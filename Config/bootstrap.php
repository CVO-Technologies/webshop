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
		'products' => array(
			'title' => __d('webshop', 'Products'),
			'url' => array(
				'plugin' => 'webshop',
				'controller' => 'products',
				'action' => 'index',
			)
		),
		'configuration' => array(
			'title' => __d('webshop', 'Configuration'),
			'url' => '#',
		)
	)
));

Croogo::hookHelper('*', 'Webshop.Product');

//Croogo::hookBehavior('Node', 'Webshop.Product');

Configure::write('Webshop.customer_access_providers', array(

));

Croogo::mergeConfig('Routing.prefixes', array(
	'panel'
));

Croogo::hookComponent('*', 'Webshop.CustomerAccess');

Croogo::hookAdminTab('Products/admin_edit', 'Configuration implementation', 'Pltfrm.admin/node_webhosting_product_tab');
Croogo::hookAdminBox('Products/admin_edit', 'Configuration group', 'Webshop.admin/product/box_configuration_group_selector');

App::build(array(
	'CustomerAccessProvider' => array('%s' . 'CustomerAccessProvider' . DS)
), App::REGISTER);
