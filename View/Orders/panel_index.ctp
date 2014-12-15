<table class="table">
	<caption>Orders</caption>
	<thead>
		<tr>
			<th><?php echo h(__d('webshop_orders', 'Order')); ?></th>
			<th><?php echo h(__d('webshop_orders', 'Actions')); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
		<tr>
			<td><?php echo h(__d('webshop_orders', 'Order #%1$d', $order['Order']['number'])); ?></td>
			<td><?php echo $this->CroogoHtml->link('View', array('customer' => $order['Customer']['id'], 'action' => 'view', $order['Order']['id']), array('button' => 'success')); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
