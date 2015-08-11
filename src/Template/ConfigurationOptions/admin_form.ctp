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

$this->append('form-start', $this->Form->create('ConfigurationOption', array(
    'class' => 'protected-form',
)));

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('webshop', 'Configuration option'), '#node-main');
echo $this->Croogo->adminTab(__d('webshop', 'Validation'), '#node-validation');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('node-main');
echo $this->Form->input('name', array(
    'label' => __d('webshop', 'Name'),
));
echo $this->Form->input('alias', array(
    'label' => __d('webshop', 'Alias'),
));
echo $this->Form->input('type', array(
    'label' => __d('webshop', 'Alias'),
    'options' => array(
        'list' => 'List',
        'int' => 'Integer',
        'float' => 'Float',
        'string' => 'Text',
        'boolean' => 'Boolean'
    )
));
echo $this->Form->input('amount', array(
    'label' => __d('webshop', 'Amount'),
));
echo $this->Form->input('step', array(
    'label' => __d('webshop', 'Step size'),
));
echo $this->Form->input('step_price', array(
    'label' => __d('webshop', 'Step price'),
));
echo $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

echo $this->Html->tabStart('node-validation');
echo $this->Form->input('minimum_length', array(
    'label' => __d('webshop', 'minimum_length'),
));
echo $this->Form->input('maximum_length', array(
    'label' => __d('webshop', 'maximum_length'),
));
echo $this->Form->input('minimum', array(
    'label' => __d('webshop', 'Minimum'),
));
echo $this->Form->input('maximum', array(
    'label' => __d('webshop', 'Maximum'),
));
echo $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

$this->end();

$this->start('panels');
echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
