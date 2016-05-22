<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FranchiseesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('User', 'Adminuser', 'State', 'Accounttype', 'Proof', 'Nomination', 'Bankdetail', 'Payment', 'Outlet', 'Franchiseeproof', 'Officeuse', 'Otherdetail', 'Franchiseebrokerage');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {


        $this->layout = 'admin';
        $this->checkadmin();
        $this->User->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }
            if ($this->request->data['searchname'] != '') {
                $search[] = 'searchname=' . $this->request->data['searchname'];
            }
            if ($this->request->data['searchfranchise'] != '') {
                $search[] = 'searchfranchise=' . $this->request->data['searchfranchise'];
            }
            if ($this->request->data['searchemail'] != '') {
                $search[] = 'searchemail=' . $this->request->data['searchemail'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        $search = array();
        $search = array('user_type' => '1', 'status !=' => 'Trash');
        if ($this->request->query('search') != '') {
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array_merge($search,array('created_date BETWEEN \'' . date('Y-m-d', strtotime($this->request->query('cdate'))) . '\' AND \'' . date('Y-m-d', strtotime($this->request->query('edate'))) . '\''));
//                $search = array('created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\'');
            } elseif ($this->request->query('cdate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            } elseif ($this->request->query('edate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            }
            if ($this->request->query('searchname') != '') {

                $search = array_merge($search, array('OR' => array('CONCAT(User.first_name, \' \', User.last_name) LIKE ' => '%' . $this->request->query('searchname') . '%', 'CONCAT(User.first_name, \'\', User.last_name) LIKE ' => '%' . $_REQUEST['searchname'] . '%', 'User.first_name LIKE ' => '%' . $_REQUEST['searchname'] . '%', 'User.last_name LIKE ' => '%' . $_REQUEST['searchname'] . '%')));
            }
            if ($this->request->query('searchfranchise')) {
                $search['franchisee_code LIKE '] = $this->request->query('searchfranchise');
            }

            if (!empty($_REQUEST['searchemail'])) {

                $search['email LIKE'] = '%' . $this->request->query('searchemail') . '%';
            }
            $this->paginate = array('conditions' => $search, 'order' => 'User.user_id DESC');
            $this->set('user', $this->paginate('User'));
        } else {
            $this->paginate = array('conditions' => $search, 'order' => 'User.user_id DESC');
            $this->set('user', $this->Paginator->paginate('User'));
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->checkadmin();
        $state = $this->State->find('all');
        $this->set('state', $state);
        $accounttype = $this->Accounttype->find('all');
        $this->set('accounttype', $accounttype);

        $proof = $this->Proof->find('all');
        $this->set('proof', $proof);

        if ($this->request->is('post')) {

            $check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'], 'status !=' => 'Trash')));
            if (empty($check)) {
                $errors = array();
                $i = 0;
                $error1 = 0;
                $error2 = 0;
                $pincode = $this->request->data['User']['pincode'];
                if ($pincode) {
                    $pins = explode(",", $pincode);
                    foreach ($pins as $pin) {
                        if ($pin) {
                            if (is_numeric($pin)) {
                                $len = strlen($pin);
                                if ($len == 6) {
                                    $errors['len'][$i] = 0;
                                } else {
                                    $errors['len'][$i] = 1;
                                }
                                $errors['num'][$i] = 0;
                            } else {
                                $errors['num'][$i] = 1;
                                $errors['len'][$i] = 1;
                            }
                        }
                        $i++;
                    }
                    if (in_array(1, $errors['num'])) {
                        $error1 = 1;
                    }
                    if (in_array(1, $errors['len'])) {
                        $error2 = 1;
                    }
                    if ($error1 == 0 && $error2 == 0) {
                        
                    } else {
                        $this->Session->setFlash('<div class="error msg">Pincode Not Valid.</div>', '');
                        return true;
                    }
                }
                $this->request->data['User']['status'] = 'Active';
                $this->request->data['User']['user_type'] = 1;
                $this->request->data['User']['created_date'] = date('Y-m-d H:i:s');

                $this->User->save($this->request->data);

                $user_id = $this->User->getLastInsertID();
                $franchisee_code = '000' . $user_id;
                $franchisee_code = sprintf("SGN-FC-%04d", $franchisee_code);
                $this->request->data['User']['user_id'] = $user_id;

                $password = $this->str_rand();
                $this->request->data['User']['password'] = sha1($password);
                $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 5)));
                $activateemail['toemail'] = $this->request->data['User']['email'];
                $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);
                $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
                //$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['User']['email'], $activateemail['Emailcontent']['subject'], $message);
                $this->request->data['User']['franchisee_code'] = $franchisee_code;
                $this->User->save($this->request->data);

                $this->request->data['Nomination']['user_id'] = $user_id;
                $this->Nomination->saveAll($this->request->data);

                $this->request->data['Bankdetail']['user_id'] = $user_id;
                $this->Bankdetail->saveAll($this->request->data);

                foreach ($this->request->data['Payment'] as $payment) {

                    $payment['user_id'] = $user_id;
                    $this->Payment->saveAll($payment);
                }

                $this->request->data['Otherdetail']['user_id'] = $user_id;
                $this->Otherdetail->save($this->request->data);

                $this->request->data['Outlet']['user_id'] = $user_id;
                $this->Outlet->save($this->request->data);

                $this->request->data['Officeuse']['user_id'] = $user_id;
                $this->request->data['Officeuse']['code_generation_date'] = date('Y-m-d H:i:s');
                $this->Officeuse->save($this->request->data);

                $this->request->data['Franchiseeproof']['user_id'] = $user_id;
                if (!empty($this->request->data['Franchiseeproof']['proof'])) {
                    $this->request->data['Franchiseeproof']['proof'] = implode(",", $this->request->data['Franchiseeproof']['proof']);
                }
                $this->Franchiseeproof->save($this->request->data);

                //added by prakash
                $this->request->data['Franchiseebrokerage']['franchisee_brkge_user_id'] = $user_id;
                $this->Franchiseebrokerage->save($this->request->data);


                $this->Session->setFlash('<div class="success msg">Franchisee has been added successfully.Please check your mail</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Email id already exits.</div>', '');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['User']['user_id'] = $id;
        $this->request->data['User']['status'] = $status;
        $this->User->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->User->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid User'));
            }

            $this->request->data['User']['user_id'] = $this->params['pass']['0'];
            $this->request->data['User']['status'] = 'Trash';
            $this->User->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Franchisee has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $franchisee) {
                    if ($franchisee > 0) {
                        $this->request->data['User']['user_id'] = $franchisee;
                        $this->request->data['User']['status'] = 'Trash';
                        $this->User->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Franchisee has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_edit() {
        $this->checkadmin();

		//print_r($_POST['map_address']);
		//exit;

        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'], 'status !=' => 'Trash')));
        $this->set('user', $user);

        $nomination = $this->Nomination->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('nomination', $nomination);

        $bank = $this->Bankdetail->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('bank', $bank);

        $other = $this->Otherdetail->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('other', $other);

        $payment = $this->Payment->find('all', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('payment', $payment);

        $out = $this->Outlet->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('out', $out);

        $use = $this->Officeuse->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('use', $use);

        $franchisee = $this->Franchiseeproof->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->set('franchisee', $franchisee);

        $state = $this->State->find('all');
        $this->set('state', $state);

        $accounttype = $this->Accounttype->find('all');
        $this->set('accounttype', $accounttype);

        $proof = $this->Proof->find('all');
        $this->set('proof', $proof);

        $user_id = $user['User']['user_id'];

        //added by prakash
        $brokerage = $this->Franchiseebrokerage->find('first', array('conditions' => array('franchisee_brkge_user_id' => $this->params['pass']['0'])));
        $this->set('brokerage', $brokerage);
        if ($this->request->is('post')) {
            $check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'], 'status !=' => 'Trash', 'user_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $errors = array();
                $i = 0;
                $error1 = 0;
                $error2 = 0;
                $pincode = $this->request->data['User']['pincode'];
                if ($pincode) {
                    $pins = explode(",", $pincode);
                    foreach ($pins as $pin) {
                        if ($pin) {
                            if (is_numeric($pin)) {
                                $len = strlen($pin);
                                if ($len == 6) {
                                    $errors['len'][$i] = 0;
                                } else {
                                    $errors['len'][$i] = 1;
                                }
                                $errors['num'][$i] = 0;
                            } else {
                                $errors['num'][$i] = 1;
                                $errors['len'][$i] = 1;
                            }
                        }
                        $i++;
                    }
                    if (in_array(1, $errors['num'])) {
                        $error1 = 1;
                    }
                    if (in_array(1, $errors['len'])) {
                        $error2 = 1;
                    }
                    if ($error1 == 0 && $error2 == 0) {
                        
                    } else {
                        $this->Session->setFlash('<div class="error msg">Pincode Not Valid.</div>', '');
                        return true;
                    }
                }
                $this->request->data['User']['user_id'] = $user['User']['user_id'];

                $password = $this->str_rand();
                $this->request->data['User']['password'] = sha1($password);
                $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 5)));
                $activateemail['toemail'] = $this->request->data['User']['email'];
                $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);
                $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
                //$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['User']['email'], $activateemail['Emailcontent']['subject'], $message);
                $this->User->save($this->request->data);

                if (!empty($nomination)) {
                    $this->request->data['Nomination']['nominee_id'] = $nomination['Nomination']['nominee_id'];
                }

                $this->request->data['Nomination']['user_id'] = $user_id;
                $this->Nomination->save($this->request->data);

                if (!empty($bank)) {
                    $this->request->data['Bankdetail']['bank_id'] = $bank['Bankdetail']['bank_id'];
                }
                $this->request->data['Bankdetail']['user_id'] = $user_id;
                $this->Bankdetail->save($this->request->data);

                if (!empty($other)) {
                    $this->request->data['Otherdetail']['other_id'] = $other['Otherdetail']['other_id'];
                }
                $this->request->data['Otherdetail']['user_id'] = $user_id;
                $this->Otherdetail->save($this->request->data);

                if (!empty($out)) {
                    $this->request->data['Outlet']['out_id'] = $out['Outlet']['out_id'];
                }
                $this->request->data['Outlet']['user_id'] = $user_id;
                $this->Outlet->save($this->request->data);

                $this->Payment->deleteAll(array('user_id' => $user['User']['user_id']));
                foreach ($this->request->data['Payment'] as $payment) {
                    $payment['user_id'] = $user_id;
                    $this->Payment->saveAll($payment);
                }
                if (!empty($use)) {
                    $this->request->data['Officeuse']['office_id'] = $use['Officeuse']['office_id'];
                }
                $this->request->data['Officeuse']['user_id'] = $user_id;
                $this->Officeuse->save($this->request->data);

                if (!empty($franchisee)) {
                    $this->request->data['Franchiseeproof']['document_id'] = $franchisee['Franchiseeproof']['document_id'];
                }

                if (!empty($this->request->data['Franchiseeproof']['proof'])) {
                    $this->request->data['Franchiseeproof']['proof'] = implode(",", $this->request->data['Franchiseeproof']['proof']);
                }
                $this->request->data['Franchiseeproof']['user_id'] = $user_id;
                $this->Franchiseeproof->save($this->request->data);

                //addded by prakash
                if (!empty($brokerage)) {
                    $this->request->data['Franchiseebrokerage']['franchisee_brkge_id'] = $brokerage['Franchiseebrokerage']['franchisee_brkge_id'];
                } else {
                    $this->request->data['Franchiseebrokerage']['franchisee_brkge_user_id'] = $user_id;
                }
                $this->Franchiseebrokerage->save($this->request->data);


                $this->Session->setFlash('<div class="success msg">Details save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Email  already exits.</div>', '');
            }
        }
    }

    public function admin_fexport($cdate, $edate) {
        $this->checkadmin();
        $this->layout = '';
        $this->render(false);

        ini_set('max_execution_time', 600);
        //increase max_execution_time to 10 min if data set is very large	
        //create a file
        $filename = "franchisee.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $u_email = $this->request->params['pass'][3];
        $u_name = $this->request->params['pass'][2];
        $u_fra = $this->request->params['pass'][4];
        $search = array();
        $search = array('user_type' => '1', 'status !=' => 'Trash');

        $this->paginate = array('conditions' => $search, 'order' => 'User.user_id DESC');
        $this->set('user', $this->paginate('User'));
        /* if($cdate == 0 && $edate == 0){	
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash')));
          }else if($cdate==''){
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date <='=>$edate)));
          }else if($edate==''){
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date >='=>$cdate)));
          }else{
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date >='=>$cdate,'created_date <='=>$edate)));
          } */
        if (($cdate != 0) && ($edate != 0)) {
            $search = array('created_date BETWEEN \'' . $cdate . '\' AND \'' . $edate . '\'');
        } elseif ($cdate != 0) {
            $search['created_date >='] = $cdate;
        } elseif ($edate != 0) {
            $search['created_date <='] = $edate;
        }
        if ($u_name != '0') {

            $search = array_merge($search, array('OR' => array('CONCAT(User.first_name, \' \', User.last_name) LIKE ' => '%' . $u_name . '%', 'CONCAT(User.first_name, \'\', User.last_name) LIKE ' => '%' . $u_name . '%', 'User.first_name LIKE ' => '%' . $u_name . '%', 'User.last_name LIKE ' => '%' . $u_name . '%')));
        }
        if ($u_fra != '0') {
            $search['franchisee_code LIKE '] = $u_fra;
        }

        if ($u_email != '0') {
            $search['email LIKE'] = '%' . $u_email . '%';
        }

        $results = $this->User->find('all', array('conditions' => $search));
        /* echo "<pre>";
          print_r($search);
          echo "</pre>"; */
        /* 	echo "<pre>";
          print_r($results);
          echo "</pre>"; */
        $header_row = array("S.No", "Email", "Title", "Frist Name", "Last Name", "Phone No", "Address", "Birth day", "Martial Status", "PAN", "Pincode", "City", "State", "Mobile No", "Phone No 2", "Fax No", "Franchisee Code", "Status", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Outlet Name", "Address", "City", "State", "Pincode", "Mobile No", "Phone No1", "Phone No 2", "Fax", "Email", "N.title", "N.name", "Guardian_name", "Address", "City", "State", "Pincode", "Mobile No", "Phone No 1", "Phone No 2", "DOB", "Email", "Bank Name", "Account No", "Branch Name", "Type", "IFSC Code", "PAN Proof", "Document Proof", "Bank Proof", "Sign Proof", "Source By", "Accepted By", "Person Name");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {
            $payment = $this->Payment->find("all", array('conditions' => array('user_id' => $results['User']['user_id']), array('limit' => '3')));
            $paymentcount = $this->Payment->find("count", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $outlet = $this->Outlet->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $nomination = $this->Nomination->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $bank = $this->Bankdetail->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $proof = $this->Franchiseeproof->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $use = $this->Officeuse->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));


            $payments = array();
            foreach ($payment as $payment_del) {

                $payments[] = $payment_del['Payment']['payment'];
                $payments[] = $payment_del['Payment']['amount'];
                $payments[] = $payment_del['Payment']['cheque_no'];
                $payments[] = $payment_del['Payment']['bank_name'];
                $payments[] = $payment_del['Payment']['account_no'];
                $payments[] = $payment_del['Payment']['branch_name'];
            }
            if ($paymentcount < 3) {
                for ($s = $paymentcount + 1; $s <= 3; $s++) {
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                }
            }


            $row = array(
                $i,
                $results['User']['email'],
                $results['User']['title'],
                $results['User']['first_name'],
                $results['User']['last_name'],
                $results['User']['phone_no'],
                $results['User']['address'],
                $results['User']['date_of_birth'],
                $results['User']['martial_status'],
                $results['User']['pan_no'],
                $results['User']['city'],
                $results['User']['state'],
                $results['User']['pincode'],
                $results['User']['mobile_no'],
                $results['User']['phone_no2'],
                $results['User']['fax_no'],
                $results['User']['franchisee_code'],
                $results['User']['status']);
            $row = array_merge($row, $payments);
            $row = array_merge($row, array($outlet['Outlet']['outlet_name'], $outlet['Outlet']['address'], $outlet['Outlet']['city'], $outlet['Outlet']['state'], $outlet['Outlet']['pincode'], $outlet['Outlet']['mobile_no'], $outlet['Outlet']['phone_no1'], $outlet['Outlet']['phone_no2'], $outlet['Outlet']['fax'], $outlet['Outlet']['email']));
            $row = array_merge($row, array($nomination['Nomination']['title'], $nomination['Nomination']['name'], $nomination['Nomination']['guardian_name'], $nomination['Nomination']['address'], $nomination['Nomination']['city'], $nomination['Nomination']['state'], $nomination['Nomination']['pincode'], $nomination['Nomination']['mobile_no'], $nomination['Nomination']['phone_no1'], $nomination['Nomination']['phone_no2'], $nomination['Nomination']['dob'], $nomination['Nomination']['email']));
            $row = array_merge($row, array($bank['Bankdetail']['name'], $bank['Bankdetail']['account_no'], $bank['Bankdetail']['branch_name'], $bank['Bankdetail']['type'], $bank['Bankdetail']['ifsc_code']));
            $row = array_merge($row, array($proof['Franchiseeproof']['pan'], $proof['Franchiseeproof']['proof'], $proof['Franchiseeproof']['bankproof'], $proof['Franchiseeproof']['sign_proof']));
            $row = array_merge($row, array($use['Officeuse']['sourceby'], $use['Officeuse']['acceptedby'], $use['Officeuse']['source_person_name']));
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

}
