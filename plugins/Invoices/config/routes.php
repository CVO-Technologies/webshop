<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', ['plugin' => 'Webshop/Invoices', 'controller' => 'Invoices'], function (RouteBuilder $routeBuilder) {

    $routeBuilder->scope('/invoices', function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
});
Router::prefix('panel', ['plugin' => 'Webshop/Invoices', 'controller' => 'Invoices'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->scope('/invoices', function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
});
