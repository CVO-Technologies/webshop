<?php $this->assign('title', __d('webshop_orders', 'Order #%1$d', $order['Order']['number'])); ?>

<strong><?php echo h(__d('webshop_orders', 'Amount')); ?>:</strong> <?php echo h($this->Number->currency($order['Order']['amount'], 'EUR')); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Remaining')); ?>:</strong> <?php echo h($this->Number->currency($order['Order']['remaining'], 'EUR')); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Status')); ?>:</strong> <?php echo h($this->Order->statusText($order['Order']['status'])); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Customer')); ?>:</strong> <?php echo h($order['Customer']['name']); ?><br>

<?php if (!empty($order['OrderShipment'])): ?>
	<table class="table">
		<caption>Shipments</caption>
		<thead>
		<tr>
			<th>Description</th>
			<th>Method</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($order['OrderShipment'] as $orderShipment): ?>
			<tr>
				<td><?php echo h($orderShipment['Shipment']['id']); ?></td>
				<td><?php echo h($orderShipment['Shipment']['ShippingMethod']['name']); ?></td>
				<td>
					<?php echo $this->element('WebshopShipping.shipment_information', array('shipmentId' => $orderShipment['Shipment']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<table class="table">
	<caption>Products</caption>
	<thead>
	<tr>
		<th>Name</th>
		<th>Amount</th>
		<th>Price</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($order['OrderProduct'] as $orderProduct): ?>
		<tr>
			<td><?php echo h($orderProduct['Product']['title']); ?></td>
			<td><?php echo h($orderProduct['amount']); ?></td>
			<td><?php echo h($orderProduct['price']); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<table class="table">
	<caption>Payments</caption>
	<thead>
	<tr>
		<th>Description</th>
		<th>Amount</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($order['OrderPayment'] as $orderPayment): ?>
		<tr>
			<td><?php echo h($orderPayment['Payment']['description']); ?></td>
			<td><?php echo h($orderPayment['Payment']['amount']); ?></td>
			<td><?php echo h($orderPayment['Payment']['status']); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php if ($order['Order']['remaining'] > 0): ?>
<?php echo $this->CroogoHtml->link(__d('webshop_orders', 'Pay'), array('action' => 'pay', $order['Order']['id']), array('button' => 'success')); ?>
<?php endif; ?>