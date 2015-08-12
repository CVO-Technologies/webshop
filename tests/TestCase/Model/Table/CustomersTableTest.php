<?php

namespace Webshop\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Webshop\Model\Table\CustomersTable;

class CustomersTableTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.customers'
    ];

    /**
     * @var CustomersTable
     */
    public $Customers;

    public function setUp()
    {
        $this->Customers = TableRegistry::get('Webshop.Customers');

        parent::setUp();
    }

    public function testFindAll()
    {
        $this->assertEquals(2, $this->Customers->find()->count());
    }

    public function tearDown()
    {
        unset($this->Customers);
    }
}
