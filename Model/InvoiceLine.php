<?php

class InvoiceLine extends AppModel {

	public $belongsTo = array(
		'Invoice' => array(
			'className' => 'WebshopInvoices.Invoice',
			'foreignKey' => 'invoice_id'
		),
		'Product' => array(
			'className' => 'Webshop.Product',
			'foreignKey' => 'product_id'
		),
		'TaxRevision' => array(
			'className' => 'Webshop.TaxRevision',
			'foreignKey' => 'tax_revision_id'
		)
	);

}
