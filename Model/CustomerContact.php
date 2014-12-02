<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class CustomerContact extends WebshopAppModel {

	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Webshop.Customer',
			'foreignKey' => 'customer_id'
		)
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		),
		'email' => array(
			'rule' => 'notEmpty',
		)
	);

}
