<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class DiamondsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Diamond', 'Productdiamond');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Diamond->recursive = 0;
        $this->paginate = array('conditions' => array('status !=' => 'Trash'));
        $this->set('diamond', $this->Paginator->paginate('Diamond'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Diamond->find('first', array('conditions' => array('name' => $this->request->data['Diamond']['name'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Diamond->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Diamond added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Diamond already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Diamond->exists($id)) {
            throw new NotFoundException(__('Invalid Diamond'));
        }
        $metal = $this->Diamond->find('first', array('conditions' => array('diamond_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Diamond->find('first', array('conditions' => array('name' => $this->request->data['Diamond']['name'], 'status !=' => 'Trash', 'diamond_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $product = $this->Diamond->find('first', array('conditions' => array('diamond_id' => $this->params['pass']['0'])));
                $productmetal = $this->Productdiamond->find('all', array('conditions' => array('diamond' => $product['Diamond']['name'])));
                if (!empty($productmetal)) {
                    foreach ($productmetal as $productmetal) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $productmetal['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['diamond'] = $this->request->data['Diamond']['name'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }
                $this->request->data['Diamond']['diamond_id'] = $this->params['pass'][0];
                $this->Diamond->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Diamond updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Diamond already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Diamond->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Diamond->exists()) {
                throw new NotFoundException(__('Invalid Diamond'));
            }
            $product = $this->Diamond->find('first', array('conditions' => array('diamond_id' => $this->params['pass']['0'])));
            $productmetal = $this->Productdiamond->find('all', array('conditions' => array('diamond' => $product['Diamond']['name'])));
            if (empty($productmetal)) {
                $this->request->data['Diamond']['diamond_id'] = $this->params['pass']['0'];
                $this->request->data['Diamond']['status'] = 'Trash';
                $this->Diamond->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Diamond already exists in the product.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Diamond has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $product = $this->Diamond->find('first', array('conditions' => array('diamond_id' => $metaldelete)));
                        $productmetal = $this->Productdiamond->find('all', array('conditions' => array('diamond' => $product['Diamond']['name'])));
                        if (empty($productmetal)) {
                            $this->request->data['Diamond']['diamond_id'] = $metaldelete;
                            $this->request->data['Diamond']['status'] = 'Trash';
                            $this->Diamond->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Diamond already exists in the product.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Diamond has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Diamond']['diamond_id'] = $this->params['pass']['0'];
        $this->request->data['Diamond']['status'] = $this->params['pass']['1'];
        $this->Diamond->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
