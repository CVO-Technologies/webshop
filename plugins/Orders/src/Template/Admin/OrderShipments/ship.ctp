<?php echo $this->Form->create('Shipment'); ?>
<?php echo $this->Form->input('Shipment.weight'); ?>
<?php echo $this->Form->submit('Send'); ?>
<?php echo $this->Form->end(); ?>