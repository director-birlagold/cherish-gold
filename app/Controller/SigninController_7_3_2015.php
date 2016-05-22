<?php

App::uses('AppController', 'Controller');
App::import('Vendor','Facebook' ,array('file'=>'Fb/facebook.php'));

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
    public $uses = array('User', 'Emailcontent', 'Shipping','Whislist');
    public $layout = 'webpage';

    public function index() {
		
		
			if($this->Session->read('referer')==''){
		        $this->Session->write('referer',$this->referer());
			}	
			
		
				if(isset($this->request->data['User']['register']))	{
				if ($this->request->is('post')) { 
				if (!empty($this->request->data['User']['cpassword'])) {
				$check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'],'status !=' => 'Trash')));
				if (empty($check)) {
				$email = $this->request->data['User']['email'];
				$password = $this->request->data['User']['password'];
				$this->request->data['User']['user_type'] = 0;
				$this->request->data['User']['password'] = sha1($this->request->data['User']['password']);
				$hash = sha1($this->request->data['User']['email'] . rand(0, 100));
				$this->request->data['User']['tokenhash'] = $hash;
				$this->request->data['User']['status'] = 'Active';
				$this->User->save($this->request->data);
				$lastid=$this->User->getLastInsertID();
				$check = $this->User->find('first', array('conditions' => array('user_id' =>$lastid)));
				$this->Session->write('loginid', $check['User']['user_id']);
				$this->Session->write($check);
				$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 3)));
				$message = str_replace(array( '{email}', '{password}'), array($email, $password), $activateemail['Emailcontent']['content']);
				//$message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/t:" . $hash . ">" . BASE_URL . "signin/index/t:" . $hash . '' . "</a>", $email, $password), $activateemail['Emailcontent']['content']);
				
				// $message = str_replace(array('{email}', '{password}'), array($email, $password), $activateemail['Emailcontent']['content']);
				$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id ' => '1')));
				$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['User']['email'], $activateemail['Emailcontent']['subject'], $message);
					if(isset($_REQUEST['ref'])){
						if($_REQUEST['ref']=="cart"){
							$this->redirect(array('controller' => 'orders', 'action' => 'personal_details'));
						}else{
							if($this->Session->read('referer')){							
								$referer=$this->Session->read('referer');
								$this->Session->delete('referer');
								$this->redirect($referer);
							}else{
								$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
							}
						}
					}else{
						$this->Session->setFlash("<div class='success msg'>" . __('Successfully Registered. Please update your profile') . "</div>");
						if($this->Session->read('referer')){							
							$referer=$this->Session->read('referer');
							$this->Session->delete('referer');
							$this->redirect($referer);
						}else{
							$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
						}						
						$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
					}
				} else {
					$this->Session->setFlash("<div class='error msg'>" . __('This Email id already exists.') . "</div>");
				}
			} 
		}
	}            
	
	          
	if(isset($this->request->data['User']['login'])){
		if ($this->request->is('post')) {
			if (!empty($this->request->data)) {
				if (!empty($this->request->data['User']['email'])) {				
					$check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'],'status !=' => 'Trash')));
					if (!empty($check)) {
						if ($check['User']['password'] ==sha1( $this->request->data['User']['password'])) {
							if ($check['User']['status'] == 'Active') {
								if($check['User']['user_type']=='1')
								{
									$this->Session->write('Franchisee', $check);
								}
								$tokenhash=$check['User']['tokenhash'];
								$this->Session->write('loginid', $check['User']['user_id']);
								$this->Session->write($check);								
								if(isset($_REQUEST['ref'])){
									if(trim($_REQUEST['ref'])=="cart"){
										$this->redirect(array('controller' => 'orders', 'action' => 'shipping_details'));
									}else{										
										$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
									}
								}else{
									$this->Session->setFlash("<div class='success msg'>" . __('Successfully Registered. Please update your profile') . "</div>");									
									$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
														
									//$this->redirect(array('controller' => 'signin', 'action' => 'index','n'=>'tab-2'));
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
                } 
				else
				{
				 $this->Session->setFlash("<div class='error msg'>" . __('Already Activated.Please Login.') . "</div>");
                 $this->redirect(array('action' => 'index'));	
				}
            }
        }
		 
		 


	}
	
	
	 public function personal() {
                 if($this->request->is('post')) {
                if (!empty($this->request->data)) {
					$user_id=$this->Session->read('User.user_id');
                    $check = $this->User->find('first', array('conditions' => array('user_id' =>$user_id)));
                   if (!empty($check)) {
                            if ($check['User']['status'] == 'Active') {
                                $this->request->data['User']['user_id'] = $check['User']['user_id'];
								$this->request->data['User']['created_date'] =date('Y-m-d H:i:s');
								$this->request->data['User']['date_of_birth']= $this->request->data['User']['year']."-".$this->request->data['User']['month']."-". $this->request->data['User']['date'];
								$this->request->data['User']['anniversary']=$this->request->data['User']['annu_year']."-". $this->request->data['User']['annu_month']."-".$this->request->data['User']['annu_date'];
                                $this->User->save($this->request->data);
                                $this->redirect(array('controller' => 'signin', 'action' => 'shipping'));
                            }
                        }
                        $this->Session->setFlash("<div class='error msg'>" . __('Email mismatch') . ".</div>", '');
                  
                }
            }
			  $user = $this->User->find('first', array('conditions' => array('user_id' =>$this->Session->read('User.user_id'))));
			  $this->set('user',$user);
	
	 }
	 
	 
	  public function shipping() {
            if (!empty($this->request->data)) {
                $user_id = $this->Session->read('User.user_id');
                $check = $this->Shipping->find('first', array('conditions' => array('user_id' =>$user_id)));
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
            $conditions = array('email LIKE' => '%' . $this->request->query('searchterm') . '%','user_type'=>'0', 'status !=' => 'Trash');
        } else {
            $conditions = array('user_type'=>'0','status !=' => 'Trash');
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

    public function admin_delete($id) {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->request->data['User']['user_id'] = $this->params['pass']['0'];
            $this->request->data['User']['status'] = 'Trash';
            $this->User->updateAll(array('status' => "'Trash'"), array('user_id' => $this->params['pass']['0']));
            $this->Session->setFlash('<div class="success msg">' . 'User has been deleted successfully' . '</div>', '');
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
        $shipping = $this->Shipping->find('first', array('conditions' => array('user_id ' => $this->params['pass']['0'])));
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
        $this->layout = false;
		  if ($this->request->is('post')) { ;
                if (!empty($this->request->data['User']['email'])) {
					 $user = $this->User->find('first', array('conditions' => array('email' =>$this->request->data['User']['email'])));
					 if(!empty($user)){
						 if ($user['User']['email'] == $this->request->data['User']['email']) { 
						  if ($user['User']['status'] == 'Active') {
							   $password= $this->str_rand();
							   $user['User']['password']=sha1($password);
							   $this->User->save($user);
						       $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 4)));
						       $activateemail['toemail'] =$this->request->data['User']['email'];
						       $message = str_replace(array('{link}', '{email}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], $password), $activateemail['Emailcontent']['content']);
						       $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
						       $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
							   $this->Session->setFlash("<div class='success msg'>" . __('Your password details sent to your email address.') . "</div>");
				               $this->redirect(array('action'=>'index'));
						 
					 }else
					 
					 {
						 $this->Session->setFlash("<div class='error msg'>" . __('Sorry, You have not permission to vist this page.Please Active') . "</div>");
						
						 $this->redirect(array('action'=>'index'));
					 }
					
					
				}
				
				
		  }
		  else
				{
					 $this->Session->setFlash("<div class='error msg'>" . __('Email id mismatch.') . "</div>");
					 $this->redirect(array('action'=>'index'));
				}
		}
	 }
 }
 
 public function admin_user_export() {
	 
	 $this->layout='';
		$this->render(false);
		ini_set('max_execution_time', 600); 	
		//create a file
		$filename = "user_details.csv";
		$csv_file = fopen('php://output', 'w');
	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$results=$this->User->find('all');//,array('conditions'=>array('status'=>'Active'))
	    $header_row = array("S.No","Email","Frist Name","Last Name","Phone No","Address","Birth day","Anniversary","status","Shipping Address","Shipping Landmark","Billing Address","Billing Landmark","Pincode","City","State");
		fputcsv($csv_file,$header_row,',','"');
		$i=1;
		foreach($results as $results){	
		$shipping=$this->Shipping->find('first',array('conditions'=>array('user_id'=>$results['User']['user_id'])));
		if(!empty($shipping)){
			$address1=$shipping['Shipping']['shipping_address'];
			$land1=$shipping['Shipping']['shipping_landmark'];
			$address2=$shipping['Shipping']['billing_address'];
			$land2=$shipping['Shipping']['billing_landmark'];
			$pincode=$shipping['Shipping']['pincode'];
			$city=$shipping['Shipping']['city'];
			$state=$shipping['Shipping']['state'];
		}else{
			$address1=$land1=$address2=$land2=$pincode=$city=$state='';
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
				$address2,
				$land2,
				$pincode,
				$city,
				$state);
							
			$i++;	
			fputcsv($csv_file,$row,',','"');
		}
		fclose($csv_file);
	 
	 
 }
 
 
 public function facebook() {
		$facebook = new Facebook(array(
		  'appId'  => FACEBOOK_API_KEY,
		  'secret' => FACEBOOK_API_SECRET,
		));		
		// Get User ID
		$user = $facebook->getUser();
		
		if(!empty($user)){
		
			$user_profile = $facebook->api('/me');
			
			$userpro=$this->User->find('first',array('conditions'=>array('facebook_id'=>$user_profile['id'])));	
			
			if(!empty($userpro)){								
				$this->redirect(array('action'=>'profile',$userpro['User']['user_id']));
				$this->redirect(array('controller' => 'signin', 'action' => 'personal'));	
			}
			else
			{
			$this->request->data['User']['email']=$user_profile['email'];
			$this->request->data['User']['user_type']=0;
			$this->request->data['User']['status']='Active';
			$this->request->data['User']['facebook_id']=$user_profile['id'];
			$this->request->data['User']['first_name']=$user_profile['first_name'];
			$this->request->data['User']['last_name']=$user_profile['last_name'];
			//$this->request->data['User']['password']=$this->str_rand();	
			$this->request->data['User']['password']=sha1($this->str_rand());
			$this->User->save($this->request->data);
			$lastid=$this->User->getLastInsertID();				
						
			$this->redirect(array('action'=>'profile',$lastid));
			$this->redirect(array('action'=>'profile'));
			$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
						
			}
			
		}
		else {					
		  $loginUrl = $facebook->getLoginUrl(array('scope'=>'email','display'=>'popup'));
		  $this->redirect($loginUrl);
		}	

 }
 
 public function profile(){
	 $userpro=$this->User->find('first',array('conditions'=>array('user_id'=>$this->params['pass']['0'])));	
	 $this->Session->write('socialsite','facebook');
	$this->Session->write('loginid', $userpro['User']['user_id']);
	$this->Session->write($userpro);
	$this->redirect(array('controller' => 'signin', 'action' => 'personal'));
	/*  $facebook = new Facebook(array(
		  'appId'  => FACEBOOK_API_KEY,
		  'secret' => FACEBOOK_API_SECRET,
		));		

		$user_profile = $facebook->api('/me');
		$this->set('user',$user_profile);*/
	
   }
   
    public function facebook_logout(){
	  $check = $this->User->find('first', array('conditions' => array('user_id' =>$this->Session->read('User.user_id'), 'status' => 'Active')));
	  $this->Session->delete('User');
	  $this->Session->destroy();
      $this->redirect(array('action'=>'index'));	
		
	}
	public function details(){
			
	
		$this->usercheck();
		$user=$this->User->find("first",array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$this->set('user',$user);
		
		$ship=$this->Shipping->find("first",array('conditions'=>array('user_id'=>$user['User']['user_id'])));
		$this->set('ship',$ship);
		if(isset($this->request->data['User']['submit']))	{
			if(!empty($this->request->data['User'])){
			$users = $this->User->find('first', array('conditions' => array('user_id' =>$this->Session->read('User.user_id'))));
		 	if(!empty($users)){
				$this->request->data['User']['user_id'] =$users['User']['user_id'];
			 	if(!empty($this->request->data['User']['date']) && !empty($this->request->data['User']['month'])&& !empty($this->request->data['User']['year'])) {
				$this->request->data['User']['date_of_birth']= $this->request->data['User']['year']."-". $this->request->data['User']['month']."-". $this->request->data['User']['date'];
			 }
			 $this->User->save($this->request->data);
			}
		}
		if(!empty($this->request->data['Shipping'])){
		   $shipping = $this->Shipping->find('first', array('conditions' => array('user_id' =>$this->Session->read('User.user_id'))));
		 	if(!empty($shipping)){
				$this->request->data['Shipping']['shipping_id'] =$shipping['Shipping']['shipping_id'];
			    $this->Shipping->save($this->request->data);
			}
		    else
			{
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
			 $this->redirect(array('action'=>'details'));*/
				 
			/* }
		 }  */
	  }
	  
	  
	  public function wishlist(){
		$this->usercheck();
		
		$user=$this->Whislist->find("all",array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$this->set('user',$user);
		  
	  }

 

}
