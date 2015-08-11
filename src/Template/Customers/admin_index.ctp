<?php

$this->extend('/Common/admin_index');

$this->set('displayFields', array(
    'name' => array(
        'label' => __d('webshop_payments_cash', 'Name'),
        'type' => 'string',
        'sort' => true,
        'url' => array(
            'action' => 'view',
            'pass' => array(
                'id'
            )
        )
    ),
    'type' => array(
        'label' => __d('webshop_payments_cash', 'Type'),
        'type' => 'string',
        'sort' => true
    ),
));
