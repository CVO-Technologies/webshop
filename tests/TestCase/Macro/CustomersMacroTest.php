<?php

namespace Webshop\TestCase\Macro;

use Cake\TestSuite\TestCase;
use Macro\Macro\MacroRegistry;
use Webshop\Macro\CustomersMacro;

class CustomersMacroTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.customers'
    ];

    /**
     * @var CustomersMacro
     */
    public $macro;

    /**
     * @var MacroRegistry
     */
    protected $_registry;

    public function setUp()
    {
        parent::setUp();

        $this->_registry = new MacroRegistry;
        $this->macro = new CustomersMacro($this->_registry);
    }

    /**
     * Tests that the customer count is correct
     *
     * @return void
     */
    public function testCount()
    {
        $this->assertEquals(2, $this->macro->amount());
    }
}
