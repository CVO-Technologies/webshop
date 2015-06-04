<?php

//region Menu's
use Cake\Core\Configure;
use Cake\Routing\Router;
use Croogo\Croogo\Croogo;
use Croogo\Croogo\CroogoNav;

CroogoNav::add('sidebar', 'webshop', array(
	'title' => __d('webshop', 'Webshop'),
	'url' => '#',
	'weight' => 30,
	'children' => array(
		'customers' => array(
			'title' => __d('webshop', 'Customers'),
			'url' => array(
				'plugin' => 'Webshop',
				'controller' => 'Customers',
				'action' => 'index',
			)
		),
		'products' => array(
			'title' => __d('webshop', 'Products'),
			'url' => array(
				'plugin' => 'Webshop',
				'controller' => 'Products',
				'action' => 'index',
			)
		),
		'Configuration groups' => array(
			'title' => __d('webshop', 'Configuration groups'),
			'url' => array(
				'plugin' => 'Webshop',
				'controller' => 'ConfigurationGroups',
				'action0' => 'index',
			)
		),
		'Configuration options' => array(
			'title' => __d('webshop', 'Configuration options'),
			'url' => array(
				'plugin' => 'Webshop',
				'controller' => 'ConfigurationOptions',
				'action' => 'index',
			)
		),
		'configuration' => array(
			'title' => __d('webshop', 'Configuration'),
			'url' => '#',
		)
	)
));

CroogoNav::add('sidebar', 'settings.children.webshop', array(
	'title' => __d('webshop', 'Webshop'),
	'url' => '#',
));

CroogoNav::add('webshop-dashboard-address_details-actions', 'edit', array(
	'title' => __d('webshop', 'Edit'),
	'url' => array(
		'controller' => 'address_details',
		'action' => 'edit',
		'_id'
	),
	'htmlAttributes' => array(
		'class' => 'btn-primary'
	)
));
CroogoNav::add('webshop-dashboard-customer_contacts-actions', 'edit', array(
	'title' => __d('webshop', 'Edit'),
	'url' => array(
		'controller' => 'customer_contacts',
		'action' => 'edit',
		'_id'
	),
	'htmlAttributes' => array(
		'class' => 'btn-primary'
	)
));

//endregion

//region Helpers
Croogo::hookHelper('*', 'Webshop.Product');
Croogo::hookHelper('*', 'Webshop.ConfigurationOption');
Croogo::hookHelper('*', 'Webshop.Webshop');
//endregion

//region Behaviors
Croogo::hookBehavior('Node', 'Webshop.Product');
//endregion

//region Components
Croogo::hookComponent('*', 'Webshop.CustomerAccess');
//endregion

Configure::write('Webshop.customer_access_providers', array(

));

Croogo::mergeConfig('Translate.models.ConfigurationOption', array(
		'fields' => array(
				'name' => 'nameTranslation',
		),
		'translateModel' => 'Webshop.ConfigurationOption',
));

//region Panel prefix setup
Croogo::mergeConfig('Routing.prefixes', array(
	'panel'
));

Router::reload();
//endregion

//region Admin panels

//region Admin tabs
Croogo::hookAdminTab('Products/admin_edit', 'Configuration implementation', 'Pltfrm.admin/node_webhosting_product_tab');
//endregion

//region Admin hooks
Croogo::hookAdminBox('Products/admin_edit', 'Configuration group', 'Webshop.admin/product/box_configuration_group_selector');
//endregion

//endregion
