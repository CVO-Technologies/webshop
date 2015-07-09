<?php

namespace Webshop\Orders\Controller\Admin;

use Croogo\Core\Controller\CroogoAppController;

/**
 * Class OrdersController
 *
 * @property Order Order
 */
class OrdersController extends CroogoAppController {

	public $components = array(
		'Paginator' => array(
			'settings' => array(
				'order' => array(
					'Order.modified' => 'DESC'
				)
			)
		),
		'Croogo.BulkProcess',
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

	public $presetVars = true;

	public function admin_index() {
		$this->Prg->commonProcess();

		$conditions = $this->Order->parseCriteria($this->Prg->parsedParams());
		if (!isset($conditions['Order.status'])) {
			$conditions['Order.status !='] = array(
				'cancelled',
				'done'
			);
		}

		$orders = $this->Paginator->paginate('Order', $conditions);

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

	public function admin_edit($id) {
		$this->Order->id = $id;
		$this->Order->recursive = 3;
		if (!$this->Order->exists()) {
			throw new NotFoundException();
		}

		$order = $this->Order->read();

		if (empty($this->request->data)) {
			$this->request->data = $order;
		}

		$this->set(compact('order'));

		if (!$this->request->is('put')) {
			return;
		}

		if (!$this->Order->save($this->request->data)) {
			$this->Session->setFlash(__d('webshop_orders', 'Could not save the order'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));

			return;
		}

		$this->Session->setFlash(__d('webshop_orders', 'The order has been saved'), 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-success'
		));
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

	/**
	 * Admin process
	 *
	 * @return void
	 * @access public
	 */
	public function admin_process() {
		list($action, $ids) = $this->BulkProcess->getRequestVars($this->{$this->modelClass}->alias);

		$displayName = Inflector::pluralize(Inflector::humanize($this->{$this->modelClass}->alias));
		$options = array(
			'redirect' => $this->referer(),
			'multiple' => array('copy' => false),
			'messageMap' => array(
				'cancel' => __d('webshop_orders', '%s cancelled', $displayName),
			),
		);
		return $this->BulkProcess->process($this->{$this->modelClass}, $action, $ids, $options);
	}

	public function panel_index() {
		$orders = $this->Paginator->paginate('Order', array(
			$this->Order->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
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

		if ($order['Order']['remaining'] <= 0) {
			$this->Session->setFlash(__d('webshop_orders', 'You\'ve already paid this order'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-info'
			));

			$this->redirect(array(
				'action' => 'view',
				$id
			));

			return;
		}

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