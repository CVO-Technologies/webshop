<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{

    use ConfigurationOptionTrait;

    public function price()
    {
        debug($this);
    }

}
