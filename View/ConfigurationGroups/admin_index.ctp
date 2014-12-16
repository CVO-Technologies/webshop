<?php

$this->extend('/Common/admin_index');
//$this->Croogo->adminScript(array('Nodes.admin'));

$this->Html
		->addCrumb('', '/admin', array('icon' => $this->Theme->getIcon('home')))
		->addCrumb(__d('webshop', 'Webshop'))
		->addCrumb(__d('webshop', 'Configuration groups'), '/' . $this->request->url);

//$this->append('actions');
//echo $this->Croogo->adminAction(
//		__d('croogo', 'Create content'),
//		array('action' => 'create'),
//		array('button' => 'success')
//);
//$this->end();

$this->append('form-start', $this->Form->create(
		'ConfigurationGroup',
		array(
				'url' => array('action' => 'process'),
				'class' => 'form-inline'
		)
));

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
	<?php foreach ($configurationGroups as $configurationGroup): ?>
		<tr>
			<td><?php echo $this->Form->checkbox('ConfigurationGroup.' . $configurationGroup['ConfigurationGroup']['id'] . '.id', array('class' => 'row-select')); ?></td>
			<td><?php echo $configurationGroup['ConfigurationGroup']['id']; ?></td>
			<td><?php echo $configurationGroup['ConfigurationGroup']['name']; ?></td>
			<td>
				<div class="item-actions">
					<?php
					echo $this->Croogo->adminRowActions($configurationGroup['ConfigurationGroup']['id']);
					echo ' ' . $this->Croogo->adminRowAction('',
							array('controller' => 'configuration_options', 'action' => 'index', 'configuration_group' => $configurationGroup['ConfigurationGroup']['id']),
							array('icon' => $this->Theme->getIcon('inspect'))
						);
					echo ' ' . $this->Croogo->adminRowAction('',
									array('action' => 'edit', $configurationGroup['ConfigurationGroup']['id']),
									array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item'))
							);
					echo ' ' . $this->Croogo->adminRowAction('',
									'#Node' . $configurationGroup['ConfigurationGroup']['id'] . 'Id',
									array(
											'icon' => $this->Theme->getIcon('copy'),
											'tooltip' => __d('croogo', 'Create a copy'),
											'rowAction' => 'copy',
									)
							);
					echo ' ' . $this->Croogo->adminRowAction('',
									'#Node' . $configurationGroup['ConfigurationGroup']['id'] . 'Id',
									array(
											'icon' => $this->Theme->getIcon('delete'),
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
