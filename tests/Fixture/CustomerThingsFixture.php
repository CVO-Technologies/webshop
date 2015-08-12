<?php

namespace Webshop\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CustomerThingsFixture extends TestFixture
{

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'name' => ['type' => 'string', 'null' => false, 'default' => null],
        'customer_id' => ['type' => 'integer', 'null' => true, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public $records = [
        [
            'id' => 1,
            'name' => 'Some thing',
            'customer_id' => 1
        ],
        [
            'id' => 2,
            'name' => 'Another thing',
            'customer_id' => 2
        ]
    ];
}
