<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class AddressDetailsTable extends Table
{

    public $validate = array(
        'address_line_1' => array(
            'rule' => 'notEmpty',
        ),
        'city' => array(
            'rule' => 'notEmpty',
        ),
        'country' => array(
            'rule' => 'notEmpty',
        ),
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Customers', [
           'className' => 'Webshop.Customers'
        ]);
        $this->addBehavior('Webshop.CustomerOwned');
    }


}
