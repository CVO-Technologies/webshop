<?php

class InvoiceTemplateBehavior extends ModelBehavior {

	public function __construct() {
		parent::__construct();

		$this->Invoice = ClassRegistry::init('WebshopInvoices.Invoice');
	}

	public function createInvoice(Model $Model, $type = 'proforma', $id = null) {
		if ($id === null) {
			$id = $Model->getID();
		}

		if ($id === false) {
			return false;
		}

		$Model->id = $id;
		$Model->recursive = 2;
		$order = $Model->read();

		$invoice = array(
			$this->Invoice->alias => array(
				'type' => $type,
				'status' => 'open',
				'customer_id' => $order[$Model->alias]['customer_id']
			)
		);

		foreach ($order['OrderProduct'] as $orderProduct) {
			$invoice[$this->Invoice->InvoiceProduct->alias][] = array(
				'amount' => $orderProduct['amount'],
				'price'  => $orderProduct['price'],
				'product_id' => $orderProduct['product_id'],
				'tax_revision_id' => $orderProduct['tax_revision_id'],
			);
		}

		foreach ($order['OrderShipment'] as $orderShipment) {
			$invoice[$this->Invoice->InvoiceShippingCost->alias][] = array(
				'amount' => 15,
				'shipment_id' => $orderShipment['shipment_id']
			);
		}

		foreach ($order['OrderPayment'] as $orderPayment) {
			$invoice[$this->Invoice->InvoiceTransactionCost->alias][] = array(
				'amount' => 15,
				'payment_id' => $orderPayment['payment_id']
			);
		}

		$status = $this->Invoice->saveAssociated($invoice, array(
			'deep' => true
		));
		if (!$status) {
			return false;
		}

		return $this->Invoice->read();
	}

}
