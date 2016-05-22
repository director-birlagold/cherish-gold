<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AdminstatusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Order', 'Adminstatus');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function admin_index() {
        $this->checkadmin();
        $this->Adminstatus->recursive = 0;
        $this->Paginator->settings = array(
//            'order' => array('Adminstatus.admin_status' => 'asc')
        );
        $this->set('adminstatus', $this->Paginator->paginate('Adminstatus'));
    }
    
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Adminstatus->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
            $this->redirect(array('action' => 'index'));
        }
    }
    
    public function admin_edit($id = NULL) {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Adminstatus->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Updated</div>');
            $this->redirect(array('action' => 'index'));
        }else{
            $adminstatus = $this->Adminstatus->findByAdminStsId($id);
            if(empty($adminstatus))
                $this->redirect(array('action' => 'index'));
            $this->request->data = $adminstatus;
        }
    }
    
    public function admin_delete($id = NULL) {
        $this->checkadmin();
        $adminstatus = $this->Adminstatus->read(null, $id);
        if(empty($adminstatus))
            $this->redirect(array('action' => 'index'));

        $check_orders = $this->Order->find('count', array('conditions' => array('Order.admin_status_id' => $id)));
        if($check_orders > 0){
            $this->Session->setFlash('<div class="error msg">This order status is used in order. Failed to delete</div>');
        }else{
            $this->Adminstatus->delete($id);
            $this->Session->setFlash('<div class="success msg">Successfully Deleted</div>');
        }
        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_adminstatus_export() {
        $filename = "admin_status.csv";
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $results = $this->Adminstatus->find('all');
        $header_row = array("S.No", "Admin Status");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $result) {
            $row = array(
                $i,
                $result['Adminstatus']['admin_status'],
//                $result['Adminstatus']['is_active'] == '1' ? 'Active' : 'In-active',
            );
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }
}
