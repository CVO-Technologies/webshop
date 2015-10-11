<?php

namespace Webshop\CustomerAccessProvider;

use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\Locator\LocatorAwareTrait;

class CustomerAccessProvider
{

    use ModelAwareTrait;
    use LocatorAwareTrait;

    /**
     * Constructs the access provider and sets up the model factory
     */
    public function __construct()
    {
        $this->modelFactory('Table', [$this->tableLocator(), 'get']);

        $this->initialize();
    }

    /**
     * Gets a customer access provider
     *
     * @param string $class CustomerAccessProvider to get
     *
     * @return CustomerAccessProvider
     */
    public static function get($class)
    {
        $class = App::className($class, 'CustomerAccessProvider', 'AccessProvider');

        return new $class;
    }

    /**
     * Initialize the customer access provider
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Returns an array of ids of accessible customers
     *
     * @param Controller $Controller Controller to use to get accessible customers
     *
     * @return bool|array Either a array of accessible customers or false in case of an error
     */
    public function getAccessibleCustomers(Controller $Controller)
    {
        return false;
    }
}
