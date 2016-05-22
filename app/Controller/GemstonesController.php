<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class GemstonesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Gemstone', 'Productgemstone');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Gemstone->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchstone=' . $this->request->data['searchstone']));
        }


        if ($this->request->query('search') != '') {
            $conditions = array('stone LIKE' => '%' . $this->request->query('searchstone') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'gemstone_id DESC');
        $this->set('stone', $this->Paginator->paginate('Gemstone'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Gemstone->find('first', array('conditions' => array('stone' => $this->request->data['Gemstone']['stone'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Gemstone->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Gemstone added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Gemstone already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Gemstone->exists($id)) {
            throw new NotFoundException(__('Invalid Gemstone'));
        }
        $metal = $this->Gemstone->find('first', array('conditions' => array('gemstone_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Gemstone->find('first', array('conditions' => array('stone' => $this->request->data['Gemstone']['stone'], 'status !=' => 'Trash', 'gemstone_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $metal = $this->Gemstone->find('first', array('conditions' => array('gemstone_id' => $this->params['pass']['0'])));
                $gemstone = $this->Productgemstone->find('all', array('conditions' => array('gemstone' => $metal['Gemstone']['stone'])));
                if (!empty($gemstone)) {
                    foreach ($gemstone as $gemstones) {
                        $this->request->data['Productgemstone']['productgemstone_id'] = $gemstones['Productgemstone']['productgemstone_id'];
                        $this->request->data['Productgemstone']['gemstone'] = $this->request->data['Gemstone']['stone'];
                        $this->Productgemstone->saveAll($this->request->data);
                    }
                }
                $this->request->data['Gemstone']['gemstone_id'] = $this->params['pass'][0];
                $this->Gemstone->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Gemstone updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Gemstone already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Gemstone->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Gemstone->exists()) {
                throw new NotFoundException(__('Invalid Gemstone'));
            }
            $metal = $this->Gemstone->find('first', array('conditions' => array('gemstone_id' => $this->params['pass']['0'])));
            $gemstone = $this->Productgemstone->find('all', array('conditions' => array('gemstone' => $metal['Gemstone']['stone'])));
            if (empty($gemstone)) {
                $this->request->data['Gemstone']['gemstone_id'] = $this->params['pass']['0'];
                $this->request->data['Gemstone']['status'] = 'Trash';
                $this->Gemstone->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Gemstone already exists in the product.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Gemstone has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $metal = $this->Gemstone->find('first', array('conditions' => array('gemstone_id' => $metaldelete)));
                        $gemstone = $this->Productgemstone->find('all', array('conditions' => array('gemstone' => $metal['Gemstone']['stone'])));
                        if (empty($gemstone)) {
                            $this->request->data['Gemstone']['gemstone_id'] = $metaldelete;
                            $this->request->data['Gemstone']['status'] = 'Trash';
                            $this->Gemstone->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Gemstone already exists in the product.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Gemstone has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Gemstone']['gemstone_id'] = $this->params['pass']['0'];
        $this->request->data['Gemstone']['status'] = $this->params['pass']['1'];
        $this->Gemstone->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
