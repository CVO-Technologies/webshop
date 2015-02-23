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

	public function price($id, $value) {
		$this->id = $id;

		$type = $this->field('type');
		switch ($type) {
			case 'list':
				$this->ConfigurationOptionItem->id = $value;

				return (float) $this->ConfigurationOptionItem->field('price');
			case 'string':
				return null;
		}

		return (float) ($value / $this->field('step')) * $this->field('step_price');
	}

}
