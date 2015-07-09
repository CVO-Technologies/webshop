<?php
use Croogo\Core\Nav;

$this->Title->setPageTitle(__d('webshop', 'Dashboards'));

$this->Title->addCrumbs(array(
	['action' => 'dashboard'],
));
?>

<div class="row">
	<div class="col-md-6">
		<h3><span>Account informatie</span>
			<small><a href="clientarea?action=details">Werk uw gegevens bij</a></small>
		</h3>
		<span><strong><?php echo h($customer->name); ?></strong></span><br/>
		<span><?php echo h(__d('webshop', 'Address details')); ?>: <?php echo $this->Html->link(__d('webshop', 'View all'), array('controller' => 'AddressDetails', 'action' => 'index'), array('escape' => false)); ?></span>
	</div>
	<div class="col-md-6">
		<h3>
            <span>Account overzicht</span>
			<small>Een simpel account overzicht.</small>
		</h3>
		<?php foreach (Nav::items('webshop-customer-dashboard') as $options): ?>
			<?php echo $this->Html->link($options['before'] . $options['title'] . $options['after'], $options['url'], array('escape' => false, 'class' => 'btn btn-default')); ?><br/>
		<?php endforeach; ?>
	</div>
</div>
<br/>


<div class="row">

	<div class="col-md-6">
		<a class="btn btn-primary btn-xs pull-right" style="margin-top: 22px;" href="submitticket"><i
				class="glyphicon glyphicon-comment"></i> Open ticket</a>

		<h3><span>Open ticket</span></h3>

		<ul class="list-group">
			<li class="list-group-item">
				<i>Er zijn momenteel geen open tickets</i>
			</li>
		</ul>
	</div>

	<div class="col-md-6">
		<h3><span>Verschuldigde facturen</span></h3>

        <?= $this->cell('Webshop/Invoices.OutstandingInvoices::panelDashboard', ['limit' => 5]); ?>
	</div>

    <div class="col-md-6">
        <h3><span>Lopende orders</span></h3>

        <?= $this->cell('Webshop/Orders.CurrentOrders::panelDashboard', ['limit' => 5]); ?>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3><span>Ons laatste nieuws</span></h3>
	</div>
</div>
<div class="row">
    <?= $this->cell('Webshop.Announcements::panelDashboard', ['limit' => 2]); ?>
</div>
