<?php

//CroogoRouter::connect('/paneel/bestellingen', array(
//	'panel' => true,
//	'locale' => 'nld',
//	'plugin' => 'webshop_orders',
//	'controller' => 'orders',
//	'action' => 'index'
//));
//
//CroogoRouter::connect('/paneel/bestellingen/:action/*', array(
//	'panel' => true,
//	'locale' => 'nld',
//	'plugin' => 'webshop_orders',
//	'controller' => 'orders'
//));

//CroogoRouter::connect('/panel/orders', array(
//	'panel' => true,
//	'plugin' => 'webshop_orders',
//	'controller' => 'orders',
//	'action' => 'index'
//));
//
use Croogo\Core\CroogoRouter;

CroogoRouter::connect('/admin/orders/:action/*', array(
    'prefix' => 'admin',
    'plugin' => 'Webshop/Orders',
    'controller' => 'Orders'
));

CroogoRouter::connect('/panel/orders/:action/*', array(
	'prefix' => 'panel',
	'plugin' => 'Webshop/Orders',
	'controller' => 'Orders'
));
