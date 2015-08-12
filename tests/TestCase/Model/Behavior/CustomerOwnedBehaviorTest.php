<?php

namespace Webshop\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Webshop\Model\Entity\Customer;
use Webshop\Model\Table\CustomersTable;
use Webshop\Test\App\Model\Table\CustomerThingsTable;

class CustomerOwnedBehaviorTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.customers',
        'plugin.webshop.customer_things',
    ];

    /**
     * @var CustomersTable
     */
    public $Customers;

    /**
     * @var CustomerThingsTable
     */
    public $CustomerThings;

    public function setUp()
    {
        parent::setUp();

        $this->Customers = TableRegistry::get('Webshop.Customers');
        $this->CustomerThings = TableRegistry::get('CustomerThings');
    }

    public function testFindOwnedByCustomer()
    {
        $listOfThings = $this->CustomerThings->find('list')->find('ownedByCustomer', [
            'customer' => $this->Customers->get(1)
        ])->toArray();

        $this->assertEquals([
            1 => 'Some thing'
        ], $listOfThings);

        $listOfThings = $this->CustomerThings->find('list')->find('ownedByCustomer', [
            'customer' => $this->Customers->get(2)
        ])->toArray();

        $this->assertEquals([
            2 => 'Another thing'
        ], $listOfThings);
    }

    public function testFindCustomer()
    {
        $customer1 = $this->Customers->get(1);
        $customer2 = $this->Customers->get(2);

        $listOfThings = $this->CustomerThings->find('list')->find('customer', [
            'customerId' => $customer1->id
        ])->toArray();

        $this->assertEquals([
            1 => 'Some thing'
        ], $listOfThings);

        $listOfThings = $this->CustomerThings->find('list')->find('customer', [
            'customerId' => $customer2->id
        ])->toArray();

        $this->assertEquals([
            2 => 'Another thing'
        ], $listOfThings);
    }
}
