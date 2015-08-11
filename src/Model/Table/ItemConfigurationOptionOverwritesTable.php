<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ItemConfigurationOptionOverwritesTable extends Table
{

    public $belongsTo = [
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

        $this->belongsTo('ConfigurationOptions', [
            'className' => 'Webshop.ConfigurationOptions'
        ]);
    }
}
