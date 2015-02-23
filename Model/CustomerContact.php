<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class CustomerContact extends WebshopAppModel {

	public $actsAs = array(
		'Search.Searchable',
	);

	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Webshop.Customer',
			'foreignKey' => 'customer_id'
		),
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		),
	);

	public $filterArgs = array(
		'customer_id' => array('type' => 'value'),
	);

}
