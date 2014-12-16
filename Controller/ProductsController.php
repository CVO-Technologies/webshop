<?php

class ProductsController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function view($id) {
		$this->Product->id = $id;
		$this->Product->recursive = 2;

		$product = $this->Product->read();
		if ($this->request->is('requested')) {
			return $product;
		}

		$this->set(compact('product'));
	}


	public function lookup() {
		$type = ($this->request->query('type')) ? $this->request->query('type') : 'EAN-13';
		$code = $this->request->query('code');

		$column = false;
		switch ($type) {
			case 'EAN-13':
				$column = 'ean';
				break;
		}

		if (!$column) {
			throw new BadRequestException();
		}

//		debug($this->Product->find('all'));

		$product = $this->Product->find('first', array(
			'conditions' => array(
				$this->Product->alias . '.' . $column => $code
			)
		));

		$this->set(compact('product'));
		$this->set('_serialize', array('product'));
	}

	public function admin_index() {
		$products = $this->Paginator->paginate('Product');

		$this->set(compact('products'));
	}

	public function admin_edit($id) {
		$this->Product->id = $id;
		$this->Product->recursive = 2;

		$this->request->data = $this->Product->read();

		if (!$this->request->is('put')) {
			return;
		}

//		debug($this->request->data?);

		$success = $this->Product->save($this->request->data);
		debug($this->Product->validationErrors);
		debug($success);
//		$log = $this->Product->getDataSource()->getLog(false, false);
//		debug($log);
		debug($this->Product->invalidFields());
		if ($success) {
			$this->redirect(array('action' => 'index'));
			return;
		}
	}

}
