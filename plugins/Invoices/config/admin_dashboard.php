<?php

use Croogo\Dashboards\CroogoDashboard;

$config = array(
	'WebshopInvoices.outstanding_invoices' => array(
		'title' => __d('webshop_invoices', 'Outstanding invoices'),
		'element' => 'Webshop/Invoices.admin/dashboard/outstanding_invoices',
		'column' => CroogoDashboard::LEFT,
	),
);
