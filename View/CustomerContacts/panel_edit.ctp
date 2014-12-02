<?php
$this->Html->addCrumb(
	'Contacts',
	array('customer' => $this->request->data['Customer']['id'], 'action' => 'index')
);
$this->Html->addCrumb(
	$this->request->data['CustomerContact']['name'],
	'/' . $this->here
);

debug($this->Html->getCrumbs());
?>
<?php echo $this->Form->create('CustomerContact'); ?>

<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('email'); ?>

<?php echo $this->Form->submit('Save'); ?>
<?php echo $this->Form->end(); ?>