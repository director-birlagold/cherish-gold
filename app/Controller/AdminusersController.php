<?php

App::uses('AppController', 'Controller');

/**
 * Adminusers Controller
 *
 * @property Adminuser $Adminuser
 * @property PaginatorComponent $Paginator
 * @property nComponent $n
 * @property SessionComponent $Session
 */
class AdminusersController extends AppController {

    //public $components = array('Paginator', 'N', 'Session');
	public $components = array('Paginator', 'Session', 'Image');
    public $layout = 'admin';
    public $uses = array('Adminuser', 'Emailcontent','Userroles','Emailcontent');

    public function admin_index() {
        $this->checkadmin();
        $this->Adminuser->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['username'] != '') {
                $search[] = 'username=' . $this->request->data['username'];
            }
            
			if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            
            if ($this->request->query('username') != '') {
                $search['username'] = $this->request->query('username');
            }
            
           $this->paginate = array('conditions' => $search, 'order' => 'admin_id DESC');
            $this->set('adminusers', $this->Paginator->paginate('Adminuser'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'admin_id DESC');
            $this->set('adminusers', $this->Paginator->paginate('Adminuser'));
        }
        
    }
	
	
	public function admin_profile() {
        $this->checkadmin();
        $id = $this->Session->read('Adminuser.admin_id');
        if (!$this->Adminuser->exists($id)) {
            throw new NotFoundException(__('Invalid adminuser'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $checkemail = $this->Adminuser->find('first', array('conditions' => array('email' => $this->request->data['Adminuser']['email'], 'admin_id !=' => $id, 'status !=' => 'Trash')));
            if (empty($checkemail)) {
                $this->request->data['Adminuser']['admin_id'] = $id;
                $this->Adminuser->save($this->request->data);
                $this->Session->setFlash("<div class='success msg'>" . __('The admin user detail has been updated successfully') . "</div>", '');
                $this->redirect(array('action' => 'profile'));
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Email already exists') . "</div>", '');
            }
        } else {
            $options = array('conditions' => array('Adminuser.' . $this->Adminuser->primaryKey => $id));
            $this->request->data = $this->Adminuser->find('first', $options);
        }
    }
	
	public function admin_add() {
        $this->checkadmin();
        
		$roles = $this->Userroles->find('all', array('conditions' => ''));
		$this->set('roles', $roles);
		
        if ($this->request->is('post') || $this->request->is('put')) {
            $checkemail = $this->Adminuser->find('first', array('conditions' => array('email' => $this->request->data['Adminuser']['email'], 'username' => $this->request->data['Adminuser']['username'])));
			
			
            if (empty($checkemail)) {
				$this->request->data['Adminuser']['password'] = sha1('shagunn123');
                $this->Adminuser->save($this->request->data);
				
				/*$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 20)));
				$activateemail['toemail'] = $this->request->data['Adminuser']['email'];
				$message = str_replace(array('{link}', '{username}', '{password}'), array("<a target='_blank' href=" . BASE_URL . "signin/index/>" . BASE_URL . "signin/index" . "</a>", $activateemail['toemail'], 'shagunn123'), $activateemail['Emailcontent']['content']);
                $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
                $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['Adminuser']['email'], $activateemail['Emailcontent']['subject'], $message);
				*/
				
                $this->Session->setFlash("<div class='success msg'>" . __('The admin user detail has been Added successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Email ID or Username already exists') . "</div>", '');
            }
        }
    }
	
	public function admin_edit($id) {
        $this->checkadmin();
        
		$roles = $this->Userroles->find('all', array('conditions' => ''));
		$this->set('roles', $roles);
		
		//$new_role = $this->Adminuser->find('all', array('conditions' => array('admin_id' => $this->params['pass']['0'])));
        //$this->set('new_role', $new_role);
		
        $adminuser = $this->Adminuser->find('first', array('conditions' => array('admin_id' => $this->params['pass']['0'])));
        $this->set('adminuser', $adminuser);
        
        $admin_id = $adminuser['Adminuser']['admin_id'];

        if ($this->request->is('post')) {
            $check = $this->Adminuser->find('first', array('conditions' => array('username' => $this->request->data['Adminuser']['username'], 'admin_id !=' => $this->params['pass']['0'], 'status !='=>'Trash')));
            if (empty($check)) {
                $this->request->data['Adminuser']['admin_id'] = $adminuser['Adminuser']['admin_id'];				
				$this->request->data['Adminuser']['password'] = $adminuser['Adminuser']['password'];
				$this->request->data['Adminuser']['status'] = $adminuser['Adminuser']['status'];
				
                $this->request->data['Adminuser']['username'] = $this->request->data['Adminuser']['username'];
				$this->request->data['Adminuser']['admin_name'] = $this->request->data['Adminuser']['admin_name'];
				$this->request->data['Adminuser']['email'] = $this->request->data['Adminuser']['email'];
				$this->request->data['Adminuser']['phone'] = $this->request->data['Adminuser']['phone'];
			
                $this->Adminuser->save($this->request->data);
				//exit;
				

                $this->Session->setFlash('<div class="success msg">Admin User save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Admin User already exits.</div>', '');
            }
        }
    }
	
	public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Adminuser->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Adminuser->exists()) {
                throw new NotFoundException(__('Invalid Record'));
            }

            $this->request->data['Adminuser']['admin_id'] = $this->params['pass']['0'];
            $this->request->data['Adminuser']['status'] = 'Trash';
            $this->Adminuser->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Record has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $productdelete) {
                    if ($productdelete > 0) {
                        $this->request->data['Adminuser']['admin_id'] = $productdelete;
                        $this->request->data['Adminuser']['status'] = 'Trash';
                        $this->Adminuser->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Record has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changepass() {
        $this->checkadmin();
        $id = $this->Session->read('Adminuser.admin_id');
        if (!$this->Adminuser->exists($id)) {
            throw new NotFoundException(__('Invalid adminuser'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $checkpass = $this->Adminuser->find('first', array('conditions' => array('password' => sha1($this->request->data['Adminuser']['oldpassword']), 'admin_id' => $id)));
            if (!empty($checkpass)) {
                if ($this->request->data['Adminuser']['passwords'] == $this->request->data['Adminuser']['cpassword']) {
                    $this->request->data['Adminuser']['password'] = sha1($this->request->data['Adminuser']['passwords']);
                    $this->request->data['Adminuser']['admin_id'] = $id;
                    $this->Adminuser->save($this->request->data);
                    $this->Session->setFlash("<div class='success msg'>" . __('The admin user detail has been updated successfully') . "</div>", '');
                    $this->redirect(array('action' => 'changepass'));
                } else {
                    $this->Session->setFlash("<div class='error msg'>" . __('New password and confirm password did not match') . "</div>", '');
                }
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Old Password is incorrect') . "</div>", '');
            }
        }
    }

    public function admin_changenewpass($id = NULL) {
        $this->checkadmin();
        $this->superadmin();
        if (!$this->Adminuser->exists($id)) {
            throw new NotFoundException(__('Invalid adminuser'));
        }
        $check = $this->Adminuser->find('first', array('conditions' => array('admin_id' => $this->params->pass['0'], 'status !=' => 'Trash')));
        if (!empty($check)) {
            $checkemail = $this->Adminuser->find('first', array('conditions' => array('admin_id' => $this->params->pass['0'], 'status !=' => 'Trash')));
            $password = $this->str_rand();
            $this->request->data['Adminuser']['admin_id'] = $id;
            $this->request->data['Adminuser']['password'] = sha1($password);
            $this->request->data['Adminuser']['status'] = 'Active';
            $this->Adminuser->save($this->request->data);
            /* $emaillist=$this->Emaillist->find('first',array('conditions'=>array('eid'=>'3')));
              $emailcontent=$this->Emailcontent->find('first',array('conditions'=>array('eid'=>'3','lan'=>'en'))); */
            $emailcontent = $this->Emailcontent->find('first', array('conditions' => array('eid' => '3')));
            $link = BASE_URL . "admin/";
            $message = str_replace(array('{username}', '{password}', '{link}'), array($checkemail['Adminuser']['username'], $password, $link), $emailcontent['Emailcontent']['emailcontent']);
            $this->mailsend($emaillist['Emaillist']['fromname'], $emaillist['Emaillist']['fromemail'], $checkemail['Adminuser']['email'], $emailcontent['Emailcontent']['subject'], $message);
            $this->Session->setFlash("<div class='success msg'>" . __('The admin user password has been changed successfully') . "</div>", '');
            $this->redirect(array('action' => 'edit', $id));
        } else {
            $this->Session->setFlash("<div class='error msg'>" . __('Admin User not found') . "</div>", '');
        }
    }

    private function superadmin() {
        $id = $this->Session->read('Adminuser.admin_id');
        if ($id > 1) {
            $this->Session->setFlash("<div class='warning msg'>" . __('Sorry, You have not permission to vist this page') . "</div>", '');
            $this->redirect(array('action' => 'profile'));
        }
    }

}
