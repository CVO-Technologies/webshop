<?php

//region Menu's
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Croogo\Core\Croogo;
use Croogo\Core\Nav;

function addWebshopPluginPath($basePluginName) {
    $pluginPaths = Configure::read('plugins');
    $pluginPaths['Webshop/' . $basePluginName] = $pluginPaths['Webshop'] . 'plugins' . DS . $basePluginName . DS;

    Configure::write('plugins', $pluginPaths);
}

addWebshopPluginPath('Invoices');

Nav::add('sidebar', 'webshop', array(
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

Nav::add('sidebar', 'settings.children.webshop', array(
	'title' => __d('webshop', 'Webshop'),
	'url' => '#',
));

Nav::add('webshop-dashboard-address_details-actions', 'edit', array(
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
Nav::add('webshop-dashboard-customer_contacts-actions', 'edit', array(
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
Croogo::hookBehavior('Croogo/Nodes.Nodes', 'Webshop.Announcements');

if (Plugin::loaded('Sites')) {
    Croogo::hookBehavior('Webshop.Products', 'Sites.SiteFilter', array(
        'relationship' => array(
            'belongsToMany' => array(
                'Sites' => array(
                    'className' => 'Sites.Sites',
                    'through' => 'Sites.SitesNodes',
                    'foreignKey' => 'node_id',
                    'targetForeignKey' => 'site_id',
                    'unique' => 'keepExisting',
                ),
            ),
        ),
    ));
}
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

if (Plugin::loaded('Sites')) {
    Croogo::hookAdminTab('Admin/Products/add', __d('sites', 'Sites'), 'Sites.sites_selection');
    Croogo::hookAdminTab('Admin/Products/edit', __d('sites', 'Sites'), 'Sites.sites_selection');
}
//endregion

//region Admin hooks
Croogo::hookAdminBox('Products/admin_edit', 'Configuration group', 'Webshop.admin/product/box_configuration_group_selector');
//endregion

//endregion
