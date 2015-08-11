<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ItemConfigurationOptionOverwritesTable extends Table
{

    public $belongsTo = array(
        'ConfigurationOption' => array(
            'className' => 'Webshop.ConfigurationOption'
        )
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('ConfigurationOptions', [
            'className' => 'Webshop.ConfigurationOptions'
        ]);
    }


}
