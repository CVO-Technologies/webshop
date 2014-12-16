<?php

$this->extend('/Common/admin_edit');

$this->Croogo->adminScript('Nodes.admin');

$this->Html
	->addCrumb('', '/admin', array('icon' => $this->Theme->getIcon('home')))
	->addCrumb(__d('webshop', 'Webshop'), array('controller' => 'nodes', 'action' => 'index'))
	->addCrumb(__d('webshop', 'Configuration groups'), array('action' => 'index'));

if ($this->request->params['action'] == 'admin_add'):
	$this->Html->addCrumb(__d('webshop', 'Create'), array('action' => 'add'));
endif;

if ($this->request->params['action'] == 'admin_edit'):
	$this->Html->addCrumb($this->request->data['ConfigurationGroup']['name'], '/' . $this->request->url);
endif;

$this->append('form-start', $this->Form->create('ConfigurationGroup', array(
	'class' => 'protected-form',
)));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('webshop', 'Configuration group'), '#node-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('node-main');
	echo $this->Form->input('name', array(
		'label' => __d('webshop', 'Name'),
	));
	echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();

$this->end();

$this->start('panels');
	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
