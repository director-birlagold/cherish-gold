<?php

App::uses('AppController', 'Controller');

/**
 * Smstemplates Controller
 *
 * @property Smstemplate $Smstemplate
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ShoppingassistanceController extends AppController {

    public $components = array('Paginator');
    public $uses = array('Adminuser', 'ShoppingAssistance');
    public $layout = 'admin';

    public function admin_index() 
	{
		$this->checkadmin();
        $this->ShoppingAssistance->recursive = 0;
        $this->paginate = array('conditions' => '');
		$this->set('ShoppingAssistance', $this->Paginator->paginate('ShoppingAssistance'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->ShoppingAssistance->create();
            $Shoppingassistance = $this->ShoppingAssistance->find('first', array('conditions' => array('title' => $this->request->data['Shoppingassistance']['title'], 'status !=' => 'Trash')));
            if (empty($Shoppingassistance)) {
                if ($this->request->data['ShoppingAssistance']['image']['name'] != '') {
                    extract($this->request->data['ShoppingAssistance']['image']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/shoppingAssistance/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['ShoppingAssistance']['image'] = $imagename;
                    }
                }
				
                if ($this->ShoppingAssistance->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __('Shopping Assistance added sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __('Shopping Assistance could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg">Shopping Assistance title  already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->ShoppingAssistance->exists($id)) {
            throw new NotFoundException(__('Invalid Shopping Assistance'));
        }
        $options = array('conditions' => array('ShoppingAssistance.' . $this->ShoppingAssistance->primaryKey => $id));
        $ShoppingAssistance = $this->ShoppingAssistance->find('first', $options);
        if ($this->request->is(array('post', 'put'))) {
            $check = $this->ShoppingAssistance->find('first', array('conditions' => array('title' => $this->request->data['ShoppingAssistance']['title'], 'shopping_assistance_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['ShoppingAssistance']['shopping_assistance_id'] = $id;
                if ($this->request->data['ShoppingAssistance']['image']['name'] != '') {

                    extract($this->request->data['ShoppingAssistance']['image']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/shoppingAssistance/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['ShoppingAssistance']['image'] = $imagename;
                    }
                }
                if ($this->ShoppingAssistance->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __('Shopping Assistance updated sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __('Shopping Assistance could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg">The Shopping Assistance title already exists</div>');
            }
        }

        $this->request->data = $ShoppingAssistance;
    }
	
	public function admin_delete($id = null) {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $this->ShoppingAssistance->id = $id;
        if (!$this->ShoppingAssistance->exists()) {
            throw new NotFoundException(__('Invalid Shopping Assistance id'));
        }
        //$this->request->onlyAllow('post', 'delete');
        $options = array('conditions' => array('ShoppingAssistance.' . $this->ShoppingAssistance->primaryKey => $id));
        $ShoppingAssistance = $this->ShoppingAssistance->find('first', $options);
        if (!empty($ShoppingAssistance['ShoppingAssistance']['image']))
            unlink('img/shoppingAssistance/' . $ShoppingAssistance['ShoppingAssistance']['image']);

        if ($this->ShoppingAssistance->delete()) {
            $this->Session->setFlash('<div class="success msg">' . __('Shopping Assistance deleted successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('<div class="error msg">' . __('Shopping Assistance was not deleted') . '</div>');
        $this->redirect(array('action' => 'index'));
    }

}
