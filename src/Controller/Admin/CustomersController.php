<?php

namespace Webshop\Controller\Admin;

// @codingStandardsIgnoreStart

use Cake\Event\Event;
use Cake\ORM\Query;
use Webshop\Controller\AppController;
use Webshop\Model\Entity\AddressDetail;
use Webshop\Model\Entity\Customer;
use Webshop\Model\Entity\CustomerContact;

class CustomersController extends AppController
{

    public function setInvoiceAddressDetail($id, $addressDetailId)
    {
        /* @var Customer $customer */
        $customer = $this->Customers->get($id);

        /* @var AddressDetail $invoiceAddressDetail */
        $invoiceAddressDetail = $this->Customers->InvoiceAddressDetails->get($addressDetailId);

        $customer->invoice_address_detail_id = $addressDetailId;

        if (!$this->Customers->save($customer)) {
            return $this->redirect(['action' => 'view', $id]);
        }

        $this->Flash->success(__d('webshop', 'Set {0} as invoice address', $invoiceAddressDetail->name));

        return $this->redirect(['action' => 'view', $id]);
    }

    public function setFinancialContact($id, $contactId)
    {
        /* @var Customer $customer */
        $customer = $this->Customers->get($id);

        /* @var CustomerContact $financialContact */
        $financialContact = $this->Customers->Contacts->get($contactId);

        $customer->financial_contact_id = $contactId;

        if (!$this->Customers->save($customer)) {
            return $this->redirect(['action' => 'view', $id]);
        }

        $this->Flash->success(__d('webshop', 'Set {0} as financial contact', $financialContact->name));

        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeFind' => 'beforeFind'
        ];
    }

    public function beforeFind(Event $event)
    {
        /* @var Query $query */
        $query = $event->subject()->query;

        $query->contain([
            'FinancialContacts',
            'InvoiceAddressDetails',
            'Contacts',
            'AddressDetails'
        ]);
    }
}
