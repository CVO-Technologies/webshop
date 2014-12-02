<?php

class CounterBehavior extends ModelBehavior {

	public function setup(Model $Model, $config = array()) {
		$this->settings[$Model->alias] = $config;

		$this->Counter = ClassRegistry::init('Webshop.Counter');
	}

	public function beforeSave(Model $Model, $options = array()) {
		if ($Model->id !== false) {
			return true;
		}

		foreach ($this->settings[$Model->alias]['fields'] as $field => $fieldOptions) {
			if ($fieldOptions['count'] !== true) {
				continue;
			}

			$Model->data[$Model->alias][$field] = $this->Counter->getNextValue($Model, $field);

			$this->Counter->increaseValue($Model, $field);
		}

		return true;
	}

}