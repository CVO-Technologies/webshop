<?php

namespace Webshop;

use Cake\ORM\Entity;
use Cake\Utility\Hash;

class Price
{

    protected $_empty = false;
    protected $_basePrice = null;
    protected $_directInput = null;
    protected $_collections = [];
    protected $_vat = [];
    protected $_taxInformation = null;
    protected $_repeat = 1;
    protected $_subject = null;

    /**
     * @return Price
     */
    public static function create()
    {
        $price = new Price;
        $price->taxInformation(new TaxInformation);

        return $price;
    }

    public static function fromDirectInput($directInput)
    {
        return static::create()
            ->directInput($directInput);
    }

    public static function emptyPrice()
    {
        return static::create()
            ->emptyMark(true);
    }

    public static function createFromCollection(PriceContainer $collection)
    {
        return static::create()
            ->addCollection($collection);
    }

    public function directInput($directInput = null)
    {
        if (is_null($directInput)) {
            return $this->_directInput;
        }

        $this->_directInput = $directInput;

        return $this;
    }

    public function basePrice(Price $basePrice = null)
    {
        if (!$basePrice) {
            return $this->_basePrice;
        }

        $this->_basePrice = $basePrice;

        return $this;
    }

    public function addCollection(PriceContainer $collection)
    {
        $this->_collections[] = $collection;

        return $this;
    }

    public function repeat($repeat = null)
    {
        if (is_null($repeat)) {
            return $this->_repeat;
        }

        $this->_repeat = $repeat;

        return $this;
    }

    public function addVat($percentage)
    {
        $this->taxInformation()->addVat($percentage);

        return $this;
    }

    public function emptyMark($empty = null)
    {
        if (is_null($empty)) {
            return $this->_empty;
        }

        $this->_empty = $empty;

        return $this;
    }

    /**
     * @param Entity|null $entity
     * @return Entity|$this|null
     */
    public function subject(Entity $entity = null)
    {
        if (!$entity) {
            return $this->_subject;
        }

        $this->_subject = $entity;

        return $this;
    }

    /**
     * Return subtotal
     *
     * @return float
     */
    public function subTotal()
    {
        if ($this->emptyMark()) {
            return 0;
        }

        $subtotal = 0;

        if ($this->directInput()) {
            $subtotal = $this->directInput();
        }

        if ($this->basePrice()) {
            $subtotal += $this->basePrice()->total();
        }

        /** @var PriceContainer $collection */
        foreach ($this->_collections as $collection) {
            /** @var Price $price */
            foreach ($collection->prices() as $price) {
                $subtotal += $price->subTotal();
            }
        }

        return $subtotal;
    }

    /**
     * Return total including taxes
     *
     * @return float
     */
    public function total()
    {
        $subTotal = $this->subTotal();

        $total = $subTotal;

        $total += $this->taxes()->calculated();

        $total *= $this->repeat();

        return $total;
    }

    public function taxes()
    {
        $taxes = clone $this->taxInformation();

        $taxes->calculate($this->subTotal());

        if ($this->basePrice()) {
            $taxes->merge($this->basePrice()->taxes());
        }

        /** @var PriceContainer $collection */
        foreach ($this->_collections as $collection) {
            $collectionTaxes = $collection->taxes();

            $taxes->merge($collectionTaxes);
        }

        return $taxes;
    }

    /**
     * @param TaxInformation|null $taxInformation
     * @return TaxInformation|$this
     */
    public function taxInformation(TaxInformation $taxInformation = null)
    {
        if (!$taxInformation) {
            return $this->_taxInformation;
        }

        $this->_taxInformation = $taxInformation;

        return $this;
    }

    public function __debugInfo()
    {
        if ($this->emptyMark()) {
            return [
                'markedEmpty' => true,
                'subject' => get_class($this->subject()),
            ];
        }

        if ($this->directInput()) {
            return [
                'directInput' => $this->directInput(),
                'repeat' => $this->_repeat,
                'subject' => get_class($this->subject()),
                'taxes' => $this->taxes(),
                'total' => $this->total()
            ];
        }

        return [
            'collections' => $this->_collections,
            'basePrice' => $this->_basePrice,
            'repeat' => $this->_repeat,
            'subject' => get_class($this->subject()),
            'taxes' => $this->taxes(),
            'subtotal' => $this->subTotal(),
            'total' => $this->total()
        ];
    }

}
