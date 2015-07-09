<?php

App::uses('WebshopOrdersAppModel', 'WebshopOrders.Model');

class OrderPayment extends WebshopOrdersAppModel
{

    public $belongsTo = array(
        'Order' => array(
            'className' => 'WebshopOrders.Order',
            'foreignKey' => 'order_id'
        ),
        'Payment' => array(
            'className' => 'WebshopPayments.Payment',
            'foreignKey' => 'payment_id'
        ),
    );

}
