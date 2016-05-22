<?php

App::uses('AppController', 'Controller');

/**
 * Contactuses Controller
 *
 * @property Contactus $Contactus
 * @property PaginatorComponent $Paginator
 * @property yComponent $y
 * @property SessionComponent $Session
 */
class ContactusesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Contactus', 'Staticpage', 'Adminuser');
    public $layout = 'webpage';

    public function contact() {
        $content = $this->Staticpage->find('first', array('conditions' => array('link' => $this->request->url)));
        $this->set("static", $content);

        if ($this->request->is('post')) {

            $this->Contactus->save($this->request->data);
            $emailcontent = $this->Emailcontent->find('first', array('conditions' => array('eid' => '7')));
            $to = $this->request->data['Contactus']['email'];
            $name = $this->request->data['Contactus']['name'];
            $message = str_replace(array('{name}'), array($name), $emailcontent['Emailcontent']['content']);
            $this->mailsend($emailcontent['Emailcontent']['fromname'], $emailcontent['Emailcontent']['fromemail'], $to, $emailcontent['Emailcontent']['subject'], $message);
            $this->Session->setFlash('<div class="success msg">' . __('Your message received. We will contact you soon.', true) . '</div>', '');
        }
    }

    public function admin_index() {
        $this->layout = 'admin';
        $this->checkadmin();
        $this->Contactus->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }
        if ($this->request->query('search') != '') {
            $search = array();
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array_merge($search, array('Contactus.created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\''));
                //$this->paginate = array('conditions' => );	
            } elseif ($this->request->query('cdate') != '') {
                $search = array_merge($search, array('Contactus.created_date >=' => $this->request->query('cdate')));
            } elseif ($this->request->query('edate') != '') {
                $search = array_merge($search, array('Contactus.created_date <=' => $this->request->query('edate')));
            }
            $search = array_merge($search);
            $this->paginate = array('conditions' => $search, 'order' => 'Contactus.contact_id DESC');
            $this->set('contact', $this->paginate('Contactus'));
        } else {
            $this->paginate = array('conditions' => '', 'order' => 'Contactus.contact_id DESC');
            $this->set('contact', $this->Paginator->paginate('Contactus'));
        }
    }

    public function admin_view() {
        $this->layout = 'admin';
        $this->checkadmin();
        $contact = $this->Contactus->find('first', array('conditions' => array('contact_id' => $this->params['pass']['0'])));
        if ($contact['Contactus']['view'] == '0') {
            $this->Contactus->updateAll(array('view' => '1'), array('contact_id' => $this->params['pass']['0']));
        }
        $this->set('contact', $contact);
        //print_r($this->data);exit;
        if (!empty($this->data)) {
            $this->request->data['Contactus']['contact_id'] = $this->params['pass']['0'];
            $this->request->data['Contactus']['replydate'] = date('Y-m-d H:i:s');
            $this->request->data['Contactus']['reply'] = '1';
            $this->Contactus->save($this->request->data);
            $this->set('message', $this->request->data['Contactus']['replymessage']);
            $message = $this->request->data['Contactus']['replymessage'] . '<br><br><br><br><br><br><br>
							  <br/><strong>Regards,<br>
								' . SITE_NAME . '<br><br>';
            $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));

            $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $this->request->data['Contactus']['email'], $this->request->data['Contactus']['replysubject'], $message);

            $this->Session->setFlash('<div class="success msg">Message sent successfully.</div>', '');
            $this->redirect(array('action' => 'view', $this->params['pass']['0']));
        }
    }
	
	
	
	 public function admin_contactus_export($cdate,$edate) {
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "contactus_details.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
		if($cdate == 0 && $edate == 0){			
			$results = $this->Contactus->find('all');	
		}else if($cdate==0){		
			$results = $this->Contactus->find('all', array('conditions' => array('created_date <='=>$edate)));	
		}else if($edate==0){		
			$results = $this->Contactus->find('all', array('conditions' => array('created_date >='=>$cdate)));	
		}else if($cdate != 0 && $edate != 0){				
			$results = $this->Contactus->find('all', array('conditions' => array('created_date >='=>$cdate,'created_date <='=>$edate)));		
		}
        $header_row = array("S.No","Type","Name","Email","Phone","City","Message","Created Date");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {
           
            $row = array(
                $i,
                $results['Contactus']['type'],
                $results['Contactus']['name'],
                $results['Contactus']['email'],
                $results['Contactus']['mobile'],
                $results['Contactus']['city'],
				$results['Contactus']['query'],
                $results['Contactus']['created_date'],
                );

            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }
	

}
