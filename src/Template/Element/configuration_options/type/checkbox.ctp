<?php

echo $this->Form->input(
    $fieldName,
    $this->ConfigurationOption->inputOptions(
        $option['alias'],
        array(
            'type' => 'checkbox'
        )
    )
);
