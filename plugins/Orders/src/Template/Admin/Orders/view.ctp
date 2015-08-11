<?php
$this->Html->addCrumb('Orders', Router::url(array('action' => 'index')));
$this->Html->addCrumb('Order #' . $order['Order']['number'], '/' . $this->here);
?>

<table class="table">
    <caption>Shipments</caption>
    <thead>
    <tr>
        <th>ID</th>
        <th>Method</th>
        <th>Status</th>
        <th>Information</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order['OrderShipment'] as $orderShipment): ?>
        <?php
        switch ($orderShipment['Shipment']['status']):
            case 'sent':
                $orderColor = 'info';
                break;
            case 'arrived':
                $orderColor = 'success';
                break;
            case 'open':
                $orderColor = '';
                break;
            case 'cancelled':
                $orderColor = 'danger';
                break;
            default:
                $orderColor = 'warning';
        endswitch;
        ?>
        <tr class="<?php echo h($orderColor); ?>">
            <td><?php echo $this->Html->link($orderShipment['Shipment']['id'], array('plugin' => 'webshop_shipping', 'controller' => 'shipments', 'action' => 'view', $orderShipment['Shipment']['id'])); ?></td>
            <td><?php echo h($orderShipment['Shipment']['ShippingMethod']['name']); ?></td>
            <td><?php echo h($this->Shipment->statusText($orderShipment['Shipment']['status'])); ?></td>
            <td><?php echo $this->Shipment->information($orderShipment['Shipment']['id']); ?></td>
            <td>
                <?php
                switch ($orderShipment['Shipment']['status']):
                    case 'sent':
                        echo $this->Form->postLink(
                            'Mark as arrived',
                            array(
                                'plugin' => 'webshop_shipping',
                                'controller' => 'shipments',
                                'action' => 'mark_arrived',
                                $orderShipment['Shipment']['id']
                            ),
                            array(
                                'button' => 'success'
                            )
                        );

                        break;
                    case 'arrived':
                        break;
                    default:
                        if (!empty($orderShipment['OrderProduct'])):
                            echo $this->Html->link(
                                'Ship',
                                array(
                                    'controller' => 'order_shipments',
                                    'action' => 'ship',
                                    $orderShipment['id']
                                ),
                                array(
                                    'button' => 'success'
                                )
                            );
                        endif;

                        echo $this->Html->link(
                            'Assign products',
                            array(
                                'controller' => 'order_products',
                                'action' => 'assign_shipment',
                                $orderShipment['order_id'],
                                $orderShipment['id']
                            ),
                            array(
                                'button' => 'success'
                            )
                        );
                endswitch;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<table class="table">
    <caption>Products</caption>
    <thead>
    <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Shipment status</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order['OrderProduct'] as $orderProduct): ?>
        <?php
        switch ($orderProduct['status']):
            case 'sent':
                $productStatus = 'info';
                break;
            case 'arrived':
                $productStatus = 'success';
                break;
            default:
                if (isset($orderProduct['OrderShipment']['Shipment'])):
                    $productStatus = 'info';

                    break;
                endif;

                $productStatus = 'warning';
        endswitch;
        ?>
        <tr class="<?php echo h($productStatus); ?>">
            <td><?php echo $this->Html->link($orderProduct['Product']['title'], $orderProduct['Product']['path']); ?></td>
            <td><?php echo h($orderProduct['amount']); ?></td>
            <td><?php echo h($this->Product->statusText($orderProduct['status'])); ?></td>
            <td>
                <?php
                if (isset($orderProduct['OrderShipment']['Shipment'])):
                    echo $this->Html->link($orderProduct['OrderShipment']['Shipment']['id'], array('plugin' => 'webshop_shipping', 'controller' => 'shipments', 'action' => 'view', $orderShipment['Shipment']['id'])) . ' (' . h($this->Shipment->statusText($orderProduct['OrderShipment']['Shipment']['status'])) . ')';
                else:
                    echo h('None');
                endif;
                ?>
            </td>
            <td><?php echo h($this->Number->currency($orderProduct['price'], 'EUR')); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<table class="table">
    <caption>Payments</caption>
    <thead>
    <tr>
        <th>Description</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order['OrderPayment'] as $orderPayment): ?>
        <?php
        switch ($orderPayment['Payment']['status']):
            case 'paid':
                $paymentColor = 'success';
                break;
            default:
                $paymentColor = 'warning';
        endswitch;
        ?>
        <tr class="<?php echo h($paymentColor); ?>">
            <td><?php echo h($orderPayment['Payment']['description']); ?></td>
            <td><?php echo h($orderPayment['Payment']['amount']); ?></td>
            <td><?php echo h($this->Payment->statusText($orderPayment['Payment']['status'])); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
