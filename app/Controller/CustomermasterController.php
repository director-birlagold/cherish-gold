<?php

App::uses('AppController', 'Controller');
App::uses('Xml', 'Utility');
/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CustomermasterController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Mpdf','RequestHandler');
    public $uses = array('CustomerBGP','CustomerBGPCopy', 'RelationshipManager','PaymentMaster','Referral', 'Price','Adminuser','User', 'State', 'Accounttype', 'Proof', 'Nomination', 'Bankdetail', 'Payment', 'Outlet', 'Franchiseeproof', 'Officeuse', 'Otherdetail', 'Franchiseebrokerage','StateMaster');
	public $layout = 'admin';
	
	public function checkMail()
	{
		
		$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
			App::uses('CakeEmail', 'Network/Email');
				
					$email = new CakeEmail();
					$email->emailFormat('html');
					$email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
					
					$email->to(trim($_GET['email']));
					$subject = "";
					$email->subject(SITE_NAME . " Birla Gold Customer Registration");
					$message = "Mails are working";
					$email->attachments(array(WWW_ROOT.'documents/tempPDF/AC_1462619315.pdf'));
					$email->send($message);
					$email->reset();
					exit;
	}
	
	public function generateXML()
	{
		if($_GET["application_no"])
		{
			$application_no = $_GET["application_no"];
			$customer = $this->CustomerBGP->find("first",array("conditions" => array("application_no" => $application_no)));
			$payment = $this->PaymentMaster->find("all",array("conditions" => array("mer_txn" => $application_no)));
			if($payment)
			{
				$data = array();
				$data1 = array();
				$data2 = array();
				$xmlArray = array();
				foreach($payment as $key=>$pay)
				{
					$data["customer_id"] = $customer['CustomerBGP']['customer_id'];
					$data["application_no"] = $customer['CustomerBGP']['application_no'];
					$data["amount"] = $pay['PaymentMaster']['amt'];
					$data["pay_type"] = $pay['PaymentMaster']['udf9'];
					$data1["id"][] = $data;
				}
				$data2["admin"] = $data1;
				$xmlObject = Xml::fromArray($data2, array('format' => 'tags')); 
				$xmlString = $xmlObject->asXML();
				echo $xmlString;
			}
			else
			{
				echo "No Data Found";
			}
		}
		else
		{
			echo "Applicaiton Number missing";
		}
			exit;
			
	}
	
	public function thankyou()
	{
		$this->usercheck();
		$this->layout = "frontend";

		$this->set("application_no",$this->Session->read('cherisgold.application_no'));
		if(!$this->Session->check('cherisgold.application_no')){
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}
		$this->Session->delete('cherisgold.application_no');
	}  	
	
	public function dashboard()
	{
		$this->layout = "frontend";
		$this->usercheck();
		$user = $this->User->find('first',array('conditions' => array('user_id' => $this->Session->read("User.user_id"),'bgp_plan' => "no")));
		if($user)
		{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
			exit;
		}
//$this->Session->write("customer_id","847");
		$search = array();
		
		$search["customer_id"] = $this->Session->read("customer_id");
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => $search));
		if($customer)
		{	
			$search1 = array();
			$search1["mer_txn"] = $customer["CustomerBGP"]["application_no"];
			$search1["udf9 !="] = "topup";
			
			$price = $this->Price->find('first', array('conditions' => array('type' => "Metals", 'metal_id ' => 1, 'metalcolor_id' => 2,'metal_fineness' => '995')));
			if($customer["CustomerBGP"]["relationship_manager"] != "0")
			{
				$relation = $this->RelationshipManager->find('first',array('conditions' => array("manager_id" => $customer["CustomerBGP"]["relationship_manager"])));
				$this->set("relation",$relation);
			}
			$this->set("price",$price);
			$this->set('customer', $customer);
			
			
			$data = array();
			$temp = explode("-",$customer['CustomerBGP']['period_from']);
				
			for($i=0;$i<$customer['CustomerBGP']['tenure'];$i++) {
				$search1["udf9"] = $i+1;
				$payment = $this->PaymentMaster->find('first', array('conditions' => $search1));
				
				$data[$i]["c"] = $i+1;
				$data[$i]["amount"] = $customer['CustomerBGP']['initial_amount'];
		
				if(($temp[0]+$i)<=12)
				{
					$data[$i]["month"] = $temp[0]+$i;
					$data[$i]["year"] = $temp[1];
				}
				else
				{
					$data[$i]["month"] = $temp[0]+$i-12;
					$data[$i]["year"] = $temp[1]+1;
				}
				
				$pay_link = rtrim(strtr(base64_encode("id=".$customer['CustomerBGP']['application_no']."&amount=".$customer['CustomerBGP']['initial_amount']."&action=".$data[$i]["c"]), '+/', '-_'), '=');
				if($payment)
					$data[$i]["payment_done"] = "Done";
				else
				{
					if(strtotime($data[$i]["year"]."-".$data[$i]["month"]."-1") > strtotime("now"))
					{
						$data[$i]["payment_done"] = " - "; 
					}
					else
					{
						$data[$i]["payment_done"] = "<a href='$pay_link'>Pay here</a>"; 
					}
				}
				
			}
			$this->set("data",$data);
		}
		else{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}
	}  
	
	public function setDistributor()
	{
		$this->usercheck();
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $this->Session->read("customer_id"))));
		if($customer)
		{
			$data['customer_id'] = $this->Session->read("customer_id");
			$data['distributor'] = "yes";
			$data['distributor_date'] = date("Y-m-d");
			$result = $this->CustomerBGP->save($data);
			echo "success";
			exit;
		}
		echo "fail";
		exit;
	}
	
	public function changefulfilment()
	{
		$this->usercheck();
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $this->Session->read("customer_id"))));
		if($customer)
		{
			$data['customer_id'] = $this->Session->read("customer_id");
			$data['fulfilment'] = $this->request->data['fulfilment'];
			$result = $this->CustomerBGP->save($data);
			echo "success";
			exit;
		}
		echo "fail";
		exit;
	}
	
	public function topupamount()
	{
		$this->usercheck();
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $this->Session->read("customer_id"))));
		if($customer)
		{
			$amount = $this->request->data['amount'];
			
			if ($amount % 1000 == 0) {
				$data['encode_application_no'] = rtrim(strtr(base64_encode("id=".$customer['CustomerBGP']['application_no']."&amount=".$amount."&action=topup"), '+/', '-_'), '=');
				$data['msg'] = "success";
				echo json_encode($data);
			}
			else
			{
				$data['msg'] = "fail";
				echo json_encode($data);
			}
		}
		exit;
	}
	
	public function manager()
	{
		$this->layout = "frontend";
		$search = array();
		$search["customer_id"] = $this->Session->read("customer_id");
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => $search));
		if($customer)
		{
			$relation = $this->RelationshipManager->find('first',array('conditions' => array("manager_id" => $customer["CustomerBGP"]["relationship_manager"])));
			$this->set("relation",$relation);
			$this->set('customer', $customer);
		}
		else{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}
	}
	
	public function listreferral()
	{
		$this->usercheck();
		$this->layout = "frontend";
		$search = array();
		$search["customer_id"] = $this->Session->read("customer_id");
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => $search));
		if($customer)
		{
			$referral = $this->Referral->find('all',array('conditions' => array("distributor_id" => $customer["CustomerBGP"]["customer_id"])));
			$this->set("referral",$referral);
			$this->set('customer', $customer);
		}
		else{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}
	}
	
	public function addreferral()
	{
		$this->usercheck();
		$this->layout = "frontend";
		$search = array();
		$search["customer_id"] = $this->Session->read("customer_id");
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => $search));
		if($customer)
		{
			
			 if ($this->request->is('post')) {
				$search = array();
				$search["contact_email"] = $this->request->data['Referral']['contact_email'];
				$customer_email = $this->CustomerBGP->find('first', array('conditions' => $search));
				$search = array();
				$search["contact_mobile"] = $this->request->data['Referral']['contact_mobile'];
				$customer_mobile = $this->CustomerBGP->find('first', array('conditions' => $search));
				$error = "no";
				if($customer_email || $customer_mobile)
				{
					$error = "yes";
				}
				
				$search = array();
				$search["email"] = $this->request->data['Referral']['contact_email'];
				$customer_email = $this->User->find('first', array('conditions' => $search));
				$search = array();
				$search["phone_no"] = $this->request->data['Referral']['contact_mobile'];
				$customer_mobile = $this->User->find('first', array('conditions' => $search));
				
				if($customer_email || $customer_mobile)
				{
					$error = "yes";
				}
				
				$check = $this->Referral->find('first', array('conditions' => array(
						'contact_email =' => $this->request->data['Referral']['contact_email'],
						'contact_mobile =' => $this->request->data['Referral']['contact_mobile'],
					)
				));

				if (empty($check) && $error == "no") {
					$this->request->data['Referral']['manager_id'] = $customer['CustomerBGP']['relationship_manager'];
					$this->request->data['Referral']['distributor_id'] = $customer['CustomerBGP']['customer_id'];
					$this->request->data['Referral']['referral_dob'] = date("Y-m-d",strtotime($this->request->data['Referral']['referral_dob']));
					
					$this->Referral->save($this->request->data);
					//$this->Session->setFlash('<div class="success msg">Relation Manager updated successfully.</div>', '');
					$this->redirect(array('action' => 'listreferral'));
				} else {
					$this->Session->setFlash('<div class="error msg">Email Id/Mobile already exists, Try another!</div>', 'default', array(), 'form1');
					$this->redirect(array('action' => 'addreferral'));
				}
			}
			
			$this->set('customer', $customer);
		}
		else{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}
	}
	
	public function registration()
	{
		$this->layout = "frontend";
		$this->usercheck();
		$user = $this->User->find('first',array('conditions' => array('user_id' => $this->Session->read("User.user_id"),'bgp_plan' => "yes")));
		
		if($user)
		{
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'dashboard'));
			exit;
		}
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
		
			$table_id = 'customer_id';
			$search = array();
			$search['contact_mobile LIKE'] = '%' . $_POST['data']["CustomerBGP"]['contact_mobile'] . '%';				
			$search['contact_email LIKE'] = '%' . $_POST['data']["CustomerBGP"]['contact_email'] . '%';				
			//$search['send_form'] = '0';
			
			if(isset($_POST['data']["CustomerBGP"][$table_id]) && $_POST['data']["CustomerBGP"][$table_id] > 0)
			{
				$search[$table_id] = $_POST['data']["CustomerBGP"][$table_id];
			}
			//$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
			$check_name = $this->CustomerBGP->find('all', array('conditions' => $search, 'order' => 'customer_id DESC'));
			
			
			$_POST['data']["CustomerBGP"]['applicant_dob'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['applicant_dob']));
			$_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date']));
			$_POST['data']["CustomerBGP"]['first_cheque_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['first_cheque_date']));
			$_POST['data']["CustomerBGP"]['nomination_dob'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['nomination_dob']));
			//$_POST['data']["CustomerBGP"]['ecs_from'] = CORE::DMYToYMD($_POST['data']["CustomerBGP"]['ecs_debit_date']."-".$_POST['data']["CustomerBGP"]['ecs_from']);
			//$_POST['data']["CustomerBGP"]['ecs_to'] = CORE::DMYToYMD($_POST['data']["CustomerBGP"]['ecs_debit_date']."-".$_POST['data']["CustomerBGP"]['ecs_to']);
			$_POST['data']["CustomerBGP"]['declaration_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['declaration_date']));
			$_POST['data']["CustomerBGP"]['pick_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGP"]['pick_date']));
			
			//if(count($check_name) > 0)
			if(false)
			{
				//$data = $db->FetchToArray($table, "*", $condition);
				$data = $this->CustomerBGP->find('all', array('conditions' => $search, 'order' => 'customer_id DESC'));
				$data[0]['CustomerBGP']['mailing_pincode'] = ($data[0]['CustomerBGP']['mailing_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['mailing_pincode'];
				$data[0]['CustomerBGP']['nomination_pincode'] = ($data[0]['CustomerBGP']['nomination_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['nomination_pincode'];
				$data[0]['CustomerBGP']['ecs_pincode'] = ($data[0]['CustomerBGP']['ecs_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['ecs_pincode'];
				$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
				$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
				$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "0000-00-00") ? "" : $data[0]['CustomerBGP']['declaration_date'];					
				$data[0]['CustomerBGP']['initial_amount'] = ($data[0]['CustomerBGP']['initial_amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['initial_amount'];
				$data[0]['CustomerBGP']['amount'] = ($data[0]['CustomerBGP']['amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['amount'];
				$data[0]['CustomerBGP']['tenure'] = ($data[0]['CustomerBGP']['tenure'] == "0") ? "" : $data[0]['CustomerBGP']['tenure'];				
				$data[0]['CustomerBGP']['ecs_amount_of_subscription'] = ($data[0]['CustomerBGP']['ecs_amount_of_subscription'] == "0") ? "" : $data[0]['CustomerBGP']['ecs_amount_of_subscription'];
				
				$data[0]['CustomerBGP']['contact_email_previous'] = $data[0]['CustomerBGP']['contact_email'];
				$data[0]['CustomerBGP']['contact_mobile_previous'] = $data[0]['CustomerBGP']['contact_mobile']; 
				
				if($data[0]['CustomerBGP']['applicant_dob'] != '0000-00-00'){
					$data[0]['CustomerBGP']['applicant_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['applicant_dob']));
				}else{
					$data[0]['CustomerBGP']['applicant_dob'] = '';
				}
				//$data[0]['applicant_dob'] = CORE::YMDToDMY($data[0]['applicant_dob']);
				//$data[0]['applicant_dob'] = ($data[0]['applicant_dob'] == "01-01-1970") ? "" : $data[0]['applicant_dob'];
				
				
				if($data[0]['CustomerBGP']['nomination_dob'] != '0000-00-00'){
					$data[0]['CustomerBGP']['nomination_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['nomination_dob']));
				}else{
					$data[0]['CustomerBGP']['nomination_dob'] = '';
				}
				
				if($data[0]['CustomerBGP']['initial_cheque_dd_no_date'] != '0000-00-00'){
					$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['initial_cheque_dd_no_date']));
				}else{
					$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = '';
				}
				
				if($data[0]['CustomerBGP']['first_cheque_date'] != '0000-00-00'){
					$data[0]['CustomerBGP']['first_cheque_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['first_cheque_date']));
				}else{
					$data[0]['CustomerBGP']['first_cheque_date'] = '';
				}
				
				if($data[0]['CustomerBGP']['pick_date'] != '0000-00-00'){
					$data[0]['CustomerBGP']['pick_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['pick_date']));
				}else{
					$data[0]['CustomerBGP']['pick_date'] = '';
				}
				//$data[0]['CustomerBGP']['nomination_dob'] = CORE::YMDToDMY($data[0]['CustomerBGP']['nomination_dob']);
				//$data[0]['CustomerBGP']['nomination_dob'] = ($data[0]['CustomerBGP']['nomination_dob'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['nomination_dob'];

				
				
				//$data[0]['CustomerBGP']['ecs_from'] = date("m-Y",strtotime($data[0]['CustomerBGP']['ecs_from']));
				$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
				//$data[0]['CustomerBGP']['ecs_to'] = date("m-Y",strtotime($data[0]['CustomerBGP']['ecs_to']));
				$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
				$data[0]['CustomerBGP']['declaration_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['declaration_date']));
				$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['declaration_date'];
				
				
				echo json_encode($data[0]['CustomerBGP']);
				exit;
			}
			else
			{		
			// upload docs if exist
				// ID Proof
				/* if(isset($_FILES) && isset($_FILES["upload_id"]["name"])){
					$imgres = $core->UploadSingleFile("upload_id",1024*1024*1,DOC_ROOT."/images/customer/");
					if($imgres['status']){
						$_POST['data']["CustomerBGP"]['upload_id_proof'] = $imgres['filename'];
					}else{
						echo json_encode(array('msg'=>$imgres['msg']));
						exit;
					}
				}else{
					unset($_POST['data']["CustomerBGP"]['upload_id']);
				}
				
				// Address Proof
				if(isset($_FILES) && isset($_FILES["upload_address"]["name"])){
					$imgres = $core->UploadSingleFile("upload_address",1024*1024*1,DOC_ROOT."/images/customer/");
					if($imgres['status']){
						$_POST['data']["CustomerBGP"]['upload_address_proof'] = $imgres['filename'];
					}else{
						echo json_encode(array('msg'=>$imgres['msg']));
						exit;
					}
				}else{
					unset($_POST['data']["CustomerBGP"]['upload_address']);
				}
				
				// Bank Proof
				if(isset($_FILES) && isset($_FILES["upload_bank"]["name"])){
					$imgres = $core->UploadSingleFile("upload_bank",1024*1024*1,DOC_ROOT."/images/customer/");
					if($imgres['status']){
						$_POST['data']["CustomerBGP"]['upload_bank_proof'] = $imgres['filename'];
					}else{
						echo json_encode(array('msg'=>$imgres['msg']));
						exit;
					}
				}else{
					unset($_POST['data']["CustomerBGP"]['upload_bank']);
				}
				
				// photo Proof
				if(isset($_FILES) && isset($_FILES["upload_photo"]["name"])){
					$imgres = $core->UploadSingleFile("upload_photo",1024*1024*1,DOC_ROOT."/images/customer/");
					if($imgres['status']){
						$_POST['data']["CustomerBGP"]['upload_photo_proof'] = $imgres['filename'];
					}else{
						echo json_encode(array('msg'=>$imgres['msg']));
						exit;
					}
				}else{
					unset($_POST['data']["CustomerBGP"]['upload_photo']);
				} */
				
				//Insert Update Code
				
				if(isset($_POST['data']["CustomerBGP"][$table_id]) && $_POST['data']["CustomerBGP"][$table_id] > 0)
				{					
					if(isset($_POST['laststep']) && $_POST['laststep'] == "true")
					{
						$_POST['data']["CustomerBGP"]['send_form'] = 1 ;
						if(isset($_COOKIE['pcode']) && !empty($_COOKIE['pcode'])){
							setcookie('pcode',"",time());
						}
					}
					
					if($_POST['data']["CustomerBGP"]['applicant_dob'] == '' || $_POST['data']["CustomerBGP"]['applicant_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['applicant_dob'] = 'null';
						
					if($_POST['data']["CustomerBGP"]['nomination_dob'] == '' || $_POST['data']["CustomerBGP"]['nomination_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['nomination_dob'] = 'null';

					if($_POST['data']["CustomerBGP"]['period_from'] == '')
						$_POST['data']["CustomerBGP"]['period_from'] = '';
						
					if($_POST['data']["CustomerBGP"]['period_to'] == '')
						$_POST['data']["CustomerBGP"]['period_to'] = '';
						
					if($_POST['data']["CustomerBGP"]['ecs_from'] == '' || $_POST['data']["CustomerBGP"]['ecs_from'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['ecs_from'] = '';
						
					if($_POST['data']["CustomerBGP"]['ecs_to'] == '' || $_POST['data']["CustomerBGP"]['ecs_to'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['ecs_to'] = '';
						
					if($_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] == '' || $_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] = 'null';
					
					if($_POST['data']["CustomerBGP"]['first_cheque_date'] == '' || $_POST['data']["CustomerBGP"]['first_cheque_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['first_cheque_date'] = 'null';
					
					if($_POST['data']["CustomerBGP"]['pick_date'] == '' || $_POST['data']["CustomerBGP"]['pick_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['pick_date'] = 'null';
					
					//$result= $db->Update($table, $_POST['data']["CustomerBGP"], $table_id, $_POST['data']["CustomerBGP"][$table_id]);		
					//$result = $this->CustomerBGP->updateAll($_POST['data']["CustomerBGP"], $_POST['data']["CustomerBGP"][$table_id]);
					$result = $this->CustomerBGP->save($_POST['data']["CustomerBGP"]);
					//echo 123;exit;
												
				}
				else
				{
					$srch = array();
					//$appNo = $db->FunctionFetch("customer_master", "max", "application_no","1=1");
				
					$app = $this->CustomerBGP->find('first', array('fields' => array('MAX(CustomerBGP.application_no) as max_application')));
					
					$appNo = $app[0]['max_application'];
					if($appNo > 0)
					{
						$_POST['data']["CustomerBGP"]['application_no'] = $appNo + 1;
					}
					else{
						$_POST['data']["CustomerBGP"]['application_no'] = ONLINE_CUST_START_NO;	
					}
					$_POST['data']["CustomerBGP"]['approve_status'] = "Pending";	
					
					
					
					if($_POST['data']["CustomerBGP"]['applicant_dob'] == '' || $_POST['data']["CustomerBGP"]['applicant_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['applicant_dob'] = 'null';
						
					if($_POST['data']["CustomerBGP"]['pick_date'] == '' || $_POST['data']["CustomerBGP"]['pick_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['pick_date'] = 'null';
						
					if($_POST['data']["CustomerBGP"]['nomination_dob'] == '' || $_POST['data']["CustomerBGP"]['nomination_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['nomination_dob'] = 'null';

					if($_POST['data']["CustomerBGP"]['period_from'] == '')
						$_POST['data']["CustomerBGP"]['period_from'] = '';
						
					if($_POST['data']["CustomerBGP"]['period_to'] == '')
						$_POST['data']["CustomerBGP"]['period_to'] = '';
						
					if($_POST['data']["CustomerBGP"]['ecs_from'] == '' || $_POST['data']["CustomerBGP"]['ecs_from'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['ecs_from'] = '';
						
					if($_POST['data']["CustomerBGP"]['ecs_to'] == '' || $_POST['data']["CustomerBGP"]['ecs_to'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['ecs_to'] = '';
						
					if($_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] == '' || $_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['initial_cheque_dd_no_date'] = 'null';
					
					if($_POST['data']["CustomerBGP"]['first_cheque_date'] == '' || $_POST['data']["CustomerBGP"]['first_cheque_date'] == '1970-01-01')
						$_POST['data']["CustomerBGP"]['first_cheque_date'] = 'null';
					
					$result = "set";
					
					if(count($check_name) == 0)
					{
						//$_POST["data"]["CustomerBGP"][$table_id] = $check_name[0]["CustomerBGP"]["customer_id"];
						$result = $this->CustomerBGP->save($_POST['data']);
					
						$_POST['data']["CustomerBGP"][$table_id] = $result['CustomerBGP']["customer_id"];					
						//$_SESSION["birlagoldadmin"]['msg']= "Record inserted successfully.";	
						$this->Session->write('cherisgold.msg', 'Record inserted successfully');
					}
					else
					{
						$_POST["data"]["CustomerBGP"][$table_id] = $check_name[0]["CustomerBGP"]["customer_id"];
					}
					//$result = $db->Insert($table, $_POST['data']["CustomerBGP"], 1);
				}
				if($result)
				{
					//$_SESSION["birlagoldadmin"]['msg_type']="1";
					$this->Session->write('cherisgold.msg_type', '1');
					//$data = $db->FetchToArray($table, "*","$table_id = ".$_POST['data']["CustomerBGP"][$table_id]);
					// $search[$table_id] = $_POST['data']["CustomerBGP"][$table_id];
					// $data = $this->CustomerBGP->find('all', array('conditions' => $search));
					$search = array();
					$search['contact_mobile LIKE'] = '%' . $_POST['data']["CustomerBGP"]['contact_mobile'] . '%';				
					$search['contact_email LIKE'] = '%' . $_POST['data']["CustomerBGP"]['contact_email'] . '%';				
					//$search['send_form'] = '0';
					
					if(isset($_POST['data']["CustomerBGP"][$table_id]) && $_POST['data']["CustomerBGP"][$table_id] > 0)
					{
						$search[$table_id] = $_POST['data']["CustomerBGP"][$table_id];
					}
					
					$data = $this->CustomerBGP->find('all', array('conditions' => $search, 'order' => 'customer_id DESC'));
					
					$data[0]['CustomerBGP']['mailing_pincode'] = ($data[0]['CustomerBGP']['mailing_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['mailing_pincode'];
					$data[0]['CustomerBGP']['nomination_pincode'] = ($data[0]['CustomerBGP']['nomination_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['nomination_pincode'];
					$data[0]['CustomerBGP']['ecs_pincode'] = ($data[0]['CustomerBGP']['ecs_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['ecs_pincode'];
					$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
					$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
					$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "0000-00-00") ? "" : $data[0]['CustomerBGP']['declaration_date'];					
					$data[0]['CustomerBGP']['initial_amount'] = ($data[0]['CustomerBGP']['initial_amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['initial_amount'];
					$data[0]['CustomerBGP']['amount'] = ($data[0]['CustomerBGP']['amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['amount'];
					$data[0]['CustomerBGP']['tenure'] = ($data[0]['CustomerBGP']['tenure'] == "0") ? "" : $data[0]['CustomerBGP']['tenure'];
					$data[0]['CustomerBGP']['ecs_amount_of_subscription'] = ($data[0]['CustomerBGP']['ecs_amount_of_subscription'] == "0") ? "" : $data[0]['CustomerBGP']['ecs_amount_of_subscription'];
					
					$data[0]['CustomerBGP']['contact_email_previous'] = $data[0]['CustomerBGP']['contact_email'];
					$data[0]['CustomerBGP']['contact_mobile_previous'] = $data[0]['CustomerBGP']['contact_mobile']; 
					//$data[0]['CustomerBGP']['applicant_dob'] = CORE::YMDToDMY($data[0]['CustomerBGP']['applicant_dob']);
					//$data[0]['CustomerBGP']['applicant_dob'] = ($data[0]['CustomerBGP']['applicant_dob'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['applicant_dob'];
					
					if($data[0]['CustomerBGP']['applicant_dob'] != '0000-00-00'){
						$data[0]['CustomerBGP']['applicant_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['applicant_dob']));
					}else{
						$data[0]['CustomerBGP']['applicant_dob'] = '';
					}
					
					if($data[0]['CustomerBGP']['pick_date'] != '0000-00-00' || $data[0]['CustomerBGP']['pick_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['pick_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['pick_date']));
					}else{
						$data[0]['CustomerBGP']['pick_date'] = date("d-m-Y");
					}
					
					if($data[0]['CustomerBGP']['initial_cheque_dd_no_date'] != '0000-00-00' || $data[0]['CustomerBGP']['initial_cheque_dd_no_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['initial_cheque_dd_no_date']));
					}else{
						$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = date("d-m-Y");
					}
					
					if($data[0]['CustomerBGP']['first_cheque_date'] != '0000-00-00' || $data[0]['CustomerBGP']['first_cheque_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['first_cheque_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['first_cheque_date']));
					}else{
						$data[0]['CustomerBGP']['first_cheque_date'] = date("d-m-Y");
					}
					
					if($data[0]['CustomerBGP']['nomination_dob'] != '0000-00-00'){
						$data[0]['CustomerBGP']['nomination_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['nomination_dob']));
					}else{
						$data[0]['CustomerBGP']['nomination_dob'] = '';
					}
					//$data[0]['CustomerBGP']['nomination_dob'] = CORE::YMDToDMY($data[0]['CustomerBGP']['nomination_dob']);
					//$data[0]['CustomerBGP']['nomination_dob'] = ($data[0]['CustomerBGP']['nomination_dob'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['nomination_dob'];
					$data[0]['CustomerBGP']['declaration_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['declaration_date']));
					$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['declaration_date'];
					$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
					//$data[0]['CustomerBGP']['ecs_from'] = ($data[0]['CustomerBGP']['ecs_from'] == "01-1970") ? "" : $data[0]['CustomerBGP']['ecs_from'];
					$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
					//$data[0]['CustomerBGP']['ecs_to'] = ($data[0]['CustomerBGP']['ecs_from'] == "01-1970") ? "" : $data[0]['CustomerBGP']['ecs_to'];
					
					$data[0]['CustomerBGP']['encode_application_no'] = rtrim(strtr(base64_encode("id=".$data[0]['CustomerBGP']['application_no']."&amount=".$data[0]['CustomerBGP']['initial_amount']."&action=1"), '+/', '-_'), '=');
					if($data[0]['CustomerBGP']['initial_pay_by'] == "Cheque")
					{
						//$_SESSION["birlagold"]['msg']= "Record updated successfully.";
						$this->Session->write('cherisgold.msg', 'Record updated successfully');
						//$_SESSION["birlagold"]['msg_type'] = 1;
						$this->Session->write('cherisgold.msg_type', '1');
					}
					else {
						//unset($_SESSION["birlagold"]['msg']);
						$this->Session->delete('cherisgold.msg');
						//unset($_SESSION["birlagold"]['msg_type']);
						$this->Session->delete('cherisgold.msg_type');
					}
					//$_SESSION["birlagold"]['application_no'] = $data[0]['CustomerBGP']['application_no'];
					//$this->Session->write('cherisgold.application_no', $data[0]['CustomerBGP']['application_no']);
					$this->Session->write('cherisgold.application_no', $_POST['data']["CustomerBGP"]['application_no']);
					$this->Session->write("customer_id",$_POST['data']["CustomerBGP"]['customer_id']);
					echo json_encode($data[0]['CustomerBGP']);
					exit;
				}
				else
				{
					echo json_encode(array('msg'=>'Problem in data insert.'));
					exit;
				}
			}
		}
		else
		{
			// var_dump($this->Session->read('User'));
			$this->set("email",$this->Session->read('User.email'));
			$this->set("phone",$this->Session->read('User.phone_no'));
		}
	}
	
	public function edit()
	{
		$this->layout = "frontend";
		$this->usercheck();
		$search = array();
					
		$search['customer_id'] = $this->Session->read('customer_id');
		$data = $this->CustomerBGP->find('first', array('conditions' => $search, 'order' => 'customer_id DESC'));
		$this->set("email",$data['CustomerBGP']['contact_email']);
		$this->set("phone",$data['CustomerBGP']['contact_mobile']);
		$this->set("customerid",$data['CustomerBGP']['customer_id']);
		$this->set("application",$data['CustomerBGP']['application_no']);
		$this->set("relationship_manager",$data['CustomerBGP']['relationship_manager']);
		$this->set("distributor",$data['CustomerBGP']['distributor']);
		$this->set("distributor_date",$data['CustomerBGP']['distributor_date']);
	}
	
	public function editdetails()
	{
		$this->layout = "frontend";
		$this->usercheck();
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
		
			$table_id = 'customer_id';
			$search = array();
			$search['contact_mobile LIKE'] = '%' . $_POST['data']["CustomerBGPCopy"]['contact_mobile'] . '%';				
			$search['contact_email LIKE'] = '%' . $_POST['data']["CustomerBGPCopy"]['contact_email'] . '%';		
			$search[$table_id] = $_POST['data']["CustomerBGPCopy"][$table_id];			
			//$search['send_form'] = '0';
			
			//$check_name = $this->CustomerBGP->find('all', array('conditions' => $search, 'order' => 'customer_id DESC'));
			
			
			$_POST['data']["CustomerBGPCopy"]['applicant_dob'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['applicant_dob']));
			$_POST['data']["CustomerBGPCopy"]['initial_cheque_dd_no_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['initial_cheque_dd_no_date']));
			$_POST['data']["CustomerBGPCopy"]['first_cheque_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['first_cheque_date']));
			$_POST['data']["CustomerBGPCopy"]['nomination_dob'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['nomination_dob']));
			$_POST['data']["CustomerBGPCopy"]['declaration_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['declaration_date']));
			$_POST['data']["CustomerBGPCopy"]['pick_date'] = date("Y-m-d",strtotime($_POST['data']["CustomerBGPCopy"]['pick_date']));
				
				//Update Code
				
				if(isset($_POST['data']["CustomerBGPCopy"][$table_id]) && $_POST['data']["CustomerBGPCopy"][$table_id] > 0)
				{					
					if(isset($_POST['laststep']) && $_POST['laststep'] == "true")
					{
						$_POST['data']["CustomerBGPCopy"]['send_form'] = 1 ;
						if(isset($_COOKIE['pcode']) && !empty($_COOKIE['pcode'])){
							setcookie('pcode',"",time());
						}
					}
					
					if($_POST['data']["CustomerBGPCopy"]['applicant_dob'] == '' || $_POST['data']["CustomerBGPCopy"]['applicant_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['applicant_dob'] = 'null';
						
					if($_POST['data']["CustomerBGPCopy"]['nomination_dob'] == '' || $_POST['data']["CustomerBGPCopy"]['nomination_dob'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['nomination_dob'] = 'null';

					if($_POST['data']["CustomerBGPCopy"]['period_from'] == '')
						$_POST['data']["CustomerBGPCopy"]['period_from'] = '';
						
					if($_POST['data']["CustomerBGPCopy"]['period_to'] == '')
						$_POST['data']["CustomerBGPCopy"]['period_to'] = '';
						
					if($_POST['data']["CustomerBGPCopy"]['ecs_from'] == '' || $_POST['data']["CustomerBGPCopy"]['ecs_from'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['ecs_from'] = '';
						
					if($_POST['data']["CustomerBGPCopy"]['ecs_to'] == '' || $_POST['data']["CustomerBGPCopy"]['ecs_to'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['ecs_to'] = '';
						
					if($_POST['data']["CustomerBGPCopy"]['initial_cheque_dd_no_date'] == '' || $_POST['data']["CustomerBGPCopy"]['initial_cheque_dd_no_date'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['initial_cheque_dd_no_date'] = 'null';
					
					if($_POST['data']["CustomerBGPCopy"]['first_cheque_date'] == '' || $_POST['data']["CustomerBGPCopy"]['first_cheque_date'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['first_cheque_date'] = 'null';
					
					if($_POST['data']["CustomerBGPCopy"]['pick_date'] == '' || $_POST['data']["CustomerBGPCopy"]['pick_date'] == '1970-01-01')
						$_POST['data']["CustomerBGPCopy"]['pick_date'] = 'null';
					
					//var_dump($_POST['data']["CustomerBGPCopy"]);
					$result = $this->CustomerBGPCopy->save($_POST['data']["CustomerBGPCopy"]);
					
					//var_dump($result);
					//echo 123;exit;
												
				}
		}
					$search = array();
					
					$search['customer_id'] = $this->Session->read('customer_id');
					$data = $this->CustomerBGP->find('all', array('conditions' => $search, 'order' => 'customer_id DESC'));
					
					$data[0]['CustomerBGP']['mailing_pincode'] = ($data[0]['CustomerBGP']['mailing_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['mailing_pincode'];
					$data[0]['CustomerBGP']['nomination_pincode'] = ($data[0]['CustomerBGP']['nomination_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['nomination_pincode'];
					$data[0]['CustomerBGP']['ecs_pincode'] = ($data[0]['CustomerBGP']['ecs_pincode'] == 0) ? "" : $data[0]['CustomerBGP']['ecs_pincode'];
					$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
					$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
					$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "0000-00-00") ? "" : $data[0]['CustomerBGP']['declaration_date'];					
					$data[0]['CustomerBGP']['initial_amount'] = ($data[0]['CustomerBGP']['initial_amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['initial_amount'];
					$data[0]['CustomerBGP']['amount'] = ($data[0]['CustomerBGP']['amount'] == "0.00") ? "" : $data[0]['CustomerBGP']['amount'];
					$data[0]['CustomerBGP']['tenure'] = ($data[0]['CustomerBGP']['tenure'] == "0") ? "" : $data[0]['CustomerBGP']['tenure'];
					$data[0]['CustomerBGP']['ecs_amount_of_subscription'] = ($data[0]['CustomerBGP']['ecs_amount_of_subscription'] == "0") ? "" : $data[0]['CustomerBGP']['ecs_amount_of_subscription'];
					
					$data[0]['CustomerBGP']['contact_email_previous'] = $data[0]['CustomerBGP']['contact_email'];
					$data[0]['CustomerBGP']['contact_mobile_previous'] = $data[0]['CustomerBGP']['contact_mobile']; 
					//$data[0]['CustomerBGP']['applicant_dob'] = CORE::YMDToDMY($data[0]['CustomerBGP']['applicant_dob']);
					//$data[0]['CustomerBGP']['applicant_dob'] = ($data[0]['CustomerBGP']['applicant_dob'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['applicant_dob'];
					
					if($data[0]['CustomerBGP']['applicant_dob'] != '0000-00-00'){
						$data[0]['CustomerBGP']['applicant_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['applicant_dob']));
					}else{
						$data[0]['CustomerBGP']['applicant_dob'] = '';
					}
					
				
					if($data[0]['CustomerBGP']['initial_cheque_dd_no_date'] != '0000-00-00' || $data[0]['CustomerBGP']['initial_cheque_dd_no_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['initial_cheque_dd_no_date']));
					}else{
						$data[0]['CustomerBGP']['initial_cheque_dd_no_date'] = date("d-m-Y");
					}
					
					if($data[0]['CustomerBGP']['first_cheque_date'] != '0000-00-00' || $data[0]['CustomerBGP']['first_cheque_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['first_cheque_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['first_cheque_date']));
					}else{
						$data[0]['CustomerBGP']['first_cheque_date'] = date("d-m-Y");
					}
					
					
					if($data[0]['CustomerBGP']['nomination_dob'] != '0000-00-00'){
						$data[0]['CustomerBGP']['nomination_dob'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['nomination_dob']));
					}else{
						$data[0]['CustomerBGP']['nomination_dob'] = '';
					}
					
					if($data[0]['CustomerBGP']['pick_date'] != '0000-00-00' || $data[0]['CustomerBGP']['pick_date'] != '1970-01-01'){
						$data[0]['CustomerBGP']['pick_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['pick_date']));
					}else{
						$data[0]['CustomerBGP']['pick_date'] = '';
					}
					
					//$data[0]['CustomerBGP']['nomination_dob'] = CORE::YMDToDMY($data[0]['CustomerBGP']['nomination_dob']);
					//$data[0]['CustomerBGP']['nomination_dob'] = ($data[0]['CustomerBGP']['nomination_dob'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['nomination_dob'];
					$data[0]['CustomerBGP']['declaration_date'] = date("d-m-Y",strtotime($data[0]['CustomerBGP']['declaration_date']));
					$data[0]['CustomerBGP']['declaration_date'] = ($data[0]['CustomerBGP']['declaration_date'] == "01-01-1970") ? "" : $data[0]['CustomerBGP']['declaration_date'];
					$data[0]['CustomerBGP']['ecs_from'] = $data[0]['CustomerBGP']['ecs_from'];
					//$data[0]['CustomerBGP']['ecs_from'] = ($data[0]['CustomerBGP']['ecs_from'] == "01-1970") ? "" : $data[0]['CustomerBGP']['ecs_from'];
					$data[0]['CustomerBGP']['ecs_to'] = $data[0]['CustomerBGP']['ecs_to'];
					//$data[0]['CustomerBGP']['ecs_to'] = ($data[0]['CustomerBGP']['ecs_from'] == "01-1970") ? "" : $data[0]['CustomerBGP']['ecs_to'];
					
					$data[0]['CustomerBGP']['encode_application_no'] = rtrim(strtr(base64_encode("id=".$data[0]['CustomerBGP']['application_no']."&amount=".$data[0]['CustomerBGP']['initial_amount']."&action=1"), '+/', '-_'), '=');
				
					echo json_encode($data[0]['CustomerBGP']);
					exit;
	}
    /**
     * admin_approvals method
     *
     * @return void
     */
    public function admin_approvals() 
	{
		/* $data = $this->CustomerBGP->find('all');
		echo "hi...<pre>";
		print_r($data);
		exit; */
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
                $this->redirect(array('action' => 'approvals?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        
		$search = array();
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
										'conditions' => array('payment.mer_txn = CustomerBGPCopy.application_no','payment.udf9 = 1')
									)
								), 'order' => 'CustomerBGPCopy.customer_id DESC');
            $this->set('customer', $this->Paginator->paginate('CustomerBGPCopy'));
		
    }
	
	    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() 
	{
		/* $data = $this->CustomerBGP->find('all');
		echo "hi...<pre>";
		print_r($data);
		exit; */
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
										'conditions' => array('payment.mer_txn = CustomerBGP.application_no','payment.udf9' => 1 )
									)
								), 'order' => 'CustomerBGP.customer_id DESC');
            $this->set('customer', $this->Paginator->paginate('CustomerBGP'));
		
    }
	
    /**
     * admin_view method
     *
     * @return void
     */

    public function admin_view($id) {
        $this->layout = 'admin';
        $this->checkadmin();
		
		 if ($this->request->is('post')) {			

					$this->CustomerBGP->updateAll(
					array('relationship_manager' => $this->request->data["CustomerBGP"]["relationship_manager"]),
					array('customer_id' => $this->request->data["CustomerBGP"]["customer_id"])
				);
				
			}
			
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $id)));
		$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		
		$relation = $this->RelationshipManager->find('all');
		
		 $this->set('relation', $relation);
		 $this->set('customer', $customer);
		 $this->set('payment', $payment);
	}
	
	/**
     * admin_approval_view method
     *
     * @return void
     */

    public function admin_approval_view($id) {
	
        $this->layout = 'admin';
        $this->checkadmin();
		
		if ($this->request->is('post')) {
			$result = $this->CustomerBGP->save($_POST['data']["CustomerBGP"]);
			$this->CustomerBGPCopy->delete($_POST['data']["CustomerBGP"]["customer_id"]);
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'approvals'));
			exit;
		}
		$customer = $this->CustomerBGPCopy->find('first', array('conditions' => array('customer_id' => $id)));
		$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		
		$relation = $this->RelationshipManager->find('all');
		
		 $this->set('relation', $relation);
		 $this->set('customer', $customer);
		 $this->set('payment', $payment);
	}
	
	public function admin_changeStatus()
	{
		 $this->checkadmin();
		
        if ($this->request->is('post')) {
			$id = $this->request->data['id'];
			$status = $this->request->data['status'];
			$text = $this->request->data['text'];
			$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $id)));
			//$user = $this->User->find('first', array('conditions' => array('user_id' => $customer['CustomerBGP']['user_id'])));
			$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
			$this->CustomerBGP->id = $this->CustomerBGP->field('customer_id', array('customer_id' => $id));
			if ($this->CustomerBGP->id) {
				$this->CustomerBGP->saveField('approve_status', $status);
				if(isset($text) && $text != "")
				{
					$this->CustomerBGP->saveField('reason', $text);
				}
				if($status == "Approved")
				{
					$this->User->updateAll(
					array('bgp_plan' => "'yes'"),
					array('user_id' => $customer['CustomerBGP']['user_id'])
					);
					
					App::uses('CakeEmail', 'Network/Email');
				
					$email = new CakeEmail();
					$email->emailFormat('html');
					$email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
					$email->template('default', 'default');
					$email->to(trim($customer['CustomerBGP']['contact_email']));
					$subject = "";
					$email->subject(SITE_NAME . " Birla Gold Customer Registration");
					$message = "Dear ".$customer['CustomerBGP']['applicant_name'].",<br/><br/>Your registration with birla gold successful. >";
					
					$email->send($message);
					$email->reset();
				}
				elseif($status == "Rejected")
				{
					App::uses('CakeEmail', 'Network/Email');
				
					$email = new CakeEmail();
					$email->emailFormat('html');
					$email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
					$email->template('default', 'default');
					$email->to(trim($customer['CustomerBGP']['contact_email']));
					$subject = "";
					$email->subject(SITE_NAME . " Birla Gold Customer Registration");
					$message = "Dear ".$customer['CustomerBGP']['applicant_name'].",<br/><br/>Your application has been rejected.. >";
					
					$email->send($message);
					$email->reset();
				
				}
				
				echo json_encode(array('msg'=>'success'));		
			}
			else
			{
				echo json_encode(array('msg'=>'fail'));			
			}  			
		}
		else
		{
			echo json_encode(array('msg'=>'fail'));			
		}  		
		exit;
	}

    public function admin_fexport($cdate, $edate) {
        $this->checkadmin();
        $this->layout = '';
        $this->render(false);

        ini_set('max_execution_time', 600);
        //increase max_execution_time to 10 min if data set is very large	
        //create a file
        $filename = "franchisee.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $u_email = $this->request->params['pass'][3];
        $u_name = $this->request->params['pass'][2];
        $u_fra = $this->request->params['pass'][4];
        $search = array();
        $search = array('user_type' => '1', 'status !=' => 'Trash');

        $this->paginate = array('conditions' => $search, 'order' => 'User.user_id DESC');
        $this->set('user', $this->paginate('User'));
        /* if($cdate == 0 && $edate == 0){	
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash')));
          }else if($cdate==''){
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date <='=>$edate)));
          }else if($edate==''){
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date >='=>$cdate)));
          }else{
          $results = $this->User->find('all', array('conditions' => array('user_type' => 1,'status !=' => 'Trash','created_date >='=>$cdate,'created_date <='=>$edate)));
          } */
        if (($cdate != 0) && ($edate != 0)) {
            $search = array('created_date BETWEEN \'' . $cdate . '\' AND \'' . $edate . '\'');
        } elseif ($cdate != 0) {
            $search['created_date >='] = $cdate;
        } elseif ($edate != 0) {
            $search['created_date <='] = $edate;
        }
        if ($u_name != '0') {

            $search = array_merge($search, array('OR' => array('CONCAT(User.first_name, \' \', User.last_name) LIKE ' => '%' . $u_name . '%', 'CONCAT(User.first_name, \'\', User.last_name) LIKE ' => '%' . $u_name . '%', 'User.first_name LIKE ' => '%' . $u_name . '%', 'User.last_name LIKE ' => '%' . $u_name . '%')));
        }
        if ($u_fra != '0') {
            $search['franchisee_code LIKE '] = $u_fra;
        }

        if ($u_email != '0') {
            $search['email LIKE'] = '%' . $u_email . '%';
        }

        $results = $this->User->find('all', array('conditions' => $search));
        /* echo "<pre>";
          print_r($search);
          echo "</pre>"; */
        /* 	echo "<pre>";
          print_r($results);
          echo "</pre>"; */
        $header_row = array("S.No", "Email", "Title", "Frist Name", "Last Name", "Phone No", "Address", "Birth day", "Martial Status", "PAN", "Pincode", "City", "State", "Mobile No", "Phone No 2", "Fax No", "Franchisee Code", "Status", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Payment", "Amount", "Cheque No", "Bank Name", "Account No", "Branch Name", "Outlet Name", "Address", "City", "State", "Pincode", "Mobile No", "Phone No1", "Phone No 2", "Fax", "Email", "N.title", "N.name", "Guardian_name", "Address", "City", "State", "Pincode", "Mobile No", "Phone No 1", "Phone No 2", "DOB", "Email", "Bank Name", "Account No", "Branch Name", "Type", "IFSC Code", "PAN Proof", "Document Proof", "Bank Proof", "Sign Proof", "Source By", "Accepted By", "Person Name");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {
            $payment = $this->Payment->find("all", array('conditions' => array('user_id' => $results['User']['user_id']), array('limit' => '3')));
            $paymentcount = $this->Payment->find("count", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $outlet = $this->Outlet->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $nomination = $this->Nomination->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $bank = $this->Bankdetail->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $proof = $this->Franchiseeproof->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));

            $use = $this->Officeuse->find("first", array('conditions' => array('user_id' => $results['User']['user_id'])));


            $payments = array();
            foreach ($payment as $payment_del) {

                $payments[] = $payment_del['Payment']['payment'];
                $payments[] = $payment_del['Payment']['amount'];
                $payments[] = $payment_del['Payment']['cheque_no'];
                $payments[] = $payment_del['Payment']['bank_name'];
                $payments[] = $payment_del['Payment']['account_no'];
                $payments[] = $payment_del['Payment']['branch_name'];
            }
            if ($paymentcount < 3) {
                for ($s = $paymentcount + 1; $s <= 3; $s++) {
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                    $payments[] = ' ';
                }
            }


            $row = array(
                $i,
                $results['User']['email'],
                $results['User']['title'],
                $results['User']['first_name'],
                $results['User']['last_name'],
                $results['User']['phone_no'],
                $results['User']['address'],
                $results['User']['date_of_birth'],
                $results['User']['martial_status'],
                $results['User']['pan_no'],
                $results['User']['city'],
                $results['User']['state'],
                $results['User']['pincode'],
                $results['User']['mobile_no'],
                $results['User']['phone_no2'],
                $results['User']['fax_no'],
                $results['User']['franchisee_code'],
                $results['User']['status']);
            $row = array_merge($row, $payments);
            $row = array_merge($row, array($outlet['Outlet']['outlet_name'], $outlet['Outlet']['address'], $outlet['Outlet']['city'], $outlet['Outlet']['state'], $outlet['Outlet']['pincode'], $outlet['Outlet']['mobile_no'], $outlet['Outlet']['phone_no1'], $outlet['Outlet']['phone_no2'], $outlet['Outlet']['fax'], $outlet['Outlet']['email']));
            $row = array_merge($row, array($nomination['Nomination']['title'], $nomination['Nomination']['name'], $nomination['Nomination']['guardian_name'], $nomination['Nomination']['address'], $nomination['Nomination']['city'], $nomination['Nomination']['state'], $nomination['Nomination']['pincode'], $nomination['Nomination']['mobile_no'], $nomination['Nomination']['phone_no1'], $nomination['Nomination']['phone_no2'], $nomination['Nomination']['dob'], $nomination['Nomination']['email']));
            $row = array_merge($row, array($bank['Bankdetail']['name'], $bank['Bankdetail']['account_no'], $bank['Bankdetail']['branch_name'], $bank['Bankdetail']['type'], $bank['Bankdetail']['ifsc_code']));
            $row = array_merge($row, array($proof['Franchiseeproof']['pan'], $proof['Franchiseeproof']['proof'], $proof['Franchiseeproof']['bankproof'], $proof['Franchiseeproof']['sign_proof']));
            $row = array_merge($row, array($use['Officeuse']['sourceby'], $use['Officeuse']['acceptedby'], $use['Officeuse']['source_person_name']));
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }
	
	
	public function generateAC()
	{
		
  		ini_set('memory_limit', '-1');
		
  		
  		if(isset($_GET) && !empty($_GET))
		{
  			$id = $_GET['id'];
  			$savefile = false;
		}
		if(isset($dis_id) && !empty($dis_id))
		{
			$id = $dis_id;
			$savefile = true;
		}
  		/* echo $id; */
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('application_no' => $id)));
		$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		
		$bank_name = '';
		$branch_name = '';
		$tenture = '';
		$monthly_sub_amt = '';
		
		
  		$app_no = $customer["CustomerBGP"]["application_no"];
		$dist_data = 'RDIRECT';
		if(isset($customer["CustomerBGP"]['partner_code']) && $customer["CustomerBGP"]['partner_code'] != ''){
			$dist_data = $customer["CustomerBGP"]['partner_code'];
		}
		
		$toname ="";
		$toname = $customer["CustomerBGP"]['applicant_name'];
		
		if( $customer["CustomerBGP"]['monthly_sip_pdc']== 'SIP'){
			$bank_name = $customer["CustomerBGP"]['ecs_bank_name'];
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['ecs_amount_of_subscription'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
				
			$branch_name = $customer["CustomerBGP"]['ecs_branch_address'];
		}else{
			$bank_name = '';
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
			
			$branch_name = '';
		}
		
		$branch_name = str_replace('\r\n',' ',$branch_name);
		
					$html_ac = '<html>
				<head>
				
				<style>
				/**** Common Style *****/
				div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
					margin:0;
					padding:0;
				}
				html, body {
					font-size:13px;
					text-align:left;
					color:#373435;
					font-family: Arial, Helvetica, sans-serif;
					direction: ltr;
					font-weight:normal;
					margin:0;
					padding:0px 0 0 0;
					background: #fff;
				}
				
				.paddingT2		{padding-top:2px;}
				.paddingB2		{padding-bottom:2px;}
				
				.paddingT5		{padding-top:5px;}
				.paddingB5		{padding-bottom:5px;}
				.paddingT		{padding-top:10px;}
				.paddingL		{padding-left:10px;}
				.paddingR		{padding-right:10px;}
				.paddingB		{padding-bottom:10px;}
				.marginr15		{margin-right:15px;}
				.paddingL5		{padding-left:5px;}
				.paddingR5		{padding-right:5px;}
				
				.head2{ font-size:18px; color:#373435;}
				.rightTxt{ color:#373435;}
				.rightTxt a {color:#373435; text-decoration:none;}
				.codeBox{border:1px solid #333; width:25px; height:28px;}
				.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
				.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
				.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
				
				.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
				.taxStatusBorder{width:190px; }
				.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
				.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
				
				.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
				.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
				.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
				
				/**** Application Form 12-05-2014 ****/
				.paddingT2		{padding-top:2px;}
				.paddingB2		{padding-bottom:2px;}
				
				.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
				.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
				.underLine{width:90px;}
				.fontsize11{ font-size:11px;}
				.fontsize12{ font-size:12px;}
				.fontsize14{ font-size:14px;}
				.fontsize15{ font-size:15px;}
				.lF{ float:left;}
				.rF{ float:right;}
				.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
				.head2{ font-size:18px; color:#373435;}
				.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
				.bold{ font-weight:bold;}
				.Boxborder{border:1px solid #333;}
				.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
				.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
				.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
				.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
				.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
				.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
				.BoxborderBotm{border-bottom:1px solid #333;}
				.BoxborderRight{border-right:1px solid #333;}
				.BoxborderTop{border-top:1px solid #333;}
				.StatusBox{ width:120px;}
				.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
				.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
				.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
				.paddingTRBL5{ padding:5px;}
				.paddingTRBL{ padding:10px;}
				
				.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
				lable{ margin:0; padding:0;}
				
				/**** New class ****/ 
				.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
				.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
				.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
				.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
				table { margin:0; padding:0;}
				</style>
				
				</head>
				<body>
				
				
				<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;"><table width="1000" border="0" cellspacing="0" cellpadding="0">';
					
				$html_ac .= '<tr>
						  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
						  	<tr>
						  		<td style="padding-bottom:10px">
						  			<b>Acknowledgment Slip</b>
						  		</td>
						  		<td>
						  			Application No: '.$app_no.'
						  		</td>
						  	</tr>
						    <tr>
						      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
							  	<p>Received with thanks from Mr./Ms./Mrs  '.(($customer["CustomerBGP"]['applicant_name'] != "") ? '<span style="text-decoration: underline;">'.$customer["CustomerBGP"]['applicant_name'].'&nbsp;&nbsp;&nbsp;</span>' : "____________________________________________________").' an application for allotment</p><br/>
								<p>of gold gram under BGP as per the advance payment details below:-<br/></p>
								<p>
								Amount '.(($payment["PaymentMaster"]['amt'] != "") ? '<span style="text-decoration: underline;">'.$payment["PaymentMaster"]['amt'].'</span>' : "___________________").' Payment Mode: Cheque/DD/Payorder Instrument No. '.(($payment["PaymentMaster"]['bank_txn'] != "") ? '<span style="text-decoration: underline;">'.$payment["PaymentMaster"]['bank_txn'].'</span>' : "___________________").' Date <span style="text-decoration: underline;">'.date('d-m-Y').'</span></p><br/>
								
								<p>Bank Name '.(($bank_name != "") ? '<span style="text-decoration: underline;">'.$bank_name.'</span>' : "______________________________").' Branch '.(($branch_name != "") ? '<span style="text-decoration: underline;">'.$branch_name.'</span>' : "_________________________").' Tenure '.(($tenture != "") ? '<span style="text-decoration: underline;">'.$tenture.' Years</span>' : "_________").'</p><br/>
								
								<p>Monthly Subscription Option: '.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? 'ECS / Direct Debit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : "PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").' Monthly Subscription Amount '.(($monthly_sub_amt != 0) ? '<span style="text-decoration: underline;">'.$monthly_sub_amt.'</span>' : "______________").'</p>
							  </td>
						      <td align="center" class="paddingL">
						        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
						          <tr>
						            <td align="center" width="180" style="height:80px; text-align:center;">
						            <img src="img/logo.jpg" />
						            </td>
						          </tr>
						        </table>
						      </td>
						    </tr>
						    
						  </table>
						  </td>
					   </tr>
					   <tr>
			              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
			                	Birla Gold and Precious Metals Pvt Ltd
			                </td>
			              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
		              </tr>
					  </table>
					  </div>';

			//$mpdf=new mPDF(); 
			$this->Mpdf->init();
			$this->Mpdf->WriteHTML($html_ac);
			$filename = $customer["CustomerBGP"]['application_no'].'_AC'.".pdf";
			$this->Mpdf->Output($filename,"D");
			exit;
	}

	public function admin_generateAC(){
  		
  		ini_set('memory_limit', '-1');
		
  		
  		if(isset($_GET) && !empty($_GET))
		{
  			$id = $_GET['id'];
  			$savefile = false;
		}
		if(isset($dis_id) && !empty($dis_id))
		{
			$id = $dis_id;
			$savefile = true;
		}
  		/* echo $id; */
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $id)));
		$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		
		$bank_name = '';
		$branch_name = '';
		$tenture = '';
		$monthly_sub_amt = '';
		
		
  		$app_no = $customer["CustomerBGP"]["application_no"];
		$dist_data = 'RDIRECT';
		if(isset($customer["CustomerBGP"]['partner_code']) && $customer["CustomerBGP"]['partner_code'] != ''){
			$dist_data = $customer["CustomerBGP"]['partner_code'];
		}
		
		$toname ="";
		$toname = $customer["CustomerBGP"]['applicant_name'];
		
		if( $customer["CustomerBGP"]['monthly_sip_pdc']== 'SIP'){
			$bank_name = $customer["CustomerBGP"]['ecs_bank_name'];
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['ecs_amount_of_subscription'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
				
			$branch_name = $customer["CustomerBGP"]['ecs_branch_address'];
		}else{
			$bank_name = '';
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
			
			$branch_name = '';
		}
		
		$branch_name = str_replace('\r\n',' ',$branch_name);
		
					$html_ac = '<html>
				<head>
				
				<style>
				/**** Common Style *****/
				div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
					margin:0;
					padding:0;
				}
				html, body {
					font-size:13px;
					text-align:left;
					color:#373435;
					font-family: Arial, Helvetica, sans-serif;
					direction: ltr;
					font-weight:normal;
					margin:0;
					padding:0px 0 0 0;
					background: #fff;
				}
				
				.paddingT2		{padding-top:2px;}
				.paddingB2		{padding-bottom:2px;}
				
				.paddingT5		{padding-top:5px;}
				.paddingB5		{padding-bottom:5px;}
				.paddingT		{padding-top:10px;}
				.paddingL		{padding-left:10px;}
				.paddingR		{padding-right:10px;}
				.paddingB		{padding-bottom:10px;}
				.marginr15		{margin-right:15px;}
				.paddingL5		{padding-left:5px;}
				.paddingR5		{padding-right:5px;}
				
				.head2{ font-size:18px; color:#373435;}
				.rightTxt{ color:#373435;}
				.rightTxt a {color:#373435; text-decoration:none;}
				.codeBox{border:1px solid #333; width:25px; height:28px;}
				.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
				.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
				.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
				
				.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
				.taxStatusBorder{width:190px; }
				.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
				.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
				
				.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
				.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
				.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
				
				/**** Application Form 12-05-2014 ****/
				.paddingT2		{padding-top:2px;}
				.paddingB2		{padding-bottom:2px;}
				
				.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
				.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
				.underLine{width:90px;}
				.fontsize11{ font-size:11px;}
				.fontsize12{ font-size:12px;}
				.fontsize14{ font-size:14px;}
				.fontsize15{ font-size:15px;}
				.lF{ float:left;}
				.rF{ float:right;}
				.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
				.head2{ font-size:18px; color:#373435;}
				.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
				.bold{ font-weight:bold;}
				.Boxborder{border:1px solid #333;}
				.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
				.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
				.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
				.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
				.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
				.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
				.BoxborderBotm{border-bottom:1px solid #333;}
				.BoxborderRight{border-right:1px solid #333;}
				.BoxborderTop{border-top:1px solid #333;}
				.StatusBox{ width:120px;}
				.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
				.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
				.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
				.paddingTRBL5{ padding:5px;}
				.paddingTRBL{ padding:10px;}
				
				.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
				lable{ margin:0; padding:0;}
				
				/**** New class ****/ 
				.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
				.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
				.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
				.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
				table { margin:0; padding:0;}
				</style>
				
				</head>
				<body>
				
				
				<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;"><table width="1000" border="0" cellspacing="0" cellpadding="0">';
					
				$html_ac .= '<tr>
						  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
						  	<tr>
						  		<td style="padding-bottom:10px">
						  			<b>Acknowledgment Slip</b>
						  		</td>
						  		<td>
						  			Application No: '.$app_no.'
						  		</td>
						  	</tr>
						    <tr>
						      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
							  	<p>Received with thanks from Mr./Ms./Mrs  '.(($customer["CustomerBGP"]['applicant_name'] != "") ? '<span style="text-decoration: underline;">'.$customer["CustomerBGP"]['applicant_name'].'&nbsp;&nbsp;&nbsp;</span>' : "____________________________________________________").' an application for allotment</p><br/>
								<p>of gold gram under BGP as per the advance payment details below:-<br/></p>
								<p>
								Amount '.(($payment["PaymentMaster"]['amt'] != "") ? '<span style="text-decoration: underline;">'.$payment["PaymentMaster"]['amt'].'</span>' : "___________________").' Payment Mode: Cheque/DD/Payorder Instrument No. '.(($payment["PaymentMaster"]['bank_txn'] != "") ? '<span style="text-decoration: underline;">'.$customer["PaymentMaster"]['bank_txn'].'</span>' : "___________________").' Date <span style="text-decoration: underline;">'.date('d-m-Y').'</span></p><br/>
								
								<p>Bank Name '.(($bank_name != "") ? '<span style="text-decoration: underline;">'.$bank_name.'</span>' : "______________________________").' Branch '.(($branch_name != "") ? '<span style="text-decoration: underline;">'.$branch_name.'</span>' : "_________________________").' Tenure '.(($tenture != "") ? '<span style="text-decoration: underline;">'.$tenture.' Years</span>' : "_________").'</p><br/>
								
								<p>Monthly Subscription Option: '.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? 'ECS / Direct Debit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : "PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").' Monthly Subscription Amount '.(($monthly_sub_amt != 0) ? '<span style="text-decoration: underline;">'.$monthly_sub_amt.'</span>' : "______________").'</p>
							  </td>
						      <td align="center" class="paddingL">
						        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
						          <tr>
						            <td align="center" width="180" style="height:80px; text-align:center;">
						            <img src="img/logo.jpg" />
						            </td>
						          </tr>
						        </table>
						      </td>
						    </tr>
						    
						  </table>
						  </td>
					   </tr>
					   <tr>
			              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
			                	Birla Gold and Precious Metals Pvt Ltd
			                </td>
			              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
		              </tr>
					  </table>
					  </div>';

			//$mpdf=new mPDF(); 
			$this->Mpdf->init();
			$this->Mpdf->WriteHTML($html_ac);
			$filename = $customer["CustomerBGP"]['application_no'].'_AC'.".pdf";
			$this->Mpdf->Output($filename,"D");
			exit;
  	}
  	
	public function admin_generateForm()
  	{  		
  		//echo $id; exit;
  		ini_set('memory_limit', '-1');
		
		if(isset($_GET['id']) && !empty($_GET['id']))
		{
  			//$_GET = $db->FilterParameters($_GET);
  			$id = $_GET['id'];
  			$savefile = false;
		}
	
		
		$customer = $this->CustomerBGP->find('first', array('conditions' => array('customer_id' => $id)));
		$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		
  		$app_no = $customer["CustomerBGP"]['application_no'];
  		
		$dist_data = 'RDIRECT';
		if(isset($customer["CustomerBGP"]['partner_code']) && $customer["CustomerBGP"]['partner_code'] != ''){
			$dist_data = $customer["CustomerBGP"]['partner_code'];
		}
  		
  		$dist_data = 'RDIRECT';
		if(isset($customer["CustomerBGP"]['partner_code']) && $customer["CustomerBGP"]['partner_code'] != ''){
			$dist_data = $customer["CustomerBGP"]['partner_code'];
		}
  		
		
		$bank_name = '';
		$branch_name = '';
		$tenture = '';
		$monthly_sub_amt = '';
		
		
  		$app_no = $customer["CustomerBGP"]["application_no"];
		$dist_data = 'RDIRECT';
		if(isset($customer["CustomerBGP"]['partner_code']) && $customer["CustomerBGP"]['partner_code'] != ''){
			$dist_data = $customer["CustomerBGP"]['partner_code'];
		}
		
		$toname ="";
		$toname = $customer["CustomerBGP"]['applicant_name'];
		
		if( $customer["CustomerBGP"]['monthly_sip_pdc']== 'SIP'){
			$bank_name = $customer["CustomerBGP"]['ecs_bank_name'];
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['ecs_amount_of_subscription'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
				
			$branch_name = $customer["CustomerBGP"]['ecs_branch_address'];
		}else{
			$bank_name = '';
			$tenture = $customer["CustomerBGP"]['tenure'];
			//$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			if($customer["CustomerBGP"]['amount'] != '0')
				$monthly_sub_amt = $customer["CustomerBGP"]['amount'];
			else 
				$monthly_sub_amt = '';
			
			$branch_name = '';
		}
		
		$branch_name = str_replace('\r\n',' ',$branch_name);
		
		
		
		$html_gen = '
			<html>
			<head>
			
			<style>
			/**** Common Style *****/
			
			.fontsize18{ font-size:18px;}
.title{ background:#d1d2d4; font-size:18px; line-height:24px; text-align:center;}
.txtjustify{ text-align:justify;}
.monthInput{border-bottom:1px solid #333; width:45px; height:22px; text-align:center; text-transform:uppercase;}
.yearInput{border-bottom:1px solid #333; width:60px; height:22px; text-align:center; text-transform:uppercase;}
			
			div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
				margin:0;
				padding:0;
			}
			html, body {
				font-size:13px;
				text-align:left;
				color:#373435;
				font-family: Arial, Helvetica, sans-serif;
				direction: ltr;
				font-weight:normal;
				margin:0;
				padding:0px 0 0 0;
				background: #fff;
			}
			
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.paddingT5		{padding-top:5px;}
			.paddingB5		{padding-bottom:5px;}
			.paddingT		{padding-top:10px;}
			.paddingL		{padding-left:10px;}
			.paddingR		{padding-right:10px;}
			.paddingB		{padding-bottom:10px;}
			.marginr15		{margin-right:15px;}
			.paddingL5		{padding-left:5px;}
			.paddingR5		{padding-right:5px;}
			
			.head2{ font-size:18px; color:#373435;}
			.rightTxt{ color:#373435;}
			.rightTxt a {color:#373435; text-decoration:none;}
			.codeBox{border:1px solid #333; width:25px; height:28px;}
			.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
			.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
			.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
			
			.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
			.taxStatusBorder{width:190px; }
			.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
			.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
			
			.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
			.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
			.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
			
			/**** Application Form 12-05-2014 ****/
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
			.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
			.underLine{width:90px;}
			.fontsize11{ font-size:11px;}
			.fontsize12{ font-size:12px;}
			.fontsize14{ font-size:14px;}
			.fontsize15{ font-size:15px;}
			.lF{ float:left;}
			.rF{ float:right;}
			.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
			.head2{ font-size:18px; color:#373435;}
			.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
			.bold{ font-weight:bold;}
			.Boxborder{border:1px solid #333;}
			.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
			.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
			.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
			.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
			.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.BoxborderBotm{border-bottom:1px solid #333;}
			.BoxborderRight{border-right:1px solid #333;}
			.BoxborderTop{border-top:1px solid #333;}
			.StatusBox{ width:120px;}
			.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
			.paddingTRBL5{ padding:5px;}
			.paddingTRBL{ padding:10px;}
			
			.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
			lable{ margin:0; padding:0;}
			
			/**** New class ****/ 
			.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
			.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
			.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
			.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
			table { margin:0; padding:0;}
			</style>
			
			</head>
			<body>
			
			
			<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;">
			
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td colspan="2" align="left" valign="top">
			    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			        <td width="840" align="left" valign="top" style="padding-right:10px;">
			            	<table width="820" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="410"><img src="img/logo.jpg" /></td>
			                    <td>
			                        <table width="250" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td colspan="2" class="head2">APPLICATION FORM &nbsp;</td>
			                          </tr>
			                          <tr>
			                            <td colspan="2" width="120" class="fontsize12">
			                            Application No. - '.$app_no.'
			                            </td>
			                          </tr>
			                        </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                    	<span class="fontsize14">Please select the fulfillment preference</span>
										
									<label><input name="input" type="checkbox" '.(($customer["CustomerBGP"]['fulfilment'] == "Coin") ? "checked=checked" : "").' value="" class="checkBox" /> Coin </label>
									<label><input name="input" type="checkbox" '.(($customer["CustomerBGP"]['fulfilment'] == "Jewellery") ? "checked=checked" : "").' value="" class="checkBox" /> Jewellery </label>
									<label><input name="input" type="checkbox" '.(($customer["CustomerBGP"]['fulfilment'] == "Pendant") ? "checked=checked" : "").' value="" class="checkBox" /> Pendant </label>';
									
							$html_gen.=	'<span class="fontsize11">(If not selected, default preference is Coin)</span>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                       <table width="820" border="0" cellspacing="0" cellpadding="0" class="borderTR">
			                          <tr>
			                            <td class="borderBL fontsize15" align="center">Distributor Code</td>
			                            <td class="borderBL fontsize15" align="center">Sub-Partner Code</td>
			                            <td class="borderBL fontsize15" align="center">For Office Use Only</td>
			                          </tr>
			                          <tr>
			                            <td class="borderBL" style="text-align:center">'.$dist_data.'</td>
			                            <td class="borderBL">'.$customer["CustomerBGP"]['sub_partner_code'].'</td>
			                            <td class="borderBL">&nbsp;</td>
			                          </tr>
			                         
			                      </table>
			                    </td>
			                  </tr>
			                </table>
			
			            </td>
						<td width="40"></td>
			          <td class="passPhoto bold" width="160" height="85" valign="middle" align="center">
			          		<br />Paste1 <br />
			                Passport size <br />
			                photograph
			            </td>
			          </tr>
			        </table>
			
			    </td>
			</tr>
			
			<tr>
			    <td height="15" colspan="2" align="left"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td>
			        <table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr></tr>
			          <tr>
			            <td width="695" class="bold fontsize14"><strong>1.APPLICANT DETAILS</strong></td>
			            <td width="305" align="left" class="paddingT5">*are Mandatory Fields</td>
			          </tr>
			          <tr>
			            <td colspan="2" class="Boxborder paddingB2 paddingT2" width="1000"><table width="1000" border="0" cellpadding="0" cellspacing="0">
			              <tr>
			                <td valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  
			                  
			                  <tr>
			                    <td class="paddingL" width="850"> *Name of Applicant (as mentioned on ID Proof)
			                      <label>
			                        Title </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mr. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Ms. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_title'] == "Mrs") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mrs. </label></td>
			                    	<td width="190" align="right" class="paddingR"> Gender*:
			                      <label>
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_gender'] == "Male") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Male</label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_gender'] == "Female") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Female</label></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			                <td class="paddingL">
			                	<input name="" type="text" class="add_input" style=" width:1001px;" value="'. $customer["CustomerBGP"]['applicant_name'].'" />
			                </td>
			              </tr>
			              <tr>
			                <td valign="top" class="paddingL paddingT2 paddingB2">
			                <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			                  <tr>
			                    <td headers="8"></td>
			                    <td class="paddingR"></td>
			                  </tr>
			                  <tr>
			                  
			                   <td width="670" style="padding:0;"><span style="width:80px;" class="lF">Status </span>
			                   
			                  	<label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_status'] == "Resident Individual") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Resident Individual </label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_status'] == "NRI") ? "checked=checked" : "").' value="" class="checkBox" />
			                        NRI </label>
			                      <label style="width:80px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_status'] == "HUF") ? "checked=checked" : "").' value="" class="checkBox" />
			                        HUF </label>
			                      <label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_status'] == "On behalf of Minor") ? "checked=checked" : "").' value="" class="checkBox" />
			                        On behalf of Minor </label>
			                      
			                     <div style="clear:both;"></div>
			                        <span style="width:93x;" class="lF">Proof of DOB* </span>
			                      <label style="width:129px;" class="lF paddingL">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_dob_proof'] == "Birth Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Birth Certificate</label>
			                      <label style="width:176px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_dob_proof'] == "Passport") ? "checked=checked" : "").' value="" class="checkBox" />
			                        School Leaving Certificate</label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_dob_proof'] == "School Leaving Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Passport</label>
			                      <label style="width:131px;" class="lF">
			                        <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_dob_proof'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />Others - '.$customer["CustomerBGP"]['applicant_dob_proof_other'].'</label>
			                  	</td>
			                  	
			                  	
			                    <td width="349" align="right" class="paddingR" style="padding-bottom:3px;"> 
			                      <table width="150" border="0" align="left" cellpadding="0" cellspacing="0">
			                        <tr>
			                          <td width="100">Date of Birth</td>
			                          
			                          <td class="DateBox" colspan="2">'.(($customer["CustomerBGP"]['applicant_dob'] != "0000-00-00") ? date('d',strtotime($customer["CustomerBGP"]['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="2">'.(($customer["CustomerBGP"]['applicant_dob'] != "0000-00-00") ? date('m',strtotime($customer["CustomerBGP"]['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="4">'.(($customer["CustomerBGP"]['applicant_dob'] != "0000-00-00") ? date('Y	',strtotime($customer["CustomerBGP"]['applicant_dob'])) : "").'</td>
			                          
			                        </tr>
			                      </table></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			              
			              <td class="paddingL BoxborderTop paddingT2" width="790"> Guardian Details (in case applicant is minor)
			                  <label> Title </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_guardian_title'] == "Mr" && $customer["CustomerBGP"]['applicant_guardian_name'] != '') ? "checked=checked" : "").' value="" class="checkBox"/>
			                    Mr. </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_guardian_title'] == "Ms" && $customer["CustomerBGP"]['applicant_guardian_name'] != '') ? "checked=checked" : "").' value="" class="checkBox" />
			                    Ms. </label>
		                  </td>
			              
			              </tr>
			              <tr>
			                <td height="" >
			                	&nbsp;<input name="" type="text" class="add_input" style="width:1006px;" value="'.$customer["CustomerBGP"]['applicant_guardian_name'].'"/>
			                </td>
			              </tr>
			              <tr>
			                <td class=" paddingL paddingT2">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="130">Country of Residence</td>
			                    <td align="left">
			                    	<input name="" type="text" class="residence_input" style="width:870px;" value="'.$customer["CustomerBGP"]['applicant_guardian_country_resident'].'"/>
			                        </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			              
			              
			              <tr>
			                <td class="paddingL paddingT2"><label class="lF" style="width:222px;">
			                  Relationship with minor</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_guardian_relationship'] == "Father" && $customer["CustomerBGP"]['applicant_guardian_name'] != '') ? "checked=checked" : "").' value="" class="checkBox" />
			                    Father </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_guardian_relationship'] == "Mother" && $customer["CustomerBGP"]['applicant_guardian_name'] != '') ? "checked=checked" : "").' value="" class="checkBox" />
			                    Mother</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['applicant_guardian_relationship'] == "Other" && $customer["CustomerBGP"]['applicant_guardian_name'] != '') ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other - '.(($customer["CustomerBGP"]['applicant_guardian_relationship_other'] != "") ? $customer["CustomerBGP"]['applicant_guardian_relationship_other'] : "______________").'</label>
			                  </td>
			              </tr>
			            
			              <tr>
			                    <td align="center" class="paddingB2 paddingT2 fontsize14"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        ---------------------------------------</strong></td>
			                  </tr>
			              <tr>
			                <td class="paddingL"><label class="lF" style="width:182px;">
			                  <input name="input" type="checkbox" value="" class="checkBox " />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:142px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Pan Card</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other ___________</label></td>
			              </tr>
			            </table></td>
			          </tr>
			          
			        </table></td>
			      </tr>
			    </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left">
			  		<table width="980" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td class="bold fontsize14 paddingT2"><strong>2.MAILING ADDRESS(*Fields are mandatory)</strong></td>
			          </tr>
			          <tr>
			            <td width="980" class=" Boxborder paddingB5 paddingL paddingT5">
			            	<table width="980" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="979">
			                    <textarea cols="" rows="2" style="width:983px;" class="add_txtarea">'.$customer["CustomerBGP"]['mailing_address'].'</textarea>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2">
			                    <table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="70">Landmark</td>
			                        <td ><input name="" type="text" class="add_input" style="width:906px;" value="'.$customer["CustomerBGP"]['mailing_landmark'].'" /></td>
			                      </tr>
			                    </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="680" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">City*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$customer["CustomerBGP"]['mailing_city'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Pin Code*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:220px;" value="'.$customer["CustomerBGP"]['mailing_pincode'].'" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="670" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">State*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$customer["CustomerBGP"]['mailing_state'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Country</td>
			                            <td width="30" >&nbsp;</td>
			                            <td width="" ><input name="" type="text" class="add_input" style="width:190px;" value="INDIA" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td>Overseas Address (Mandatory for NRI)</td>
			                  </tr>
			                  <tr>
			                    <td><input name="" type="text" class="add_input" value="'.$customer["CustomerBGP"]['mailing_overseas_address'].'" /></td>
			                  </tr>
			                  <tr>
			                    <td align="center" class="paddingB5 paddingT5 fontsize15"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        -----------------------------------------
			                    	</strong></td>
			                  </tr>
			                  <tr width="970">
			                    <td class="paddingB5 paddingT5">
			                   <label class="lF" style="width:120px;">
			                  <input name="input" type="checkbox" value="" class="checkBox" />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:110px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:111px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  
			                    <label class="lF" style="width:112px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Ration Card</label>
			                    <label class="lF" style="width:172px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Lease or Sale Agreement</label>
			                    <label class="lF" style="width:222px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Bank Statement/Passbook</label>
								
			                    
			                        
			                    </td>
			                  </tr>
							  <tr>
							  	<td>
									 <label class="lF" style="width:180px;">
										<input name="input" type="checkbox" value="" class="checkBox lF" />Latest Utility Bill</label>
								<label class="lF" style="width:190px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Gas Bill</label>
			                  	<label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other____________</label>
								</td>
							  </tr>
			                  <tr>
			                    <td class="paddingT5 fontsize11" width="950">
			                    **Not more than 3 months old proof of address issued by any of the following: Bank Managers of Schedule Commercial Bank/Schedule Co-operative Bank/Multinational Foreign Bank
			Gazetted oficer/Notary Public/ElectedRepresentatives to the Representative to the Legislative Assembly/Parliament/Document issued by Govt. or Statutory Authority.
			                    </td>
			                  </tr>
			                  
			                </table>
			
			            </td>
			          </tr>
			        </table>
			
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" valign="top" class="paddingB5 paddingT5">
			  <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14 paddingB paddingT">
			      	3. CONTACT DETAILS and PAN DETAIL (*Fields are mandatory)
			      </td>
			    </tr>
			    <tr>
			      <td class="paddingTRBL5" style="padding-left:0;">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="borderBL">
			        <tr>
			          <td width="80" class="paddingT2 paddingB2 borderTR">&nbsp; Phone</td>
			          <td width="120" class="paddingT2 paddingB2 borderTR">&nbsp; Residence</td>
			          <td width="230" class="paddingT2 paddingB2 borderTR">'.$customer["CustomerBGP"]['contact_phone_residence'].'</td>
			          <td width="90" class="paddingT2 paddingB2 borderTR">&nbsp; Office</td>
			          <td width="200" class="paddingT2 paddingB2 borderTR">'.$customer["CustomerBGP"]['contact_phone_office'].'</td>
			          <td width="300" class="paddingT2 paddingB2 borderTR">&nbsp; PAN No.- '.$customer["CustomerBGP"]['contact_pan_no'].'</td>
			        </tr>
			      </table></td>
			    </tr>
			    <tr>
			      <td height="20" >
					  <table width="1010" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			          <td width="480" align="left" >
			          <table width="480" border="0" cellspacing="0" cellpadding="0" class="Boxborder">
			            <tr>
			              <td width="180" class="BoxborderRight">&nbsp; Mobile*</td>
			              <td width="300">'.$customer["CustomerBGP"]['contact_mobile'].'</td>
			            </tr>
			          </table>
			          </td>
			          <td width="30"></td>
			          <td width="488">
			          <table width="490" border="0" align="right" cellpadding="0" cellspacing="0" class="Boxborder">
			            <tr>
			              <td width="170" class="BoxborderRight">&nbsp; E-mail</td>
			              <td width="338">'.$customer["CustomerBGP"]['contact_email'].'</td>
			            </tr>
			          </table>
			          </td>
			        </tr>
			      </table>
				  
				  </td>
			    </tr>
			    <tr>
			      <td class="fontsize11 paddingL5">I agree to receive updates via SMS on my registered mobile and to receive Account Statements / other statutory as well as other information documents on my registered email in lieu of physical documents</td>
			    </tr>
			    <tr>
			    
			    <td class="paddingB5 paddingT5 BoxborderBotm BoxborderTop fontsize11">
			       <span class="lF bold" style="width:90px;">Occupation</span>
			                   <label class="lF" style="width:101px;">
			                  <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Private Sector") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Private Sector</label>
			                  <label class="lF" style="width:129px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Government Service") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Government Service </label>
			                  <label class="lF" style="width:82px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Business") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Business</label>
			                  <label class="lF" style="width:96px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Professional") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Professional </label>
			                  <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Agriculturist") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Agriculturist </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Retired") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Retired </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Housewife") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Housewife</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['occupation'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other _______</label>
			                        
            	  </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14">3.PAYMENT DETAILS</td>
			    </tr>
			    <tr>
			      <td width="1000" class=" Boxborder  ">
			      		<table width="995" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="490" valign="top" class="paddingB2 BoxborderRight paddingL5">
			                	<table width="500" border="0" align="right" cellpadding="0" cellspacing="0">
			                      <tr>
			                        <td class="bold fontsize14  paddingT2 paddingB2">
			                        	<span style="text-decoration:underline;">Initial Subscription Details</span></td>
			                      </tr>
			                      <tr>
			                        <td class="">
			                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150">Amount(Rs.)</td>
			                                <td><p>
			                                  <input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value="'.$customer["CustomerBGP"]['initial_amount'].'" />
			                                </p></td>
			                              </tr>
			                              <tr>
			                                <td>Mode of Payment</td>
			                                ';
											if($customer["CustomerBGP"]['initial_pay_by'] == 'Online'){
												$html_gen.= '<td class="paddingT2">
			                                	Online
			                                </td>';
											}else{
												$html_gen.= '<td class="paddingT2">
			                                	<label class="lF" style="width:90px;"><input name="" type="checkbox" '.(($customer["CustomerBGP"]['initial_pay_by'] == "Cheque") ? "checked=checked" : "").' value="" class="checkBox" /> Cheque </label>
			                                    <label class="lF" style="width:60px;"><input name="" type="checkbox"  value="" class="checkBox" /> DD </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> Payorder </label>
			                                	</td>';
											}
			                               $html_gen.= '</tr>';
			                               
			                              if($customer["CustomerBGP"]['initial_pay_by'] == 'Online'){
				                              	$html_gen.= '
				                              	<tr>
					                                <td>Transaction ID</td>
					                                <td class="paddingT2">'.$payment["PaymentMaster"]['mmp_txn'].'</td>
				                              	</tr>
				                              	<tr>
					                                <td>Transaction Date</td>
					                                <td class="paddingT2">'.date("d-m-Y", strtotime($payment["PaymentMaster"]['date'])).'</td>
				                              	</tr>
				                              	<tr>
					                                <td>Bank Details</td>
					                                <td class="paddingT2">
					                                	'.$payment["PaymentMaster"]['bank_name'].'
					                                </td>
				                              	</tr>
				                              	<tr>
					                                <td>Bank Transaction</td>
					                                <td class="paddingT2">
					                                	'.$payment["PaymentMaster"]['bank_txn'].'
					                                </td>
				                              	</tr>
				                              	';
			                              }else{
				                              	$html_gen.= '<tr>
				                                <td>Cheque/DD/Payorder No.</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Cheque/DD/Payorder Date</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Bank Name<br />
				                                Bank Branch</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Account Number</td>
				                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Account Type</td>
				                                <td class="paddingT5">
					                                <label class="lF" style="width:64px;"><input name="" type="checkbox" value="" class="checkBox" /> Saving </label>
				                                    <label class="lF" style="width:64px;"><input name="" type="checkbox"  value="" class="checkBox" /> Current </label>
				                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" value="" class="checkBox" /> NRE </label>
				                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> NRO </label>
				                                </td>
				                              </tr>';
			                              }
			                            $html_gen.= '</table>
			                        </td>
			                      </tr>
			                    </table>
			
			                </td>
			                <td width="549" valign="top" class="paddingL5">
			                	 <table width="545" border="0" align="right" cellpadding="0" cellspacing="0">
			                  <tr>
			                     <td>
			                     	<table width="545" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="360" class="paddingT2 paddingB5"><span class="bold fontsize14" style="text-decoration:underline;">Monthly Subscription Details</span>
			                            	<div><label class="paddingT2 lF"><input name="" type="checkbox" value="" class="checkBox" /> SIP through Auto-Debit(ECS/Direct Debit)</label></div>
			                            </td>
			                            <td width="20"><input name="" type="checkbox" value="" class="checkBox" '.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' /> </td>
										<td width="30"> SIP</td>
			                            <td width="20"><input name="" type="checkbox"  value="" class="checkBox" '.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "PDC") ? "checked=checked" : "").' /> </td>
										<td width="30"> PDC</td>
										<td width="10">&nbsp;</td>
			                          </tr>
			                        </table>
			                     </td>
			                   </tr>
			                  
			                  <tr>
			                    <td>
			                    	
			                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150" valign="top">Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['bank_name'] : "").'" /></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['account_number'] : "").'"/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT2">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($customer["CustomerBGP"]['account_type'] == "Saving" && $customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP" ) ? "checked=checked" : "").' value="" class="checkBox"  /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($customer["CustomerBGP"]['account_type'] == "Current" && $customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").'  value="" class="checkBox"  /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" '.(($customer["CustomerBGP"]['account_type'] == "NRE" && $customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox"  /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" '.(($customer["CustomerBGP"]['account_type'] == "NRO" && $customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                          </table> 
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 BoxborderBotm paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['amount'] : "").'" /></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['tenure'] : "").'" class="app_inputBox" style="width:25px;"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['period_from'] : "").'" /> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "SIP") ? $customer["CustomerBGP"]['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                  	<td class="paddingT2"><label><input name="" type="checkbox" value="" class="checkBox" /> </label>SIP through Post Dated Cheque</td>
			                  </tr>
			                  <tr>
			                    <td class="">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "PDC") ? $customer["CustomerBGP"]['amount'] : "").'"/></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" class="app_inputBox" style="width:25px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "PDC") ? $customer["CustomerBGP"]['tenure'] : "").'"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "PDC") ? $customer["CustomerBGP"]['period_from'] : "").'"/> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($customer["CustomerBGP"]['monthly_sip_pdc'] == "PDC") ? $customer["CustomerBGP"]['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Cheque No. From <input name="" type="text" class="app_inputBox" style="width:75px;" value="'.$customer["CustomerBGP"]['cheque_number_from'].'"/> to <input name="" type="text" value="'.$customer["CustomerBGP"]['cheque_number_to'].'" class="app_inputBox" style="width:75px;"/></td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			            </table>
			      </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT2">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			         <td class="bold fontsize14 paddingB5">
			          	4.NOMINATION DETAILS (Mandatory)
			          </td>
			        </tr>
			        <tr>
			          <td class="Boxborder paddingL5">
			          	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="520" align="center" class="fontsize14">Name and Address of Nominee</td>
			                <td width="520" align="center" class="fontsize14">Name and Address of Guardian(if Nominee is Minor)</td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                      <td width="60">Name</td>
			                        <td >  <input name="input3" type="text" class="inputBoxDtl-4" value="'.$customer["CustomerBGP"]['nomination_name'].'"/>
			                        </td>
			                      <td width="60">Name</td>
			                        <td >  <input name="input4" type="text" class="inputBoxDtl-4" value="'.$customer["CustomerBGP"]['nomination_guardian_name'].'"/>
			                        </td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="60">Address</td>
			                        <td><input name="input6" type="text" class="inputBoxDtl-2" style="width:926px; float:left;" value="'.$customer["CustomerBGP"]['nomination_address'].'"/></td>
			                      </tr>
			                    </table>
			
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">City</td>
			                    <td><input name="input5" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$customer["CustomerBGP"]['nomination_city'].'"/></td>
			                    <td width="60"> State </td>
			                    <td width="230"><input name="input7" type="text" class="inputBoxDtl-2" style="width:477px;" value="'.$customer["CustomerBGP"]['nomination_state'].'"/></td>
			                  </tr>
			                </table>
			
			                <!--<span style="width:60px; float:left;">&nbsp;&nbsp;</span>
			                  <input name="input5" type="text" class="inputBoxDtl-2" style="width:602px;"/>
			                  City
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:280px;"/>-->
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="990" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">Pin Code</td>
			                    <td><input name="input4" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$customer["CustomerBGP"]['nomination_pincode'].'"/></td>
			                    <td width="210"> Guardian Relationship with Minor </td>
			                    <td width=""><input name="input7" type="text" class="inputBoxDtl-2" style="width:328px;" value="'.$customer["CustomerBGP"]['nomination_guardian_realtion'].'"/></td>
			                  </tr>
			                </table>
			
			                </td>
			              </tr>
			              
			              <tr>
			                <td class="paddingT2">
			                	<span style="width:130px; float:left;">Relationship with Applicant</span>
			                    <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.$customer["CustomerBGP"]['nomination_applicant_realtion'].'"/>
			                </td>
			                <td rowspan="2" align="right" class="paddingT5 paddingB2" style="padding-right:10px;">
			                    <table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			                      <tr>
			                        <td height="45" width="450" valign="middle" style="color:#ccc;">Signature of Guardian</td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
			              <tr>
			                <td class="paddingT2"><span style="width:130px; float:left;">Date of Birth <br />
			                  (In case of Minor)</span>
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.(($customer["CustomerBGP"]['nomination_dob'] != "0000-00-00") ? date('d-m-Y',strtotime($customer["CustomerBGP"]['nomination_dob'])) : "").'"/></td>
			                </tr>
			            </table>
			
			          </td>
			        </tr>
			      </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			<p class="fontsize15">Declaration:-</p>
			<p class="fontsize11" style="text-align:justify;">I propose to enroll with Birla Gold Plus, subject to terms & conditions of the product brochures as amended from time to time. I have read and understood (before Filling the application form)
& Conditions in the product brouchures, and I accept the same. I have neither received nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Plus.I hereby
declare that the subscriptions proposed to be remitted in Birla Gold Plus will be from legitimate sources only and will not be with any intention to contravene/evade/avoid any legal/statutory/regulatory
requirements. I understand that Birla Gold & Precious Metals Pvt. Ltd.,may, at its absolute discretion, discontinue any or all of the services by giving prior notice to me. I hereby authorise BGPM to debit
my customer ID with the service charges as applicable from time to time. I hereby authorise the aforesaid nominee to receive all the gold accrued to my credit, in the event of my death. Signature of the
nominee acknowledging receipts of the proceeds of Birla Gold shall constitute full discharge of liabilities of Birla Gold in respect of my Customer ID.</p>     
			     
			                                                          
			  </td>
			</tr>
			
			
			<tr>
			  <td align="left" width="450">
			  
			 <p> Date :- '.$customer["CustomerBGP"]['declaration_date'].'</p>
			
			<p> Place :- '.$customer["CustomerBGP"]['declaration_place'].' </p>
			  
			  </td>
			  <td align="right" style="padding-right:10px;">
			  	<table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			      <tr>
			        <td width="450" height="45" valign="middle" style="color:#ccc;">Signature of Investor</td>
			      </tr>
			    </table>
			  </td>
			</tr>
			  
			  
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			  	
			    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    
			          <tr>
			        <td colspan="2" align="left"height="10"></td>
			        </tr>
			
			      <tr>
			        <td width="790" align="left" class="paddingT fontsize15 bold" style="border-top:2px dashed #333;">
			    	<div style="text-align:center; display:block; border:2px solid #ccc; height:30px; width:759px; padding-top:10px;"> Acknowledgment Slip (to be filled by Customer) </div>
			    </td>
			         <td width="250" align="center" valign="middle" class="paddingT fontsize15" style="border-top:2px dashed #333;">Application No. - '.$app_no.'</td>
			      </tr>
			    </table>
			    
			  </td>
			  </tr>
			
			<tr>
			  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
				  <p>Received with thanks from Mr./Ms./Mrs_______________________________________________an application for allotment</p><br/>
			<p>of gold gram under BGP as per the advance payment details below:-<br/></p>
			<p>
			Amount ____________Payment Mode: Cheque/DD/Payorder Instrument No.__________________Date ________________</p><br/>
			
			<p>Bank Name_________________________________________Branch____________________________Tenure__________</p><br/>
			
			<p>Monthly Subscription Option: ECS / Direct Debit / PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monthly Subscription Amount_____________________</p>
			</td>
			      <td align="center" class="paddingL">
			      
			      
			        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
			          <tr>
			            <td align="center" width="180" style="border:2px dotted #333; height:80px; text-align:center;">
			            <p>&nbsp;</p>
			            Collection Center Date and Stamp
			            </td>
			          </tr>
			        </table>
			      
			      </td>
			    </tr>
			  </table></td>
			  </tr>
			  
			  <tr>
              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
                	Birla Gold and Precious Metals Pvt Ltd
                </td>
              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
              </tr>
			  </table>
			
			  
			</div>
			<div style="width:1000px; border:0px solid #666; padding:10px 10px 10px 40px; margin:0 auto;">

  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="499" valign="top" style="padding-top:15px"><img src="img/logo.jpg" />
                <p class="fontsize14 paddingT"> Birla Gold and Precious Metals Pvt Ltd <br />
                  Morya Landmark II,G-002,Ground Floor, <br />
                  New Link Road,Andheri(W),Mumbai-400 053 </p></td>
              <td width="501" align="right" valign="top"><strong class="fontsize15"> Application No. - '.$app_no.'</strong></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" class="paddingB paddingT"><h4 class="fontsize18">Electronic Clearing Service<br />
        RBI-ECS Debit / Direct Debit collection Mandate form</h4></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingB paddingT txtjustify"> I/We the account holders with the Bank as per details below hereby request and authorize the Bank to accept this ECS Debit(Clearing)/Direct Debit
        mandate executed by me/us in favour of <strong>M/s Birla Gold and Precious Metals Private Limited</strong> and submitted by them or through their authorized
        service provider under RBI ECS debit procedures. I/We further request and authorize the bank to debit my/our account to honor the periodical payment
        contribution requests presented by the service provider. Various details of bank account and periodical payment are furnished below: </td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="25" class="title">BANK ACCOUNT DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT paddingB txtjustify"> I/We hereby authorize <strong>Birla Gold and Precious Metals Private Limited</strong> and their authorized service providers to debit my/our following
            bank account by ECS Debit (Clearing)/Direct Debit to account for collection of Monthly Subscription Payments (Applicant should be amongst
            one of bank account holders). </td>
        </tr>
        <tr>
          <td class="paddingB5"> 
          	<table width="990" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="160">Bank Account Number:</td>
                        <td width="830">'.$customer["CustomerBGP"]['ecs_bank_account_number'].'</td>
                      </tr>
                      <tr>
                        <td>Account Type:</td>
                        <td class="paddingB5 paddingT5">
                        <table width="830" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="input" type="checkbox" value="" '.(($customer["CustomerBGP"]['ecs_bank_account_type'] == "Saving") ? "checked=checked" : "").' class="checkBox" /> Savings</td>
                            <td><input name="input" type="checkbox" value="" '.(($customer["CustomerBGP"]['ecs_bank_account_type'] == "Current") ? "checked=checked" : "").' class="checkBox" /> Current</td>
                            <td><input name="input" type="checkbox" value="" '.(($customer["CustomerBGP"]['ecs_bank_account_type'] == "NRE") ? "checked=checked" : "").' class="checkBox" /> NRE</td>
                            <td><input name="input" type="checkbox" value="" '.(($customer["CustomerBGP"]['ecs_bank_account_type'] == "NRO") ? "checked=checked" : "").' class="checkBox" /> NRO</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Account Holders Name (1st holder): '.$customer["CustomerBGP"]['ecs_account_holder_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Name:'.$customer["CustomerBGP"]['ecs_bank_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Branch Name/Address: '.$customer["CustomerBGP"]['ecs_branch_address'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110">Bank City/Town: </td>
                        <td width="442">'.$customer["CustomerBGP"]['ecs_city'].'</td>
                        <td width="30">&nbsp;</td>
                        <td width="142" align="right">PIN CODE:</td>
                        <td width="266" align="left">'.$customer["CustomerBGP"]['ecs_pincode'].'</td>
                      </tr>
                    </table>

                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5"><table width="990" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="260">Bank Branch MICR Number (9 DIGITS) : </td>
                    <td width="342">'.$customer["CustomerBGP"]['ecs_branch_micr'].'</td>
                    <td width="35">&nbsp;</td>
                    <td width="100" align="right">IFSC CODE:</td>
                    <td width="263" align="left">'.$customer["CustomerBGP"]['ecs_ifsc_code'].'</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td style="font-size:13px;">as appearing in Cheque leaf-please attach a copy of cancelled cheque/bankers attestation. MICR Code starting and/or ending with 000 are not valid for ECS.</td>
              </tr>
            </table>

          </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td height="30" align="left" class="paddingT2 title"> PERIODIC PAYMENT DETAILS <span class="fontsize14">(Please refer payment mode section)</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingT fontsize15"><table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="35" valign="middle"> Debit Date (tick applicable date)
            <input name="input" type="checkbox" '.(($customer["CustomerBGP"]['ecs_debit_date'] == "10") ? "checked=checked" : "").' value="" class="checkBox" />
            10
            <input name="input2" type="checkbox" '.(($customer["CustomerBGP"]['ecs_debit_date'] == "20") ? "checked=checked" : "").' value="" class="checkBox" />
            20 </td>
          <td>Amount of Subscription:'.$customer["CustomerBGP"]['ecs_amount_of_subscription'].'</td>
        </tr>
        <tr>
          <td class="paddingT2"> From:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="border:0; width:70px !important" value="'.$customer["CustomerBGP"]['ecs_from'].'" />
            
            To:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="width:70px !important" value="'.$customer["CustomerBGP"]['ecs_to'].'" />
            
          <td class="paddingT2"> Frequency: MONTHLY </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT2 paddingB"><table width="1030" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1030" height="30" class="paddingT2 title"> CONTRIBUTION DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT"><table width="1020" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="450" class="paddingT5">Beneficiary Name: <strong>Birla Gold and Precious Metals Pvt. Ltd</strong></td>
              <td>Product Code: <strong>BGP</strong></td>
              <td width="415" align="right">Product Name: <strong> Birla Gold Plus</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer ID/Folio No. ___________________________________________________________________________________________________________________________________</td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer/Contributors Name_____________________________________________________________________________________________________________________________</td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" valign="top" class="paddingT5 paddingB5"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">DECLARATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT5"> I/We wish to inform you that I/We have registered for the subject scheme for the contribution payment to the bene?ciary as per account details as above
by debit to said Bank Account. I/We express my willingness for participation in ECS/Direct Debit scheme. I declare that the particulars given above
are correct and complete. I/We agree to discharge the responsibility expected of me as a participant under the ECS/Direct Debit scheme. I/We hereby
authorize the bene?ciary or their representatives to get this mandate lodged with bank/get veri?ed and further execute by raising debits on the applicable
dates through ECS/Direct Debit scheme. If the mandate is not lodged/transaction is not collected or delayed for reasons beyond control of the bene?ciary/service
provider representative or on account of incomplete or incorrect information, I/We shall not hold them responsible. I/We shall keep indemni?ed for
claims and actions, that bene?ciary or representative may incur, for execution of transactions in conformity with this mandate.
           </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT5 paddingB5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">AUTHORISATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT paddingB" > I/We hereby request and authorize the bank to honor the periodic debit instructions raised as above and cause my account to be debited accordingly. Charges,
if any, for mandate veri?cation/registration may be debited to my account. I hereby undertake to keep suf?cient funds in the account well prior to the applicable
date and till the date of execution. If the date of debit happens to be a holiday or non working day for the bank or location, the debit may happen on any subsequent
working day. Debited contributions may be passed on to the bene?ciary/representative as per rules, procedures and practices in force. I/We shall not dispute any
debit raised under this mandate and as speci?ed therein and during or for the validity period. I/We shall keep indemni?ed for claims that Bank may incur for reason
of execution in conformity with this mandate. </td>
        </tr>
        <tr>
          <td width="980" class="paddingT">
          <table width="980" border="1" cellspacing="0" cellpadding="0" class="fontsize18 borderBL">
            <tr>
              <td align="center" class="borderTR">As per Bank Record</td>
              <td align="center" class="borderTR">1st Account Holder</td>
              <td align="center" class="borderTR">2nd Account Holder</td>
              <td align="center" class="borderTR">3rd Account Holder</td>
            </tr>
            <tr>
              <td align="center" class="borderTR">Name</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" class="borderTR" style="height:60px">Signature</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr><td height="10"></td></tr>
    <tr>
      <td height="30" align="center" class="paddingT5 title paddingB5"> FOR BANK USE ONLY </td>
    </tr>
    <tr>
      <td class="txtjustify fontsize15 paddingT"> Certified that the bank account details and signatures of the account holders are correct and as per '."bank's".' records. </td>
    </tr>
	
	
	
    <tr>
      <td class="txtjustify fontsize15"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="527">Date:____________________</td>
          <td width="473" align="center">_______________________________________________</td>
        </tr>
        <tr>
          <td width="527">&nbsp;</td>
          <td align="center" class="paddingT">Stamp & Signature of the Authorized Official of the Bank</td>
        </tr>
      </table></td>
    </tr>
	
	 <tr>
		<td height="28" valign="bottom">
			 <table width="1000" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="500" align="left" style="font-size:12px;">Birla Gold and Precious Metals Pvt Ltd</td>
				<td width="500" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
			  </tr>
			</table>
		</td>
	  </tr>
  </table>
</div>
			
			
			</body>
			</html>
			';
			
			// $date = date_create();
			// $pdf_time = date_timestamp_get($date);
			
			$this->Mpdf->init();
			$this->Mpdf->WriteHTML($html_gen);
			$filename = $customer["CustomerBGP"]['application_no'].'_AC'.".pdf";
			$this->Mpdf->Output($filename."_form.pdf","D");

			exit;

  	}
	
	public function getState()
	{
		/* require 'includeAll.php';
		$state = $db->FetchToArray('state_master', "state_name", "active='1'"); */
		
		$state = $this->StateMaster->find('all', array('conditions' => array('active' => "1")));
		
		if(!empty($state))
		{
			$html = '<select class="span7" name="data[CustomerBGP][mailing_state]" id="mailing_state">';
			
			foreach($state as $val)
			{
				$html .= "<option value='".$val['StateMaster']["state_name"]."'>".$val['StateMaster']["state_name"]."</option>";
			}
			
			$html .= '</select>';
			
			$html .= '::<select class="span7" name="data[CustomerBGP][nomination_state]" id="nomination_state">';
			
			foreach($state as $val)
			{
				$html .= "<option value='".$val['StateMaster']["state_name"]."'>".$val['StateMaster']["state_name"]."</option>";
			}
			
			$html .= '</select>';
			
			echo $html;
		}
		exit;
	}
	
	public function generateForm_dn()
	{
		ini_set('memory_limit', '-1');
		
		$table_id = 'application_no';
		
		if(isset($_GET) && !empty($_GET))
		{
  			$id = $_GET['id'];
  			$savefile = false;
		}
		
  		
  		$result_data = $this->CustomerBGP->find('all', array('conditions' => array('application_no' => $id)));
		
//$payment = $this->PaymentMaster->find('first', array('conditions' => array('mer_txn' => $customer["CustomerBGP"]["application_no"])));
		

  		$app_no = $result_data[0]['CustomerBGP']['application_no'];
//  		print_r($result);exit;

  		$dist_data = 'RDIRECT';
		if(isset($result_data[0]['CustomerBGP']['partner_code']) && $result_data[0]['CustomerBGP']['partner_code'] != ''){
			$dist_data = $result_data[0]['CustomerBGP']['partner_code'];
		}
  		
		$html = '
			<html>
			<head>
			
			<style>
			/**** Common Style *****/
			
			.fontsize18{ font-size:18px;}
.title{ background:#d1d2d4; font-size:18px; line-height:24px; text-align:center;}
.txtjustify{ text-align:justify;}
.monthInput{border-bottom:1px solid #333; width:45px; height:22px; text-align:center; text-transform:uppercase;}
.yearInput{border-bottom:1px solid #333; width:60px; height:22px; text-align:center; text-transform:uppercase;}
			
			div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
				margin:0;
				padding:0;
			}
			html, body {
				font-size:13px;
				text-align:left;
				color:#373435;
				font-family: Arial, Helvetica, sans-serif;
				direction: ltr;
				font-weight:normal;
				margin:0;
				padding:0px 0 0 0;
				background: #fff;
			}
			
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.paddingT5		{padding-top:5px;}
			.paddingB5		{padding-bottom:5px;}
			.paddingT		{padding-top:10px;}
			.paddingL		{padding-left:10px;}
			.paddingR		{padding-right:10px;}
			.paddingB		{padding-bottom:10px;}
			.marginr15		{margin-right:15px;}
			.paddingL5		{padding-left:5px;}
			.paddingR5		{padding-right:5px;}
			
			.head2{ font-size:18px; color:#373435;}
			.rightTxt{ color:#373435;}
			.rightTxt a {color:#373435; text-decoration:none;}
			.codeBox{border:1px solid #333; width:25px; height:28px;}
			.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
			.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
			.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
			
			.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
			.taxStatusBorder{width:190px; }
			.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
			.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
			
			.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
			.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
			.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
			
			/**** Application Form 12-05-2014 ****/
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
			.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
			.underLine{width:90px;}
			.fontsize11{ font-size:11px;}
			.fontsize12{ font-size:12px;}
			.fontsize14{ font-size:14px;}
			.fontsize15{ font-size:15px;}
			.lF{ float:left;}
			.rF{ float:right;}
			.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
			.head2{ font-size:18px; color:#373435;}
			.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
			.bold{ font-weight:bold;}
			.Boxborder{border:1px solid #333;}
			.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
			.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
			.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
			.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
			.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.BoxborderBotm{border-bottom:1px solid #333;}
			.BoxborderRight{border-right:1px solid #333;}
			.BoxborderTop{border-top:1px solid #333;}
			.StatusBox{ width:120px;}
			.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
			.paddingTRBL5{ padding:5px;}
			.paddingTRBL{ padding:10px;}
			
			.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
			lable{ margin:0; padding:0;}
			
			/**** New class ****/ 
			.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
			.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
			.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
			.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
			table { margin:0; padding:0;}
			</style>
			
			</head>
			<body>
			
			
			<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;">
			
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td colspan="2" align="left" valign="top">
			    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			        <td width="840" align="left" valign="top" style="padding-right:10px;">
			            	<table width="820" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="410"><img src="img/logo.jpg" />
								</td>
			                    <td>
			                        <table width="250" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td colspan="2" class="head2">APPLICATION FORM &nbsp;</td>
			                          </tr>
			                          <tr>
			                            <td colspan="2" width="120" class="fontsize12">
			                            Application No. - '.$app_no.'
			                            </td>
			                          </tr>
			                        </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                    	<span class="fontsize14">Please select the fulfillment preference</span>;
			                    	
										<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Coin") ? "checked=checked" : "").' value="" class="checkBox" /> Coin </label>
										<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Jewellery") ? "checked=checked" : "").' value="" class="checkBox" /> Jewellery </label>
										<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Pendant") ? "checked=checked" : "").' value="" class="checkBox" /> Pendant </label>';
								
				$html.=	   '<span class="fontsize11">(If not selected, default preference is Coin)</span>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                       <table width="820" border="0" cellspacing="0" cellpadding="0" class="borderTR">
			                          <tr>
			                            <td class="borderBL fontsize15" align="center">Distributor Code</td>
			                            <td class="borderBL fontsize15" align="center">Sub-Partner Code</td>
			                            <td class="borderBL fontsize15" align="center">For Office Use Only</td>
			                          </tr>
			                          <tr>
			                            <td class="borderBL" style="text-align:center">'.$dist_data.'</td>
			                            <td class="borderBL">'.$result_data[0]['CustomerBGP']['sub_partner_code'].'</td>
			                            <td class="borderBL">&nbsp;</td>
			                          </tr>
			                         
			                      </table>
			                    </td>
			                  </tr>
			                </table>
			
			            </td>
						<td width="40"></td>
			          <td class="passPhoto bold" width="160" height="85" valign="middle" align="center">
			          		<br />Paste1 <br />
			                Passport size <br />
			                photograph
			            </td>
			          </tr>
			        </table>
			
			    </td>
			</tr>
			
			<tr>
			    <td height="15" colspan="2" align="left"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td>
			        <table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr></tr>
			          <tr>
			            <td width="695" class="bold fontsize14"><strong>1.APPLICANT DETAILS</strong></td>
			            <td width="305" align="left" class="paddingT5">*are Mandatory Fields</td>
			          </tr>
			          <tr>
			            <td colspan="2" class="Boxborder paddingB2 paddingT2" width="1000"><table width="1000" border="0" cellpadding="0" cellspacing="0">
			              <tr>
			                <td valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  
			                  
			                  <tr>
			                    <td class="paddingL" width="850"> *Name of Applicant (as mentioned on ID Proof)
			                      <label>
			                        Title </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mr. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Ms. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mrs") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mrs. </label></td>
			                    <td width="190" align="right" class="paddingR"> Gender*:
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Male") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Male</label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Female") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Female</label></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			                <td class="paddingL">
			                	<input name="" type="text" class="add_input" style=" width:1001px;" value="'. $result_data[0]['CustomerBGP']['applicant_name'].'" />
			                </td>
			              </tr>
			              <tr>
			                <td valign="top" class="paddingL paddingT2 paddingB2">
			                <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			                  <tr>
			                    <td headers="8"></td>
			                    <td class="paddingR"></td>
			                  </tr>
			                  <tr>
			                  
			                   <td width="670" style="padding:0;"><span style="width:80px;" class="lF">Status </span>
			                   
			                  	<label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "Resident Individual") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Resident Individual </label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "NRI") ? "checked=checked" : "").' value="" class="checkBox" />
			                        NRI </label>
			                      <label style="width:80px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "HUF") ? "checked=checked" : "").' value="" class="checkBox" />
			                        HUF </label>
			                      <label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "On behalf of Minor") ? "checked=checked" : "").' value="" class="checkBox" />
			                        On behalf of Minor </label>
			                      
			                     <div style="clear:both;"></div>
			                        <span style="width:93x;" class="lF">Proof of DOB* </span>
			                      <label style="width:129px;" class="lF paddingL">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Birth Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Birth Certificate</label>
			                      <label style="width:176px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Passport") ? "checked=checked" : "").' value="" class="checkBox" />
			                        School Leaving Certificate</label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "School Leaving Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Passport</label>
			                      <label style="width:131px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />Others - '.$result_data[0]['CustomerBGP']['applicant_dob_proof_other'].'</label>
			                  	</td>
			                  	
			                    <td width="349" align="right" class="paddingR" style="padding-bottom:3px;"> 
			                      <table width="150" border="0" align="left" cellpadding="0" cellspacing="0">
			                        <tr>
			                          <td width="60">Date of Birth</td>
			                          
			                          <td class="DateBox" colspan="2">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('d',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="2">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('m',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="4">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('Y	',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          
			                        </tr>
			                      </table></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			              
			              <td class="paddingL BoxborderTop paddingT2" width="790"> Guardian Details (in case applicant is minor)
			                  <label> Title </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox"/>
			                    Mr. </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Ms. </label>
		                  </td>
			              
			              </tr>
			              <tr>
			                <td height="" >
			                	&nbsp;<input name="" type="text" class="add_input" style="width:1006px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_name'].'"/>
			                </td>
			              </tr>
			              <tr>
			                <td class=" paddingL paddingT2">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="130">Country of Residence</td>
			                    <td align="left">
			                    	<input name="" type="text" class="residence_input" style="width:870px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_country_resident'].'"/>
			                        </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			              
			              
			              <tr>
			                <td class="paddingL paddingT2"><label class="lF" style="width:222px;">
			                  Relationship with minor</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Father") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Father </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Mother") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Mother</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other - '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship_other'] != "") ? $result_data[0]['CustomerBGP']['applicant_guardian_relationship_other'] : "______________").'</label>
			                  </td>
			              </tr>
			            
			              <tr>
			                    <td align="center" class="paddingB2 paddingT2 fontsize14"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        ---------------------------------------</strong></td>
			                  </tr>
			              <tr>
			                <td class="paddingL"><label class="lF" style="width:182px;">
			                  <input name="input" type="checkbox" value="" class="checkBox " />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:142px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Pan Card</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other ___________</label></td>
			              </tr>
			            </table></td>
			          </tr>
			          
			        </table></td>
			      </tr>
			    </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left">
			  		<table width="980" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td class="bold fontsize14 paddingT2"><strong>2.MAILING ADDRESS(*Fields are mandatory)</strong></td>
			          </tr>
			          <tr>
			            <td width="980" class=" Boxborder paddingB5 paddingL paddingT5">
			            	<table width="980" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="979">
			                    <textarea cols="" rows="2" style="width:983px;" class="add_txtarea">'.$result_data[0]['CustomerBGP']['mailing_address'].'</textarea>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2">
			                    <table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="70">Landmark</td>
			                        <td ><input name="" type="text" class="add_input" style="width:906px;" value="'.$result_data[0]['CustomerBGP']['mailing_landmark'].'" /></td>
			                      </tr>
			                    </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="680" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">City*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_city'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Pin Code*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:220px;" value="'.$result_data[0]['CustomerBGP']['mailing_pincode'].'" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="670" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">State*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_state'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Country</td>
			                            <td width="30" >&nbsp;</td>
			                            <td width="" ><input name="" type="text" class="add_input" style="width:190px;" value="INDIA" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td>Overseas Address (Mandatory for NRI)</td>
			                  </tr>
			                  <tr>
			                    <td><input name="" type="text" class="add_input" value="'.$result_data[0]['CustomerBGP']['mailing_overseas_address'].'" /></td>
			                  </tr>
			                  <tr>
			                    <td align="center" class="paddingB5 paddingT5 fontsize15"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        -----------------------------------------
			                    	</strong></td>
			                  </tr>
			                  <tr width="970">
			                    <td class="paddingB5 paddingT5">
			                   <label class="lF" style="width:120px;">
			                  <input name="input" type="checkbox" value="" class="checkBox" />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:110px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:111px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  
			                    <label class="lF" style="width:112px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Ration Card</label>
			                    <label class="lF" style="width:172px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Lease or Sale Agreement</label>
			                    <label class="lF" style="width:222px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Bank Statement/Passbook</label>
								
			                    
			                        
			                    </td>
			                  </tr>
							  <tr>
							  	<td>
									 <label class="lF" style="width:180px;">
										<input name="input" type="checkbox" value="" class="checkBox lF" />Latest Utility Bill</label>
								<label class="lF" style="width:190px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Gas Bill</label>
			                  	<label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other____________</label>
								</td>
							  </tr>
			                  <tr>
			                    <td class="paddingT5 fontsize11" width="950">
			                    **Not more than 3 months old proof of address issued by any of the following: Bank Managers of Schedule Commercial Bank/Schedule Co-operative Bank/Multinational Foreign Bank
			Gazetted oficer/Notary Public/ElectedRepresentatives to the Representative to the Legislative Assembly/Parliament/Document issued by Govt. or Statutory Authority.
			                    </td>
			                  </tr>
			                  
			                </table>
			
			            </td>
			          </tr>
			        </table>
			
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" valign="top" class="paddingB5 paddingT5">
			  <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14 paddingB paddingT">
			      	3. CONTACT DETAILS and PAN DETAIL (*Fields are mandatory)
			      </td>
			    </tr>
			    <tr>
			      <td class="paddingTRBL5" style="padding-left:0;">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="borderBL">
			        <tr>
			          <td width="80" class="paddingT2 paddingB2 borderTR">&nbsp; Phone</td>
			          <td width="120" class="paddingT2 paddingB2 borderTR">&nbsp; Residence</td>
			          <td width="230" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_residence'].'</td>
			          <td width="90" class="paddingT2 paddingB2 borderTR">&nbsp; Office</td>
			          <td width="200" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_office'].'</td>
			          <td width="300" class="paddingT2 paddingB2 borderTR">&nbsp; PAN No.- '.$result_data[0]['CustomerBGP']['contact_pan_no'].'</td>
			        </tr>
			      </table></td>
			    </tr>
			    <tr>
			      <td height="20" >
					  <table width="1010" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			          <td width="480" align="left" >
			          <table width="480" border="0" cellspacing="0" cellpadding="0" class="Boxborder">
			            <tr>
			              <td width="180" class="BoxborderRight">&nbsp; E-mail</td>
			              <td width="300">'.$result_data[0]['CustomerBGP']['contact_email'].'</td>
			            </tr>
			          </table>
			          </td>
			          <td width="30"></td>
			          <td width="488">
			          <table width="490" border="0" align="right" cellpadding="0" cellspacing="0" class="Boxborder">
			            <tr>
			              <td width="170" class="BoxborderRight">&nbsp; Mobile</td>
			              <td width="338">'.$result_data[0]['CustomerBGP']['contact_mobile'].'</td>
			            </tr>
			          </table>
			          </td>
			        </tr>
			      </table>
				  
				  </td>
			    </tr>
			    <tr>
			      <td class="fontsize11 paddingL5">I agree to receive updates via SMS on my registered mobile and to receive Account Statements / other statutory as well as other information documents on my registered email in lieu of physical documents</td>
			    </tr>
			    <tr>
			    
			    <td class="paddingB5 paddingT5 BoxborderBotm BoxborderTop fontsize11">
			       <span class="lF bold" style="width:90px;">Occupation</span>
			                   <label class="lF" style="width:101px;">
			                  <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Private Sector") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Private Sector</label>
			                  <label class="lF" style="width:129px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Government Service") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Government Service </label>
			                  <label class="lF" style="width:82px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Business") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Business</label>
			                  <label class="lF" style="width:96px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Professional") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Professional </label>
			                  <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Agriculturist") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Agriculturist </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Retired") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Retired </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Housewife") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Housewife</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other _______</label>
			                        
            	  </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14">3.PAYMENT DETAILS</td>
			    </tr>
			    <tr>
			      <td width="1000" class=" Boxborder  ">
			      		<table width="995" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="490" valign="top" class="paddingB2 BoxborderRight paddingL5">
			                	<table width="500" border="0" align="right" cellpadding="0" cellspacing="0">
			                      <tr>
			                        <td class="bold fontsize14  paddingT2 paddingB2">
			                        	<span style="text-decoration:underline;">Initial Subscription Details</span></td>
			                      </tr>
			                      <tr>
			                        <td class="">
			                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150">Amount(Rs.)</td>
			                                <td><p>
			                                  <input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value="'.$result_data[0]['CustomerBGP']['initial_amount'].'" />
			                                </p></td>
			                              </tr>
			                              <tr>
			                                <td>Mode of Payment</td>
			                                <td class="paddingT2">
			                                	<label class="lF" style="width:90px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['initial_pay_by'] == "Cheque") ? "checked=checked" : "").' value="" class="checkBox" /> Cheque </label>
			                                    <label class="lF" style="width:60px;"><input name="" type="checkbox"  value="" class="checkBox" /> DD </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> Payorder </label>
			                                </td>
			                              </tr>
			                              <tr>
			                                <td>Cheque/DD/Payorder No.</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Cheque/DD/Payorder Date</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT5">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" value="" class="checkBox" /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox"  value="" class="checkBox" /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" value="" class="checkBox" /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                            </table>
			                        </td>
			                      </tr>
			                    </table>
			
			                </td>
			                <td width="549" valign="top" class="paddingL5">
			                	 <table width="545" border="0" align="right" cellpadding="0" cellspacing="0">
			                  <tr>
			                     <td>
			                     	<table width="545" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="360" class="paddingT2 paddingB5"><span class="bold fontsize14" style="text-decoration:underline;">Monthly Subscription Details</span>
			                            	<div><label class="paddingT2 lF"><input name="" type="checkbox" value="" class="checkBox" /> SIP through Auto-Debit(ECS/Direct Debit)</label></div>
			                            </td>
			                            <td width="20"><input name="" type="checkbox" value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' /> </td>
										<td width="30"> SIP</td>
			                            <td width="20"><input name="" type="checkbox"  value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? "checked=checked" : "").' /> </td>
										<td width="30"> PDC</td>
										<td width="10">&nbsp;</td>
			                          </tr>
			                        </table>
			                     </td>
			                   </tr>
			                  
			                  <tr>
			                    <td>
			                    	
			                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150" valign="top">Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['bank_name'] : "").'" /></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['account_number'] : "").'"/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT2">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Saving" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP" ) ? "checked=checked" : "").' value="" class="checkBox"  /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Current" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").'  value="" class="checkBox"  /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRE" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox"  /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRO" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                          </table> 
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 BoxborderBotm paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['amount'] : "").'" /></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['tenure'] : "").'" class="app_inputBox" style="width:25px;"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['period_from'] : "").'" /> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                  	<td class="paddingT2"><label><input name="" type="checkbox" value="" class="checkBox" /> </label>SIP through Post Dated Cheque</td>
			                  </tr>
			                  <tr>
			                    <td class="">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['amount'] : "").'"/></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" class="app_inputBox" style="width:25px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['tenure'] : "").'"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['period_from'] : "").'"/> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Cheque No. From <input name="" type="text" class="app_inputBox" style="width:75px;" value="'.$result_data[0]['CustomerBGP']['cheque_number_from'].'"/> to <input name="" type="text" value="'.$result_data[0]['CustomerBGP']['cheque_number_to'].'" class="app_inputBox" style="width:75px;"/></td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			            </table>
			      </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT2">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			         <td class="bold fontsize14 paddingB5">
			          	4.NOMINATION DETAILS (Mandatory)
			          </td>
			        </tr>
			        <tr>
			          <td class="Boxborder paddingL5">
			          	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="520" align="center" class="fontsize14">Name and Address of Nominee</td>
			                <td width="520" align="center" class="fontsize14">Name and Address of Guardian(if Nominee is Minor)</td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                      <td width="60">Name</td>
			                        <td >  <input name="input3" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_name'].'"/>
			                        </td>
			                      <td width="60">Name</td>
			                        <td >  <input name="input4" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_name'].'"/>
			                        </td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="60">Address</td>
			                        <td><input name="input6" type="text" class="inputBoxDtl-2" style="width:926px; float:left;" value="'.$result_data[0]['CustomerBGP']['nomination_address'].'"/></td>
			                      </tr>
			                    </table>
			
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">City</td>
			                    <td><input name="input5" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_city'].'"/></td>
			                    <td width="60"> State </td>
			                    <td width="230"><input name="input7" type="text" class="inputBoxDtl-2" style="width:477px;" value="'.$result_data[0]['CustomerBGP']['nomination_state'].'"/></td>
			                  </tr>
			                </table>
			
			                <!--<span style="width:60px; float:left;">&nbsp;&nbsp;</span>
			                  <input name="input5" type="text" class="inputBoxDtl-2" style="width:602px;"/>
			                  City
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:280px;"/>-->
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="990" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">Pin Code</td>
			                    <td><input name="input4" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_pincode'].'"/></td>
			                    <td width="210"> Guardian Relationship with Minor </td>
			                    <td width=""><input name="input7" type="text" class="inputBoxDtl-2" style="width:328px;" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_realtion'].'"/></td>
			                  </tr>
			                </table>
			
			                </td>
			              </tr>
			              
			              <tr>
			                <td class="paddingT2">
			                	<span style="width:130px; float:left;">Relationship with Applicant</span>
			                    <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.$result_data[0]['CustomerBGP']['nomination_applicant_realtion'].'"/>
			                </td>
			                <td rowspan="2" align="right" class="paddingT5 paddingB2" style="padding-right:10px;">
			                	
			                    <table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			                      <tr>
			                        <td height="45" width="450" valign="middle" style="color:#ccc;">Signature of Guardian</td>
			                      </tr>
			                    </table>
			
			                    
			                </td>
			              </tr>
			              <tr>
			                <td class="paddingT2"><span style="width:130px; float:left;">Date of Birth <br />
			                  (In case of Minor)</span>
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.(($result_data[0]['CustomerBGP']['nomination_dob'] != "0000-00-00") ? date('d-m-Y',strtotime($result_data[0]['CustomerBGP']['nomination_dob'])) : "").'"/></td>
			                </tr>
			            </table>
			
			          </td>
			        </tr>
			      </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			<p class="fontsize15">Declaration:-</p>
			<p class="fontsize11" style="text-align:justify;">I propose to enroll with Birla Gold Plus, subject to terms & conditions of the product brochures as amended from time to time. I have read and understood (before Filling the application form)
& Conditions in the product brouchures, and I accept the same. I have neither received nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Plus.I hereby
declare that the subscriptions proposed to be remitted in Birla Gold Plus will be from legitimate sources only and will not be with any intention to contravene/evade/avoid any legal/statutory/regulatory
requirements. I understand that Birla Gold & Precious Metals Pvt. Ltd.,may, at its absolute discretion, discontinue any or all of the services by giving prior notice to me. I hereby authorise BGPM to debit
my customer ID with the service charges as applicable from time to time. I hereby authorise the aforesaid nominee to receive all the gold accrued to my credit, in the event of my death. Signature of the
nominee acknowledging receipts of the proceeds of Birla Gold shall constitute full discharge of liabilities of Birla Gold in respect of my Customer ID.</p>     
			     
			                                                          
			  </td>
			</tr>
			
			
			<tr>
			  <td align="left" width="450">
			  
			 <p> Date :- '.date('d-m-Y',strtotime($result_data[0]['CustomerBGP']['declaration_date'])).'</p>
			
			<p> Place :- '.$result_data[0]['CustomerBGP']['declaration_place'].' </p>
			  
			  </td>
			  <td align="right" style="padding-right:10px;">
			  	<table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			      <tr>
			        <td width="450" height="45" valign="middle" style="color:#ccc;">Signature of Investor</td>
			      </tr>
			    </table>
			  </td>
			</tr>
			  
			  
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			  	
			    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    
			          <tr>
			        <td colspan="2" align="left"height="10"></td>
			        </tr>
			
			      <tr>
			        <td width="790" align="left" class="paddingT fontsize15 bold" style="border-top:2px dashed #333;">
			    	<div style="text-align:center; display:block; border:2px solid #ccc; height:30px; width:759px; padding-top:10px;"> Acknowledgment Slip (to be filled by Customer) </div>
			    </td>
			         <td width="250" align="center" valign="middle" class="paddingT fontsize15" style="border-top:2px dashed #333;">Application No. - '.$app_no.'</td>
			      </tr>
			    </table>
			    
			  </td>
			  </tr>
			
			<tr>
			  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
				  <p>Received with thanks from Mr./Ms./Mrs_______________________________________________an application for allotment</p><br/>
			<p>of gold gram under BGP as per the advance payment details below:-<br/></p>
			<p>
			Amount ____________Payment Mode: Cheque/DD/Payorder Instrument No.__________________Date ________________</p><br/>
			
			<p>Bank Name_________________________________________Branch____________________________Tenure__________</p><br/>
			
			<p>Monthly Subscription Option: ECS / Direct Debit / PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monthly Subscription Amount_____________________</p>
			</td>
			      <td align="center" class="paddingL">
			      
			      
			        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
			          <tr>
			            <td align="center" width="180" style="border:2px dotted #333; height:80px; text-align:center;">
			            <p>&nbsp;</p>
			            Collection Center Date and Stamp
			            </td>
			          </tr>
			        </table>
			      
			      </td>
			    </tr>
			  </table></td>
			  </tr>
			  
			  <tr>
              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
                	Birla Gold and Precious Metals Pvt Ltd
                </td>
              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
              </tr>
			  </table>
			
			  
			</div>
			<div style="width:1000px; border:0px solid #666; padding:10px 0 0 40px; margin:0 auto;">

  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="499" valign="top" style="padding-top:15px"><img src="img/logo.jpg" />
                <p class="fontsize14 paddingT"> Birla Gold and Precious Metals Pvt Ltd <br />
                  Morya Landmark II,G-002,Ground Floor, <br />
                  New Link Road,Andheri(W),Mumbai-400 053 </p></td>
              <td width="501" align="right" valign="top"><strong class="fontsize15"> Application No. - '.$app_no.'</strong></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" class="paddingB paddingT"><h4 class="fontsize18">Electronic Clearing Service<br />
        RBI-ECS Debit / Direct Debit collection Mandate form</h4></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingB paddingT txtjustify"> I/We the account holders with the Bank as per details below hereby request and authorize the Bank to accept this ECS Debit(Clearing)/Direct Debit
        mandate executed by me/us in favour of <strong>M/s Birla Gold and Precious Metals Private Limited</strong> and submitted by them or through their authorized
        service provider under RBI ECS debit procedures. I/We further request and authorize the bank to debit my/our account to honor the periodical payment
        contribution requests presented by the service provider. Various details of bank account and periodical payment are furnished below: </td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="25" class="title">BANK ACCOUNT DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT paddingB txtjustify"> I/We hereby authorize <strong>Birla Gold and Precious Metals Private Limited</strong> and their authorized service providers to debit my/our following
            bank account by ECS Debit (Clearing)/Direct Debit to account for collection of Monthly Subscription Payments (Applicant should be amongst
            one of bank account holders). </td>
        </tr>
        <tr>
          <td class="paddingB5"> 
          	<table width="990" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="160">Bank Account Number:</td>
                        <td width="830">'.$result_data[0]['CustomerBGP']['ecs_bank_account_number'].'</td>
                      </tr>
                      <tr>
                        <td>Account Type:</td>
                        <td class="paddingB5 paddingT5">
                        <table width="830" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Saving") ? "checked=checked" : "").' class="checkBox" /> Savings</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Current") ? "checked=checked" : "").' class="checkBox" /> Current</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRE") ? "checked=checked" : "").' class="checkBox" /> NRE</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRO") ? "checked=checked" : "").' class="checkBox" /> NRO</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Account Holders Name (1st holder): '.$result_data[0]['CustomerBGP']['ecs_account_holder_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Name:'.$result_data[0]['CustomerBGP']['ecs_bank_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Branch Name/Address: '.$result_data[0]['CustomerBGP']['ecs_branch_address'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110">Bank City/Town: </td>
                        <td width="442">'.$result_data[0]['CustomerBGP']['ecs_city'].'</td>
                        <td width="30">&nbsp;</td>
                        <td width="142" align="right">PIN CODE:</td>
                        <td width="266" align="left">'.$result_data[0]['CustomerBGP']['ecs_pincode'].'</td>
                      </tr>
                    </table>

                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5"><table width="990" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="260">Bank Branch MICR Number (9 DIGITS) : </td>
                    <td width="342">'.$result_data[0]['CustomerBGP']['ecs_branch_micr'].'</td>
                    <td width="35">&nbsp;</td>
                    <td width="100" align="right">IFSC CODE:</td>
                    <td width="263" align="left">'.$result_data[0]['CustomerBGP']['ecs_ifsc_code'].'</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td style="font-size:13px;">as appearing in Cheque leaf-please attach a copy of cancelled cheque/bankers attestation. MICR Code starting and/or ending with 000 are not valid for ECS.</td>
              </tr>
            </table>

          </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td height="30" align="left" class="paddingT2 title"> PERIODIC PAYMENT DETAILS <span class="fontsize14">(Please refer payment mode section)</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingT fontsize15"><table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="35" valign="middle"> Debit Date (tick applicable date)
            <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "10") ? "checked=checked" : "").' value="" class="checkBox" />
            10
            <input name="input2" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "20") ? "checked=checked" : "").' value="" class="checkBox" />
            20 </td>
          <td>Amount of Subscription:'.$result_data[0]['CustomerBGP']['ecs_amount_of_subscription'].'</td>
        </tr>
         <tr>
          <td class="paddingT2"> From:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="border:0; width:70px !important" value="'.$result_data[0]['CustomerBGP']['ecs_from'].'" />
            
            To:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="width:70px !important" value="'.$result_data[0]['CustomerBGP']['ecs_to'].'" />
            
          <td class="paddingT2"> Frequency: MONTHLY </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT2 paddingB"><table width="1030" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1030" height="30" class="paddingT2 title"> CONTRIBUTION DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT"><table width="1020" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="450" class="paddingT5">Beneficiary Name: <strong>Birla Gold and Precious Metals Pvt. Ltd</strong></td>
              <td>Product Code: <strong>BGP</strong></td>
              <td width="415" align="right">Product Name: <strong> Birla Gold Plus</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer ID/Folio No. ___________________________________________________________________________________________________________________________________</td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer/Contributors Name_____________________________________________________________________________________________________________________________</td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" valign="top" class="paddingT5 paddingB5"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">DECLARATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT5"> I/We wish to inform you that I/We have registered for the subject scheme for the contribution payment to the bene?ciary as per account details as above
by debit to said Bank Account. I/We express my willingness for participation in ECS/Direct Debit scheme. I declare that the particulars given above
are correct and complete. I/We agree to discharge the responsibility expected of me as a participant under the ECS/Direct Debit scheme. I/We hereby
authorize the bene?ciary or their representatives to get this mandate lodged with bank/get veri?ed and further execute by raising debits on the applicable
dates through ECS/Direct Debit scheme. If the mandate is not lodged/transaction is not collected or delayed for reasons beyond control of the bene?ciary/service
provider representative or on account of incomplete or incorrect information, I/We shall not hold them responsible. I/We shall keep indemni?ed for
claims and actions, that bene?ciary or representative may incur, for execution of transactions in conformity with this mandate.
           </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT5 paddingB5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">AUTHORISATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT paddingB" > I/We hereby request and authorize the bank to honor the periodic debit instructions raised as above and cause my account to be debited accordingly. Charges,
if any, for mandate veri?cation/registration may be debited to my account. I hereby undertake to keep suf?cient funds in the account well prior to the applicable
date and till the date of execution. If the date of debit happens to be a holiday or non working day for the bank or location, the debit may happen on any subsequent
working day. Debited contributions may be passed on to the bene?ciary/representative as per rules, procedures and practices in force. I/We shall not dispute any
debit raised under this mandate and as speci?ed therein and during or for the validity period. I/We shall keep indemni?ed for claims that Bank may incur for reason
of execution in conformity with this mandate. </td>
        </tr>
        <tr>
          <td width="980" class="paddingT">
          <table width="980" border="1" cellspacing="0" cellpadding="0" class="fontsize18 borderBL">
            <tr>
              <td align="center" class="borderTR">As per Bank Record</td>
              <td align="center" class="borderTR">1st Account Holder</td>
              <td align="center" class="borderTR">2nd Account Holder</td>
              <td align="center" class="borderTR">3rd Account Holder</td>
            </tr>
            <tr>
              <td align="center" class="borderTR">Name</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" class="borderTR" style="height:60px">Signature</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr><td height="10"></td></tr>
    <tr>
      <td height="30" align="center" class="paddingT5 title paddingB5"> FOR BANK USE ONLY </td>
    </tr>
    <tr>
      <td class="txtjustify fontsize15 paddingT"> Certified that the bank account details and signatures of the account holders are correct and as per '."bank's".' records. </td>
    </tr>
	
	
	
    <tr>
      <td class="txtjustify fontsize15"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="527">Date:____________________</td>
          <td width="473" align="center">_______________________________________________</td>
        </tr>
        <tr>
          <td width="527">&nbsp;</td>
          <td align="center" class="paddingT">Stamp & Signature of the Authorized Official of the Bank</td>
        </tr>
      </table></td>
    </tr>
	
	 <tr>
		<td height="28" valign="bottom">
			 <table width="1000" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="500" align="left" style="font-size:12px;">Birla Gold and Precious Metals Pvt Ltd</td>
				<td width="500" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
			  </tr>
			</table>
		</td>
	  </tr>
  </table>
</div>
			
			
			</body>
			</html>
			';
			
			
		
			
//==============================================================
		
//		include_once(DOC_ROOT."/classes/mpdf/mpdf.php");
//		
//		$mpdf=new mPDF('', 'A4', 0, '', 5, 5, 5, 5, 8, 8);
//		
//		$mpdf->WriteHTML($html);	
//		$filename = $result_data[0]['CustomerBGP']['application_no'].'_AC'.".pdf";
//		if(!is_dir(DOC_ROOT."/documents/cust_form/"))
//		{
//			mkdir(DOC_ROOT."/documents/cust_form");
//		}
//		if($savefile)
//		{			
//			$mpdf->Output(DOC_ROOT."/documents/cust_form/".$filename,"F");
//			return $filename;
//		}
//		else 
//		{
//			$mpdf->Output($filename,"D");
//			exit;
//		}

			$date = date_create();
			$pdf_time = date_timestamp_get($date).".pdf";

			$this->Mpdf->init();
			$this->Mpdf->SetHTMLHeader(" ");
			$this->Mpdf->WriteHTML($html);
			$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/".$pdf_time."_form.pdf","F");
			
			
	  		if($savefile)
			{			
				$this->Mpdf->Output(WWW_ROOT.'/documents/tempPDF/'.$pdf_time.'_form.pdf',"F");
				return $pdf_time;
			}
			else 
			{
				$this->Mpdf->Output($pdf_time,"D");
				exit;
			}
		exit;
	}
}
