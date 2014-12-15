<?php

class OrderHelper extends AppHelper {

	public function statusText($status) {
		if ($status === 'open') {
			return __d('webshop_order', 'Open');
		}
		if ($status === 'cancelled') {
			return __d('webshop_order', 'Cancelled');
		}
		if ($status === 'paid') {
			return __d('webshop_order', 'Paid');
		}
		if ($status === 'sent') {
			return __d('webshop_order', 'Sent');
		}
		if ($status === 'arrived') {
			return __d('webshop_order', 'Arrived');
		}
		if ($status === 'done') {
			return __d('webshop_order', 'Done');
		}
		return $status;
	}

}
