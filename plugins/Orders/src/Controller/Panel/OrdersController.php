<?php

namespace Webshop\Orders\Controller\Panel;

use Croogo\Core\Controller\CroogoAppController;

class OrdersController extends CroogoAppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
    }

    public function index()
    {
        $query = $this->Orders->find('customer', [
            'customerId' => $this->CustomerAccess->getCustomerId()
        ]);
        $orders = $this->Paginator->paginate($query);

        $this->set('orders', $orders);
    }

    public function view($id)
    {
        $order = $this->Orders->get($id, [
            'contain' => [
                'Customers',
//                'OrderShipments',
                'OrderProducts' => [
                    'Products'
                ],
                'OrderPayments'
            ]
        ]);

        $this->set('order', $order);
    }

    public function pay($id)
    {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException();
        }

        $order = $this->Order->read();

        if ($order['Order']['remaining'] <= 0) {
            $this->Session->setFlash(__d('webshop_orders', 'You\'ve already paid this order'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-info'
            ));

            $this->redirect(array(
                'action' => 'view',
                $id
            ));

            return;
        }

        $this->set(compact('order'));

        if (!$this->request->is('post')) {
            return;
        }

        $payment = $this->Order->createPayment(
            $id,
            array(
                'plugin' => 'webshop_orders',
                'controller' => 'orders',
                'action' => 'view',
                $id
            )
        );

        $this->redirect(array(
            'panel' => true,
            'plugin' => 'webshop_payments',
            'controller' => 'payments',
            'action' => 'process',
            $payment['Payment']['id']
        ));
    }

}
