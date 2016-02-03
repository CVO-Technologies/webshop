<?php

namespace Webshop\Controller;

use Croogo\Core\Controller\AppController as CroogoAppController;

/**
 * Class ProductsController
 *
 * @property Product Product
 */
class ProductsController extends CroogoAppController
{

    public $components = array(
        'Paginator'
    );

    public function view($id)
    {
        $this->Product->id = $id;
        $this->Product->recursive = 2;

        $product = $this->Product->read();
        if ($this->request->is('requested')) {
            return $product;
        }

        $this->set(compact('product'));
    }


    public function lookup()
    {
        $type = ($this->request->query('type')) ? $this->request->query('type') : 'EAN-13';
        $code = $this->request->query('code');

        $column = false;
        switch ($type) {
            case 'EAN-13':
                $column = 'ean';
                break;
        }

        if (!$column) {
            throw new BadRequestException();
        }

//		debug($this->Product->find('all'));

        $product = $this->Product->find('first', array(
            'conditions' => array(
                $this->Product->alias . '.' . $column => $code
            )
        ));

        $this->set(compact('product'));
        $this->set('_serialize', array('product'));
    }

    public function calculate_price($id)
    {
        return $this->Product->getPrice($id, $this->request->param('configuration'));
    }

    public function admin_index()
    {
        $products = $this->Paginator->paginate('Product');

        $this->set(compact('products'));
    }

    public function admin_listing()
    {
        $this->Paginator->settings['Product']['type'] = 'list';
        $products = $this->Paginator->paginate('Product');

        if ($this->request->is('requested')) {
            return $products;
        }

        $this->set(compact('products'));
    }

    public function admin_edit($id)
    {
        $this->Product->id = $id;
        $this->Product->recursive = 2;

        if (empty($this->request->data)) {
            $this->request->data = $this->Product->read();
        }

        if (!$this->request->is('put')) {
            return;
        }

        if (!$this->Product->saveAll($this->request->data, array(
            'deep' => true
        ))
        ) {
            debug(':(');
            debug($this->Product->validationErrors);
            debug($this->Product->invalidFields());

            return;
        }

        $this->redirect(array('action' => 'index'));
    }

}
