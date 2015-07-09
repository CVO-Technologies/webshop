<?php

App::uses('CakeEventListener', 'Event');

/**
 * Class OrdersHandler
 *
 * @property OrderShipment OrderShipment
 */
class OrdersHandler implements CakeEventListener
{

    function __construct()
    {
        $this->OrderPayment = ClassRegistry::init('WebshopOrders.OrderPayment');
        $this->OrderShipment = ClassRegistry::init('WebshopOrders.OrderShipment');
        $this->OrderProduct = ClassRegistry::init('WebshopOrders.OrderProduct');
        $this->Order = ClassRegistry::init('WebshopOrders.Order');
    }


    public function implementedEvents()
    {
        return array(
            'Payment.statusChanged' => 'onPaymentUpdate',
            'Shipment.statusChanged' => 'onShipmentUpdate',
            'Order.statusChanged' => 'onOrderStatusChange',
            'OrderProduct.statusChangedToPaid' => 'onOrderProductPaid',
            'OrderProduct.statusChangedToDelivered' => 'onOrderProductDelivered',
        );
    }

    public function onPaymentUpdate($event)
    {
        if ($event->data['payment']['status'] !== 'paid') {
            return;
        }

        $order_payment = $this->OrderPayment->find('first', array(
            'conditions' => array(
                $this->OrderPayment->alias . '.payment_id' => $event->data['payment']['id']
            ),
            'recursive' => 2
        ));

        $this->OrderPayment->Order->id = $order_payment['Order']['id'];
        $this->OrderPayment->Order->saveField('remaining', $order_payment['Order']['remaining'] - $order_payment['Payment']['amount']);
        CakeLog::write(
            LOG_DEBUG,
            __d(
                'webshop_orders',
                'Order with id %1$d has gotten a payment. Outstanding amount: %2$d',
                $order_payment['Order']['id'],
                (float)$order_payment['Order']['remaining'] - (float)$order_payment['Payment']['amount']
            ),
            array('orders', 'webshop')
        );
        if ($order_payment['Order']['amount'] - $order_payment['Payment']['amount'] <= 0) {
            CakeLog::write(
                LOG_INFO,
                __d(
                    'webshop_orders',
                    'Order with id %1$d has been paid entirely. Marking as paid',
                    $order_payment['Order']['id']
                ),
                array('orders', 'webshop')
            );

            $this->OrderPayment->Order->changeStatus('paid', $this->OrderPayment->Order->id);

            $order = $this->OrderPayment->Order->read();

            foreach ($order['OrderProduct'] as $orderProduct) {
                $this->OrderProduct->changeStatus('paid', $orderProduct['id']);
            }
        }
    }

    public function onShipmentUpdate($event)
    {
        $orderShipmentList = $this->OrderShipment->find('list', array(
            'conditions' => array(
                $this->OrderShipment->alias . '.shipment_id' => $event->data['shipment']['id']
            )
        ));

        if (count($orderShipmentList) > 1) {
            CakeLog::write(
                LOG_WARNING,
                __d(
                    'webshop_orders',
                    'Shipment with id %1$d belongs to multiple (%2$d) shipment orders! The following to be precise: %3$s',
                    $event->data['shipment']['id'],
                    count($orderShipmentList),
                    implode(', ', $orderShipmentList)
                ),
                array('orders', 'webshop')
            );
        }

        $order_shipment = $this->OrderShipment->find('first', array(
            'conditions' => array(
                $this->OrderShipment->alias . '.shipment_id' => $event->data['shipment']['id']
            ),
            'recursive' => 2
        ));

        if (($event->data['shipment']['status'] === 'sent') || ($event->data['shipment']['status'] === 'arrived')) {
            CakeLog::write(
                LOG_DEBUG,
                __d(
                    'webshop_orders',
                    'Order shipment status changed to %1$s for order #%2$d',
                    $event->data['shipment']['status'],
                    $order_shipment['Order']['number']
                ),
                array('orders', 'webshop')
            );

            foreach ($order_shipment['OrderProduct'] as $orderProduct) {
                $this->OrderProduct->changeStatus($event->data['shipment']['status'], $orderProduct['id']);
            }

            $amountUndelivered = $this->OrderShipment->find('count', array(
                'conditions' => array(
                    $this->OrderShipment->Shipment->alias . '.status !=' => array($event->data['shipment']['status'], 'cancelled'),
                    $this->OrderShipment->alias . '.order_id' => $order_shipment['Order']['id']
                )
            ));
            debug($amountUndelivered);

            $this->OrderShipment->Order->id = $order_shipment['Order']['id'];
            if ($amountUndelivered === 0) {
                $this->OrderShipment->Order->changeStatus($event->data['shipment']['status'], $this->OrderShipment->Order->id);
            }
        }
    }

