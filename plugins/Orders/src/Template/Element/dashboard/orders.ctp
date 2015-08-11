<?php

$orders = $this->requestAction(array('admin' => true, 'plugin' => 'webshop_orders', 'controller' => 'orders', 'action' => 'index'));

?>

<table class="table">
    <thead>
    <tr>
        <th>Number</th>
        <th>Amount</th>
        <th>Remaining</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo h($order['Order']['number']); ?></td>
            <td><?php echo h($order['Order']['amount']); ?></td>
            <td><?php echo h($order['Order']['remaining']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
