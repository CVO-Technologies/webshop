<?php
$invoices = $this->requestAction(array('plugin' => 'webshop_invoices', 'controller' => 'invoices', 'action' => 'index', '?' => array('customer_id' => $id), 'limit' => 10));
?>
<table class="table">
	<thead>
	<tr>
		<th><?php echo h(__d('webshop_invoices', '#')); ?></th>
		<th><?php echo h(__d('webshop_invoices', 'Status')); ?></th>
		<th><?php echo h(__d('webshop_invoices', 'Date')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($invoices as $invoice): ?>
		<tr class="<?php echo h($this->Invoices->statusContext($invoice['Invoice']['status'])); ?>">
			<td><?php echo $this->Html->link($invoice['Invoice']['number'], array('plugin' => 'webshop_invoices', 'controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id'])); ?></td>
			<td><?php echo h($this->Invoices->statusText($invoice['Invoice']['status'])); ?></td>
			<td><?php echo h($this->Time->i18nFormat($invoice['Invoice']['modified'], '%c')); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>