    public function onOrderStatusChange($event)
    {
        $this->Order->id = $event->data['order']['id'];
        $order = $this->Order->read();

        $this->Order->Customer->id = $order['Order']['customer_id'];
        $this->Order->Customer->recursive = 2;

        $customer = $this->Order->Customer->read();

        CakeLog::write(
            LOG_INFO,
            __d(
                'webshop_orders',
                'Sending email about order status change to %1$s to contacts of customer %2$s',
                $order['Order']['status'],
                $customer['Customer']['name']
            ),
            array('orders', 'webshop')
        );

        foreach ($customer['CustomerContact'] as $contact) {
            $Email = new CakeEmail();
            $Email->template('WebshopOrders.order_status_update', 'default')
                ->emailFormat('html')
                ->to($contact['email'])
                ->from(Configure::read('Site.email'))
                ->subject(__d('webshop_orders', 'Status update for order #%1$d', $order['Order']['number']))
                ->viewVars(compact('order', 'customer', 'contact'))
                ->send();
        }
    }

    public function onOrderProductPaid($event)
    {
        $this->OrderProduct->id = $event->data['order_product']['id'];
        $this->OrderProduct->recursive = 2;
        $orderProduct = $this->OrderProduct->read();

        $configuration = array();
        foreach ($orderProduct['OrderProductOption'] as $orderProductOption) {
            $configuration[$orderProductOption['ConfigurationOption']['alias']] = array(
                'group_id' => $orderProductOption['ConfigurationOption']['configuration_group_id'],
                'item_id' => $orderProductOption['configuration_option_item_id'],
                'value' => $orderProductOption['value']
            );
        }

        $eventData = array();
        $eventData['product']['amount'] = $orderProduct[$this->OrderProduct->alias]['amount'];
        $eventData['product']['configuration'] = $configuration;
        $eventData['product']['id'] = $orderProduct[$this->OrderProduct->alias]['product_id'];
        $eventData['order']['id'] = $orderProduct['Order']['id'];
        $eventData['order']['product_id'] = $orderProduct[$this->OrderProduct->alias]['id'];
        $eventData['customer']['id'] = $orderProduct['Order']['Customer']['id'];
        $productBoughtEvent = new CakeEvent('Product.gotBought', $this, $eventData);

        CakeEventManager::instance()->dispatch($productBoughtEvent);
    }

    public function onOrderProductDelivered($event)
    {
        $this->OrderProduct->id = $event->data['order_product']['id'];
        $this->OrderProduct->recursive = 2;
        $orderProduct = $this->OrderProduct->read();

        $this->Order->id = $orderProduct['Order']['id'];
        $this->Order->recursive = 2;
        $order = $this->Order->read();

        $allDelivered = true;
        foreach ($order['OrderProduct'] as $orderProduct) {
            if ($orderProduct['status'] !== 'delivered') {
                $allDelivered = false;
            }
        }

        if ($allDelivered) {
            $this->Order->changeStatus('delivered', $orderProduct['order_id']);
        }
    }

}
