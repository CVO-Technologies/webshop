<?php

$url = isset($url) ? $url : array('action' => 'index');

?>
<div class="clearfix filter">
	<?php
	echo $this->Form->create('Order', array(
		'class' => 'form-inline',
		'url' => $url,
		'inputDefaults' => array(
			'label' => false,
		),
	));

	echo $this->Form->input('customer_id', array(
		'label' => __d('webshop_orders', 'Customer id'),
		'type' => 'text',
	));

	echo $this->Form->input('status', array(
		'options' => array(
			'open' => $this->Order->statusText('open'),
			'cancelled' => $this->Order->statusText('cancelled'),
			'paid' => $this->Order->statusText('paid'),
			'sent' => $this->Order->statusText('sent'),
			'arrived' => $this->Order->statusText('arrived'),
			'done' => $this->Order->statusText('done'),
		),
		'empty' => __d('croogo', 'Status'),
	));

	echo $this->Form->input(__d('croogo', 'Filter'), array(
		'type' => 'submit',
	));
	echo $this->Form->end();
	?>
</div>
