<?php

namespace Webshop\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Croogo\Core\Controller\HookableComponentInterface;
use Croogo\Core\Controller\HookableComponentTrait;
use Croogo\Core\Croogo;
use Crud\Controller\Component\CrudComponent;
use Crud\Controller\ControllerTrait;

/**
 * @property CrudComponent Crud
 */
class AppController extends BaseController implements HookableComponentInterface
{

    use ControllerTrait;
    use HookableComponentTrait;

    /**
     * {@inheritDoc}
     */
    public function __construct($request, $response, $name)
    {
        parent::__construct($request, $response, $name);

        $this->eventManager()->dispatch(new Event('Controller.afterConstruct', $this));
    }

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        $this->dispatchBeforeInitialize();

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

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Controller.afterConstruct' => 'afterConstruct',
        ];
    }

    public function afterConstruct()
    {
        $this->viewBuilder()->helpers(Croogo::options('Hook.view_builder_options', $this, 'helpers'));
    }
}
