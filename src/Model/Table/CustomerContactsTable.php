<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;

class CustomerContactsTable extends Table
{

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
        ),
    );

    public $filterArgs = array(
        'customer_id' => array('type' => 'value'),
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Search.Searchable');

        $this->belongsTo('Customers', [
           'className' => 'Webshop.Customers'
        ]);
    }


}
