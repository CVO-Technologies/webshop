<?php
$prefix = (!isset($prefix)) ? '' : $prefix;
$contactDetails = (isset($contactDetails)) ? $contactDetails : true;
?>
<?php echo $this->Html->script('Webshop.webshop', array('inline' => false)); ?>
<?php
echo $this->Form->inputs(array(
    'legend' => 'Customer details',
    (((isset($subData)) && ($subData)) ? '' : $prefix . '.') . 'Customer.name',
    (((isset($subData)) && ($subData)) ? '' : $prefix . '.') . 'Customer.type' => array(
        'options' => array(
            'individual' => 'Individual',
            'company' => 'Company'
        )
    ),
    (((isset($subData)) && ($subData)) ? '' : $prefix . '.') . 'Customer.vat_number' => array(
        'div' => array(
            'class' => 'form-group company-only'
        )
    ),
));

if ($contactDetails):
    echo $this->Form->inputs(array(
        'legend' => __d('webshop', 'Contact details'),
        $prefix . 'CustomerContact.0.name' => array(
            'label' => 'Name'
        ),
        $prefix . 'CustomerContact.0.email' => array(
            'label' => 'Email'
        )
    ));
endif;

echo $this->Form->inputs(array(
    'legend' => __d('webshop', 'Address details'),
    $prefix . 'AddressDetail.0.street' => array(
        'label' => 'Street'
    ),
    $prefix . 'AddressDetail.0.house_number' => array(
        'label' => 'House number'
    ),
    $prefix . 'AddressDetail.0.house_number_addition' => array(
        'label' => 'House number addition'
    ),
    $prefix . 'AddressDetail.0.postcode' => array(
        'label' => 'Postcode'
    ),
    $prefix . 'AddressDetail.0.city' => array(
        'label' => 'City'
    ),
    $prefix . 'AddressDetail.0.municipality' => array(
        'label' => 'Municipality'
    ),
    $prefix . 'AddressDetail.0.province' => array(
        'label' => 'Province'
    ),
    $prefix . 'AddressDetail.0.country' => array(
        'label' => 'Country',
        'options' => array(
            'NL' => 'The Netherlands'
        )
    )
));
?>
