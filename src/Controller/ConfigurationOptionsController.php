<?php

namespace Webshop\Controller;

use Croogo\Core\Controller\AppController as CroogoAppController;

class ConfigurationOptionsController extends AppController
{

    public $components = array(
        'Paginator' => array(
            'settings' => array(
                'order' => array(
                    'ConfigurationOption.weight' => 'ASC'
                )
            )
        )
    );

    public function admin_index()
    {
        $conditions = array();
        if (isset($this->request->params['named']['configuration_group'])) {
            $conditions['configuration_group_id'] = $this->request->params['named']['configuration_group'];

            $this->ConfigurationOption->ConfigurationGroup->id = $this->request->params['named']['configuration_group'];
            $configurationGroup = $this->ConfigurationOption->ConfigurationGroup->read();

            $this->set(compact('configurationGroup'));
        }
        $configurationOptions = $this->Paginator->paginate('ConfigurationOption', $conditions);

        $this->set(compact('configurationOptions'));
    }

    public function admin_edit($id)
    {
        $this->ConfigurationOption->id = $id;
        if (empty($this->request->data)) {
            $this->request->data = $this->ConfigurationOption->read();
        }

        if (!$this->request->is('put')) {
            return;
        }

        if ($this->ConfigurationOption->save($this->request->data)) {
            $this->redirect(array('controller' => 'configuration_options', 'action' => 'index', 'configuration_group' => $this->request->data['ConfigurationOption']['configuration_group_id']));
            return;
        }
    }

    /**
     * Admin moveup
     *
     * @param integer $id Dashboard Id
     * @param integer $step Step
     * @return void
     */
    public function admin_moveup($id, $step = 1)
    {
        if ($this->ConfigurationOption->moveUp($id, $step)) {
            $this->Session->setFlash(__d('croogo', 'Moved up successfully'), 'flash', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__d('croogo', 'Could not move up'), 'flash', array('class' => 'error'));
        }
        return $this->redirect($this->referer());
    }

    /**
     * Admin movedown
     *
     * @param integer $id Dashboard Id
     * @param integer $step Step
     * @return void
     */
    public function admin_movedown($id, $step = 1)
    {
        if ($this->ConfigurationOption->moveDown($id, $step)) {
            $this->Session->setFlash(__d('croogo', 'Moved down successfully'), 'flash', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__d('croogo', 'Could not move down'), 'flash', array('class' => 'error'));
        }
        return $this->redirect($this->referer());
    }

}

