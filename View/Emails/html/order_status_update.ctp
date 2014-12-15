<p>
Hello <?php echo h($contact['name']); ?>,
</p>

<p>
	<?php
	echo __d(
		'webshop_orders',
		'On %1$s the status of order with number #%2$d has changed to <b>%3$s</b>.',
		$this->Time->i18nFormat(time(), '%c'),
		$order['Order']['number'],
		$this->Order->statusText($order['Order']['status'])
	);
	?>
</p>
