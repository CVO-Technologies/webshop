<?php
class InitialDatabaseVersion extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Initial_database_version';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'order_payments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'order_id' => array('column' => 'order_id', 'unique' => 0),
						'payment_id' => array('column' => 'payment_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'order_product_options' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'order_product_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'configuration_option_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'configuration_option_item_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'price' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'order_products' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'order_shipment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'amount' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'price' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
					'status' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'tax_revision_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'order_id' => array('column' => 'order_id', 'unique' => 0),
						'product_id' => array('column' => 'product_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'order_shipments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'shipment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'orders' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'number' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'status' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
					'remaining' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
					'shipping_method_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'order_payments', 'order_product_options', 'order_products', 'order_shipments', 'orders'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
