<?php

echo $this->Form->create('Customer', array(
    'class' => '',
    'inputDefaults' => array(
        'div' => array(
            'class' => 'form-group'
        ),
        'class' => 'form-control'
    )
));

echo $this->Form->input('Customer.name');

echo $this->Form->input('Customer.type', array(
    'options' => array(
        'individual' => 'Individual',
        'company' => 'Company'
    )
));
echo $this->Form->input('Customer.vat_number', array('label' => 'VAT number'));
?>
<fieldset>
    <legend>Address detail</legend>
    <?php
    echo $this->Form->input('AddressDetail.address_line_1');
    echo $this->Form->input('AddressDetail.address_line_2');
    echo $this->Form->input('AddressDetail.city');
    echo $this->Form->input('AddressDetail.state');
    echo $this->Form->input('AddressDetail.postcode');
    echo $this->Form->input('AddressDetail.country');
    ?>
</fieldset>

<fieldset>
    <legend>Contact</legend>
    <?php
    echo $this->Form->input('CustomerContact.name');
    echo $this->Form->input('CustomerContact.email');
    ?>
</fieldset>

<?php
echo $this->Form->submit('Create', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>
