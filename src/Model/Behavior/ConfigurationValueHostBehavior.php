<?php

namespace Webshop\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Utility\Hash;

class ConfigurationValueHostBehavior extends Behavior {

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->_table->hasMany('ConfigurationValues', [
            'className' => 'Webshop.ItemConfigurationValues',
            'foreignKey' => 'foreign_key',
            'conditions' => array(
                'ConfigurationValues.model' => get_class($this->_table)
            )
        ]);
    }

//	public function afterFind(Model $model, $results, $primary = false) {
//		if ($primary) {
//			foreach ($results as $index => $entry) {
//				if (!isset($entry['ConfigurationValue'])) {
//					continue;
//				}
//
//				$results[$index][$model->alias]['configuration'] = $this->parseConfiguration($model, $entry['ConfigurationValue']);
//			}
//		} else {
//			if (!isset($entry['ConfigurationValue'])) {
//				return $results;
//			}
//
//			$results[$model->alias]['configuration'] = $this->parseConfiguration($model, $entry['ConfigurationValue']);
//		}
//
//		return $results;
//	}

	public function parseConfiguration(array $configurationValues) {
		$aliases = $this->_table->ConfigurationValues->ConfigurationOptions->find('list', [
            'valueField' => 'alias'
        ])->where([
            'ConfigurationOptions.id IN' => Hash::extract($configurationValues, '{n}.configuration_option_id')
        ])->toArray();

		$configuration = array();
		foreach ($configurationValues as $configurationValue) {
			if (!isset($aliases[(int) $configurationValue['configuration_option_id']])) {
				continue;
			}
			$alias = $aliases[(int) $configurationValue['configuration_option_id']];

			$value = null;

			if (isset($configurationValue['value'])) {
				$value = $configurationValue['value'];
			}

			if (isset($configurationValue['configuration_option_item_id'])) {
				$value = $configurationValue['configuration_option_item_id'];
			}

			if (is_null($value)) {
				continue;
			}

			$configuration[$alias] = $value;
		}

		return $configuration;
	}

}
