<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator<br>

 */
class CaratsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Carat', 'Productdiamond');
    public $layout = 'admin';
	 /*List  Carat */
    public function admin_index() {
        $this->checkadmin();
        $this->Carat->recursive = 0;
		/*search redirect*/
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchcarat=' . $this->request->data['searchcarat']));
        }

		/*query for search*/
        if ($this->request->query('search') != '') {
            $conditions = array('carat LIKE' => '%' . $this->request->query('searchcarat') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'carat_id DESC');
        $this->set('carat', $this->Paginator->paginate('Carat'));
    }
	/*Add Carat */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Carat->find('first', array('conditions' => array('carat' => $this->request->data['Carat']['carat'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Carat->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Carat added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Carat already exits.</div>', '');
            }
        }
    }
	/*Edit Carat */
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Carat->exists($id)) {
            throw new NotFoundException(__('Invalid Carat'));
        }
        $metal = $this->Carat->find('first', array('conditions' => array('carat_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Carat->find('first', array('conditions' => array('carat' => $this->request->data['Carat']['carat'], 'status !=' => 'Trash', 'Carat_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $metal = $this->Carat->find('first', array('conditions' => array('carat_id' => $this->params['pass']['0'])));
                $gemstone = $this->Productdiamond->find('all', array('conditions' => array('carat' => $metal['Carat']['carat'])));
                if (!empty($gemstone)) {
                    foreach ($gemstone as $stone) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $stone['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['carat'] = $this->request->data['Carat']['carat'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }
                $this->request->data['Carat']['carat_id'] = $this->params['pass'][0];
                $this->Carat->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Carat updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Carat already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }
	/*Delete Carat */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Carat  Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Carat->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Carat->exists()) {
                throw new NotFoundException(__('Invalid Carat'));
            }
            $metal = $this->Carat->find('first', array('conditions' => array('carat_id' => $this->params['pass']['0'])));
            $gemstone = $this->Productdiamond->find('all', array('conditions' => array('carat' => $metal['Carat']['carat'])));
            if (empty($gemstone)) {
                $this->request->data['Carat']['carat_id'] = $this->params['pass']['0'];
                $this->request->data['Carat']['status'] = 'Trash';
                $this->Carat->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('A carat already used in the product. Please delete the product') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }


            $this->Session->setFlash("<div class='success msg'>" . __('Carat has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Carat  Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $metal = $this->Carat->find('first', array('conditions' => array('carat_id' => $metaldelete)));
                        $gemstone = $this->Productdiamond->find('all', array('conditions' => array('carat' => $metal['Carat']['carat'])));
                        if (empty($gemstone)) {
                            $this->request->data['Carat']['carat_id'] = $metaldelete;
                            $this->request->data['Carat']['status'] = 'Trash';
                            $this->Carat->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('A carat already used in the product. Please delete the product') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Carat has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Change Status Carat */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Carat']['carat_id'] = $this->params['pass']['0'];
        $this->request->data['Carat']['status'] = $this->params['pass']['1'];
        $this->Carat->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
