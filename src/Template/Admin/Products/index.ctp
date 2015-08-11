<?php

$this->extend('Croogo/Croogo./Common/admin_index');
//$this->Croogo->adminScript(array('Nodes.admin'));

$this->CroogoHtml
    ->addCrumb('', '/admin', array('icon' => 'home'))
    ->addCrumb(__d('webshop', 'Webshop'))
    ->addCrumb(__d('webshop', 'Products'), '/' . $this->request->url);

//$this->append('actions');
//echo $this->Croogo->adminAction(
//		__d('croogo', 'Create content'),
//		array('action' => 'create'),
//		array('button' => 'success')
//);
//$this->end();

//$this->append('form-start', $this->Form->create(
//		'Node',
//		array(
//				'url' => array('controller' => 'nodes', 'action' => 'process'),
//				'class' => 'form-inline'
//		)
//));

?>
    <table class="table">
        <?php
        $tableHeaders = $this->CroogoHtml->tableHeaders(array(
            $this->Paginator->sort('id', __d('croogo', 'Id')),
            $this->Paginator->sort('title', __d('croogo', 'Title')),
//		$this->Paginator->sort('type', __d('croogo', 'Type')),
//		$this->Paginator->sort('user_id', __d('croogo', 'User')),
//		$this->Paginator->sort('status', __d('croogo', 'Status')),
            ''
        ));
        echo $this->CroogoHtml->tag('thead', $tableHeaders);

        ?>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $this->CroogoHtml->link($product->title, array('admin' => false) + $product->url->getArrayCopy(), array('target' => '_blank')); ?></td>
                <td>
                    <div class="item-actions">
                        <?php
                        echo $this->Croogo->adminRowActions($product->id);
                        echo ' ' . $this->Croogo->adminRowAction('',
                                array('action' => 'edit', $product->id),
                                array('icon' => 'update', 'tooltip' => __d('croogo', 'Edit this item'))
                            );
                        echo ' ' . $this->Croogo->adminRowAction('',
                                '#Node' . $product->id . 'Id',
                                array(
                                    'icon' => 'copy',
                                    'tooltip' => __d('croogo', 'Create a copy'),
                                    'rowAction' => 'copy',
                                )
                            );
                        echo ' ' . $this->Croogo->adminRowAction('',
                                '#Node' . $product->id . 'Id',
                                array(
                                    'icon' => 'delete',
                                    'class' => 'delete',
                                    'tooltip' => __d('croogo', 'Remove this item'),
                                    'rowAction' => 'delete',
                                ),
                                __d('croogo', 'Are you sure?')
                            );
                        ?>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php

$this->start('bulk-action');
echo $this->Form->input('Node.action', array(
    'label' => __d('croogo', 'Applying to selected'),
    'div' => 'input inline',
    'options' => array(
        'publish' => __d('croogo', 'Publish'),
        'unpublish' => __d('croogo', 'Unpublish'),
        'promote' => __d('croogo', 'Promote'),
        'unpromote' => __d('croogo', 'Unpromote'),
        'delete' => __d('croogo', 'Delete'),
        'copy' => array(
            'value' => 'copy',
            'name' => __d('croogo', 'Copy'),
            'hidden' => true,
        ),
    ),
    'empty' => true,
));

//$jsVarName = uniqid('confirmMessage_');
//$button = $this->Form->button(__d('croogo', 'Submit'), array(
//		'type' => 'button',
//		'onclick' => sprintf('return Nodes.confirmProcess(app.%s)', $jsVarName),
//));
//echo $this->CroogoHtml->div('controls', $button);
//$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));

$this->end();

$this->append('form-end', $this->Form->end());
