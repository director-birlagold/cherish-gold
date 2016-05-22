<?php

App::uses('AppController', 'Controller');

/**
 * Login Controller
 *
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 */
class LoginController extends AppController {

    /**
     * This model is used in site for login
     *
     * @var array
     * @access public
     */
    public $uses = array('Adminuser', 'Emailcontent','Userroles','User', 'App', 'Vendor');

    /**
     * This layout is used for login
     *
     * @var array
     * @access public
     */
    public $layout = 'adminlogin';

    /**
     * admin_index method
     * Login for admin
     *
     * @return void
     */
    public function admin_index() {
        $this->admin_logincheck();
		
		$roles = $this->Userroles->find('all', array('conditions' => ''));
		$this->set('roles', $roles);
		
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['email'])) {
                $check = $this->Adminuser->find('first', array('conditions' => array('email' => $this->request->data['email'], 'status' => 'Active')));
                if (!empty($check)) {
                    $pass = $this->str_rand();
                    $password = sha1($pass);
                    $emailcontent = $this->Emailcontent->find('first', array('conditions' => array('eid' => '1')));
                    $name = $check['Adminuser']['admin_name'];
                    $subject = $emailcontent['Emailcontent']['subject'];
                    $link = BASE_URL . "admin/login";
                    $message = str_replace(array('{username}', '{password}', '{link}'), array($check['Adminuser']['username'], $pass, $link), $emailcontent['Emailcontent']['content']);
                    $this->mailsend($emailcontent['Emailcontent']['fromname'], $emailcontent['Emailcontent']['fromemail'], $this->request->data['email'], $subject, $message);

                    $check['Adminuser']['password'] = $password;
                    $check['Adminuser']['modify_date '] = date("Y-m-d H:i:s", mktime(date("H"), date("i") + 30, date("s"), date("m"), date("d"), date("Y")));
                    $this->Adminuser->save($check);
                    $this->Session->setFlash("<div class='success msg'>" . __('Your password details sent to your email address') . ".</div>", '');
                    $this->redirect(array('controller' => 'login', 'action' => 'index'));
                } else
                    $this->Session->setFlash("<div class='error msg'>" . __('Invalid email address') . ".</div>", '');
                $this->set('result', 'forgot');
            }
            else {
				//echo "here";
				//exit;
				
				//print_r($this->request->data);
				//exit;
				
				if($this->request->data['role_id'] == 3){
					
					$check = $this->User->find('first', array('conditions' => array('email' => $this->request->data['username'])));
					/*echo "<pre>";
					print_r($check);
					exit;*/
					
					//echo "enter pass: ".sha1($this->request->data['password'])."<br/>";
					//echo "db pass: ".$check['User']['password']."<br/>";
					
					if (!empty($check)) {
						if ($check['User']['password'] == sha1($this->request->data['password'])) {
							if ($check['User']['status'] == 'Active') {
								
								$vendor_id = $this->Vendor->find('first', array('conditions' => array('user_id' => $check['User']['user_id'])));
								
								/*echo "<pre>";
								print_r($vendor_id);
								exit;*/
								
								$check1['User']['login_type'] = 'Vendor';
								$check1['Adminuser']['admin_id'] = $check['User']['user_id'];
								$check1['Adminuser']['admin_name'] = $check['User']['email'];
								$check1['Adminuser']['role_id'] = $this->request->data['role_id'];
								$check1['Adminuser']['username'] = $check['User']['email'];
								$check1['Adminuser']['user_type'] = $check['User']['user_type'];
								$check1['Adminuser']['vendor_id'] = $vendor_id['Vendor']['vendor_id'];
								
								$getuserperms = $this->getByUsername($this->request->data['role_id']);
								$check1['Permissions']['user_privilage'] = $getuserperms;
								
								$this->Session->write($check1);
								
								$this->redirect(array('controller' => 'Dashboard', 'action' => 'index'));
								//echo "here..";
								//exit;
							} else
								$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch1') . ".</div>", '');
						} else
							$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch2') . ".</div>", '');
					} else
						$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch3') . ".</div>", '');
					$this->set('result', '');
					
				}else{
					
					$check = $this->Adminuser->find('first', array('conditions' => array('username' => $this->request->data['username'])));
					if (!empty($check)) {
						if ($check['Adminuser']['password'] == sha1($this->request->data['password'])) {
							if ($check['Adminuser']['status'] == 'Active') {
								$check['User']['login_type'] = 'Adminuser';
								$getuserperms = $this->getByUsername($this->request->data['role_id']);
								$check['Permissions']['user_privilage'] = $getuserperms;
								//echo "<pre>";
								//print_r($getuser);
								//exit;
								//echo "<pre>";
								//print_r($check);
								//exit;
								$this->Session->write($check);
								$this->redirect(array('controller' => 'Dashboard', 'action' => 'index'));
							} else
								$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
						} else
							$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
					} else
						$this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
					$this->set('result', '');
				}
				
				
                /*$check = $this->Adminuser->find('first', array('conditions' => array('username' => $this->request->data['username'])));
                if (!empty($check)) {
                    if ($check['Adminuser']['password'] == sha1($this->request->data['password'])) {
                        if ($check['Adminuser']['status'] == 'Active') {
                            $this->Session->write($check);
                            $this->redirect(array('controller' => 'Dashboard', 'action' => 'index'));
                        } else
                            $this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
                    } else
                        $this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
                } else
                    $this->Session->setFlash("<div class='error msg'>" . __('Username and password mismatch') . ".</div>", '');
                $this->set('result', '');*/
            }
        }
    }

}
