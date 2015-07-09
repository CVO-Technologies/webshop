<?php

App::uses('WebshopOrdersAppModel', 'WebshopOrders.Model');

class OrderShipment extends WebshopOrdersAppModel
{

    public $belongsTo = array(
        'Order' => array(
            'className' => 'WebshopOrders.Order',
            'foreignKey' => 'order_id'
        ),
        'Shipment' => array(
            'className' => 'WebshopShipping.Shipment',
            'foreignKey' => 'shipment_id'
        ),
    );

    public $hasMany = array(
        'OrderProduct' => array(
            'className' => 'WebshopOrders.OrderProduct',
            'foreignKey' => 'order_shipment_id'
        )
    );

}
