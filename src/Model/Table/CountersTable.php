<?php

// @codingStandardsIgnoreStart

//App::uses('WebshopAppModel', 'Webshop.Model');

class Counter extends WebshopAppModel
{

    public function increaseValue(Model $Model, $field)
    {
        $counter = $this->find('first', array(
            'conditions' => array(
                $this->alias . '.model' => $Model->alias,
                $this->alias . '.field' => $field
            )
        ));

        $this->id = $counter[$this->alias]['id'];
        return $this->saveField('next_value', $this->getNextValue($Model, $field) + 1);
    }

    public function getNextValue(Model $Model, $field)
    {
        $counter = $this->find('first', array(
            'conditions' => array(
                $this->alias . '.model' => $Model->alias,
                $this->alias . '.field' => $field
            )
        ));

        if (empty($counter)) {
            $this->create();
            $counter = $this->save(array(
                $this->alias => array(
                    'model' => $Model->alias,
                    'field' => $field
                )
            ));
        }

        return (int)$counter[$this->alias]['next_value'];
    }

    public function setNextValue(Model $Model, $field, $value)
    {
        $counter = $this->find('first', array(
            'conditions' => array(
                $this->alias . '.model' => $Model->alias,
                $this->alias . '.field' => $field
            )
        ));

        if (empty($counter)) {
            $this->create();
            return $counter = $this->save(array(
                $this->alias => array(
                    'model' => $Model->alias,
                    'field' => $field,
                    'next_value' => $value
                )
            ));
        }

        $this->id = $counter[$this->alias]['id'];
        return $this->saveField('next_value', $value);
    }

}
