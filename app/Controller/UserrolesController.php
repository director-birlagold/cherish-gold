<?php

App::uses('AppController', 'Controller');

/**
 * Userroles Controller
 *
 * @property Userroles $Userroles
 * @property PaginatorComponent $Paginator
 */
class UserrolesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Userroles','Permissions','Roles','Roleperm');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Userroles->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['role_name'] != '') {
                $search[] = 'role_name=' . $this->request->data['role_name'];
            }
            
			if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            
            if ($this->request->query('role_name') != '') {
                $search['role_name'] = $this->request->query('role_name');
            }
            
            $this->paginate = array('conditions' => $search, 'order' => 'role_id DESC');
            $this->set('roles', $this->Paginator->paginate('Roles'));
        } else {
            $this->paginate = array('order' => 'role_id DESC');
            $this->set('roles', $this->Paginator->paginate('Roles'));
        }
        
    }

    public function admin_add() {
        $this->checkadmin();
        
        $permissions = $this->Permissions->find('all', array('conditions' => '', 'order' => 'perm_desc ASC'));
        $this->set('permissions', $permissions);

        if ($this->request->is('post')) {
            
			$roles = $this->Roles->find('first', array('conditions' => array('role_name' => $this->request->data['Userroles']['role_name'])));
			
            if (empty($roles)) {
                
				$this->request->data['Userroles']['role_name'] = trim($this->request->data['Userroles']['role_name']);
				//print_r($this->request->data);
				//exit;
                
                $this->Userroles->save($this->request->data);
				//echo "here..";
				//exit;
                $role_id = $this->Userroles->getLastInsertID();
				//echo "R ID: ".$role_id;
				//exit;
                
				
				if (!empty($this->request->data['Roleperm']['perm_id'])) {
					foreach ($this->request->data['Roleperm']['perm_id'] as $permission) {
						$this->request->data['Roleperm']['role_id'] = $role_id;
						$this->request->data['Roleperm']['perm_id'] = $permission;
						//echo $permission;
						//echo "<pre>";
						//print_r($this->request->data['Roleperm']);
						$this->Roleperm->saveAll($this->request->data['Roleperm']);
					}
				}
                    
                
               

                $this->Session->setFlash('<div class="success msg">Record save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Role already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        
		$permissions = $this->Permissions->find('all', array('conditions' => '', 'order' => 'perm_desc ASC'));
        $this->set('permissions', $permissions);
		
        $new_perms = $this->Roleperm->find('all', array('conditions' => array('role_id' => $this->params['pass']['0'])));
		//print_r($new_perms);
		//exit;
        $this->set('new_perms', $new_perms);
		
		$role = $this->Userroles->find('first', array('conditions' => array('role_id' => $this->params['pass']['0'])));
        $this->set('role', $role);
        
        $role_id = $role['Userroles']['role_id'];

        if ($this->request->is('post')) {
            $check = $this->Roles->find('first', array('conditions' => array('role_name' => $this->request->data['Userroles']['role_name'], 'role_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Userroles']['role_id'] = $role['Userroles']['role_id'];
                $this->request->data['Userroles']['role_name'] = trim($this->request->data['Userroles']['role_name']);
			
                $this->Userroles->save($this->request->data);
				
				if (!empty($this->request->data['Roleperm']['perm_id'])) {
					$this->Roleperm->deleteAll(array('role_id' => $this->params['pass']['0']));
					foreach ($this->request->data['Roleperm']['perm_id'] as $permission) {
						$this->request->data['Roleperm']['role_id'] = $role_id;
						$this->request->data['Roleperm']['perm_id'] = $permission;
						//echo $permission;
						//echo "<pre>";
						//print_r($this->request->data['Roleperm']);
						$this->Roleperm->saveAll($this->request->data['Roleperm']);
					}
				}
				
				//exit;
				

                $this->Session->setFlash('<div class="success msg">Role save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Role already exits.</div>', '');
            }
        }
    }
	

}
