<?php

namespace Webshop\Test;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use Webshop\Price;
use Webshop\PriceContainer;

class PriceTest extends TestCase
{

    /**
     * Tests the static directInput method
     *
     * @return void
     */
    public function testStaticFromDirectInput()
    {
        $this->assertEquals(5.7, Price::fromDirectInput(5.7)->total());
    }

    /**
     * Tests the empty price method
     *
     * @return void
     */
    public function testStaticEmpty()
    {
        $this->assertTrue(Price::emptyPrice()->emptyMark());
    }

    /**
     * Tests the create method
     *
     * @return void
     */
    public function testStaticCreate()
    {
        $this->assertInstanceOf('\Webshop\Price', Price::create());
    }

    /**
     * Tests price creation from a collection
     *
     * @return void
     */
    public function testStaticCreateFromCollection()
    {
        $container = PriceContainer::construct();
        $container->add(Price::fromDirectInput(1.5));
        $container->add(Price::fromDirectInput(1.5));
        $container->add(Price::fromDirectInput(2));

        $this->assertEquals(5, Price::createFromCollection($container)->total());
    }

    /**
     * Tests setting and getting a subject
     *
     * @return void
     */
    public function testSubject()
    {
        $entity = new Entity;

        $price = Price::create();

        $this->assertInstanceOf('\Webshop\Price', $price->subject($entity));
        $this->assertEquals($entity, $price->subject());
    }

    /**
     * Test the taxes method with one tax
     *
     * @return void
     */
    public function testTaxesOneTax()
    {
        $price = Price::fromDirectInput(5);
        $price->addVat(21);

        $this->assertEquals(1.05, $price->taxes()->calculated());
    }

    /**
     * Test the taxes method with multiple taxes
     *
     * @return void
     */
    public function testTaxesMultiple()
    {
        $price = Price::fromDirectInput(5);
        $price->addVat(21);
        $price->addVat(6);

        $this->assertEquals(1.3500000000000001, $price->taxes()->calculated());
    }

    /**
     * Tests repeating of a price
     *
     * @return void
     */
    public function testRepeat()
    {
        $price = Price::fromDirectInput(10);

        $price->repeat(5);

        $this->assertEquals(50, $price->total());
    }

    /**
     * Tests using a base price
     *
     * @return void
     */
    public function testBasePrice()
    {
        $container = PriceContainer::construct();
        $container->add(Price::fromDirectInput(1.5));
        $container->add(Price::fromDirectInput(1.5));
        $container->add(Price::fromDirectInput(2));

        $price = Price::createFromCollection($container);

        $this->assertInstanceOf('\Webshop\Price', $price->basePrice(Price::fromDirectInput(10)));
        $this->assertEquals(15, $price->total());
    }

    /**
     * Tests if an empty returns a total of 0
     *
     * @return void
     */
    public function testEmptyTotal()
    {
        $price = Price::emptyPrice();

        $this->assertEquals(0, $price->total());
    }

    /**
     * Makes sure there is a difference between the subtotal and total
     *
     * @return void
     */
    public function testSubTotalDifference()
    {
        $price = Price::fromDirectInput(5);
        $price->addVat(21);

        $this->assertEquals(5, $price->subTotal());
        $this->assertEquals(6.0499999999999998, $price->total());
    }

    /**
     * Basic debug info checks
     *
     * @return void
     */
    public function testDebugInfo()
    {
        $price = Price::create();

        $this->assertInternalType('array', $price->__debugInfo());
        $this->assertArrayHasKey('collections', $price->__debugInfo());
    }

    /**
     * Basis debug info with direct input
     *
     * @return void
     */
    public function testDebugInfoDirectInput()
    {
        $price = Price::fromDirectInput(10);

        $this->assertArrayHasKey('directInput', $price->__debugInfo());
    }

    /**
     * Basis debug info with empty price
     *
     * @return void
     */
    public function testDebugInfoEmpty()
    {
        $price = Price::emptyPrice();

        $this->assertArrayHasKey('markedEmpty', $price->__debugInfo());
        $this->assertTrue($price->__debugInfo()['markedEmpty']);
    }
}
