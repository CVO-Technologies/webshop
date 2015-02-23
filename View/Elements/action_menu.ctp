<?php

echo $this->ButtonMenu->buttonMenu($id, CroogoNav::items('webshop-dashboard-' . $model . '-actions'), array(
	'htmlAttributes' => array(
		'class' => 'btn-group'
	)
));
