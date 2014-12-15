<?php

class OrderShipmentsController extends AppController {

	public function admin_ship($id) {
		$this->OrderShipment->id = $id;
		$this->OrderShipment->recursive = 3;
		if (!$this->OrderShipment->exists()) {
			throw new NotFoundException();
		}

		$orderShipment = $this->OrderShipment->read();
		if (!$this->request->is('post')) {
			return;
		}

		$this->OrderShipment->Shipment->id = $orderShipment['Shipment']['id'];
		$this->OrderShipment->Shipment->saveField('weight', $this->request->data['Shipment']['weight']);

		$this->redirect(array(
			'plugin' => 'webshop_shipping',
			'controller' => 'shipments',
			'action' => 'ship',
			$orderShipment['Shipment']['id']
		));
	}

}
