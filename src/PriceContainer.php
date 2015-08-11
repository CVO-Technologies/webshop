<?php

namespace Webshop;

use Cake\Collection\Collection;

class PriceContainer
{

    protected $_prices = [];

    public static function construct()
    {
        return new PriceContainer;
    }

    public function add(Price $price)
    {
        $this->_prices[] = $price;

        return $this;
    }

    public function __debugInfo()
    {
        return [
            'prices' => $this->prices(),
            'taxes' => $this->taxes()
        ];
    }

    public function prices()
    {
        return $this->_prices;
    }

    public function taxes()
    {
        $taxes = new TaxInformation;

        /** @var Price $price */
        foreach ($this->prices() as $price) {
            $priceTaxes = $price->taxes();

            $taxes->merge($priceTaxes);
        }

        return $taxes;
    }

}
