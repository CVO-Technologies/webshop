<p>
    Hello <?php echo h($contact['name']); ?>,
</p>

<p>
    <?php
    echo __d(
        'webshop_invoices',
        'On %1$s the status of invoice with number #%2$d has changed to <b>%3$s</b>.',
        $this->Time->i18nFormat(time(), '%c'),
        $invoice['Invoice']['number'],
        $invoice['Invoice']['status']
    );
    ?>
</p>
