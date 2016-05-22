<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator<br>

 */
class SettingtypesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Settingtype', 'Productdiamond', 'Productgemstone');
    public $layout = 'admin';
	 /*List  Setting Type */
    public function admin_index() {
        $this->checkadmin();
        $this->Settingtype->recursive = 0;
			/*search redirect*/
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchsetting=' . $this->request->data['searchsetting']));
        }

		/*query for search*/
        if ($this->request->query('search') != '') {
            $conditions = array('settingtype LIKE' => '%' . $this->request->query('searchsetting') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'settingtype_id DESC');
        $this->set('settingtype', $this->Paginator->paginate('Settingtype'));
    }
	 /*Add  Setting Type */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Settingtype->find('first', array('conditions' => array('settingtype' => $this->request->data['Settingtype']['settingtype'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Settingtype->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Settingtype added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Settingtype already exits.</div>', '');
            }
        }
    }
	 /*Edit  Setting Type */
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Settingtype->exists($id)) {
            throw new NotFoundException(__('Invalid Settingtype'));
        }
        $metal = $this->Settingtype->find('first', array('conditions' => array('settingtype_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Settingtype->find('first', array('conditions' => array('settingtype' => $this->request->data['Settingtype']['settingtype'], 'status !=' => 'Trash', 'settingtype_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
			/*Edit Setting Type in Productdiamond Table*/
                $metal = $this->Settingtype->find('first', array('conditions' => array('settingtype_id' => $this->params['pass']['0'])));
                $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
                if (!empty($shapediamond)) {
                    foreach ($shapediamond as $diamond) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $diamond['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['settingtype'] = $this->request->data['Settingtype']['settingtype'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }
				/*Edit Setting Type in ProductGemstone Table*/
                $shapestone = $this->Productgemstone->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
                if (!empty($shapestone)) {
                    foreach ($shapestone as $shapestone) {
                        $this->request->data['Productgemstone']['productgemstone_id'] = $shapestone['Productgemstone']['productgemstone_id'];
                        $this->request->data['Productgemstone']['settingtype'] = $this->request->data['Settingtype']['settingtype'];
                        $this->Productgemstone->saveAll($this->request->data);
                    }
                }
                $this->request->data['Settingtype']['settingtype_id'] = $this->params['pass'][0];
                $this->Settingtype->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Settingtype updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Settingtype already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }
	 /*Delete  Setting Type */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Setting Type  Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Settingtype->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Settingtype->exists()) {
                throw new NotFoundException(__('Invalid Settingtype'));
            }
				
            $metal = $this->Settingtype->find('first', array('conditions' => array('settingtype_id' => $this->params['pass']['0'])));
            $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
            $shapestone = $this->Productgemstone->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
            if (empty($shapediamond) && empty($shapestone)) {
                $this->request->data['Settingtype']['settingtype_id'] = $this->params['pass']['0'];
                $this->request->data['Settingtype']['status'] = 'Trash';
                $this->Settingtype->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('A setting type already used in the product. Please delete the product') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Settingtype has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Setting Type  Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $metal = $this->Settingtype->find('first', array('conditions' => array('settingtype_id' => $metaldelete)));
                        $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
                        $shapestone = $this->Productgemstone->find('all', array('conditions' => array('settingtype' => $metal['Settingtype']['settingtype'])));
                        if (empty($shapediamond) && empty($shapestone)) {
                            $this->request->data['Settingtype']['settingtype_id'] = $metaldelete;
                            $this->request->data['Settingtype']['status'] = 'Trash';
                            $this->Settingtype->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('A setting type already used in the product. Please delete the product') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Settingtype has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Change Status  Setting Type */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Settingtype']['settingtype_id'] = $this->params['pass']['0'];
        $this->request->data['Settingtype']['status'] = $this->params['pass']['1'];
        $this->Settingtype->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
