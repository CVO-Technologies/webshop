<?php

namespace Webshop\View\Helper;

use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Webshop\Model\Entity\ConfigurationOption;

class ConfigurationOptionHelper extends Helper
{

    public $helpers = array(
        'Number'
    );

    private $_details = array();
    private $_options = array();
    private $_overwrites = array();
    private $_values = array();
    private $__defaults = array();
    private $__idAliasMapping = array();
    private $valueStoreIds;

    public function setConfigurationGroupDetails(array $details)
    {
//		$this->_details = $details;
//
//		$this->_options = array();
//		foreach ($details['ConfigurationOption'] as $configurationOptions) {
//			$this->_options[$configurationOptions['alias']] = $configurationOptions;
//		}
//
//		$this->__idAliasMapping = Hash::combine($details, 'ConfigurationOption.{n}.id', 'ConfigurationOption.{n}.alias');
    }

    public function setOptions(Collection $options)
    {
//		$this->_details = $details;

        $this->_options = array();
        /** @var Entity $option */
        foreach ($options as $option) {
            $this->_options[$option->alias] = $option;
        }

        $this->__idAliasMapping = $options->combine('id', 'alias')->toList();
    }

//	public function setOverwrites(array $options) {
//		$this->_overwrites = array();
//
//		foreach ($options as $option) {
//			debug($option);
//			$this->_overwrites[$option['ConfigurationOption']['alias']] = $option['ProductConfigurationOption'];
//		}
//	}

    public function setProductDefaults(array $defaults)
    {
        foreach ($defaults as $default) {
            $this->__defaults[$this->getAlias($default['configuration_option_id'])] = $default;
        }
    }

    public function setValues(Collection $values)
    {
        $this->_values = $values->toArray();
    }

    public function setValueStoreIds(array $valueStoreIds)
    {
        $this->valueStoreIds = $valueStoreIds;
    }

    public function form(array $options = array())
    {
        return $this->_View->element(
            'Webshop.configuration_options/form',
            array(
                'configurationOptions' => $this->_options,
                'options' => $options,
                'valueStoreIds' => $this->valueStoreIds
            )
        );
    }

    public function input($alias, $fieldPrefix, $inputOptions)
    {
        $option = $this->configurationOption($alias);

        switch ($option['type']) {
            case 'int':
            case 'float':
                return $this->_View->element(
                    'Webshop.configuration_options/type/number',
                    array('option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value')
                );
            case 'string':
                return $this->_View->element(
                    'Webshop.configuration_options/type/string',
                    array('option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value')
                );
            case 'boolean':
//				$option['label'] = $option['title'];
//				$option['type'] = 'checkbox';

                return $this->_View->element(
                    'Webshop.configuration_options/type/checkbox',
                    array('option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value')
                );
            case 'list':
                if ($option['maximum_length'] <= 1) {
                    return $this->_View->element(
                        'Webshop.' . ((count($option['ConfigurationOptionItem']) > 5) ? 'configuration_options/type/list/dropdown' : 'configuration_options/type/list/radio'),
                        array('option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.configuration_option_item_id')
                    );
                }
        }
    }

    public function inputOptions($alias, $options = array())
    {
        $optionSettings = $this->configurationOption($alias);

        $value = null;

        if (isset($this->__defaults[$alias])) {
            $value = ($optionSettings['type'] === 'list') ? $this->__defaults[$alias]['configuration_option_item_id'] : $this->__defaults[$alias]['value'];

            if (!$this->__defaults[$alias]['overridable']) {
                $options['disabled'] = true;
            }
        }

        if (isset($this->_values[$alias])) {
            $value = $this->_values[$alias];
        }

        if (((isset($optionSettings['fixed_value'])) && (strlen(trim($optionSettings['fixed_value']))))) {
            $value = $optionSettings['fixed_value'];

            $options['disabled'] = true;
        }

        $options = array_merge(array(
            'label' => $optionSettings['title'],
            'legend' => $optionSettings['title'],
            'min' => $optionSettings['minimum'],
            'max' => $optionSettings['maximum'],
            'maxlength' => $optionSettings['maximum_length'],
            'step' => $optionSettings['step'],
            'value' => $this->convertValue($alias, $value)
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

    /**
     * @param string $alias
     * @return ConfigurationOption
     */
    public function configurationOption($alias)
    {
        $optionSettings = $this->_options[$alias];

        if (isset($this->_overwrites[$alias])) {
            $optionSettings = array_merge($optionSettings, $this->_overwrites[$alias]);
        }

        return $optionSettings;
    }

    public function optionValues($fixed = false)
    {
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

    public function convertValue($alias, $value)
    {
        $option = $this->configurationOption($alias);

        switch ($option['type']) {
            case 'int':
                return (int)$value;
            case 'float':
                return (float)$value;
        }

        return $value;
    }

    public function valueDisplayText($alias, $value)
    {
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

    public function configurationOptionItem($alias, $itemId)
    {
        $option = $this->configurationOption($alias);

        foreach ($option['ConfigurationOptionItem'] as $configurationOptionItem) {
            if ($configurationOptionItem['id'] != $itemId) {
                continue;
            }

            return $configurationOptionItem;
        }
    }

    public function getPrice($alias)
    {
        $option = $this->configurationOption($alias);

        switch ($option['type']) {
            case 'list':
                $configurationOptionItem = $this->configurationOptionItem($alias, $this->_values[$alias]);

                return (float)$configurationOptionItem['price'];
            case 'int':
            case 'float':
                return ($this->_values[$alias] / $option['step']) * $option['step_price'];
        }
    }

    public function getAlias($configurationOptionId)
    {
        return $this->__idAliasMapping[$configurationOptionId];
    }

}
