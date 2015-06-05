<?php

use Croogo\Croogo\Croogo;
use Croogo\Croogo\CroogoNav;

CroogoNav::add('sidebar', 'webshop.children.invoices', array(
	'title' => __d('webshop_invoices', 'Invoices'),
	'url' => array(
		'admin' => true,
		'plugin' => 'Webshop/Invoices',
		'controller' => 'Invoices',
		'action' => 'index'
	),
));

CroogoNav::add('webshop-customer-dashboard', 'invoices', array(
	'title' => __d('webshop_invoices', 'Invoices'),
	'url' => array(
		'prefix' => 'panel',
		'plugin' => 'Webshop/Invoices',
		'controller' => 'Invoices',
		'action' => 'index'
	),
));

Croogo::hookBehavior('Order', 'Webshop/Invoices.InvoiceTemplate');

Croogo::hookHelper('*', 'Webshop/Invoices.Invoices');
