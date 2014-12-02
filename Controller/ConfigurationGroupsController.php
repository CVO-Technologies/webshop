<?php

class ConfigurationGroupsController extends AppController {

	public $components = array(
		'Paginator'
	);

	public function admin_index() {
		debug($this->Paginator->paginate('ConfigurationGroup'));
	}

	public function admin_add() {
		if (!$this->request->is('post')) {
			return;
		}

		$this->ConfigurationGroup->create();
		if ($this->ConfigurationGroup->save($this->request->data)) {
			$this->redirect(array(
				'action' => 'index'
			));
		}
	}

	public function admin_edit($id) {
		$this->ConfigurationGroup->id = $id;

		$this->request->data = $this->ConfigurationGroup->read();
		if (!$this->request->is('post')) {
			return;
		}

		if ($this->ConfigurationGroup->save($this->request->data)) {
			$this->redirect(array(
					'action' => 'index'
			));
		}
	}

	public function admin_listing() {
		return $this->ConfigurationGroup->find('list');
	}

}
