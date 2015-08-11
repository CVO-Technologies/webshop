<?php

namespace Webshop\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class ConfigurableItemBehavior extends Behavior
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->_table->hasMany('ItemConfigurationGroups', [
            'className' => 'Webshop.ItemConfigurationGroups',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ItemConfigurationGroups.model' => get_class($this->_table)
            ]
        ]);
        $this->_table->hasMany('ItemConfigurationOptionOverwrites', [
            'className' => 'Webshop.ItemConfigurationOptionOverwrites',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ItemConfigurationOptionOverwrites.model' => get_class($this->_table)
            ]
        ]);
    }


//    public function setup(Model $Model, $config = array()) {
//		$Model->bindModel(array(
//			'hasMany' => array(
//				'ItemConfigurationGroup' => array(
//					'className' => 'Webshop.ItemConfigurationGroup',
//					'foreignKey' => 'foreign_key',
//					'conditions' => array(
//						'ItemConfigurationGroup.model' => $Model->name
//					)
//				),
//				'ItemConfigurationOptionOverwrite' => array(
//					'className' => 'Webshop.ItemConfigurationOptionOverwrite',
//					'foreignKey' => 'foreign_key',
//					'conditions' => array(
//						'ItemConfigurationOptionOverwrite.model' => $Model->name
//					)
//				)
//			)
//		), false);
//
//		$Model->findMethods['options'] = true;
//	}

    /**
     * @param Query $query Find the options
     *
     * @return Query
     */
    public function findOptions(Query $query)
    {
        $query->select([$query->repository()->primaryKey()])->contain([
            'ItemConfigurationGroups' => [
                'ConfigurationGroups' => [
                    'ConfigurationOptions' => [
                        'ConfigurationOptionItems'
                    ]
                ]
            ],
            'ItemConfigurationOptionOverwrites',
        ]);

        return $query;
    }
}
