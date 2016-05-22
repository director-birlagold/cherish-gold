<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class ShoppingcartsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Shoppingcart', 'Product','Order','Discounthistory', 'User');
    public $layout = 'frontend';
	/*List Shopping Carts in User Login */
    public function shopping_cart() {
        if ($this->Session->read('cart_process') == '') {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        }
        if ($this->request->is('post')) {
            if (!empty($this->request->data['cartid'])) {
                $i = 0;
                foreach ($this->request->data['cartid'] as $cartid) {
                    $this->request->data['Shoppingcart']['cart_id'] = $cartid;
                    $this->request->data['Shoppingcart']['quantity'] = $this->request->data['quantity'][$i];
                    $this->Shoppingcart->saveAll($this->request->data['Shoppingcart']);
                    $i++;
                }
                $this->redirect(array('action' => 'shopping_cart'));
            }
        }

        $cart_product = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
        if (empty($cart_product)) {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        } else {

            $this->set('cart_products', $cart_product);
        }
    }
    
    public function minicart() {
        $this->layout = '';
        if (isset($this->request->data['Shopping']['shoppingsubmit'])) {
            if ($this->Session->read('cart_process') == '') {
                $this->Session->write('cart_process');
                $cart_session = $this->str_rand(15);
            } else {
                $cart_session = $this->Session->read('cart_process');
            }
            $carts = $this->Shoppingcart->find('first', array('conditions' => array('size' => $this->request->data['Shoppingcart']['size'], 'purity' => $this->request->data['Shoppingcart']['purity'], 'color' => $this->request->data['Shoppingcart']['color'], 'clarity' => $this->request->data['Shoppingcart']['clarity'], 'product_id' => $this->request->data['Shoppingcart']['product_id'], 'cart_session' => $cart_session)));

            if (empty($carts)) {
                $this->request->data['Shoppingcart']['cart_session'] = $cart_session;
                $this->request->data['Shoppingcart']['stoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneamount']);
                $this->request->data['Shoppingcart']['goldamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldamount']);
                $this->request->data['Shoppingcart']['vat'] = str_replace(",", '', $this->request->data['Shoppingcart']['vat']);
                $this->request->data['Shoppingcart']['making_charge'] = str_replace(",", '', $this->request->data['Shoppingcart']['making_charge']);
                $this->request->data['Shoppingcart']['total'] = str_replace(",", '', $this->request->data['Shoppingcart']['total']);
                $this->request->data['Shoppingcart']['goldprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldprice']);
                $this->request->data['Shoppingcart']['stoneprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneprice']);
                $this->request->data['Shoppingcart']['gemstoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['gemstoneamount']);
                $this->request->data['Shoppingcart']['created_date'] = date('Y-m-d H:i:s');
                $this->Shoppingcart->save($this->request->data);
            } else {
               // $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];
                $carts['Shoppingcart']['quantity']= $carts['Shoppingcart']['quantity'] + 1;
                $this->Shoppingcart->save($carts);
            }
			if($this->Session->read('discount')!=''){
				$this->Order->updateAll(array('discount_per'=>NULL,'discount_amount'=>0),array('order_id'=>$this->Session->read('Order')));
				$this->Discounthistory->deleteAll(array('order_id'=>$this->Session->read('Order')),false,false,false);
				$this->Session->delete('discount');
			}
            $this->Session->write('cart_process', $cart_session);
        }
    
        if ($this->Session->read('cart_process') == '') {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        }

        $cart_product = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
        if (empty($cart_product)) {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        } else {

            $this->set('cart_products', $cart_product);
        }
    }
	/*Add Shopping Carts */
    public function addcart() {
        if (isset($this->request->data['Shopping']['shoppingsubmit'])) {
            if ($this->Session->read('cart_process') == '') {
                $this->Session->write('cart_process');
                $cart_session = $this->str_rand(15);
            } else {
                $cart_session = $this->Session->read('cart_process');
            }
            $carts = $this->Shoppingcart->find('first', array('conditions' => array('size' => $this->request->data['Shoppingcart']['size'], 'purity' => $this->request->data['Shoppingcart']['purity'], 'color' => $this->request->data['Shoppingcart']['color'], 'clarity' => $this->request->data['Shoppingcart']['clarity'], 'product_id' => $this->request->data['Shoppingcart']['product_id'], 'cart_session' => $cart_session)));

            if (empty($carts)) {
                $this->request->data['Shoppingcart']['cart_session'] = $cart_session;
                $this->request->data['Shoppingcart']['stoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneamount']);
                $this->request->data['Shoppingcart']['goldamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldamount']);
                $this->request->data['Shoppingcart']['vat'] = str_replace(",", '', $this->request->data['Shoppingcart']['vat']);
                $this->request->data['Shoppingcart']['making_charge'] = str_replace(",", '', $this->request->data['Shoppingcart']['making_charge']);
                $this->request->data['Shoppingcart']['total'] = str_replace(",", '', $this->request->data['Shoppingcart']['total']);
                $this->request->data['Shoppingcart']['goldprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldprice']);
                $this->request->data['Shoppingcart']['stoneprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneprice']);
                $this->request->data['Shoppingcart']['gemstoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['gemstoneamount']);
                $this->request->data['Shoppingcart']['created_date'] = date('Y-m-d H:i:s');
                $this->Shoppingcart->save($this->request->data);
            } else {
               // $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];
                $carts['Shoppingcart']['quantity']= $carts['Shoppingcart']['quantity'] + 1;
                $this->Shoppingcart->save($carts);
            }
			if($this->Session->read('discount')!=''){
				$this->Order->updateAll(array('discount_per'=>NULL,'discount_amount'=>0),array('order_id'=>$this->Session->read('Order')));
				$this->Discounthistory->deleteAll(array('order_id'=>$this->Session->read('Order')),false,false,false);
				$this->Session->delete('discount');
			}
            $this->Session->write('cart_process', $cart_session);
            
            if($this->Session->check('User.user_id')){
                $this->User->id = $this->Session->read('User.user_id');
                $this->User->saveField('cart_session', $cart_session);
            }
        }
        $this->redirect(array('action' => 'shopping_cart'));
    }			

	public function quickaddcart() {        
		if (isset($this->request->data['Shopping']['shoppingsubmit'])) {            
			if ($this->Session->read('cart_process') == '') {                
				$this->Session->write('cart_process');                
				$cart_session = $this->str_rand(15);            
			} else {                
				$cart_session = $this->Session->read('cart_process');            
			}            
			$carts = $this->Shoppingcart->find('first', array('conditions' => array('size' => $this->request->data['Shoppingcart']['size'], 'purity' => $this->request->data['Shoppingcart']['purity'], 'color' => $this->request->data['Shoppingcart']['color'], 'clarity' => $this->request->data['Shoppingcart']['clarity'], 'product_id' => $this->request->data['Shoppingcart']['product_id'], 'cart_session' => $cart_session)));            
			if (empty($carts)) {                
				$this->request->data['Shoppingcart']['cart_session'] = $cart_session;                
				$this->request->data['Shoppingcart']['stoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneamount']);                
				$this->request->data['Shoppingcart']['goldamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldamount']);
		                $this->request->data['Shoppingcart']['vat'] = str_replace(",", '', $this->request->data['Shoppingcart']['vat']);                
				$this->request->data['Shoppingcart']['making_charge'] = str_replace(",", '', $this->request->data['Shoppingcart']['making_charge']);                
				$this->request->data['Shoppingcart']['total'] = str_replace(",", '', $this->request->data['Shoppingcart']['total']);                
				$this->request->data['Shoppingcart']['goldprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['goldprice']);                
				$this->request->data['Shoppingcart']['stoneprice'] = str_replace(",", '', $this->request->data['Shoppingcart']['stoneprice']);                
				$this->request->data['Shoppingcart']['gemstoneamount'] = str_replace(",", '', $this->request->data['Shoppingcart']['gemstoneamount']);                
				$this->request->data['Shoppingcart']['created_date'] = date('Y-m-d H:i:s');                
				$this->Shoppingcart->save($this->request->data);            
			} else {               
				// $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];                
				$carts['Shoppingcart']['quantity']= $carts['Shoppingcart']['quantity'] + 1;                
				$this->Shoppingcart->save($carts);            
			}			
		
			if($this->Session->read('discount')!=''){				
				$this->Order->updateAll(array('discount_per'=>NULL,'discount_amount'=>0),array('order_id'=>$this->Session->read('Order')));				
				$this->Discounthistory->deleteAll(array('order_id'=>$this->Session->read('Order')),false,false,false);				
				$this->Session->delete('discount');			
			}            
			
			$this->Session->write('cart_process', $cart_session);                        
			
			if($this->Session->check('User.user_id')){                
				$this->User->id = $this->Session->read('User.user_id');                
				$this->User->saveField('cart_session', $cart_session);            
			}        
		}        		
		
		if($this->Session->read('User')=='') {			
			$this->redirect(array("controller" => "signin","action" => "index","?" => array("ref" => "cart")));		
		}else {			
			$usertypest = $this->Session->read('User');			
			if($usertypest['user_type'] == 1){				
				//$link=BASE_URL.'orders/personal_details';				
				$this->redirect(array("controller" => "orders","action" => "personal_details"));			
			}else{				
				//$link=BASE_URL.'orders/shipping_details';				
				$this->redirect(array("controller" => "orders","action" => "shipping_details"));			
			}			
		}				    
	}
		
	/*Remove Shopping Carts */
    public function remove() {
        $this->layout = '';
        $this->render(false);
        $cart = $this->Shoppingcart->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->Shoppingcart->delete(array('product_id' => $this->params['pass']['0']));
        $this->redirect(array('action' => 'shopping_cart'));
    }
	
	/* Added by Rohan on 02-02-2016 */
	
    public function open_cart_api_addcart() 
	{
        if (isset($_REQUEST['product_id'])) 
		{
            if ($_REQUEST['cakePhp_cart_session'] == '') 
			{
                $this->Session->write('cart_process');
                $cart_session = $this->str_rand(15);
            } 
			else 
			{
                $cart_session = $_REQUEST['cakePhp_cart_session'];
            }
			
            $carts = $this->Shoppingcart->find('first', array('conditions' => array('Shoppingcart.product_id' => $_REQUEST['product_id']),'order' => array('Shoppingcart.cart_id' => 'desc')));
			
            if (empty($carts)) {
                $this->request->data['Shoppingcart']['cart_session'] = $cart_session;
                $this->request->data['Shoppingcart']['product_id'] = str_replace(",", '', $_REQUEST['product_id']);
                $this->request->data['Shoppingcart']['metal'] = str_replace(",", '', $_REQUEST['metal']);
                $this->request->data['Shoppingcart']['purity'] = str_replace(",", '', $_REQUEST['purity']);
                $this->request->data['Shoppingcart']['size'] = str_replace(",", '', $_REQUEST['size']);
                $this->request->data['Shoppingcart']['clarity'] = str_replace(",", '', $_REQUEST['clarity']);
                $this->request->data['Shoppingcart']['color'] = str_replace(",", '', $_REQUEST['color']);
                $this->request->data['Shoppingcart']['metalcolor'] = str_replace(",", '', $_REQUEST['metalcolor']);
                $this->request->data['Shoppingcart']['weight'] = str_replace(",", '', $_REQUEST['weight']);
                $this->request->data['Shoppingcart']['quantity'] = str_replace(",", '', $_REQUEST['quantity']);
                $this->request->data['Shoppingcart']['stoneamount'] = str_replace(",", '', $_REQUEST['stoneamount']);
                $this->request->data['Shoppingcart']['goldamount'] = str_replace(",", '', $_REQUEST['goldamount']);
                $this->request->data['Shoppingcart']['vat'] = str_replace(",", '', $_REQUEST['vat']);
                $this->request->data['Shoppingcart']['vat_per'] = str_replace(",", '', $_REQUEST['vat_per']);
                $this->request->data['Shoppingcart']['making_charge'] = str_replace(",", '', $_REQUEST['making_charge']);
                $this->request->data['Shoppingcart']['making_per'] = str_replace(",", '', $_REQUEST['making_per']);
                $this->request->data['Shoppingcart']['total'] = str_replace(",", '', $_REQUEST['total']);
                $this->request->data['Shoppingcart']['goldprice'] = str_replace(",", '', $_REQUEST['goldprice']);
                $this->request->data['Shoppingcart']['stoneprice'] = str_replace(",", '', $_REQUEST['stoneprice']);
                $this->request->data['Shoppingcart']['gemstoneamount'] = str_replace(",", '', $_REQUEST['gemstoneamount']);
                $this->request->data['Shoppingcart']['created_date'] = date('Y-m-d H:i:s');
				
				$this->Shoppingcart->save($this->request->data);
            } else {
               // $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];
                $carts['Shoppingcart']['quantity'] = ($carts['Shoppingcart']['quantity']+$_REQUEST['quantity']);
                $this->Shoppingcart->save($carts);
            }
			if($this->Session->read('discount')!=''){
				$this->Order->updateAll(array('discount_per'=>NULL,'discount_amount'=>0),array('order_id'=>$this->Session->read('Order')));
				$this->Discounthistory->deleteAll(array('order_id'=>$this->Session->read('Order')),false,false,false);
				$this->Session->delete('discount');
			}
			
			
            if($this->Session->check('User.user_id')){
                $this->User->id = $this->Session->read('User.user_id');
                $this->User->saveField('cart_session', $cart_session);
            }
			
			echo $cart_session;
        }
        
		
    }
	
	/*Remove Shopping Carts */
    public function open_cart_api_removecart() 
	{
		$product_id = $_REQUEST['product_id'];
		$cakePhp_cart_session = $_REQUEST['cakePhp_cart_session'];
        $cart = $this->Shoppingcart->find('first', array('conditions' => array('Shoppingcart.product_id' => $product_id),'order' => array('Shoppingcart.cart_id' => 'desc')));
        
		if(!empty($cart['Shoppingcart']['cart_id']))
		{
			$this->Shoppingcart->delete($cart['Shoppingcart']['cart_id'],false);
		}
    }
	
	public function open_cart_api_getcart() 
	{
		if(!empty($_REQUEST['products']))
		{
			$products = explode(",",$_REQUEST['products']);
			$cart_product['sub_total'] = 0;
			$cart_product['vat'] = 0;
			$cart_product['total'] = 0;
			$cart_product['total_quantity'] = 0;
			
			foreach($products as $product)
			{
				$key = unserialize(base64_decode($product));
				$cart = $this->Shoppingcart->find('first', array('conditions' => array('Shoppingcart.product_id' => $key['product_id']),'order' => array('Shoppingcart.cart_id' => 'desc')));
				
				if(!empty($cart))
				{
					$cart_product[$cart['Shoppingcart']['product_id']]['price'] = $cart['Shoppingcart']['total'];
					$cart_product[$cart['Shoppingcart']['product_id']]['quantity'] = $cart['Shoppingcart']['quantity'];
					$cart_product['sub_total'] += ($cart['Shoppingcart']['total']*$cart['Shoppingcart']['quantity'])-$cart['Shoppingcart']['vat'];
					$cart_product['total_quantity'] += $cart['Shoppingcart']['quantity'];
					$cart_product['vat'] += $cart['Shoppingcart']['vat'];
				}
			}
			
			$cart_product['total'] += ($cart_product['sub_total']+$cart_product['vat']);
			$cart_product['cart_total'] = $cart_product['total_quantity'].' item(s) - Rs. '.($cart_product['sub_total']+$cart_product['vat']);
			
			echo json_encode($cart_product);
		}
    }
}
