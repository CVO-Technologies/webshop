<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <div class="row-fluid">
                <div class="span6">
                    <h2>Customer</h2>
                    <strong><?php echo h($invoice['Customer']['name']); ?></strong>
                    <ul>
                        <li><strong>Type</strong>: <?php echo h($invoice['Customer']['type']); ?></li>
                        <li><strong>VAT number</strong>: <?php echo h($invoice['Customer']['vat_number']); ?></li>
                    </ul>
                </div>
                <div class="span6">
                    <h2>Invoice address</h2>
                    <strong></strong>
                    <?php echo $this->element('Webshop.address', array('addressDetail' => $invoice['AddressDetail'])); ?>
                </div>
            </div>
        </div>
        <div class="well">
            <h2>Details</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Item price</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($invoice['InvoiceLine'] as $invoiceLine): ?>
                    <tr>
                        <td><?php echo h($invoiceLine['title']); ?></td>
                        <td><?php echo h($invoiceLine['description']); ?></td>
                        <td><?php echo h($this->Number->currency($invoiceLine['individual_price'], 'EUR')); ?></td>
                        <td><?php echo h($this->Number->precision($invoiceLine['amount'], 2)); ?></td>
                        <td><?php echo h(($invoiceLine['tax_revision_id']) ? $invoiceLine['TaxRevision']['Tax']['name'] : 'None'); ?></td>
                        <td><?php echo h($this->Number->currency($invoiceLine['price'], 'EUR')); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
