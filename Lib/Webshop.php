<?php

class Webshop
{

    /**
     * Panel tab
     *
     * @param string $action in the format ControllerName/action_name
     * @param string $title Tab title
     * @param string $element element name, like plugin_name.element_name
     * @param array $options array with options for the hook to take effect
     */
    public static function hookPanelTab($action, $title, $element, $options = array())
    {
        self::_hookAdminBlock('Webshop.panel.tabs', $action, $title, $element, $options);
    }

    protected static function _hookAdminBlock($key, $action, $title, $element, $options = array())
    {
        $tabs = Configure::read($key);
        if (!is_array($tabs)) {
            $tabs = array();
        }
        if (!isset($tabs[$action])) {
            $tabs[$action] = array();
        }
        $tabs[$action][$title]['element'] = $element;
        $tabs[$action][$title]['options'] = $options;
        Configure::write($key, $tabs);
    }

}
