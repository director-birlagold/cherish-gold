<?php

App::uses('AppController', 'Controller');

/**
 * Staticpages Controller
 *
 * @property Staticpage $Staticpage
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class StaticpagesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $uses = array('Adminuser', 'Staticpage');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
	 /*List Staticpages*/
    public function admin_index() {
        $this->checkadmin();
        $this->Staticpage->recursive = 0;
        $this->set('staticpages', $this->paginate('Staticpage'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
	 /*Add  Staticpages*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->request->data['Staticpage']['link'] = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Staticpage']['pagename'])));
            $check = $this->Staticpage->find('first', array('conditions' => array('link' => $this->request->data['Staticpage']['link'])));
            if (empty($check)) {
                $this->Staticpage->save($this->request->data['Staticpage']);
                $this->Session->setFlash('<div class="success msg">' . __('Content Page added successfully') . '.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">' . __('Content Page already exists') . '.</div>', '');
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
	  /*Edit  Staticpages*/
    public function admin_edit($id = null) {
        $this->checkadmin();
        if (!$this->Staticpage->exists($id)) {
            throw new NotFoundException(__('Invalid staticpage'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Staticpage']['link'] = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Staticpage']['pagename'])));
            $check = $this->Staticpage->find('first', array('conditions' => array('link' => $this->request->data['Staticpage']['link'], 'staticpage_id !=' => $id)));
            if (empty($check)) {
                $this->request->data['Staticpage']['staticpage_id'] = $id;
                $this->Staticpage->save($this->request->data['Staticpage']);
            } else {
                $this->Session->setFlash('<div class="error msg">' . __('Content Page name already exists') . '.</div>', '');
                $this->redirect(array('action' => 'edit', $this->params['pass'][0], $this->params['pass'][1]));
            }
        }

        $options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));
        $this->request->data = $this->Staticpage->find('first', $options);
    }
	/*View the Staticpage*/
    public function staticpage() {
        $this->layout = 'frontend';
        //$content=$this->Staticpage->find('first',array('conditions'=>array('pagename'=>$this->request->params['url']['url'])));
        //print_r($this->request->url);exit;
        $content = $this->Staticpage->find('first', array('conditions' => array('link' => $this->request->url)));

        $this->set('title', $content['Staticpage']['meta_title']);
        $this->set('metakeyword', $content['Staticpage']['meta_keyword']);
        $this->set('metadescription', $content['Staticpage']['meta_description']);
        $this->set("static", $content);
        //print_r($content);exit;
    }

}
