<?php

namespace Webshop\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;

/**
 * @property HtmlHelper Html
 */
class WebshopHelper extends Helper
{

    public $helpers = array('Html');

    public function beforeRender()
    {
        $this->Html->script('Webshop.webshop', ['block' => 'script']);
        $this->Html->css('Webshop.webshop', ['block' => 'css']);
    }

    /**
     * Create a tab title/link
     */
    public function panelTab($title, $url, $options = array())
    {
        return $this->Html->tag('li',
            $this->Html->link($title, $url, Hash::merge(array(
                'data-toggle' => 'tab',
            ), $options)
            )
        );
    }

    /**
     * Show tabs
     *
     * @return string
     */
    public function panelTabs($show = null)
    {
        if (!isset($this->adminTabs)) {
            $this->adminTabs = false;
        }

        $output = '';
        $tabs = Configure::read('Webshop.panel.tabs.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($tabs)) {
            foreach ($tabs as $title => $tab) {
                $tab = Hash::merge(array(
                    'options' => array(
                        'linkOptions' => array(),
                        'elementData' => array(),
                        'elementOptions' => array(),
                    ),
                ), $tab);

                if (!isset($tab['options']['type']) || (isset($tab['options']['type']) && (in_array($this->_View->viewVars['typeAlias'], $tab['options']['type'])))) {
                    $domId = strtolower(Inflector::singularize($this->request->params['controller'])) . '-' . strtolower(Inflector::slug($title, '-'));
                    if ($this->adminTabs) {
                        list($plugin, $element) = pluginSplit($tab['element']);
                        $elementOptions = Hash::merge(array(
                            'plugin' => $plugin,
                        ), $tab['options']['elementOptions']);
                        $output .= '<div id="' . $domId . '" class="tab-pane">';
                        $output .= $this->_View->element($element, $tab['options']['elementData'], $elementOptions);
                        $output .= '</div>';
                    } else {
                        $output .= $this->panelTab(__d('croogo', $title), '#' . $domId, $tab['options']['linkOptions']);
                    }
                }
            }
        }

        $this->adminTabs = true;
        return $output;
    }

    /**
     * Starts a new tab pane
     *
     * @param string $id Tab pane id
     * @param array $options Options array
     * @return string
     */
    public function tabStart($id, $options = array())
    {
        $options = Hash::merge(array(
            'id' => $id,
            'class' => 'tab-pane',
        ), $options);
        return $this->Html->formatTemplate('blockstart', [
            'attrs' => $this->Html->templater()->formatAttributes($options)
        ]);
    }

    /**
     * Ends a tab pane
     *
     * @return string
     */
    public function tabEnd()
    {
        return $this->Html->formatTemplate('blockend', []);
    }

}
