<?php

// @codingStandardsIgnoreStart

class ConfigurationGroupsController extends AppController
{

    public $components = array(
        'Paginator'
    );

    public function view($id)
    {
        $this->ConfigurationGroup->id = $id;
        $this->ConfigurationGroup->recursive = 2;

        return $this->ConfigurationGroup->read();
    }

    public function admin_index()
    {
        $configurationGroups = $this->Paginator->paginate('ConfigurationGroup');

        $this->set(compact('configurationGroups'));
    }

    public function admin_add()
    {
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

    public function admin_edit($id)
    {
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

    public function admin_delete($id)
    {
        if ($this->ConfigurationGroup->delete($id)) {
            $this->Session->setFlash(__d('webshop', 'Configuration group has been deleted'), 'flash', array('class' => 'success'));

            $this->redirect(array('action' => 'index'));
            return;
        }
    }

    public function admin_listing()
    {
        return $this->ConfigurationGroup->find('list');
    }

}
