<?php

App::uses('AppController', 'Controller');

/**
 * Types Controller
 *
 * @property Type $Type
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TypesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Type');
    public $layout = 'admin';
	/*List Vendor Type*/
    public function admin_index() {
        $this->checkadmin();
        $this->Type->recursive = 0;
        $this->paginate = array('conditions' => '');
        $this->set('type', $this->Paginator->paginate('Type'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
	 /*Add Vendor Type*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Type->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Type added successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Edit Vendor Type*/
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Type->exists($id)) {
            throw new NotFoundException(__('Invalid Question'));
        }
        $type = $this->Type->find('first', array('conditions' => array('vendor_type_id' => $this->params['pass']['0'])));
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Type']['vendor_type_id'] = $this->params['pass'][0];
            $this->Type->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Type updated successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $type;
        }
    }
	/*Detele Vendor Type*/
    public function admin_delete() {
        $this->checkadmin();
		/*Single Vendor Type Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Type->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Type->exists()) {
                throw new NotFoundException(__('Invalid Question'));
            }
            $this->Type->delete(array('vendor_type_id' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Type has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Vendor Type Delete*/
            $this->Type->deleteAll(array('vendor_type_id IN (' . implode(",", $this->request->data['action']) . ')'), false, false);
            $this->Session->setFlash("<div class='success msg'>" . __('Type has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

}
