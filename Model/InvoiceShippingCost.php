<?php

class InvoiceShippingCost extends AppModel {

	public $belongsTo = array(
		'Invoice' => array(
			'className' => 'WebshopInvoices.Invoice',
			'foreignKey' => 'invoice_id'
		),
		'Shipment' => array(
			'className' => 'WebshopShipping.Shipment',
			'foreignKey' => 'shipment_id'
		)
	);

}
