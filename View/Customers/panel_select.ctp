<?php echo $this->Form->create(false, array(
	'type' => 'get',
	'class' => 'form-login form-wrapper form-narrow',
	'inputDefaults' => array(
		'div' => array(
			'class' => 'form-group'
		),
		'label' => array(
			'class' => 'sr-only'
		),
		'class' => 'form-control'
	),
	'url' => array(
		'panel' => true,
		'plugin' => 'webshop',
		'controller' => 'customers',
		'action' => 'select'
	)
)); ?>
	<h3 class="title-divider"><span><?php echo h(__d('webshop', 'Select customer')); ?></span></h3>
<p>Select the customer you would like the act on behalf of</p>
<?php echo $this->Form->input('customer', array('options' => $customers)); ?>

	<div class="btn-group">
		<?php
		echo $this->Form->submit( __d('croogo', 'Select'), array('class' => 'btn btn-primary', 'div' => false));
		?>
	</div>
<?php echo $this->Form->end(); ?>