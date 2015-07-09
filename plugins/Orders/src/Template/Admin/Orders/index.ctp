<?php

$this->extend('/Common/admin_index');
$this->Croogo->adminScript(array('Nodes.admin'));

$this->Html
	->addCrumb('', '/admin', array('icon' => $this->Theme->getIcon('home')))
	->addCrumb(__d('webshop_orders', 'Orders'), '/' . $this->request->url);

$this->append('search', $this->element('admin/orders_search'));

$this->append('form-start', $this->Form->create(
	'Order',
	array(
		'url' => array('action' => 'process'),
		'class' => 'form-inline'
	)
));

$this->set('displayFields', array(
	'checkbox' => array(
		'label' => $this->Form->checkbox('Order.checkAll'),
		'sort' => false
	),
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
		<td><?php echo $this->Form->checkbox('Order.' . $order['Order']['id'] . '.id', array('class' => 'row-select')); ?></td>
		<td><?php echo $this->Html->link('#' . $order['Order']['number'], array('action' => 'view', $order['Order']['id'])); ?></td>
		<td><?php echo $this->Html->link($order['Customer']['name'], array('plugin' => 'webshop', 'controller' => 'customers', 'action' => 'view', $order['Customer']['id'])); ?></td>
		<td><?php echo $this->Html->link($this->Order->statusText($order['Order']['status']), array('?' => array('status' => $order['Order']['status']))); ?></td>
		<td>
			<div class="item-actions">
				<?php
				if ($order['Order']['status'] === 'arrived'):
//					echo $this->Croogo->adminRowAction(
//						__d('webshop_orders', 'Mark as done'),
//						array('action' => 'mark_done', $order['Order']['id']),
//						array('button' => 'success', 'method' => 'post')
//					);
				endif;
//				if (($order['Order']['status'] !== 'cancelled') && ($order['Order']['status'] !== 'done')):
//					echo $this->Croogo->adminRowAction(
//						__d('webshop_orders', 'Cancel'),
//						array('action' => 'cancel', $order['Order']['id']),
//						array('button' => 'warning', 'method' => 'post')
//					);
//				endif;
				echo $this->Croogo->adminRowActions($order['Order']['id']);
				?>
			</div>
		</td>
	</tr>
<?php
endforeach;

$this->end();

$this->start('bulk-action');
echo $this->Form->input('Order.action', array(
	'label' => __d('croogo', 'Applying to selected'),
	'div' => 'input inline',
	'options' => array(
		'cancel' => __d('croogo', 'Cancel'),
	),
	'empty' => true,
));

$jsVarName = uniqid('confirmMessage_');
$button = $this->Form->button(__d('croogo', 'Submit'), array(
	'type' => 'button',
	'class' => 'bulk-process',
	'data-relatedElement' => '#' . $this->Form->domId('Order.action'),
	'data-confirmMessage' => $jsVarName,
));
echo $this->Html->div('controls', $button);
$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();

$this->append('form-end', $this->Form->end());
