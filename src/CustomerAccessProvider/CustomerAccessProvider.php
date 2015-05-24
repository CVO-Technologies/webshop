<?php

class CustomerAccessProvider extends Object {

	static public function get($class) {
		list($plugin, $class) = pluginSplit($class, true);

		$class .= 'AccessProvider';

		App::uses($class, $plugin . 'CustomerAccessProvider');

		return new $class;
	}

	public function getAccessibleCustomers(Controller $Controller) {
		return false;
	}

}