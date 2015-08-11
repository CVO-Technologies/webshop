<?php

namespace Webshop\Controller\Panel;

use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Croogo\Core\Controller\CroogoAppController;

class CustomersController extends CroogoAppController
{

    public $helpers = [
        'SocialSeo.Title'
    ];

    /**
     * Shows the customer dashboard
     *
     * @return null
     */
    public function dashboard()
    {
        return null;
    }

    /**
     * Used to select a customer
     *
     * @return void
     */
    public function select()
    {
        if ($this->request->query('customer')) {
            $this->request->session()->write('Customer.current', $this->request->query('customer'));

            $redirectUrl = '/';
            if ($this->request->session()->check('Customer.select.redirect')) {
                $redirectUrl = $this->request->session()->read('Customer.select.redirect');
            }
            if (($redirectUrl === '/') && (Router::parse($this->referer('/', true))['action'] !== 'select')) {
                $redirectUrl = $this->referer('/', true);
            }

            $this->request->session()->delete('Customer.select.redirect');

            $this->redirect($redirectUrl);
            return;
        }
    }

    /**
     * Used to unselect a customer
     *
     * @return void
     */
    public function unselect()
    {
        $this->request->session()->delete('Customer.current');

        $this->redirect('/');
    }

    /**
     * Used to view a customer
     *
     * @param int $id ID of the customer to view
     * @return mixed
     *
     * @throws NotFoundException
     */
    public function view($id)
    {
        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException();
        }

        $customer = $this->Customer->read();

        if ($this->request->is('requested')) {
            return $customer;
        }
    }
}
