<?php

use Cake\Utility\Hash;
use Cake\Utility\Inflector;

if (empty($modelClass)) {
	$modelClass = Inflector::singularize($this->name);
}
if (!isset($className)) {
	$className = strtolower($this->name);
}

$showActions = isset($showActions) ? $showActions : true;

if ($pageHeading = trim($this->fetch('page-heading'))):
	echo $pageHeading;
endif;
?>

<?php if ($showActions): ?>
	<div class="row">
		<div class="actions col-lg-12">
			<?php
			if ($actionsBlock = $this->fetch('actions')):
				echo $actionsBlock;
			else:
				echo $this->Html->link(
					__d('webshop', 'Create'),
					array('action' => 'add'),
					array('class' => 'btn btn-success')
				);
			endif;
			?>
		</div>
	</div>
<?php endif; ?>

<?php
$tableHeaders = trim($this->fetch('table-heading'));
if (!$tableHeaders && isset($displayFields)):
	$tableHeaders = array();
	foreach ($displayFields as $field => $arr):
		if ($arr['sort']):
			$tableHeaders[] = $this->Paginator->sort($field, __d('croogo', $arr['label']));
		else:
			$tableHeaders[] = __d('croogo', $arr['label']);
		endif;
	endforeach;
	$tableHeaders[] = __d('croogo', 'Actions');
	$tableHeaders = $this->Html->tableHeaders($tableHeaders);
endif;

$tableBody = trim($this->fetch('table-body'));
if (!$tableBody && isset($displayFields)):
	$rows = array();
	if (!empty(${Inflector::variable($this->name)})):
		foreach (${Inflector::variable($this->name)} as $item):
			$actions = array();

			if (isset($this->request->query['chooser'])):
				$title = isset($item[$modelClass]['title']) ? $item[$modelClass]['title'] : null;
				$actions[] = $this->Croogo->adminRowAction(__d('croogo', 'Choose'), '#', array(
					'class' => 'item-choose',
					'data-chooser_type' => $modelClass,
					'data-chooser_id' => $item[$modelClass]['id'],
				));
			else:
//				$actions[] = $this->element('Webshop.action_menu', array('id' => $item[$modelClass]['id'], 'model' => Inflector::tableize($modelClass)));
			endif;
			$actions = $this->Html->div('item-actions', implode(' ', $actions));
			$row = array();
			foreach ($displayFields as $key => $val):
				extract($val);
				if (!is_int($key)) {
					$val = $key;
				}
				if (strpos($val, '.') === false) {
					$val = $modelClass . '.' . $val;
				}
				list($model, $field) = pluginSplit($val);
				if (isset($element)):
					$elementData = array();
					foreach ($element['data'] as $key => $path):
						$elementData[$key] = Hash::extract($item, $path);
					endforeach;
					$row[] = $this->element($element['element'], $elementData);

					unset($element);
				else:
					$row[] = $this->Layout->displayField($item, $model, $field, compact('type', 'url', 'options'));

					unset($type);
					unset($url);
					unset($options);
				endif;
			endforeach;
			$row[] = $actions;
			$rows[] = $row;
		endforeach;
		$tableBody = $this->Html->tableCells($rows);
	endif;
endif;

$tableFooters = trim($this->fetch('table-footer'));

?>
	<div class="row">
		<div class="col-lg-12">
			<?php
			$searchBlock = $this->fetch('search');
			if (!$searchBlock):
				$searchBlock = $this->element('Croogo/Croogo.admin/search');
			endif;
			echo $searchBlock;

			if ($contentBlock = trim($this->fetch('content'))):
				echo $this->element('Croogo/Croogo.admin/search');
				echo $contentBlock;
			else:

				if ($formStart = trim($this->fetch('form-start'))):
					echo $formStart;
				endif;

				if ($mainBlock = trim($this->fetch('main'))):
					echo $mainBlock;
				else:
					?>
					<table class="table">
						<?php
						echo $tableHeaders;
						echo $tableBody;
						if ($tableFooters):
							echo $tableFooters;
						endif;
						?>
					</table>
				<?php endif; ?>

				<?php if ($bulkAction = trim($this->fetch('bulk-action'))): ?>
				<div class="row">
					<div id="bulk-action" class="control-group">
						<?php echo $bulkAction; ?>
					</div>
				</div>
			<?php endif; ?>

				<?php
				if ($formEnd = trim($this->fetch('form-end'))):
					echo $formEnd;
				endif;

				echo $this->fetch('postLink');
				?>

			<?php endif; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php
			if ($pagingBlock = $this->fetch('paging')):
				echo $pagingBlock;
			else:
				if (isset($this->Paginator) && isset($this->request['paging'])):
					echo $this->element('pagination');
				endif;
			endif;
			?>
		</div>
	</div>
<?php

if ($pageFooter = trim($this->fetch('page-footer'))):
	echo $pageFooter;
endif;
