<?php
$this->Title->addSegment(__d('webshop', 'Dashboard'));
$this->Title->setPageTitle(__d('webshop', 'Address details'));

$this->Title->addCrumbs([
    ['_name' => 'panel_dashboard'],
    ['action' => 'index']
]);

$this->extend('Webshop./Common/panel_index');

$this->start('actions');
?>
    <div class="btn-group btn-group-justified">
        <?php
        echo $this->Html->link(
            __d('webshop', 'Back'),
            ['_name' => 'panel_dashboard'],
            ['class' => 'btn btn-default']
        );
        echo $this->Html->link(
            __d('webshop', 'Create'),
            ['action' => 'add'],
            ['class' => 'btn btn-success']
        );
        ?>
    </div>
<?php
$this->end();

$this->set('displayFields', [
    'name' => [
        'label' => __d('webshop', 'Name'),
        'sort' => true,
        'type' => 'string'
    ],
    'address' => [
        'label' => __d('webshop', 'Address'),
        'element' => [
            'element' => 'Webshop.address',
            'data' => [
                'addressDetail' => '.'
            ]
        ],
        'sort' => false
    ]
]);
