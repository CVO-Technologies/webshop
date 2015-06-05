<?php
$invoices = $this->requestAction(array('plugin' => 'webshop_invoices', 'controller' => 'invoices', 'action' => 'index', '?' => array('status' => 'open')));
?>
<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>Customer</th>
		<th>Created</th>
		<th>Amount</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($invoices as $invoice): ?>
		<tr>
			<td><?php echo $this->Html->link($invoice['Invoice']['number'], array('plugin' => 'webshop_invoices', 'controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id'])); ?></td>
			<td><?php echo $this->Html->link($invoice['Customer']['name'], array('plugin' => 'webshop', 'controller' => 'customers', 'action' => 'view', $invoice['Customer']['id'])); ?></td>
			<td><?php echo h($this->Time->timeAgoInWords($invoice['Invoice']['created'])); ?></td>
			<td><?php echo h($this->Number->currency($invoice['Invoice']['prices']['total'], 'EUR')); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>