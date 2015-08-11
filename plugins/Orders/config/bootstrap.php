<?php

use Croogo\Core\Croogo;
use Croogo\Core\Nav;

Nav::add('sidebar', 'webshop.children.orders', array(
    'title' => __d('webshop_orders', 'Orders'),
    'url' => array(
        'prefix' => 'admin',
        'plugin' => 'Webshop/Orders',
        'controller' => 'Orders',
        'action' => 'index'
    ),
));

Nav::add('webshop-customer-dashboard', 'orders', array(
    'title' => __d('webshop_orders', 'Orders'),
    'url' => array(
        'prefix' => 'panel',
        'plugin' => 'Webshop/Orders',
        'controller' => 'Orders',
        'action' => 'index'
    ),
));

Nav::add('webshop-dashboard-order-actions', 'view', array(
    'title' => __d('webshop_orders', 'View'),
    'url' => array(
        'controller' => 'Orders',
        'action' => 'view',
        '_id'
    ),
    'htmlAttributes' => array(
        'class' => 'btn-primary'
    )
));

Nav::add('webshop-dashboard-order-actions', 'pay', array(
    'title' => __d('webshop_orders', 'Pay'),
    'url' => array(
        'controller' => 'Orders',
        'action' => 'pay',
        '_id'
    ),
    'htmlAttributes' => array(
        'class' => 'btn-success'
    )
));

Croogo::hookHelper('*', 'Webshop/Orders.Orders');

Croogo::hookAdminTab('Customers/admin_view', __d('webshop_orders', 'Orders'), 'WebshopOrders.admin/tab/orders');
