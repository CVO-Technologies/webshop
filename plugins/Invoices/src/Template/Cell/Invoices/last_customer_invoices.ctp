<table class="table">
    <thead>
    <tr>
        <th><?php echo h(__d('webshop_invoices', '#')); ?></th>
        <th><?php echo h(__d('webshop_invoices', 'Status')); ?></th>
        <th><?php echo h(__d('webshop_invoices', 'Date')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($invoices as $invoice): ?>
        <tr class="<?php echo h($this->Invoices->statusContext($invoice->status)); ?>">
            <td><?php echo $this->Html->link($invoice->number, array('plugin' => 'Webshop/Invoices', 'controller' => 'Invoices', 'action' => 'view', $invoice->id)); ?></td>
            <td><?php echo h($this->Invoices->statusText($invoice->status)); ?></td>
            <td><?php echo h($invoice->modified->i18nFormat([IntlDateFormatter::LONG, IntlDateFormatter::SHORT])); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
