<?php

$this->extend('Croogo/Core./Common/admin_view');

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('webshop', 'Customer'), '#customer-main');
echo $this->Croogo->adminTab(__d('webshop', 'Contacts'), '#customer-contacts');
echo $this->Croogo->adminTab(__d('webshop', 'Addresses'), '#customer-addresses');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('customer-main');
?>

    <div class="row-fluid">
        <div class="span12">
            <div class="well">
                <div class="row-fluid">
                    <div class="span6">
                        <h1><?php echo h($customer->name); ?></h1>
                        <ul>
                            <li>
                                <strong><?php echo h(__d('webshop', 'Type')); ?></strong>: <?php echo h($customer->type); ?>
                            </li>
                            <li>
                                <strong><?php echo h(__d('webshop', 'VAT number')); ?></strong>: <?php echo h($customer->vat_number); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="span3">
                        <h2>Invoice address</h2>
                        <?php echo $this->element('Webshop.address_detail', array('addressDetail' => $customer->invoice_address_detail)); ?>
                    </div>
                    <div class="span3">
                        <h2>Financial contect</h2>
                        <?php echo $this->element('Webshop.customer_contact', array('customerContact' => $customer->financial_contact)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->Html->tabEnd(); ?>

<?= $this->Html->tabStart('customer-contacts'); ?>
<div class="btn-group">
    <?= $this->Html->link(__d('webshop', 'Add contact'), ['controller' => 'CustomerContacts', 'action' => 'add', '?' => ['customer_id' => $customer->id]], ['class' => 'btn btn-success']); ?>
</div>

<table class="table">
    <thead>
    <tr>
        <th><?= h(__d('webshop', 'Name')); ?></th>
        <th><?= h(__d('webshop', 'Email address')); ?></th>
        <th><?= h(__d('webshop', 'Telephone number')); ?></th>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customer->contacts as $contact): ?>
        <tr>
            <td><?= h($contact->name); ?></td>
            <td><?= h($contact->email); ?></td>
            <td><?= h($contact->telephone); ?></td>
            <td>
                <div class="btn-group">
                    <?= $this->Form->postLink(__d('webshop', 'Make financial contact'), ['action' => 'setFinancialContact', $customer->id, $contact->id], ['class' => 'btn btn-primary', 'block' => true, 'disabled' => $customer->financial_contact_id === $contact->id]); ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $this->Html->tabEnd(); ?>

<?= $this->Html->tabStart('customer-addresses'); ?>
    <div class="btn-group">
        <?= $this->Html->link(__d('webshop', 'Add address'), ['controller' => 'CustomerAddressDetails', 'action' => 'add', '?' => ['customer_id' => $customer->id]], ['class' => 'btn btn-success']); ?>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th><?= h(__d('webshop', 'Name')); ?></th>
            <th><?= h(__d('webshop', 'Address')); ?></th>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customer->address_details as $addressDetail): ?>
            <tr>
                <td><?= h($addressDetail->name); ?></td>
                <td><?= $this->element('Webshop.address_detail', ['addressDetail' => $addressDetail, 'title' => false]); ?></td>
                <td>
                    <div class="btn-group">
                        <?= $this->Form->postLink(__d('webshop', 'Make invoice address'), ['action' => 'setInvoiceAddressDetail', $customer->id, $addressDetail->id], ['class' => 'btn btn-primary', 'block' => true, 'disabled' => $customer->invoice_address_detail_id === $addressDetail->id]); ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->Html->tabEnd(); ?>

<?= $this->Croogo->adminTabs(); ?>

<?= $this->fetch('postLink'); ?>

<?php
$this->end();
