<?php


$this->Title->addTopSegment(__d('webshop', 'Dashboard'));
$this->Title->addSegment(__d('webshop_invoices', 'Invoices'));
$this->Title->setPageTitle(__d('webshop_invoices', 'Invoice #%d', $invoice['Invoice']['number']));

$this->Title->addCrumbs(array(
	array('plugin' => 'webshop', 'controller' => 'customers', 'action' => 'dashboard'),
	array('action' => 'index'),
	array('action' => 'view', $invoice['Invoice']['id'])
));

$this->extend('Webshop.Common/panel_view');

$this->append('tab-heading');
echo $this->Webshop->panelTab(__d('webshop_invoices', 'Invoice'), '#invoice-main');
echo $this->Webshop->panelTabs();
$this->end();

$this->append('tab-content');

echo $this->Webshop->tabStart('invoice-main');
echo $this->element('WebshopInvoices.invoice', array('invoice' => $invoice));
echo $this->Webshop->tabEnd();

echo $this->Webshop->panelTabs();

$this->end();
