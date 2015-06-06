<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class AddressDetail extends WebshopAppModel {

	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Webshop.Customer',
			'foreignKey' => 'customer_id'
		)
	);

	public $validate = array(
		'address_line_1' => array(
			'rule' => 'notEmpty',
		),
		'city' => array(
			'rule' => 'notEmpty',
		),
		'country' => array(
			'rule' => 'notEmpty',
		),
	);

}
