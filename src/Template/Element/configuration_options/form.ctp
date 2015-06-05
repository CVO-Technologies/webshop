<?php

$index = 0;
foreach ($configurationOptions as $configurationOption):
	if (isset($valueStoreIds[$configurationOption['alias']])):
		echo $this->Form->hidden($options['input']['prefix'] . $index . '.id', array('value' => $valueStoreIds[$configurationOption['alias']]));
	endif;
	if (isset($options['relation']['id'])):
		echo $this->Form->hidden($options['input']['prefix'] . $index . '.foreign_key', array('value' => $options['relation']['id']));
	endif;

	echo $this->Form->hidden($options['input']['prefix'] . $index . '.model', array('value' => $options['relation']['model']));
	echo $this->Form->hidden($options['input']['prefix'] . $index . '.configuration_option_id', array('value' => $configurationOption['id']));
	echo $this->ConfigurationOption->input($configurationOption['alias'], $options['input']['prefix'] . $index, $options['input']);

	$index++;
endforeach;
