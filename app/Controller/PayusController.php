<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PayusController extends AppController {

    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Payu');
    public $layout = 'admin';
	/*Add Payu */
    public function admin_payu() {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Payu']['payu_id'] = 1;
            $this->Payu->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'payu'));
        }
        $payu = $this->Payu->find('first', array('conditions' => array('payu_id' => '1')));
        $this->request->data = $payu;
    }

}
