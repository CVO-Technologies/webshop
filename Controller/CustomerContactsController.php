<?php

class CustomerContactsController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function panel_index() {
		$customer_contacts = $this->Paginator->paginate('CustomerContact', array(
			$this->CustomerContact->alias . '.customer_id' => $this->request->params['named']['customer']
		));

		$this->set(compact('customer_contacts'));
	}

	public function panel_view($id) {
		$this->CustomerContact->id = $id;
		if (!$this->CustomerContact->read()) {
			throw new NotFoundException();
		}

		$customer_contact = $this->CustomerContact->read();

		$this->set(compact('customer_contact'));
	}

	public function panel_edit($id) {
		$this->CustomerContact->id = $id;
		if (!$this->CustomerContact->read()) {
			throw new NotFoundException();
		}

		$this->request->data = $this->CustomerContact->read();
	}

}
