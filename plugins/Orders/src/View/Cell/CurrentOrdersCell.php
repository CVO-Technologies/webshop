<?php

namespace Webshop\Orders\View\Cell;

use Cake\View\Cell;

class CurrentOrdersCell extends Cell
{

    public function panelDashboard($limit = null)
    {
        $this->loadModel('Webshop/Orders.Orders');

        $orders = $this->Orders
            ->find('current')
            ->find('customer', [
                'customerId' => $this->request->session()->read('Customer.current')
            ]);
        if (!is_null($limit)) {
            $orders->limit($limit);
        }

        $this->set('orders', $orders);
    }

}
