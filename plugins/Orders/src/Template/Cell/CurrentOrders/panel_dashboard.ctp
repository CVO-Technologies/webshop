<?php
/** @var $orders \Cake\Collection\Collection */
?>
<ul class="list-group">
    <?php if ($orders->isEmpty()): ?>
        <li class="list-group-item">
            <i>Op dit moment zijn er geen lopende orders</i>
        </li>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <li class="list-group-item">
                        <span class="pull-right">
                        <span data-toggle="tooltip" title="Factuurdatum"><?= $order->created->i18nFormat(); ?></span> |
                        <span data-toggle="tooltip" title="Verloopdatum">05/07/2015</span> |
                        <span data-toggle="tooltip" title="Totaal">€ 6.05</span>

                        </span>
                <?= $this->Html->link('#' . $order->number, ['plugin' => 'Webshop/Orders', 'controller' => 'Orders', 'action' => 'view', $order->id, '_ext' => 'pdf']) ?> - <?= $this->Html->link(__d('webshop/invoices', 'Pay invoice'), ['plugin' => 'Webshop/Orders', 'controller' => 'Orders', 'action' => 'view', $order->id]) ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
