<?php

namespace Webshop\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Controller\Event\ControllerEvent;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Response;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Webshop\CustomerAccessProvider\CustomerAccessProvider;
use Webshop\Model\Entity\Customer;

class CustomerAccessComponent extends Component
{

    /**
     * Redirects when no customer has been selected
     *
     * @param Event $event Event to use
     *
     * @return Response|void
     */
    public function beforeFilter(Event $event)
    {
        /* @var Controller $controller */
        $controller = $event->subject();

        if ($controller->request->param('prefix') !== 'panel') {
            return;
        }

        $customerSelect = ($this->request->params['controller'] === 'Customers') && ($this->request->params['action'] === 'select');
        if ((!$this->getCustomerId()) && (!$customerSelect)) {
            return $controller->redirect(
                ['_name' => 'panel_customers_select']
            );
        }
    }

    public function startup(Event $event)
    {
        $controller = $event->subject();

        if ($controller->request->param('prefix') === 'admin') {
            return;
        }

        $accessibleCustomers = $this->getAccessibleCustomers();

        if (($this->getCustomerId()) && (!in_array($this->getCustomerId(), $accessibleCustomers))) {
            throw new ForbiddenException();
        }

        $Customer = TableRegistry::get('Webshop.Customers');
        if ($this->getCustomerId()) {
            $controller->set('customer', $this->getCustomer());
        }

        if (empty($accessibleCustomers)) {
            return;
        }

        $controller->set('customers', $Customer->find('list')->where([
            'Customers.id IN' => $accessibleCustomers
        ])->toArray());

        if (($this->request->param('prefix') === 'panel') && (empty($accessibleCustomers))) {
            throw new ForbiddenException();
        }
    }

    /**
     * Returns the id of the currently selected customer
     *
     * @return bool|mixed
     */
    public function getCustomerId()
    {
        $controller = $this->_registry->getController();

        $customerId = false;
        if (isset($controller->request->params['named']['customer'])) {
            $customerId = $controller->request->params['named']['customer'];
        }

        if ($controller->request->session()->check('Customer.current')) {
            $customerId = $controller->request->session()->read('Customer.current');
        }

        $accessibleCustomers = $this->getAccessibleCustomers();
        if (count($accessibleCustomers) === 1) {
            $customerId = current($accessibleCustomers);
        }

        if (($customerId !== false) && (!in_array($customerId, $accessibleCustomers))) {
            $controller->request->session()->delete('Customer.current');

            return $this->getCustomerId();
        }

        return $customerId;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        if (!$this->getCustomerId()) {
            return false;
        }

        $customers = TableRegistry::get('Webshop.Customers');

        return $customers->get($this->getCustomerId());
    }

    /**
     * Returns an array of ids of accessible customers
     *
     * @return array
     */
    public function getAccessibleCustomers()
    {
        $controller = $this->_registry->getController();

        $accessibleCustomers = [];
        foreach (Configure::read('Webshop.customer_access_providers') as $alias => $options) {
            $AccessProvider = CustomerAccessProvider::get($options['provider']);

            $accessibleCustomersTemp = $AccessProvider->getAccessibleCustomers($controller);
            if (!$accessibleCustomersTemp) {
                continue;
            }

            $accessibleCustomers += $accessibleCustomersTemp;
        }

        return $accessibleCustomers;
    }
}
