<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{

    use ConfigurationOptionTrait;

    /**
     * Unknown method
     *
     * @deprecated
     *
     * @return void
     */
    public function price()
    {
        debug($this);
    }
}
