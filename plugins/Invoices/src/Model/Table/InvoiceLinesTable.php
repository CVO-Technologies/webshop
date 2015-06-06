<?php

namespace Webshop\Invoices\Model\Table;

use Cake\ORM\Table;

class InvoiceLinesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Invoices', [
           'className' => 'Webshop/Invoices.Invoices',
        ]);
        $this->belongsTo('Products', [
            'className' => 'Webshop.Products',
        ]);
        $this->belongsTo('TaxRevisions', [
            'className' => 'Webshop.TaxRevisions',
        ]);
    }

}
