<?php

namespace Webshop\Controller\Admin;

use Croogo\Croogo\Controller\CroogoAppController;
use Crud\Controller\ControllerTrait;

class ProductsController extends CroogoAppController
{

    use ControllerTrait;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'add' => [
                    'className' => 'Crud.Add',
                    'view' => 'form'
                ],
                'edit' => [
                    'className' => 'Crud.Edit',
                    'view' => 'form'
                ],
                'Crud.View',
                'Crud.Delete'
            ]
        ]);
    }


}
