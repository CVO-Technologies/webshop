<strong>Order:</strong> #<?php echo h($order['Order']['number']); ?><br>
<strong>Shipping method:</strong> <?php echo h($orderShipment['Shipment']['ShippingMethod']['name']); ?>


<?php echo $this->Form->create(false); ?>
<table class="table">
	<thead>
		<tr>
			<th>Product</th>
			<th>Amount</th>
			<th>Current shipment</th>
			<th>Assign</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($orderProducts as $orderProduct): ?>
		<tr>
			<td><?php echo h($orderProduct['Product']['title']); ?></td>
			<td><?php echo h($orderProduct['OrderProduct']['amount']); ?></td>
			<td>
				<?php
				if (isset($orderProduct['OrderShipment']['Shipment'])):
					echo h($orderProduct['OrderShipment']['Shipment']['id']) . ' (' . h($orderProduct['OrderShipment']['Shipment']['status']) . ')';
				else:
					echo h('None');
				endif;
				?>
			</td>
			<td><?php echo $this->Form->checkbox('OrderProduct.' . $orderProduct['OrderProduct']['id']); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->Form->submit('Assign', array(
	'button' => 'success'
)); ?>
<?php echo $this->Form->end(); ?>
