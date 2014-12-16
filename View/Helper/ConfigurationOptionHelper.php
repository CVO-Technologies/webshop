<?php

class ConfigurationOptionHelper extends AppHelper {

	public $helpers = array(
		'Number'
	);

	private $_details    = array();
	private $_options    = array();
	private $_overwrites = array();
	private $_values     = array();

	public function setConfigurationGroupDetails(array $details) {
		$this->_details = $details;

		$this->_options = array();
		foreach ($details['ConfigurationOption'] as $configurationOptions) {
			$this->_options[$configurationOptions['alias']] = $configurationOptions;
		}
	}

	public function setOverwrites(array $options) {
		$this->_overwrites = array();
		foreach ($options as $option) {
			$this->_overwrites[$option['ConfigurationOption']['alias']] = $option['ProductConfigurationOption'];
		}
	}

	public function setValues(array $values) {
		$this->_values = $values;
	}

	public function form(array $options = array()) {
		return $this->_View->element('Webshop.configuration_options/form', array('configurationGroup' => $this->_details, 'options' => $options));
	}

	public function input($alias, $inputOptions) {
		$option = $this->configurationOption($alias);

		switch ($option['type']) {
			case 'int':
			case 'float':
				return $this->_View->element(
						'Webshop.configuration_options/type/number',
						array('option' => $option, 'inputOptions' => $inputOptions)
				);
			case 'string':
				return $this->_View->element(
						'Webshop.configuration_options/type/string',
						array('option' => $option, 'inputOptions' => $inputOptions)
				);
			case 'boolean':
				$option['label'] = $option['name'];
				$option['type'] = 'checkbox';

				break;
			case 'list':
				if ($option['maximum_length'] <= 1) {
					return $this->_View->element(
							'Webshop.' . ((count($option['ConfigurationOptionItem']) > 5) ? 'configuration_options/type/list/dropdown' : 'configuration_options/type/list/radio'),
							array('option' => $option, 'inputOptions' => $inputOptions)
					);
				}
		}
	}

	public function inputOptions($alias, $options = array()) {
		$optionSettings = $this->configurationOption($alias);

		if (((isset($optionSettings['fixed_value'])) && (strlen(trim($optionSettings['fixed_value']))))) {
			$value = $optionSettings['fixed_value'];
		} else {
			$value = (isset($this->_values[$alias])) ? $this->_values[$alias] : null;
		}

		$options = array_merge(array(
				'label' => $optionSettings['name'],
				'min' => $optionSettings['minimum'],
				'max' => $optionSettings['maximum'],
				'maxlength' => $optionSettings['maximum_length'],
				'step' => $optionSettings['step'],
				'value' => $this->convertValue($alias, $value),
				'disabled' => ((isset($optionSettings['fixed_value'])) && (strlen(trim($optionSettings['fixed_value']))))
		), $options);

		if ($optionSettings['type'] === 'list') {
			$listOptions = array();
			foreach ($optionSettings['ConfigurationOptionItem'] as $item) {
				$listOptions[$item['id']] = $item['name'] . ' - ' . $this->Number->currency($item['price'], 'EUR');
			}

			$options['options'] = $listOptions;
		}

		return $options;
	}

	public function configurationOption($alias) {
		$optionSettings = $this->_options[$alias];

		if (isset($this->_overwrites[$alias])) {
			$optionSettings = array_merge($optionSettings, $this->_overwrites[$alias]);
		}

		return $optionSettings;
	}

	public function optionValues($fixed = false) {
		$optionValues = array();
		foreach ($this->_options as $alias => $optionSettings) {
			if (isset($this->_overwrites[$alias])) {
				$optionSettings = array_merge($optionSettings, $this->_overwrites[$alias]);
			}

			if ((isset($optionSettings['fixed_value'])) && (strlen(trim($optionSettings['fixed_value'])))) {
				if (!$fixed) {
					continue;
				}

				$value = $optionSettings['fixed_value'];
			} else {
				$value = (isset($this->_values[$alias])) ? $this->_values[$alias] : null;
			}

			$optionValues[$alias] = $this->convertValue($alias, $value);
		}

		return $optionValues;
	}

	public function convertValue($alias, $value) {
		$option = $this->configurationOption($alias);

		switch ($option['type']) {
			case 'int':
				return (int) $value;
			case 'float':
				return (float) $value;
		}

		return $value;
	}

	public function valueDisplayText($alias, $value) {
		$option = $this->_options[$alias];

		if (isset($this->_overwrites[$alias])) {
			$option = array_merge($option, $this->_overwrites[$alias]);
		}

		if ($option['type'] === 'list') {
			foreach ($option['ConfigurationOptionItem'] as $configurationOptionItem) {
				if ($configurationOptionItem['id'] != $value) {
					continue;
				}

				$value = $configurationOptionItem['name'];
			}
		}

		return $value;
	}

	public function configurationOptionItem($alias, $itemId) {
		$option = $this->configurationOption($alias);

		foreach ($option['ConfigurationOptionItem'] as $configurationOptionItem) {
			if ($configurationOptionItem['id'] != $itemId) {
				continue;
			}

			return $configurationOptionItem;
		}
	}

	public function getPrice($alias) {
		$option = $this->configurationOption($alias);

		switch ($option['type']) {
			case 'list':
				$configurationOptionItem = $this->configurationOptionItem($alias, $this->_values[$alias]);

				return (float) $configurationOptionItem['price'];
			case 'int':
			case 'float':
				return ($this->_values[$alias] / $option['step']) * $option['step_price'];
		}
	}

}
