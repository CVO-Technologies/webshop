<?php

CroogoNav::add('', 'add-to-cart', array(
	'icon'  => array('comments', 'large'),
	'title' => __d('webshop', 'Add to cart'),
	'url'   => array(
		'plugin'     => 'webshop_shopping_cart',
		'controller' => 'shopping_cart',
		'action'     => 'add_product',
		'_id'
	)
));

CroogoNav::add('sidebar', 'webshop', array(
	'title' => __d('webshop', 'Webshop'),
	'url' => '#',
	'weight' => 30,
	'children' => array(
		'configuration' => array(
			'title' => __d('webshop', 'Configuration'),
			'url' => '#',
		)
	)
));

Configure::write('Webshop.customer_access_providers', array(

));

Croogo::mergeConfig('Routing.prefixes', array(
	'panel'
));

Croogo::hookComponent('*', 'Webshop.CustomerAccess');

App::build(array(
	'CustomerAccessProvider' => array('%s' . 'CustomerAccessProvider' . DS)
), App::REGISTER);
