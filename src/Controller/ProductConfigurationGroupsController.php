<?php

// @codingStandardsIgnoreStart

class ProductConfigurationGroupsController extends AppController
{

    public function view($id)
    {
        $this->ProductConfigurationGroup->id = $id;

        return $this->ProductConfigurationGroup->read();
    }

    public function admin_index()
    {
        debug('aa');
    }

    public function admin_edit($id)
    {
        $this->ProductConfigurationGroup->id = $id;
        $this->ProductConfigurationGroup->recursive = 2;

        if (empty($this->request->data)) {
            $this->request->data = $this->ProductConfigurationGroup->read();
        }

        if (!$this->request->is('put')) {
            return;
        }

        debug($this->request->data);

        if (!empty($this->request->data)) {
            unset($this->ProductConfigurationGroup->ProductConfigurationOption->validate['product_configuration_group_id']);
            if ($this->ProductConfigurationGroup->saveAssociated($this->request->data)) {
                $this->redirect(array('action' => 'index'));

                return;
            } else {
                debug(':(');
            }
        }
    }

}
