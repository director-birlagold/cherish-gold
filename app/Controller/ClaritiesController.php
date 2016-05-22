<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class ClaritiesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Clarity', 'Productdiamond');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Clarity->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchclarity=' . $this->request->data['searchclarity']));
        }


        if ($this->request->query('search') != '') {
            $conditions = array('clarity LIKE' => '%' . $this->request->query('searchclarity') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'clarity_id DESC');
        $this->set('clarity', $this->Paginator->paginate('Clarity'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Clarity->find('first', array('conditions' => array('clarity' => $this->request->data['Clarity']['clarity'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Clarity->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Clarity added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Clarity already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Clarity->exists($id)) {
            throw new NotFoundException(__('Invalid Clarity'));
        }
        $metal = $this->Clarity->find('first', array('conditions' => array('clarity_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Clarity->find('first', array('conditions' => array('clarity' => $this->request->data['Clarity']['clarity'], 'status !=' => 'Trash', 'clarity_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $clarity = $this->Clarity->find('first', array('conditions' => array('clarity_id' => $this->params['pass']['0'])));
                $gemstone = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity['Clarity']['clarity'])));
                if (!empty($gemstone)) {
                    foreach ($gemstone as $gemstone) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $gemstone['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['clarity'] = $this->request->data['Clarity']['clarity'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }
                $this->request->data['Clarity']['clarity_id'] = $this->params['pass'][0];
                $this->Clarity->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Clarity updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Clarity already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Clarity->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Clarity->exists()) {
                throw new NotFoundException(__('Invalid Clarity'));
            }
            $clarity = $this->Clarity->find('first', array('conditions' => array('clarity_id' => $this->params['pass']['0'])));
            $gemstone = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity['Clarity']['clarity'])));
            if (empty($gemstone)) {
                $this->request->data['Clarity']['clarity_id'] = $this->params['pass']['0'];
                $this->request->data['Clarity']['status'] = 'Trash';
                $this->Clarity->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Clarity already exists in the product.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Clarity has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $clarity = $this->Clarity->find('first', array('conditions' => array('clarity_id' => $metaldelete)));
                        $gemstone = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity['Clarity']['clarity'])));
                        if (empty($gemstone)) {
                            $this->request->data['Clarity']['clarity_id'] = $metaldelete;
                            $this->request->data['Clarity']['status'] = 'Trash';
                            $this->Clarity->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Clarity already exists in the product.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Clarity has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Clarity']['clarity_id'] = $this->params['pass']['0'];
        $this->request->data['Clarity']['status'] = $this->params['pass']['1'];
        $this->Clarity->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
