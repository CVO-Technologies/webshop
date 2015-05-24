<?php

class ProductHelper extends AppHelper {

	public function statusText($status) {
		if ($status === 'open') {
			return __d('webshop', 'Open');
		}
		if ($status === 'cancelled') {
			return __d('webshop', 'Cancelled');
		}
		if ($status === 'paid') {
			return __d('webshop', 'Paid');
		}
		if ($status === 'sent') {
			return __d('webshop', 'Sent');
		}
		if ($status === 'arrived') {
			return __d('webshop', 'Arrived');
		}
		if ($status === 'done') {
			return __d('webshop', 'Done');
		}
		return $status;
	}

}
