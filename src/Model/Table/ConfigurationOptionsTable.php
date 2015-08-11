<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ConfigurationOptionsTable extends Table
{

    /**
     * }{@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

//        $this->addBehavior('Croogo/Core.Ordered', [
////            'field' => 'weight',
//            'foreign_key' => 'configuration_group_id'
//        ]);
        $this->belongsTo('ConfigurationGroups', [
            'className' => 'Webshop.ConfigurationGroups'
        ]);
        $this->hasMany('ConfigurationOptionItems', [
            'className' => 'Webshop.ConfigurationOptionItems'
        ]);
    }
}
