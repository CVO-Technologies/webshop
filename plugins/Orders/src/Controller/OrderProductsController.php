<?php

class OrderProductsController extends AppController {

	public function admin_assign_shipment($orderId, $orderShipmentId) {
		$orderProducts = $this->OrderProduct->find('all', array(
			'conditions' => array(
				$this->OrderProduct->alias . '.order_id' => $orderId
			),
			'recursive' => 2
		));
		$this->OrderProduct->OrderShipment->id = $orderShipmentId;
		$this->OrderProduct->OrderShipment->recursive = 2;
		$orderShipment = $this->OrderProduct->OrderShipment->read();

		$this->OrderProduct->Order->id = $orderId;
		$order = $this->OrderProduct->Order->read();

		$this->set(compact('orderProducts', 'orderShipment', 'order'));

		if (!$this->request->is('post')) {
			return;
		}

		foreach ($this->request->data['OrderProduct'] as $orderProductId => $assign) {
			if (!(bool) $assign) {
				continue;
			}

			$this->OrderProduct->id = $orderProductId;
			$this->OrderProduct->saveField('order_shipment_id', $orderShipmentId);;
		}

		$this->redirect(array(
			'controller' => 'orders',
			'action' => 'view',
			$orderId
		));
	}

}
