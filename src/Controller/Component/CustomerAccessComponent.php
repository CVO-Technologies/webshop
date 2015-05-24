<?php

App::uses('CustomerAccessProvider', 'Webshop.CustomerAccessProvider');

class CustomerAccessComponent extends Component {

	public $components = array(
		'Session'
	);

	public function initialize(Controller $Controller) {
		$this->Controller = $Controller;
	}

	public function beforeRender(Controller $Controller) {
		if ($Controller->request->param('prefix') === 'admin') {
			return;
		}

		$accessibleCustomers = $this->getAccessibleCustomers();

		if (($this->getCustomerId(false)) && (!in_array($this->getCustomerId(false), $accessibleCustomers))) {
			throw new ForbiddenException();
		}

		$Customer = ClassRegistry::init('Webshop.Customer');
		if ($this->getCustomerId()) {
			$Controller->set('customer', $Customer->read(null, $this->getCustomerId(false)));
		}

		$Controller->set('customers', $Customer->find('list', array(
			'conditions' => array(
				'Customer.id' => $accessibleCustomers
			)
		)));

		if ((!isset($Controller->request->params['prefix'])) || ($Controller->request->params['prefix'] !== 'panel')) {
			return;
		}

		if (empty($accessibleCustomers)) {
			throw new ForbiddenException();
		}
	}

	public function getCustomerId($redirect = true) {
		$customerId = false;
		if (isset($this->Controller->request->params['named']['customer'])) {
			$customerId = $this->Controller->request->params['named']['customer'];
		}

		if ($this->Controller->Session->check('Customer.current')) {
			$customerId = $this->Controller->Session->read('Customer.current');
		}

		if (count($this->getAccessibleCustomers()) === 1) {
			$customerId = $this->getAccessibleCustomers()[0];
		}

		if (($customerId !== false) && (!in_array($customerId, $this->getAccessibleCustomers()))) {
			$this->Controller->Session->delete('Customer.current');

			return $this->getCustomerId($redirect);
		}

		if (($customerId === false) && ($redirect) && (count($this->getAccessibleCustomers()) > 1)) {
			if (($this->Controller->request['prefix'] != 'admin') && ($this->Controller->request['action'] != 'panel_select') && (!$this->Controller->request->is(array('ajax', 'requested'))))  {
//				debug($this->Controller->request);exit();
//				debug($this->Controller->request)
				if (!$this->Session->check('Customer.select.redirect')) {
					$this->Session->write('Customer.select.redirect', $this->Controller->request->here);
				}
				$this->Controller->redirect(array('panel' => true, 'plugin' => 'webshop', 'controller' => 'customers', 'action' => 'select'));
			}
		}

		return $customerId;
	}

	public function getAccessibleCustomers() {
		$accessibleCustomers = array();
		foreach (Configure::read('Webshop.customer_access_providers') as $alias => $options) {
			$AccessProvider = CustomerAccessProvider::get($options['provider']);

			$accessibleCustomersTemp = $AccessProvider->getAccessibleCustomers($this->Controller);

			if (is_array($accessibleCustomersTemp)) {
				$accessibleCustomers += $accessibleCustomersTemp;
			}
		}

		return $accessibleCustomers;
	}

}