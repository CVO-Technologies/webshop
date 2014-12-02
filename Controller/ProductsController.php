<?php

class ProductsController extends AppController {

	public $components = array(
		'Paginator'
	);

	public $scaffold;

	public function view($id) {
		$this->Product->id = $id;

		return $this->Product->read();
	}

	public function admin_index() {
		$products = $this->Paginator->paginate('Product');

		$this->set(compact('products'));
	}

	public function admin_edit($id) {
		$this->Product->id = $id;

		$this->request->data = $this->Product->read();
	}

}
