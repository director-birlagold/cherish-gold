<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PayupaymentController extends AppController {

	public $components = array('Paginator','Session','Image');
	
	public $uses=array('Payu','Shoppingcart','User','Order');
	
	public $layout='webpage';
	
	public function index(){
		if($this->Session->read('User')==''){
			$this->redirect(array('controller'=>'webpage','action'=>'index'));
		}
		$payu=$this->Payu->find('first',array('conditions'=>array('payu_id'=>'1')));
		$key=$payu['Payu']['key'];
		$salt=$payu['Payu']['salt'];
		$env=$payu['Payu']['mode'];
		$url=$this->payu_url($env);
		if($this->Session->read('Franchisee.User.user_id')==''){
		$cart_product=$this->Shoppingcart->find('first',array('conditions'=>array('cart_session'=>$this->Session->read('cart_process')),'fields'=>array('SUM(quantity*total) as tot')));
		$amount=$cart_product[0]['tot'];
		}
		else
		{
			$orderamount=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
			if($orderamount['Order']['cod_status']=='COD') {
			$amount=$orderamount['Order']['cod_amount'];
			}
			elseif($orderamount['Order']['cod_status']=='PayU') 
			{
				$cart_product=$this->Shoppingcart->find('first',array('conditions'=>array('cart_session'=>$this->Session->read('cart_process')),'fields'=>array('SUM(quantity*total) as tot')));
		$amount=$cart_product[0]['tot'];
			}
		}
		$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
		$user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
		if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.1.20'){
			$tn='SG-INNN-';
			
		}else
		{
			$tn='SG-ONNNN-';
		}
		$params=array ('url'=>$url.'_payment','key' => $key, 'txnid' => $tn.$order['Order']['invoice'], 'amount' => $amount,'firstname' => $user['User']['first_name'],'lastname'=>$user['User']['last_name'], 'email' =>$user['User']['email'], 'phone' => $user['User']['phone_no'],'productinfo' => 'Shagunn Product', 'surl' => BASE_URL.'orders/payment_success', 'furl' => BASE_URL.'orders/payment_failure','salt'=>$salt);
		$this->check_params($params);
		$params['hash'] = $this->get_hash($params, $salt);			
		$this->set('params',$params);		
			
	}
	
	public function check_params ($params){
		if ( empty( $params['key'] ) ) return $this->error( 'key' );
		if ( empty( $params['txnid'] ) ) return $this->error( 'txnid' );
		if ( empty( $params['amount'] ) ) return $this->error( 'amount' );
		if ( empty( $params['firstname'] ) ) return $this->error( 'firstname' );
		if ( empty( $params['email'] ) ) return $this->error( 'email' );
		if ( empty( $params['phone'] ) ) return $this->error( 'phone' );
		if ( empty( $params['productinfo'] ) ) return $this->error( 'productinfo' );
		if ( empty( $params['surl'] ) ) return $this->error( 'surl' );
		if ( empty( $params['furl'] ) ) return $this->error( 'furl' );
		
		return true;
	}
	
	public function error ( $key ){		
		$this->Session->setFlash("<div class='success msg'>" . __('Mandatory parameter ' . $key . ' is empty') . "</div>");
		$this->redirect(array('action' =>'order','controller'=>'orders'));
	}
	
	public function payu_url($env){
		switch ( $env ) {
		case 'test' :
			$url = 'https://test.payu.in/';
			break;
		case 'live' :
			$url = 'https://secure.payu.in/';
			break;
		default :
			$url = 'https://test.payu.in/';
		}
		return $url;
	}
	
	public static function get_hash ( $params, $salt ){
		$posted = array ();
		
		if ( ! empty( $params ) ) foreach ( $params as $key => $value )
			$posted[$key] = htmlentities( $value, ENT_QUOTES );
		
		$hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		
		$hash_vars_seq = explode( '|', $hash_sequence );
		$hash_string = null;
		
		foreach ( $hash_vars_seq as $hash_var ) {
			$hash_string .= isset( $posted[$hash_var] ) ? $posted[$hash_var] : '';
			$hash_string .= '|';
		}
		
		$hash_string .= $salt;		
		return strtolower( hash( 'sha512', $hash_string ) );
	}
	
	public static function reverse_hash ( $params, $salt, $status )
	{
		$posted = array ();
		$hash_string = null;
		
		if ( ! empty( $params ) ) foreach ( $params as $key => $value )
			$posted[$key] = htmlentities( $value, ENT_QUOTES );
		
		$additional_hash_sequence = 'base_merchantid|base_payuid|miles|additional_charges';
		$hash_vars_seq = explode( '|', $additional_hash_sequence );
		
		foreach ( $hash_vars_seq as $hash_var )
			$hash_string .= isset( $posted[$hash_var] ) ? $posted[$hash_var] . '|' : '';
		
		$hash_sequence = "udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
		$hash_vars_seq = explode( '|', $hash_sequence );
		$hash_string .= $salt . '|' . $status;
		
		foreach ( $hash_vars_seq as $hash_var ) {
			$hash_string .= '|';
			$hash_string .= isset( $posted[$hash_var] ) ? $posted[$hash_var] : '';
		}
		
		return strtolower( hash( 'sha512', $hash_string ) );
	}
	
	public static function curl_call ( $url, $data ){
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch,  CURLOPT_POST , true);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36');
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
				
		/*curl_setopt_array( $ch, array ( 
			CURLOPT_URL => $url, 
			CURLOPT_POSTFIELDS => $data, 
			CURLOPT_POST => true, 
			CURLOPT_RETURNTRANSFER => true, 
			CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', 
			CURLOPT_SSL_VERIFYHOST => 0, 
			CURLOPT_SSL_VERIFYPEER => 0 ) );	*/
				
		$o = curl_exec( $ch );	
			
		if ( curl_errno( $ch ) ) {
			$c_error = curl_error( $ch );			
			if ( empty( $c_error ) ) $c_error = 'Server Error';			
			return array ( 'curl_status' => 0, 'error' => $c_error );
		}
		
		$o = trim( $o );
		return array ( 'curl_status' => 1, 'result' => $o );
	}

	
	
	}