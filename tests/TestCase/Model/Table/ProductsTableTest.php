<?php

namespace Webshop\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Webshop\Model\Table\ProductsTable;

class ProductsTableTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.products'
    ];

    /**
     * @var ProductsTable
     */
    public $Products;

    public function setUp()
    {
        $this->Products = TableRegistry::get('Webshop.Products');

        parent::setUp();
    }

    public function testFindAll()
    {
        $this->assertEquals(1, $this->Products->find()->count());
    }

    public function tearDown()
    {
        unset($this->Products);
    }
}
