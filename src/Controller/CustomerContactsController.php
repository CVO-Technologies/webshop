<?php

class CustomerContactsController extends AppController
{

    public $components = array(
        'Paginator',
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring',
            ),
            'commonProcess' => array(
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ),
        )
    );

    public function panel_index()
    {
        $this->Prg->commonProcess();

        $conditions = $this->CustomerContact->parseCriteria($this->Prg->parsedParams());
        $conditions['CustomerContact.customer_id'] = $this->CustomerAccess->getCustomerId();

        $customerContacts = $this->Paginator->paginate('CustomerContact', $conditions);

        if ($this->request->is('requested')) {
            return $customerContacts;
        }

        $this->set(compact('customerContacts'));
    }

    public function panel_view($id)
    {
        $this->CustomerContact->id = $id;
        if (!$this->CustomerContact->read()) {
            throw new NotFoundException();
        }

        $customer_contact = $this->CustomerContact->read();

        $this->set(compact('customer_contact'));
    }

    public function panel_edit($id)
    {
        $this->CustomerContact->id = $id;
        if (!$this->CustomerContact->read()) {
            throw new NotFoundException();
        }

        $this->request->data = $this->CustomerContact->read();
    }

    public function admin_index()
    {
        $this->Prg->commonProcess();

        $customerContacts = $this->Paginator->paginate('CustomerContact', $this->CustomerContact->parseCriteria($this->Prg->parsedParams()));

        if ($this->request->is('requested')) {
            return $customerContacts;
        }

        $this->set(compact('customerContacts'));
    }

    public function admin_listing()
    {
        $this->Prg->commonProcess();

        $this->Paginator->settings['CustomerContact']['type'] = 'list';
        $customerContacts = $this->Paginator->paginate('CustomerContact', $this->CustomerContact->parseCriteria($this->Prg->parsedParams()));

        if ($this->request->is('requested')) {
            return $customerContacts;
        }

        $this->set(compact('customerContacts'));
    }

}
