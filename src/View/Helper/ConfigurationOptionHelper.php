<?php

namespace Webshop\View\Helper;

use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Webshop\Model\Entity\ConfigurationOption;

class ConfigurationOptionHelper extends Helper
{

    public $helpers = [
        'Number'
    ];

    private $_details = [];
    private $_options = [];
    private $_overwrites = [];
    private $_values = [];
    private $__defaults = [];
    private $__idAliasMapping = [];
    private $valueStoreIds;

    /**
     * @param Collection $options Set the options
     *
     * @return void
     */
    public function setOptions(Collection $options)
    {
//		$this->_details = $details;

        $this->_options = [];
        /* @var Entity $option */
        foreach ($options as $option) {
            $this->_options[$option->alias] = $option;
        }

        $this->__idAliasMapping = $options->combine('id', 'alias')->toList();
    }

    /**
     * @param array $defaults Defaults
     *
     * @return void
     */
    public function setProductDefaults(array $defaults)
    {
        foreach ($defaults as $default) {
            $this->__defaults[$this->getAlias($default['configuration_option_id'])] = $default;
        }
    }

    /**
     * Set the current values
     *
     * @param Collection $values Collection of values
     *
     * @return void
     */
    public function setValues(Collection $values)
    {
        $this->_values = $values->toArray();
    }

    /**
     * @param array $valueStoreIds Sets an array of ids of current values
     *
     * @return void
     */
    public function setValueStoreIds(array $valueStoreIds)
    {
        $this->valueStoreIds = $valueStoreIds;
    }

    /**
     * @param array $options Form options
     *
     * @return string
     */
    public function form(array $options = [])
    {
        return $this->_View->element(
            'Webshop.configuration_options/form',
            [
                'configurationOptions' => $this->_options,
                'options' => $options,
                'valueStoreIds' => $this->valueStoreIds
            ]
        );
    }

    /**
     * @param string $alias String alias of option
     * @param string $fieldPrefix Field prefix
     * @param array $inputOptions Options for input
     *
     * @return string
     */
    public function input($alias, $fieldPrefix, $inputOptions)
    {
        $option = $this->configurationOption($alias);

        switch ($option['type']) {
            case 'int':
            case 'float':
                return $this->_View->element(
                    'Webshop.configuration_options/type/number',
                    ['option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value']
                );
            case 'string':
                return $this->_View->element(
                    'Webshop.configuration_options/type/string',
                    ['option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value']
                );
            case 'boolean':
//				$option['label'] = $option['title'];
//				$option['type'] = 'checkbox';

                return $this->_View->element(
                    'Webshop.configuration_options/type/checkbox',
                    ['option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.value']
                );
            case 'list':
                if ($option['maximum_length'] <= 1) {
                    return $this->_View->element(
                        'Webshop.' . ((count($option['ConfigurationOptionItem']) > 5) ? 'configuration_options/type/list/dropdown' : 'configuration_options/type/list/radio'),
                        ['option' => $option, 'inputOptions' => $inputOptions, 'fieldName' => $fieldPrefix . '.configuration_option_item_id']
                    );
                }
        }
    }

    /**
     * Returns the options of an input
     *
     * @param string $alias Alias of option
     * @param array $options Options to be merged
     *
     * @return array
     */
    public function inputOptions($alias, array $options = [])
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

        $options = array_merge([
            'label' => $optionSettings['title'],
            'legend' => $optionSettings['title'],
            'min' => $optionSettings['minimum'],
            'max' => $optionSettings['maximum'],
            'maxlength' => $optionSettings['maximum_length'],
            'step' => $optionSettings['step'],
            'value' => $this->convertValue($alias, $value)
        ], $options);

        if ($optionSettings['type'] === 'list') {
            $listOptions = [];
            foreach ($optionSettings['ConfigurationOptionItem'] as $item) {
                $listOptions[$item['id']] = $item['name'] . ' - ' . $this->Number->currency($item['price'], 'EUR');
            }

            $options['options'] = $listOptions;
        }

        return $options;
    }

    /**
     * @param string $alias Alias of option
     *
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

    /**
     * @param bool $fixed Something
     *
     * @return array
     */
    public function optionValues($fixed = false)
    {
        $optionValues = [];
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

    /**
     * Converts a value
     *
     * @param string $alias Alias of option
     * @param mixed $value Value to be converted
     *
     * @return float|int
     */
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

    /**
     * Returns the display value of a item
     *
     * @param string $alias Alias of option
     * @param string $value Value to be displayed
     *
     * @return mixed
     */
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

    /**
     * @param string $alias Alias of option
     * @param int $itemId ID of item
     *
     * @return mixed
     */
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

    /**
     * @param string $alias Alias of option
     *
     * @return float
     */
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

    /**
     * @param int $configurationOptionId Option id to get alias of
     *
     * @return string
     */
    public function getAlias($configurationOptionId)
    {
        return $this->__idAliasMapping[$configurationOptionId];
    }
}
