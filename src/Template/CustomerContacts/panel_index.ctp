<?php

$this->extend('Webshop.Common/panel_index');

$this->set('displayFields', array(
    'name' => array(
        'label' => __d('webshop', 'Name'),
        'sort' => true
    )
));
