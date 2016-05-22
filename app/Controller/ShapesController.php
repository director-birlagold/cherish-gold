<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator<br>

 */
class ShapesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Shape', 'Productdiamond', 'Productgemstone');
    public $layout = 'admin';
	 /*List  Shape */
    public function admin_index() {
        $this->checkadmin();
        $this->Shape->recursive = 0;
		/*search redirect*/
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchshape=' . $this->request->data['searchshape']));
        }
	/*query for search*/

        if ($this->request->query('search') != '') {
            $conditions = array('shape LIKE' => '%' . $this->request->query('searchshape') . '%', 'status !=' => 'Trash');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'shape_id DESC');
        $this->set('shape', $this->Paginator->paginate('Shape'));
    }
	 /*Add  Shape */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Shape->find('first', array('conditions' => array('shape' => $this->request->data['Shape']['shape'], 'status !=' => 'Trash')));
            if (empty($type)) {
                $this->Shape->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Shape added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Shape already exits.</div>', '');
            }
        }
    }
	 /*Edit  Shape */
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Shape->exists($id)) {
            throw new NotFoundException(__('Invalid Shape'));
        }
        $metal = $this->Shape->find('first', array('conditions' => array('shape_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Shape->find('first', array('conditions' => array('shape' => $this->request->data['Shape']['shape'], 'status !=' => 'Trash', 'shape_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
				/*Edit Shape in Productdiamond Table*/
                $metal = $this->Shape->find('first', array('conditions' => array('shape_id' => $this->params['pass']['0'])));
                $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
                if (!empty($shapediamond)) {
                    foreach ($shapediamond as $diamond) {
                        $this->request->data['Productdiamond']['productdiamond_id'] = $diamond['Productdiamond']['productdiamond_id'];
                        $this->request->data['Productdiamond']['shape'] = $this->request->data['Shape']['shape'];
                        $this->Productdiamond->saveAll($this->request->data);
                    }
                }/*Edit Shape in ProductGemstone Table*/
                $shapestone = $this->Productgemstone->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
                if (!empty($shapestone)) {
                    foreach ($shapestone as $shapestone) {
                        $this->request->data['Productgemstone']['productgemstone_id'] = $shapestone['Productgemstone']['productgemstone_id'];
                        $this->request->data['Productgemstone']['shape'] = $this->request->data['Shape']['shape'];
                        $this->Productgemstone->saveAll($this->request->data);
                    }
                }

                $this->request->data['Shape']['shape_id'] = $this->params['pass'][0];
                $this->Shape->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Shape updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Shape already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
    }
	 /*Delete  Shape */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Shape Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Shape->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Shape->exists()) {
                throw new NotFoundException(__('Invalid Shape'));
            }
            $metal = $this->Shape->find('first', array('conditions' => array('shape_id' => $this->params['pass']['0'])));
            $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
            $shapestone = $this->Productgemstone->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
            if (empty($shapediamond) && empty($shapestone)) {
                $this->request->data['Shape']['shape_id'] = $this->params['pass']['0'];
                $this->request->data['Shape']['status'] = 'Trash';
                $this->Shape->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('A shape already used in the product. Please delete the product') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }

            $this->Session->setFlash("<div class='success msg'>" . __('Shape has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Shape Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $metal = $this->Shape->find('first', array('conditions' => array('shape_id' => $metaldelete)));
                        $shapediamond = $this->Productdiamond->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
                        $shapestone = $this->Productgemstone->find('all', array('conditions' => array('shape' => $metal['Shape']['shape'])));
                        if (empty($shapediamond) && empty($shapestone)) {
                            $this->request->data['Shape']['shape_id'] = $metaldelete;
                            $this->request->data['Shape']['status'] = 'Trash';
                            $this->Shape->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('A shape already used in the product. Please delete the product') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Shape has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Change Status  Shape */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Shape']['shape_id'] = $this->params['pass']['0'];
        $this->request->data['Shape']['status'] = $this->params['pass']['1'];
        $this->Shape->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
