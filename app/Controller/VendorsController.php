<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class VendorsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Vendor', 'Status', 'Type', 'State', 'Accounttype', 'Vendorclient', 'Vendorplant', 'Vendorcontact', 
        'Checklist', 'Product', 'User', 'Order', 'Shoppingcart');
    public $layout = 'admin';

    /* List the vendors */

    public function admin_index() {
        $this->checkadmin();
        $this->Vendor->recursive = 0;

        /* search redirect */
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }
            if ($this->request->data['searchvendorname'] != '') {
                $search[] = 'searchvendorname=' . $this->request->data['searchvendorname'];
            }
            if ($this->request->data['vendorcode'] != '') {
                $search[] = 'vendorcode=' . $this->request->data['vendorcode'];
            }
            if ($this->request->data['searchvendorstatus'] != '') {
                $search[] = 'searchvendorstatus=' . $this->request->data['searchvendorstatus'];
            }
            if ($this->request->data['searchvendortype'] != '') {
                $search[] = 'searchvendortype=' . $this->request->data['searchvendortype'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        /* query for search */
        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('status !=' => 'Trash');
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array('created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\'');
            }if ($this->request->query('cdate') != '') {
                $search['created_date'] = $this->request->query('cadte');
            }if ($this->request->query('edate') != '') {
                $search['created_date'] = $this->request->query('edate');
            }
            if ($this->request->query('searchvendorname') != '') {
                $vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $this->request->query['searchvendorname'])));
                $this->set('vendor', $vendor);

                $search['vendor_id'] = $vendor['Vendor']['vendor_id'];
            }

            if ($this->request->query('vendorcode') != '') {
                $search['vendor_code'] = $this->request->query['vendorcode'];
            }

            if ($this->request->query('searchvendorstatus') != '') {

                $status = $this->Status->find('first', array('conditions' => array('vendor_status_id' => $this->request->query['searchvendorstatus'])));
                $this->set('status', $status);

                $search['vendor_status'] = $status['Status']['vendor_status_id'];
            }

            if ($this->request->query('searchvendortype') != '') {

                $type = $this->Type->find('first', array('conditions' => array('vendor_type_id' => $this->request->query['searchvendortype'])));
                $this->set('type', $type);

                $search['vendor_type'] = $type['Type']['vendor_type_id'];
            }

            $this->paginate = array('conditions' => $search, 'order' => 'vendor_id DESC');
            $this->set('vendor', $this->Paginator->paginate('Vendor'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'vendor_id DESC');
            $this->set('vendor', $this->Paginator->paginate('Vendor'));
        }

        /* get the status */
        $status = $this->Status->find('all');
        $this->set('status', $status);

        /* get the status of type */
        $type = $this->Type->find('all');
        $this->set('type', $type);

        /* get the status of vendor */
        $vendorstatus = $this->Vendor->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('vendorstatus', $vendorstatus);
    }				
	public function admin_profile() 
	{        
		$this->checkadmin();        
		$id = $this->Session->read('Adminuser.admin_id');		
		//echo $id;		//exit;        
		/*if (!$this->Adminuser->exists($id)) {            throw new NotFoundException(__('Invalid user'));        }*/        		
		$adminuser = $this->Vendor->find('first', array('conditions' => array('user_id' => $id)));        
		$this->set('adminuser', $adminuser);                
		$admin_id = $id;		
		//echo "here..".$admin_id;		//exit;				        
		if ($this->request->is('post')) {					
			//print_r($_POST);			
			//echo $_POST['some'];			//exit;		            
			//$check = $this->Vendor->find('first', array('conditions' => array( 'admin_id !=' => $this->params['pass']['0'], 'status !='=>'Trash')));            
			if (!empty($_POST['some'])) {							
				//print_r($this->request->data);				
				//exit;                
				$this->request->data['Vendor']['vendor_id'] = $_POST['some'];								                
				$this->request->data['Vendor']['Company_name'] = $this->request->data['Vendor']['Company_name'];				
				$this->request->data['Vendor']['Reg_mobile'] = $this->request->data['Vendor']['Reg_mobile'];							                
				$this->Vendor->save($this->request->data);				
				//exit;				                
				$this->Session->setFlash('<div class="success msg">Information save successfully.</div>', 'default');                
				$this->redirect(array('action' => 'profile'));            
			} else {               
			$this->Session->setFlash('<div class="error msg">User not found.</div>', '');            
			}        
		}						    
	}

    /* Add vendor */

    public function admin_add() {
        $this->checkadmin();
        $status = $this->Status->find('all');
        $this->set('statues', $status);
        $type = $this->Type->find('all');
        $this->set('type', $type);
        $state = $this->State->find('all');
        $this->set('state', $state);
        $accounttype = $this->Accounttype->find('all');
        $this->set('accounttype', $accounttype);

        /* Save the vendor */
        if ($this->request->is('post')) {
            $check = $this->Vendor->find('first', array('conditions' => array('Company_name' => $this->request->data['Vendor']['Company_name'], 'status !=' => 'Trash')));
            $check_user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['Vendorcontact'][0]['email'], 'status !=' => 'Trash')));
            if (empty($check) && empty($check_user)) {
                $user = array();
                //$password = $this->str_rand();
                $password = 'shagunn123';
                $user['User']['email'] = $this->request->data['Vendorcontact'][0]['email'];
                $user['User']['password'] = sha1($password);
                $user['User']['user_type'] = 2;
                $user['User']['title'] = 'Mfg';
                $user['User']['name'] = $this->request->data['Vendor']['Company_name'];
                $user['User']['phone_no'] = $this->request->data['Vendorcontact'][0]['phone'];
                $user['User']['mobile_no'] = $this->request->data['Vendorcontact'][0]['mobile'];
                $user['User']['pan_no'] = $this->request->data['Vendor']['panno'];
                $user['User']['address'] = $this->request->data['Vendor']['reg_address'].','.$this->request->data['Vendor']['reg_address1'];
                $user['User']['city'] = $this->request->data['Vendor']['reg_city'];
                $user['User']['state'] = $this->request->data['Vendor']['reg_state'];
                $user['User']['pincode'] = $this->request->data['Vendor']['reg_pincode'];
                $user['User']['status'] = "Active";

                $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 5)));
                $activateemail['toemail'] = $user['User']['email'];
                $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);
                $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
                $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
                $this->User->save($user);

                if (!empty($this->request->data['Vendor']['Product_category'])) {
                    $this->request->data['Vendor']['Product_category'] = implode(",", $this->request->data['Vendor']['Product_category']);
                }
                $this->request->data['Vendor']['status'] = 'Active';
                $this->request->data['Vendor']['created_date'] = date('Y-m-d H:i:s');
                $this->request->data['Vendor']['user_id'] = $this->User->getLastInsertID();

                $this->Vendor->save($this->request->data);
                $vendor_id = $this->Vendor->getLastInsertID();
                $vendor_id_code = '000' . $vendor_id;
                $vendorcode = sprintf("SGN-VC-%04d", $vendor_id_code);
                //print_r($vendorcode);exit;
                $this->request->data['Vendor']['vendor_id'] = $vendor_id;
                $this->request->data['Vendor']['vendor_code'] = $vendorcode;
                $this->Vendor->save($this->request->data);

                foreach ($this->request->data['Vendorcontact'] as $vendor_contact) {
                    if ($vendor_contact['name'] != '') {
                        $vendor_contact['vendor_id'] = $vendor_id;
                        $this->Vendorcontact->saveAll($vendor_contact);
                    }
                }

                foreach ($this->request->data['Vendorplant'] as $vendor_plant) {
                    if ($vendor_plant['manufacture_name'] != '' || $vendor_plant['year'] != '') {
                        $vendor_plant['vendor_id'] = $vendor_id;
                        $this->Vendorplant->saveAll($vendor_plant);
                    }
                }

                foreach ($this->request->data['Vendorclient'] as $vendor_client) {
                    if ($vendor_client['client'] != '' || $vendor_client['turnover'] != '') {
                        $vendor_client['vendor_id'] = $vendor_id;
                        $this->Vendorclient->saveAll($vendor_client);
                    }
                }
                $this->request->data['Checklist']['vendor_id'] = $vendor_id;
                $this->Checklist->save($this->request->data);


                $this->Session->setFlash('<div class="success msg">Vendor has been added  successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $flash_message = !empty($check) ? "Company name  already exits." : "Email Id '{$check_user['User']['email']}' already exits.";
                $this->Session->setFlash("<div class='error msg'>{$flash_message}</div>", '');
            }
        }
    }

    /* Edit Vendor */

    public function admin_edit($id) {
        $this->checkadmin();
        $status = $this->Status->find('all');
        $this->set('statues', $status);
        $type = $this->Type->find('all');
        $this->set('type', $type);
        $state = $this->State->find('all');
        $this->set('state', $state);
        $accounttype = $this->Accounttype->find('all');
        $this->set('accounttype', $accounttype);
        if (!$this->Vendor->exists($id)) {
            throw new NotFoundException(__('Invalid Vendor'));
        }
        $vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $this->params['pass']['0'])));
        $this->set('vendor', $vendor);
        $vendorcontact = $this->Vendorcontact->find('all', array('conditions' => array('vendor_id' => $this->params['pass']['0'])));
        $this->set('vendorcontact', $vendorcontact);
        $vendorplant = $this->Vendorplant->find('all', array('conditions' => array('vendor_id' => $this->params['pass']['0'])));
        $this->set('vendorplant', $vendorplant);
        $vendorclient = $this->Vendorclient->find('all', array('conditions' => array('vendor_id' => $this->params['pass']['0'])));
        $this->set('vendorclient', $vendorclient);
        $checklist = $this->Checklist->find('first', array('conditions' => array('vendor_id' => $this->params['pass']['0'])));
        $this->set('checklist', $checklist);

        $vendor_id = $vendor['Vendor']['vendor_id'];

        /* update the vendor details */
        if ($this->request->is('post')) {
            $check = $this->Vendor->find('first', array('conditions' => array('Company_name' => $this->request->data['Vendor']['Company_name'], 'status !=' => 'Trash', 'vendor_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Vendor']['vendor_id'] = $vendor['Vendor']['vendor_id'];
                if (!empty($this->request->data['Vendor']['Product_category'])) {
                    $this->request->data['Vendor']['Product_category'] = implode(",", $this->request->data['Vendor']['Product_category']);
                }

                $this->Vendor->save($this->request->data);
                $this->Vendorcontact->deleteAll(array('vendor_id' => $vendor['Vendor']['vendor_id']));
                foreach ($this->request->data['Vendorcontact'] as $vendor_contact) {
                    if ($vendor_contact['name'] != '') {
                        $vendor_contact['vendor_id'] = $vendor_id;
                        $this->Vendorcontact->saveAll($vendor_contact);
                    }
                }

                $this->Vendorplant->deleteAll(array('vendor_id' => $vendor['Vendor']['vendor_id']));
                foreach ($this->request->data['Vendorplant'] as $vendor_plant) {
                    if ($vendor_plant['manufacture_name'] != '' || $vendor_plant['year'] != '') {
                        $vendor_plant['vendor_id'] = $vendor_id;
                        $this->Vendorplant->saveAll($vendor_plant);
                    }
                }

                $this->Vendorclient->deleteAll(array('vendor_id' => $vendor['Vendor']['vendor_id']));
                foreach ($this->request->data['Vendorclient'] as $vendor_client) {
                    if ($vendor_client['client'] != '' || $vendor_client['turnover'] != '') {
                        $vendor_client['vendor_id'] = $vendor_id;
                        $this->Vendorclient->saveAll($vendor_client);
                    }
                }


                if (!empty($checklist)) {
                    $this->request->data['Checklist']['checklist_id'] = $checklist['Checklist']['checklist_id'];
                }
                $this->request->data['Checklist']['vendor_id'] = $vendor_id;
                $this->Checklist->save($this->request->data);


                $this->Session->setFlash('<div class="success msg">Details save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Company name  already exits.</div>', '');
            }
        }
    }

    /* Delete Vendor */

    public function admin_delete() {
        $this->checkadmin();

        /* Single vendor delete */
        if (!empty($this->params['pass']['0'])) {
            $this->Vendor->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Vendor->exists()) {
                throw new NotFoundException(__('Invalid Vendor'));
            }

            $this->request->data['Vendor']['vendor_id'] = $this->params['pass']['0'];
            $this->request->data['Vendor']['status'] = 'Trash';
            $this->Vendor->save($this->request->data);
            $product = $this->Product->find('all', array('conditions' => array('vendor_id' => $this->params['pass']['0'], 'status !=' => 'Trash')));

            foreach ($product as $product) {
                $this->request->data['Product']['product_id'] = $product['Product']['product_id'];
                $this->request->data['Product']['vendor_id'] = $this->params['pass']['0'];
                $this->request->data['Product']['status'] = 'Trash';

                $this->Product->saveAll($this->request->data);
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Vendor has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            /* Multi vendor delete */
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $vendordelete) {
                    if ($vendordelete > 0) {
                        $this->request->data['Vendor']['vendor_id'] = $vendordelete;
                        $this->request->data['Vendor']['status'] = 'Trash';
                        $this->Vendor->saveAll($this->request->data);

                        $product = $this->Product->find('all', array('conditions' => array('vendor_id' => $vendordelete, 'status !=' => 'Trash')));

                        foreach ($product as $product) {
                            $this->request->data['Product']['product_id'] = $product['Product']['product_id'];
                            $this->request->data['Product']['vendor_id'] = $vendordelete;
                            $this->request->data['Product']['status'] = 'Trash';
                            $this->Product->saveAll($this->request->data);
                        }
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Vendor has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Vendor']['vendor_id'] = $id;
        $this->request->data['Vendor']['status'] = $status;
        $this->Vendor->save($this->request->data);

        $product = $this->Product->find('all', array('conditions' => array('vendor_id' => $id, 'status !=' => 'Trash')));

        foreach ($product as $product) {
            $this->request->data['Product']['product_id'] = $product['Product']['product_id'];
            $this->request->data['Product']['vendor_id'] = $this->params['pass']['0'];
            $this->request->data['Product']['status'] = $status;

            $this->Product->saveAll($this->request->data);
        }

        $this->Session->setFlash('<div class="success msg">' . __('Vendor Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_vendor_export() {
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large	
        //create a file
        $filename = "vendor_data.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $results = $this->Vendor->find('all', array('conditions' => array('status !=' => 'Trash')));
        $header_row = array("S.No", "Company Name", "Vendor Code", "Vendor Status", "Preferred Billing Address", "Vendor Type", "ROA.Address1", "ROA.Address2", "ROA.City", "ROA.State", "ROA.Pincode", "ROA.Phone(1)", "ROA.Phone(2)", "ROA.mobile", "HOD.Address1", "HOD.Address2", "HOD.City", "HOD.State", "HOD.Pincode", "HOD.Phone(1)", "HOD.Phone(2)", "HOD.mobile", "WFA.Address1", "WFA.Address2", "WFA.City", "WFA.State", "WFA.Pincode", "WFA.Phone(1)", "WFA.Phone(2)", "WFA.mobile", "Contact Name 1", "Contact Designation 1", "Contact Phone 1", "Contact Mobile 1", "Contact Email 1", "Contact Name 2", "Contact Designation 2", "Contact Phone 2", "Contact Mobile 2", "Contact Email 2", "Contact Name 3", "Contact Designation 3", "Contact Phone 3", "Contact Mobile 3", "Contact Email 3", "Contact Name 4", "Contact Designation 4", "Contact Phone 4", "Contact Mobile 4", "Contact Email 4", "Contact Name 5", "Contact Designation 5", "Contact Phone 5", "Contact Mobile 5", "Contact Email 5", "Contact Name 6", "Contact Designation 6", "Contact Phone 6", "Contact Mobile 6", "Contact Email 6", "Bank Name", "Account No", "Account Type", "MICR CODE", "IFSC CODE", "Pincode", "State Sales Tax (SST)", "Central Sales Tax(CST)", ">Tax Index No.(TIN) (for VAT)", "Work Contract Tax (WCT)", "Goods &Services Tax (GST)", "Vaue Added Tax (VAT)", "PAN NO", "Tax Relaxation", "Total Experience", "Turnover for last 1 years", "Turnover for last 2 years", "Paid Up Capital", "Category", "Certification/Standardization", "Manufacture Name 1", "Year Of Mfg 1", "Manufacture Name 2", "Year Of Mfg 2", "Manufacture Name 3", "Year Of Mfg 3", "Manufacture Name 4", "Year Of Mfg 4", "Manufacture Name 5", "Year Of Mfg 5", "Client 1", "TurnOver 1", "Client 2", "TurnOver 2", "Client 3", "TurnOver 3");

        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {
            $status = $this->Status->find('first', array('conditions' => array('vendor_status_id' => $results['Vendor']['vendor_status'])));
            $type = $this->Type->find('first', array('conditions' => array('vendor_type_id' => $results['Vendor']['vendor_type'])));
            $vendor_status = $status['Status']['vendor_status'];
            $vendor_type = $type['Type']['vendor_type'];

            $contacts = $this->Vendorcontact->find('all', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id']), array('limit' => '6')));
            $contacts_count = $this->Vendorcontact->find('count', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id'])));

            $contacts_opt = array();
            foreach ($contacts as $contacts) {
                $contacts_opt[] = $contacts['Vendorcontact']['name'];
                $contacts_opt[] = $contacts['Vendorcontact']['designation'];
                $contacts_opt[] = $contacts['Vendorcontact']['phone'];
                $contacts_opt[] = $contacts['Vendorcontact']['mobile'];
                $contacts_opt[] = $contacts['Vendorcontact']['email'];
                //$contacts_array[]=implode(",",$contacts_opt);
            }

            if ($contacts_count < 6) {
                for ($s = $contacts_count + 1; $s <= 6; $s++) {
                    $contacts_opt[] = ' ';
                    $contacts_opt[] = ' ';
                    $contacts_opt[] = ' ';
                    $contacts_opt[] = ' ';
                    $contacts_opt[] = ' ';
                    //$contacts_array[]=implode(",",$contacts_opt);
                }
            }


            $plants = $this->Vendorplant->find('all', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id']), array('limit' => '5')));
            $plants_count = $this->Vendorplant->find('count', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id']), array('limit' => '5')));
            $plants_opt = array();
            foreach ($plants as $plants) {
                $plants_opt[] = $plants['Vendorplant']['manufacture_name'];
                $plants_opt[] = $plants['Vendorplant']['year'];
            }

            if ($plants_count < 5) {
                for ($j = $plants_count + 1; $j <= 5; $j++) {
                    $plants_opt[] = ' ';
                    $plants_opt[] = ' ';
                }
            }

            $clients = $this->Vendorclient->find('all', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id']), array('limit' => '3')));
            $clients_count = $this->Vendorclient->find('count', array('conditions' => array('vendor_id' => $results['Vendor']['vendor_id']), array('limit' => '3')));
            $clients_opt = array();
            foreach ($clients as $clients) {
                $clients_opt[] = $clients['Vendorclient']['client'];
                $clients_opt[] = $clients['Vendorclient']['turnover'];
            }
            if ($clients_count < 3) {
                for ($k = $clients_count + 1; $k <= 3; $k++) {
                    $clients_opt[] = ' ';
                    $clients_opt[] = ' ';
                }
            }

            $row = array(
                $i,
                $results['Vendor']['Company_name'],
                $results['Vendor']['vendor_code'],
                $vendor_status,
                $results['Vendor']['preferred_billing'],
                $vendor_type,
                $results['Vendor']['reg_address'], $results['Vendor']['reg_address1'], $results['Vendor']['reg_city'], $results['Vendor']['reg_state'], $results['Vendor']['reg_pincode'],
                $results['Vendor']['reg_phone'], $results['Vendor']['reg_phone1'], $results['Vendor']['reg_mobile'],
                $results['Vendor']['ho_address'], $results['Vendor']['ho_address1'], $results['Vendor']['ho_city'], $results['Vendor']['ho_state'], $results['Vendor']['ho_pincode'],
                $results['Vendor']['ho_phone'], $results['Vendor']['ho_phone1'], $results['Vendor']['ho_mobile'],
                $results['Vendor']['work_address'], $results['Vendor']['work_address1'], $results['Vendor']['work_city'], $results['Vendor']['work_state'], $results['Vendor']['work_pincode'],
                $results['Vendor']['work_phone'], $results['Vendor']['work_phone1'], $results['Vendor']['work_mobile']);
            $row = array_merge($row, $contacts_opt);
            $row = array_merge($row, array($results['Vendor']['bank_name'], $results['Vendor']['account_no'], $results['Vendor']['account_type'], $results['Vendor']['micr_code'], $results['Vendor']['ifsc_code'],
                $results['Vendor']['bank_pincode'],
                $results['Vendor']['state_sales_tax'], $results['Vendor']['central_sales_tax'], $results['Vendor']['tax_index_no'], $results['Vendor']['work_contact_tax'], $results['Vendor']['good_service_tax'],
                $results['Vendor']['value_add_tax'], $results['Vendor']['panno'], $results['Vendor']['taxrelexation'],
                $results['Vendor']['total_experience'], $results['Vendor']['turnover_first_year'], $results['Vendor']['turnover_second_year'], $results['Vendor']['capital_amount'],
                $results['Vendor']['Product_category'], $results['Vendor']['product_certificate']));
            $row = array_merge($row, $plants_opt);
            $row = array_merge($row, $clients_opt);


            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

    public function user_orders() {
        $this->usercheck();
        if($this->Session->read('User.user_type') == 2){
            $this->layout = 'webpage';
            $vendor = $this->Vendor->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
            $product_ids = $this->Product->find('list', array('conditions' => array('vendor_id' => $vendor['Vendor']['vendor_id'])));
            $carts = $this->Shoppingcart->find('all', array(
                'conditions' => array('product_id' => $product_ids), 
                'fields' => array('DISTINCT Shoppingcart.order_id')));
            $order_ids = array();
            foreach ($carts as $key => $cart) {
                $order_ids[$cart['Shoppingcart']['order_id']] = $cart['Shoppingcart']['order_id'];
            }
            $orders = $this->Order->find('all', array('conditions' => array('order_id' => $order_ids), 'order' => 'order_id DESC'));
            $this->set(compact('orders'));
        }else{
            return $this->redirect('/');
        }
    }
}
