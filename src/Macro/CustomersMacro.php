<?php

namespace Webshop\Macro;

use Macro\Macro\Macro;

class CustomersMacro extends Macro
{

    /**
     * Returns the amount of customers
     *
     * @return int
     */
    public function amount()
    {
        return $this->Customers->find()->count();
    }
}
