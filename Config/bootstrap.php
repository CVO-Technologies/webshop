<?php

CroogoNav::add('sidebar', 'webshop.children.orders', array(
	'title' => __d('webshop_orders', 'Orders'),
	'url' => array(
		'admin' => true,
		'plugin' => 'webshop_orders',
		'controller' => 'orders',
		'action' => 'index'
	),
));

CroogoNav::add('webshop-customer-dashboard', 'orders', array(
	'title' => __d('webshop_orders', 'Orders'),
	'url' => array(
		'prefix' => 'panel',
		'plugin' => 'webshop_orders',
		'controller' => 'orders',
		'action' => 'index'
	),
));

CroogoNav::add('webshop-dashboard-order-actions', 'view', array(
	'title' => __d('webshop_orders', 'View'),
	'url' => array(
		'controller' => 'orders',
		'action' => 'view',
		'_id'
	),
	'htmlAttributes' => array(
		'class' => 'btn-primary'
	)
));

CroogoNav::add('webshop-dashboard-order-actions', 'pay', array(
	'title' => __d('webshop_orders', 'Pay'),
	'url' => array(
		'controller' => 'orders',
		'action' => 'pay',
		'_id'
	),
	'htmlAttributes' => array(
		'class' => 'btn-success'
	)
));

Croogo::hookHelper('*', 'WebshopOrders.Order');
