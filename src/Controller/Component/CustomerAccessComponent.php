<?php

namespace Webshop\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;

class CustomerAccessComponent extends Component {

	public function beforeRender(Event $event) {
        /** @var Controller $controller */
        $controller = $event->subject();

		if ($controller->request->param('prefix') === 'admin') {
			return;
		}

		$accessibleCustomers = $this->getAccessibleCustomers();

		if (($this->getCustomerId($controller, false)) && (!in_array($this->getCustomerId($controller, false), $accessibleCustomers))) {
			throw new ForbiddenException();
		}

		$Customer = TableRegistry::get('Webshop.Customers');
		if ($this->getCustomerId($controller)) {
			$controller->set('customer', $Customer->read(null, $this->getCustomerId($controller, false)));
		}

		$controller->set('customers', $Customer->find('list', array(
			'conditions' => array(
				'Customer.id' => $accessibleCustomers
			)
		)));

		if ((!isset($controller->request->params['prefix'])) || ($controller->request->params['prefix'] !== 'panel')) {
			return;
		}

		if (empty($accessibleCustomers)) {
			throw new ForbiddenException();
		}
	}

	public function getCustomerId(Controller $controller, $redirect = true) {
		$customerId = false;
		if (isset($controller->request->params['named']['customer'])) {
			$customerId = $controller->request->params['named']['customer'];
		}

		if ($controller->request->session()->check('Customer.current')) {
			$customerId = $controller->request->session()->read('Customer.current');
		}

		if (count($this->getAccessibleCustomers()) === 1) {
			$customerId = $this->getAccessibleCustomers()[0];
		}

		if (($customerId !== false) && (!in_array($customerId, $this->getAccessibleCustomers()))) {
			$controller->request->session()->delete('Customer.current');

			return $this->getCustomerId($controller, $redirect);
		}

		if (($customerId === false) && ($redirect) && (count($this->getAccessibleCustomers()) > 1)) {
			if (($controller->request['prefix'] != 'admin') && ($controller->request['action'] != 'panel_select') && (!$controller->request->is(array('ajax', 'requested'))))  {
//				debug($controller->request);exit();
//				debug($controller->request)
				if (!$this->request->session()->check('Customer.select.redirect')) {
					$this->request->session()->write('Customer.select.redirect', $controller->request->here);
				}
				$controller->redirect(array('panel' => true, 'plugin' => 'webshop', 'controller' => 'customers', 'action' => 'select'));
			}
		}

		return $customerId;
	}

	public function getAccessibleCustomers() {
		$accessibleCustomers = array();
		foreach (Configure::read('Webshop.customer_access_providers') as $alias => $options) {
			$AccessProvider = CustomerAccessProvider::get($options['provider']);

			$accessibleCustomersTemp = $AccessProvider->getAccessibleCustomers($controller);

			if (is_array($accessibleCustomersTemp)) {
				$accessibleCustomers += $accessibleCustomersTemp;
			}
		}

		return $accessibleCustomers;
	}

}
