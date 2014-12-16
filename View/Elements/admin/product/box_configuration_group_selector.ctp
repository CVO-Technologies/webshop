<?php

$configurationGroups = $this->requestAction(array('controller' => 'configuration_groups', 'action' => 'listing'));

echo $this->Form->input('ProductConfigurationImplementation.configuration_group_id', array(
	'options' => $configurationGroups,
	'default' => 'aa'
));

echo $this->Html->link(
	__d('webshop', 'Add configuration group'),
	array(
		'plugin' => 'webshop',
		'controller' => 'configuration_groups',
		'action' => 'add'
	)
);
