<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class CustomerContactsTable extends Table
{

    public $validate = [
        'name' => [
            'rule' => 'notEmpty',
        ],
    ];

    public $filterArgs = [
        'customer_id' => ['type' => 'value'],
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Search.Searchable');

        $this->belongsTo('Customers', [
            'className' => 'Webshop.Customers'
        ]);
    }
}
