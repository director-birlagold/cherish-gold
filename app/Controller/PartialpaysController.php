<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PartialpaysController extends AppController {

    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Partialpay');
    public $layout = 'admin';
	/*Add Payu */
    public function admin_partialpay() {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Partialpay']['partialpay_id'] = 1;
            $this->Partialpay->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'partialpay'));
        }
        $partialpay = $this->Partialpay->find('first', array('conditions' => array('partialpay_id' => '1')));
        $this->request->data = $partialpay;
    }

}
