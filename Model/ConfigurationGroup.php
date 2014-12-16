<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ConfigurationGroup extends WebshopAppModel {

	public $hasMany = array(
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption'
		)
	);

}
