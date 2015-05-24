<?php

$configurationGroup = $this->requestAction(array('controller' => 'configuration_groups', 'action' => 'view', $product['ProductConfigurationGroup'][0]['configuration_group_id']));
debug($configurationGroup);

$this->ConfigurationOption->setConfigurationGroupDetails($configurationGroup);

echo $this->ConfigurationOption->form();

//debug($product);

