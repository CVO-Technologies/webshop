<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class AddressDetailsTable extends Table
{

    public $validate = [
        'address_line_1' => [
            'rule' => 'notEmpty',
        ],
        'city' => [
            'rule' => 'notEmpty',
        ],
        'country' => [
            'rule' => 'notEmpty',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Customers', [
            'className' => 'Webshop.Customers'
        ]);
        $this->addBehavior('Webshop.CustomerOwned');
    }
}
