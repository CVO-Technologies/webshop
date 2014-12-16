<?php

echo $this->Form->input(
		$inputOptions['prefix'] . $option['alias'],
		$this->ConfigurationOption->inputOptions(
				$option['alias'],
				array(
						'type' => 'select',
				)
		)
);
