<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ConfigurationOption extends WebshopAppModel {

	public $actsAs = array(
		'Croogo.Ordered' => array(
//			'field' => 'weight',
			'foreign_key' => 'configuration_group_id'
		),
	);

	public $belongsTo = array(
		'ConfigurationGroup' => array(
			'className' => 'Webshop.ConfigurationGroup'
		)
	);

	public $hasMany = array(
		'ConfigurationOptionItem'
	);

}
