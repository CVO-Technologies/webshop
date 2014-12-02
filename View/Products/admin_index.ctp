<?php

$this->extend('/Common/admin_index');
//$this->Croogo->adminScript(array('Nodes.admin'));

$this->Html
		->addCrumb('', '/admin', array('icon' => $_icons['home']))
		->addCrumb(__d('webshop', 'Webshop'))
		->addCrumb(__d('webshop', 'Products'), '/' . $this->request->url);

//$this->append('actions');
//echo $this->Croogo->adminAction(
//		__d('croogo', 'Create content'),
//		array('action' => 'create'),
//		array('button' => 'success')
//);
//$this->end();

//$this->append('form-start', $this->Form->create(
//		'Node',
//		array(
//				'url' => array('controller' => 'nodes', 'action' => 'process'),
//				'class' => 'form-inline'
//		)
//));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id', __d('croogo', 'Id')),
		$this->Paginator->sort('title', __d('croogo', 'Title')),
//		$this->Paginator->sort('type', __d('croogo', 'Type')),
//		$this->Paginator->sort('user_id', __d('croogo', 'User')),
//		$this->Paginator->sort('status', __d('croogo', 'Status')),
		''
));
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
?>
	<tbody>
	<?php foreach ($products as $product): ?>
		<tr>
			<td><?php echo $product['Product']['id']; ?></td>
			<td><?php echo $product['Product']['title']; ?></td>
			<td>
				<div class="item-actions">
					<?php
					echo $this->Croogo->adminRowActions($product['Product']['id']);
					echo ' ' . $this->Croogo->adminRowAction('',
									array('action' => 'edit', $product['Product']['id']),
									array('icon' => $_icons['update'], 'tooltip' => __d('croogo', 'Edit this item'))
							);
					echo ' ' . $this->Croogo->adminRowAction('',
									'#Node' . $product['Product']['id'] . 'Id',
									array(
											'icon' => $_icons['copy'],
											'tooltip' => __d('croogo', 'Create a copy'),
											'rowAction' => 'copy',
									)
							);
					echo ' ' . $this->Croogo->adminRowAction('',
									'#Node' . $product['Product']['id'] . 'Id',
									array(
											'icon' => $_icons['delete'],
											'class' => 'delete',
											'tooltip' => __d('croogo', 'Remove this item'),
											'rowAction' => 'delete',
									),
									__d('croogo', 'Are you sure?')
							);
					?>
				</div>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
<?php
$this->end();

$this->start('bulk-action');
echo $this->Form->input('Node.action', array(
		'label' => __d('croogo', 'Applying to selected'),
		'div' => 'input inline',
		'options' => array(
				'publish' => __d('croogo', 'Publish'),
				'unpublish' => __d('croogo', 'Unpublish'),
				'promote' => __d('croogo', 'Promote'),
				'unpromote' => __d('croogo', 'Unpromote'),
				'delete' => __d('croogo', 'Delete'),
				'copy' => array(
						'value' => 'copy',
						'name' => __d('croogo', 'Copy'),
						'hidden' => true,
				),
		),
		'empty' => true,
));

$jsVarName = uniqid('confirmMessage_');
$button = $this->Form->button(__d('croogo', 'Submit'), array(
		'type' => 'button',
		'onclick' => sprintf('return Nodes.confirmProcess(app.%s)', $jsVarName),
));
echo $this->Html->div('controls', $button);
$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));

$this->end();

$this->append('form-end', $this->Form->end());
