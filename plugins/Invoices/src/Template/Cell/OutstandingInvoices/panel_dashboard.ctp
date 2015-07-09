<?php
/** @var $invoices \Cake\Collection\Collection */
?>
<ul class="list-group">
    <?php if ($invoices->isEmpty()): ?>
        <li class="list-group-item">
            <i>Op dit moment zijn er geen openstaande facturen</i>
        </li>
    <?php else: ?>
        <?php foreach ($invoices as $invoice): ?>
            <li class="list-group-item">
                        <span class="pull-right">
                        <span data-toggle="tooltip" title="Factuurdatum"><?= $invoice->created->i18nFormat(); ?></span> |
                        <span data-toggle="tooltip" title="Verloopdatum">05/07/2015</span> |
                        <span data-toggle="tooltip" title="Totaal">€ 6.05</span>

                        </span>
                <?= $this->Html->link('#' . $invoice->number, ['plugin' => 'Webshop/Invoices', 'controller' => 'Invoices', 'action' => 'view', $invoice->id, '_ext' => 'pdf']) ?> - <?= $this->Html->link(__d('webshop/invoices', 'Pay invoice'), ['plugin' => 'Webshop/Invoices', 'controller' => 'Invoices', 'action' => 'view', $invoice->id]) ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
