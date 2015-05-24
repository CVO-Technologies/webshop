<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class ItemConfigurationValue extends WebshopAppModel {

	public $belongsTo = array(
		'ConfigurationOption' => array(
			'className' => 'Webshop.ConfigurationOption',
		),
		'ConfigurationOptionItem' => array(
			'className' => 'Webshop.ConfigurationOptionItem',
		),
	);

	public function generateValueData($modelName, $configurationGroupIds, $configuration, $nonOverridableConfiguration) {
		$combinedConfigurations = Hash::merge($configuration, $nonOverridableConfiguration);

		$configurationOptions = $this->ConfigurationOption->find('all', array(
			'conditions' => array(
				'ConfigurationOption.configuration_group_id' => $configurationGroupIds,
				'ConfigurationOption.alias' => array_keys($combinedConfigurations)
			)
		));

//		debug($configurationOptions);exit();

		$configurationOptions = Hash::combine($configurationOptions, '{n}.ConfigurationOption.alias', '{n}');

//		debug($configurationOptions);

		$valueData = array();
		foreach ($combinedConfigurations as $alias => $value) {
			$configurationOption = $configurationOptions[$alias];

			$valueEntry = array(
				'configuration_option_id' => $configurationOption['ConfigurationOption']['id'],
				'model' => $modelName,
				'price' => $this->ConfigurationOption->price($configurationOption['ConfigurationOption']['id'], $value),
				'overridable' => true
			);
			if (isset($nonOverridableConfiguration[$alias])) {
				$valueEntry['overridable'] = false;
			}
			if ($configurationOption['ConfigurationOption']['type'] === 'list') {
				$valueEntry['configuration_option_item_id'] = $value;
			} else {
				$valueEntry['value'] = $value;
			}

			$valueData[] = $valueEntry;
		}

		return $valueData;
	}

}
