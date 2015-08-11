<?php
$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->setPageTitle(__d('webshop_orders', 'Orders'));

$this->Title->addCrumbs(array(
    array('plugin' => 'Webshop', 'controller' => 'Customers', 'action' => 'dashboard'),
    array('action' => 'index')
));
?>

<div class="btn-group">
    <?php echo $this->Html->link(__d('webshop', 'Back'), array('plugin' => 'Webshop', 'controller' => 'Customers', 'action' => 'dashboard'), array('class' => 'btn btn-default')); ?>
</div>

<table class="table">
    <caption>Orders</caption>
    <thead>
    <tr>
        <th><?php echo h(__d('webshop_orders', 'Order number')); ?></th>
        <th><?php echo h(__d('webshop_orders', 'Status')); ?></th>
        <th><?php echo h(__d('webshop_orders', 'Date')); ?></th>
        <th><?php echo h(__d('webshop_orders', 'Outstanding')); ?></th>
        <th><?php echo h(__d('webshop_orders', 'Actions')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo h(__d('webshop_orders', 'Order #{0}', $order->number)); ?></td>
            <td><?php echo h($this->Orders->statusText($order->status)); ?></td>
            <td><?php echo h($order->modified->i18nFormat([\IntlDateFormatter::SHORT, \IntlDateFormatter::NONE])); ?></td>
            <td><?php echo h($this->Number->currency($order->remaining, 'EUR')); ?></td>
            <td>
                <?php echo $this->element('Webshop.action_menu', array('id' => $order->id, 'model' => 'order')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
