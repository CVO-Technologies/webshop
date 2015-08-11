<?php
if ($this->request->param('action') === 'add'):
    $actionPartTitle = __d('webshop', 'Create address');
elseif ($this->request->param('action') === 'edit'):
    $actionPartTitle = __d('webshop', 'Edit address - {0}', $addressDetail->name);
endif;

$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->addSegment(__d('webshop', 'Address details'));
$this->Title->setPageTitle($actionPartTitle);

if ($this->request->param('action') === 'add'):
    $actionPart = ['action' => 'add'];
elseif ($this->request->param('action') === 'edit'):
    $actionPart = ['action' => 'edit', $addressDetail->id];
endif;
$this->Title->addCrumbs([
    ['controller' => 'Customers', 'action' => 'dashboard'],
    ['action' => 'index'],
    $actionPart
]);
?>
<div class="row">
    <div class="actions col-sm-4 col-md-2">
        <div class="btn-group btn-group-justified">
            <?= $this->Html->link(__d('webshop', 'Back'), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= $this->Form->create($addressDetail, ['horizontal' => true, 'class' => 'well']); ?>

        <?php
        echo $this->Form->inputs([
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name this address'
            ],
            'address_line_1' => [
                'label' => 'Address line 1'
            ],
            'address_line_2' => [
                'label' => 'Address line 2'
            ],
            'street' => [
                'label' => 'Street'
            ],
            'house_number' => [
                'label' => 'House number'
            ],
            'house_number_addition' => [
                'label' => 'House number addition'
            ],
            'postcode' => [
                'label' => 'Postcode'
            ],
            'city' => [
                'label' => 'City'
            ],
            'municipality' => [
                'label' => 'Municipality'
            ],
            'province' => [
                'label' => 'Province'
            ],
            'state' => [
                'label' => 'State'
            ],
            'country' => [
                'label' => 'Country',
                'options' => [
                    'NL' => 'The Netherlands'
                ]
            ]
        ], [
            'legend' => __d('webshop', 'Address details')
        ]);
        ?>

        <?= $this->Form->submit(($this->request->param('action') === 'add') ? __d('webshop', 'Create') : __d('webshop', 'Update')); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>
