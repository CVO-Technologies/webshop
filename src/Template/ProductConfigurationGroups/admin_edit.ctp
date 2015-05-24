<?php

$this->extend('/Common/admin_edit');

$this->Croogo->adminScript('Nodes.admin');

$this->Html
		->addCrumb('', '/admin', array('icon' => $_icons['home']))
		->addCrumb(__d('croogo', 'Content'), array('controller' => 'nodes', 'action' => 'index'))
		->addCrumb($this->request->data['Product']['title'] . ': ' . $this->request->data['ConfigurationGroup']['name'], array('controller' => 'nodes', 'action' => 'index'));

//if ($this->request->params['action'] == 'admin_add') {
//	$formUrl = array('action' => 'add', $typeAlias);
//	$this->Html
//		->addCrumb(__d('croogo', 'Create'), array('controller' => 'nodes', 'action' => 'create'))
//		->addCrumb($type['Type']['title'], '/' . $this->request->url);
//}
//
//if ($this->request->params['action'] == 'admin_edit') {
//	$formUrl = array('action' => 'edit');
//	$this->Html->addCrumb($this->request->data['Node']['title'], '/' . $this->request->url);
//}

//$lookupUrl = $this->Html->apiUrl(array(
//	'plugin' => 'users',
//	'controller' => 'users',
//	'action' => 'lookup',
//));

//$parentTitle = isset($parentTitle) ? $parentTitle : null;
//$apiUrl = $this->Form->apiUrl(array(
//	'controller' => 'nodes',
//	'action' => 'lookup',
//	'?' => array(
//		'type' => $type['Type']['alias'],
//	),
//));

$this->append('form-start', $this->Form->create('ProductConfigurationGroup', array(
		'class' => 'protected-form',
)));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('webshop', 'Product'), '#node-main');
echo $this->Croogo->adminTab(__d('webshop', 'Options'), '#node-options');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('node-main');
echo $this->Form->input('id');
echo $this->Html->tabEnd();

echo $this->Html->tabStart('node-options');

$this->ConfigurationOption->setConfigurationGroupDetails($this->request->data['ConfigurationGroup']);

foreach ($this->request->data['ProductConfigurationOption'] as $index => $productConfigurationOption):
	echo $this->Form->inputs(
			array(
					'legend' => $productConfigurationOption['ConfigurationOption']['name'],
					'ProductConfigurationOption.' . $index . '.id' => array(
							'value' => $productConfigurationOption['id']
					),
					'ProductConfigurationOption.' . $index . '.value' => $this->ConfigurationOption->inputOptions($productConfigurationOption['ConfigurationOption']['alias'], array(
							'label' => 'Value',
					)),
					'ProductConfigurationOption.' . $index . '.allow_user_input' => array(
							'label' => 'Allow user input'
					)
			)
	);
endforeach;

echo $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

$this->end();

$username = isset($this->request->data['User']['username']) ?
		$this->request->data['User']['username'] :
		$this->Session->read('Auth.User.username');

$this->start('panels');
echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
		$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
		$this->Form->button(__d('croogo', 'Save'), array('button' => 'success')) .
		$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'cancel btn btn-danger'));
//		$this->Form->input('status', array(
//			'legend' => false,
//			'type' => 'radio',
//			'default' => CroogoStatus::UNPUBLISHED,
//			'options' => $this->Croogo->statuses(),
//		)) .
//		$this->Form->input('promote', array(
//			'label' => __d('croogo', 'Promoted to front page'),
//		)) .
//		$this->Form->autocomplete('user_id', array(
//			'type' => 'text',
//			'label' => __d('croogo', 'Publish as '),
//			'autocomplete' => array(
//				'default' => $username,
//				'data-displayField' => 'username',
//				'data-primaryKey' => 'id',
//				'data-queryField' => 'name',
//				'data-relatedElement' => '#NodeUserId',
//				'data-url' => $lookupUrl,
//			),
//		)) .
//
//		$this->Form->input('created', array(
//			'type' => 'text',
//			'class' => trim($inputClass . ' input-datetime'),
//			'label' => __d('croogo', 'Created'),
//		)) .
//
//		$this->Html->div('input-daterange',
//			$this->Form->input('publish_start', array(
//				'label' => __d('croogo', 'Publish Start'),
//				'type' => 'text',
//			)) .
//			$this->Form->input('publish_end', array(
//				'label' => __d('croogo', 'Publish End'),
//				'type' => 'text',
//			))
//		);

echo $this->Html->endBox();

echo $this->Croogo->adminBoxes();

$this->end();

$this->append('form-end', $this->Form->end());
