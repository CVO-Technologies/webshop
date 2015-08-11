<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class CustomersTable extends Table
{

    public $validate = [
        'name' => [
            'rule' => 'notEmpty',
        ],
        'type' => [
            'rule' => ['inList', ['individual', 'company']],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('FinancialContacts', [
            'className' => 'Webshop.CustomerContacts',
        ]);
        $this->belongsTo('InvoiceAddressDetails', [
            'className' => 'Webshop.AddressDetails',
        ]);

        $this->hasMany('CustomerContacts', [
            'className' => 'Webshop.CustomerContacts',
        ]);
        $this->hasMany('AddressDetails', [
            'className' => 'Webshop.AddressDetails',
        ]);
    }
}
