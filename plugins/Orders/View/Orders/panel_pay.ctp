<?php echo $this->Form->create('Order'); ?>
<strong><?php echo h(__d('webshop_orders', 'Remaining')); ?></strong> <?php echo h($this->Number->currency($order['Order']['remaining'], 'EUR')); ?>
<?php echo $this->Form->submit(__d('webshop_orders', 'Pay')); ?>
<?php echo $this->Form->end(); ?>
