<?php

namespace Webshop\Invoices\Controller\Admin;

use Cake\Event\Event;
use Cake\ORM\Query;
use Webshop\Invoices\Controller\AppController;

class InvoicesController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginateAndFine',
            'Crud.beforeFind' => 'beforePaginateAndFine',
        ];
    }

    public function beforePaginateAndFine(Event $event)
    {
        /* @var Query $query */
        $query = $event->subject()->query;

        $query->contain([
            'Customers',
            'AddressDetails',
            'Lines',
        ]);
    }
}
