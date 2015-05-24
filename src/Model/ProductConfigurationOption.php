<?php

class ProductConfigurationOption extends AppModel {

	public $belongsTo = array(
		'Product' => array(
			'className' => 'Webshop.Product'
		),
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption'
		)
	);

	public $hasMany = array(
//		'ConfigurationOptionItem' => array(
//			'className' => 'Webshop.ConfigurationOptionItem'
//		)
	);

}
