<?php

class InvoicesController extends AppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'Invoice' => array(
					'contain' => array(
						'Customer',
						'AddressDetail',
						'InvoiceLine' => array(
							'TaxRevision'
						)
					),
					'order' => array(
						'created' => 'DESC'
					)
				)
			)
		),
		'Search.Prg' => array(
			'presetForm' => array(
				'paramType' => 'querystring',
			),
			'commonProcess' => array(
				'paramType' => 'querystring',
				'filterEmpty' => true,
			),
		),
	);

	public function panel_index() {
		$invoices = $this->Paginator->paginate('Invoice', array(
			$this->Invoice->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
		));

		$this->set(compact('invoices'));
	}

	public function panel_view($id) {
		$invoice = $this->Invoice->find('first', array(
			'conditions' => array(
				'Invoice.id' => $id,
				'Invoice.customer_id' => $this->CustomerAccess->getCustomerId()
			),
			'contain' => array(
				'Customer',
				'AddressDetail',
				'InvoiceLine' => array(
					'TaxRevision'
				)
			)
		));
		if (!$invoice) {
			throw new NotFoundException();
		}

		$this->set(compact('invoice'));
		$this->set('_serialize', array('invoice'));
	}

	public function get_prices($id) {
		return $this->Invoice->getPrices($id);
	}

	public function panel_count() {
		$total = $this->Invoice->find('count', array(
			'conditions' => array(
				$this->Invoice->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
			)
		));

		if ($this->request->is('requested')) {
			return compact('total');
		}
	}

	public function admin_index() {
		$this->Prg->commonProcess();

		$conditions = $this->Invoice->parseCriteria($this->Prg->parsedParams());

		$invoices = $this->Paginator->paginate('Invoice', $conditions);

		if ($this->request->is('requested')) {
			return $invoices;
		}

		$this->set(compact('invoices'));
	}

	public function admin_view($id) {
		$invoice = $this->Invoice->find('first', array(
			'conditions' => array(
				'Invoice.id' => $id
			),
			'contain' => array(
				'Customer',
				'AddressDetail',
				'InvoiceLine' => array(
					'TaxRevision' => array(
						'Tax'
					)
				)
			)
		));

		$this->set(compact('invoice'));
	}

}
