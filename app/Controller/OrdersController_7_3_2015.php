<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'payu');
/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Session','Image');
	
	public $uses=array('Order','User','Shipping','Shoppingcart','Discount','Paymentdetails','Product','Productimage','Category','Productdiamond','Productgemstone','Vendorcontact');
	public $layout='webpage';
	
	 public function personal_details(){
		 if($this->Session->read('User')!=''){
			 $user_id=$this->Session->read('User.user_id');
			 $user=$this->User->find('first',array('conditions'=>array('user_id'=>$user_id)));			
			 $this->set('user',$user);
			 if (!empty($this->request->data)) {
					
                    $check = $this->User->find('first', array('conditions' => array('user_id' =>$user_id)));
                   if (!empty($check)) {
  
                                $this->request->data['User']['user_id'] = $check['User']['user_id'];
								$this->request->data['User']['created_date'] =date('Y-m-d H:i:s');
								$this->request->data['User']['date_of_birth']=$this->request->data['User']['year']."-".$this->request->data['User']['month']."-". $this->request->data['User']['date'];
								$this->request->data['User']['anniversary']=$this->request->data['User']['annu_year']."-". $this->request->data['User']['annu_month']."-".$this->request->data['User']['annu_date'];
                                $this->User->save($this->request->data);
								$this->Session->setFlash("<div class='success msg'>" . __('Personal detail  saved successfully') . "</div>");
                                $this->redirect(array('controller' => 'orders', 'action' => 'shipping_details'));
                        }
                      
                  
                }
				
            } 
	 }
	 
	  public function shipping_details(){
		   if($this->Session->read('User')!=''){
			   if($this->Session->read('Order')!=''){
				 $order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order')))); 
				 if(!empty($order)){
			      $this->set('order',$order);
		         }  
			   }
			   else
			   {
				 $shipping_add=$this->Shipping->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id')))); 
				  if(!empty($shipping_add))
		  			 {
			   			$this->set('shipping',$shipping_add);
						
		   			}  
			   }
		  }
		  


		    if (!empty($this->request->data)) {
				 if($this->Session->read('User')!=''){
					 $user_id=$this->Session->read('User.user_id');
						 if($this->Session->read('Order')!=''){ 
						   $order_id=$this->Session->read('Order');
						   $check = $this->Order->find('first', array('conditions' => array('order_id' =>$order_id)));
						  if (!empty($check)) {
									$this->request->data['Order']['order_id'] = $check['Order']['order_id'];
									$this->request->data['Order']['user_id'] = $user_id;
									$this->Order->save($this->request->data);
						 }
						 }
					   else
					   {
						$this->request->data['Order']['user_id'] = $user_id;
						$invoice = $this->Order->find('first',array('fields' => array('MAX(Order.invoice) AS maxid', '*')));
						if (!empty($invoice[0]['maxid'])) {
						$tiid = $invoice[0]['maxid'] + 1;
						} else {
						$tiid = 1;
						}
						$invoice_code=sprintf("%06d",$tiid);
						$this->request->data['Order']['invoice'] = $invoice_code;
						$this->request->data['Order']['created_date'] =date('Y-m-d H:i:s');
						$this->Order->save($this->request->data);
					    $order_id=$this->Order->getLastInsertID();
						
					 }
					 
					  $this->Session->write('Order',$order_id);
				  }
                     $this->Session->setFlash("<div class='success msg'>" . __('Shipping detail  saved successfully') . "</div>");
                     $this->redirect(array('controller' => 'orders', 'action' => 'order'));
				}
		   
				
		  
	  }
	  
	   public function order(){
		 
		if($this->Session->read('cart_process')!=''){		
			$cart_product=$this->Shoppingcart->find('all',array('conditions'=>array('cart_session'=>$this->Session->read('cart_process'))));
			if(empty($cart_product)){
				$this->redirect(array('action'=>'jewellery','controller'=>'webpages'));		
			}
		}else{
			$this->redirect(array('action'=>'jewellery','controller'=>'webpages'));	
		}
		 if($this->Session->read('User')!=''){
			    $id=$this->Session->read('cart_process');
			    $carts=$this->Shoppingcart->find('all',array('conditions'=>array('cart_session'=>$id)));
				$this->set('cart',$carts);
				$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
			    $this->set('order',$order);
				$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
			    $this->set('user',$user);
				
		   }
		   
		   if($this->Session->read('cart_process')!='')
				{
				 $order_id=$this->Session->read('Order');
				$cart = $this->Shoppingcart->find('all', array('conditions' => array('cart_session'=>$this->Session->read('cart_process'))));	
				if(!empty($cart))
				{
				foreach($cart as $carts) {
				$this->request->data['Shoppingcart']['cart_id']=$carts['Shoppingcart']['cart_id'];
				$this->request->data['Shoppingcart']['order_id'] = $order_id;
				$this->Shoppingcart->saveAll($this->request->data);
				}
				
				}
				}
				
				if(isset($this->request->data['Paymentdetails']['payment'])){
					$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
					if(!empty($order)){
						$this->request->data['Order']['order_id']=$order['Order']['order_id'];
						$this->request->data['Order']['cod_status'] = $_REQUEST['cod_status'];
						if($this->Session->read('Franchisee.User.user_id')!='') {
						if($_REQUEST['cod_status']=='COD') {
						$this->request->data['Order']['cod_percentage'] = '30';
						$this->request->data['Order']['cod_amount'] =round(($_REQUEST['amountpay']*30)/100);
						$this->Order->saveAll($this->request->data);
						$this->redirect(array('action' =>'payment','controller'=>'orders'));
						}
						elseif($_REQUEST['cod_status']=='CHQ/DD') {
							$this->Order->saveAll($this->request->data);
							$order1=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
							$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
							$name=$user['User']['first_name'];
							$cart=$this->Shoppingcart->find('all',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
						
							if(!empty($cart)){
							//$msg='<table cellpadding="0" cellspacing="0" id="example" class="table gtable" width="100%" style="border:1px solid bgcolor="#993300";"><thead><tr>';
							$msg='<table cellpadding="0" cellspacing="0" id="example" class="" width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th></tr>';
							foreach($cart as $carts){
							$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
							$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
							$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
							/*$msg.='<td align="left"><span>Product Name:</span>'.$product['Product']['product_name'].'</td>
							<td align="left"><span>Type:</span>'.$_REQUEST['cod_status'].'</td>';*/
							$msg.='<tr><td align="left">'.$product['Product']['product_name'].'</td><td align="left">'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'-'.$carts['Shoppingcart']['purity'].'K'.$carts['Shoppingcart']['clarity'].$carts['Shoppingcart']['color'].'</td></tr>';
							}
							$msg.='</thead></table>';
							}
							
							$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 11)));
							$message = str_replace(array('{name}','{details}'), array($name,$msg), $activateemail['Emailcontent']['content']);
							
							$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
							$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
							
							$email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 12)));
							$messagen = str_replace(array('{name}','{details}'), array($name,$msg), $email['Emailcontent']['content']);
							$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
							$this->Session->delete('Order');
							$this->Session->delete('cart_process');
							$this->redirect(BASE_URL.'account-details');
							$this->Session->setFlash("<div class='success msg'>" . __('Your Order successfully updated.') . "</div>");
							
						}
						elseif($_REQUEST['cod_status']=='PayU')
						{
							$this->Order->saveAll($this->request->data);
							$this->redirect(array('action' =>'payment','controller'=>'orders'));
						}
						}else
						{
						if($_REQUEST['cod_status']=='CHQ/DD') {
							
							$order1=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
							$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
							$name=$user['User']['first_name'];
							$cart=$this->Shoppingcart->find('all',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
						
							if(!empty($cart)){
							$msg='<table cellpadding="5" cellspacing="0" id="example" class="" width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th></tr>';
							foreach($cart as $carts){
							$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
							$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
							$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
							$msg.='<tr><td align="left">'.$product['Product']['product_name'].'</td><td align="left">'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'-'.$carts['Shoppingcart']['purity'].'K'.$carts['Shoppingcart']['clarity'].$carts['Shoppingcart']['color'].'</td></tr>';
							}
							$msg.='</thead></table>';
							}
							$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 11)));
							$message = str_replace(array('{name}','{details}'), array($name,$msg), $activateemail['Emailcontent']['content']);
							$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
							$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
							
							$email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 12)));
							$messagen = str_replace(array('{name}','{details}','{amount}'), array($name,$msg), $email['Emailcontent']['content']);
							$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
							$this->Order->saveAll($this->request->data);
							$this->Session->delete('Order');
							$this->Session->delete('cart_process');
							$this->redirect(BASE_URL.'account-details');
							$this->Session->setFlash("<div class='success msg'>" . __('Your Order successfully updated.') . "</div>");
						}
						elseif($_REQUEST['cod_status']=='PayU')
						{
							$this->Order->saveAll($this->request->data);
							$this->redirect(array('action' =>'payment','controller'=>'orders'));
						}
						}
						
					}
			  }
	   }
				

		
	
		     public function delete(){
				$this->layout = '';
				$this->render(false);
				$cart=$this->Shoppingcart->find('first',array('conditions'=>array('cart_id'=>$this->params['pass']['0'])));
				$this->Shoppingcart->delete(array('cart_id'=>$this->params['pass']['0']));
				$this->Session->setFlash("<div class='success msg'>" . __('Order deleted successfully') . "</div>");
				$this->redirect(array('action' =>'order','controller'=>'orders'));
				 
			 }
			 
			 public function movetowishlist(){	 
			 }
			 
	public function payment(){
		if($this->Session->read('cart_process')!=''){		
			$cart_product=$this->Shoppingcart->find('all',array('conditions'=>array('cart_session'=>$this->Session->read('cart_process'))));
			if(empty($cart_product)){
				$this->redirect(array('action'=>'jewellery','controller'=>'webpages'));		
			}
		}else{
			$this->redirect(array('action'=>'jewellery','controller'=>'webpages'));	
		}
		$cart_product=$this->Shoppingcart->find('first',array('conditions'=>array('cart_session'=>$this->Session->read('cart_process')),'fields'=>array('SUM(quantity*total) as tot')));
		$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$this->redirect(array('controller'=>'payupayment','action'=>'index'));
		
	}
	
	
	public function payment_success(){
		
		$this->request->data['Paymentdetails']['order_id']=$this->Session->read('Order');
		$this->request->data['Paymentdetails']['user_id']=$this->Session->read('User.user_id');
		$this->request->data['Paymentdetails']['txnid']=$_POST['mihpayid'];
		$this->request->data['Paymentdetails']['amount']=$_POST['net_amount_debit'];
		$this->request->data['Paymentdetails']['pg_type']=$_POST['PG_TYPE'];
		$this->request->data['Paymentdetails']['bank_ref_num']=$_POST['bank_ref_num'];
		$this->request->data['Paymentdetails']['bankcode']=$_POST['bankcode'];
		$this->request->data['Paymentdetails']['status']='Success';	
		$this->request->data['Paymentdetails']['admin_status']='Order in Progress';
		$this->request->data['Paymentdetails']['ip']= $_SERVER['REMOTE_ADDR'];
	    $this->Paymentdetails->save($this->request->data);
		$last_id=$this->Paymentdetails->getLastInsertID();
		$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$usertypest=$user['User']['user_type'];
		if($usertypest=='1'){
		$orderstatus='BookedbyFranchisee';	
		}elseif($usertypest=='0'){
			$orderstatus='BookedbyUser';
		}
		if(!empty($order)){
			$this->request->data['Order']['order_id']=$order['Order']['order_id'];
			$this->request->data['Order']['order_status']=$orderstatus;
			if($order['Order']['cod_status']=='PayU'){
			$this->request->data['Order']['status']='Paid';
			}elseif($order['Order']['cod_status']=='COD'){
			$this->request->data['Order']['status']='PartialPaid';	
			}
			 $this->Order->save($this->request->data); 		
		}
		$order1=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		
		$name=$user['User']['first_name'];
		$cart=$this->Shoppingcart->find('all',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		if($order1['Order']['cod_status']=='COD') {
		if(!empty($cart)){
			 //$msg='<table cellpadding="0" cellspacing="0" id="example"  width="100%"><thead><tr>';
$msg='<table cellpadding="0" width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th><th>Type</th><th>Paid Amount</th><th>Balance Amount</th></tr>';
		foreach($cart as $carts){
				$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
				$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
				$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
				$orders=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
				$tot=$carts['Shoppingcart']['total']-$orders['Order']['cod_amount'];
			
			/*$msg.='<td align="left"><span><b>Product Name:</b></span>'.$product['Product']['product_name'].'</td>
			       <td align="left"><span><b>Product Code:</b></span>'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'</td>
                   <td align="left"><span><b>Type:</b></span>'.$orders['Order']['cod_status'].'</td>
			       <td align="left"><span><b>Paid Amount:</b></span><span>Rs.</span>'.$orders['Order']['cod_amount'].'</td>
				   <td align="left"><span><b>Balance Amount:</b></span><span>Rs.</span>'.$tot.'</td><br>';	*/	
				   $msg.='<tr><td align="left">'.$product['Product']['product_name'].'</td><td align="left">'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'-'.$carts['Shoppingcart']['purity'].'K'.$carts['Shoppingcart']['clarity'].$carts['Shoppingcart']['color'].'</td><td align="left">'.$orders['Order']['cod_status'].'</td><td  align="left">'.'Rs'.$orders['Order']['cod_amount'].'</td>
				   <td  align="left">'.'Rs'.$tot.'</td></tr>';
							
				   	
		}
		$msg.='</thead></table>';
		}
		$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 8)));
		$message = str_replace(array('{name}','{details}'), array($name,$msg), $activateemail['Emailcontent']['content']);
		$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
		$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
		$email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
		$amountedit=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$last_id)));
		$messagen = str_replace(array('{name}','{details}','{amount}'), array($name,$msg,$amountedit['Paymentdetails']['amount']), $email['Emailcontent']['content']);
		$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
		}
		if($order1['Order']['cod_status']=='PayU') {
			if(!empty($cart)){
	$msg='<table cellpadding="0" cellspacing="0"   width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th><th>Type</th><th>Paid Amount</th></tr>';
		foreach($cart as $carts){
				$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
				$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
				$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
				$orders=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
			
		/*	$msg.='<td align="left"><span><b>Product Name:</b></span>'.$product['Product']['product_name'].'</td>
				   <td align="left"><span><b>Product Code:</b></span>'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'</td>
                   <td align="left"><span><b>Type:</b></span>'.$orders['Order']['cod_status'].'</td>
			       <td align="left"><span><b>Paid Amount:</b></span><span>Rs.</span>'.$carts['Shoppingcart']['total'].'</td><br>';	*/
				 $msg.='<tr><td align="left">'.$product['Product']['product_name'].'</td><td align="left">'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'-'.$carts['Shoppingcart']['purity'].'K'.$carts['Shoppingcart']['clarity'].$carts['Shoppingcart']['color'].'</td><td align="left">'.$orders['Order']['cod_status'].'</td><td  align="left">'.'Rs'.$carts['Shoppingcart']['total'].'</td></tr>';    
				   
		}
		$msg.='</thead></table>';
		}
		$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 10)));
		$message = str_replace(array('{name}','{details}'), array($name,$msg), $activateemail['Emailcontent']['content']);
		$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
		$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
		
		$email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
		$amountedit=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$last_id)));
		$messagen = str_replace(array('{name}','{details}','{amount}'), array($name,$msg,$amountedit['Paymentdetails']['amount']), $email['Emailcontent']['content']);
		$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
			
		}
		
		
		
		
	/*	$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$name=$user['User']['first_name'];
		$aemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
		$amountedit=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$last_id)));
		$messagen = str_replace(array('{name}','{order}','{amount}'), array($name,'SGN-ON'.$order['Order']['invoice'],$amountedit['Paymentdetails']['amount']), $aemail['Emailcontent']['content']);
		$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
		$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $aemail['Emailcontent']['subject'], $messagen);*/
		
		$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		
		$this->Session->delete('Order');
		$this->Session->delete('cart_process');
		
		 $this->Session->setFlash("<div class='success msg'>" . __('Payment process successfully completed. We will deliver your order soon .') . "</div>");
		 $this->redirect(array('controller'=>'orders','action'=>'my_order'));
		
	}
	
	public function payment_failure(){
		
		$this->request->data['Paymentdetails']['order_id']=$this->Session->read('Order');
		$this->request->data['Paymentdetails']['user_id']=$this->Session->read('User.user_id');
		$this->request->data['Paymentdetails']['txnid']=$_POST['mihpayid'];
		$this->request->data['Paymentdetails']['amount']=$_POST['net_amount_debit'];
		$this->request->data['Paymentdetails']['pg_type']=$_POST['PG_TYPE'];
		$this->request->data['Paymentdetails']['bank_ref_num']=$_POST['bank_ref_num'];
		$this->request->data['Paymentdetails']['bankcode']=$_POST['bankcode'];
		$this->request->data['Paymentdetails']['status']='Failed';	
		$this->request->data['Paymentdetails']['admin_status']='Order in Pending';
		$this->request->data['Paymentdetails']['ip']= $_SERVER['REMOTE_ADDR'];
	    $this->Paymentdetails->save($this->request->data);
		$orderfailed=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		$usertypest=$user['User']['user_type'];
		if($usertypest=='1'){
		$orderstatus='BookedbyFranchisee';	
		}elseif($usertypest=='0'){
			$orderstatus='BookedbyUser';
		}
		if(!empty($orderfailed)){
		$this->request->data['Order']['order_id']=$orderfailed['Order']['order_id'];
		$this->request->data['Order']['order_status']=$orderstatus;
		$this->request->data['Order']['status']='Failed';
		$this->Order->save($this->request->data);	
		}
		
		$order1=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		
		
		
		$name=$user['User']['first_name'];
		$cart=$this->Shoppingcart->find('all',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
$msg='<table cellpadding="0" cellspacing="0" id="example"  width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th><th>Type</th><th>Paid Amount</th></tr>';
		if(!empty($cart)){
			
		foreach($cart as $carts){
				$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
				$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
					$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
				$orders=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
			
			/*$msg.='<td align="left"><span><b>Product Name:</b></span>'.$product['Product']['product_name'].'</td>
			 <td align="left"><span><b>Product Code:</b></span>'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'</td>
                   <td align="left"><span><b>Type:</b></span>'.$orders['Order']['cod_status'].'</td>
			       <td align="left"><span><b>Total Amount:</b></span><span>Rs.</span>'.$carts['Shoppingcart']['total'].'</td>';	*/
				   $msg.='<tr><td align="left">'.$product['Product']['product_name'].'</td><td align="left">'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'-'.$carts['Shoppingcart']['purity'].'K'.$carts['Shoppingcart']['clarity'].$carts['Shoppingcart']['color'].'</td><td align="left">'.$orders['Order']['cod_status'].'</td><td  align="left">'.'Rs'.$carts['Shoppingcart']['total'].'</td></tr>';    
				   
		}
		$msg.='</thead></table>';
		}
		$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 13)));
		$message = str_replace(array('{name}','{details}'), array($name,$msg), $activateemail['Emailcontent']['content']);
		$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
		$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
		
		$email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 14)));
		$messagen = str_replace(array('{name}','{details}'), array($name,$msg), $email['Emailcontent']['content']);
		$this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
		$this->Session->setFlash("<div class='error msg'>" . __('Payment process not completed. Please try again.') . "</div>");
		 $this->redirect(array('controller'=>'orders','action'=>'order'));
	}
	
	
	
	
	 public function coupon(){
				$this->layout = '';
				$this->render(false);
				$date=date('Y-m-d');
				$discount=$this->Discount->find('first',array('conditions'=>array('type'=>'Vouchercode','voucher_code'=>$_REQUEST['value'],'status'=>'Active','"'.$date.'" BETWEEN Discount.start_date AND  Discount.expired_date')));
				if(!empty($discount)){
					$this->request->data['Discount']['discount_id']=$discount['Discount']['discount_id'];
					$this->request->data['Discount']['status']='Apply';
					$this->Discount->save($this->request->data);
					$val= 'Applied';
					$status=20;
					$discount=round(($discount['Discount']['percentage']*$_REQUEST['amount'])/100);
					$net=$_REQUEST['amount']-$discount;
					
				}
				else
				{
					$val='Invalid Coupon';
					$status=30;
					$net='';
					$discount='';
				}
				  $jsonarray=array('val'=>$val,'check'=>$status,'discount'=>$discount,'net'=>$net);
		         echo json_encode($jsonarray);  
			 }
			 
			  public function my_order(){
				  $pay=$this->Paymentdetails->find('all',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id')),'order'=>'paymentdetails_id DESC')); 
				  $this->set('pay',$pay);
				 
			  }
			  
	 	  public function admin_index(){
			    $this->layout="admin";
				$this->checkadmin();
				$this->Paymentdetails->recursive=0;
			
			if(isset($this->request->data['searchfilter'])){
			$search=array();
			if($this->request->data['cdate']!=''){
				$search[]='cdate='.$this->request->data['cdate'];
			}
			
			if($this->request->data['edate']!=''){
				$search[]='edate='.$this->request->data['edate'];
			}
			
			if($this->request->data['searchinvoice']!=''){
				$search[]='searchinvoice='.$this->request->data['searchinvoice'];
			}
			if($this->request->data['type']!=''){
				$search[]='type='.$this->request->data['type'];
			}
			
			if(!empty($search)){
				$this->redirect(array('action'=>'?search=1&'.implode('&',$search)));
			}else{
				$this->redirect(array('action'=>'index'));
			}
		}
		
		if($this->request->query('search')!=''){
			$search=array();	
			if(($this->request->query('cdate')!='') && ($this->request->query('edate')!='')){
				$search=array('created_date BETWEEN \''.$this->request->query('cdate').'\' AND \''.$this->request->query('edate').'\'');
				
			}elseif($this->request->query('cdate')!=''){
				$search['created_date']=$this->request->query('cdate');
				
			}elseif($this->request->query('edate')!=''){
				$search['created_date']=$this->request->query('cdate');
			}
			
			if($this->request->query('searchinvoice')!=''){
				
				$code=explode('-',$this->request->query['searchinvoice']);
				$order=$this->Order->find('first',array('conditions'=>array('invoice'=>$code[2])));
				$search['order_id']=$order['Order']['order_id'];
				}
			if($this->request->query('type')!=''){
				if($this->request->query('type')==0){
				$user=$this->User->find('first',array('conditions'=>array('user_type'=>$this->request->query['type'])));
				$search['user_id']=$user['User']['user_id'];
				}
				}
				if($this->request->query('type')!=''){
			 if($this->request->query('type')==1){
				$user=$this->User->find('first',array('conditions'=>array('user_type'=>$this->request->query['type'])));
				$search['user_id']=$user['User']['user_id'];
				}
				}
			 $this->paginate = array('conditions' =>$search,'order'=>'Paymentdetails.paymentdetails_id DESC');
			 $this->set('paymentdetail', $this->paginate('Paymentdetails'));
			
		}
		else{
		 $this->paginate = array('conditions' =>'', 'order' => 'paymentdetails_id DESC');
        $this->set('paymentdetail', $this->Paginator->paginate('Paymentdetails'));
		}
			}
			
			  public function admin_order_index(){
			    $this->layout="admin";
				$this->checkadmin();
				$this->Order->recursive=0;
				
				if(isset($this->request->data['searchfilter'])){
			$search=array();
			if($this->request->data['cdate']!=''){
				$search[]='cdate='.$this->request->data['cdate'];
			}
			
			if($this->request->data['edate']!=''){
				$search[]='edate='.$this->request->data['edate'];
			}
			
			if($this->request->data['searchinvoice']!=''){
				$search[]='searchinvoice='.$this->request->data['searchinvoice'];
			}
			if($this->request->data['type']!=''){
				$search[]='type='.$this->request->data['type'];
			}
			
			if(!empty($search)){
				$this->redirect(array('action'=>'admin_order_index?search=1&'.implode('&',$search)));
			}else{
				$this->redirect(array('action'=>'admin_order_index'));
			}
		}
		
		if($this->request->query('search')!=''){
			$search=array();	
			if(($this->request->query('cdate')!='') && ($this->request->query('edate')!='')){
				$search=array('created_date BETWEEN \''.$this->request->query('cdate').'\' AND \''.$this->request->query('edate').'\'');
				
			}elseif($this->request->query('cdate')!=''){
				$search['created_date']=$this->request->query('cdate');
				
			}elseif($this->request->query('edate')!=''){
				$search['created_date']=$this->request->query('cdate');
			}
			
			if($this->request->query('searchinvoice')!=''){
				
				$code=explode('-',$this->request->query['searchinvoice']);
				$order=$this->Order->find('first',array('conditions'=>array('invoice'=>$code[2])));
				$search['order_id']=$order['Order']['order_id'];
				}
			if($this->request->query('type')!=''){
				if($this->request->query('type')==0){
				$user=$this->User->find('first',array('conditions'=>array('user_type'=>$this->request->query['type'])));
				$search['user_id']=$user['User']['user_id'];
				}
				}
				if($this->request->query('type')!=''){
			 if($this->request->query('type')==1){
				$user=$this->User->find('first',array('conditions'=>array('user_type'=>$this->request->query['type'])));
				$search['user_id']=$user['User']['user_id'];
				}
				}
			 $this->paginate = array('conditions' =>$search,'order'=>'Order.order_id DESC');
			 $this->set('orderdetails', $this->paginate('Order'));
			
		}else{	
		      $this->paginate = array('conditions' =>'', 'order' => 'order_id DESC');
              $this->set('orderdetails', $this->Paginator->paginate('Order'));
		}
				  }
			
			
			public function admin_view(){
				$this->layout="admin";
				$this->checkadmin();
				
				$paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
				$this->set('paymentdetail',$paymentdetails);
				
			}
			
			public function admin_user_view(){
				$this->layout="admin";
				$this->checkadmin();
				$orderdetails=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				$this->set('orderdetails',$orderdetails);
								
			}
			public function admin_franchisee_view(){
				$this->layout="admin";
				$this->checkadmin();
				$orderdetails=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				$this->set('orderdetails',$orderdetails);
								
			}
			public function admin_product_view(){
				$this->layout="admin";
				$this->checkadmin();
				/*$paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
				$this->set('paymentdetail',$paymentdetails);*/
				$orderdetails=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				$this->set('orderdetails',$orderdetails);				
			}
			public function admin_billing_view(){
				$this->layout="admin";
				$this->checkadmin();
				$paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
				$this->set('paymentdetail',$paymentdetails);
								
			}
			public function admin_shipping_view(){
				$this->layout="admin";
				$this->checkadmin();
				$paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
				$this->set('paymentdetail',$paymentdetails);
								
			}
			
			public function admin_order_view(){
				$this->layout="admin";
				$this->checkadmin();
				/*$paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
				$this->set('paymentdetail',$paymentdetails);*/
				$orderdetails=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				$this->set('orderdetails',$orderdetails);
								
			}
			
			
			public function admin_chq_dd_view(){
				$this->layout="admin";
				$this->checkadmin();
				$orderdetails=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				$user=$this->User->find('first',array('conditions'=>array('user_id'=>$orderdetails['Order']['user_id'])));
				$this->set('orderdetails',$orderdetails);
				$paymentaldetails=$this->Paymentdetails->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
				if(empty($paymentaldetails)){
				if($this->request->is('post')){
				$this->request->data['Paymentdetails']['order_id']=$orderdetails['Order']['order_id'];
				$this->request->data['Paymentdetails']['user_id']=$orderdetails['Order']['user_id'];
				$this->request->data['Paymentdetails']['status']='Success';	
				$this->request->data['Paymentdetails']['ip']=$_SERVER['REMOTE_ADDR'];	
				$this->request->data['Paymentdetails']['created_date'] =date('Y-m-d H:i:s');
				$this->Paymentdetails->save($this->request->data);
				$this->request->data['Order']['order_id']=$orderdetails['Order']['order_id'];
				$this->request->data['Order']['status']='Paid';
				if($user['User']['user_type']=='0'){
				$this->request->data['Order']['order_status']='BookedbyUser';
				}elseif($user['User']['user_type']=='1'){
				$this->request->data['Order']['order_status']='BookedbyFranchisee';	
				}
				$this->Order->save($this->request->data);
				/*$id=$this->Paymentdetails->getLastInsertId();
				$paymentaldetails_id=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$id)));
				$amount=$paymentaldetails_id['Paymentdetails']['amount'];
				$chq=$paymentaldetails_id['Paymentdetails']['chq/dd'];
				$bankname=$paymentaldetails_id['Paymentdetails']['bankname'];
				$cart=$this->Shoppingcart->find('all',array('conditions'=>array('order_id'=>$orderdetails['Order']['order_id'])));
				foreach($cart as $carts){
				$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
				
				//$cat=$this->Category->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
				//$image=$this->Productimage->find('first',array('conditions'=>array('product_id'=>$product['Product']['product_id'])));
				//$orders=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
				//$tot=$carts['Shoppingcart']['total']-$orders['Order']['cod_amount'];
				$msg='';
				//$msg.='Product'.$product['Product']['product_name'].'Total Weight'.$carts['Shoppingcart']['total_weight'].'Purity'.$carts['Shoppingcart']['purity'].'Diamond in'.;			
						
		}
				$activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' =>15)));
				$name=$user['User']['first_name'];
				$message = str_replace(array('{name}','{amount}','{chqno}','{bankname}'), array($name,$amount,$chq,$bankname,$msg), $activateemail['Emailcontent']['content']);
				$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
				$this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);*/
							
				$this->Session->setFlash('<div class="success msg">CHQ/DD details added successfully.</div>','');
				$this->redirect(array('action'=>'chq_dd_view',$this->params['pass']['0']));	
				}
				}else{
				$this->set('paymentaldetails',$paymentaldetails);
				if($this->request->is('post')){
			    $this->request->data['Paymentdetails']['paymentdetails_id']=$paymentaldetails['Paymentdetails']['paymentdetails_id'];
				$this->request->data['Paymentdetails']['ip']=$_SERVER['REMOTE_ADDR'];	
				$this->request->data['Paymentdetails']['created_date'] =date('Y-m-d H:i:s');
				$this->Paymentdetails->save($this->request->data);
				$this->Session->setFlash('<div class="success msg">CHQ/DD details updated successfully.</div>','');
				$this->redirect(array('action'=>'chq_dd_view',$this->params['pass']['0']));	
				}
				}
				
				
			}
}




