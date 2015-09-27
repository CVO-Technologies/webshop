<?php

namespace Webshop\Controller;

use Croogo\Core\Controller\CroogoAppController;
use Crud\Controller\Component\CrudComponent;
use Crud\Controller\ControllerTrait;

/**
 * @property CrudComponent Crud
 */
class AppController extends CroogoAppController
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
        $this->loadComponent('Search.Prg', [
            'presetForm' => [
                'paramType' => 'querystring',
            ],
            'commonProcess' => [
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ],
        ]);

        $this->Crud->addListener('search', 'Search.Search');
    }
}
