<?php

App::uses('AppController', 'Controller');

/**
 * RedeemController Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RedeemController extends AppController {

    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Redeem');
    public $layout = 'admin';
	
    public function admin_redeem() {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Redeem']['redeem_id'] = 1;
            $this->Redeem->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'redeem'));
        }
        $redeem = $this->Redeem->find('first', array('conditions' => array('redeem_id' => '1')));
        $this->request->data = $redeem;
    }

}
