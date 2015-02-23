<?php

class AddressDetailsController extends AppController {

	public $components = array(
		'RequestHandler',
		'Paginator'
	);

	public function panel_index() {
		$addressDetails = $this->Paginator->paginate('AddressDetail', array(
			'AddressDetail.customer_id' => $this->CustomerAccess->getCustomerId()
		));

		if ($this->request->is('requested')) {
			return $addressDetails;
		}

		$this->set(compact('addressDetails'));
		$this->set('_serialize', array('addressDetails'));
	}

	public function panel_add() {
		if ($this->request->query('modal')) {
			$this->layout = 'modal';

			$this->set('modal', $this->request->query('modal'));
		}

		if (!$this->request->is('post')) {
			return;
		}

		$this->request->data['AddressDetail']['customer_id'] = $this->CustomerAccess->getCustomerId();

		if (!$this->AddressDetail->save($this->request->data)) {
			return;
		}

		$this->redirect(array(
			'action' => 'index'
		));
	}

	public function panel_edit($id) {
		$addressDetail = $this->AddressDetail->find('first', array(
			'conditions' => array(
				'AddressDetail.id' => $id,
				'AddressDetail.customer_id' => $this->CustomerAccess->getCustomerId()
			)
		));
		if (!$addressDetail) {
			throw new NotFoundException();
		}

		if (empty($this->request->data)) {
			$this->request->data = $addressDetail;
		}

		debug($this->request->method());

		if (!$this->request->is('put')) {
			return;
		}

		$this->AddressDetail->id = $id;
		if (!$this->AddressDetail->save($this->request->data, array(
			'AddressDetail.name',
			'AddressDetail.street',
			'AddressDetail.house_number',
			'AddressDetail.house_number_addition',
			'AddressDetail.postcode',
			'AddressDetail.city',
			'AddressDetail.municipality',
			'AddressDetail.province',
			'AddressDetail.country',
		))) {
			$this->Session->setFlash(__d('webshop', 'Could not save address details'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));

			return;
		}

		$this->redirect(array(
			'action' => 'index'
		));
	}

	public function check($modelName) {
		$this->loadModel($modelName);

		$transformedFields = array();
		foreach ($this->request->query['data'] as $association => $fields) {
			$Model = ($association === $modelName) ? $this->{$modelName} : $this->{$modelName}->{$association};
			if (!$Model) {
				continue;
			}

			$transformedFields[$Model->name] = $this->__transformFields($Model, array($Model->alias), $fields);
		}

		$ChangeEvent = new CakeEvent('Form.change', $this, array(
			'fields' => $transformedFields
		));

		$this->getEventManager()->dispatch($ChangeEvent);

		$fields = array();
		foreach (Hash::flatten($ChangeEvent->data['fields']) as $key => $value) {
			$fieldParts = explode('.', $key);
			$lastPart = array_pop($fieldParts);
			if (is_numeric($lastPart)) {
				$lastPart = array_pop($fieldParts);
				$fields[implode('.', $fieldParts)][$lastPart][] = $value;
			} else {
				$fields[implode('.', $fieldParts)][$lastPart] = $value;
			}
		}

		$this->set('fields', $fields);
		$this->set('_serialize', array('fields'));
	}

	public function admin_listing() {
		$this->Paginator->settings['AddressDetail']['type'] = 'list';
		$addressDetails = $this->Paginator->paginate('AddressDetail');

		if ($this->request->is('requested')) {
			return $addressDetails;
		}

		$this->set(compact('addressDetails'));
	}

	private function __transformFields(Model $Model, array $stack, $fields) {
		$transformedFields = array();

		foreach ($fields as $fieldName => $fieldValue) {
			$fieldStack = $stack;
			$fieldStack[] = $fieldName;

			$transformedFields[$fieldName] = array(
				'name' => 'data[' . implode('][', $fieldStack) . ']',
				'disabled' => null,
				'errors' => array(

				),
				'value' => $fieldValue,
				'changed' => false
			);
		}

		return $transformedFields;
	}

}
