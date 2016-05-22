<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class MetalcolorsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Metalcolor', 'Metal', 'Product');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Metalcolor->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchmetal'] != '') {
                $search[] = 'searchmetal=' . $this->request->data['searchmetal'];
            }

            if ($this->request->data['searchterm'] != '') {
                $search[] = 'searchterm=' . $this->request->data['searchterm'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }


        if ($this->request->query('search') != '') {
            $conditions['status !='] = 'Trash';
            if ($this->request->query('searchmetal') != '') {
                $conditions['metal_id'] = $this->request->query('searchmetal');
            }
            if ($this->request->query('searchterm') != '') {
                $conditions['metalcolor LIKE'] = '%' . $this->request->query('searchterm') . '%';
            }
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'metalcolor_id DESC');
        $this->set('color', $this->Paginator->paginate('Metalcolor'));
        $metal = $this->Metal->find('all', array('conditions' => array('status !=' => 'Trash'), 'order' => 'metal_id DESC'));
        $this->set('metal', $metal);
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Metalcolor->find('first', array('conditions' => array('metal_id' => $this->request->data['Metalcolor']['metal_id'], 'metalcolor' => $this->request->data['Metalcolor']['metalcolor'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Metalcolor->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Metal color added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Metal color already exits.</div>', '');
            }
        }
        $metal = $this->Metal->find('all', array('conditions' => array('status !=' => 'Trash'), 'order' => 'metal_id DESC'));
        $this->set('metal', $metal);
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Metalcolor->exists($id)) {
            throw new NotFoundException(__('Invalid Metalcolor'));
        }
        $metal = $this->Metalcolor->find('first', array('conditions' => array('metalcolor_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Metalcolor->find('first', array('conditions' => array('metal_id' => $this->request->data['Metalcolor']['metal_id'], 'metalcolor' => $this->request->data['Metalcolor']['metalcolor'], 'status !=' => 'Trash', 'metalcolor_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $metalcolors = $this->Metalcolor->find('first', array('conditions' => array('metalcolor_id' => $this->params['pass']['0'])));
                $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $metalcolors['Metalcolor']['metal_id'])));
                $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'], 'FIND_IN_SET(\'' . $metalcolors['Metalcolor']['metalcolor'] . '\',metal_color)')));
                if (!empty($product)) {

                    foreach ($product as $product) {
                        $this->request->data['Project']['product_id'] = $product['Product']['product_id'];
                        $this->request->data['Project']['metal_color'] = $this->request->data['Metalcolor']['metalcolor'];

                        $this->Product->saveAll($this->request->data);
                    }
                }

                $this->request->data['Metalcolor']['metalcolor_id'] = $this->params['pass'][0];
                $this->Metalcolor->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Metal color updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Metal color already exits.</div>', '');
            }
        }

        $this->request->data = $metal;
        $metals = $this->Metal->find('all', array('conditions' => array('status !=' => 'Trash'), 'order' => 'metal_id DESC'));
        $this->set('metals', $metals);
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Metalcolor->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Metalcolor->exists()) {
                throw new NotFoundException(__('Invalid Metalcolor'));
            }
            $metalcolors = $this->Metalcolor->find('first', array('conditions' => array('metalcolor_id' => $this->params['pass']['0'])));
            $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $metalcolors['Metalcolor']['metal_id'])));
            $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'], 'FIND_IN_SET(\'' . $metalcolors['Metalcolor']['metalcolor'] . '\',metal_color)')));
            if (empty($product)) {
                $this->request->data['Metalcolor']['metalcolor_id'] = $this->params['pass']['0'];
                $this->request->data['Metalcolor']['status'] = 'Trash';
                $this->Metalcolor->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Metal Color already exists in the project.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Metal Color has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {


                        $metalcolors = $this->Metalcolor->find('first', array('conditions' => array('metalcolor_id' => $metaldelete)));
                        $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $metalcolors['Metalcolor']['metal_id'])));
                        $product = $this->Product->find('all', array('conditions' => array('metal' => $metal['Metal']['metal_name'], 'FIND_IN_SET(\'' . $metalcolors['Metalcolor']['metalcolor'] . '\',metal_color)')));
                        if (empty($product)) {
                            $this->request->data['Metalcolor']['metalcolor_id'] = $metaldelete;
                            $this->request->data['Metalcolor']['status'] = 'Trash';
                            $this->Metalcolor->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Metal Color already exists in the project.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
                $this->Session->setFlash("<div class='success msg'>" . __('Metal Color has been deleted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Metalcolor']['metalcolor_id'] = $this->params['pass']['0'];
        $this->request->data['Metalcolor']['status'] = $this->params['pass']['1'];
        $this->Metalcolor->save($this->request->data);
        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
