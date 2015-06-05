<?php

namespace Webshop\Invoices\View\helper;

use Cake\View\Helper;

class InvoicesHelper extends Helper {

	public function statusText($status) {
		if ($status === 'open') {
			return __d('webshop_invoices', 'Open');
		}
		if ($status === 'cancelled') {
			return __d('webshop_invoices', 'Cancelled');
		}
		if ($status === 'paid') {
			return __d('webshop_invoices', 'Paid');
		}
		if ($status === 'sent') {
			return __d('webshop_invoices', 'Sent');
		}
		if ($status === 'arrived') {
			return __d('webshop_invoices', 'Arrived');
		}
		if ($status === 'done') {
			return __d('webshop_invoices', 'Done');
		}
		return $status;
	}

	public function statusContext($status) {
		switch ($status) {
			case 'open':
				return 'warning';
			case 'paid':
			case 'sent':
				return 'info';
			case 'arrived':
				return 'success';
		}

		return '';
	}

	public function statusOptions() {
		return array(
			'open' => $this->statusText('open'),
			'cancelled' => $this->statusText('cancelled'),
			'paid' => $this->statusText('paid'),
			'sent' => $this->statusText('sent'),
			'arrived' => $this->statusText('arrived'),
			'done' => $this->statusText('done'),
		);
	}

}
