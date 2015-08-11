<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ConfigurationGroupsTable extends Table
{

    public $hasMany = [
        'ConfigurationOption' => [
            'className' => 'Webshop.ConfigurationOption'
        ]
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->hasMany('ConfigurationOptions', [
            'className' => 'Webshop.ConfigurationOptions'
        ]);
    }

//    public function createGroup($alias, $schema)
//    {
//        $configurationGroupData = $schema;
//        unset($configurationGroupData['options']);
//
//        $configurationGroup = array();
//        $configurationGroup[$this->alias] = $configurationGroupData;
//        $configurationGroup[$this->alias]['alias'] = $alias;
//        $configurationGroup[$this->ConfigurationOption->alias] = array();
//
//        foreach ($schema['options'] as $optionAlias => $option) {
//            $configurationOption = $option;
//            $configurationOption['alias'] = $optionAlias;
//            $configurationGroup[$this->ConfigurationOption->alias][] = $configurationOption;
//        }
//
//        return $this->saveAll($configurationGroup, [
//            'deep' => true
//        ]);
//    }
//
//    public function destroyGroup($alias)
//    {
//        return $this->deleteAll([
//            $this->alias . '.alias' => $alias
//        ]);
//    }
}
