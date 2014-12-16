<?php

foreach ($configurationGroup['ConfigurationOption'] as $configurationOption):
	?>
		<?php echo $this->ConfigurationOption->input($configurationOption['alias'], $options['input']); ?>
<?php
endforeach;

//debug($configurationGroup);
