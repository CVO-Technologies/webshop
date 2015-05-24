<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ConfigurationGroup extends WebshopAppModel {

	public $hasMany = array(
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption'
		)
	);

	public function createGroup($alias, $schema) {
		$configurationGroupData = $schema;
		unset($configurationGroupData['options']);

		$configurationGroup = array();
		$configurationGroup[$this->alias] = $configurationGroupData;
		$configurationGroup[$this->alias]['alias'] = $alias;
		$configurationGroup[$this->ConfigurationOption->alias] = array();

		foreach ($schema['options'] as $optionAlias => $option) {
			$configurationOption = $option;
			$configurationOption['alias'] = $optionAlias;
			$configurationGroup[$this->ConfigurationOption->alias][] = $configurationOption;
		}

		return $this->saveAll($configurationGroup, array(
			'deep' => true
		));
	}

	public function destroyGroup($alias) {
		return $this->deleteAll(array(
			$this->alias . '.alias' => $alias
		));
	}

}
