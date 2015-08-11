<?php

namespace Webshop;

class TaxInformation
{

    protected $_vat = [];
    protected $_calculated = [
        'vat' => []
    ];

    /**
     * @param TaxInformation $taxInformation Merges in data from another TaxInformation object
     *
     * @return void
     */
    public function merge(TaxInformation $taxInformation)
    {
        foreach ($taxInformation->vat() as $percentage => $amount) {
            if (!isset($this->_calculated['vat'][$percentage])) {
                $this->_calculated['vat'][$percentage] = 0;
            }

            $this->_calculated['vat'][$percentage] += $amount;
        }
    }

    /**
     * @return array
     */
    public function vat()
    {
        return $this->_calculated['vat'];
    }

    /**
     * Adds a tax percentage
     *
     * @param float $percentage tax percentage
     *
     * @return void
     */
    public function addVat($percentage)
    {
        $this->_vat[] = $percentage;
    }

    /**
     * Calculates vat for a price amount
     *
     * @param float $amount Amount of money
     *
     * @return $this
     */
    public function calculate($amount)
    {
        foreach ($this->_vat as $percentage) {
            $this->_calculated['vat'][$percentage] = $amount / 100 * $percentage;
        }

        return $this;
    }

    /**
     * Calculated vat
     *
     * @return float
     */
    public function calculated()
    {
        $amount = 0;

        foreach ($this->_calculated['vat'] as $percentage => $vatAmount) {
            $amount += $vatAmount;
        }

        return $amount;
    }

    /**
     * Returns useful debug info
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'calculated' => $this->_calculated
        ];
    }
}
