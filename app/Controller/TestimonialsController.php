<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TestimonialsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Image');
    public $uses = array('Testimonial', '');
    public $layout = 'admin';
	 /*List  Testimonial */
    public function admin_index() {
        $this->checkadmin();
        $this->Testimonial->recursive = 0;	
		$cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
		if (isset($this->request->data['searchfilter_news'])) {   
			$search_loc = array();         
  			if ($this->request->data['cdate'] != '') {     
				$search_loc[] = 'cdate=' . $this->request->data['cdate'];  
			}      
			if ($this->request->data['edate'] != '') {      
				$search_loc[] = 'edate=' . $this->request->data['edate'];     
			}      
			if (!empty($search_loc)) {   
				$this->redirect(array('action' => 'index/'.$this->params['pass']['0'].'?search_news=1&' . implode('&', $search_loc)));
			}      
		}

		//echo $this->params['pass']['0'];exit;
		if ($this->request->query('search_news') != '') {     
			$search = array();				
			$search= array('status ' => 'Active');		
			if (($this->request->query('cdate') != '') && ($this->request->query('edate'))) {  
				$search = array_merge($search, array('created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\''));      
			} elseif ($this->request->query('edate') != '') {   
				$search = array_merge($search, array('created_date <=' => $this->request->query('edate')));
			} elseif ($this->request->query('cdate')) {      
				$search = array_merge($search, array('created_date >=' => $this->request->query('cdate')));
			}    
				$condition = $search;      
			} else { 
				$condition = array('status !=' => 'Trash');    
			}

			
			//echo $cms; 
			$cms = ($cms == "Testimonial") ? "Testimonial" : "Customer says";
			//echo $cms;exit; 
			$condition = array_merge($condition, array("type = '$cms'"));
			$this->paginate = array('conditions' => $condition, 'order' => 'test_id DESC'); 
			$this->set('cms', $cms);		
			$this->set('testimonial', $this->Paginator->paginate('Testimonial'));		
		/*search redirect*/       /*  $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));		echo $cms; */
       /*  if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => 'index/' . $this->params['pass']['0'] . '?search=1&searchterm=' . $this->request->data['searchterm']));
        } */
		/*query for search*/

      /*   if ($this->request->query('search') != '') {
            $conditions = array('name LIKE' => '%' . $this->request->query('searchterm') . '%', 'status !=' => 'Trash', 'type' => $cms);
        } else {
            $conditions = array('status !=' => 'Trash', 'type' => $cms);
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'test_id DESC');
        $this->set('testimonial', $this->Paginator->paginate('Testimonial')); */
    }
	/*Add Testimonial */
	public function admin_testi_export($cdate,$edate) {   
		$this->layout = '';    
		$this->render(false);   
		ini_set('max_execution_time', 600);    
		$filename = "testimonial.csv";     
		$csv_file = fopen('php://output', 'w');   
		header('Content-type: application/csv');   
		header('Content-Disposition: attachment; filename="' . $filename . '"');	
		$search = array('status ' => 'Active');	
			if ($cdate != 0 && $edate != 0) {	
				$search = array_merge($search, array('created_date BETWEEN \'' . $cdate . '\' AND \'' . $edate . '\''));
			} elseif ($edate != 0) {
				$search = array_merge($search, array('created_date <=' => $edate));	
			} elseif ($cdate !=0) {	
				$search = array_merge($search, array('created_date >=' => $cdate));	
			}			
			$results = $this->Testimonial->find('all', array('conditions' => $search));   
			$header_row = array("S.No", "Name", "Status", "Created date");    
			fputcsv($csv_file, $header_row, ',', '"');    
			$i = 1;  
			foreach ($results as $results) {  
				$row = array( $i,$results['Testimonial']['name'],$results['Testimonial']['status'],$results['Testimonial']['created_date']);
				$i++; 
				fputcsv($csv_file, $row, ',', '"');  
			}    
		fclose($csv_file);  
	}
    public function admin_add() {
        $this->checkadmin();
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if ($this->request->is('post')) {
            $test = $this->Testimonial->find('first', array('conditions' => array('name' => $this->request->data['Testimonial']['name'], 'type' => $cms, 'status !=' => 'Trash')));
            if (empty($test)) {
                if (!empty($this->request->data['Testimonial']['images']['name'])) {
					/*$this->request->data['Testimonial']['image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Testimonial']['images'], 800, 800, 112, 126, "testimonial");*/
                    extract($this->request->data['Testimonial']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/testimonial/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Testimonial']['image'] = $imagename;
                    }
                }
                $this->request->data['Testimonial']['status'] = 'Active';
                $this->request->data['Testimonial']['type'] = $cms;
                $this->request->data['Testimonial']['created_date'] = date('Y-m-d H:i:s');
                $this->Testimonial->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">' . $cms . ' added successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            } else {
                $this->Session->setFlash('<div class="error msg">' . $cms . ' name already exits.</div>', '');
            }
        }
        $this->set('cms', $cms);
    }
	/*Edit  Testimonial */
    public function admin_edit($cms, $id = null) {
        $this->checkadmin();
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));

        $test = $this->Testimonial->find('first', array('conditions' => array('test_id' => $id)));
        $this->set('test', $test);
        $this->set('cms', $cms);
        if ($this->request->is('post')) {
			          $check = $this->Testimonial->find('first', array('conditions' => array('name' => $this->request->data['Testimonial']['name'], 'status !=' => 'Trash', 'type' => $cms, 'test_id !=' => $id)));
            if (empty($check)) {
                $this->request->data['Testimonial']['test_id'] = $id;
			/*File Upload*/
                if (!empty($this->request->data['Testimonial']['images']['name'])) {
                    extract($this->request->data['Testimonial']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/testimonial/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Testimonial']['image'] = $imagename;
                    }
					//$this->request->data['Testimonial']['image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Testimonial']['images'], 800, 800, 112, 126, "testimonial");
                }else{
					$this->request->data['Testimonial']['image']=$test['Testimonial']['image'];
				}
                $this->request->data['Testimonial']['type'] = $cms;
                $this->Testimonial->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">' . $cms . ' updated successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            } else {
                $this->Session->setFlash('<div class="error msg">' . $cms . ' name already exits.</div>', '');
            }
        }
    }
	/*Delete  Testimonial */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Testimonial  Delete*/
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if (!empty($this->params['pass']['1'])) {
            $this->request->data['Testimonial']['test_id'] = $this->params['pass']['1'];
            $this->request->data['Testimonial']['status'] = 'Trash';
            $this->Testimonial->updateAll(array('status' => "'Trash'"), array('test_id' => $this->params['pass']['1']));
            $this->Session->setFlash('<div class="success msg">' . $cms . ' has been deleted successfully.</div>', '');
            $this->redirect(array('action' => 'index', $this->params['pass']['0']));
        } else {
			/*Multiple Testimonial  Delete*/
            if (!empty($this->request->data['action'])) {
                $array = array_filter($this->request->data['action']);
                $this->Testimonial->updateAll(array('status' => "'Trash'"), array('test_id' => $array));
                $this->Session->setFlash('<div class="success msg">' . $cms . ' has been deleted successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            }
        }
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }
	/*Change Status  Testimonial */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Testimonial']['test_id'] = $this->params['pass']['1'];
        $this->request->data['Testimonial']['status'] = $this->params['pass']['2'];
        $this->Testimonial->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . ucwords(str_replace('_', ' ', $this->params['pass']['0'])) . ' ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }

}
