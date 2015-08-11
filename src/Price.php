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
     * Creates a price object from a direct value
     *
     * @param float $directInput Direct value
     *
     * @return $this|null|Price
     */
    public static function fromDirectInput($directInput)
    {
        return static::create()
            ->directInput($directInput);
    }

    /**
     * Gets or sets the direct va;ie
     *
     * @param float|null $directInput Direct value
     *
     *
     * @return $this|null
     */
    public function directInput($directInput = null)
    {
        if (is_null($directInput)) {
            return $this->_directInput;
        }

        $this->_directInput = $directInput;

        return $this;
    }

    /**
     * @return Price
     */
    public static function create()
    {
        $price = new Price;
        $price->taxInformation(new TaxInformation);

        return $price;
    }

    /**
     * Gets or sets a tax information object
     *
     * @param TaxInformation|null $taxInformation Object to set
     *
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

    /**
     * Returns an empty price object
     *
     * @return $this|bool|Price
     */
    public static function emptyPrice()
    {
        return static::create()
            ->emptyMark(true);
    }

    /**
     * Marks a object as empty
     *
     * @param bool $empty Boolean
     *
     * @return $this|bool
     */
    public function emptyMark($empty = null)
    {
        if (is_null($empty)) {
            return $this->_empty;
        }

        $this->_empty = $empty;

        return $this;
    }

    /**
     * Returns a price object from a price collection
     *
     * @param PriceContainer $collection Container add
     *
     * @return Price
     */
    public static function createFromCollection(PriceContainer $collection)
    {
        return static::create()
            ->addCollection($collection);
    }

    /**
     * Adds a price container
     *
     * @param PriceContainer $collection Container to add
     *
     * @return $this
     */
    public function addCollection(PriceContainer $collection)
    {
        $this->_collections[] = $collection;

        return $this;
    }

    /**
     * Adds a VAT percentage
     *
     * @param float $percentage Percentage to add
     *
     * @return $this
     */
    public function addVat($percentage)
    {
        $this->taxInformation()->addVat($percentage);

        return $this;
    }

    /**
     * Sets or gets an entity as subject
     *
     * @param Entity|null $entity Subject to set
     *
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
     * Returns an object with tax information
     *
     * @return $this|Price|TaxInformation
     */
    public function taxes()
    {
        $taxes = clone $this->taxInformation();

        $taxes->calculate($this->subTotal());

        if ($this->basePrice()) {
            $taxes->merge($this->basePrice()->taxes());
        }

        /* @var PriceContainer $collection */
        foreach ($this->_collections as $collection) {
            $collectionTaxes = $collection->taxes();

            $taxes->merge($collectionTaxes);
        }

        return $taxes;
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

        /* @var PriceContainer $collection */
        foreach ($this->_collections as $collection) {
            /* @var Price $price */
            foreach ($collection->prices() as $price) {
                $subtotal += $price->subTotal();
            }
        }

        return $subtotal;
    }

    /**
     * Gets or sets the base price
     *
     * @param Price|null $basePrice Base price
     *
     * @return $this|null
     */
    public function basePrice(Price $basePrice = null)
    {
        if (!$basePrice) {
            return $this->_basePrice;
        }

        $this->_basePrice = $basePrice;

        return $this;
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

    /**
     * Sets or gets the amount of time the price needs to be repeated
     *
     * @param float $repeat Amount of times to repeat
     *
     * @return $this|int
     */
    public function repeat($repeat = null)
    {
        if (is_null($repeat)) {
            return $this->_repeat;
        }

        $this->_repeat = $repeat;

        return $this;
    }

    /**
     * Returns useful debug data
     *
     * @return array
     */
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
