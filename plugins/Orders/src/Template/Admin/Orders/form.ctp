<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => $this->Theme->getIcon('home')))
	->addCrumb(__d('webshop_orders', 'Orders'), array('action' => 'index'))
	->addCrumb(__d('webshop_orders', '%1$s\'s orders', $order['Customer']['name']), array('action' => 'index', '?' => array('customer_id' => $this->request->data['Order']['customer_id'])))
	->addCrumb(__d('webshop_orders', 'Order #%1$d', $order['Order']['number']), '/' . $this->request->url);

$this->set('customers', $this->requestAction(array(
	'plugin' => 'webshop',
	'controller' => 'customers',
	'action' => 'listing'
)));

$this->set('invoiceAddressDetails', $this->requestAction(array(
	'plugin' => 'webshop',
	'controller' => 'address_details',
	'action' => 'listing'
)));

$this->set('editFields', array(
	'customer_id' => array(
		'label' => __d('webshop_orders', 'Customer'),
	),
	'invoice_address_detail_id' => array(
		'label' => __d('webshop_orders', 'Invoice address detail'),
	),
	'status' => array(
		'label' => __d('webshop_orders', 'Status'),
		'options' => $this->Order->statusOptions()
	)
));
