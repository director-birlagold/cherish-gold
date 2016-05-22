<?php

App::uses('AppController', 'Controller');

/**
 * Category Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class ShippingratesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Shippingrate', 'States');
    public $layout = 'admin';

    /* List  Shippingrates */

    public function admin_index() {

        $this->layout = 'admin';
        $this->checkadmin();
        $this->Shippingrate->recursive = 0;
        /* search redirect */
        if (isset($this->request->data['searchfilter'])) {
            $search = array();



            if ($this->request->data['searchterm'] != '') {
                $search[] = 'searchterm=' . $this->request->data['searchterm'];
            }

            if ($this->request->data['searchpincode'] != '') {
                $search[] = 'searchpincode=' . $this->request->data['searchpincode'];
            }
            if ($this->request->data['searchdeliveryday'] != '') {
                $search[] = 'searchdeliveryday=' . $this->request->data['searchdeliveryday'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }/* query for search */
        if ($this->request->query('search') != '') {
            $conditions['status !='] = 'Trash';

            if ($this->request->query('searchterm') != '') {
               // $conditions['city'] = $this->request->query('searchterm');
			   $conditions['city LIKE'] = '%'.$this->request->query('searchterm').'%';
            }
            if ($this->request->query('searchpincode') != '') {
                $conditions['pincode LIKE'] = '%' . $this->request->query('searchpincode') . '%';
            }
            if ($this->request->query('searchdeliveryday') != '') {
                $conditions['delivery_date'] = $this->request->query('searchdeliveryday');
            }
        } else {
            $conditions = array('status !=' => 'Trash');
        }


        $this->paginate = array('conditions' => $conditions, 'order' => 'sid DESC');
        $this->set('shippingrates', $this->Paginator->paginate('Shippingrate'));
    }

    /* Add   Shippingrates */

    public function admin_add() {
        $this->checkadmin();
        $state = $this->States->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('state', $state);

        if ($this->request->is('post')) {

            $check = $this->Shippingrate->find('first', array('conditions' => array('pincode' => $this->request->data['Shippingrate']['pincode'])));
            if (empty($check)) {
                $this->request->data['Shippingrate']['created_date'] = date("Y-m-d H:i:s");
                $this->request->data['Shippingrate']['status'] = 'Active';
                $this->Shippingrate->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">shipping rates added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('This Pincode  already exists.') . "</div>");
            }
        }
    }

    /* Edit   Shippingrates */

    public function admin_edit($id) {
        $this->checkadmin();
        $state = $this->States->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('state', $state);

        if (!$this->Shippingrate->exists($id)) {
            throw new NotFoundException(__('Invalid Question'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $check = $this->Shippingrate->find('first', array('conditions' => array('pincode' => $this->request->data['Shippingrate']['pincode'], 'sid !=' => $id)));
            if (empty($check)) {
                $this->request->data['Shippingrate']['sid'] = $id;
                $this->Shippingrate->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Shipping Rate updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('This Pincode  already exists.') . "</div>");
            }
        }
        $shippingrate = $this->Shippingrate->find('first', array('conditions' => array('sid' => $id)));
        $this->set('shippingrate', $shippingrate);
    }

    /* Change Status   Shippingrates */

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Shippingrate']['sid'] = $id;
        $this->request->data['Shippingrate']['status'] = $status;
        $this->Shippingrate->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

    /* Delete   Shippingrates */

    public function admin_delete() {
        $this->checkadmin();
        /* Single Shippingrates Delete */
        if (!empty($this->params['pass']['0'])) {
            $this->Shippingrate->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Shippingrate->exists()) {
                throw new NotFoundException(__('Invalid Question'));
            }
            $this->Shippingrate->delete(array('sid' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Shipping Details has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            /* Multiple Shippingrates Delete */
            $this->Shippingrate->deleteAll(array('sid IN (' . implode(",", $this->request->data['action']) . ')'), false, false);
            $this->Session->setFlash("<div class='success msg'>" . __('Shipping Details has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    /* Export   Shippingrates */

    public function admin_shippingrates_export() {

        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "shippingrates.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $results = $this->Shippingrate->find('all');
        $header_row = array("S.No", "State", "City", "Pincode", "DeliveryDays", "TaxCode", "TaxRate(%)");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {

            $row = array(
                $i,
                $results['Shippingrate']['state'],
                $results['Shippingrate']['city'],
                $results['Shippingrate']['pincode'],
                $results['Shippingrate']['delivery_date'],
                $results['Shippingrate']['taxcode'],
                $results['Shippingrate']['taxrate'],
            );

            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

    public function admin_shippingrates_import() {
        $this->checkadmin();
        if (isset($this->request->data['submit'])) {
            if (!empty($this->request->params['form']['importfile']['name'])) {
                $filename = $this->request->params['form']['importfile'];
                $filetype = $this->Image->getFileExtension($this->request->params['form']['importfile']['name']);
                if ($filetype == 'csv') {
                    $tmp_name = $filename["tmp_name"];
                    App::import('Vendor', 'csvimport/parsecsv');
                    $data = new parseCSV();
                    $data->auto($tmp_name);
                    $datas = $data->data;
                } elseif ($filetype == 'xls') {
                    $tmp_name = $filename["tmp_name"];
                    App::import('Vendor', 'php-excel-reader/excel_reader2');
                    $data = new Spreadsheet_Excel_Reader($tmp_name, true);
                    $datas = $data->dumpdata(true, true);
                } else {
                    $this->Session->setFlash("<div class='success msg'>" . __('Please upload CSV or XLS file.') . "</div>", '');
                    $this->redirect(array('action' => 'shippingrates_import'));
                }
                foreach ($datas as $datas) {

                    if (!empty($datas['State']) && !empty($datas['City']) && !empty($datas['Pincode'])) {
                        $check = $this->Shippingrate->find('first', array('conditions' => array('pincode' => $datas['Pincode'])));
                        if (!empty($check)) {
                            $this->request->data['Shippingrate']['sid'] = $check['Shippingrate']['sid'];
                        }
                        $this->request->data['Shippingrate']['state'] = $datas['State'];
                        $this->request->data['Shippingrate']['city'] = $datas['City'];
                        $this->request->data['Shippingrate']['pincode'] = $datas['Pincode'];
                        $this->request->data['Shippingrate']['delivery_date'] = !empty($datas['DeliveryDays']) ? $datas['DeliveryDays'] : '0';
                        ;
                        $this->request->data['Shippingrate']['taxcode'] = !empty($datas['TaxCode']) ? $datas['TaxCode'] : '';
                        $this->request->data['Shippingrate']['taxrate'] = !empty($datas['TaxRate(%)']) ? $datas['TaxRate(%)'] : '0';
                        $this->request->data['Shippingrate']['created_date'] = date("Y-m-d H:i:s");
                        $this->request->data['Shippingrate']['status'] = 'Active';
                        $this->Shippingrate->saveAll($this->request->data);
                    }
                }
                $this->Session->setFlash("<div class='success msg'>" . __('Shipping Details has been inserted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index', 'controller' => 'shippingrates'));
            }
        }
    }

    public function shipredirect() {
        //echo 'asdfdsaf';exit;
        //$this->Session->setFlash("<div class='success msg'>" . __('Shipping Details has been deleted successfully') . "</div>", '');
        $this->redirect(array('action' => 'index', 'controller' => 'shippingrates'));
    }

}
