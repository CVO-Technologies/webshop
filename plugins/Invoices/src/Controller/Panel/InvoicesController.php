<?php

namespace Webshop\Invoices\Controller\Panel;

use Croogo\Core\Controller\CroogoAppController;
use Webshop\Invoices\Model\Table\InvoicesTable;

/**
 * @property InvoicesTable Invoices
 */
class InvoicesController extends CroogoAppController
{

    public $helpers = [
        'SocialSeo.Title'
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
    }


    public function index()
    {
        $query = $this->Invoices->find('customer', [
            'customerId' => $this->CustomerAccess->getCustomerId($this)
        ]);
        $invoices = $this->Paginator->paginate($query);

        $this->set(compact('invoices'));
    }

    public function view($id)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => [
                'Customers' => [
                    'FinancialContacts'
                ],
                'AddressDetails',
                'InvoiceLines' => [
//                    'TaxRevisions'
                ]
            ]
        ]);
//        debug($invoice);exit();
//        $invoice = $this->Invoices->find('first', array(
//            'conditions' => array(
//                'Invoice.id' => $id,
//                'Invoice.customer_id' => $this->CustomerAccess->getCustomerId()
//            ),
//            'contain' => array(
//                'Customer',
//                'AddressDetail',
//                'InvoiceLine' => array(
//                    'TaxRevision'
//                )
//            )
//        ));
//        if (!$invoice) {
//            throw new NotFoundException();
//        }

        $this->set(compact('invoice'));
        $this->set('_serialize', array('invoice'));
    }

    public function get_prices($id)
    {
        return $this->Invoice->getPrices($id);
    }

    public function panel_count()
    {
        $total = $this->Invoice->find('count', array(
            'conditions' => array(
                $this->Invoice->alias . '.customer_id' => $this->CustomerAccess->getCustomerId()
            )
        ));

        if ($this->request->is('requested')) {
            return compact('total');
        }
    }

}
