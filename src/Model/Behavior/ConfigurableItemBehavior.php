<?php

class ConfigurableItemBehavior extends ModelBehavior {

	public $mapMethods = array(
		'/\_findOptions/' => 'findOptions'
	);

	public function setup(Model $Model, $config = array()) {
		$Model->bindModel(array(
			'hasMany' => array(
				'ItemConfigurationGroup' => array(
					'className' => 'Webshop.ItemConfigurationGroup',
					'foreignKey' => 'foreign_key',
					'conditions' => array(
						'ItemConfigurationGroup.model' => $Model->name
					)
				),
				'ItemConfigurationOptionOverwrite' => array(
					'className' => 'Webshop.ItemConfigurationOptionOverwrite',
					'foreignKey' => 'foreign_key',
					'conditions' => array(
						'ItemConfigurationOptionOverwrite.model' => $Model->name
					)
				)
			)
		), false);

		$Model->findMethods['options'] = true;
	}

	public function findOptions(Model $Model, $method, $state, $query, $results = array()) {
		if ($state === 'before') {
			$query['fields'] = array(
				$Model->alias . '.' . $Model->primaryKey
			);

			if (!isset($query['contain'])) {
				$query['contain'] = array();
			}

			$query['contain'] += array(
				'ItemConfigurationGroup' => array(
					'ConfigurationGroup' => array(
						'ConfigurationOption' => array(
							'ConfigurationOptionItem'
						)
					)
				),
				'ItemConfigurationOptionOverwrite',
			);

			return $query;
		}

		$configurationOptionsResults = array();
		foreach ($results as $index => $result) {
			$configurationOptions = array();
			foreach ($result['ItemConfigurationGroup'] as $itemConfigurationGroup) {
				$configurationOptions = Hash::merge(
					$configurationOptions,
					Hash::combine(
						$itemConfigurationGroup,
						'ConfigurationGroup.ConfigurationOption.{n}.id',
						'ConfigurationGroup.ConfigurationOption.{n}'
					)
				);
			}

			$overwrites = Hash::combine(
				$result,
				'ItemConfigurationOptionOverwrite.{n}.configuration_option_id',
				'ItemConfigurationOptionOverwrite.{n}'
			);

			foreach ($configurationOptions as $configurationOptionIndex => $configurationOption) {
				if (!isset($overwrites[$configurationOptionIndex])) {
					continue;
				}

				$overwrite = $overwrites[$configurationOptionIndex];

				foreach ($overwrite as $field => $value) {
					if ($value === null) {
						continue;
					}
					if (in_array($field, array('id', 'foreign_key', 'model', 'configuration_option_id'))) {
						continue;
					}

					$configurationOptions[$configurationOptionIndex][$field] = $value;
				}
			}

			$configurationOptionsResults[$index] = $configurationOptions;
		}

		return $configurationOptionsResults;
	}


}
