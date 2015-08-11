<?php

namespace Webshop\Invoices\View\Cell;

use Cake\View\Cell;
use Webshop\Invoices\Model\Table\InvoicesTable;

/**
 * @property InvoicesTable Invoices
 */
class OutstandingInvoicesCell extends Cell
{

    public function panelDashboard($limit = null)
    {
        $this->loadModel('Webshop/Invoices.Invoices');

        $invoices = $this->Invoices
            ->find('outstanding')
            ->find('customer', [
                'customerId' => $this->request->session()->read('Customer.current')
            ]);
        if (!is_null($limit)) {
            $invoices->limit($limit);
        }

        $this->set('invoices', $invoices);
    }

}
