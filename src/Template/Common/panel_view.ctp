<ul class="nav nav-tabs">
	<?php
	if ($tabHeading = $this->fetch('tab-heading')):
		echo $tabHeading;
	else:
		echo $this->Croogo->adminTab(__d('croogo', $modelClass), "#$tabId");
		echo $this->Croogo->adminTabs();
	endif;
	?>
</ul>

<?php

$tabContent = trim($this->fetch('tab-content'));
if (!$tabContent):
	$content = '';
	foreach ($editFields as $field => $opts):
		if (is_string($opts)) {
			$field = $opts;
			$opts = array(
				'label' => false,
				'tooltip' => ucfirst($field),
			);
		}
		$content .= $this->Form->input($field, $opts);
	endforeach;
endif;
?>

<?php
if (empty($tabContent) && !empty($content)):
	$tabContent = $this->Html->div('tab-pane', $content, array(
		'id' => $tabId,
	));
	$tabContent .= $this->Croogo->adminTabs();
endif;
echo $this->Html->div('tab-content', $tabContent);
?>
