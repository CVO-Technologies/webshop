<?php

namespace Webshop\CustomerAccessProvider;

use Cake\Controller\Controller;
use Cake\Core\App;

class CustomerAccessProvider {

    /**
     * @param $class
     * @return CustomerAccessProvider
     */
	static public function get($class) {
        $class = App::className($class, 'CustomerAccessProvider', 'AccessProvider');

		return new $class;
	}

	public function getAccessibleCustomers(Controller $Controller) {
		return false;
	}

}
