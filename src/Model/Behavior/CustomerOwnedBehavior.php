<?php

namespace Webshop\Model\Behavior;

use Cake\ORM\Query;

class CustomerOwnedBehavior extends \Cake\ORM\Behavior
{

    /**
     * @param Query $query Query to adjust
     * @param array $options Options to use
     *
     * @return Query
     */
    public function findCustomer(Query $query, array $options)
    {
        return $query->where(['customer_id' => $options['customerId']]);
    }

    /**
     * @param Query $query Query to adjust
     * @param array $options Options to use
     *
     * @return Query
     */
    public function findOwnedByCustomer(Query $query, array $options)
    {
        return $query->where(['customer_id' => $options['customer']->id]);
    }
}
