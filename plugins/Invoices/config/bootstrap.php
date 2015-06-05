<?php

CroogoNav::add('sidebar', 'webshop.children.invoices', array(
	'title' => __d('webshop_invoices', 'Invoices'),
	'url' => array(
		'admin' => true,
		'plugin' => 'webshop_invoices',
		'controller' => 'invoices',
		'action' => 'index'
	),
));

CroogoNav::add('webshop-customer-dashboard', 'invoices', array(
	'title' => __d('webshop_invoices', 'Invoices'),
	'url' => array(
		'prefix' => 'panel',
		'plugin' => 'webshop_invoices',
		'controller' => 'invoices',
		'action' => 'index'
	),
));

Croogo::hookBehavior('Order', 'WebshopInvoices.InvoiceTemplate');

Croogo::hookHelper('*', 'WebshopInvoices.Invoices');
