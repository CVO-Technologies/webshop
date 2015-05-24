<?php
$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->addSegment(__d('webshop', 'Address details'));
$this->Title->setPageTitle(__d('webshop', 'Create address'));

$this->Title->addCrumbs(array(
	array('controller' => 'customers', 'action' => 'dashboard'),
	array('action' => 'index'),
	array('action' => 'add')
));

$modal = (isset($modal)) ? $modal : false;
?>
<div class="btn-group">
	<?php echo $this->Html->link(__d('webshop', 'Back'), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
</div>
<?php
echo $this->Form->create('AddressDetail', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => (($modal) ? '' : 'well') . ' form-horizontal'
));

echo $this->Form->inputs(array(
	'legend' => __d('webshop', 'Address details'),
	'AddressDetail.name' => array(
		'label' => 'Name',
		'placeholder' => 'Name this address'
	),
	'AddressDetail.street' => array(
		'label' => 'Street'
	),
	'AddressDetail.house_number' => array(
		'label' => 'House number'
	),
	'AddressDetail.house_number_addition' => array(
		'label' => 'House number addition'
	),
	'AddressDetail.postcode' => array(
		'label' => 'Postcode'
	),
	'AddressDetail.city' => array(
		'label' => 'City'
	),
	'AddressDetail.municipality' => array(
		'label' => 'Municipality'
	),
	'AddressDetail.province' => array(
		'label' => 'Province'
	),
	'AddressDetail.country' => array(
		'label' => 'Country',
		'options' => array(
			'NL' => 'The Netherlands'
		)
	)
));

echo $this->Form->submit('Create', array(
	'div' => 'col col-md-9 col-md-offset-3',
	'class' => 'btn btn-default'
));

echo $this->Form->end();
