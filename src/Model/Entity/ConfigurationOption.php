<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;
use Webshop\Price;

class ConfigurationOption extends Entity
{

    /**
     * @param mixed $value Input value
     * @return Price|null
     */
    public function price($value)
    {
        switch ($this->type) {
            case 'list':
                return Price::fromDirectInput($this->configuration_option_item->price)
                    ->subject($this);
            case 'string':
                return Price::emptyPrice()
                    ->subject($this);
        }

        if ($value / $this->step == 0) {
            return Price::emptyPrice()
                ->subject($this);
        }

        return Price::fromDirectInput($this->step_price)
            ->repeat($value / $this->step)
            ->subject($this);
    }
}
