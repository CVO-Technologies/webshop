<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ItemConfigurationGroup extends WebshopAppModel {

	public $belongsTo = array(
		'ConfigurationGroup' => array(
			'className' => 'Webshop.ConfigurationGroup'
		)
	);

}
