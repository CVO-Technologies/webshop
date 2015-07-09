<?php
$orders = $this->requestAction(array('plugin' => 'webshop_orders', 'controller' => 'orders', 'action' => 'index', '?' => array('customer' => $id), 'limit' => 10));
?>
<table class="table">
	<thead>
	<tr>
		<th><?php echo h(__d('webshop_orders', '#')); ?></th>
		<th><?php echo h(__d('webshop_orders', 'Status')); ?></th>
		<th><?php echo h(__d('webshop_orders', 'Date')); ?></th>
		<th><?php echo h(__d('webshop_orders', 'Amount')); ?></th>
		<th><?php echo h(__d('webshop_orders', 'Outstanding')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
		<tr class="<?php echo h($this->Order->statusContext($order['Order']['status'])); ?>">
			<td><?php echo $this->Html->link($order['Order']['number'], array('plugin' => 'webshop_orders', 'controller' => 'orders', 'action' => 'view', $order['Order']['id'])); ?></td>
			<td><?php echo h($this->Order->statusText($order['Order']['status'])); ?></td>
			<td><?php echo h($this->Time->i18nFormat($order['Order']['modified'], '%c')); ?></td>
			<td><?php echo h($this->Number->currency($order['Order']['amount'], 'EUR')); ?></td>
			<td><?php echo h($this->Number->currency($order['Order']['remaining'], 'EUR')); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>