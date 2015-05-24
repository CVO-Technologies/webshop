<?php

$this->extend('default');

?>

<p>
	Hello <?php echo h($contact['name']); ?>,
</p>

<?php echo $this->fetch('content'); ?>
