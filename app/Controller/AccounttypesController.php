<?php

App::uses('AppController', 'Controller');

/**
 * Accounttypes Controller
 *
 * @property Accounttype $Accounttype
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AccounttypesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Accounttype');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Accounttype->recursive = 0;
        $this->paginate = array('conditions' => '');
        $this->set('accounttype', $this->Paginator->paginate('Accounttype'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Accounttype->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Accounttype added successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Accounttype->exists($id)) {
            throw new NotFoundException(__('Invalid Question'));
        }
        $accounttype = $this->Accounttype->find('first', array('conditions' => array('account_id' => $this->params['pass']['0'])));
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Accounttype']['account_id'] = $this->params['pass'][0];
            $this->Accounttype->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Accounttype updated successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $accounttype;
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Accounttype->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Accounttype->exists()) {
                throw new NotFoundException(__('Invalid Question'));
            }
            $this->Accounttype->delete(array('account_id' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Accounttype has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Type->deleteAll(array('account_id IN (' . implode(",", $this->request->data['action']) . ')'), false, false);
            $this->Session->setFlash("<div class='success msg'>" . __('Accounttype has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

}
