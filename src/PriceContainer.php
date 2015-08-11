<?php

namespace Webshop;

use Cake\Collection\Collection;

class PriceContainer
{

    protected $_prices = [];

    /**
     * Constructs a empty price container
     *
     * @return PriceContainer
     */
    public static function construct()
    {
        return new PriceContainer;
    }

    /**
     * Adds a price to the collection
     *
     * @param Price $price Price to add
     *
     * @return $this
     */
    public function add(Price $price)
    {
        $this->_prices[] = $price;

        return $this;
    }

    /**
     * Return a array with price objects
     *
     * @return array
     */
    public function prices()
    {
        return $this->_prices;
    }

    /**
     * Returns tax information
     *
     * @return TaxInformation
     */
    public function taxes()
    {
        $taxes = new TaxInformation;

        /* @var Price $price */
        foreach ($this->prices() as $price) {
            $priceTaxes = $price->taxes();

            $taxes->merge($priceTaxes);
        }

        return $taxes;
    }

    /**
     * Returns useful debug info
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'prices' => $this->prices(),
            'taxes' => $this->taxes()
        ];
    }
}
