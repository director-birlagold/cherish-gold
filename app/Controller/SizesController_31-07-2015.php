<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class SizesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Size', 'Category', 'Purity', 'Productmetal');
    public $layout = 'admin';
	 /*List  Size */
    public function admin_index() {
        $this->checkadmin();
        $this->Size->recursive = 0;
		/*search redirect*/	
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchmetal'] != '') {
                $search[] = 'searchmetal=' . $this->request->data['searchmetal'];
            }

            if ($this->request->data['searchsize'] != '') {
                $search[] = 'searchsize=' . $this->request->data['searchsize'];
            }
            if ($this->request->data['searchpurity'] != '') {
                $search[] = 'searchpurity=' . $this->request->data['searchpurity'];
            }
            /* if($this->request->data['searchterm']!=''){
              $search[]='searchterm='.$this->request->data['searchterm'];
              } */

            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }/*query for search*/
		if ($this->request->query('search') != '') {
            $conditions['status !='] = 'Trash';
            if ($this->request->query('searchmetal') != '') {
                $conditions['category_id'] = $this->request->query('searchmetal');
            }
            if ($this->request->query('searchsize') != '') {
                $conditions['size'] = $this->request->query('searchsize');
            }
            if ($this->request->query('searchpurity') != '') {
                $conditions['goldpurity'] = $this->request->query('searchpurity');
            }
        } else {
            $conditions = array('status !=' => 'Trash');
        }
        $this->paginate = array('conditions' => $conditions, 'order' => 'size_id DESC');
        $this->set('size', $this->Paginator->paginate('Size'));
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('category', $category);
    }
	/*Add   Size*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $type = $this->Size->find('first', array('conditions' => array('size' => $this->request->data['Size']['size'], 'goldpurity' => $this->request->data['Size']['goldpurity'], 'category_id' => $this->request->data['Size']['category_id'], 'status !=' => 'Trash')));
            if (empty($type)) {
                if (!empty($this->request->data['Size']['size_value'])) {
                    $this->request->data['Size']['size_value'] = $this->request->data['Size']['size_value'];
                } else {
                    $this->request->data['Size']['size_value'] = $this->request->data['Size']['size'];
                }
                $this->Size->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Size added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Size already exits.</div>', '');
            }
        }
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('category', $category);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('purity', $purity);
    }
	/*Edit   Size*/
    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Size->exists($id)) {
            throw new NotFoundException(__('Invalid Size'));
        }
        $metal = $this->Size->find('first', array('conditions' => array('size_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {
            $type = $this->Size->find('first', array('conditions' => array('size' => $this->request->data['Size']['size'], 'goldpurity' => $this->request->data['Size']['goldpurity'], 'category_id' => $this->request->data['Size']['category_id'], 'status !=' => 'Trash', 'size_id !=' => $this->params['pass']['0'])));
            if (empty($type)) {
                $metal = $this->Size->find('first', array('conditions' => array('size_id' => $this->params['pass']['0'])));

                $productmetal = $this->Productmetal->find('all', array('conditions' => array('type' => 'Size', 'value' => $metal['Size']['size_value'], 'category_id' => $metal['Size']['category_id'])));
				/*Edit Size in Productmetal Table*/

                if (!empty($productmetal)) {

                    foreach ($productmetal as $products) {
                        $this->request->data['Productmetal']['productmetal_id'] = $products['Productmetal']['productmetal_id'];
                        $this->request->data['Productmetal']['category_id'] = $this->request->data['Size']['category_id'];
                        
                        $this->request->data['Productmetal']['value'] = $this->request->data['Size']['size_value'];
                        $this->Productmetal->save($this->request->data);
                    }
                }
                $this->request->data['Size']['size_id'] = $this->params['pass'][0];
                $categoryid = $this->Category->find('first', array('conditions' => array('category_id' => $this->request->data['Size']['category_id'], 'category' => 'Bangles')));
                if (!empty($categoryid)) {
                    $this->request->data['Size']['size_value'] = $this->request->data['Size']['size_value'];
                } else {
                    $this->request->data['Size']['size_value'] = $this->request->data['Size']['size'];
                }
                $this->Size->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Size updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Size already exits.</div>', '');
            }
        } else {
            $this->request->data = $metal;
        }
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('purity', $purity);
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('category', $category);
    }
	/*Delete Size*/
    public function admin_delete() {
        $this->checkadmin();
		/*Single Size Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Size->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Size->exists()) {
                throw new NotFoundException(__('Invalid Size'));
            }
            $size = $this->Size->find('first', array('conditions' => array('size_id' => $this->params['pass']['0'])));
            $product = $this->Productmetal->find('all', array('conditions' => array('type' => 'Size', 'value' => $size['Size']['size'])));
            if (empty($product)) {
                $this->request->data['Size']['size_id'] = $this->params['pass']['0'];
                $this->request->data['Size']['status'] = 'Trash';
                $this->Size->save($this->request->data);
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Size already exists in the product.Please delete the product') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Size has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Size Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $metaldelete) {
                    if ($metaldelete > 0) {
                        $size = $this->Size->find('first', array('conditions' => array('size_id' => $metaldelete)));
                        $product = $this->Productmetal->find('all', array('conditions' => array('type' => 'Size', 'value' => $size['Size']['size'])));
                        if (empty($product)) {
                            $this->request->data['Size']['size_id'] = $metaldelete;
                            $this->request->data['Size']['status'] = 'Trash';
                            $this->Size->saveAll($this->request->data);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Size already exists in the product.Please delete the product') . "</div>", '');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Size has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Change Status  Size */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Size']['size_id'] = $this->params['pass']['0'];
        $this->request->data['Size']['status'] = $this->params['pass']['1'];
        $this->Size->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }
	/*Ajax Get Size value  */
    public function size_value() {
        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $sizevalue = $this->Category->find('first', array('conditions' => array('status' => 'Active', 'category_id' => $id, 'category' => 'Bangles')));
        if (!empty($sizevalue)) {
            echo 'Yes';
        } else {
            echo 'No';
        }
    }

}
