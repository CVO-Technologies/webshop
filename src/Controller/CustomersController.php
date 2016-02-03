<?php

namespace Webshop\Controller;

use Croogo\Core\Controller\AppController as CroogoAppController;

class CustomersController extends CroogoAppController
{

    public $components = [
        'Paginator'
    ];

    /**
     * Does nothing at the moment
     *
     * @return void
     */
    public function add()
    {
        debug($this->request->data);
    }

    /**
     * Returns the amount of available customers
     *
     * @return int
     */
    public function count()
    {
        return $this->Customer->find('count');
    }

    /**
     * @return array
     *
     * @deprecated
     */
    public function adminIndex()
    {
        $customers = $this->Paginator->paginate('Customer');

        if ($this->request->is('requested')) {
            return $customers;
        }

        $this->set(compact('customers'));
    }

    /**
     * @return array
     *
     * @deprecated
     */
    public function adminListing()
    {
        $this->Paginator->settings['Customer']['type'] = 'list';
        $customers = $this->Paginator->paginate('Customer');

        if ($this->request->is('requested')) {
            return $customers;
        }

        $this->set(compact('customers'));
    }

    /**
     * @param int $id ID of customer to view
     *
     * @return void
     *
     * @deprecated
     */
    public function adminView($id)
    {
        $this->Customer->id = $id;
        $customer = $this->Customer->read();

        $this->set(compact('customer'));
    }

    public function adminEdit($id)
    {
        $this->Customer->id = $id;
        $customer = $this->Customer->read();

        if (empty($this->request->data)) {
            $this->request->data = $customer;
        }

        $this->set(compact('customer'));
    }

    public function admin_set_invoice_address_detail($id, $addressDetailId)
    {
        debug($id);
    }

}
