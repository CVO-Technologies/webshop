<?php

$this->extend('Croogo/Core./Common/admin_view');

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('webshop', 'Customer'), '#customer-main');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('customer-main');
?>

    <div class="row-fluid">
        <div class="span9">
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
        <div class="span3">
            <div class="well">
                <h2>Contacts</h2>
                <?php foreach ($customer->customer_contacts as $customerContact): ?>
                    <?php echo $this->element('Webshop.customer_contact', compact('customerContact')); ?>
                    <div class="btn-group">
                        <?php echo $this->Html->link(__d('webshop', 'Edit'), array('controller' => 'customer_contacts', 'action' => 'edit', $customerContact->id), array('class' => 'btn btn-default')); ?>
                        <?php echo $this->Html->link(__d('webshop', 'Contact'), array('controller' => 'customer_contacts', 'action' => 'contact', $customerContact->id), array('class' => 'btn btn-primary')); ?>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
            <div class="well">
                <h2>Address details</h2>
                <?php foreach ($customer->address_details as $addressDetail): ?>
                    <?php echo $this->element('Webshop.address_detail', compact('addressDetail')); ?>
                    <div class="btn-group">
                        <?php echo $this->Html->link(__d('webshop', 'Edit'), array('controller' => 'address_details', 'action' => 'edit', $addressDetail->id), array('class' => 'btn btn-default')); ?>
                        <?php echo $this->Form->postLink(__d('webshop', 'Make invoice address'), array('controller' => 'customers', 'action' => 'set_invoice_address_detail', $customer['id'], $addressDetail->id), array('class' => 'btn btn-warning')); ?>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php

echo $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

$this->end();
