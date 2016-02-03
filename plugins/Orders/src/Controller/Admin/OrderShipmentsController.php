<?php

namespace Webshop\Orders\Controller\Admin;

use Croogo\Core\Controller\AppController as CroogoAppController;

class OrderShipmentsController extends CroogoAppController
{

    public function ship($id)
    {
        $this->OrderShipment->id = $id;
        $this->OrderShipment->recursive = 3;
        if (!$this->OrderShipment->exists()) {
            throw new NotFoundException();
        }

        $orderShipment = $this->OrderShipment->read();
        if (!$this->request->is('post')) {
            return;
        }

        $this->OrderShipment->Shipment->id = $orderShipment['Shipment']['id'];
        $this->OrderShipment->Shipment->saveField('weight', $this->request->data['Shipment']['weight']);

        $this->redirect(array(
            'plugin' => 'webshop_shipping',
            'controller' => 'shipments',
            'action' => 'ship',
            $orderShipment['Shipment']['id']
        ));
    }

}
