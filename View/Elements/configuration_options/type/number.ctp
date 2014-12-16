<?php

$name = $inputOptions['prefix'] . $option['alias'];
echo $this->Form->input(
		$name,
		$this->ConfigurationOption->inputOptions(
				$option['alias'],
				array(
						'type' => 'number'
				)
		)
);
