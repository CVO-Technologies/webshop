<?php
$this->Title->setPageTitle(__d('webshop', 'Select customer'));

echo $this->Form->create(false, array(
	'type' => 'get',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal',
	'url' => array(
		'panel' => true,
		'plugin' => 'webshop',
		'controller' => 'customers',
		'action' => 'select'
	)
)); ?>
<p>Select the customer you would like the act on behalf of</p>
<?php echo $this->Form->input('customer', array('options' => $customers)); ?>

	<div class="btn-group">
		<?php
		echo $this->Form->submit( __d('croogo', 'Select'), array('class' => 'btn btn-primary', 'div' => false));
		?>
	</div>
<?php echo $this->Form->end(); ?>
