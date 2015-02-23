<div class="row-fluid">
	<div class="span9">
		<div class="well">
			<div class="row-fluid">
				<div class="span6">
					<h1><?php echo h($customer['Customer']['name']); ?></h1>
					<ul>
						<li><strong><?php echo h(__d('webshop', 'Type')); ?></strong>: <?php echo h($customer['Customer']['type']); ?></li>
						<li><strong><?php echo h(__d('webshop', 'VAT number')); ?></strong>: <?php echo h($customer['Customer']['vat_number']); ?></li>
					</ul>
				</div>
				<div class="span6">
					<h2>Invoice address</h2>
					<?php echo $this->element('Webshop.address_detail', array('addressDetail' => $customer['InvoiceAddressDetail'])); ?>
				</div>
			</div>
		</div>
		<div class="well">
			<h2>Orders</h2>
			<?php echo $this->element('WebshopOrders.admin/latest_customer_orders', array('id' => $customer['Customer']['id'])); ?>
		</div>
		<div class="well">
			<h2>Invoices</h2>
			<?php echo $this->element('WebshopInvoices.admin/latest_customer_invoices', array('id' => $customer['Customer']['id'])); ?>
		</div>
	</div>
	<div class="span3">
		<div class="well">
			<h2>Contacts</h2>
			<?php foreach ($customer['CustomerContact'] as $customerContact): ?>
				<?php echo $this->element('Webshop.customer_contact', compact('customerContact')); ?>
				<div class="btn-group">
					<?php echo $this->Html->link(__d('webshop', 'Edit'), array('controller' => 'customer_contacts', 'action' => 'edit', $customerContact['id']), array('class' => 'btn btn-default')); ?>
					<?php echo $this->Html->link(__d('webshop', 'Contact'), array('controller' => 'customer_contacts', 'action' => 'contact', $customerContact['id']), array('class' => 'btn btn-primary')); ?>
				</div>
				<br>
			<?php endforeach; ?>
		</div>
		<div class="well">
			<h2>Address details</h2>
			<?php foreach ($customer['AddressDetail'] as $addressDetail): ?>
				<?php echo $this->element('Webshop.address_detail', compact('addressDetail')); ?>
				<div class="btn-group">
					<?php echo $this->Html->link(__d('webshop', 'Edit'), array('controller' => 'address_details', 'action' => 'edit', $addressDetail['id']), array('class' => 'btn btn-default')); ?>
					<?php echo $this->Form->postLink(__d('webshop', 'Make invoice address'), array('controller' => 'customers', 'action' => 'set_invoice_address_detail', $customer['Customer']['id'], $addressDetail['id']), array('class' => 'btn btn-warning')); ?>
				</div>
				<br>
			<?php endforeach; ?>
		</div>
	</div>
</div>
