<?php
$this->Title->setPageTitle(__d('webshop', 'Dashboards'));

$this->Title->addCrumbs(array(
	array('controller' => 'customers', 'action' => 'dashboard'),
));
?>

<div class="row">
	<div class="col-md-6">
		<h3 class="title-divider"><span>Account informatie</span>
			<small><a href="clientarea?action=details">Werk uw gegevens bij</a></small>
		</h3>
		<span><strong><?php echo h($customer['Customer']['name']); ?></strong></span><br/>
		<span><?php echo h(__d('webshop', 'Address details')); ?>: <?php echo $this->Html->link(__d('webshop', 'View all'), array('panel' => true, 'plugin' => 'webshop', 'controller' => 'address_details', 'action' => 'index'), array('escape' => false)); ?></span>
	</div>
	<div class="col-md-6">
		<h3 class="title-divider"><span>Account overzicht</span>
			<small>Een simpel account overzicht.</small>
		</h3>
		<?php foreach (CroogoNav::items('webshop-customer-dashboard') as $options): ?>
			<?php echo $this->Html->link($options['before'] . $options['title'] . $options['after'], $options['url'], array('escape' => false, 'class' => 'btn btn-default')); ?><br/>
		<?php endforeach; ?>
	</div>
</div>
<br/>


<div class="row">

	<div class="col-md-6">
		<a class="btn btn-primary btn-xs pull-right" style="margin-top: 22px;" href="submitticket"><i
				class="glyphicon glyphicon-comment"></i> Open ticket</a>

		<h3 class="title-divider"><span style="font-weight: normal;">Open ticket</span></h3>

		<ul class="list-group">
			<li class="list-group-item">
				<i>Er zijn momenteel geen open tickets</i>
			</li>
		</ul>
	</div>

	<div class="col-md-6">
		<h3 class="title-divider"><span style="font-weight: normal;">Verschuldigde facturen</span></h3>

		<ul class="list-group">
			<li class="list-group-item">
				<i>Op dit moment zijn er geen openstaande facturen</i>
			</li>

		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3 class="title-divider"><span style="font-weight: normal;">Ons laatste nieuws</span></h3>
	</div>
</div>
<div class="row">
	<?php $announcements = $this->requestAction(array('panel' => false, 'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index', 'type' => 'announcement')); ?>
	<?php foreach ($announcements as $announcement): ?>
		<?php $this->Nodes->set($announcement); ?>
		<div class="col-md-6">
			<strong><?php echo h($announcement['Node']['title']); ?></strong> (10/10/2014)<br/>
			<?php echo $this->Nodes->excerpt(); ?>
			<br/><br/>
			<?php echo $this->Html->link('Meer...', $this->Nodes->field('url'), array('class' => 'btn btn-primary')); ?>
		</div>
	<?php endforeach; ?>
</div>
