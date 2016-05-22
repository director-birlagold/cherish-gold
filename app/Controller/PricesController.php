<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class PricesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Price', 'Jeweltype', 'Metalcolor', 'Metal', 'Diamond', 'Gemstone', 'Clarity', 'Color', 'Carat', 'Shape', 'Settingtype', 'Purity', 'Productmetal', 'Productgemstone', 'Productdiamond');
    public $layout = 'admin';
	/*List Price */
    public function admin_index($page = NULL) {
        $this->checkadmin();
        $this->Price->recursive = 0;
			
        if(isset($_REQUEST['searchfilter'])){
            $search = array();
            $search = array('Price.status !=' => 'Trash');
            if ($_REQUEST['searchtype'] == 'Metals') {
                if (!empty($_REQUEST['searchtype']) && (!empty($_REQUEST['searchname']))) {
                    $search = array_merge($search, array('Price.metal_id' => $_REQUEST['searchname'], 'Price.type' => $_REQUEST['searchtype']));
                }
            } elseif ($_REQUEST['searchtype'] == 'Stone') {
                if (!empty($_REQUEST['searchtype']) && (!empty($_REQUEST['searchname']))) {
                    $search = array_merge($search, array('Price.diamond_id' => $_REQUEST['searchname'], 'Price.type' => $_REQUEST['searchtype']));
                }
            } elseif ($_REQUEST['searchtype'] == 'Gemstone') {
                if (!empty($_REQUEST['searchtype']) && (!empty($_REQUEST['searchname']))) {
                    $search = array_merge($search, array('Price.gemstone_id' => $_REQUEST['searchname'], 'Price.type' => $_REQUEST['searchtype']));
                }
            }
            if (!empty($_REQUEST['searchtype'])) {
                $search = array_merge($search, array('Price.type ' => $_REQUEST['searchtype']));
            }
            $this->paginate = array('conditions' => $search, 'order' => 'price_id DESC');
            $this->set('price', $this->Paginator->paginate('Price'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'price_id DESC');
            $this->set('price', $this->Paginator->paginate('Price'));
        }
    }
	/*Add & Edit Price */
    public function admin_add() {
        $this->checkadmin();

        /* $clarity=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Stone Clarity','status'=>'Active'),'order'=>'type_id ASC'));			
          $this->set('clarity',$clarity);
          $colors=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Stone Color','status'=>'Active'),'order'=>'type_id ASC'));
          $this->set('colors',$colors);
          $carats=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Stone Carat','status'=>'Active'),'order'=>'type_id ASC'));
          $this->set('carats',$carats);
          $shapes=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Stone Shape','status'=>'Active'),'order'=>'type_id ASC'));
          $this->set('shape',$shapes);
          $type=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Setting Type','status'=>'Active'),'order'=>'type_id ASC'));
          $this->set('type',$type); */

        $clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'clarity_id ASC'));
        $this->set('clarity', $clarity);

        $carats = $this->Carat->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'carat_id ASC'));
        $this->set('carats', $carats);
        $shapes = $this->Shape->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
        $this->set('shape', $shapes);
        $type = $this->Settingtype->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'settingtype_id ASC'));
        $this->set('type', $type);
        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);
        $diamond = $this->Diamond->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('diamond', $diamond);

        $gemstone = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('gemstone', $gemstone);

        if (!isset($this->params['pass']['0'])) {

            /*Add Price */
            if ($this->request->is('post')) {
               
                if ($this->request->data['Price']['type'] == 'Metals') {
                    if($this->request->data['Price']['metal_fineness'] == 0){
                        $price = $this->Price->find('first', array('conditions' => array('type' => $this->request->data['Price']['type'], 'metal_id' => $this->request->data['Price']['metal_id'], 'status !=' => 'Trash', 'metalcolor_id' => $this->request->data['Price']['metalcolor_id'], 'metal_fineness' => 0)));
                    }else{
                        $price = $this->Price->find('first', array('conditions' => array('type' => $this->request->data['Price']['type'], 'metal_id' => $this->request->data['Price']['metal_id'], 'status !=' => 'Trash', 'metalcolor_id' => $this->request->data['Price']['metalcolor_id'], 'metal_fineness' => $this->request->data['Price']['metal_fineness'])));
                    }
                }if ($this->request->data['Price']['type'] == 'Stone') {
                    $price = $this->Price->find('first', array('conditions' => array('type' => $this->request->data['Price']['type'], 'diamond_id' => $this->request->data['Price']['diamond_id'], 'clarity_id' => $this->request->data['Price']['clarity_id'], 'color_id' => $this->request->data['Price']['color_id'], 'status !=' => 'Trash')));
                }if ($this->request->data['Price']['type'] == 'Gemstone') {
                    $price = $this->Price->find('first', array('conditions' => array('type' => $this->request->data['Price']['type'], 'gemstone_id' => $this->request->data['Price']['gemstone_id'], 'gemstoneshape' => $this->request->data['Price']['gemstoneshape'], 'status !=' => 'Trash', 'metalcolor_id' => $this->request->data['Price']['metalcolor_id'])));
                }
                if (empty($price)) {

                    $this->request->data['Price']['status'] = 'Active';
                    $this->request->data['Price']['created_date'] = date('Y-m-d H:i:s');
                    $this->request->data['Price']['modify_date'] = date('Y-m-d H:i:s');
                    $this->Price->save($this->request->data);
                    if ($this->request->data['Price']['type'] == 'Gemstone') {
                        $gemstone = $this->Gemstone->find('first', array('conditons' => array('gemstone_id' => $this->request->data['Price']['gemstone_id'])));
                        $gemstoneshape = $this->Shape->find('first', array('conditons' => array('shape_id' => $this->request->data['Price']['gemstoneshape'])));
                        $this->Productgemstone->updateAll(array('stone_price' => $this->request->data['Price']['price']), array('gemstone' => $gemstone['Gemstone']['stone'], 'shape' => $gemstoneshape['Shape']['shape']));
                    }
                    $this->Session->setFlash('<div class="success msg">Price save successfully.</div>', 'default');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="error msg">Price  already exits.</div>', '');
                }
            }
        } else {
			/*Edit Price */
            $prices = $this->Price->find('first', array('conditions' => array('price_id' => $this->params['pass']['0'])));
            $this->set('price', $prices);

            $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
            $this->set('metal', $metals);





            if ($this->request->is('post')) {
                if ($prices['Price']['type'] == 'Metals') {
                    if($this->request->data['Price']['metal_fineness'] == 0){
                        $price = $this->Price->find('first', array('conditions' => array('status !=' => 'Trash', 'type' => $this->request->data['Price']['type'], 'metal_id' => $this->request->data['Price']['metal_id'], 'metalcolor_id' => $this->request->data['Price']['metalcolor_id'], 'price_id !=' => $prices['Price']['price_id'], 'metal_fineness' => 0)));
                    }else{
                        $price = $this->Price->find('first', array('conditions' => array('status !=' => 'Trash', 'type' => $this->request->data['Price']['type'], 'metal_id' => $this->request->data['Price']['metal_id'], 'metalcolor_id' => $this->request->data['Price']['metalcolor_id'], 'price_id !=' => $prices['Price']['price_id'], 'metal_fineness' => $this->request->data['Price']['metal_fineness'])));
                    }
                } if ($prices['Price']['type'] == 'Stone') {
                    $price = $this->Price->find('first', array('conditions' => array('type' => $this->request->data['Price']['type'], 'diamond_id' => $this->request->data['Price']['diamond_id'], 'clarity_id' => $this->request->data['Price']['clarity_id'], 'color_id' => $this->request->data['Price']['color_id'], 'status !=' => 'Trash', 'price_id !=' => $prices['Price']['price_id'])));
                } if ($prices['Price']['type'] == 'Gemstone') {
                    $price = $this->Price->find('first', array('conditions' => array('status !=' => 'Trash', 'type' => $this->request->data['Price']['type'], 'gemstone_id' => $this->request->data['Price']['gemstone_id'], 'gemstoneshape' => $this->request->data['Price']['gemstoneshape'], 'price_id !=' => $prices['Price']['price_id'])));
                }

                if (empty($price)) {
                    $this->request->data['Price']['price_id'] = $prices['Price']['price_id'];
                    $this->Price->save($this->request->data);
                    if ($this->request->data['Price']['type'] == 'Gemstone') {
                        $gemstone = $this->Gemstone->find('first', array('conditions' => array('gemstone_id' => $this->request->data['Price']['gemstone_id'])));
                        $gemstoneshape = $this->Shape->find('first', array('conditions' => array('shape_id' => $this->request->data['Price']['gemstoneshape'])));
                        $this->Productgemstone->updateAll(array('stone_price' => $this->request->data['Price']['price']), array('gemstone' => $gemstone['Gemstone']['stone'], 'shape' => $gemstoneshape['Shape']['shape']));
                    }
                    $this->Session->setFlash('<div class="success msg">Price save successfully.</div>', 'default');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="error msg">Price  already exits.</div>', '');
                }
            }
        }
    }
	/*Ajax Get Metal type */
    public function metal_type() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $type = $this->Metal->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($type)) {
                echo json_encode($type);
            } else {
                echo '[]';
            }
        }
    }
	/*Ajax Get Stone type */
    public function stone_types() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $type = $this->Diamond->find('all', array('conditions' => array('status' => 'Active')));

            if (!empty($type)) {
                echo json_encode($type);
            } else {
                echo '[]';
            }
        }
    }
	/*Ajax Get Gemstone type */
    public function gemstone_types() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $type = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active')));

            if (!empty($type)) {
                echo json_encode($type);
            } else {
                echo '[]';
            }
        }
    }
	/* Change Status Price*/
    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Price']['price_id'] = $id;
        $this->request->data['Price']['status'] = $status;
        $this->Price->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Price Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }
	/* Delete Price*/
    public function admin_delete() {
        $this->checkadmin();
		/*Single Price  Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Price->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Price->exists()) {
                throw new NotFoundException(__('Invalid Price'));
            }

            $this->request->data['Price']['price_id'] = $this->params['pass']['0'];
            $this->request->data['Price']['status'] = 'Trash';
            $this->Price->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Price has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Price  Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $price) {
                    if ($price > 0) {
                        $this->request->data['Price']['price_id'] = $price;
                        $this->request->data['Price']['status'] = 'Trash';
                        $this->Price->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Price has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }
	/*Ajax Get Metal Color  */
    public function metalcolor() {

        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $metal = $this->Metal->find('first', array('conditions' => array('metal_id' => $id)));

        if (!empty($metal)) {
            $colors = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $metal['Metal']['metal_id'], 'status' => 'Active')));
            if (!empty($colors)) {
                echo '<select name="data[Price][metalcolor_id]" class="validate[required]" id="metals_color"><option value="">Select Color</option>';
                foreach ($colors as $colors) {
                    echo '<option value="' . $colors['Metalcolor']['metalcolor_id'] . '">' . $colors['Metalcolor']['metalcolor'] . '</option>';
                }
                echo '</select>';
            } else {
                echo '[]';
            }
        } else {
            echo 'No';
        }
    }
	/*Ajax Get Stone Color  */
    public function stone_color() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $stone_clarity = $this->Clarity->find('first', array('conditions' => array('clarity_id' => $id, 'status' => 'Active')));
            $stone_color = $this->Color->find('all', array('conditions' => array('clarity' => $stone_clarity['Clarity']['clarity'], 'status' => 'Active')));
            if (!empty($stone_color)) {
                echo json_encode($stone_color);
            } else {
                echo '[]';
            }
        }
    }

}
