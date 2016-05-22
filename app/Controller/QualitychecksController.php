<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class QualitychecksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Qualitycheck');
    public $layout = 'admin';
	/*List Qualitycheck*/
    public function admin_index() {
        $this->checkadmin();
        $this->Qualitycheck->recursive = 0;
		/*search redirect*/
        if (isset($this->request->data['searchfilter_loc'])) {
            $search_loc = array();
            if ($this->request->data['searchname'] != '') {
                $search_loc[] = 'searchname=' . $this->request->data['searchname'];
            }if ($this->request->data['searchphone'] != '') {
                $search_loc[] = 'searchphone=' . $this->request->data['searchphone'];
            }
            if ($this->request->data['searchemail'] != '') {
                $search_loc[] = 'searchemail=' . $this->request->data['searchemail'];
            }
            if (!empty($search_loc)) {
                $this->redirect(array('action' => '?search_loc=1&' . implode('&', $search_loc)));
            }
        }
		/*query for search*/
        if ($this->request->query('search_loc') != '') {
            $search = array();
            $search = array('status !=' => 'Trash');

            if ($this->request->query('searchemail') != '') {
                $search = array_merge($search, array('email LIKE ' => '%' . $_REQUEST['searchemail'] . '%'));
            }
            if ($this->request->query('searchname') != '') {
                $search = array_merge($search, array('name LIKE ' => '%' . $_REQUEST['searchname'] . '%'));
            }
            if ($this->request->query('searchphone') != '') {
                $search = array_merge($search, array('mobile' => $_REQUEST['searchphone']));
            }
            $condition = $search;
        } else {
            $condition = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $condition, 'order' => 'qc_id DESC');
        $this->set('qualitycheck', $this->Paginator->paginate('Qualitycheck'));
    }
	/*Add Qualitycheck*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->request->data['Qualitycheck']['created_date'] = date('Y-m-d H:i:s');
            $this->request->data['Qualitycheck']['status'] = 'Active';
            $this->Qualitycheck->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Quality check details saved  successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Edit Qualitycheck*/
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Qualitycheck->exists($id)) {
            throw new NotFoundException(__('Invalid Quality Check'));
        }
        $qualitycheck = $this->Qualitycheck->find('first', array('conditions' => array('qc_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Qualitycheck']['qc_id'] = $this->params['pass'][0];
            $this->Qualitycheck->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Quality check  details updated successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        } else {

            $this->set('qualitycheck', $qualitycheck);
        }
    }
	/*Delete Qualitycheck*/
    public function admin_delete() {
		/*Single Qualitycheck  Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->request->data['Qualitycheck']['qc_id'] = $this->params['pass']['0'];
            $this->request->data['Qualitycheck']['status'] = 'Trash';
            $this->Qualitycheck->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Quality Check details has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Qualitycheck Delete*/
            if (!empty($this->request->data['action'])) {
                $array = array_filter($this->request->data['action']);
                $this->Qualitycheck->updateAll(array('status' => "'Trash'"), array('qc_id' => $array));
                $this->Session->setFlash("<div class='success msg'>" . __('Quality Check details has been deleted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->redirect(array('action' => 'index'));
    }
	/*Change Status  Qualitycheck */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Qualitycheck']['qc_id'] = $this->params['pass']['0'];
        $this->request->data['Qualitycheck']['status'] = $this->params['pass']['1'];
        $this->Qualitycheck->save($this->request->data);
        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
