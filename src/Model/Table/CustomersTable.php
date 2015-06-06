<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class CustomersTable extends Table
{

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
        ),
        'type' => array(
            'rule' => array('inList', array('individual', 'company')),
        ),
    );

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
