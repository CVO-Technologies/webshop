<div class="row">
    <div class="col-xs-6">
        <h1>
            <a href="https://twitter.com/tahirtaous">
                <img src="logo.png">
                Logo here
            </a>
        </h1>
    </div>
    <div class="col-xs-6 text-right">
        <h1><?php echo ($invoice->type === 'proforma') ? 'PRO FORMA ' : ''; ?>INVOICE</h1>

        <h1>
            <small>Invoice #<?php echo h($invoice->number); ?></small>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>From: <a href="#">Your Name</a></h4>
            </div>
            <div class="panel-body">
                <p>
                    Address <br>
                    details <br>
                    more <br>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>To : <a href="#"><?php echo h($invoice->customer->name); ?></a></h4>
            </div>
            <div class="panel-body">
                <p>
                    <?php echo $this->element('Webshop.address_detail', array('addressDetail' => $invoice->address_detail)); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- / end client details section -->
<table class="table table-bordered">
    <thead>
    <tr>
        <th>
            <h4>Service</h4>
        </th>
        <th>
            <h4>Description</h4>
        </th>
        <th>
            <h4>Hrs/Qty</h4>
        </th>
        <th>
            <h4>Rate/Price</h4>
        </th>
        <th>
            <h4>Sub Total</h4>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($invoice->invoice_lines as $invoiceLine): ?>
        <tr>
            <td><?php echo h($invoiceLine->title); ?></td>
            <td><?php echo h($invoiceLine->description); ?></td>
            <td class="text-right"><?php echo h($this->Number->precision($invoiceLine->amount, 2)); ?></td>
            <td class="text-right"><?php echo h($this->Number->currency($invoiceLine->individual_price, 'EUR')); ?></td>
            <td class="text-right"><?php echo h($this->Number->currency($invoiceLine->price, 'EUR')); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="row text-right">
    <div class="col-xs-2 col-xs-offset-8">
        <p>
            <strong>
                <?php foreach ($invoice['Invoice']['prices']['shippingCosts'] as $shippingCost): ?>
                    Shipping: <br>
                <?php endforeach; ?>
                <?php foreach ($invoice['Invoice']['prices']['transactionCosts'] as $transactionCosts): ?>
                    Transactioncosts: <br>
                <?php endforeach; ?>
                Sub Total : <br>
                <?php foreach ($invoice['Invoice']['prices']['taxes'] as $tax): ?>
                    TAX <?php echo h($tax['percentage']); ?>% : <br>
                <?php endforeach; ?>
                Total : <br>
            </strong>
        </p>
    </div>
    <div class="col-xs-2">
        <strong>
            <?php foreach ($invoice['Invoice']['prices']['shippingCosts'] as $shippingCost): ?>
                <?php echo h($this->Number->currency($shippingCost['amount'], 'EUR')); ?> <br>
            <?php endforeach; ?>
            <?php foreach ($invoice['Invoice']['prices']['transactionCosts'] as $transactionCosts): ?>
                <?php echo h($this->Number->currency($transactionCosts['amount'], 'EUR')); ?> <br>
            <?php endforeach; ?>
            <?php echo h($this->Number->currency($invoice['Invoice']['prices']['subTotal'], 'EUR')); ?> <br>
            <?php foreach ($invoice['Invoice']['prices']['taxes'] as $tax): ?>
                <?php echo h($this->Number->currency($tax['amount'], 'EUR')); ?><br>
            <?php endforeach; ?>
            <?php echo h($this->Number->currency($invoice['Invoice']['prices']['total'], 'EUR')); ?> <br>
        </strong>
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>Bank details</h4>
            </div>
            <div class="panel-body">
                <p>Your Name</p>

                <p>Bank Name</p>

                <p>SWIFT : --------</p>

                <p>Account Number : --------</p>

                <p>IBAN : --------</p>
            </div>
        </div>
    </div>
    <div class="col-xs-7">
        <div class="span7">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Contact Details</h4>
                </div>
                <div class="panel-body">
                    <p>
                        Email : you@example.com <br><br>
                        Mobile : -------- <br> <br>
                        Twitter : <a href="https://twitter.com/tahirtaous">@TahirTaous</a>
                    </p>
                    <h4>Payment should be made by Bank Transfer</h4>
                </div>
            </div>
        </div>
    </div>
</div>
