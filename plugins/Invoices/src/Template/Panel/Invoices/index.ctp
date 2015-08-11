<?php
$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->setPageTitle(__d('webshop_invoices', 'Invoices'));

$this->Title->addCrumbs(array(
    array('controller' => 'customers', 'action' => 'dashboard'),
    array('action' => 'index')
));

$this->extend('Webshop./Common/panel_index');

$this->start('actions');
$this->end();

$this->set('displayFields', array(
    'number' => array(
        'label' => __d('webshop_invoices', 'Number'),
        'sort' => true,
        'url' => array(
            'action' => 'view',
            'pass' => array(
                'id'
            )
        )
    ),
    'status' => array(
        'label' => __d('webshop_invoices', 'Status'),
        'sort' => true
    ),
    'created' => array(
        'label' => __d('webshop_invoices', 'Created'),
        'sort' => true
    )
));
