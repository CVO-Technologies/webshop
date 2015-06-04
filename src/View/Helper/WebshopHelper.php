<?php

namespace Webshop\View\Helper;

use Cake\View\Helper;

class WebshopHelper extends Helper {

	public $helpers = array('Html');

	public function beforeRender($viewFile) {
		$this->Html->script('Webshop.webshop', array('inline' => false, 'block' => 'script'));
		$this->Html->css('Webshop.webshop', array('inline' => false, 'block' => 'css'));
	}

}
