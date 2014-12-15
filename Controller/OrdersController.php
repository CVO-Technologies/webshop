<?php

class OrdersController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function admin_index() {
		$this->Paginator->settings = array(
			'Order' => array(
				'order' => array(
					'Order.modified' => 'DESC'
				)
			)
		);
		$orders = $this->Paginator->paginate('Order');

		if ($this->request->is('requested')) {
			return $orders;
		}

		$this->set(compact('orders'));
	}

	public function admin_view($id) {
		$this->Order->id = $id;
		$this->Order->recursive = 3;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$order = $this->Order->read();

		$this->set(compact('order'));
	}

	public function admin_mark_done($id) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$this->Order->changeStatus('done', $id);

		$this->redirect(array(
			'action' => 'index'
		));
	}

	public function admin_cancel($id) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$this->Order->changeStatus('cancelled', $id);

		$this->redirect(array(
			'action' => 'index'
		));
	}

	public function panel_index() {
		$orders = $this->Order->find('all', array(
			'conditions' => array(
//				$this->Order->alias . '.customer_id' => $this->CustomerAccess->getAccessibleCustomers()
				$this->Order->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
			)
		));

		$this->set(compact('orders'));
	}

	public function panel_view($id) {
		$this->Order->id = $id;
		$this->Order->recursive = 3;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$order = $this->Order->read();

		$this->set(compact('order'));
	}

	public function panel_pay($id) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$order = $this->Order->read();

		$this->set(compact('order'));

		if (!$this->request->is('post')) {
			return;
		}

		$payment = $this->Order->createPayment(
			$id,
			array(
				'plugin' => 'webshop_orders',
				'controller' => 'orders',
				'action' => 'view',
				$id
			)
		);

		$this->redirect(array(
			'panel' => true,
			'plugin' => 'webshop_payments',
			'controller' => 'payments',
			'action' => 'process',
			$payment['Payment']['id']
		));
	}

}