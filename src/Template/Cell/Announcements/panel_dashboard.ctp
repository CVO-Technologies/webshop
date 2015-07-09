<?php foreach ($announcements as $announcement): ?>
    <?php $this->Nodes->set($announcement); ?>
    <div class="col-md-6">
        <strong><?= h($announcement->title); ?></strong> (<?= $announcement->created->i18nFormat([\IntlDateFormatter::SHORT, \IntlDateFormatter::NONE]); ?>)<br/>
        <?= $this->Nodes->excerpt(); ?>
        <br/><br/>
        <?= $this->Html->link('Meer...', $this->Nodes->field('url')->getArrayCopy(), ['class' => 'btn btn-primary']); ?>
    </div>
<?php endforeach; ?>
