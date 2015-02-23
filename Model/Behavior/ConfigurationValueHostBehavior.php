<?php

class ConfigurationValueHostBehavior extends ModelBehavior {

	public function setup(Model $Model, $config = array()) {
		$Model->bindModel(array(
			'hasMany' => array(
				'ConfigurationValue' => array(
					'className' => 'Webshop.ItemConfigurationValue',
					'foreignKey' => 'foreign_key',
					'conditions' => array(
						'ConfigurationValue.model' => $Model->name
					)
				)
			)
		), false);
	}

	public function afterFind(Model $model, $results, $primary = false) {
		if ($primary) {
			foreach ($results as $index => $entry) {
				if (!isset($entry['ConfigurationValue'])) {
					continue;
				}

				$results[$index][$model->alias]['configuration'] = $this->parseConfiguration($model, $entry['ConfigurationValue']);
			}
		} else {
			if (!isset($entry['ConfigurationValue'])) {
				return $results;
			}

			$results[$model->alias]['configuration'] = $this->parseConfiguration($model, $entry['ConfigurationValue']);
		}

		return $results;
	}

	public function parseConfiguration(Model $Model, $configurationValues) {
		$aliases = $Model->ConfigurationValue->ConfigurationOption->find('list', array(
			'fields' => array(
				'ConfigurationOption.alias'
			),
			'conditions' => array(
				'ConfigurationOption.id' => Hash::extract($configurationValues, '{n}.configuration_option_id')
			)
		));

		$configuration = array();
		foreach ($configurationValues as $configurationValue) {
			if (!isset($aliases[$configurationValue['configuration_option_id']])) {
				continue;
			}
			$alias = $aliases[$configurationValue['configuration_option_id']];

			$value = null;

			if (isset($configurationValue['value'])) {
				$value = $configurationValue['value'];
			}

			if (isset($configurationValue['configuration_option_item_id'])) {
				$value = $configurationValue['configuration_option_item_id'];
			}

			if (!$value) {
				continue;
			}

			$configuration[$alias] = $value;
		}

		return $configuration;
	}

}
