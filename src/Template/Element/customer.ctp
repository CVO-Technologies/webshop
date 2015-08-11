<?php
if (isset($this->request->params['named']['customer'])):
    $customer = $this->requestAction(array('plugin' => 'webshop', 'controller' => 'customers', 'action' => 'view', $this->request->params['named']['customer']));
    ?>

    <strong>Name:</strong> <?php echo h($customer['Customer']['name']); ?>

<?php endif; ?>
