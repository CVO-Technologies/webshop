<?php

namespace Webshop\Orders\Model\Table;

use Cake\ORM\Table;

class OrderItemsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Webshop.Status');

        $this->belongsTo('Orders', [
            'className' => 'WebshopOrders.Orders',
            'foreignKey' => 'order_id'
        ]);
        $this->belongsTo('Products', [
            'className' => 'Webshop.Products',
            'foreignKey' => 'product_id'
        ]);
        $this->belongsTo('OrderShipments', [
            'className' => 'WebshopOrders.OrderShipments',
            'foreignKey' => 'order_shipment_id'
        ]);

        $this->hasMany('OrderProductOption', [
            'className' => 'WebshopOrders.OrderProductOptions'
        ]);
    }

}
