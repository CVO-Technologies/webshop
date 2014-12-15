<?php
$this->extend('/Common/admin_index');

$this->set('displayFields', array(
	'number' => array(
		'label' => __d('webshop_payments_cash', 'Number'),
		'sort'  => true
	),
	'Customer.name' => array(
		'label' => __d('webshop_payments_cash', 'Customer'),
		'sort'  => true
	),
	'status' => array(
		'label' => __d('webshop_payments_cash', 'Status'),
		'sort'  => true
	)
));

$this->set('showActions', false);

$this->start('table-body');

foreach ($orders as $order):
	switch ($order['Order']['status']):
		case 'open':
			$orderColor = 'warning';
			break;
		case 'paid':
		case 'sent':
			$orderColor = 'info';
			break;
		case 'arrived':
			$orderColor = 'success';
			break;
		default:
			$orderColor = '';
	endswitch;
	?>
	<tr class="<?php echo h($orderColor); ?>">
		<td><?php echo $this->Html->link('#' . $order['Order']['number'], array('action' => 'view', $order['Order']['id'])); ?></td>
		<td><?php echo h($order['Customer']['name']); ?></td>
		<td><?php echo h($this->Order->statusText($order['Order']['status'])); ?></td>
		<td>
			<div class="item-actions">
				<?php
				if ($order['Order']['status'] === 'arrived'):
					echo $this->Croogo->adminRowActions($order['Order']['id']);
					echo $this->Croogo->adminRowAction(
						__d('webshop_orders', 'Mark as done'),
						array('action' => 'mark_done', $order['Order']['id']),
						array('button' => 'success', 'method' => 'post')
					);
				endif;
				if (($order['Order']['status'] !== 'cancelled') && ($order['Order']['status'] !== 'done')):
					echo $this->Croogo->adminRowAction(
						__d('webshop_orders', 'Cancel'),
						array('action' => 'cancel', $order['Order']['id']),
						array('button' => 'warning', 'method' => 'post')
					);
				endif;
				?>
			</div>
		</td>
	</tr>
<?php
endforeach;

$this->end();
