<?php

namespace Webshop\Test;

use Cake\TestSuite\TestCase;
use Webshop\Price;
use Webshop\PriceContainer;

class PriceContainerTest extends TestCase
{

    /**
     * Tests the construct method on the container
     *
     * @return void
     */
    public function testStaticConstruct()
    {
        $priceContainer = PriceContainer::construct();

        $this->assertInstanceOf('\Webshop\PriceContainer', $priceContainer);
        $this->assertCount(0, $priceContainer->prices());
    }

    /**
     * Tests the add method
     *
     * @return void
     */
    public function testAddMethod()
    {
        $priceContainer = PriceContainer::construct();

        $this->assertInstanceOf('\Webshop\PriceContainer', $priceContainer->add(Price::fromDirectInput(2)));
        $this->assertCount(1, $priceContainer->prices());

        $this->assertInstanceOf('\Webshop\PriceContainer', $priceContainer->add(Price::fromDirectInput(4)));
        $this->assertCount(2, $priceContainer->prices());
    }

    /**
     * Tests the taxes method with multiple taxes
     */
    public function testTaxesMethod()
    {
        $priceContainer = PriceContainer::construct();

        $price1 = Price::fromDirectInput(5);
        $price1->addVat(21);
        $priceContainer->add($price1);

        $price2 = Price::fromDirectInput(10);
        $price2->addVat(6);
        $priceContainer->add($price2);

        $price3 = Price::fromDirectInput(15);
        $price3->addVat(6);
        $priceContainer->add($price3);

        $calculatedVat = $priceContainer->taxes()->vat();

        $this->assertArrayHasKey(21, $calculatedVat);
        $this->assertEquals(1.05, $calculatedVat[21]);

        $this->assertArrayHasKey(6, $calculatedVat);
        $this->assertEquals(1.5, $calculatedVat[6]);
    }

    /**
     * Tests the debug info method
     *
     * @return void
     */
    public function testDebugInfo()
    {
        $priceContainer = PriceContainer::construct();

        $this->assertInternalType('array', $priceContainer->__debugInfo());
        $this->assertArrayHasKey('prices', $priceContainer->__debugInfo());
        $this->assertArrayHasKey('taxes', $priceContainer->__debugInfo());
    }
}
