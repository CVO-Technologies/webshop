<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ConfigurationOptionItemsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('ConfigurationOptions', [
            'className' => 'Webshop.ConfigurationOptions'
        ]);
    }


}
