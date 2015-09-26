<?php if ((!isset($title)) || ($title)): ?>
    <strong><?php echo h($addressDetail->name); ?></strong>
<?php endif; ?>
<address>
    <?php echo h($addressDetail['address_line_1']); ?><br>
    <?php echo h($addressDetail['postcode']); ?> <?php echo h($addressDetail['city']); ?><br>
    <?php echo h($addressDetail['state']); ?>, <?php echo h($addressDetail['country']); ?>
</address>
