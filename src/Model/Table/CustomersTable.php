<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class Customer extends WebshopAppModel {

	public $belongsTo = array(
		'FinancialContact' => array(
			'className' => 'Webshop.CustomerContact',
			'foreignKey' => 'financial_contact_id'
		),
		'InvoiceAddressDetail' => array(
			'className' => 'Webshop.AddressDetail',
			'foreignKey' => 'invoice_address_detail_id'
		)
	);

	public $hasMany = array(
		'CustomerContact' => array(
			'className' => 'Webshop.CustomerContact',
			'foreignKey' => 'customer_id'
		),
		'AddressDetail' => array(
			'className' => 'Webshop.AddressDetail',
			'foreignKey' => 'customer_id'
		)
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		),
		'type' => array(
			'rule' => array('inList', array('individual', 'company')),
		),
	);

}
