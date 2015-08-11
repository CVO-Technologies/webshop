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

    /**
     * @var array List of helpers to include
     */
    public $helpers = [
        'Html'
    ];

    /**
     * Adds required scripts and css files
     *
     * @return void
     */
    public function beforeRender()
    {
        $this->Html->script('Webshop.webshop', ['block' => 'script']);
        $this->Html->css('Webshop.webshop', ['block' => 'css']);
    }

    /**
     * Create a tab title/link
     *
     * @param string $title Title of panel
     * @param string|array $url Url of panel
     * @param array $options Options
     *
     * @return string List item for panel
     */
    public function panelTab($title, $url, array $options = [])
    {
        return $this->Html->tag(
            'li',
            $this->Html->link($title, $url, Hash::merge(['data-toggle' => 'tab'], $options))
        );
    }

    /**
     * Show tabs
     *
     * @return string
     */
    public function panelTabs()
    {
        if (!isset($this->adminTabs)) {
            $this->adminTabs = false;
        }

        $output = '';
        $tabs = Configure::read('Webshop.panel.tabs.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($tabs)) {
            foreach ($tabs as $title => $tab) {
                $tab = Hash::merge([
                    'options' => [
                        'linkOptions' => [],
                        'elementData' => [],
                        'elementOptions' => [],
                    ],
                ], $tab);

                if (!isset($tab['options']['type']) || (isset($tab['options']['type']) && (in_array($this->_View->viewVars['typeAlias'], $tab['options']['type'])))) {
                    $domId = strtolower(Inflector::singularize($this->request->params['controller'])) . '-' . strtolower(Inflector::slug($title, '-'));
                    if ($this->adminTabs) {
                        list($plugin, $element) = pluginSplit($tab['element']);
                        $elementOptions = Hash::merge([
                            'plugin' => $plugin,
                        ], $tab['options']['elementOptions']);
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
     *
     * @return string
     */
    public function tabStart($id, array $options = [])
    {
        $options = Hash::merge([
            'id' => $id,
            'class' => 'tab-pane',
        ], $options);

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
