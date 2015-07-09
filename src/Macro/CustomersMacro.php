<?php

namespace Webshop\Macro;

use Macro\Macro\Macro;

class CustomersMacro extends Macro
{

    public function amount()
    {
        return $this->Customers->find()->count();
    }

}
