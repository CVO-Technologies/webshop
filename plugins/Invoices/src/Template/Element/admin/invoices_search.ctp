<?php

$url = isset($url) ? $url : array('action' => 'index');

?>
<div class="clearfix filter">
    <?php
    echo $this->Form->create('Invoice', array(
        'class' => 'form-inline',
        'url' => $url,
        'inputDefaults' => array(
            'label' => false,
        ),
    ));

    echo $this->Form->input('customer_id', array(
        'label' => __d('webshop_invoices', 'Customer id'),
        'type' => 'text',
    ));

    echo $this->Form->input('status', array(
        'options' => $this->Invoices->statusOptions(),
        'empty' => __d('croogo', 'Status'),
    ));

    echo $this->Form->input(__d('croogo', 'Filter'), array(
        'type' => 'submit',
    ));
    echo $this->Form->end();
    ?>
</div>
