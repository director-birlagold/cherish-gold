<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class ColorsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Color', 'Productdiamond', 'Clarity');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Color->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchcolor=' . $this->request->data['searchcolor']));
        }


        if ($this->request->query('search') != '') {
            $conditions = array('color LIKE' => '%' . $this->request->query('searchcolor') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'color_id DESC');
        $this->set('color', $this->Paginator->paginate('Color'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Color->find('first', array('conditions' => array('clarity' => $this->request->data['Color']['clarity'], 'color' => $this->request->data['Color']['color'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Color->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Color added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Color already exits.</div>', '');
            }
        }
        $clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('clarity', $clarity);
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Color->exists($id)) {
            throw new NotFoundException(__('Invalid Color'));
        }
        $metal = $this->Color->find('first', array('conditions' => array('color_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Color->find('first', array('conditions' => array('clarity' => $this->request->data['Color']['clarity'], 'color' => $this->request->data['Color']['color'], 'status !=' => 'Trash', 'color_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {

                $color = $this->Color->find('first', array('conditions' => array('color_id' => $this->params['pass']['0'])));
                $diamond = $this->Productdiamond->find('all', array('conditions' => array('color' => $color['Color']['color'])));
                if (!empty($diamond)) {
                    foreach ($diamond as $diamond) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $diamond['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['color'] = $this->request->data['Color']['color'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }
                $this->request->data['Color']['color_id'] = $this->params['pass'][0];
                $this->Color->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Color updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Color already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
        $clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('clarity', $clarity);
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Color->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Color->exists()) {
                throw new NotFoundException(__('Invalid Color'));
            }
            $color = $this->Color->find('first', array('conditions' => array('color_id' => $this->params['pass']['0'])));
            $colors = $this->Productdiamond->find('all', array('conditions' => array('color' => $color['Color']['color'])));
            if (empty($colors)) {
                $this->request->data['Color']['color_id'] = $this->params['pass']['0'];
                $this->request->data['Color']['status'] = 'Trash';
                $this->Color->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Color already exists in the product.Please delete the project') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Color has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $color = $this->Color->find('first', array('conditions' => array('color_id' => $metaldelete)));
                        $colors = $this->Productdiamond->find('all', array('conditions' => array('color' => $color['Color']['color'])));
                        if (empty($colors)) {
                            $this->request->data['Color']['color_id'] = $metaldelete;
                            $this->request->data['Color']['status'] = 'Trash';
                            $this->Color->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Color already exists in the product.Please delete the project') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Color has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Color']['color_id'] = $this->params['pass']['0'];
        $this->request->data['Color']['status'] = $this->params['pass']['1'];
        $this->Color->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
