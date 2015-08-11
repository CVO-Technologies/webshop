<?php
$this->Title->setPageTitle(__d('webshop', 'Select customer'));

echo $this->Form->create(false, array(
    'type' => 'get',
    'class' => 'well form-horizontal',
));
$this->Form->templates([
    'div' => 'form-group',
    'wrapInput' => 'col col-md-9',
    'class' => 'form-control'
]);
?>
<p>Select the customer you would like the act on behalf of</p>
<?php echo $this->Form->input('customer', array('options' => $customers)); ?>

<div class="btn-group">
    <?php
    echo $this->Form->submit(__d('croogo', 'Select'), array('class' => 'btn btn-primary', 'div' => false));
    ?>
</div>
<?php echo $this->Form->end(); ?>
