<?php

class Invoice extends AppModel {

	public $actsAs = array(
		'Webshop.Counter' => array(
			'fields' => array(
				'number' => array(
					'count' => true
				)
			)
		),
		'Webshop.Status'
	);

	public $belongsTo = array(
		'Customer' => array(
			'className'  => 'Webshop.Customer',
			'foreignKey' => 'customer_id'
		)
	);

	public $hasMany = array(
		'InvoiceProduct' => array(
			'className'  => 'WebshopInvoices.InvoiceProduct',
			'foreignKey' => 'invoice_id'
		),
		'InvoiceShippingCost' => array(
			'className'  => 'WebshopInvoices.InvoiceShippingCost',
			'foreignKey' => 'invoice_id'
		),
		'InvoiceTransactionCost' => array(
			'className'  => 'WebshopInvoices.InvoiceTransactionCost',
			'foreignKey' => 'invoice_id'
		)
	);

	public function getPrices($id = null) {
		if ($id === null) {
			$id = $this->getID();
		}

		if ($id === false) {
			return false;
		}

		$this->id = $id;

		$this->recursive = 2;
		$invoice = $this->read();

		$subTotal = 0;
		$total = 0;

		$taxes = array();

		foreach ($invoice['InvoiceProduct'] as $invoiceProduct) {
			if (!isset($taxes[$invoiceProduct['TaxRevision']['tax_id']])) {
				$taxes[$invoiceProduct['TaxRevision']['tax_id']] = array(
					'tax_id'     => (int) $invoiceProduct['TaxRevision']['tax_id'],
					'percentage' => (float )$invoiceProduct['TaxRevision']['percentage'],
					'amount'     => (float) ($invoiceProduct['amount'] * $invoiceProduct['price']) / 100 * $invoiceProduct['TaxRevision']['percentage']
				);
			} else {
				$taxes[$invoiceProduct['TaxRevision']['tax_id']]['amount'] += ($invoiceProduct['amount'] * $invoiceProduct['price']) / 100 * $taxes[$invoiceProduct['TaxRevision']['tax_id']]['percentage'];
			}
			$subTotal += $invoiceProduct['amount'] * $invoiceProduct['price'];
		}

		$transactionCosts = $invoice['InvoiceTransactionCost'];
		foreach ($transactionCosts as $transactionCost) {
			$subTotal += $transactionCost['amount'];
		}
		$shippingCosts =  $invoice['InvoiceShippingCost'];
		foreach ($shippingCosts as $shippingCost) {
			$subTotal += $shippingCost['amount'];
		}

		$total += $subTotal;
		foreach ($taxes as $tax) {
			$total += $tax['amount'];
		}

		return compact('transactionCosts', 'shippingCosts', 'taxes', 'subTotal', 'total');
	}

}
