<?php

class CustomersController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function add() {
		debug($this->request->data);
	}

	public function count() {
		return $this->Customer->find('count');
	}

	public function admin_index() {
		$customers = $this->Paginator->paginate('Customer');

		if ($this->request->is('requested')) {
			return $customers;
		}

		$this->set(compact('customers'));
	}

	public function admin_listing() {
		$this->Paginator->settings['Customer']['type'] = 'list';
		$customers = $this->Paginator->paginate('Customer');

		if ($this->request->is('requested')) {
			return $customers;
		}

		$this->set(compact('customers'));
	}

	public function admin_view($id) {
		$this->Customer->id = $id;
		$customer = $this->Customer->read();

		$this->set(compact('customer'));
	}

	public function admin_edit($id) {
		$this->Customer->id = $id;
		$customer = $this->Customer->read();

		if (empty($this->request->data)) {
			$this->request->data = $customer;
		}

		$this->set(compact('customer'));
	}

	public function admin_set_invoice_address_detail($id, $addressDetailId) {
		debug($id);
	}

}
