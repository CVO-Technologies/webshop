<?php

use Croogo\Core\Nav;

echo $this->ButtonMenu->buttonMenu($id, Nav::items('webshop-dashboard-' . $model . '-actions'), array(
    'htmlAttributes' => array(
        'class' => 'btn-group'
    )
));
