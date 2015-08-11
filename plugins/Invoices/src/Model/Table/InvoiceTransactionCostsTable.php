<?php

class InvoiceTransactionCost extends AppModel
{

    public $belongsTo = array(
        'Invoice' => array(
            'className' => 'WebshopInvoices.Invoice',
            'foreignKey' => 'invoice_id'
        ),
        'Payment' => array(
            'className' => 'WebshopPayments.Payment',
            'foreignKey' => 'payment_id'
        )
    );

}
