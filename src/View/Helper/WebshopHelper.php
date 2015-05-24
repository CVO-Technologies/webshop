<?php

class WebshopHelper extends AppHelper {

	public $helpers = array('Html');

	public function beforeRender($viewFile) {
		$this->Html->script('Webshop.webshop', array('inline' => false, 'block' => 'script'));
		$this->Html->css('Webshop.webshop', array('inline' => false, 'block' => 'css'));
	}

}
