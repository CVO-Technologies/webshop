<?php

App::uses('WebshopOrdersAppModel', 'WebshopOrders.Model');

class OrderProductOption extends WebshopOrdersAppModel {

	public $belongsTo = array(
		'OrderProduct' => array(
			'className' => 'WebshopOrders.Product',
			'foreignKey' => 'order_product_id'
		),
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption',
		),
	);

}
