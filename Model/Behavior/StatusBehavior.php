<?php

class StatusBehavior extends ModelBehavior {

	public function changeStatus(Model $Model, $status, $id = null, $force = false) {
		if ($id === null) {
			$id = $Model->getID();
		}

		if ($id === false) {
			return false;
		}

		$force = true;

		$Model->id = $id;

		if (!$Model->exists()) {
			throw new NotFoundException();
		}

		if ($force !== true) {
			$modelData = $Model->read();

			if ($modelData[$Model->alias]['status'] === $status) {
				CakeLog::write(
					LOG_WARNING,
					__d(
						'webshop',
						'The status of %1$s with id %2$d is already set to %3$s. Not making a change',
						strtolower(Inflector::humanize(Inflector::underscore($Model->name))),
						$id,
						$status
					),
					array('webshop')
				);

				return false;
			}
		} else {
			CakeLog::write(
				LOG_WARNING,
				__d(
					'webshop',
					'Status change of %1$s with id %2$d is being forced to %3$s',
					strtolower(Inflector::humanize(Inflector::underscore($Model->name))),
					$id,
					$status
				),
				array('webshop')
			);
		}

		$Model->saveField('status', $status);

		CakeLog::write(
			LOG_INFO,
			__d(
				'webshop',
				'Changed status of %1$s with id %2$d to %3$s',
				strtolower(Inflector::humanize(Inflector::underscore($Model->name))),
				$id,
				$status
			),
			array('webshop')
		);

		$eventData = array();
		$eventData[Inflector::underscore($Model->name)]['id'] = $id;
		$eventData[Inflector::underscore($Model->name)]['status'] = $status;

		$overallEvent = new CakeEvent($Model->name . '.statusChanged', $this, $eventData);
		$specificEvent = new CakeEvent($Model->name . '.statusChangedTo' . Inflector::camelize($status), $this, $eventData);
		CakeEventManager::instance()->dispatch($overallEvent);
		CakeEventManager::instance()->dispatch($specificEvent);

		return true;
	}

}
