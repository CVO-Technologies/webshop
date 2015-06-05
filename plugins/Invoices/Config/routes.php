<?php

CroogoRouter::connect('/panel/invoices', array(
	'panel' => true,
	'plugin' => 'webshop_invoices',
	'controller' => 'invoices',
	'action' => 'index'
));

CroogoRouter::connect('/panel/invoices/:action/*', array(
	'panel' => true,
	'plugin' => 'webshop_invoices',
	'controller' => 'invoices'
));
