<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Croogo\Core\CroogoRouter;

Router::prefix('admin', ['plugin' => 'Webshop'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->scope('/customers', ['controller' => 'Customers'], function (RouteBuilder $routeBuilder) {
        $routeBuilder->scope('/:customer_id', function (RouteBuilder $routeBuilder) {
            \Cake\Event\EventManager::instance()
                ->dispatch(new \Cake\Event\Event('Router.webshop_customers_nested', $routeBuilder));

            $routeBuilder->scope('/contacts', ['controller' => 'CustomerContacts'], function (RouteBuilder $routeBuilder) {
                $routeBuilder->connect('/', ['action' => 'index']);
                $routeBuilder->connect('/:action/*', []);
            });
            $routeBuilder->scope('/addresses', ['controller' => 'AddressDetails'], function (RouteBuilder $routeBuilder) {
                $routeBuilder->connect('/', ['action' => 'index']);
                $routeBuilder->connect('/:action/*', []);
            });
        });

        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
    $routeBuilder->scope('/products', ['controller' => 'Products'], function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
    $routeBuilder->scope('/configuration_groups', ['controller' => 'ConfigurationGroups'], function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
    $routeBuilder->scope('/configuration_options', ['controller' => 'ConfigurationOptions'], function (RouteBuilder $routeBuilder) {
        $routeBuilder->connect('/', ['action' => 'index']);
        $routeBuilder->connect('/:action/*', []);
    });
});
Router::prefix('panel', ['plugin' => 'Webshop', 'controller' => 'Customers'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->connect(
        '/',
        ['action' => 'dashboard'],
        ['_name' => 'panel_dashboard']
    );
    $routeBuilder->connect(
        '/select',
        ['action' => 'select'],
        ['_name' => 'panel_customers_select']
    );

    $routeBuilder->fallbacks();
});

CroogoRouter::contentType('product');
