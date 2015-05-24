<?php

CroogoRouter::contentType('product');

CroogoRouter::connect('/panel', array('panel' => true, 'plugin' => 'webshop', 'controller' => 'customers', 'action' => 'dashboard'));
