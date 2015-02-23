<?php

$this->extend('/Common/admin_edit');

$this->Croogo->adminScript('Nodes.admin');

$this->set('financialContacts', $this->requestAction(array(
	'controller' => 'customerContacts',
	'action' => 'listing',
	'?' => array(
		'customer_id' => $this->request->data['Customer']['id']
	)
)));

$this->set('editFields', array(
	'name' => array(
		'label' => __d('webshop', 'Name'),
	),
	'type' => array(
		'label' => __d('webshop', 'Type'),
		'options' => array(
			'individual' => __d('webshop', 'Individual'),
			'business' => __d('webshop', 'Business'),
		)
	),
	'vat_number' => array(
		'label' => __d('webshop', 'VAT number'),
	),
	'financial_contact_id' => array(
		'label' => __d('webshop', 'Financial contact')
	),
	'invoice_address_detail_id' => array(
		'label' => __d('webshop', 'Invoice address')
	)
));
