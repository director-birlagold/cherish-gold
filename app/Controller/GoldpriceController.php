<?php

App::uses('AppController', 'Controller');

/**
 * GoldPriceController Controller
 *
 * @property RelationshipManager $RelationshipManager
 * @property PaginatorComponent $Paginator
 */
class GoldpriceController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Cookie', 'Image');
    public $uses = array('GoldPrice', 'CustomerBGP','Adminuser','Referral');
    public $layout = 'admin';

    public function admin_index() {	
		$this->layout = 'admin';   
		$this->checkadmin();
			if (isset($this->request->data['searchfilter'])) {    
			$search = array();
				if ($this->request->data['searchdate'] != '') {   
					$search[] = 'searchdate=' . $this->request->data['searchdate']; 
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
					 if (!empty($_REQUEST['searchdate'])) {

						$search['gold_date LIKE'] = '%' . $this->request->query('searchdate') . '%';
					}
				}      
		
		 $this->paginate = array('conditions' => $search, 'order' => 'GoldPrice.id DESC');
            $this->set('gold', $this->Paginator->paginate('GoldPrice'));
    }
	
	public function admin_edit() {
        $this->checkadmin();

        if ($this->request->is('post')) {
           
            $check = $this->GoldPrice->find('first', array('conditions' => array(
                    'gold_date' => $_POST["data"]['GoldPrice']['gold_date'],
                    'id !=' => $_POST["data"]['GoldPrice']['id']
                )
            ));

            if (empty($check)) {
                	
                $this->GoldPrice->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Gold Price updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Date already exits.</div>', '');
            }
        }
        $gold = $this->GoldPrice->find('first', array('conditions' => array('id' => $this->params['pass']['0'])));
        $this->set('gold', $gold);
    }
	
	public function admin_add() {
        $this->checkadmin();

        if ($this->request->is('post')) {
           
            $check = $this->GoldPrice->find('first', array('conditions' => array(
                    'gold_date' => $this->request->data['GoldPrice']['gold_date']
                )
            ));

            if (empty($check)) {           	
                $this->GoldPrice->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Gold Price added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Date already exits.</div>', '');
            }
        }
    }
	
	

}
