<?php

App::uses('AppController', 'Controller');

/**
 * Statuses Controller
 *
 * @property Status $Status
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class StatusesController extends AppController {
    /**
     * Helpers
     *
     * @var array
     */

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Status');
    public $layout = 'admin';
	 /*List the  Vendor Status */
    public function admin_index() {
        $this->checkadmin();
        $this->Status->recursive = 0;
        $this->paginate = array('conditions' => '');
        $this->set('status', $this->Paginator->paginate('Status'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
	 /*Add Vendor Status*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Status->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Status added successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        }
    }
	 /*Edit Vendor Status*/
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Status->exists($id)) {
            throw new NotFoundException(__('Invalid Question'));
        }
        $status = $this->Status->find('first', array('conditions' => array('vendor_status_id ' => $this->params['pass']['0'])));
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Status']['vendor_status_id'] = $this->params['pass'][0];
            $this->Status->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Status updated successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $status;
        }
    }

	/*Delete Vendor Status*/
    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Status->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Status->exists()) {
                throw new NotFoundException(__('Invalid Question'));
            }
            $this->Status->delete(array('vendor_status_id' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Status has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Status->deleteAll(array('vendor_status_id IN (' . implode(",", $this->request->data['action']) . ')'), false, false);
            $this->Session->setFlash("<div class='success msg'>" . __('Status has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

}
