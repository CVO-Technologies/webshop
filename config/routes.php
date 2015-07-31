<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Croogo\Core\CroogoRouter;

Router::prefix('admin', function (RouteBuilder $routeBuilder) {
    $routeBuilder->plugin('Webshop', function (RouteBuilder $routeBuilder) {
        $routeBuilder->fallbacks();
    });
});
Router::prefix('panel', function (RouteBuilder $routeBuilder) {
    $routeBuilder->connect(
        '/',
        ['plugin' => 'Webshop', 'controller' => 'Customers', 'action' => 'dashboard'],
        ['_name' => 'panel_dashboard']
    );
    $routeBuilder->plugin('Webshop', function (RouteBuilder $routeBuilder) {
        $routeBuilder->fallbacks('DashedRoute');
    });
});

CroogoRouter::contentType('product');
