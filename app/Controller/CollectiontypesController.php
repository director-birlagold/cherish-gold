<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CollectiontypesController extends AppController {

    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Collectiontype');
    public $layout = 'admin';
	/*Add Payu */
    public function admin_collectiontype() {
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) { 
			$this->request->data['Collectiontype']['collectiontype_id']=$this->params['pass']['0'];
			$this->request->data['Collectiontype']['collection_name']=$this->request->data['Collectiontype']['collection_name']; 
		 	$this->Collectiontype->save($this->request->data);	 
		           
            $this->Session->setFlash('<div class="success msg">Updated Successfully</div>');
            $this->redirect(array('action' => 'index'));
        }
        $collectiontype = $this->Collectiontype->find('first', array('conditions' =>array('collectiontype_id'=>$this->params['pass']['0'])));
        $this->set('collectiontype',$collectiontype);
		    }
			
			
			 public function admin_index() {
        $this->checkadmin();
        $this->Collectiontype->recursive = 0;
        $this->paginate = array('order' => 'collectiontype_id ASC');
        $this->set('collectiontype', $this->Paginator->paginate('Collectiontype'));
    }
			
			
			

}
