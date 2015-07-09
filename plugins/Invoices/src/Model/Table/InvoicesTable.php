<?php

namespace Webshop\Invoices\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class InvoicesTable extends Table {

	public $actsAs = array(
		'Webshop.Counter' => array(
			'fields' => array(
				'number' => array(
					'count' => true
				)
			)
		),
		'Webshop.Status',
		'Search.Searchable',
	);

	public $filterArgs = array(
		'status' => array('type' => 'value'),
		'customer_id' => array('type' => 'value'),
	);

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Webshop.CustomerOwned');
//        $this->addBehavior('Webshop.Counter', [
//            'fields' => [
//                'number' => [
//                    'count' => true
//                ]
//            ]
//        ]);
        $this->addBehavior('Webshop.Status');
        $this->belongsTo('Customers', [
            'className' => 'Webshop.Customers'
        ]);
        $this->belongsTo('AddressDetails', [
            'className' => 'Webshop.AddressDetails'
        ]);
        $this->hasMany('InvoiceProducts', [
            'className' => 'Webshop/Invoices.InvoiceProducts'
        ]);
        $this->hasMany('InvoiceLines', [
            'className' => 'Webshop/Invoices.InvoiceLines'
        ]);
        $this->hasMany('InvoiceShippingCosts', [
            'className' => 'Webshop/Invoices.InvoiceShippingCosts'
        ]);
        $this->hasMany('InvoiceTransactionCosts', [
            'className' => 'Webshop/Invoices.InvoiceTransactionCosts'
        ]);
    }

    public function findOutstanding(Query $query)
    {
        return $query->andWhere([
            'status' => 'open'
        ]);
    }

    public function afterFind($results, $primary = false) {
		if ($primary) {
			foreach ($results as &$result) {
				$subTotal = 0;
				$total = 0;

				$taxes = array();

				if (!isset($result['InvoiceLine'])) {
					continue;
				}

				foreach ($result['InvoiceLine'] as $invoiceLine) {
					if (!isset($invoiceLine['TaxRevision'])) {
						continue;
					}

					if (isset($invoiceLine['TaxRevision']['tax_id'])) {
						if (!isset($taxes[$invoiceLine['TaxRevision']['tax_id']])) {
							$taxes[$invoiceLine['TaxRevision']['tax_id']] = array(
								'tax_id' => (int)$invoiceLine['TaxRevision']['tax_id'],
								'percentage' => (float )$invoiceLine['TaxRevision']['percentage'],
								'amount' => (float)$invoiceLine['price'] / 100 * $invoiceLine['TaxRevision']['percentage']
							);
						} else {
							$taxes[$invoiceLine['TaxRevision']['tax_id']]['amount'] += $invoiceLine['price'] / 100 * $taxes[$invoiceLine['TaxRevision']['tax_id']]['percentage'];
						}
					}

					$subTotal += $invoiceLine['price'];
				}

				if (isset($result['InvoiceTransactionCost'])) {
					$transactionCosts = $result['InvoiceTransactionCost'];
					foreach ($transactionCosts as $transactionCost) {
						$subTotal += $transactionCost['amount'];
					}
				} else {
					$transactionCosts = array();
				}

				if (isset($result['InvoiceShippingCost'])) {
					$shippingCosts = $result['InvoiceShippingCost'];
					foreach ($shippingCosts as $shippingCost) {
						$subTotal += $shippingCost['amount'];
					}
				} else {
					$shippingCosts = array();
				}

				$total += $subTotal;
				foreach ($taxes as $tax) {
					$total += $tax['amount'];
				}

				$result[$this->alias]['prices'] = compact('transactionCosts', 'shippingCosts', 'taxes', 'subTotal', 'total');
			}
		}

		return $results;
	}


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
