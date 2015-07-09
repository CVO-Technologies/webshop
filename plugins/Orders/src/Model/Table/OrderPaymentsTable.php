<?php

namespace Webshop\Orders\Model\Table;

use Cake\ORM\Table;

class OrderPayment extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Orders', [
            'className' => 'WebshopOrders.Orders',
            'foreignKey' => 'order_id'
        ]);
        $this->belongsTo('Payments', [
            'className' => 'WebshopPayments.Payments',
            'foreignKey' => 'payment_id'
        ]);
    }

}
