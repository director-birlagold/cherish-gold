<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class MetalsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Metal', 'Metalcolor', 'Product');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Metal->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchterm=' . $this->request->data['searchterm']));
        }


        if ($this->request->query('search') != '') {
            $conditions = array('metal_name LIKE' => '%' . $this->request->query('searchterm') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'metal_id DESC');
        $this->set('metals', $this->Paginator->paginate('Metal'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Metal->find('first', array('conditions' => array('metal_name' => $this->request->data['Metal']['metal_name'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Metal->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Metal added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Metal already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Metal->exists($id)) {
            throw new NotFoundException(__('Invalid Metal'));
        }
        $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Metal->find('first', array('conditions' => array('metal_name' => $this->request->data['Metal']['metal_name'], 'status !=' => 'Trash', 'metal_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {

                $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $this->params['pass']['0'])));
                $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'])));
                if (!empty($product)) {

                    foreach ($product as $products) {
                        $this->request->data['Product']['product_id'] = $products['Product']['product_id'];
                        $this->request->data['Product']['metal'] = $this->request->data['Metal']['metal_name'];

                        $this->Product->saveAll($this->request->data);
                    }
                }
                $this->request->data['Metal']['metal_id'] = $this->params['pass'][0];
                $this->Metal->save($this->request->data);

                $this->Session->setFlash('<div class="success msg">Metal updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Metal already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Metal->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Metal->exists()) {
                throw new NotFoundException(__('Invalid Metal'));
            }


            $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $this->params['pass']['0'])));
            $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'])));
            if (empty($product)) {
                $this->request->data['Metal']['metal_id'] = $this->params['pass']['0'];
                $this->request->data['Metal']['status'] = 'Trash';
                $this->Metal->save($this->request->data);
                $color = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $this->params['pass']['0'], 'status !=' => 'Trash')));
                if (!empty($color)) {
                    foreach ($color as $color) {
                        $this->request->data['Metalcolor']['metalcolor_id'] = $color['Metalcolor']['metalcolor_id'];
                        $this->request->data['Metalcolor']['status'] = 'Trash';
                        $this->Metalcolor->saveAll($this->request->data);
                    }
                }
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Metal already exists in the project.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Metal has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {

                        $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $metaldelete)));
                        $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'])));
                        if (empty($product)) {
                            $this->request->data['Metal']['metal_id'] = $metaldelete;
                            $this->request->data['Metal']['status'] = 'Trash';
                            $this->Metal->saveAll($this->request->data);

                            $color = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $metaldelete, 'status !=' => 'Trash')));
                            foreach ($color as $color) {
                                $this->request->data['Metalcolor']['metalcolor_id'] = $color['Metalcolor']['metalcolor_id'];
                                $this->request->data['Metalcolor']['status'] = 'Trash';
                                $this->Metalcolor->saveAll($this->request->data);
                            }
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Metal already exists in the project.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Metal has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Metal']['metal_id'] = $this->params['pass']['0'];
        $this->request->data['Metal']['status'] = $this->params['pass']['1'];
        $this->Metal->save($this->request->data);
        $color = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $this->params['pass']['0'], 'status !=' => 'Trash')));

        if (!empty($color)) {
            foreach ($color as $color) {
                $this->request->data['Metalcolor']['metalcolor_id'] = $color['Metalcolor']['metalcolor_id'];
                $this->request->data['Metalcolor']['metal_id'] = $this->params['pass']['0'];
                $this->request->data['Metalcolor']['status'] = $this->params['pass']['1'];
                $this->Metalcolor->saveAll($this->request->data);
            }
        }
        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
