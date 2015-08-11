<?php $this->assign('title', __d('webshop_orders', 'Order #{0}', $order->number)); ?>

<strong><?php echo h(__d('webshop_orders', 'Amount')); ?>
    :</strong><?php echo h($this->Number->currency($order->amount, 'EUR')); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Remaining')); ?>
    :</strong><?php echo h($this->Number->currency($order->remaining, 'EUR')); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Status')); ?>
    :</strong><?php echo h($this->Orders->statusText($order->status)); ?><br>
<strong><?php echo h(__d('webshop_orders', 'Customer')); ?>:</strong><?php echo h($order->customer->name); ?><br>

<?php //if (!empty($order->order_shipments)): ?>
<!--	<table class="table">-->
<!--		<caption>Shipments</caption>-->
<!--		<thead>-->
<!--		<tr>-->
<!--			<th>Description</th>-->
<!--			<th>Method</th>-->
<!--			<th>Status</th>-->
<!--		</tr>-->
<!--		</thead>-->
<!--		<tbody>-->
<!--		--><?php //foreach ($order['OrderShipment'] as $orderShipment): ?>
<!--			<tr>-->
<!--				<td>--><?php //echo h($orderShipment['Shipment']['id']); ?><!--</td>-->
<!--				<td>--><?php //echo h($orderShipment['Shipment']['ShippingMethod']['name']); ?><!--</td>-->
<!--				<td>-->
<!--					--><?php //echo $this->element('WebshopShipping.shipment_information', array('shipmentId' => $orderShipment['Shipment']['id'])); ?>
<!--				</td>-->
<!--			</tr>-->
<!--		--><?php //endforeach; ?>
<!--		</tbody>-->
<!--	</table>-->
<?php //endif; ?>

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
    <?php foreach ($order->order_products as $orderProduct): ?>
        <tr>
            <td><?php echo h($orderProduct->product->title); ?></td>
            <td><?php echo h($orderProduct->amount); ?></td>
            <td><?php echo h($orderProduct->price); ?></td>
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
    <?php foreach ($order->order_payments as $orderPayment): ?>
        <tr>
            <td><?php echo h($orderPayment->payment->description); ?></td>
            <td><?php echo h($orderPayment->payment->amount); ?></td>
            <td><?php echo h($orderPayment->payment->status); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if ($order->remaining > 0): ?>
    <?php echo $this->Html->link(__d('webshop_orders', 'Pay'), array('action' => 'pay', $order->id), array('button' => 'success')); ?>
<?php endif; ?>
