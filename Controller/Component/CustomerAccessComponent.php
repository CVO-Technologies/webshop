<?php

App::uses('CustomerAccessProvider', 'Webshop.CustomerAccessProvider');

class CustomerAccessComponent extends Component {

	public function initialize(Controller $Controller) {
		$this->Controller = $Controller;
	}

	public function beforeRender(Controller $Controller) {
		$accessibleCustomers = $this->getAccessibleCustomers();

		if ((!isset($Controller->request->params['prefix'])) || ($Controller->request->params['prefix'] !== 'panel')) {
			return;
		}

		if (empty($accessibleCustomers)) {
			throw new ForbiddenException();
		}
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