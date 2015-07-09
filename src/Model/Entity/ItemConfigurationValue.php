<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;
use Webshop\Price;

/**
 * @property ConfigurationOption configuration_option
 */
class ItemConfigurationValue extends Entity
{

    public function value()
    {
        switch ($this->configuration_option->type) {
            case 'list':
                return $this->configuration_option_item_id;
        }

        return $this->value;
    }

    public function basePrice() {
        return $this->configuration_option->price($this->value());
    }

    /**
     * @return Price
     */
    public function price()
    {
        $configurationPrice = $this->configuration_option->price($this->value());

        if (!$configurationPrice) {
            return Price::emptyPrice()->subject($this);
        }

        return Price::create()
            ->basePrice($configurationPrice)
            ->subject($this);
    }

}
