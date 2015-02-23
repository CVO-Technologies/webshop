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

	public function panel_dashboard() {

	}

	public function panel_select() {
		if ($this->request->query('customer')) {
			$this->Session->write('Customer.current', $this->request->query('customer'));

			$redirectUrl = '/';
			if ($this->Session->check('Customer.select.redirect')) {
				$redirectUrl = $this->Session->read('Customer.select.redirect');
			}
			if (($redirectUrl === '/') && (Router::parse($this->referer('/', true))['action'] !== 'panel_select')) {
				$redirectUrl = $this->referer('/', true);
			}

			$this->Session->delete('Customer.select.redirect');

			$this->redirect($redirectUrl);
			return;
		}
	}

	public function panel_unselect() {
		$this->Session->delete('Customer.current');

		$this->redirect('/');
		return;
	}

	public function panel_view($id) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException();
		}

		$customer = $this->Customer->read();

		if ($this->request->is('requested')) {
			return $customer;
		}
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
