<?php

namespace Webshop\CustomerAccessProvider;

use Cake\Controller\Controller;
use Cake\Core\App;

class CustomerAccessProvider
{

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
