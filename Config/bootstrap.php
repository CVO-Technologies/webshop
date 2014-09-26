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
