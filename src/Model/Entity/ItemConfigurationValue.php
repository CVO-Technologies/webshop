<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;
use Webshop\Price;

/**
 * @property ConfigurationOption configuration_option
 */
class ItemConfigurationValue extends Entity
{

    /**
     * Returns the base price of an item
     *
     * @return null|Price
     */
    public function basePrice()
    {
        return $this->configuration_option->price($this->value());
    }

    /**
     * Returns the value of an item
     *
     * @return mixed
     */
    public function value()
    {
        switch ($this->configuration_option->type) {
            case 'list':
                return $this->configuration_option_item_id;
        }

        return $this->value;
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
