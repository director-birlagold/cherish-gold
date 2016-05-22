<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class PuritiesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Purity', 'Productmetal', 'Size');
    public $layout = 'admin';
	/*List Purity*/
    public function admin_index() {
        $this->checkadmin();
        $this->Purity->recursive = 0;
		/*search redirect*/	
        if (isset($this->request->data['searchfilter'])) {
            $search = array();

            if ($this->request->data['searchterm'] != '') {
                $search[] = 'searchterm=' . $this->request->data['searchterm'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }/*query for search*/
		if ($this->request->query('search') != '') {
            $conditions['status !='] = 'Trash';
            if ($this->request->query('searchterm') != '') {
                $conditions['purity'] = $this->request->query('searchterm');
            }
        } else {
            $conditions = array('status !=' => 'Trash');
        }
        $this->paginate = array('conditions' => $conditions, 'order' => 'purity_id DESC');
        $this->set('purity', $this->Paginator->paginate('Purity'));
    }
	/*Add Purities*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Purity->find('first', array('conditions' => array('purity' => $this->request->data['Purity']['purity'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Purity->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Purity added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Purity already exits.</div>', '');
            }
        }
    }
	/*Edit Purities*/
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Purity->exists($id)) {
            throw new NotFoundException(__('Invalid Purity'));
        }
        $metal = $this->Purity->find('first', array('conditions' => array('purity_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Purity->find('first', array('conditions' => array('purity' => $this->request->data['Purity']['purity'], 'status !=' => 'Trash', 'purity_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $metal = $this->Purity->find('first', array('conditions' => array('purity_id' => $this->params['pass']['0'])));
				/*Edit Purity in Productmetal Table*/
                $this->Productmetal->updateAll(array('value' => "'" . $this->request->data['Purity']['purity'] . "'"), array('type' => 'Purity', 'value' => $metal['Purity']['purity']));
                	/*Edit Size in Productmetal Table*/
                $this->Size->updateAll(array('goldpurity' => "'" . $this->request->data['Purity']['purity'] . "'"), array('goldpurity' => $metal['Purity']['purity']));
                
                $this->request->data['Purity']['purity_id'] = $this->params['pass'][0];
                $this->Purity->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Purity updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Purity already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }
	/*Delete Size*/
    public function admin_delete() {
        $this->checkadmin();
		/*Single Purity Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Purity->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Purity->exists()) {
                throw new NotFoundException(__('Invalid Purity'));
            }
            $purity1 = $this->Size->find('all', array('conditions' => array('goldpurity' => $this->params['pass']['0'])));
            $purity2 = $this->Productmetal->find('all', array('conditions' => array('type' => 'Purity', 'value' => $this->params['pass']['0'])));
            if (empty($purity1) && empty($purity2)) {
                $this->request->data['Purity']['purity_id'] = $this->params['pass']['0'];
                $this->request->data['Purity']['status'] = 'Trash';
                $this->Purity->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Purity already exists in the project.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Metal has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Purity Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {

                        $purity1 = $this->Size->find('all', array('conditions' => array('goldpurity' => $metaldelete)));
                        $purity2 = $this->Productmetal->find('all', array('conditions' => array('type' => 'Purity', 'value' => $metaldelete)));
                        if (empty($purity1) && empty($purity2)) {
                            $this->request->data['Purity']['purity_id'] = $metaldelete;
                            $this->request->data['Purity']['status'] = 'Trash';
                            $this->Purity->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Purity already exists in the project.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Purity has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Change Status  Purity */
    public function admin_changestatus() {
        $this->checkadmin();

        $metal = $this->Purity->find('first', array('conditions' => array('purity_id' => $this->params['pass']['0'])));

        $this->request->data['Purity']['purity_id'] = $this->params['pass']['0'];
        $this->request->data['Purity']['status'] = $this->params['pass']['1'];
        $this->Purity->save($this->request->data);

        $this->Productmetal->updateAll(array('status' => "'" . $this->params['pass']['1'] . "'"), array('type' => 'Purity', 'value' => $metal['Purity']['purity']));
        $this->Size->updateAll(array('status' => "'" . $this->params['pass']['1'] . "'"), array('goldpurity' => $metal['Purity']['purity']));

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
