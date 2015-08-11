<?php

namespace Webshop\Controller\Panel;

use Croogo\Core\Controller\CroogoAppController;
use Webshop\Model\Table\AddressDetailsTable;

/**
 * @property AddressDetailsTable AddressDetails
 */
class AddressDetailsController extends CroogoAppController
{

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    /**
     * @return array
     */
    public function index()
    {
        $query = $this->AddressDetails->find('ownedByCustomer', [
            'customer' => $this->CustomerAccess->getCustomer()
        ]);

        $addressDetails = $this->Paginator->paginate($query);

        if ($this->request->is('requested')) {
            return $addressDetails;
        }

        $this->set(compact('addressDetails'));
        $this->set('_serialize', ['addressDetails']);
    }

    /**
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $addressDetail = $this->AddressDetails->newEntity([
            'customer_id' => $this->CustomerAccess->getCustomerId()
        ]);

        $this->set('addressDetail', $addressDetail);

        if (!$this->request->is('post')) {
            return;
        }

        $addressDetail = $this->AddressDetails->patchEntity($addressDetail, $this->request->data());
        if (!$this->AddressDetails->save($addressDetail)) {
            return;
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * @param int $id ID of customer to edit
     * @return \Cake\Network\Response|void
     */
    public function edit($id)
    {
        $addressDetail = $this->AddressDetails->get($id, [
            'finder' => 'ownedByCustomer',
            'customer' => $this->CustomerAccess->getCustomer()
        ]);

        $this->set('addressDetail', $addressDetail);

        if (!$this->request->is('put')) {
            return;
        }

        $addressDetail = $this->AddressDetails->patchEntity($addressDetail, $this->request->data());
        if (!$this->AddressDetails->save($addressDetail)) {
            $this->Flash->error(__d('webshop', 'Could not save address details'));

            return;
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

//    /**
//     * @param string $modelName Model name
//     *
//     * @return void
//     */
//    public function check($modelName)
//    {
//        $this->loadModel($modelName);
//
//        $transformedFields = [];
//        foreach ($this->request->query['data'] as $association => $fields) {
//            $Model = ($association === $modelName) ? $this->{$modelName} : $this->{$modelName}->{$association};
//            if (!$Model) {
//                continue;
//            }
//
//            $transformedFields[$Model->name] = $this->__transformFields($Model, [$Model->alias], $fields);
//        }
//
//        $ChangeEvent = new CakeEvent('Form.change', $this, [
//            'fields' => $transformedFields
//        ]);
//
//        $this->getEventManager()->dispatch($ChangeEvent);
//
//        $fields = [];
//        foreach (Hash::flatten($ChangeEvent->data['fields']) as $key => $value) {
//            $fieldParts = explode('.', $key);
//            $lastPart = array_pop($fieldParts);
//            if (is_numeric($lastPart)) {
//                $lastPart = array_pop($fieldParts);
//                $fields[implode('.', $fieldParts)][$lastPart][] = $value;
//            } else {
//                $fields[implode('.', $fieldParts)][$lastPart] = $value;
//            }
//        }
//
//        $this->set('fields', $fields);
//        $this->set('_serialize', ['fields']);
//    }

//    private function __transformFields(Model $Model, array $stack, $fields)
//    {
//        $transformedFields = [];
//
//        foreach ($fields as $fieldName => $fieldValue) {
//            $fieldStack = $stack;
//            $fieldStack[] = $fieldName;
//
//            $transformedFields[$fieldName] = [
//                'name' => 'data[' . implode('][', $fieldStack) . ']',
//                'disabled' => null,
//                'errors' => [],
//                'value' => $fieldValue,
//                'changed' => false
//            ];
//        }
//
//        return $transformedFields;
//    }

    /**
     * @return array
     *
     * @deprecated
     */
    public function adminListing()
    {
        $this->Paginator->settings['AddressDetail']['type'] = 'list';
        $addressDetails = $this->Paginator->paginate('AddressDetail');

        if ($this->request->is('requested')) {
            return $addressDetails;
        }

        $this->set(compact('addressDetails'));
    }
}
