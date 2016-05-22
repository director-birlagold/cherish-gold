<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class LocateusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Locateus', 'Cities', 'States','User');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Locateus->recursive = 0;
        if (isset($this->request->data['searchfilter_loc'])) {
            $search_loc = array();
            if ($this->request->data['searchname'] != '') {
                $search_loc[] = 'searchname=' . $this->request->data['searchname'];
            }if ($this->request->data['searchemail'] != '') {
                $search_loc[] = 'searchemail=' . $this->request->data['searchemail'];
            }/* if ($this->request->data['searchphone'] != '') {
                $search_loc[] = 'searchphone=' . $this->request->data['searchphone'];
            } */
			if ($this->request->data['cdate'] != '') {
                $search_loc[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search_loc[] = 'edate=' . $this->request->data['edate'];
            }
            if (!empty($search_loc)) {
                $this->redirect(array('action' => '?search_loc=1&' . implode('&', $search_loc)));
            }
        }

        if ($this->request->query('search_loc') != '') {
            $search = array();
            $search = array('status !=' => 'Trash');
			 if (($this->request->query('cdate') != '') && ($this->request->query('edate'))) {
                $search = array_merge($search, array('created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\''));
            } elseif ($this->request->query('edate') != '') {
                $search = array_merge($search, array('created_date <=' => $this->request->query('edate')));
            } elseif ($this->request->query('cdate')) {
                $search = array_merge($search, array('created_date >=' => $this->request->query('cdate')));
            }
            if ($this->request->query('searchname') != '') {
                $search = array_merge($search, array('name LIKE ' => '%' . $_REQUEST['searchname'] . '%'));
            }

            if ($this->request->query('searchemail') != '') {
                $search = array_merge($search, array('email' => $_REQUEST['searchemail']));
            } //pr($search);exit;
            /* if ($this->request->query('searchphone') != '') {
                $search = array_merge($search, array('phone' => $_REQUEST['searchphone']));
            } */
            $condition = $search;
        } else {
            $condition = array('status !=' => 'Trash');
        }
		//print_r($condition);
        $this->paginate = array('conditions' => $condition, 'order' => 'locateus_id DESC');
        $this->set('locateus', $this->Paginator->paginate('Locateus'));
    }

    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {

            /* $statevalue=$this->States->find('first',array('first',array('conditions'=>array('state_id'=>$this->request->data['Locateus']['state']))));
              $this->request->data['Locateus']['state']=$statevalue['States']['state']; */
            $this->request->data['Locateus']['status'] = 'Active';
            $this->request->data['Locateus']['created_date'] = date("Y-m-d H:i:s");
            $this->Locateus->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Locate us details has been added successfully') . "</div>", '');
            $this->redirect(array('controller' => 'locateus', 'action' => 'index'));
        }
        $state = $this->States->find('list', array('conditions' => array('status' => 'Active'), 'fields' => array('state_id', 'state')));
        $this->set('state', $state);
    }

    public function admin_edit($id) {
        $this->checkadmin();
        if (!$this->Locateus->exists($id)) {
            throw new NotFoundException(__('Invalid Locateus'));
        }
        $locateus = $this->Locateus->find('first', array('conditions' => array('locateus_id' => $this->params['pass']['0'])));

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Locateus']['locateus_id'] = $this->params['pass'][0];
            $this->Locateus->save($this->request->data);
            $this->Session->setFlash('<div class="success msg">Locate us details updated successfully.</div>', '');
            $this->redirect(array('action' => 'index'));
        } else {
            //$this->request->data=$locateus;
            $this->set('locateus', $locateus);
        }
        $state = $this->States->find('list', array('conditions' => array('status' => 'Active'), 'fields' => array('state_id', 'state')));
        $this->set('state', $state);
    }

    public function admin_delete() {
        if (!empty($this->params['pass']['0'])) {
            $this->request->data['Locateus']['locateus_id'] = $this->params['pass']['0'];
            $this->request->data['Locateus']['status'] = 'Trash';
            $this->Locateus->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Locate us details has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                //pr($this->request->data['action']);exit;
                $array = array_filter($this->request->data['action']);
                $this->Locateus->updateAll(array('status' => "'Trash'"), array('locateus_id' => $array));
                /* foreach($this->request->data['action'] as $loct){
                  if($loct >0){
                  $locateus=$this->Locateus->find('first',array('conditions'=>array('locateus_id'=>$loct)));
                  $this->request->data['Locateus']['locateus_id']=$locateus;
                  $this->request->data['Locateus']['status']='Trash';
                  $this->Locateus->saveAll($this->request->data);
                  }
                  } */

                $this->Session->setFlash("<div class='success msg'>" . __('Locate us details has been deleted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Locateus']['locateus_id'] = $this->params['pass']['0'];
        $this->request->data['Locateus']['status'] = $this->params['pass']['1'];
        $this->Locateus->save($this->request->data);

        $this->Session->setFlash('<div class="success msg"> ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

    public function register_state() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $this->request->data;
            $city = $this->Cities->find('all', array('conditions' => array('state_id' => $id)));
            if (!empty($city)) {
                echo json_encode($city);
            } else {
                echo '[]';
            }
        }
    }

    public function select_city() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $this->request->data;
            $city = $this->City->find('all', array('conditions' => array('state_id' => $id)));
            if (!empty($city)) {
                echo json_encode($city);
            } else {
                echo '[]';
            }
        }
    }

    public function locate_us() {
        $this->layout = 'frontend';
        $locateus = $this->User->find('all', array('conditions' => array('user_type' => '1', 'status !=' => 'Trash')));
        $this->set('locateus', $locateus);
if (isset($this->request->params['named']['search'])) {
	if ($this->request->params['named']['search'] != '') {
            $search = array();
            $search = array('user_type' => '1', 'status !=' => 'Trash');	
			
           
            if ($this->request->params['named']['zipcode'] != '') {
			//SELECT *
//FROM `entries` where entries LIKE '%,data' OR entries LIKE '%data,%' OR entries LIKE 'data'
               // $search = array_merge($search, array('pincode ' => $this->request->params['named']['zipcode']));
			  // $search = array_merge($search, array('OR'=>array('pincode LIKE ' => '%,'.$this->request->params['named']['zipcode'],'pincode LIKE ' => '%'.$this->request->params['named']['zipcode'].',%','pincode LIKE ' => '%'.$this->request->params['named']['zipcode'].'%')));
			  //$search = array_merge($search, array('OR'=>array('pincode LIKE ' => '%,'.$this->request->params['named']['zipcode'].' pincode LIKE ' => '%'.$this->request->params['named']['zipcode'].',%'.' pincode LIKE ' => $this->request->params['named']['zipcode'])));
			   /* $search = array_merge($search,array('AND' => array(
            'OR' => array(
                // topic
                array('pincode LIKE' => '%,'.$this->request->params['named']['zipcode']),
                array('pincode LIKE' => '%'.$this->request->params['named']['zipcode'].',%'),
                array('pincode LIKE' => $this->request->params['named']['zipcode'])
            )
        ))); */
		$search=array('user_type' => '1', 'status !=' => 'Trash','AND' => array(
        array(
            'OR' => array(
                // topic
                 array('pincode LIKE' => '%,'.$this->request->params['named']['zipcode']),
                array('pincode LIKE' => '%'.$this->request->params['named']['zipcode'].',%'),
                array('pincode LIKE' => $this->request->params['named']['zipcode'])
            )
        )));
			  //$search = array_merge($search, array('OR'=>array()));
			  //$search = array_merge($search, array('OR'=>array()));
               /*  $search = array_merge($search, array('pincode LIKE ' => '%,'.$this->request->params['named']['zipcode']));
                $search = array_merge($search, array('OR pincode LIKE ' => '%'.$this->request->params['named']['zipcode'].',%'));
                $search = array_merge($search, array('OR pincode LIKE ' => '%'.$this->request->params['named']['zipcode'].'%')); */
            }
			//print_r($search);
			//die;
            $locateus = $this->User->find('all', array('conditions' => $search));
            $this->set('locateus', $locateus);
        } else {
            $locateus = $this->User->find('all', array('conditions' => array('user_type' => '1', 'status !=' => 'Trash')));

            $this->set('locateus', $locateus);
        }
}else{
        if (isset($this->request->data['search'])) {
            $search = array();	
			/* if ($this->request->data['zipcode'] != '') {
                $search[] = 'zipcode=' . $this->request->data['zipcode'];
            } */ 
			if ($this->request->data['servicestate'] != '') {
                $search[] = 'servicestate=' . $this->request->data['servicestate'];
            }if ($this->request->data['servicecity'] != '') {
                $search[] = 'servicecity=' . $this->request->data['servicecity'];
            }
			if (!empty($search)) {
                $this->redirect(array('action' => 'locate_us?search=1&' . implode('&', $search)));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('user_type' => '1', 'status !=' => 'Trash');	
			
			if (($this->request->query('servicestate') != '') && ($this->request->query('servicecity') != '')) {
				$city=$this->Cities->find('first',array('conditions'=>array('city_id'=>$this->request->query('servicecity'))));
				$state=$this->States->find('first',array('conditions'=>array('state_id'=>$this->request->query('servicestate'))));
               // $search = array_merge($search, array('state' => $state, 'city' => $city));
				
				$search['city LIKE'] = '%' . $city['Cities']['city'] . '%';
				
				$search['state LIKE'] = '%' . $state['States']['state'] . '%';
            }
            if ($this->request->query('servicecity') != '') {
                $city=$this->Cities->find('first',array('conditions'=>array('city_id'=>$this->request->query('servicecity'))));
				$search['city LIKE'] = '%' . $city['Cities']['city'] . '%';
            }
            if ($this->request->query('servicestate') != '') {
               $state=$this->States->find('first',array('conditions'=>array('state_id'=>$this->request->query('servicestate'))));
			   
				$search['state LIKE'] = '%' . $state['States']['state'] . '%';
				
               // $search = array_merge($search, array('state' => $state, 'city' => $city));
				
				
            }
           
           /*  if ($this->request->query('zipcode') != '') {
                $search = array_merge($search, array('pincode' => $_REQUEST['zipcode']));
            } */
			//print_r($search);
            $locateus = $this->User->find('all', array('conditions' => $search));
            $this->set('locateus', $locateus);
        } else {
            $locateus = $this->User->find('all', array('conditions' => array('user_type' => '1', 'status !=' => 'Trash')));

            $this->set('locateus', $locateus);
		}
	}
        $state = $this->States->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('state', $state);
    }	 
	public function admin_locate_export($cdate,$edate) {
			$this->layout = '';     
			$this->render(false);    
			ini_set('max_execution_time', 600);		 
			$filename = "locateus_details.csv";
			$csv_file = fopen('php://output', 'w');   
			header('Content-type: application/csv');  
			header('Content-Disposition: attachment; filename="' . $filename . '"');	
			if($cdate == 0 && $edate == 0){		
				$results = $this->Locateus->find('all', array('conditions' => array('status ' => 'Active')));
			}else if($cdate==''){	
				$results = $this->Locateus->find('all', array('conditions' => array('status ' => 'Active','created_date <='=>$edate)));	
			}else if($edate==''){
				$results = $this->Locateus->find('all', array('conditions' => array('status ' => 'Active','created_date >='=>$cdate)));	
			}else{		
				$results = $this->Locateus->find('all', array('conditions' => array('status ' => 'Active','created_date >='=>$cdate,'created_date <='=>$edate)));
			}     
			$header_row = array("S.No", "Name", "State", "City", "Email", "Created Date");  
				fputcsv($csv_file, $header_row, ',', '"');   
				$i = 1;      
				foreach ($results as $results) {		
					$city=$this->Cities->find('first',array('conditions'=>array('city_id'=>$results['Locateus']['city'])));	
					$state=$this->States->find('first',array('conditions'=>array('state_id'=>$results['Locateus']['state'])));
					$row = array( 
						$i,  
						$results['Locateus']['name'],
						$state['States']['state'],
						$city['Cities']['city'], 
						$results['Locateus']['email'],
						$results['Locateus']['created_date']
					); 
					$i++;  
					fputcsv($csv_file, $row, ',', '"');
				} 
				fclose($csv_file); 
		}

    public function register_state1() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $city = $this->Cities->find('all', array('conditions' => array('state_id' => $id)));
            if (!empty($city)) {
                echo json_encode($city);
            } else {
                echo '[]';
            }
        }
    }

    public function get_data() {

        if ($this->request->is('ajax')) {

            $this->layout = '';
            $this->render(false);
            $page = $_REQUEST['p'];

            $current_page = $page - 1;
            $records_per_page = 1;
            $start = $current_page * $records_per_page;
            $locateus = $this->Locateus->find('all', array('conditions' => array('status !=' => 'Trash'), 'limit' => $records_per_page, 'offset' => $start));
            //$this->set('locateus',$locateus);
            //pr($locateus);exit;
            $t = '';
            foreach ($locateus as $locateus) {

                $state = $this->States->find('first', array('conditions' => array('status' => 'Active', 'state_id' => $locateus['Locateus']['state'])));

                $city = $this->Cities->find('first', array('conditions' => array('status' => 'Active', 'city_id' => $locateus['Locateus']['city'])));

                $phone = explode(",", $locateus['Locateus']['phone']);
                $fax = explode(",", $locateus['Locateus']['fax']);

                foreach ($phone as $p1) {
                    $p1 . '<br>';
                }

                foreach ($fax as $f1) {
                    $f1 . '<br>';
                }

                $t.='<tr>
                    <td class="tdBorderR">' . $locateus['Locateus']['name'] . '</td><td class="tdBorderR">' . $locateus['Locateus']['address'] . '</td> <td class="tdBorderR">' . $city['Cities']['city'] . '<br>' . $state['States']['state'] . '</td> <td class="tdBorderR">' . $locateus['Locateus']['email'] . '</td> <td class="tdBorderR">' . $p1 . '</td><td class="tdBorderR">' . $f1 . '</td> </tr>';
            }

            //echo $t;
            //print_r($t);

            echo json_encode($t);
            exit;
        }
    }

}
