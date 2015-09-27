<?php

$this->extend('Croogo/Core./Common/admin_index');
$this->Croogo->adminScript(array('Nodes.admin'));

$this->Html
    ->addCrumb('', '/admin', array('icon' => $this->Theme->getIcon('home')))
    ->addCrumb(__d('webshop_invoices', 'Invoices'), '/' . $this->request->url);

$this->append('search', $this->element('admin/invoices_search'));

$this->append('form-start', $this->Form->create(
    'Invoice',
    array(
        'url' => array('action' => 'process'),
        'class' => 'form-inline'
    )
));

$this->set('displayFields', array(
    'checkbox' => array(
        'label' => $this->Form->checkbox('Invoice.checkAll'),
        'sort' => false
    ),
    'number' => array(
        'label' => __d('webshop_invoices', 'Number'),
        'sort' => true
    ),
    'Customer.name' => array(
        'label' => __d('webshop_invoices', 'Customer'),
        'sort' => true
    ),
    'status' => array(
        'label' => __d('webshop_invoices', 'Status'),
        'sort' => true
    ),
    'price' => array(
        'label' => __d('webshop_invoices', 'Price'),
        'sort' => false
    ),
    'created' => array(
        'label' => __d('webshop_invoices', 'Created'),
        'sort' => true
    ),
));

$this->set('showActions', false);

$this->start('table-body');

foreach ($invoices as $invoice):
    switch ($invoice->status):
        case 'open':
            $invoiceColor = 'warning';
            break;
        case 'paid':
        case 'sent':
            $invoiceColor = 'info';
            break;
        case 'arrived':
            $invoiceColor = 'success';
            break;
        default:
            $invoiceColor = '';
    endswitch;
    ?>
    <tr class="<?php echo h($invoiceColor); ?>">
        <td><?php echo $this->Form->checkbox('Invoice.' . $invoice->id . '.id', array('class' => 'row-select')); ?></td>
        <td><?php echo $this->Html->link('#' . $invoice->number, array('action' => 'view', $invoice->id)); ?></td>
        <td><?php echo $this->Html->link($invoice->customer->name, array('plugin' => 'Webshop', 'controller' => 'Customers', 'action' => 'view', $invoice['Customer']['id'])); ?></td>
        <td><?php echo $this->Html->link($this->Invoices->statusText($invoice->status), array('?' => array('status' => $invoice->status))); ?></td>
        <td><?php echo h($this->Number->currency($invoice['Invoice']['prices']['total'], 'EUR')); ?></td>
        <td><?php echo h($invoice->created->i18nFormat([IntlDateFormatter::LONG, IntlDateFormatter::SHORT])); ?></td>
        <td>
            <div class="item-actions">
                <?php
                if ($invoice->status === 'arrived'):
//					echo $this->Croogo->adminRowAction(
//						__d('webshop_Invoices', 'Mark as done'),
//						array('action' => 'mark_done', $Invoice['Invoice']['id']),
//						array('button' => 'success', 'method' => 'post')
//					);
                endif;
                //				if (($Invoice['Invoice']['status'] !== 'cancelled') && ($Invoice['Invoice']['status'] !== 'done')):
                //					echo $this->Croogo->adminRowAction(
                //						__d('webshop_Invoices', 'Cancel'),
                //						array('action' => 'cancel', $Invoice['Invoice']['id']),
                //						array('button' => 'warning', 'method' => 'post')
                //					);
                //				endif;
                echo $this->Croogo->adminRowActions($invoice->id);
                ?>
            </div>
        </td>
    </tr>
    <?php
endforeach;

$this->end();

$this->start('bulk-action');
echo $this->Form->input('Invoice.action', array(
    'label' => __d('croogo', 'Applying to selected'),
    'div' => 'input inline',
    'options' => array(
        'cancel' => __d('croogo', 'Cancel'),
    ),
    'empty' => true,
));

$jsVarName = uniqid('confirmMessage_');
$button = $this->Form->button(__d('croogo', 'Submit'), array(
    'type' => 'button',
    'class' => 'bulk-process',
    'data-relatedElement' => '#' . $this->Form->domId('Invoice.action'),
    'data-confirmMessage' => $jsVarName,
));
echo $this->Html->div('controls', $button);
$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();

$this->append('form-end', $this->Form->end());
