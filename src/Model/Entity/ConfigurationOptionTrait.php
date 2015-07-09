<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;

trait ConfigurationOptionTrait
{

    /**
     * @return \Cake\Collection\Collection
     */
    public function options()
    {
        $options = [];
        $overwrites = [];
        /** @var Entity $itemConfigurationGroup */
        foreach ($this->item_configuration_groups as $itemConfigurationGroup) {
            /** @var ConfigurationOption $configurationOption */
            foreach ($itemConfigurationGroup->configuration_group->configuration_options as $configurationOption) {
                $options[$configurationOption->id] = $configurationOption;
            }
        }

        /** @var Entity $itemConfigurationOptionOverwrite */
        foreach ($this->item_configuration_option_overwrites as $itemConfigurationOptionOverwrite) {
            $overwrites[$itemConfigurationOptionOverwrite->configuration_option_id] = $itemConfigurationOptionOverwrite;
        }

        /** @var Entity $overwrite */
        foreach ($overwrites as $configurationOptionId => $overwrite) {
            foreach ($overwrite->toArray() as $field => $value) {
                if ($value === null) {
                    continue;
                }
                if (in_array($field, array('id', 'foreign_key', 'model', 'configuration_option_id'))) {
                    continue;
                }

                $options[$configurationOptionId]->set($field, $value);
            }

        }

        return collection($options);
    }

}
