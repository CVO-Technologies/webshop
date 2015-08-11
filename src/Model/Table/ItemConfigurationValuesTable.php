<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Hash;
use Webshop\Model\Entity\ConfigurationOption;

class ItemConfigurationValuesTable extends Table
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('ConfigurationOptions', [
            'className' => 'Webshop.ConfigurationOptions',
        ]);
        $this->belongsTo('ConfigurationOptionItems', [
            'className' => 'Webshop.ConfigurationOptionItems',
        ]);
    }

    /**
     * Generates a array with value data
     *
     * @param string $modelName Model name
     * @param array $configurationGroupIds Group ids
     * @param array $configuration Configuration array
     * @param array $nonOverridableConfiguration Array with options that can't be overriden
     *
     * @return array
     */
    public function generateValueData($modelName, $configurationGroupIds, $configuration, $nonOverridableConfiguration)
    {
        $combinedConfigurations = Hash::merge($configuration, $nonOverridableConfiguration);

        $configurationOptionsQuery = $this->ConfigurationOptions->find()->where([
            'ConfigurationOptions.configuration_group_id IN' => $configurationGroupIds,
            'ConfigurationOptions.alias IN' => array_keys($combinedConfigurations)
        ]);

        $configurationOptions = [];
        foreach ($configurationOptionsQuery as $configurationOption) {
            $configurationOptions[$configurationOption->alias] = $configurationOption;
        }

        $valueData = [];
        foreach ($combinedConfigurations as $alias => $value) {
            /* @var ConfigurationOption $configurationOption */
            $configurationOption = $configurationOptions[$alias];

            $valueEntry = [
                'configuration_option_id' => $configurationOption->id,
                'model' => $modelName,
                'price' => $configurationOption->price($value)->subTotal(),
                'overridable' => true
            ];
            if (isset($nonOverridableConfiguration[$alias])) {
                $valueEntry['overridable'] = false;
            }
            if ($configurationOption->type === 'list') {
                $valueEntry['configuration_option_item_id'] = $value;
            } else {
                $valueEntry['value'] = $value;
            }

            $valueData[] = $valueEntry;
        }

        return $valueData;
    }
}
