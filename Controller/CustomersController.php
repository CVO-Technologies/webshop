<?php

class CustomersController extends AppController {

	public function add() {
		debug($this->request->data);
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

}