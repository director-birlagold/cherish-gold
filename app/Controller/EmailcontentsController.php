<?php

App::uses('AppController', 'Controller');

/**
 * Emailcontents Controller
 *
 * @property Emailcontent $Emailcontent
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EmailcontentsController extends AppController {

    public $components = array('Paginator');
    public $uses = array('Adminuser', 'Emailcontent');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Emailcontent->recursive = 0;
        $this->paginate = array('conditions' => array('Emailcontent.is_active' => 1));
        $this->set('emailcontent', $this->Paginator->paginate('Emailcontent'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Emailcontent->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        $emailcontent = $this->Emailcontent->find('first', array('conditions' => array('eid' => $this->params['pass']['0'])));
        //print_r($emailcontent);exit;
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Emailcontent']['eid'] = $this->params['pass'][0];
            $this->Emailcontent->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $emailcontent;
        }
    }

}
