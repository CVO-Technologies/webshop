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

Croogo::hookHelper('*', 'WebshopOrders.Order');
