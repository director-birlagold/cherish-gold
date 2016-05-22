<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BrokeragestatusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Brokerage', 'Brokeragestatus', 'Order');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function admin_index() {
        $this->checkadmin();
        $this->Brokeragestatus->recursive = 0;
        $this->Paginator->settings = array(
//            'brokerage' => array('Brokeragestatus.brokerage_status' => 'asc')
        );
        $this->set('brokeragestatus', $this->Paginator->paginate('Brokeragestatus'));
    }
    
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Brokeragestatus->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Created</div>');
            $this->redirect(array('action' => 'index'));
        }
    }
    
    public function admin_edit($id = NULL) {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Brokeragestatus->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Successfully Updated</div>');
            $this->redirect(array('action' => 'index'));
        }else{
            $brokeragestatus = $this->Brokeragestatus->findByBrokerageStsId($id);
            if(empty($brokeragestatus))
                $this->redirect(array('action' => 'index'));
            $this->request->data = $brokeragestatus;
        }
    }
    
    public function admin_delete($id = NULL) {
        $this->checkadmin();
        $brokeragestatus = $this->Brokeragestatus->read(null, $id);
        if(empty($brokeragestatus))
            $this->redirect(array('action' => 'index'));

        $check_brokerages = $this->Order->find('count', array('conditions' => array('Order.brokerage_status_id' => $id)));
        if($check_brokerages > 0){
            $this->Session->setFlash('<div class="error msg">This brokerage status is used in brokerage. Failed to delete</div>');
        }else{
            $this->Brokeragestatus->delete($id);
            $this->Session->setFlash('<div class="success msg">Successfully Deleted</div>');
        }
        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_brokeragestatus_export() {
        $filename = "brokerage_status.csv";
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $results = $this->Brokeragestatus->find('all');
        $header_row = array("S.No", "Brokerage Status");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $result) {
            $row = array(
                $i,
                $result['Brokeragestatus']['brokerage_status'],
//                $result['Adminstatus']['is_active'] == '1' ? 'Active' : 'In-active',
            );
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }
}
