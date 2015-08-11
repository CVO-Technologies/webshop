<?php

namespace Webshop\Controller\Panel;

use Cake\Routing\Router;
use Croogo\Core\Controller\CroogoAppController;

class CustomersController extends CroogoAppController
{

    public $helpers = [
        'SocialSeo.Title'
    ];

    public function dashboard()
    {

    }

    public function select()
    {
        if ($this->request->query('customer')) {
            $this->request->session()->write('Customer.current', $this->request->query('customer'));

            $redirectUrl = '/';
            if ($this->request->session()->check('Customer.select.redirect')) {
                $redirectUrl = $this->request->session()->read('Customer.select.redirect');
            }
            if (($redirectUrl === '/') && (Router::parse($this->referer('/', true))['action'] !== 'select')) {
                $redirectUrl = $this->referer('/', true);
            }

            $this->request->session()->delete('Customer.select.redirect');

            $this->redirect($redirectUrl);
            return;
        }
    }

    public function unselect()
    {
        $this->request->session()->delete('Customer.current');

        $this->redirect('/');
        return;
    }

    public function view($id)
    {
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
