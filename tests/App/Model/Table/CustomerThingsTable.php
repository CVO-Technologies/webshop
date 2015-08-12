<?php

namespace Webshop\Test\App\Model\Table;

use Cake\ORM\Table;

class CustomerThingsTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Webshop.CustomerOwned');
    }
}
