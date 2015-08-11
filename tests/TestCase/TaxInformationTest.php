<?php

namespace Webshop\Test;

use Cake\TestSuite\TestCase;
use Webshop\TaxInformation;

class TaxInformationTest extends TestCase
{

    /**
     * Test calculate method
     *
     * @return void
     */
    public function testCalculate()
    {
        $taxInformation = new TaxInformation;
        $taxInformation->addVat(21);

        $taxInformation->calculate(10);

        $vat = $taxInformation->vat();

        $this->assertArrayHasKey(21, $vat);
        $this->assertEquals(2.1, $vat[21]);
    }

    /**
     * Test the merge button
     *
     * @return void
     */
    public function testMerge()
    {
        $taxInformation = new TaxInformation;

        $taxInformation1 = new TaxInformation;
        $taxInformation1->addVat(21);
        $taxInformation1->calculate(10);
        $taxInformation->merge($taxInformation1);

        $taxInformation2 = new TaxInformation;
        $taxInformation2->addVat(6);
        $taxInformation2->calculate(10);
        $taxInformation->merge($taxInformation2);

        $vat = $taxInformation->vat();

        $this->assertArrayHasKey(21, $vat);
        $this->assertEquals(2.1, $vat[21]);

        $this->assertArrayHasKey(6, $vat);
        $this->assertEquals(0.6, $vat[6]);
    }

    /**
     * Test calculated method
     *
     * @return void
     */
    public function testCalculated()
    {
        $taxInformation = new TaxInformation;
        $taxInformation->addVat(21);
        $taxInformation->addVat(6);

        $taxInformation->calculate(10);

        $this->assertEquals(2.7000000000000002, $taxInformation->calculated());
    }

    /**
     * Test the debug info
     *
     * @return void
     */
    public function testDebugInfo()
    {
        $taxInformation = new TaxInformation;

        $this->assertInternalType('array', $taxInformation->__debugInfo());
    }
}
