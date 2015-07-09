<?php

namespace Webshop\Orders\Model\Table;

use Cake\ORM\Table;

class OrdersTable extends Table {

	public $filterArgs = array(
		'status' => array('type' => 'value'),
		'customer_id' => array('type' => 'value'),
	);

    public function initialize(array $config)
    {
        parent::initialize($config);

//        $this->addBehavior('Webshop.Counter', [
//            'fields' => [
//                'number' => [
//                    'count' => true
//                ]
//            ]
//        ]);
        $this->addBehavior('Webshop.Status');
        $this->addBehavior('Webshop.CustomerOwned');
        $this->addBehavior('Croogo/Core.BulkProcess', [
            'actionsMap' => [
                'cancel' => 'bulkCancel'
            ]
        ]);
        $this->addBehavior('Search.Searchable');

        $this->belongsTo('Customers', [
            'className' => 'Webshop.Customers',
            'foreignKey' => 'customer_id'
        ]);
        $this->belongsTo('InvoiceAddressDetail', [
            'className' => 'Webshop.AddressDetails',
            'foreignKey' => 'invoice_address_detail_id'
        ]);

        $this->hasMany('OrderProducts', [
            'className' => 'WebshopOrders.OrderProducts',
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('OrderPayments', [
            'className' => 'WebshopOrders.OrderPayments',
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('OrderShipments', [
            'className' => 'WebshopOrders.OrderShipments',
            'foreignKey' => 'order_id'
        ]);
    }


    public function createFromProductList($customerId, $productsList) {
		$products = $this->OrderProduct->Product->find('all', array(
			'conditions' => array(
				'id' => array_keys($productsList)
			),
			'contain' => array(
				'ProductConfigurationGroup'
			)
		));

		$amount = 0;
//		foreach ($products as $product) {
//			$amount += $product['Product']['price'] * (int) $productsList[(int) $product['Product']['id']]['amount'];
//		}

		$data = array(
			$this->alias => array(
				'status' => 'open',
//				'amount' => $amount,
//				'remaining' => $amount,
				'customer_id' => $customerId
			),
			$this->OrderProduct->alias => array(

			)
		);

		foreach ($products as $product) {
			$orderProduct = array(
				'product_id' => $product['Product']['id'],
				'amount' => (int)$productsList[(int)$product['Product']['id']]['amount'],
				'price' => (float)$product['Product']['price']
			);
			$orderProduct[$this->OrderProduct->OrderProductOption->alias] = array();

			$optionPrices = 0;
			foreach ($product['ProductConfigurationGroup'] as $productConfigurationGroup) {
				foreach ($productsList[(int)$product['Product']['id']]['configuration'] as $alias => $value) {
					$configurationOption = $this->OrderProduct->OrderProductOption->ConfigurationOption->find('first', array(
						'conditions' => array(
							'configuration_group_id' => $productConfigurationGroup['configuration_group_id'],
							'alias' => $alias
						)
					));
					if (!$configurationOption) {
						continue;
					}

					if ($configurationOption['ConfigurationOption'][ 'type'] !== 'list') {
						$optionPrice = $value / (float) $configurationOption['ConfigurationOption']['step'] * (float) $configurationOption['ConfigurationOption']['step_price'];
					} else {
						foreach ($configurationOption['ConfigurationOptionItem'] as $configurationOptionItem) {
							if ($configurationOptionItem['id'] !== $value) {
								continue;
							}

							$optionPrice = (float) $configurationOptionItem['price'];
						}
					}

					$optionPrices += $optionPrice;

					$orderProduct[$this->OrderProduct->OrderProductOption->alias][] = array(
						'configuration_option_id' => $configurationOption['ConfigurationOption']['id'],
						'configuration_option_item_id' => ($configurationOption['ConfigurationOption'][ 'type'] === 'list') ? $value : null,
						'value' => ($configurationOption['ConfigurationOption'][ 'type'] !== 'list') ? $value : null,
						'price' => $optionPrice
					);
				}
			}
			$orderProduct['price'] += $optionPrices;
			$amount += $orderProduct['price'] * (int) $productsList[(int) $product['Product']['id']]['amount'];

			$data[$this->OrderProduct->alias][] = $orderProduct;
		}

		$data[$this->alias]['amount'] = $amount;
		$data[$this->alias]['remaining'] = $amount;

		$this->saveAssociated($data, array('deep' => true));

		return $this->read();
	}

	public function createPayment($id, $redirectRoute, $amount = null) {
		$this->id = $id;
		$order = $this->read();

		if ($amount === null) {
			$amount = (float) $order[$this->alias]['remaining'];
		}

		$this->OrderPayment->Payment->create();
		$this->OrderPayment->Payment->save(array(
			$this->OrderPayment->Payment->alias => array(
				'amount' => $amount,
				'description' => __d('webshop_orders', 'Order #%1$d', $order[$this->alias]['number']),
				'status' => 'new',
				'redirect_route' => $redirectRoute
			)
		));

		$this->OrderPayment->create();
		$this->OrderPayment->save(array(
			$this->OrderPayment->alias => array(
				'order_id' => $id,
				'payment_id' => $this->OrderPayment->Payment->getID()
			)
		));

		return $this->OrderPayment->Payment->read();
	}

	public function createShipment($id, $shippingMethodId, $addressDetailId) {
		$this->id = $id;

		$this->OrderShipment->Shipment->create();
		$this->OrderShipment->Shipment->save(array(
			$this->OrderShipment->Shipment->alias => array(
				'shipping_method_id' => $shippingMethodId,
				'address_detail_id' => $addressDetailId,
				'status' => 'new',
				'weight' => 10
			)
		));

		$this->OrderShipment->create();
		$this->OrderShipment->save(array(
			$this->OrderShipment->alias => array(
				'order_id' => $id,
				'shipment_id' => $this->OrderShipment->Shipment->getID()
			)
		));

		return $this->OrderShipment->Shipment->read();
	}

//	public function updateStatus($id, $status) {
//		$this->id = $id;
//		$this->saveField('status', $status);
//
//		$order = $this->read();
//
//		CakeLog::write(
//			LOG_INFO,
//			__d(
//				'webshop_orders',
//				'Changed status of order #%1$d to %2$s',
//				$order['Order']['number'],
//				$status
//			),
//			array('orders', 'webshop')
//		);
//
//		$this->Customer->id = $order['Order']['customer_id'];
//		$this->Customer->recursive = 2;
//
//		$customer = $this->Customer->read();
//
//		foreach ($customer['CustomerContact'] as $contact) {
//			$Email = new CakeEmail();
//			$Email->template('WebshopOrders.order_status_update', 'default')
//				->emailFormat('html')
//				->to($contact['email'])
//				->from(Configure::read('Site.email'))
//				->subject(__d('webshop_orders', 'Status update for order #%1$d', $order['Order']['number']))
//				->viewVars(compact('order', 'customer', 'contact'))
//				->send();
//		}
//	}

	public function bulkCancel($ids) {
		foreach ($ids as $id) {
			$success = $this->changeStatus('cancelled', $id);

			if (!$success) {
				return false;
			}
		}

		return true;
	}

}
