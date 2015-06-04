<?php

namespace Webshop\Controller\Panel;

use App\Controller\AppController;

class CustomersController extends AppController {

    public $helpers = [
        'SocialSeo.Title'
    ];

    public function dashboard() {

    }

    public function select() {
        if ($this->request->query('customer')) {
            $this->Session->write('Customer.current', $this->request->query('customer'));

            $redirectUrl = '/';
            if ($this->Session->check('Customer.select.redirect')) {
                $redirectUrl = $this->Session->read('Customer.select.redirect');
            }
            if (($redirectUrl === '/') && (Router::parse($this->referer('/', true))['action'] !== 'panel_select')) {
                $redirectUrl = $this->referer('/', true);
            }

            $this->Session->delete('Customer.select.redirect');

            $this->redirect($redirectUrl);
            return;
        }
    }

    public function unselect() {
        $this->Session->delete('Customer.current');

        $this->redirect('/');
        return;
    }

    public function view($id) {
        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException();
        }

        $customer = $this->Customer->read();

        if ($this->request->is('requested')) {
            return $customer;
        }
    }

}
