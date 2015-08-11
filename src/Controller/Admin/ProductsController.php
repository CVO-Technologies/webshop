<?php

namespace Webshop\Controller\Admin;

use Croogo\Core\Controller\CroogoAppController;
use Crud\Controller\ControllerTrait;

class ProductsController extends CroogoAppController
{

    use ControllerTrait;

    /**
     * {@inheritDoc}
     */
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
