<?php

namespace Webshop\Invoices\View\Cell;

use Cake\View\Cell;

class InvoicesCell extends Cell
{

    public function lastCustomerInvoices($customerId, $limit = 10)
    {
        $this->loadModel('Webshop.Customers');
        $this->loadModel('Webshop/Invoices.Invoices');

        $customer = $this->Customers->get($customerId);

        $invoices = $this->Invoices
            ->find('ownedByCustomer', ['customer' => $customer])
            ->limit($limit);

        $this->set([
            'invoices' => $invoices
        ]);
    }
}
