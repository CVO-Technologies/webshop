<?php

class ProductConfigurationGroup extends AppModel
{

    public $belongsTo = array(
        'Product' => array(
            'className' => 'Webshop.Product'
        ),
        'ConfigurationGroup' => array(
            'className' => 'Webshop.ConfigurationGroup'
        )
    );

    public $hasMany = array(
//		'ProductConfigurationOption' => array(
//			'className' => 'Webshop.ProductConfigurationOption'
//		)
    );

}
