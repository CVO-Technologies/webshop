<?php

App::uses('WebshopOrdersAppModel', 'WebshopOrders.Model');

class OrderProduct extends WebshopOrdersAppModel
{

    public $actsAs = array(
        'Webshop.Status'
    );

    public $belongsTo = array(
        'Order' => array(
            'className' => 'WebshopOrders.Order',
            'foreignKey' => 'order_id'
        ),
        'Product' => array(
            'className' => 'Webshop.Product',
            'foreignKey' => 'product_id'
        ),
        'OrderShipment' => array(
            'className' => 'WebshopOrders.OrderShipment',
            'foreignKey' => 'order_shipment_id'
        ),
    );

    public $hasMany = array(
        'OrderProductOption' => array(
            'className' => 'WebshopOrders.OrderProductOption'
        )
    );

    /*public function changeStatus($id, $status) {
        $this->id = $id;

        $this->saveField('status', $status);

        $orderProduct = $this->read();

        $this->Order->id = $orderProduct[$this->alias]['order_id'];
        $this->Order->recursive = 2;
        $order = $this->Order->read();

        CakeLog::write(
            LOG_INFO,
            __d(
                'webshop_orders',
                'Changed status of OrderProduct with id %1$d belonging to order #%2$d to %3$s',
                $orderProduct[$this->alias]['id'],
                $order['Order']['number'],
                $status
            ),
            array('orders', 'webshop')
        );

        switch ($status) {
            case 'paid':
                $eventData = array();
                $eventData['product']['amount'] = $orderProduct[$this->alias]['amount'];
                $eventData['product']['id'] = $orderProduct[$this->alias]['product_id'];
                $eventData['order']['id'] = $order['Order']['id'];
                $eventData['order']['product_id'] = $orderProduct[$this->alias]['id'];
                $eventData['customer']['id'] = $order['Customer']['id'];
                $productBoughtEvent = new CakeEvent('Product.gotBought', $this, $eventData);

                CakeEventManager::instance()->dispatch($productBoughtEvent);
                break;
        }

        switch ($status) {
            case 'delivered':
                $allDelivered = true;
                foreach ($order['OrderProduct'] as $orderProduct) {
                    if ($orderProduct['status'] !== 'delivered') {
                        $allDelivered = false;
                    }
                }

                if ($allDelivered) {
                    $this->Order->updateStatus($orderProduct['order_id'], 'delivered');
                }

        }
    }*/

}
