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

	public function increment(Model $Model, $id = null, $field = null) {
		if ((!$field) && (key($this->settings[$Model->alias]['fields']))) {
			$field = key($this->settings[$Model->alias]['fields']);
		}

		if (!$field) {
			return false;
		}

		if ($id === null) {
			$id = $Model->getID();
		}

		if ($id === false) {
			return false;
		}

		$Model->id = $id;

		$currentValue = $Model->field($field, array(
			$Model->alias . '.id' => $id
		));

		$result = $Model->saveField($field, $currentValue + 1);

		if (!$result) {
			return false;
		}

		return $currentValue + 1;
	}

}
