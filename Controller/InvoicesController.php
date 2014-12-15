<?php

class InvoicesController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function panel_index() {
		$this->Paginator->settings = array(
			'order' => array(
				'created' => 'DESC'
			)
		);

		$invoices = $this->Paginator->paginate('Invoice', array(
			$this->Invoice->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
		));

		$this->set(compact('invoices'));
	}

	public function panel_view($id) {
		$this->Invoice->id = $id;
		$this->Invoice->recursive = 2;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException();
		}

		$invoice = $this->Invoice->read();

		$prices = $this->Invoice->getPrices();

		$this->set(compact('invoice', 'prices'));
		$this->set('_serialize', array('invoice', 'prices'));
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

}
