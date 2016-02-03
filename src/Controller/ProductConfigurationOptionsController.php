<?php

namespace Webshop\Controller;

use Croogo\Core\Controller\AppController as CroogoAppController;

class ProductConfigurationOptionsController extends CroogoAppController
{

    public function product($id)
    {
        return $this->ProductConfigurationOption->find('all', array(
            'conditions' => array(
                'ProductConfigurationOption.product_id' => $id
            ),
            'contain' => array(
                'ConfigurationOption'
            ),
            'recursive' => 1
        ));
    }

}
