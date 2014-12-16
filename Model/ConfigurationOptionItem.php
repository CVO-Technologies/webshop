<?php

class ConfigurationOptionItem extends WebshopAppModel {

	public $belongsTo = array(
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption'
		)
	);

}
