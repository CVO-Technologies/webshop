<?php

namespace Webshop\Controller\Admin;

// @codingStandardsIgnoreStart

use Cake\Event\Event;
use Cake\ORM\Query;
use Webshop\Controller\AppController;

class CustomersController extends AppController
{

    public function admin_set_invoice_address_detail($id, $addressDetailId)
    {
        debug($id);
    }

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeFind' => 'beforeFind'
        ];
    }

    public function beforeFind(Event $event)
    {
        /* @var Query $query */
        $query = $event->subject()->query;

        $query->contain([
            'FinancialContacts',
            'InvoiceAddressDetails',
            'CustomerContacts',
            'AddressDetails'
        ]);
    }
}
