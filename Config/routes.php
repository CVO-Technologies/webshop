<?php

CroogoRouter::connect('/paneel/bestellingen', array(
	'panel' => true,
	'locale' => 'nld',
	'plugin' => 'webshop_orders',
	'controller' => 'orders',
	'action' => 'index'
));

CroogoRouter::connect('/paneel/bestellingen/:action/*', array(
	'panel' => true,
	'locale' => 'nld',
	'plugin' => 'webshop_orders',
	'controller' => 'orders'
));

CroogoRouter::connect('/panel/orders', array(
	'panel' => true,
	'plugin' => 'webshop_orders',
	'controller' => 'orders',
	'action' => 'index'
));

CroogoRouter::connect('/panel/orders/:action/*', array(
	'panel' => true,
	'plugin' => 'webshop_orders',
	'controller' => 'orders'
));
