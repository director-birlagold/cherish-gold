<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'Facebook', array('file' => 'Fb/facebook.php'));

/**
 * Statuses Controller
 *
 * @property Status $Status
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SigninController extends AppController {
    /**
     * Helpers
     *
     * @var array
     */

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('User', 'Emailcontent', 'Shipping', 'Whislist', 'Shippingdetails','CustomerBGP');
    public $layout = 'frontend';

    public function index() {
		if($this->Session->check('loginid'))
		{
			$this->redirect(array('action' => 'details'));
		}

        if(isset($this->params->query['rel']) &&  $this->params->query['rel'] == 'register'){
            $this->set("register",true);
        }

        if(isset($this->params->query['rel']) &&  $this->params->query['rel'] == 'cart'){
            $this->Session->write('cart_redirect',1);
        }
		
        if ($this->Session->read('referer') == '') {
            $this->Session->write('referer', $this->referer());
        }
		
        if (isset($this->request->data['User']['register'])) {
            if ($this->request->is('post')) {
                if (!empty($this->request->data['User']['cpassword'])) {
                    $check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'], 'status !=' => 'Trash')));
                    if (empty($check)) {
                        $email = $this->request->data['User']['email'];
                        $password = $this->request->data['User']['password'];
                        $this->request->data['User']['user_type'] = 0;
                        $this->request->data['User']['password'] = sha1($this->request->data['User']['password']);
                        $hash = sha1($this->request->data['User']['email'] . rand(0, 100));
                        $this->request->data['User']['tokenhash'] = $hash;
                        $this->request->data['User']['status'] = 'Active';
                        $this->User->save($this->request->data);
                        $lastid = $this->User->getLastInsertID();
                        $check = $this->User->find('first', array('conditions' => array('user_id' => $lastid)));
                        $this->Session->write('loginid', $check['User']['user_id']);
                        $this->Session->write($check);
                        $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 3)));
                        $message = str_replace(array('{email}', '{password}'), array($email, $password), $activateemail['Emailcontent']['content']);
                        //$message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/t:" . $hash . ">" . BASE_URL . "signin/index/t:" . $hash . '' . "</a>", $email, $password), $activateemail['Emailcontent']['content']);
                        // $message = str_replace(array('{email}', '{password}'), array($email, $password), $activateemail['Emailcontent']['content']);
                        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id ' => '1')));
                        //$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['User']['email'], $activateemail['Emailcontent']['subject'], $message);

                        if($this->Session->check('cart_redirect')){
                            $this->Session->delete('cart_redirect');
                            $this->redirect(array('controller' => 'orders', 'action' => 'personal_details'));
                            die;
                        }

                        if ($this->Session->check('referer')) {
                            $referer = $this->Session->read('referer');
                            $this->Session->delete('referer');
                            $this->redirect($referer);
                            die;
                        } else {
                            $this->Session->setFlash("<div class='success msg'>" . __('Successfully Registered. Please update your profile') . "</div>");
                            $this->redirect(array('controller' => 'signin', 'action' => 'personal'));
                            die;
                        }
                    } else {
                        $this->Session->setFlash("<div class='error msg'>" . __('This Email id already exists.') . "</div>");
                    }
                }
            }
        }


        if (isset($this->request->data['User']['login'])) {
            if ($this->request->is('post')) {
                if (!empty($this->request->data)) {
                    if (!empty($this->request->data['User']['email'])) {
                        $check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'], 'status !=' => 'Trash')));
                        if (!empty($check)) {
                            if ($check['User']['password'] == sha1($this->request->data['User']['password'])) {
                                if ($check['User']['status'] == 'Active') {
                                    if ($check['User']['user_type'] == '1') {
                                        $this->Session->write('Franchisee', $check);
                                    }
                                    $tokenhash = $check['User']['tokenhash'];
                                    $this->Session->write('loginid', $check['User']['user_id']);
									$customer = $this->CustomerBGP->find('first', array('conditions' => array('user_id'=>$check['User']['user_id'])));
									if($customer)
									{
										$this->Session->write("customer_id",$customer['CustomerBGP']['customer_id']);
									}
                                    $this->Session->write($check);
                                    if ($check['User']['cart_session'] != '') {
                                        $prev_cart_session = $this->Session->read('cart_process');
                                        $this->Shoppingcart->updateAll(array('cart_session'=>"'".$check['User']['cart_session']."'"),array('cart_session'=>$prev_cart_session));
                                        $this->Session->write('cart_process', $check['User']['cart_session']);
                                    }

                                    if($_SERVER["HTTP_REFERER"] == BASE_URL."/bgp-plan/registration")
                                    {                                       
                                        $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
                                    }

                                    if($this->Session->check('cart_redirect')){
                                        $this->Session->delete('cart_redirect');
                                        $this->redirect(array('controller' => 'orders', 'action' => 'shipping_details'));
                                        die;
                                    }

                                    if ($this->Session->check('referer')) {
                                        $referer = $this->Session->read('referer');
                                        $this->Session->delete('referer');
                                        $this->redirect($referer);
                                        die;
                                    } else {
                                        $this->Session->setFlash("<div class='success msg'>" . __('Successfully Logged in') . "</div>");

                                        if($check['User']['user_type'] == '2'){
                                            $this->redirect(array('controller' => 'vendors', 'action' => 'user_orders'));
                                        }
                                        pr($check); die;
                                        if(empty($check['User']['first_name']) || empty($check['User']['phone_no'])){
                                            $this->redirect(array('controller' => 'signin', 'action' => 'personal'));
                                        }
                                        $this->redirect(array('controller' => 'signin', 'action' => 'details'));
                                        die;
                                    }

                                } else
                                    $this->Session->setFlash("<div class='error msg'>" . __('Email id and password mismatch') . ".</div>", '');
                            } else
                                $this->Session->setFlash("<div class='error msg'>" . __('Email id and password mismatch') . ".</div>", '');
                        } else
                            $this->Session->setFlash("<div class='error msg'>" . __('Email id and password mismatch') . ".</div>", '');
                        $this->set('result', '');
                    }
                }
            }
        }


        if (!empty($this->passedArgs['t'])) {
            $tokenhash = $this->passedArgs['t'];
            $this->Session->write('tokenhash', $tokenhash);
            $results = $this->User->find('first', array('conditions' => array('tokenhash' => $tokenhash)));
            $this->Session->write('user_id', $results['User']['user_id']);
            if ($results['User']['tokenhash'] == $tokenhash) {
                if ($results['User']['status'] == 'Pending') {

                    $this->Session->write('user_id', $results);
                    $results['User']['status'] = 'Active';
                    $this->User->save($results);
                    $this->Session->setFlash("<div class='success msg'>" . __('Status Successfully Activated.Please Login.') . "</div>");
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash("<div class='error msg'>" . __('Already Activated.Please Login.') . "</div>");
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

     public function personal() {
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $user_id = $this->Session->read('User.user_id');
                $check = $this->User->find('first', array('conditions' => array('user_id' => $user_id)));
                if (!empty($check)) {
                    if ($check['User']['status'] == 'Active') {
                        $this->request->data['User']['user_id'] = $check['User']['user_id'];
                        $this->request->data['User']['created_date'] = date('Y-m-d H:i:s');
						if(!empty($this->request->data['User']['year']) && !empty($this->request->data['User']['month']) && !empty($this->request->data['User']['date']))
						{
								$this->request->data['User']['date_of_birth'] = $this->request->data['User']['year'] . "-" . $this->request->data['User']['month'] . 
								"-" . $this->request->data['User']['date'];
						}else{
							$this->request->data['User']['date_of_birth']='';
						}
						if(!empty($this->request->data['User']['annu_year']) && !empty($this->request->data['User']['annu_month']) && !empty($this->request->data['User']['annu_date']))
						{
                        $this->request->data['User']['anniversary'] = $this->request->data['User']['annu_year'] . "-" . $this->request->data['User']['annu_month'] . "-" . $this->request->data['User']['annu_date'];
						}else{
							$this->request->data['User']['anniversary'] = '';
						}
                        $this->User->save($this->request->data);
                        $this->redirect(array('controller' => 'signin', 'action' => 'details'));
                    }
                }
                $this->Session->setFlash("<div class='error msg'>" . __('Email mismatch') . ".</div>", '');
            }
        }
        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        $this->set('user', $user);
    }

    public function shipping() {
        if (!empty($this->request->data)) {
            $user_id = $this->Session->read('User.user_id');
            $check = $this->Shipping->find('first', array('conditions' => array('user_id' => $user_id)));
            if (empty($check)) {
                $this->request->data['Shipping']['user_id'] = $user_id;
                $this->Shipping->save($this->request->data);
                $this->redirect(array('controller' => 'signin', 'action' => 'details'));
            }
        }
    }

    public function admin_index() {
        $this->layout = 'admin';
        $this->checkadmin();
        $this->User->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => 'admin_index/?search=1&searchterm=' . $this->request->data['searchterm']));
        }


        if ($this->request->query('search') != '') {
            $conditions = array('email LIKE' => '%' . $this->request->query('searchterm') . '%', 'user_type' => '0', 'status !=' => 'Trash');
        } else {
            $conditions = array('user_type' => '0', 'status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'user_id DESC');
        $this->set('user', $this->Paginator->paginate('User'));
    }

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['User']['user_id'] = $id;
        $this->request->data['User']['status'] = $status;
        $this->User->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('User Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'admin_index'));
    }

    public function admin_activate($id) {
        $userdetail = $this->User->find('first', array('conditions' => array('user_id' => $id)));

        $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 3)));
        $activateemail['toemail'] = $userdetail['User']['email'];
        $password = $userdetail['User']['password'];
        $hash = sha1($userdetail['User']['email'] . rand(0, 100));
        $userdetail['User']['tokenhash'] = $hash;
        $this->User->save($userdetail);
        $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/t:" . $hash . ">" . BASE_URL . "signin/index/t:" . $hash . '' . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);

        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
        $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $userdetail['User']['email'], $activateemail['Emailcontent']['subject'], $message);
        $this->Session->setFlash("<div class='success msg'>" . __('Activation Link Sent sucessfully.') . "</div>");
        $this->redirect(array('action' => 'admin_index'));
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->request->data['User']['user_id'] = $this->params['pass']['0'];
            $this->request->data['User']['status'] = 'Trash';
            $this->User->updateAll(array('status' => "'Trash'"), array('user_id' => $this->params['pass']['0']));
            $this->Session->setFlash('<div class="success msg">' . 'User has been deleted successfully' . '</div>', '');
            $this->redirect(array('action' => 'admin_index'));
        }else {
			
            if (!empty($this->request->data['action'])) {
				
                foreach ($this->request->data['action'] as $user) {
					
                    if ($user > 0) {
                        $this->request->data['User']['user_id'] = $user;
                        $this->request->data['User']['status'] = 'Trash';
                        $this->User->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('User has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_index'));
        }
    }

    public function admin_edit($id) {
        $this->layout = 'admin';
        $this->checkadmin();
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid User'));
        }
        $user = $this->User->find('first', array('conditions' => array('user_id ' => $this->params['pass']['0'])));
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['user_id'] = $this->params['pass'][0];
            $this->User->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Pesonal details updated successfully.</div>', '');
            $this->redirect(array('action' => 'admin_index'));
        } else {
            $this->request->data = $user;
        }
    }

    public function admin_shipping_edit($id) {
        $this->layout = 'admin';
        $this->checkadmin();
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid User'));
        }
        $shipping = $this->Shipping->find('all', array('conditions' => array('user_id ' => $this->params['pass']['0']),'order' => 'default DESC'));
		
        if (empty($shipping)) {
            // $this->Session->setFlash('<div class="error msg">Please update shipping details.</div>', '');
        }
        /* else if ($this->request->is('post') || $this->request->is('put')) {
          $this->request->data['Shipping']['user_id'] = $this->params['pass'][0];
          $this->Shipping->save($this->request->data);
          $this->Session->setFlash('<div class="success msg">Shipping details updated successfully.</div>','');
          $this->redirect(array('action'=>'admin_index'));
          } */
		
        $this->request->data = $shipping;
    }

    public function forgot() {
        if($this->Session->check('loginid'))
		{
			$this->redirect(array('action' => 'details'));
		}
        if ($this->request->is('post')) {
            
            if (!empty($this->request->data['User']['email'])) {
                $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'],'status !='=>'Trash')));
                if (!empty($user)) {
                    if ($user['User']['email'] == $this->request->data['User']['email']) {
                        if ($user['User']['status'] == 'Active') {
                            $password = $this->str_rand();
                            $user['User']['password'] = sha1($password);
                            $this->User->save($user);
						  // 	$password=$user['User']['password'];
                            if($user['User']['user_type'] == '2'){
                                $template = 17;
                            }else{
                                $template = 4;
                            }
                            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => $template)));
                            $activateemail['toemail'] = $this->request->data['User']['email'];
                            $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);
                            $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
                            $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
                            $this->Session->setFlash("<div class='success msg'>" . __('Your password details sent to your email address.') . "</div>");
                            $this->redirect(array('action' => 'forgot'));
                        } else {
                            $this->Session->setFlash("<div class='error msg'>" . __('Sorry, You have not permission to vist this page.Please Active') . "</div>");

                            $this->redirect(array('action' => 'forgot'));
                        }
                    }
                } else {
                    $this->Session->setFlash("<div class='error msg'>" . __('Email id mismatch.') . "</div>");
                    $this->redirect(array('action' => 'forgot'));
                }
            }
        }
    }

   public function admin_user_export($user_id = NULL) {
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "user_details.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        if($user_id == NULL){
        $results = $this->User->find('all',array('conditions'=>array(
            'status !='=>'Trash',
            'user_type'=>'0'
            ))); //,array('conditions'=>array('status'=>'Active'))
        }else{
            $exp_user = explode(',', $user_id);
            $results = $this->User->find('all',array('conditions'=>array(
                'status !='=>'Trash',
                'user_type'=>'0',
                'user_id' => $exp_user
                ))); //,array('conditions'=>array('status'=>'Active'))
            
        }
        $header_row = array("S.No", "Email", "Frist Name", "Last Name", "Phone No", "Address", "Birth day", "Anniversary", "status", "Shipping Address", "Shipping Landmark","Shipping Pincode","Shipping City","Shipping State", "Billing Address", "Billing Landmark", "Pincode", "City", "State");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {
            $shipping = $this->Shipping->find('first', array('conditions' => array('user_id' => $results['User']['user_id'])));
            if (!empty($shipping)) {
                $address1 = $shipping['Shipping']['shipping_address'];
                $land1 = $shipping['Shipping']['shipping_landmark'];
                    $shipping_pincode=$shipping['Shipping']['shipping_pincode'];
                    $shipping_city=$shipping['Shipping']['shipping_city'];
                    $shipping_state=$shipping['Shipping']['shipping_state'];
                $address2 = $shipping['Shipping']['billing_address'];
                $land2 = $shipping['Shipping']['billing_landmark'];
				
                $pincode = $shipping['Shipping']['pincode'];
                $city = $shipping['Shipping']['city'];
                $state = $shipping['Shipping']['state'];
            } else {
                $address1 = $land1 = $address2 = $land2 = $pincode = $city = $state = $shipping_pincode = $shipping_city = $shipping_state = '';
            }
            $row = array(
                $i,
                $results['User']['email'],
                $results['User']['first_name'],
                $results['User']['last_name'],
                $results['User']['phone_no'],
                $results['User']['address'],
                $results['User']['date_of_birth'],
                $results['User']['anniversary'],
                $results['User']['status'],
                $address1,
                $land1,
                $shipping_pincode,
                $shipping_city,
                $shipping_state,
                $address2,
                $land2,
                $pincode,
                $city,
                $state);

            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }


    public function facebook($cart = '') {
        $facebook = new Facebook(array(
            'appId' => 332032290254287,
            'secret' => '3d822737acd3f4aaeda290a55d666942',
        ));
        // Get User ID
        $user = $facebook->getUser();

        if (!empty($user)) {

            $user_profile = $facebook->api('/me?fields=id,name,first_name,last_name,email,gender,permissions');

			$userpro = $this->User->find('first', array('conditions' => array('facebook_id' => $user_profile['id'],'status !='=>'Trash')));
			
            if (!empty($userpro)) {
		if($userpro['User']['status']=="Active"){
			$this->redirect(array('action' => 'profile', $userpro['User']['user_id']));
		}else{
			  $this->Session->setFlash("<div class='success msg'>" . __('You are deactivated by admin.') . "</div>");
		  $this->redirect(array('action'=>'index'));
		}
                //$this->redirect(array('action' => 'profile', $userpro['User']['user_id']));
                if ($cart == '') {
                    $this->redirect(array('controller' => 'signin', 'action' => 'personal'));
                } else {
                    $this->redirect(array('controller' => 'shoppingcarts', 'action' => 'shopping_cart'));
                }
            } else {
				
                $this->request->data['User']['email'] = $user_profile['email'];
                $this->request->data['User']['user_type'] = 0;
                $this->request->data['User']['status'] = 'Active';
                $this->request->data['User']['facebook_id'] = $user_profile['id'];
                $this->request->data['User']['first_name'] = $user_profile['first_name'];
                $this->request->data['User']['last_name'] = $user_profile['last_name'];
                //$this->request->data['User']['password']=$this->str_rand();	
                $this->request->data['User']['password'] = sha1($this->str_rand());
				// echo "<pre>";
				// print_r($this->request->data);
				// exit;
                $this->User->save($this->request->data);
                $lastid = $this->User->getLastInsertID();

                $this->redirect(array('action' => 'profile', $lastid));
                $this->redirect(array('action' => 'profile'));
                $this->redirect(array('controller' => 'signin', 'action' => 'personal'));
            }
        } else {
            $loginUrl = $facebook->getLoginUrl(array('scope' => 'email', 'display' => 'popup'));
            $this->redirect($loginUrl);
        }
    }

    public function profile() {
        $userpro = $this->User->find('first', array('conditions' => array('user_id' => $this->params['pass']['0'])));
        $this->Session->write('socialsite', 'facebook');
        $this->Session->write('loginid', $userpro['User']['user_id']);
        $this->Session->write($userpro);
        $this->redirect(array('controller' => 'signin', 'action' => 'personal'));
        /*  $facebook = new Facebook(array(
          'appId'  => FACEBOOK_API_KEY,
          'secret' => FACEBOOK_API_SECRET,
          ));

          $user_profile = $facebook->api('/me');
          $this->set('user',$user_profile); */
    }

    public function facebook_logout() {
        $check = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'), 'status' => 'Active')));
        $this->Session->delete('User');
        $this->Session->destroy();
        $this->redirect(array('action' => 'index'));
    }

    public function details() {


        $this->usercheck();
        $user = $this->User->find("first", array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        $this->set('user', $user);

        $ship = $this->Shipping->find("first", array('conditions' => array('user_id' => $user['User']['user_id'])));
        $this->set('ship', $ship);
        if (isset($this->request->data['User']['submit'])) {
            if (!empty($this->request->data['User'])) {
                $users = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
                if (!empty($users)) {
                    $this->request->data['User']['user_id'] = $users['User']['user_id'];
                    $this->request->data['User']['password']= sha1($this->request->data['User']['password']);

                    $this->User->save($this->request->data);
                }
            }
            if (!empty($this->request->data['Shipping'])) {
                $shipping = $this->Shipping->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
                if (!empty($shipping)) {
                    $this->request->data['Shipping']['shipping_id'] = $shipping['Shipping']['shipping_id'];
                    $this->Shipping->save($this->request->data);
                } else {
                    $this->Shipping->save($this->request->data);
                }
            }
        }
        /* if ($this->request->is('post')) { 
          $users = $this->User->find('first', array('conditions' => array('email' =>$this->request->data['User']['email'])));
          if(empty($users)){

          $this->request->data['User']['user_id'] =$this->Session->read('User.user_id');
          if(!empty($this->request->data['User']['date']) && !empty($this->request->data['User']['month'])&& !empty($this->request->data['User']['year'])) {
          $this->request->data['User']['date_of_birth']= $this->request->data['User']['year']."-". $this->request->data['User']['month']."-". $this->request->data['User']['date'];

          }
          $this->User->save($this->request->data);
          if(!empty($this->request->data['Shipping'])){
          $lastid=$this->User->getLastInsertID();
          $this->request->data['Shipping']['user_id'] =$this->Session->read('User.user_id');
          $this->Shipping->save($this->request->data);
          }
          $this->Session->setFlash("<div class='success msg'>" . __('Details saved successfully.') . "</div>");
          $this->redirect(array('action'=>'details'));
          } else
          {


          $this->request->data['User']['user_id'] =$this->Session->read('User.user_id');
          if(!empty($this->request->data['User']['date']) && !empty($this->request->data['User']['month'])&& !empty($this->request->data['User']['year'])) {
          $this->request->data['User']['date_of_birth']= $this->request->data['User']['year']."-". $this->request->data['User']['month']."-". $this->request->data['User']['date'];

          }
          $this->User->save($this->request->data);
          if(!empty($this->request->data['Shipping'])){

          $this->request->data['Shipping']['user_id'] =$this->Session->read('User.user_id');
          //$this->request->data['Shipping']['shipping_id'] =$ship['Shipping']['shipping_id'];
          $this->Shipping->save($this->request->data);
          }
          $this->Session->setFlash("<div class='success msg'>" . __('Details saved successfully.') . "</div>");
          $this->redirect(array('action'=>'details')); */

        /* }
          } */
    }

    public function wishlist() {
        $this->usercheck();

        $user = $this->Whislist->find("all", array('conditions' => array('Whislist.user_id' => $this->Session->read('User.user_id'),'Whislist.status'=>'Active','Whislist.product_id NOT IN (SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.order_id IN (SELECT Orders.order_id FROM `sha_orders` AS `Orders` WHERE Orders.user_id='.$this->Session->read('User.user_id').' AND (Orders.status=\'Paid\' OR Orders.status=\'Partialpaid\') AND Orders.created_date >= Whislist.created_date))'),'joins'=>array(array(
				'table'=>'products',
				'alias'=>'Product',
				'type'=>'inner',
				 'foreignKey' => false,
				'conditions' => array('`Product.product_id`=`Whislist.product_id`','Product.status'=>'Active')
				)),'group'=>'Whislist.whislist_id'));
        $this->set('user', $user);
    }

    public function address_book() {
        $this->usercheck();

        $address = $this->Shippingdetails->find("all", array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'limit' => '3'));

        $count = $this->Shippingdetails->find("count", array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'limit' => '3'));

        $this->set('address', $address);
        $this->set('count', $count);
    }

    public function billing_address() {

        $this->usercheck();
        $user = '';
        if (isset($this->params['pass']['0'])) {
            $user = $this->Shippingdetails->find("first", array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        }
        if (isset($this->request->data['nextBtn'])) {
            $user = $this->Shippingdetails->find("count", array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
            if ($user != 0) {
                $billing_address = $this->request->data['Shippingdetails']['billing_address'];
                $billing_landmark = $this->request->data['Shippingdetails']['billing_landmark'];
                $pincode = $this->request->data['Shippingdetails']['pincode'];
                $city = $this->request->data['Shippingdetails']['city'];
                $state = $this->request->data['Shippingdetails']['state'];
                $this->Shippingdetails->updateAll(array('billing_address' => "'$billing_address'", 'billing_landmark' => "'$billing_landmark'", 'pincode' => "'$pincode'", 'city' => "'$city'", 'state' => "'$state'"), array('user_id' => $this->Session->read('User.user_id')));
                $this->redirect(array('controller' => 'signin', 'action' => 'address_book'));
            } else {
                $this->request->data['Shippingdetails']['user_id'] = $this->Session->read('User.user_id');
                $this->Shippingdetails->save($this->request->data);
                $this->redirect(array('controller' => 'signin', 'action' => 'address_book'));
            }
        }
        $this->set('user', $user);
    }

    public function shipping_address() {
        $this->usercheck();
        $user = '';
        if (isset($this->params['pass']['0'])) {
            $user = $this->Shippingdetails->find("first", array('conditions' => array('shipping_id' => $this->params['pass']['0'])));
        }
        if (isset($this->request->data['nextBtn'])) {
            $user = $this->Shippingdetails->find("count", array('conditions' => array('user_id' => $this->Session->read('User.user_id'), 'shipping_address' => '')));
            if ($user != 0 && !isset($this->params['pass']['0'])) {
                $billing_address = $this->request->data['Shippingdetails']['shipping_address'];
                $billing_landmark = $this->request->data['Shippingdetails']['shipping_landmark'];
                $pincode = $this->request->data['Shippingdetails']['shipping_pincode'];
                $city = $this->request->data['Shippingdetails']['shipping_city'];
                $state = $this->request->data['Shippingdetails']['shipping_state'];
                $this->Shippingdetails->updateAll(array('shipping_address' => "'$billing_address'", 'shipping_landmark' => "'$billing_landmark'", 'shipping_pincode' => "'$pincode'", 'shipping_city' => "'$city'", 'shipping_state' => "'$state'", 'default' => 1), array('user_id' => $this->Session->read('User.user_id')));
                
                $shipping_update = $this->Shippingdetails->find("first", array('conditions' => array('user_id' => $this->Session->read('User.user_id'),'billing_address != '=>"")));
             
           if(!empty($shipping_update))  {   
               
                $billing_address_update=$shipping_update['Shippingdetails']['billing_address'];
                $billing_landmark_update=$shipping_update['Shippingdetails']['billing_landmark'];
                $pincode_update=$shipping_update['Shippingdetails']['pincode'];
                $city_update=$shipping_update['Shippingdetails']['city'];
                $state_update=$shipping_update['Shippingdetails']['state'];
                
               $this->Shippingdetails->updateAll(array('billing_address' => "'$billing_address_update'", 'billing_landmark' => "'$billing_landmark_update'", 'pincode' => "'$pincode_update'", 'city' => "'$city_update'", 'state' => "'$state_update'"), array('user_id' => $this->Session->read('User.user_id')));}
                
                $this->redirect(array('controller' => 'signin', 'action' => 'address_book'));
            } else if (!isset($this->params['pass']['0'])) {
                $user_count = $this->Shippingdetails->find("count", array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
                $this->request->data['Shippingdetails']['user_id'] = $this->Session->read('User.user_id');
                if ($user_count == 0) {
                    $this->request->data['Shippingdetails']['default'] = "1";
                }
                $this->Shippingdetails->save($this->request->data);
                
                  $shipping_update = $this->Shippingdetails->find("first", array('conditions' => array('user_id' => $this->Session->read('User.user_id'),'billing_address != '=>"")));
                  
               
  if(!empty($shipping_update))   {
       $billing_address_update=$shipping_update['Shippingdetails']['billing_address'];
                $billing_landmark_update=$shipping_update['Shippingdetails']['billing_landmark'];
                $pincode_update=$shipping_update['Shippingdetails']['pincode'];
                $city_update=$shipping_update['Shippingdetails']['city'];
                $state_update=$shipping_update['Shippingdetails']['state'];
      $this->Shippingdetails->updateAll(array('billing_address' => "'$billing_address_update'", 'billing_landmark' => "'$billing_landmark_update'", 'pincode' => "'$pincode_update'", 'city' => "'$city_update'", 'state' => "'$state_update'"), array('user_id' => $this->Session->read('User.user_id')));}
                
                $this->redirect(array('controller' => 'signin', 'action' => 'address_book'));
            } else if ($this->params['pass']['0'] != '') {

                $billing_address = $this->request->data['Shippingdetails']['shipping_address'];
                $billing_landmark = $this->request->data['Shippingdetails']['shipping_landmark'];
                $pincode = $this->request->data['Shippingdetails']['shipping_pincode'];
                $city = $this->request->data['Shippingdetails']['shipping_city'];
                $state = $this->request->data['Shippingdetails']['shipping_state'];
                $this->Shippingdetails->updateAll(array('shipping_address' => "'$billing_address'", 'shipping_landmark' => "'$billing_landmark'", 'shipping_pincode' => "'$pincode'", 'shipping_city' => "'$city'", 'shipping_state' => "'$state'"), array('shipping_id' => $this->params['pass']['0']));
             
                $shipping_update = $this->Shippingdetails->find("first", array('conditions' => array('user_id' => $this->Session->read('User.user_id'),'billing_address != '=>"")));
             
           if(!empty($shipping_update)) {  
               
                  $billing_address_update=$shipping_update['Shippingdetails']['billing_address'];
                $billing_landmark_update=$shipping_update['Shippingdetails']['billing_landmark'];
                $pincode_update=$shipping_update['Shippingdetails']['pincode'];
                $city_update=$shipping_update['Shippingdetails']['city'];
                $state_update=$shipping_update['Shippingdetails']['state'];
               $this->Shippingdetails->updateAll(array('billing_address' => "'$billing_address_update'", 'billing_landmark' => "'$billing_landmark_update'", 'pincode' => "'$pincode_update'", 'city' => "'$city_update'", 'state' => "'$state_update'"), array('user_id' => $this->Session->read('User.user_id')));}
                
                
                $this->redirect(array('controller' => 'signin', 'action' => 'address_book'));
            }
        }

        $this->set('user', $user);
    }

    public function update_default() {
        $id = $this->params['pass']['0'];

        $this->Shippingdetails->updateAll(array('default' => 0), array('user_id' => $this->Session->read('User.user_id')));
        $this->Shippingdetails->updateAll(array('default' => 1), array('shipping_id' => $id));

        echo "success";
        exit;
    }
    
    public function testmail() {
        $this->mailsend(SITE_NAME, 'customer.service@Cherishgold.com', 'softwaretesterid@gmail.com', 'Cherishgold Welcomes you', 'Hai', $cc = NULL, $attachment = 0, $attachmentsfiles = '', $template = 'default', $layout = 'default') ;
        exit;
    }		public function deleteWishlistProduct() {       $this->usercheck();	   $wishlist_id = (int)$_POST['wishlist_id'];	   	   /*Single Whislist Delete*/        if (!empty($wishlist_id) && $wishlist_id > 0) {            $this->Whislist->id = $wishlist_id;            $id = $wishlist_id;            if (!$this->Whislist->exists()) {                throw new NotFoundException(__('Invalid Whislist'));            }            $this->request->data['Whislist']['whislist_id'] = $wishlist_id;            $this->request->data['Whislist']['status'] = 'Trash';            $this->Whislist->save($this->request->data);            $this->Session->setFlash("<div class='success msg'>" . __('Wish list has been deleted successfully') . "</div>", '');			echo json_encode(array("success"=>true));        }else{			$this->Session->setFlash("<div class='error msg'>" . __('Invalid Request') . "</div>", '');			echo json_encode(array("success"=>false));		}		exit;    }

}
