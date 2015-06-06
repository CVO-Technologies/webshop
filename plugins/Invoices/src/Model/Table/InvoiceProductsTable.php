<?php

class InvoiceProduct extends AppModel {

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
			'className' => 'WebshopTaxes.TaxRevision',
			'tax_revision_id'
		)
	);

}
