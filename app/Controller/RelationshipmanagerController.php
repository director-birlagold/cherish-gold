<?php

App::uses('AppController', 'Controller');

/**
 * RelationshipManager Controller
 *
 * @property RelationshipManager $RelationshipManager
 * @property PaginatorComponent $Paginator
 */
class RelationshipManagerController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Cookie', 'Image');
    public $uses = array('RelationshipManager', 'CustomerBGP','Adminuser','Referral');
    public $layout = 'admin';

    public function admin_index() {	
		$this->layout = 'admin';   
		$this->checkadmin();
			if (isset($this->request->data['searchfilter'])) {    
			$search = array();
				if ($this->request->data['searchmanager'] != '') {   
					$search[] = 'searchmanager=' . $this->request->data['searchmanager']; 
				}   
				
				 if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
				} else {
					$this->redirect(array('action' => 'index'));
				}
			}     		
				$search = array();
				if ($this->request->query('search') != '') 
				{
					 if (!empty($_REQUEST['searchmanager'])) {

						$search['manager_name LIKE'] = '%' . $this->request->query('searchmanager') . '%';
					}
				}      
		
		 $this->paginate = array('conditions' => $search, 'order' => 'RelationshipManager.manager_id DESC');
            $this->set('relation', $this->Paginator->paginate('RelationshipManager'));
    }
	
	public function admin_distributor($id) {	
		$this->layout = 'admin';   
		$this->checkadmin();
			 if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchemail'] != '') {
                $search[] = 'searchemail=' . $this->request->data['searchemail'];
            }
			if ($this->request->data['searchphone'] != '') {
                $search[] = 'searchphone=' . $this->request->data['searchphone'];
            }
			
			if ($this->request->data['searchapplication'] != '') {
                $search[] = 'searchapplication=' . $this->request->data['searchapplication'];
            }
			
			if ($this->request->data['searchpartner'] != '') {
                $search[] = 'searchpartner=' . $this->request->data['searchpartner'];
            }
			if ($this->request->data['searchname'] != '') {
                $search[] = 'searchname=' . $this->request->data['searchname'];
            }
			if ($this->request->data['searchpayby'] != '') {
                $search[] = 'searchpayby=' . $this->request->data['searchpayby'];
            }
			
			if ($this->request->data['searchstatus'] != '') {
                $search[] = 'searchstatus=' . $this->request->data['searchstatus'];
            }
			
			
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        
		$search = array();
		$search['distributor LIKE'] = "yes";
		$search['relationship_manager'] = $id;
		
		 if ($this->request->query('search') != '') {
            if (!empty($_REQUEST['searchemail'])) {

                $search['contact_email LIKE'] = '%' . $this->request->query('searchemail') . '%';
            }
			if (!empty($_REQUEST['searchphone'])) {

                $search['contact_mobile LIKE'] = '%' . $this->request->query('searchphone') . '%';
            }
			
			if (!empty($_REQUEST['searchapplication'])) {

                $search['application_no LIKE'] = '%' . $this->request->query('searchapplication') . '%';
            }
			if (!empty($_REQUEST['searchpartner'])) {

                $search['partner_code LIKE'] = '%' . $this->request->query('searchpartner') . '%';
            }
			if (!empty($_REQUEST['searchname'])) {

                $search['applicant_name LIKE'] = '%' . $this->request->query('searchname') . '%';
            }
			if (!empty($_REQUEST['searchpayby'])) {

                $search['initial_pay_by LIKE'] = '%' . $this->request->query('searchpayby') . '%';
            }if (!empty($_REQUEST['searchstatus'])) {

                $search['approve_status LIKE'] = '%' . $this->request->query('searchstatus') . '%';
            }
			
		 }
		 $this->paginate = array('conditions' => $search,
								'joins' => array(
									array(
										'alias' => 'payment',
										'table' => 'payment_master',
										'type' => 'left',
										'conditions' => array('payment.mer_txn = CustomerBGP.application_no','payment.udf9 = 1' )
									)
								), 'order' => 'CustomerBGP.customer_id DESC');
            $this->set('customer', $this->Paginator->paginate('CustomerBGP'));
    }
	
	public function admin_referral($id) {	
		$this->layout = 'admin';   
		$this->checkadmin();
			 if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchemail'] != '') {
                $search[] = 'searchemail=' . $this->request->data['searchemail'];
            }
			if ($this->request->data['searchphone'] != '') {
                $search[] = 'searchphone=' . $this->request->data['searchphone'];
            }
			
			if ($this->request->data['searchmobile'] != '') {
                $search[] = 'searchmobile=' . $this->request->data['searchmobile'];
            }
			
			if ($this->request->data['searchname'] != '') {
                $search[] = 'searchname=' . $this->request->data['searchname'];
            }
			
			if ($this->request->data['searchstatus'] != '') {
                $search[] = 'searchstatus=' . $this->request->data['searchstatus'];
            }
			
			
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        
		$search = array();
		$search['distributor_id'] = $id;
		
		 if ($this->request->query('search') != '') {
            if (!empty($_REQUEST['searchemail'])) {

                $search['contact_email LIKE'] = '%' . $this->request->query('searchemail') . '%';
            }
			if (!empty($_REQUEST['searchphone'])) {

                $search['contact_phone LIKE'] = '%' . $this->request->query('searchphone') . '%';
            }
			
			if (!empty($_REQUEST['searchmobile'])) {

                $search['contact_mobile LIKE'] = '%' . $this->request->query('searchmobile') . '%';
            }
			if (!empty($_REQUEST['searchname'])) {

                $search['applicant_name LIKE'] = '%' . $this->request->query('searchname') . '%';
            }
			if (!empty($_REQUEST['searchstatus'])) {

                $search['approve_status LIKE'] = '%' . $this->request->query('searchstatus') . '%';
            }
			
		 }
		 $this->paginate = array('conditions' => $search, 'order' => 'Referral.referral_id DESC');
            $this->set('customer', $this->Paginator->paginate('Referral'));
    }
	
	public function admin_referraldetail($id)
	{
		 $this->checkadmin();
		$referral = $this->Referral->find('first', array('conditions' => array('referral_id' => $this->params['pass']['0'])));
        if ($this->request->is('post')) {
           
            $check = $this->Referral->find('first', array('conditions' => array(
                    'referral_id !=' => $this->params['pass']['0']
                )
            ));

            if (empty($check)) {
                $this->request->data['Referral']['referral_id'] = $this->params['pass']['0'];
           
               // $this->request->data['RelationshipManager']['manager_name'] = $page_link;
								
                $this->Referral->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Referral updated successfully.</div>', '');
                $this->redirect(array('action' => 'referral', $referral['Referral']['distributor_id']));
            } else {
                $this->Session->setFlash('<div class="error msg">Referral already exits.</div>', '');
            }
        }
        
        $this->set('referral', $referral);
	}
	
	
	public function admin_edit() {
        $this->checkadmin();

        if ($this->request->is('post')) {
           
            $check = $this->RelationshipManager->find('first', array('conditions' => array(
                    'manager_id !=' => $this->params['pass']['0']
                )
            ));

            if (empty($check)) {
                $this->request->data['RelationshipManager']['manager_id'] = $this->params['pass']['0'];
           
               // $this->request->data['RelationshipManager']['manager_name'] = $page_link;
								
                $this->RelationshipManager->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Relation Manager updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Relation Manager already exits.</div>', '');
            }
        }
        $relation = $this->RelationshipManager->find('first', array('conditions' => array('manager_id' => $this->params['pass']['0'])));
        $this->set('relation', $relation);
    }
	
	

}
