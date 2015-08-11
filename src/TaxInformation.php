<?php

namespace Webshop;

class TaxInformation
{

    protected $_vat = [];
    protected $_calculated = [
        'vat' => []
    ];

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

    public function addVat($percentage)
    {
        $this->_vat[] = $percentage;
    }

    public function calculate($amount)
    {
        foreach ($this->_vat as $percentage) {
            $this->_calculated['vat'][$percentage] = $amount / 100 * $percentage;
        }

        return $this;
    }

    public function calculated()
    {
        $amount = 0;

        foreach ($this->_calculated['vat'] as $percentage => $vatAmount) {
            $amount += $vatAmount;
        }

        return $amount;
    }

    public function __debugInfo()
    {
        return [
            'calculated' => $this->_calculated
        ];
    }

}
