<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubmenusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Menu', 'Category', 'Submenu');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function admin_index($id = NULL) {
        $this->checkadmin();
        $this->Submenu->recursive = 0;
        $this->Paginator->settings = array(
            'conditions' => array('Submenu.menu_id' => $id)
        );
        $this->set('submenus', $this->Paginator->paginate('Submenu'));
        $this->set('menu', $this->Menu->findByMenuId($id));
        $this->set('id', $id);
    }
    
    public function admin_add($id = NULL) {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Submenu->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
            $this->redirect(array('action' => 'add',$id));
        }
        $this->set('menu', $this->Menu->findByMenuId($id));
        $this->set(compact('id'));
    }
    
    public function admin_edit($id = NULL) {
        $this->checkadmin();
        $submenu = $this->Submenu->read(null, $id);
        if(empty($submenu))
            $this->redirect(array('action' => 'index', $id));

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Submenu->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Updated</div>');
            $this->redirect(array('action' => 'index', $submenu['Menu']['menu_id']));
        }else{
            $this->request->data = $submenu;
        }
        $this->set(compact('id', 'submenu'));
    }
    
    public function admin_delete($id = NULL) {
        $this->checkadmin();
        $menus = $this->Menu->read(null, $id);
        if(empty($menus))
            $this->redirect(array('action' => 'index'));

        $check_orders = $this->Order->find('count', array('conditions' => array('Order.order_status_id' => $id)));
        if($check_orders > 0){
            $this->Session->setFlash('<div class="error msg">This order status is used in order. Failed to delete</div>');
        }else{
            $this->Menu->delete($id);
            $this->Session->setFlash('<div class="success msg">Successfully Deleted</div>');
        }
        $this->redirect(array('action' => 'index'));
    }
}
