<?php

use Cake\Event\Event;
use Cake\Routing\RouteBuilder;
use Croogo\Core\Croogo;
use Croogo\Core\Nav;

Nav::add('sidebar', 'webshop.children.invoices', array(
    'title' => __d('webshop_invoices', 'Invoices'),
    'url' => array(
        'prefix' => 'admin',
        'plugin' => 'Webshop/Invoices',
        'controller' => 'Invoices',
        'action' => 'index'
    ),
));

Nav::add('webshop-customer-dashboard', 'invoices', array(
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

Croogo::hookAdminTab('Admin/Customers/view', __d('webshop_invoices', 'Invoices'), 'Webshop/Invoices.admin/tab/customer_invoices');

\Cake\Event\EventManager::instance()->on('Router.webshop_customers_nested', function (Event $event) {
    /* @var RouteBuilder $routeBuilder */
    $routeBuilder = $event->subject();

    $routeBuilder->scope('/invoices', ['plugin' => 'Webshop/Invoices', 'controller' => 'Invoices'], function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
});
