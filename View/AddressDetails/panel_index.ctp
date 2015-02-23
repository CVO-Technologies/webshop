<?php
$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->setPageTitle(__d('webshop', 'Address details'));

$this->Title->addCrumbs(array(
	array('controller' => 'customers', 'action' => 'dashboard'),
	array('action' => 'index')
));

$this->extend('Webshop.Common/panel_index');

$this->start('actions');
?>
<div class="btn-group">
<?php
echo $this->Html->link(
	__d('webshop', 'Back'),
	array('controller' =>  'customers', 'action' => 'dashboard'),
	array('class' => 'btn btn-default')
);
echo $this->Html->link(
	__d('webshop', 'Create'),
	array('action' => 'add'),
	array('class' => 'btn btn-success')
);
?>
</div>
<?php
$this->end();

$this->set('displayFields', array(
	'name' => array(
		'label' => __d('webshop', 'Name'),
		'sort' => true
	),
	'address' => array(
		'label' => __d('webshop', 'Address'),
		'element' => array(
			'element' => 'Webshop.address',
			'data' => array(
				'addressDetail' => 'AddressDetail'
			)
		),
		'sort' => false
	)
));
