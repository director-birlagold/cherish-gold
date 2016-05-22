<?php

App::uses('AppController', 'Controller');

/**
 * Category Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class JeweltypesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Jeweltype', 'Category', 'Productsize', 'Metalcolor');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Jeweltype->recursive = 0;
        $type = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if ($type == "Size") {
            $this->paginate = array('conditions' => array('product_id' => 0, 'category_id !=' => ''), 'order' => 'type_id DESC');
            $this->set('productsize', $this->Paginator->paginate('Productsize'));
            $this->set('type', $type);
        } else {
            if (isset($this->request->data['searchfilter'])) {
                $this->redirect(array('action' => 'index/' . $this->params['pass']['0'] . '?search=1&searchterm=' . $this->request->data['searchterm']));
            }


            if ($this->request->query('search') != '') {
                $conditions = array('name LIKE' => '%' . $this->request->query('searchterm') . '%', 'status !=' => 'Trash', 'type' => $type);
            } else {
                $conditions = array('status !=' => 'Trash', 'type' => $type);
            }

            $this->paginate = array('conditions' => $conditions, 'order' => 'type_id DESC');
            $this->set('jeweltype', $this->Paginator->paginate('Jeweltype'));
            $this->set('type', $type);
        }
    }

    public function admin_add() {
        $this->checkadmin();
        $type = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if ($this->request->is('post')) {
            if ($type != 'Size') {
                $jeweltype = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'type' => $type, 'status !=' => 'Trash')));
            }
            if ($type == 'Size') {
                $jeweltype = '';
            }

            if ($type == 'Metal Color') {

                $jewel = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'type' => $type, 'status !=' => 'Trash')));
                if (!empty($jewel)) {
                    $id = $jewel['Jeweltype']['type_id'];
                    $jeweltype = $this->Metalcolor->find('first', array('conditions' => array('type_id' => $id, 'metals' => $this->request->data['Metalcolor']['metals'])));
                }
            }
            if ($type == 'Size') {
                $jeweltype = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'type' => $type, 'status !=' => 'Trash')));
                if (empty($jeweltype)) {
                    $this->request->data['Jeweltype']['status'] = 'Active';
                    $this->request->data['Jeweltype']['type'] = $type;
                    $this->request->data['Jeweltype']['created_date'] = date('Y-m-d H:i:s');
                    $this->request->data['Jeweltype']['modify_date'] = date('Y-m-d H:i:s');
                    $this->Jeweltype->save($this->request->data);
                    $type_id = $this->Jeweltype->getLastInsertID();
                } else {
                    $type_id = $jeweltype['Jeweltype']['type_id'];
                }
                $check = $this->Productsize->find('first', array('conditions' => array('type_id' => $type_id, 'goldpurity' => $this->request->data['Productsize']['goldpurity'], 'status' => 'Active')));
                if (empty($check)) {
                    $this->request->data['Productsize']['type_id'] = $type_id;
                    $this->request->data['Productsize']['status'] = 'Active';
                    $this->Productsize->save($this->request->data);
                    $this->Session->setFlash('<div class="success msg">' . $type . ' added successfully.</div>', '');
                    $this->redirect(array('action' => 'index', $this->params['pass']['0']));
                } else {
                    $this->Session->setFlash('<div class="error msg">' . $type . ' already exists.</div>', '');
                }
            } else {

                if (empty($jeweltype)) {
                    $this->request->data['Jeweltype']['status'] = 'Active';
                    $this->request->data['Jeweltype']['type'] = $type;
                    $this->request->data['Jeweltype']['created_date'] = date('Y-m-d H:i:s');
                    $this->request->data['Jeweltype']['modify_date'] = date('Y-m-d H:i:s');
                    $this->Jeweltype->save($this->request->data);
                    $type_id = $this->Jeweltype->getLastInsertID();
                    if ($type == 'Metal Color') {
                        $metalcolor = $this->Metalcolor->find('first', array('conditions' => array('type_id' => $type_id)));
                        if (empty($productsize)) {
                            $this->request->data['Metalcolor']['type_id'] = $type_id;
                            $this->Metalcolor->save($this->request->data);
                        }
                    }

                    $this->Session->setFlash('<div class="success msg">' . $type . ' added successfully.</div>', '');
                    $this->redirect(array('action' => 'index', $this->params['pass']['0']));
                } else {
                    $this->Session->setFlash('<div class="error msg">' . $type . ' already exits.</div>', '');
                }
            }
        }
        $this->set('type', $type);
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('category', $category);

        $golds = $this->Jeweltype->find('all', array('conditions' => array('type' => 'Purity', 'status' => 'Active')));
        $this->set('golds', $golds);

        $metal = $this->Jeweltype->find('all', array('conditions' => array('type' => 'Metals', 'status' => 'Active')));
        $this->set('metal', $metal);
    }

    public function admin_edit($types, $id = null) {
        $this->checkadmin();
        $type = ucwords(str_replace('_', ' ', $this->params['pass']['0']));

        $jeweltype = $this->Jeweltype->find('first', array('conditions' => array('type_id' => $id)));
        $this->set('jeweltype', $jeweltype);

        if ($this->request->is('post')) {
            if ($type != 'Size') {

                $check = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'status !=' => 'Trash', 'type' => $type, 'type_id !=' => $id)));
            }
            if ($type == 'Size') {
                $jeweltype = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'type' => $type, 'status !=' => 'Trash')));
                if (empty($jeweltype)) {
                    $this->request->data['Jeweltype']['status'] = 'Active';
                    $this->request->data['Jeweltype']['type'] = $type;
                    $this->request->data['Jeweltype']['created_date'] = date('Y-m-d H:i:s');
                    $this->request->data['Jeweltype']['modify_date'] = date('Y-m-d H:i:s');
                    $this->Jeweltype->save($this->request->data);
                    $type_id = $this->Jeweltype->getLastInsertID();
                } else {
                    $type_id = $jeweltype['Jeweltype']['type_id'];
                }
                /* $check=$this->Productsize->find('first',array('conditions'=>array('type_id'=> $type_id,'goldpurity'=>$this->request->data['Productsize']['goldpurity'],'status'=>'Active','product_size !='=>$id)));
                  echo $id;
                  pr($check);exit;
                  if(empty($check)){ */
                $this->request->data['Productsize']['product_size'] = $id;
                $this->request->data['Productsize']['type_id'] = $type_id;
                $this->request->data['Productsize']['status'] = 'Active';
                $this->Productsize->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">' . $type . ' added successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
                /* }else{
                  $this->Session->setFlash('<div class="error msg">'.$type.' already exists.</div>','');
                  } */
            } else {
                if ($type == 'Metal Color') {

                    $jewel = $this->Jeweltype->find('first', array('conditions' => array('name' => $this->request->data['Jeweltype']['name'], 'type' => $type, 'status !=' => 'Trash', 'type_id !=' => $id)));

                    if (!empty($jewel)) {
                        $id = $jewel['Jeweltype']['type_id'];
                        $jeweltype = $this->Metalcolor->find('first', array('conditions' => array('type_id' => $id, 'metals' => $this->request->data['Metalcolor']['metals'])));
                    }
                }
                if (empty($check)) {
                    $this->request->data['Jeweltype']['type_id'] = $id;
                    $this->request->data['Jeweltype']['type'] = $type;
                    $this->request->data['Jeweltype']['name'] = $this->request->data['Jeweltype']['name'];
                    $this->request->data['Jeweltype']['modify_date'] = date('Y-m-d H:i:s');
                    $this->Jeweltype->save($this->request->data);
                    if ($type == 'Size') {
                        $this->Productsize->deleteAll(array('type_id' => $id));
                        $productsize = $this->Productsize->find('first', array('conditions' => array('type_id' => $id)));
                        if (empty($productsize)) {
                            $this->request->data['Productsize']['type_id'] = $id;
                            $this->Productsize->save($this->request->data);
                        }
                    }
                    if ($type == 'Metal Color') {
                        $metalcolor = $this->Metalcolor->find('first', array('conditions' => array('type_id' => $id)));
                        if (empty($metalcolor)) {
                            $this->request->data['Metalcolor']['type_id'] = $id;
                            $this->Metalcolor->save($this->request->data);
                        }
                    }

                    $this->Session->setFlash('<div class="success msg">' . $type . ' updated successfully.</div>', '');
                    $this->redirect(array('action' => 'index', $this->params['pass']['0']));
                } else {
                    $this->Session->setFlash('<div class="error msg">' . $type . ' already exits.</div>', '');
                }
            }
        }

        if ($type == 'Size') {
            $productsize = $this->Productsize->find('first', array('conditions' => array('product_size' => $id)));
            $this->set('productsize', $productsize);
            $jeweltype = $this->Jeweltype->find('first', array('conditions' => array('type_id' => $productsize['Productsize']['type_id'], 'type' => $type, 'status !=' => 'Trash')));
            $this->set('jeweltype', $jeweltype);
        } else {
            $productsize = $this->Productsize->find('first', array('conditions' => array('type_id' => $id)));
            $this->set('productsize', $productsize);
        }

        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('category', $category);

        $golds = $this->Jeweltype->find('all', array('conditions' => array('type' => 'Purity', 'status' => 'Active')));
        $this->set('golds', $golds);

        $metal = $this->Jeweltype->find('all', array('conditions' => array('type' => 'Metals', 'status' => 'Active')));
        $this->set('metal', $metal);

        $colors = $this->Metalcolor->find('first', array('conditions' => array('type_id' => $id)));
        $this->set('colors', $colors);
    }

    public function admin_delete() {
        $this->checkadmin();
        $type = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if (!empty($this->params['pass']['1'])) {
            $this->request->data['Jeweltype']['type_id'] = $this->params['pass']['1'];
            $this->request->data['Jeweltype']['status'] = 'Trash';
            $this->Jeweltype->updateAll(array('status' => "'Trash'"), array('type_id' => $this->params['pass']['1']));
            if ($type == 'Size') {
                $productsize = $this->Productsize->find('first', array('conditions' => array('type_id' => $this->params['pass']['1'])));
                $this->request->data['Productsize']['product_size'] = $productsize['Productsize']['product_size'];
                $this->request->data['Productsize']['type_id'] = $this->params['pass']['1'];
                $this->request->data['Productsize']['status'] = 'Trash';
                $this->Productsize->saveAll($this->request->data);
            }

            if ($type == 'Metals') {

                $color = $this->Metalcolor->find('all', array('conditions' => array('metals' => $this->params['pass']['1'], 'status !=' => 'Trash')));
                foreach ($color as $color) {

                    $jewels = $this->Jeweltype->find('first', array('conditions' => array('type_id' => $color['Metalcolor']['type_id'], 'status !=' => 'Trash')));
                    if (!empty($jewels)) {
                        $this->request->data['Jeweltype']['type_id'] = $jewels['Jeweltype']['type_id'];
                        $this->request->data['Jeweltype']['status'] = 'Trash';
                        $this->Jeweltype->saveAll($this->request->data);
                    }
                }
            }


            $this->Session->setFlash('<div class="success msg">' . $type . ' has been deleted successfully.</div>', '');
            $this->redirect(array('action' => 'index', $this->params['pass']['0']));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $array) {
                    if ($array > 0) {
                        $this->request->data['Jeweltype']['type_id'] = $array;
                        $this->request->data['Jeweltype']['status'] = 'Trash';
                        $this->Jeweltype->saveAll($this->request->data);
                        if ($type == 'Size') {
                            $product = $this->Productsize->find('all', array('conditions' => array('type_id' => $array)));

                            foreach ($product as $product) {
                                $this->request->data['Productsize']['product_size'] = $product['Productsize']['product_size'];
                                $this->request->data['Productsize']['type_id'] = $array;
                                $this->request->data['Productsize']['status'] = 'Trash';
                                $this->Productsize->saveAll($this->request->data);
                            }
                        }

                        if ($type == 'Metals') {

                            $color = $this->Metalcolor->find('all', array('conditions' => array('metals' => $array, 'status !=' => 'Trash')));
                            foreach ($color as $color) {

                                $jewels = $this->Jeweltype->find('first', array('conditions' => array('type_id' => $color['Metalcolor']['type_id'], 'status !=' => 'Trash')));

                                $this->request->data['Jeweltype']['type_id'] = $jewels['Jeweltype']['type_id'];
                                $this->request->data['Jeweltype']['status'] = 'Trash';
                                $this->Jeweltype->saveAll($this->request->data);
                            }
                        }
                    }
                }
                $this->Session->setFlash('<div class="success msg">' . $type . ' has been deleted successfully.</div>', '');
                $this->redirect(array('controller' => 'jeweltypes', 'action' => 'index', $this->params['pass']['0']));
            }
        }
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Jeweltype']['type_id'] = $this->params['pass']['1'];
        $this->request->data['Jeweltype']['status'] = $this->params['pass']['2'];
        $this->Jeweltype->save($this->request->data);
        $productsize = $this->Productsize->find('first', array('conditions' => array('type_id' => $this->params['pass']['1'])));
        if (!empty($productsize)) {
            $this->request->data['Productsize']['product_size'] = $productsize['Productsize']['product_size'];
            $this->request->data['Productsize']['type_id'] = $this->params['pass']['1'];
            $this->request->data['Productsize']['status'] = $this->params['pass']['2'];
            $this->Productsize->save($this->request->data);
        }

        $color = $this->Metalcolor->find('all', array('conditions' => array('metals' => $this->params['pass']['1'], 'status !=' => 'Trash')));

        if (!empty($color)) {
            foreach ($color as $color) {

                $jewels = $this->Jeweltype->find('first', array('conditions' => array('type_id' => $color['Metalcolor']['type_id'], 'status !=' => 'Trash')));

                if (!empty($jewels)) {

                    $this->request->data['Jeweltype']['type_id'] = $jewels['Jeweltype']['type_id'];
                    $this->request->data['Jeweltype']['status'] = $this->params['pass']['2'];
                    $this->Jeweltype->saveAll($this->request->data);
                }
            }
        }
        $this->Session->setFlash('<div class="success msg">' . ucwords(str_replace('_', ' ', $this->params['pass']['0'])) . ' ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }

}
