<?php

class ProductConfigurationOptionsController extends AppController {

	public function product($id) {
		return $this->ProductConfigurationOption->find('all', array(
			'conditions' => array(
				'ProductConfigurationOption.product_id' => $id
			),
			'recursive' => 1
		));
	}

}
