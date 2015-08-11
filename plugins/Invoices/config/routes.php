<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Croogo\Core\CroogoRouter;

Router::prefix('admin', function (RouteBuilder $routeBuilder) {
    $routeBuilder->plugin('Webshop/Invoices', function (RouteBuilder $routeBuilder) {
        $routeBuilder->fallbacks();
    });
});
Router::prefix('panel', function (RouteBuilder $routeBuilder) {
    $routeBuilder->plugin('Webshop/Invoices', function (RouteBuilder $routeBuilder) {
        $routeBuilder->fallbacks();
    });
});

CroogoRouter::connect('/panel/invoices', array(
    'prefix' => 'panel',
    'plugin' => 'Webshop/Invoices',
    'controller' => 'Invoices',
    'action' => 'index'
));

CroogoRouter::connect('/panel/invoices/:action/*', array(
    'prefix' => 'panel',
    'plugin' => 'Webshop/Invoices',
    'controller' => 'Invoices'
));
