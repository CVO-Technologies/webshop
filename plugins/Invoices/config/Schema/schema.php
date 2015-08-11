<?php

class AppSchema extends CakeSchema
{

    public $invoice_products = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
        'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
        'price' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
        'product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'tax_revision_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    public $invoice_shipping_costs = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
        'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
        'shipment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    public $invoice_transaction_costs = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
        'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
        'payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    public $invoices = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
        'number' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'type' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'status' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );

    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

}
