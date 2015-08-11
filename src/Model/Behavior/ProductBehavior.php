<?php

// @codingStandardsIgnoreStart

class ProductBehavior extends ModelBehavior
{

    public function setup(Model $Model, $config = array())
    {
        $Model->bindModel(array(
            'belongsTo' => array(
                'Product' => array(
                    'className' => 'Webshop.Product',
                    'foreignKey' => 'id'
                )
            )
        ), false);
    }

}
