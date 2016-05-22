<?php

App::uses('AppController', 'Controller');

/**
 * Smstemplates Controller
 *
 * @property Smstemplate $Smstemplate
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SmstemplatesController extends AppController {

    public $components = array('Paginator');
    public $uses = array('Adminuser', 'Smstemplate');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Smstemplate->recursive = 0;
        $this->paginate = array('conditions' => '');
        $this->set('smstemplate', $this->Paginator->paginate('Smstemplate'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Smstemplate->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        $smstemplate = $this->Smstemplate->find('first', array('conditions' => array('sms_id' => $this->params['pass']['0'])));
        //print_r($smstemplate);exit;
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Smstemplate']['sms_id'] = $this->params['pass'][0];
            $this->Smstemplate->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $smstemplate;
        }
    }

}
