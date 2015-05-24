<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ItemConfigurationOptionOverwrite extends WebshopAppModel {

	public $belongsTo = array(
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption'
		)
	);

}
