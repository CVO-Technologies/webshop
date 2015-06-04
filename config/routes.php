<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Croogo\Croogo\CroogoRouter;

Router::prefix('admin', function (RouteBuilder $routeBuilder) {
   $routeBuilder->plugin('Webshop', function (RouteBuilder $routeBuilder) {
      $routeBuilder->fallbacks();
   });
});

CroogoRouter::contentType('product');

CroogoRouter::connect('/panel', array('prefix' => 'panel', 'plugin' => 'Webshop', 'controller' => 'Customers', 'action' => 'dashboard'));
