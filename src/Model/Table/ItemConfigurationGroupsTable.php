<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class ItemConfigurationGroupsTable extends Table {

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('ConfigurationGroups', [
            'className' => 'Webshop.ConfigurationGroups'
        ]);
    }

}
