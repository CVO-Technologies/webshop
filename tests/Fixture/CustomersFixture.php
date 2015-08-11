<?php

namespace Webshop\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CustomersFixture extends TestFixture
{

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'name' => ['type' => 'string', 'null' => false, 'default' => null],
        'type' => ['type' => 'string', 'null' => false, 'default' => null],
        'vat_number' => ['type' => 'string', 'null' => true, 'default' => null],
        'financial_contact_id' => ['type' => 'integer', 'null' => true, 'default' => null],
        'invoice_address_detail_id' => ['type' => 'integer', 'null' => true, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public $records = [
        [
            'id' => 1,
            'name' => 'Marlin Cremers',
            'type' => 'individual',
            'vat_number' => null,
            'financial_contact_id' => null,
            'invoice_address_detail_id' => null
        ],
        [
            'id' => 2,
            'name' => 'CVO-Technologies',
            'type' => 'company',
            'vat_number' => 'NL853785673B01',
            'financial_contact_id' => null,
            'invoice_address_detail_id' => null
        ]
    ];
}
