<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MenusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Menu', 'Category');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function admin_index() {
        $this->checkadmin();
        $this->Menu->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('Menu.order' => 'asc')
        );
        $this->set('menus', $this->Paginator->paginate('Menu'));
    }
    
//    public function admin_add() {
//        $this->checkadmin();
//        if ($this->request->is('post')) {
//            $this->Menu->save($this->request->data);
//            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
//            $this->redirect(array('action' => 'index'));
//        }
//    }
    
    public function admin_edit($id = NULL) {
        $this->checkadmin();
        $menus = $this->Menu->read(null, $id);
        $categories = $this->Category->find('all', array('conditions' => array('Category.status' => 'Active')));
        if(empty($menus))
            $this->redirect(array('action' => 'index'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $ids = !empty($this->data['Menu']['category_ids']) ? implode(',', $this->data['Menu']['category_ids']) : '';
            $this->request->data['Menu']['category_ids'] = $ids;
            $this->Menu->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Updated</div>');
            $this->redirect(array('action' => 'index'));
        }else{
            $this->request->data = $menus;
        }
        $this->set(compact('categories'));
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
    
    public function admin_menu_export() {
        $filename = "menus.csv";
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $results = $this->Menu->find('all');
        $header_row = array("S.No", "Menu", "Is Active");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $result) {
            $row = array(
                $i,
                $result['Menu']['menu_name'],
                $result['Menu']['is_active'] == '1' ? 'Active' : 'In-active',
            );
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }
}
