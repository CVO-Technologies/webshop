<?php

class ConfigurationOptionItemsController extends AppController
{

    public $components = array(
        'Paginator' => array(
            'settings' => array(
                'order' => array(
                    'ConfigurationOptionItem.weight' => 'ASC'
                )
            )
        )
    );

    public function admin_index()
    {
        $conditions = array();
        if (isset($this->request->params['named']['configuration_option'])) {
            $conditions['configuration_option_id'] = $this->request->params['named']['configuration_option'];

            $this->ConfigurationOptionItem->ConfigurationOption->id = $this->request->params['named']['configuration_option'];
            $configurationOption = $this->ConfigurationOptionItem->ConfigurationOption->read();

            $this->set(compact('configurationOption'));
        }
        $configurationOptionItems = $this->Paginator->paginate('ConfigurationOptionItem', $conditions);

        $this->set(compact('configurationOptionItems'));
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
        if ($this->ConfigurationOptionItem->moveUp($id, $step)) {
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
        if ($this->ConfigurationOptionItem->moveDown($id, $step)) {
            $this->Session->setFlash(__d('croogo', 'Moved down successfully'), 'flash', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__d('croogo', 'Could not move down'), 'flash', array('class' => 'error'));
        }
        return $this->redirect($this->referer());
    }

}

