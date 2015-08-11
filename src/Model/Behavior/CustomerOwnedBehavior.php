<?php

namespace Webshop\Model\Behavior;

use Cake\ORM\Query;

class CustomerOwnedBehavior extends \Cake\ORM\Behavior
{

    public function findCustomer(Query $query, array $options)
    {
        return $query->where(['customer_id' => $options['customerId']]);
    }

    public function findOwnedByCustomer(Query $query, array $options)
    {
        return $query->where(['customer_id' => $options['customer']->id]);
    }

}
