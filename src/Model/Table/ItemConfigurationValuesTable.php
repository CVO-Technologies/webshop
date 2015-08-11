<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Hash;
use Webshop\Model\Entity\ConfigurationOption;

class ItemConfigurationValuesTable extends Table
{

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

        $valueData = array();
        foreach ($combinedConfigurations as $alias => $value) {
            /** @var ConfigurationOption $configurationOption */
            $configurationOption = $configurationOptions[$alias];

            $valueEntry = array(
                'configuration_option_id' => $configurationOption->id,
                'model' => $modelName,
                'price' => $configurationOption->price($value)->subTotal(),
                'overridable' => true
            );
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
