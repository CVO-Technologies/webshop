<?php
$this->Html->addCrumb(
	'Contacts',
	array('customer' => $customer_contacts[0]['Customer']['id'], 'action' => 'index')
);
$this->Html->addCrumb(
	'Contacts',
	array('customer' => $customer_contacts[0]['Customer']['id'], 'action' => 'index')
);
?>

<table class="table">
	<thead>
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($customer_contacts as $customer_contact): ?>
		<tr>
			<td><?php echo h($customer_contact['CustomerContact']['name']); ?></td>
			<td><?php echo h($customer_contact['CustomerContact']['email']); ?></td>
			<td>
				<?php
				echo $this->CroogoHtml->link(
					'Edit',
					array(
						'action' => 'edit',
						$customer_contact['CustomerContact']['id']
					),
					array(
						'button' => 'success'
					)
				);
				echo $this->CroogoHtml->link(
					'View',
					array(
						'action' => 'view',
						$customer_contact['CustomerContact']['id']
					),
					array(
						'button' => 'success'
					)
				);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>