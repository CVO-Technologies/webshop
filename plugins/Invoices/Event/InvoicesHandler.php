<?php

App::uses('CakeEventListener', 'Event');

class InvoicesHandler implements CakeEventListener {

	private $__invoiceTypeOrderStatus = array(
		'full' => array(
			'delivered',
			'shipped'
		),
		'proforma' => array(
			'paid'
		)
	);

	public function __construct() {
		$this->Order = ClassRegistry::init('WebshopOrders.Order');
		$this->Invoice = ClassRegistry::init('WebshopInvoices.Invoice');
	}


	/**
	 * Returns a list of events this object is implementing. When the class is registered
	 * in an event manager, each individual method will be associated with the respective event.
	 *
	 * ## Example:
	 *
	 * {{{
	 *    public function implementedEvents() {
	 *        return array(
	 *            'Order.complete' => 'sendEmail',
	 *            'Article.afterBuy' => 'decrementInventory',
	 *            'User.onRegister' => array('callable' => 'logRegistration', 'priority' => 20, 'passParams' => true)
	 *        );
	 *    }
	 * }}}
	 *
	 * @return array associative array or event key names pointing to the function
	 * that should be called in the object when the respective event is fired
	 */
	public function implementedEvents() {
		$events = array();

		foreach ($this->__invoiceTypeOrderStatus as $type => $statuses) {
			foreach ($statuses as $status) {
				$events['Order.statusChangedTo' . Inflector::camelize($status)] = 'onOrderStatusChange';
			}
		}

		$events['Invoice.statusChanged'] = array(
			'callable' => 'onInvoiceStatusChange',
			'passParams' => true
		);

		return $events;
	}

	public function onOrderStatusChange($event) {
		foreach ($this->__invoiceTypeOrderStatus as $type => $statuses) {
			foreach ($statuses as $status) {
				if ($event->data['order']['status'] !== $status) {
					continue;
				}

				if ($type === 'full') {
					$this->onOrderStatusChangeFullInvoice($event);
				} elseif ($type === 'proforma')  {
					$this->onOrderStatusChangeProFormaInvoice($event);
				}
			}
		}
	}

	public function onOrderStatusChangeFullInvoice($event) {
		$this->Order->id = $event->data['order']['id'];

		$invoice = $this->Order->createInvoice('full');

		$this->Invoice->changeStatus('done', $invoice['Invoice']['id']);
	}

	public function onOrderStatusChangeProFormaInvoice($event) {
		$this->Order->id = $event->data['order']['id'];

		$invoice = $this->Order->createInvoice('proforma');

		$this->Invoice->changeStatus('done', $invoice['Invoice']['id']);
	}

	public function onInvoiceStatusChange($invoiceData) {
		$this->Invoice->id = $invoiceData['id'];

		$invoice = $this->Invoice->read();

		$this->Order->Customer->id = $invoice['Invoice']['customer_id'];
		$this->Order->Customer->recursive = 2;

		$customer = $this->Invoice->Customer->read();

		CakeLog::write(
			LOG_INFO,
			__d(
				'webshop_invoices',
				'Sending email about invoice status change to %1$s to contacts of customer %2$s',
				$invoice['Invoice']['status'],
				$customer['Customer']['name']
			),
			array('invoices', 'webshop')
		);

		foreach ($customer['CustomerContact'] as $contact) {
			$Email = new CakeEmail();
			$Email->template('WebshopInvoices.invoice_status_update', 'default')
				->emailFormat('html')
				->to($contact['email'])
				->from(Configure::read('Site.email'))
				->subject(__d('webshop_invoices', 'Status update for invoice #%1$d', $invoice['Invoice']['number']))
				->viewVars(compact('invoice', 'customer', 'contact'))
				->send();
		}

	}

}
