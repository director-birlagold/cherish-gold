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
    public $components = array('Paginator', 'Session', 'Image', 'Mpdf');

 /*    public $uses = array('Order','Orderstatus', 'User', 'Shipping', 'Shoppingcart', 'Discount', 'Paymentdetails', 'Discounthistory', 'Product', 'Productimage', 'Category', 'Productdiamond', 'Productgemstone', 'Vendorcontact', 'Products', 'Shippingrate', 'Partialpay','Vendor'); */	    
 
 public $uses = array('Order', 'User', 'Shipping', 'Shoppingcart', 'Discount', 'Paymentdetails', 'Discounthistory', 'Product',  'Collectiontype',  'Productmetal',    'Productimage', 'Category','Size', 'Productdiamond', 'Productgemstone', 'Vendorcontact', 'Products', 'Shippingrate', 'Partialpay',        'Orderhistory', 'Vendor', 'Orderstatus', 'Subcategory','Vendorcontact', 'Franchiseecustomers');

    public $layout = 'frontend';

    public function personal_details() {
        if ($this->Session->read('User') != '') {
            $user_id = $this->Session->read('User.user_id');
            $user = $this->User->find('first', array('conditions' => array('user_id' => $user_id)));
            $this->set('user', $user);
			
			$franchiseecustomer = $this->Franchiseecustomers->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
            $this->set('franchiseecustomer', $franchiseecustomer);
            if (!empty($this->request->data)) {

                $check = $this->User->find('first', array('conditions' => array('user_id' => $user_id)));
                if (!empty($check)) {
                    $this->request->data['User']['user_id'] = $check['User']['user_id'];
                    $this->request->data['User']['created_date'] = date('Y-m-d H:i:s');
                    if (!empty($this->request->data['User']['year']) && !empty($this->request->data['User']['month']) && !empty($this->request->data['User']['date'])) {
                        $this->request->data['User']['date_of_birth'] = $this->request->data['User']['year'] . "-" . $this->request->data['User']['month'] .
                                "-" . $this->request->data['User']['date'];
                    } else {
                        $this->request->data['User']['date_of_birth'] = '';
                    }
                    if (!empty($this->request->data['User']['annu_year']) && !empty($this->request->data['User']['annu_month']) && !empty($this->request->data['User']['annu_date'])) {
                        $this->request->data['User']['anniversary'] = $this->request->data['User']['annu_year'] . "-" . $this->request->data['User']['annu_month'] . "-" . $this->request->data['User']['annu_date'];
                    } else {
                        $this->request->data['User']['anniversary'] = '';
                    }
                    $this->User->save($this->request->data['User']);
					
					$validateCustomer = $this->Franchiseecustomers->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
					if (!empty($validateCustomer)) {
						$this->request->data['Franchiseecustomers']['franchisee_customer_id'] = $validateCustomer['Franchiseecustomers']['franchisee_customer_id'];
					}
					$this->request->data['Franchiseecustomers']['user_id'] = $check['User']['user_id'];
					$this->request->data['Franchiseecustomers']['created_date'] = date('Y-m-d H:i:s');
					$this->request->data['Franchiseecustomers']['cart_session'] = $this->Session->read('cart_process');
					$this->Franchiseecustomers->save($this->request->data['Franchiseecustomers']);
					
                    $this->Session->setFlash("<div class='success msg'>" . __('Personal detail  saved successfully') . "</div>");
                    $this->redirect(array('controller' => 'orders', 'action' => 'shipping_details'));
                }
            }
        }
    }

    public function shipping_details() {

        if ($this->Session->read('User') != '') {
            if ($this->Session->read('Order') != '') {

                $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));

                if (!empty($order)) {
                    $this->set('order', $order);
                } else {
                    $order = $this->Order->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'order' => 'order_id DESC'));
                    if (!empty($order)) {
                        $this->set('order', $order);
                    }
                }
            } else {
				if($this->Session->read('User.buying_for') == "Customer"){
					$order = $this->Order->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'order' => 'order_id DESC'));
                    if (!empty($order)) {
                        $this->set('order', $order);
                    }
				}else{
					$shipping_add = $this->Shipping->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'), 'default' => 1)));

					if (!empty($shipping_add)) {
						$this->set('shipping', $shipping_add);
					} else {
						$order = $this->Order->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'order' => 'order_id DESC'));
						if (!empty($order)) {
							$this->set('order', $order);
						}
					}
				}
            }
        }
		
        if (!empty($this->request->data)) {
            if ($this->Session->read('User') != '') {
                $user_id = $this->Session->read('User.user_id');
                if ($this->Session->read('Order') != '') {
                    $order_id = $this->Session->read('Order');
                    $check = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
                    if (!empty($check)) {
                        $this->request->data['Order']['order_id'] = $check['Order']['order_id'];
                        $this->request->data['Order']['user_id'] = $user_id;
                        $this->Order->save($this->request->data);
                    }
                } else {
                    $this->request->data['Order']['user_id'] = $user_id;
					$this->request->data['Order']['buying_for'] = $this->Session->read('User.buying_for');
                    $invoice = $this->Order->find('first', array('fields' => array('MAX(Order.invoice) AS maxid', '*')));
                    if (!empty($invoice[0]['maxid'])) {
                        $tiid = $invoice[0]['maxid'] + 1;
                    } else {
                        $tiid = 1;
                    }
                    $invoice_code = sprintf("%06d", $tiid);
					
                    $this->request->data['Order']['invoice'] = $invoice_code;
                    $this->request->data['Order']['user_id'] = $this->Session->read("User.user_id");
					
                    $this->request->data['Order']['created_date'] = date('Y-m-d H:i:s');
                    $this->Order->save($this->request->data);
                    $order_id = $this->Order->getLastInsertID();
                }
                $this->Session->write('Order', $order_id);
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Shipping detail  saved successfully') . "</div>");

            $this->redirect(array('controller' => 'orders', 'action' => 'order'));
        }if (isset($this->params['pass']['0'])) {
            $this->Session->setFlash("<div class='error msg'>" . __('We could not do delivery this pincode. Sorry for the inconvinience.') . "</div>");
        }
    }

    public function order() {
        /* check the cart session */
        if ($this->Session->read('cart_process') != '') {
            $cart_product = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
            if (empty($cart_product)) {
                $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
            }
        } else {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        }
		//echo "<pre>";
		//print_r($this->request->data);exit;
        /* payment process */
        if (isset($this->request->data['Paymentdetails']['payment'])) {
            $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
            $partialpay = $this->Partialpay->find('first', array('conditions' => array('partialpay_id' => '1')));
            $partialpay_percentage = $partialpay['Partialpay']['partialpay_per'];
            if (!empty($order)) {
                $this->request->data['Order']['order_id'] = $order['Order']['order_id'];
                $this->request->data['Order']['cod_status'] = $_REQUEST['cod_status'];

                if ($_REQUEST['cod_status'] == 'COD') {
                    $this->request->data['Order']['cod_percentage'] = $partialpay_percentage;
                    $this->request->data['Order']['cod_amount'] = round(($_REQUEST['amountpay'] * $partialpay_percentage) / 100);
                    $this->Order->saveAll($this->request->data);
                    $this->redirect(array('action' => 'payment', 'controller' => 'orders'));
                } elseif ($_REQUEST['cod_status'] == 'PayU') {
                    //pr($this->request->data['amountpay']);exit;
                    $this->request->data['Order']['netpayamt'] = $this->request->data['amountpay'];
                    $this->Order->saveAll($this->request->data);
                    $this->redirect(array('action' => 'payment', 'controller' => 'orders'));
                } elseif ($_REQUEST['cod_status'] == 'CHQ/DD') {
                    $this->request->data['Order']['org_invoice'] = $this->generate_invoice_number();
                    $this->Order->saveAll($this->request->data);
                    $order1 = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                    $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
                    $name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                    $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $this->Session->read('Order'))));
					
					$this->request->data['Paymentdetails']['order_id'] = $order1['Order']['order_id'];
                    $this->request->data['Paymentdetails']['user_id'] = $order1['Order']['user_id'];
                    $this->request->data['Paymentdetails']['status'] = 'Success';
                    $this->request->data['Paymentdetails']['admin_status'] = 'Order in Progress';
                    $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
					$this->request->data['Paymentdetails']['amount'] = $this->request->data['amountpay'];
                    //$this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');

                    $this->Paymentdetails->save($this->request->data);
					
					
                    if ($user['User']['user_type'] == '0') {
                        if ($order1['Order']['cod_status'] == 'PayU') {
                            $in = 'SGN-ON-';
                        } elseif ($order1['Order']['cod_status'] == 'CHQ/DD') {
                            $in = 'SGN-CHQ/DD-';
                        } elseif ($order1['Order']['cod_status'] == 'COD') {
                            $in = 'SGN-CD-';
                        }
                    } else {
                        if ($order1['Order']['cod_status'] == 'PayU') {
                            $in = 'SGN-FN-';
                        } elseif ($order1['Order']['cod_status'] == 'COD') {
                            $in = 'SGN-FNCD-';
                        } elseif ($order1['Order']['cod_status'] == 'CHQ/DD') {
                            $in = 'SGN-FNCHQ/DD-';
                        }
                    }

                    $msg = '';
                    if (!empty($cart)) {
                        $msg = '<table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000; border-bottom:none;" width="100%">
						  <tr>
							<th width="10" height="27" style="border-bottom:1px solid #000;border-right:1px solid #000; " >S.No</th>
							<th style=" border-bottom:1px solid #000;border-right:1px solid #000; " >Product Code</th>
							<th style="border-bottom:1px solid #000;border-right:1px solid #000; " >Product Description</th>
							<th width="10" style="border-bottom:1px solid #000;border-right:1px solid #000; "  >Quantity</th>
							<th style=" border-bottom:1px solid #000;" >Price</th>
						  </tr>';
                        $i = 1;
                        $productnames = '';
                        foreach ($cart as $carts) {
                            $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                            $productdiamond = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'], 'clarity' => $carts['Shoppingcart']['clarity'], 'color' => $carts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));

                            $productgemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));

                            $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                            $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                            $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
                            $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                            
                            $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                            $productnames .= $sub_category['Subcategory']['subcategory'].',';
                            $msg.='<tr align="center" >
            <td valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000; " >' . $i . '</td>
            <td valign="top" style=" border-bottom:1px solid #000;border-right:1px solid #000; ">' . $cat['Category']['category_code'] . '' . $product['Product']['product_code'] . '-' . $carts['Shoppingcart']['purity'] . 'K' . $carts['Shoppingcart']['clarity'] . $carts['Shoppingcart']['color'] . '</td>
            <td  valign="middle" style=" border-bottom:1px solid #000;border-right:1px solid #000; " ><table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000;" width="80%">
                <tr >
                  <td style="border-bottom:1px solid #000;">' . $product['Product']['product_name'] . ',</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #000;">' . ($carts['Shoppingcart']['size'] != '' ? '<strong>Size -</strong> 12,<br />' : '') . '
                    <strong>Metals:</strong> ' . $carts['Shoppingcart']['purity'] . 'K ' . $carts['Shoppingcart']['metalcolor'] . ' Glod</td>
                </tr>
                <tr>
                  <td style="line-height:0.5;"><p><strong>Matels Wt:</strong> ' . $carts['Shoppingcart']['weight'] . ' gms</p>';
                            if ($carts['Shoppingcart']['stoneamount'] > 0) {
                                $msg.='<p><strong>Stone:</strong> Diamond</p>
                    <p><strong>Stone Wt:</strong> ' . $productdiamond[0]['sweight'] . ' carat</p>
                    <p><strong>Quality:</strong> ' . $carts['Shoppingcart']['clarity'] . '-' . $carts['Shoppingcart']['color'] . '</p>
                    <p><strong>Number of Stone:</strong> ' . $productdiamond[0]['no_diamond'] . '</p>';
                            }
                            if ($carts['Shoppingcart']['gemstoneamount'] > 0) {
                                foreach ($productgemstone as $productgemstone) {
                                    $msg.='<p><strong>Stone:</strong> ' . $productgemstone['Productgemstone']['gemstone'] . '</p>
							<p><strong>Stone Wt:</strong>  ' . $productgemstone['Productgemstone']['stone_weight'] . ' carat</p>
							<p><strong>Number of Stone:</strong> ' . $productgemstone['Productgemstone']['no_of_stone'] . '</p>';
                                }
                            }
                            $msg.='</td>
                </tr>
              </table></td>
            <td style=" border-bottom:1px solid #000;border-right:1px solid #000; " valign="top">' . $carts['Shoppingcart']['quantity'] . '</td>
            <td style=" border-bottom:1px solid #000; " valign="top">' . ($carts['Shoppingcart']['quantity'] * $carts['Shoppingcart']['total']) . '</td>
          </tr>';
                        }$msg.='</table>';
                    }
                    $shipping_details = ' <p><strong>' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . '</strong></p>
			<p>' . str_replace('/n', '<br/>', $order1['Order']['shipping_add']) . '</p>
			<p>' . $order1['Order']['scity'] . '-' . $order1['Order']['spincode'] . '</p>
			<p>' . $order1['Order']['sstate'] . '</p>';
                    $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order1['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
                    $netamount = $cart_amount[0]['subtotal'];
                    $paymentdetails = '<table border="1" cellpadding="5" align="center">
          <tr>
            <th>Sub Total Amount</th>
            <th>Rs. ' . $cart_amount[0]['subtotal'] . '</th>
          </tr>';
                    if ($order1['Order']['discount_amount'] > 0) {
                        $paymentdetails.='<tr>
            <th>Offer Discount Amount</th>
            <th>Rs. ' . $order1['Order']['discount_amount'] . '</th>
          </tr>';
                        $netamount-=$order1['Order']['discount_amount'];
                    }
                    if ($order1['Order']['shipping_amt'] > 0) {
                        $paymentdetails.=' <tr>
            <th>Shipping Charges :</th>
            <th>Rs. ' . $order1['Order']['shipping_amt'] . '</th>
          </tr>';
                        $netamount+=$order1['Order']['shipping_amt'];
                    }
                    $paymentdetails.='<tr>
            <th>Total Amount</th>
            <th>Rs. ' . $netamount . '</th>
          </tr>';
                    if ($order1['Order']['status'] == 'PartialPaid') {
                        $paymentdetails.='<tr>
            <td>Amount Paid</td>
            <td>Rs. ' . $order1['Order']['cod_amount'] . '</td>
         	 </tr>';
                        $balance = $netamount - $order1['Order']['cod_amount'];
                        $paymentdetails.='<tr>
            <th>Balance Payable Amount :</th>
            <th>Rs. ' . $balance . '</th>
            </tr>';
                    }

                    $paymentdetails.='</table>';

                    $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 11)));
                    $message = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $activateemail['Emailcontent']['content']);
                    $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));

                    //added by prakash
                    $invoice = $this->requestAction(array('action' => 'orderpdf', $order1['Order']['order_id'], 'F'), array('return', 'bare' => false));
                    $file = 'files/invoices/' . str_replace('/', '_', $in . $order1['Order']['invoice'] . '.pdf');
                   // $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message, '', 1, $file, 'acknowledgment', '');
                    //send sms
                    $productnames = rtrim($productnames,',');
                    $sms_message = $this->get_sms_message(1);
                    $sms_message = str_replace(array('{PRODUCT_NAME}'), array($productnames), $sms_message);
                    $this->sendsms($user['User']['phone_no'], $sms_message);
                    
                    $email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 12)));

                    $messagen = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $email['Emailcontent']['content']);
                    //$this->mailsend(SITE_NAME, $user['User']['email'], $adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen, '', 1, $file, 'acknowledgment', '');

                    $this->Session->delete('Order');
                    $this->Session->delete('cart_process');
                    $this->User->read(NULL, $user['User']['user_id']);
                    $this->User->saveField('cart_session', '');
                    $this->Session->setFlash("<div class='success msg'>" . __('Your Order successfully updated.') . "</div>");
                    $this->redirect(BASE_URL . 'account-details');
                }
            }
        }



        if ($this->Session->read('cart_process') != '') {
            $order_id = $this->Session->read('Order');
            $cart = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
            if (!empty($cart)) {
                /* update the order id into shopping cart */
                foreach ($cart as $carts) {
                    $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];
                    $this->request->data['Shoppingcart']['order_id'] = $order_id;
                    $this->Shoppingcart->saveAll($this->request->data);

                }
				
				$franchiseecustomer = $this->Franchiseecustomers->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
				if (!empty($franchiseecustomer)) {
					$this->request->data['Franchiseecustomers']['franchisee_customer_id'] = $franchiseecustomer['Franchiseecustomers']['franchisee_customer_id'];
					$this->request->data['Franchiseecustomers']['order_id'] = $order_id;
					$this->Franchiseecustomers->save($this->request->data['Franchiseecustomers']);
				}
				
                /* shipping rate caluclation */
                $order_pincode = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                $shippingrate_taxcode = $this->Shippingrate->find('first', array('conditions' => array('pincode' => $order_pincode['Order']['spincode'])));
                if (!empty($shippingrate_taxcode)) {
                    $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order_pincode['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
                    $taxrate_amt = round($cart_amount['0']['subtotal'] * $shippingrate_taxcode['Shippingrate']['taxrate'] / 100);
                    $order_pincode['Order']['shipping_per'] = $shippingrate_taxcode['Shippingrate']['taxrate'];
                    $order_pincode['Order']['shipping_amt'] = $taxrate_amt;
                    $this->Order->save($order_pincode);
                }
            }
        }

        /* check the user session */
        if ($this->Session->read('User') != '') {
            $id = $this->Session->read('cart_process');
            $carts = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $id)));
            $this->set('cart', $carts);
            $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
            $this->set('order', $order);
            $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
            $this->set('user', $user);
        }
    }

    public function delete() {
        $this->layout = '';
        $cart = $this->Shoppingcart->find('first', array('conditions' => array('cart_id' => $this->params['pass']['0'])));
        $this->Shoppingcart->deleteAll(array('cart_id' => $this->params['pass']['0']), false, false);
        if ($this->Session->read('discount') != '') {
            $this->Order->updateAll(array('discount_per' => NULL, 'discount_amount' => 0), array('order_id' => $this->Session->read('Order')));
            $this->Discounthistory->deleteAll(array('order_id' => $this->Session->read('Order')), false, false, false);
            $this->Session->delete('discount');
        }
        //$newcart = $this->Shoppingcart->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));       
        $this->Session->setFlash("<div class='success msg'>" . __('Order deleted successfully') . "</div>");
        $this->redirect(array('action' => 'order', 'controller' => 'orders'));
        $this->render(false);
    }

    public function movetowishlist() {
        
    }

    public function payment() {
        if ($this->Session->read('cart_process') != '') {
            $cart_product = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));
            if (empty($cart_product)) {
                $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
            }
        } else {
            $this->redirect(array('action' => 'jewellery', 'controller' => 'webpages'));
        }
        $cart_product = $this->Shoppingcart->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process')), 'fields' => array('SUM(quantity*total) as tot')));
        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        $this->redirect(array('controller' => 'payupayment', 'action' => 'index'));
    }

    public function payment_success() {

        $this->request->data['Paymentdetails']['order_id'] = $this->Session->read('Order');
        $this->request->data['Paymentdetails']['user_id'] = $this->Session->read('User.user_id');
        $this->request->data['Paymentdetails']['txnid'] = $_POST['mihpayid'];
        $this->request->data['Paymentdetails']['amount'] = $_POST['net_amount_debit'];
        $this->request->data['Paymentdetails']['pg_type'] = $_POST['PG_TYPE'];
        $this->request->data['Paymentdetails']['bank_ref_num'] = $_POST['bank_ref_num'];
        $this->request->data['Paymentdetails']['bankcode'] = $_POST['bankcode'];
        $this->request->data['Paymentdetails']['status'] = 'Success';
        $this->request->data['Paymentdetails']['admin_status'] = 'Order in Progress';
        $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
        $this->Paymentdetails->save($this->request->data);
        $last_id = $this->Paymentdetails->getLastInsertID();
        $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        $usertypest = $user['User']['user_type'];
        if ($usertypest == '1') {
            $orderstatus = 'BookedbyFranchisee';
        } elseif ($usertypest == '0') {
            $orderstatus = 'BookedbyUser';
        }
        if (!empty($order)) {
            $this->request->data['Order']['order_id'] = $order['Order']['order_id'];
            $this->request->data['Order']['order_status'] = $orderstatus;
            if ($order['Order']['cod_status'] == 'PayU') {
                $this->request->data['Order']['status'] = 'Paid';
            } elseif ($order['Order']['cod_status'] == 'COD') {
                $this->request->data['Order']['status'] = 'PartialPaid';
            }
            $this->request->data['Order']['org_invoice'] = $this->generate_invoice_number();
            $this->Order->save($this->request->data);
        }
        $order1 = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
        if ($user['User']['user_type'] == '0') {
            if ($order1['Order']['cod_status'] == 'PayU') {
                $in = 'SGN-ON-';
            } elseif ($order1['Order']['cod_status'] == 'CHQ/DD') {
                $in = 'SGN-CHQ/DD-';
            } elseif ($order1['Order']['cod_status'] == 'COD') {
                $in = 'SGN-CD-';
            }
        } else {
            if ($order1['Order']['cod_status'] == 'PayU') {
                $in = 'SGN-FN-';
            } elseif ($order1['Order']['cod_status'] == 'COD') {
                $in = 'SGN-FNCD-';
            } elseif ($order1['Order']['cod_status'] == 'CHQ/DD') {
                $in = 'SGN-FNCHQ/DD-';
            }
        }

        $name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
        $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $this->Session->read('Order'))));
        if ($order1['Order']['cod_status'] == 'COD') {
            $msg = '';
            if (!empty($cart)) {
                $msg = '<table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000; border-bottom:none;" width="100%">
						  <tr>
							<th width="10" height="27" style="border-bottom:1px solid #000;border-right:1px solid #000; " >S.No</th>
							<th style=" border-bottom:1px solid #000;border-right:1px solid #000; " >Product Code</th>
							<th style="border-bottom:1px solid #000;border-right:1px solid #000; " >Product Description</th>
							<th width="10" style="border-bottom:1px solid #000;border-right:1px solid #000; "  >Quantity</th>
							<th style=" border-bottom:1px solid #000;" >Price</th>
						  </tr>';
                $i = 1;
                $productnames = '';
                foreach ($cart as $carts) {
                    $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                    $productdiamond = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'], 'clarity' => $carts['Shoppingcart']['clarity'], 'color' => $carts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));

                    $productgemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));

                    $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                    $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                    $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
                    $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                    
                    $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                    $productnames .= $sub_category['Subcategory']['subcategory'].',';
                    $msg.='<tr align="center" >
            <td valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000; " >' . $i . '</td>
            <td valign="top" style=" border-bottom:1px solid #000;border-right:1px solid #000; ">' . $cat['Category']['category_code'] . '' . $product['Product']['product_code'] . '-' . $carts['Shoppingcart']['purity'] . 'K' . $carts['Shoppingcart']['clarity'] . $carts['Shoppingcart']['color'] . '</td>
            <td  valign="middle" style=" border-bottom:1px solid #000;border-right:1px solid #000; " ><table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000;" width="80%">
                <tr >
                  <td style="border-bottom:1px solid #000;">' . $product['Product']['product_name'] . ',</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #000;">' . ($carts['Shoppingcart']['size'] != '' ? '<strong>Size -</strong> 12,<br />' : '') . '
                    <strong>Metals:</strong> ' . $carts['Shoppingcart']['purity'] . 'K ' . $carts['Shoppingcart']['metalcolor'] . ' Glod</td>
                </tr>
                <tr>
                  <td style="line-height:0.5;"><p><strong>Matels Wt:</strong> ' . $carts['Shoppingcart']['weight'] . ' gms</p>';
                    if ($carts['Shoppingcart']['stoneamount'] > 0) {
                        $msg.='<p><strong>Stone:</strong> Diamond</p>
                    <p><strong>Stone Wt:</strong> ' . $productdiamond[0]['sweight'] . ' carat</p>
                    <p><strong>Quality:</strong> ' . $carts['Shoppingcart']['clarity'] . '-' . $carts['Shoppingcart']['color'] . '</p>
                    <p><strong>Number of Stone:</strong> ' . $productdiamond[0]['no_diamond'] . '</p>';
                    }
                    if ($carts['Shoppingcart']['gemstoneamount'] > 0) {
                        foreach ($productgemstone as $productgemstone) {
                            $msg.='<p><strong>Stone:</strong> ' . $productgemstone['Productgemstone']['gemstone'] . '</p>
							<p><strong>Stone Wt:</strong>  ' . $productgemstone['Productgemstone']['stone_weight'] . ' carat</p>
							<p><strong>Number of Stone:</strong> ' . $productgemstone['Productgemstone']['no_of_stone'] . '</p>';
                        }
                    }
                    $msg.='</td>
                </tr>
              </table></td>
            <td style=" border-bottom:1px solid #000;border-right:1px solid #000; " valign="top">' . $carts['Shoppingcart']['quantity'] . '</td>
            <td style=" border-bottom:1px solid #000; " valign="top">' . ($carts['Shoppingcart']['quantity'] * $carts['Shoppingcart']['total']) . '</td>
          </tr>';
                    //update stock
                    $this->Product->updateAll(
                            array('Product.stock_quantity' => 'Product.stock_quantity - 1'), array('Product.product_id' => $carts['Shoppingcart']['product_id']));
                }$msg.='</table>';
            }
            $shipping_details = ' <p><strong>' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . '</strong></p>
			<p>' . str_replace('/n', '<br/>', $order1['Order']['shipping_add']) . '</p>
			<p>' . $order1['Order']['scity'] . '-' . $order1['Order']['spincode'] . '</p>
			<p>' . $order1['Order']['sstate'] . '</p>';
            $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order1['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
            $netamount = $cart_amount[0]['subtotal'];
            $paymentdetails = '<table border="1" cellpadding="5" align="center">
          <tr>
            <th>Sub Total Amount</th>
            <th>Rs. ' . $cart_amount[0]['subtotal'] . '</th>
          </tr>';
            if ($order1['Order']['discount_amount'] > 0) {
                $paymentdetails.='<tr>
            <th>Offer Discount Amount</th>
            <th>Rs. ' . $order1['Order']['discount_amount'] . '</th>
          </tr>';
                $netamount-=$order1['Order']['discount_amount'];
            }
            if ($order1['Order']['shipping_amt'] > 0) {
                $paymentdetails.=' <tr>
            <th>Shipping Charges :</th>
            <th>Rs. ' . $order1['Order']['shipping_amt'] . '</th>
          </tr>';
                $netamount+=$order1['Order']['shipping_amt'];
            }
            $paymentdetails.='<tr>
            <th>Total Amount</th>
            <th>Rs. ' . $netamount . '</th>
          </tr>';
            if ($order1['Order']['status'] == 'PartialPaid') {
                $paymentdetails.='<tr>
            <td>Amount Paid</td>
            <td>Rs. ' . $order1['Order']['cod_amount'] . '</td>
         	 </tr>';
                $balance = $netamount - $order1['Order']['cod_amount'];
                $paymentdetails.='<tr>
            <th>Balance Payable Amount :</th>
            <th>Rs. ' . $balance . '</th>
            </tr>';
            }

            $paymentdetails.='</table>';

            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 8)));
            $message = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $activateemail['Emailcontent']['content']);
            $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));

            //added by prakash
            $invoice = $this->requestAction(array('action' => 'orderpdf', $order1['Order']['order_id'], 'F'), array('return', 'bare' => false));
            $file = 'files/invoices/' . str_replace('/', '_', $in . $order1['Order']['invoice'] . '.pdf');
            $subject = $activateemail['Emailcontent']['subject'] . ' ' . $in . $order1['Order']['invoice'];
            $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $user['User']['email'], $subject, $message, '', 1, $file, 'acknowledgment', '');
            //send sms
//            $sms_message = "Dear {$user['User']['first_name']}, Thank You for placing your order with Shagunn. Your Order #{$in}{$order1['Order']['invoice']} has been confirmed and is being processed.";
            $productnames = rtrim($productnames,',');
            $sms_message = $this->get_sms_message(1);
            $sms_message = str_replace(array('{PRODUCT_NAME}'), array($productnames), $sms_message);
            $this->sendsms($user['User']['phone_no'], $sms_message);

            $email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
            $amountedit = $this->Paymentdetails->find('first', array('conditions' => array('paymentdetails_id' => $last_id)));

            $messagen = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $email['Emailcontent']['content']);
            $this->mailsend(SITE_NAME, $user['User']['email'], $adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen, '', 1, $file, 'acknowledgment', '');
        }
        if ($order1['Order']['cod_status'] == 'PayU') {
            $msg = '';
            if (!empty($cart)) {
                $msg = '<table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000; border-bottom:none;" width="100%">
						  <tr>
							<th width="10" height="27" style="border-bottom:1px solid #000;border-right:1px solid #000; " >S.No</th>
							<th style=" border-bottom:1px solid #000;border-right:1px solid #000; " >Product Code</th>
							<th style="border-bottom:1px solid #000;border-right:1px solid #000; " >Product Description</th>
							<th width="10" style="border-bottom:1px solid #000;border-right:1px solid #000; "  >Quantity</th>
							<th style=" border-bottom:1px solid #000;" >Price</th>
						  </tr>';
                $i = 1;
                $productnames = '';
                foreach ($cart as $carts) {
                    $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                    $productdiamond = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'], 'clarity' => $carts['Shoppingcart']['clarity'], 'color' => $carts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));

                    $productgemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));

                    $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                    $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                    $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
                    $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                    
                    $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                    $productnames .= $sub_category['Subcategory']['subcategory'].',';
                    $msg.='<tr align="center" >
            <td valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000; " >' . $i . '</td>
            <td valign="top" style=" border-bottom:1px solid #000;border-right:1px solid #000; ">' . $cat['Category']['category_code'] . '' . $product['Product']['product_code'] . '-' . $carts['Shoppingcart']['purity'] . 'K' . $carts['Shoppingcart']['clarity'] . $carts['Shoppingcart']['color'] . '</td>
            <td  valign="middle" style=" border-bottom:1px solid #000;border-right:1px solid #000; " ><table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000;" width="80%">
                <tr >
                  <td style="border-bottom:1px solid #000;">' . $product['Product']['product_name'] . ',</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #000;">' . ($carts['Shoppingcart']['size'] != '' ? '<strong>Size -</strong> 12,<br />' : '') . '
                    <strong>Metals:</strong> ' . $carts['Shoppingcart']['purity'] . 'K ' . $carts['Shoppingcart']['metalcolor'] . ' Glod</td>
                </tr>
                <tr>
                  <td style="line-height:0.5;"><p><strong>Matels Wt:</strong> ' . $carts['Shoppingcart']['weight'] . ' gms</p>';
                    if ($carts['Shoppingcart']['stoneamount'] > 0) {
                        $msg.='<p><strong>Stone:</strong> Diamond</p>
                    <p><strong>Stone Wt:</strong> ' . $productdiamond[0]['sweight'] . ' carat</p>
                    <p><strong>Quality:</strong> ' . $carts['Shoppingcart']['clarity'] . '-' . $carts['Shoppingcart']['color'] . '</p>
                    <p><strong>Number of Stone:</strong> ' . $productdiamond[0]['no_diamond'] . '</p>';
                    }
                    if ($carts['Shoppingcart']['gemstoneamount'] > 0) {
                        foreach ($productgemstone as $productgemstone) {
                            $msg.='<p><strong>Stone:</strong> ' . $productgemstone['Productgemstone']['gemstone'] . '</p>
							<p><strong>Stone Wt:</strong>  ' . $productgemstone['Productgemstone']['stone_weight'] . ' carat</p>
							<p><strong>Number of Stone:</strong> ' . $productgemstone['Productgemstone']['no_of_stone'] . '</p>';
                        }
                    }
                    $msg.='</td>
                </tr>
              </table></td>
            <td style=" border-bottom:1px solid #000;border-right:1px solid #000; " valign="top">' . $carts['Shoppingcart']['quantity'] . '</td>
            <td style=" border-bottom:1px solid #000; " valign="top">' . ($carts['Shoppingcart']['quantity'] * $carts['Shoppingcart']['total']) . '</td>
          </tr>';

                    //update stock
                    $this->Product->updateAll(
                            array('Product.stock_quantity' => 'Product.stock_quantity - 1'), array('Product.product_id' => $carts['Shoppingcart']['product_id']));
                }$msg.='</table>';
            }
            $shipping_details = ' <p><strong>' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . '</strong></p>
			<p>' . str_replace('/n', '<br/>', $order1['Order']['shipping_add']) . '</p>
			<p>' . $order1['Order']['scity'] . '-' . $order1['Order']['spincode'] . '</p>
			<p>' . $order1['Order']['sstate'] . '</p>';
            $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order1['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
            $netamount = $cart_amount[0]['subtotal'];
            $paymentdetails = '<table border="1" cellpadding="5" align="center">
          <tr>
            <th>Sub Total Amount</th>
            <th>Rs. ' . $cart_amount[0]['subtotal'] . '</th>
          </tr>';
            if ($order1['Order']['discount_amount'] > 0) {
                $paymentdetails.='<tr>
            <th>Offer Discount Amount</th>
            <th>Rs. ' . $order1['Order']['discount_amount'] . '</th>
          </tr>';
                $netamount-=$order1['Order']['discount_amount'];
            }
            if ($order1['Order']['shipping_amt'] > 0) {
                $paymentdetails.=' <tr>
            <th>Shipping Charges :</th>
            <th>Rs. ' . $order1['Order']['shipping_amt'] . '</th>
          </tr>';
                $netamount+=$order1['Order']['shipping_amt'];
            }
            $paymentdetails.='<tr>
            <th>Total Amount</th>
            <th>Rs. ' . $netamount . '</th>
          </tr>';
            if ($order1['Order']['status'] == 'PartialPaid') {
                $paymentdetails.='<tr>
            <td>Amount Paid</td>
            <td>Rs. ' . $order1['Order']['cod_amount'] . '</td>
         	 </tr>';
                $balance = $netamount - $order1['Order']['cod_amount'];
                $paymentdetails.='<tr>
            <th>Balance Payable Amount :</th>
            <th>Rs. ' . $balance . '</th>
            </tr>';
            }

            $paymentdetails.='</table>';

            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 10)));
            $message = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $activateemail['Emailcontent']['content']);
            $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));

            //added by prakash
            $invoice = $this->requestAction(array('action' => 'orderpdf', $order1['Order']['order_id'], 'F'), array('return', 'bare' => false));
            $file = 'files/invoices/' . str_replace('/', '_', $in . $order1['Order']['invoice'] . '.pdf');
            $subject = $activateemail['Emailcontent']['subject'] . ' ' . $in . $order1['Order']['invoice'];
           // $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $user['User']['email'], $subject, $message, '', 1, $file, 'acknowledgment', '');
            //send sms
//            $sms_message = "Dear {$user['User']['first_name']}, Thank You for placing your order with Shagunn. Your Order #{$in}{$order1['Order']['invoice']} has been confirmed and is being processed.";
            $productnames = rtrim($productnames,',');
            $sms_message = $this->get_sms_message(1);
            $sms_message = str_replace(array('{PRODUCT_NAME}'), array($productnames), $sms_message);
            $this->sendsms($user['User']['phone_no'], $sms_message);

            $email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
            $amountedit = $this->Paymentdetails->find('first', array('conditions' => array('paymentdetails_id' => $last_id)));

            $messagen = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $email['Emailcontent']['content']);

            //$this->mailsend(SITE_NAME, $user['User']['email'], $adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen, '', '', '', 'acknowledgment', '');
        }




        /* 	$order=$this->Order->find('first',array('conditions'=>array('order_id'=>$this->Session->read('Order'))));
          $user=$this->User->find('first',array('conditions'=>array('user_id'=>$this->Session->read('User.user_id'))));
          $name=$user['User']['first_name'];
          $aemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 9)));
          $amountedit=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$last_id)));
          $messagen = str_replace(array('{name}','{order}','{amount}'), array($name,'SGN-ON'.$order['Order']['invoice'],$amountedit['Paymentdetails']['amount']), $aemail['Emailcontent']['content']);
          $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
          $this->mailsend(SITE_NAME, $user['User']['email'],$adminmailid['Adminuser']['email'], $aemail['Emailcontent']['subject'], $messagen); */

        $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));

        $this->Session->delete('Order');
        $this->Session->delete('cart_process');
        $this->User->read(NULL, $user['User']['user_id']);
        $this->User->saveField('cart_session', '');

        $this->Session->setFlash("<div class='success msg'>" . __('Payment process successfully completed. We will deliver your order soon .') . "</div>");
        $this->redirect(array('controller' => 'orders', 'action' => 'my_order'));
    }

    public function payment_failure() {

        $this->request->data['Paymentdetails']['order_id'] = $this->Session->read('Order');
        $this->request->data['Paymentdetails']['user_id'] = $this->Session->read('User.user_id');
        $this->request->data['Paymentdetails']['txnid'] = $_POST['mihpayid'];
        $this->request->data['Paymentdetails']['amount'] = $_POST['net_amount_debit'];
        $this->request->data['Paymentdetails']['pg_type'] = $_POST['PG_TYPE'];
        $this->request->data['Paymentdetails']['bank_ref_num'] = $_POST['bank_ref_num'];
        $this->request->data['Paymentdetails']['bankcode'] = $_POST['bankcode'];
        $this->request->data['Paymentdetails']['status'] = 'Failed';
        $this->request->data['Paymentdetails']['admin_status'] = 'Order in Pending';
        $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
        $this->Paymentdetails->save($this->request->data);
        $orderfailed = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
        $usertypest = $user['User']['user_type'];
        if ($usertypest == '1') {
            $orderstatus = 'BookedbyFranchisee';
        } elseif ($usertypest == '0') {
            $orderstatus = 'BookedbyUser';
        }
        if (!empty($orderfailed)) {
            $this->request->data['Order']['order_id'] = $orderfailed['Order']['order_id'];
            $this->request->data['Order']['order_status'] = 'Failed';
            $this->request->data['Order']['status'] = 'Failed';
            $this->Order->save($this->request->data);
        }

        $order1 = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));



        $name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
        $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $this->Session->read('Order'))));
        $msg = '<table cellpadding="0" cellspacing="0" id="example"  width="100%" border="1"><thead><tr><th>Product Name</th><th>Product Code</th><th>Type</th><th>Paid Amount</th></tr>';
        if (!empty($cart)) {

            foreach ($cart as $carts) {
                $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
                $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));

                $type = $orders['Order']['cod_status'];
                if ($type == 'PayU') {
                    $type_view = 'Full Payment';
                } elseif ($type == 'COD') {
                    $type_view = 'Partial Payment';
                } elseif ($type == 'CHQ/DD') {
                    $type_view = 'CHQ/DD';
                }

                /* $msg.='<td align="left"><span><b>Product Name:</b></span>'.$product['Product']['product_name'].'</td>
                  <td align="left"><span><b>Product Code:</b></span>'.$cat['Category']['category_code'].''.$product['Product']['product_code'].'</td>
                  <td align="left"><span><b>Type:</b></span>'.$orders['Order']['cod_status'].'</td>
                  <td align="left"><span><b>Total Amount:</b></span><span>Rs.</span>'.$carts['Shoppingcart']['total'].'</td>'; */
                $msg.='<tr><td align="left">' . $product['Product']['product_name'] . '</td><td align="left">' . $cat['Category']['category_code'] . '' . $product['Product']['product_code'] . '-' . $carts['Shoppingcart']['purity'] . 'K' . $carts['Shoppingcart']['clarity'] . $carts['Shoppingcart']['color'] . '</td><td align="left">' . $orders['Order']['cod_status'] . '</td><td  align="left">' . 'Rs' . $carts['Shoppingcart']['total'] . '</td></tr>';
            }
            $msg.='</thead></table>';
            
            $this->requestAction(array('controller' => 'webpages', 'action' => 'cart_reminder', $user['User']['user_id'], $this->Session->read('Order'), 19));
        }
        $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 13)));
        $message = str_replace(array('{name}', '{details}'), array($name, $msg), $activateemail['Emailcontent']['content']);
        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
//        $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);

        $email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 14)));
        $messagen = str_replace(array('{name}', '{details}'), array($name, $msg), $email['Emailcontent']['content']);
        $this->mailsend(SITE_NAME, $user['User']['email'], $adminmailid['Adminuser']['email'], $email['Emailcontent']['subject'], $messagen);
        $this->Session->setFlash("<div class='error msg'>" . __('Payment process not completed. Please try again.') . "</div>");
        $this->redirect(array('controller' => 'orders', 'action' => 'order'));
    }

    public function coupon() {
        $this->layout = '';
        $this->render(false);
        $date = date('Y-m-d');
        $discount = $this->Discount->find('first', array('conditions' => array('type' => 'Vouchercode', 'voucher_code' => $_REQUEST['value'], 'status' => 'Active', '"' . $date . '" BETWEEN Discount.start_date AND  Discount.expired_date')));
        if (!empty($discount)) {
            $this->request->data['Discount']['discount_id'] = $discount['Discount']['discount_id'];
            $this->request->data['Discount']['status'] = 'Apply';
            $this->Discount->save($this->request->data);
            $val = 'Applied';
            $status = 20;
            $discount = round(($discount['Discount']['percentage'] * $_REQUEST['amount']) / 100);
            $net = $_REQUEST['amount'] - $discount;
        } else {
            $val = 'Invalid Coupon';
            $status = 30;
            $net = '';
            $discount = '';
        }
        $jsonarray = array('val' => $val, 'check' => $status, 'discount' => $discount, 'net' => $net);
        echo json_encode($jsonarray);
    }

    public function partialpayment_amt() {
        $this->layout = '';
        $this->render(false);
        $per = $_REQUEST['percentage'];
        $amt = $_REQUEST['amount'];
        $partial_amt = round($amt * $per / 100);
        $partial_amt_res = 'Rs. ' . $partial_amt;
        echo json_encode($partial_amt_res);
    }

    public function my_order() {
        $this->usercheck();

        //$pay = $this->Paymentdetails->find('all', array('conditions' => array('user_id' => $this->Session->read('User.user_id')), 'order' => 'paymentdetails_id DESC'));
        //$this->set('pay', $pay);
        $order = $this->Order->find('all', array('recursive' => 2, 'conditions' => array('user_id' => $this->Session->read('User.user_id')), 'order' => 'order_id DESC'));
        $this->set('order', $order);
    }

    public function admin_index() {
        $this->layout = "admin";
        $this->checkadmin();
        $this->Paymentdetails->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }

            if ($this->request->data['searchinvoice'] != '') {
                $search[] = 'searchinvoice=' . $this->request->data['searchinvoice'];
            }
            if ($this->request->data['type'] != '') {
                $search[] = 'type=' . $this->request->data['type'];
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
                $search = array('Order.created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\'');
            } elseif ($this->request->query('cdate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            } elseif ($this->request->query('edate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            }

            if ($this->request->query('searchinvoice') != '') {

                $code = explode('-', $this->request->query['searchinvoice']);
                $order = $this->Order->find('first', array('conditions' => array('invoice' => $code[2])));
                $search['order_id'] = $order['Order']['order_id'];
            }
            if ($this->request->query('type') != '') {
                if ($this->request->query('type') == 0) {
                    $user = $this->User->find('first', array('conditions' => array('user_type' => $this->request->query['type'])));
                    $search['user_id'] = $user['User']['user_id'];
                }
            }
            if ($this->request->query('type') != '') {
                if ($this->request->query('type') == 1) {
                    $user = $this->User->find('first', array('conditions' => array('user_type' => $this->request->query['type'])));
                    $search['user_id'] = $user['User']['user_id'];
                }
            }
            $this->paginate = array('conditions' => $search, 'order' => 'Paymentdetails.paymentdetails_id DESC');
            $this->set('paymentdetail', $this->paginate('Paymentdetails'));
        } else {
            $this->paginate = array('conditions' => '', 'order' => 'paymentdetails_id DESC');
            $this->set('paymentdetail', $this->Paginator->paginate('Paymentdetails'));
        }
    }

	public function admin_order_index() {

		//echo "<pre>";
		//print_r($_SESSION);
		//exit;
		
		$this->layout = "admin";
		$this->checkadmin();
		$this->Order->recursive = 2;

		if (isset($this->request->data['searchfilter'])) {
			
			$search = array();
			if ($this->request->data['cdate'] != '') {
				$search[] = 'cdate=' . $this->request->data['cdate'];
			}
			
			if ($this->request->data['edate'] != '') {
				$search[] = 'edate=' . $this->request->data['edate'];
			}
			
			if ($this->request->data['searchinvoice'] != '') {
				$code = explode('-', $this->request->query['searchinvoice']); 
				$search[] = 'searchinvoice=' . $code[2];
			}

			if ($this->request->data['type'] != '') { 
				$search[] = 'type=' . $this->request->data['type'];
			}
		
			if (!empty($search)) {

				$this->redirect(array('action' => 'admin_order_index?search=1&' . implode('&', $search)));
			} else {

				$this->redirect(array('action' => 'admin_order_index'));
			}

		}

		if ($this->request->query('search') != '') {
			$search = array();
			$cdate=$this->request->query('cdate');
			$edate=$this->request->query('edate');
			/*if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
			$search['created_date >='] = $this->request->query('cdate');
			$search['created_date <='] = $this->request->query('edate');
			//$search = array('\'created_date\' >= \'' . $this->request->query('cdate') . '\' AND  \'created_date\' <= \'' . $this->request->query('edate') . '\'');
			} elseif ($this->request->query('cdate') != '') {
			$search['created_date >='] = $this->request->query('cdate');
			} elseif ($this->request->query('edate') != '') {
			$search['created_date <='] = $this->request->query('edate');
			}
			*/

			if($cdate==''){
				$search['created_date >='] = $cdate;
			}else if($edate==''){
				$search['created_date <='] = $edate;
			}else{
				$search = array('Order.created_date BETWEEN \'' . $cdate." 00:00:00" . '\' AND \'' . $edate . ' 23:59:59\'');
			}

			if ($this->request->query('searchinvoice') != '') {
				$code = $this->request->query['searchinvoice'];
				$order = $this->Order->find('first', array('conditions' => array('invoice' => $code)));
				$search['order_id'] = $order['Order']['order_id'];
			}
			
			$user_idd = array();
			if(isset($this->request->query['type'])){

				if ($this->request->query['type'] != -1) {
					if ($this->request->query['type'] == 0) {
						$user = $this->User->find('all', array('conditions' => array('user_type' => $this->request->query['type'])));
						$i=0;

						foreach($user as $use){

							$user_idd[$i] = $use['User']['user_id'];
							$i++;

						}

					$search['user_id'] = $user_idd;
					}
				}
			}
			
			if ($this->request->query('type') != -1) {

				if ($this->request->query('type') == 1) {
					$user = $this->User->find('all', array('conditions' => array('user_type' => $this->request->query['type'])));
					$i=0;
					foreach($user as $use){
						$user_idd[$i] = $use['User']['user_id'];
						$i++;
					}
					$search['user_id'] = $user_idd;

				}
			}

			/* echo "<pre>";
			   print_r($user);
				print_r($search);
			 echo "</pre>"; 
			*/
			
			
			
			//$this->paginate = array('conditions' => $search, 'order' => 'Order.order_id DESC');
			
			if($_SESSION['User']['login_type'] == 'Vendor'){
				
				$search['vendor_id'] = $_SESSION['Adminuser']['vendor_id'];
				
				$this->paginate = array('conditions' => $search,
								
								'joins'=> array(
									array(
										'alias' => 'Shoppingcarts',
										'table' => 'shoppingcarts',
										'type' => 'LEFT',
										'conditions' => 'Shoppingcarts.order_id = Order.order_id'
									),array(
										'alias' => 'Products',
										'table' => 'products',
										'type' => 'LEFT',
										'conditions' => 'Shoppingcarts.product_id = Products.product_id'
									)
								),
								
								'order' => array('Order.order_id' => 'DESC'),
								'group' => 'Order.order_id'
								
							);
				
				//$this->paginate = array('conditions' => $search, 'order' => 'Order.order_id DESC');
				
				
			}else{
				$this->paginate = array('conditions' => $search, 'order' => 'Order.order_id DESC');
			}
			
			$this->set('orderdetails', $this->paginate('Order'));

		} else {
			
			
			//$this->paginate = array('conditions' => '', 'order' => 'order_id DESC');
			
			
			if($_SESSION['User']['login_type'] == 'Vendor'){
				
				//print_r($_SESSION['User']);
				//echo "in if";
				//exit;
			
				$this->paginate = array('conditions' => 'Products.vendor_id='.$_SESSION['Adminuser']['vendor_id'].' ',
								
								'joins'=> array(
									array(
										'alias' => 'Shoppingcarts',
										'table' => 'shoppingcarts',
										'type' => 'LEFT',
										'conditions' => 'Shoppingcarts.order_id = Order.order_id'
									),array(
										'alias' => 'Products',
										'table' => 'products',
										'type' => 'LEFT',
										'conditions' => 'Shoppingcarts.product_id = Products.product_id'
									)
								),
								
								'order' => array('Order.order_id' => 'DESC'),
								'group' => 'Order.order_id'
								
							);
				
			}else{
				//echo "in else";
				//exit;
				
				$this->paginate = array('conditions' => '', 'order' => 'Order.order_id DESC');
			}
			
			$this->set('orderdetails', $this->Paginator->paginate('Order'));

		}
}   
 
	
	public function admin_order_export($cdate=null,$edate=null,$type=null,$invoice=null) {
		
		//echo "<pre>";
		//print_r($this->Session);
		//exit;
		//print_r($this->Session->read('Adminuser.vendor_id'));
		//exit;
		
		$this->layout = '';
		$this->render(false);
		$row_cnt =array();
		$header_row1 =array();
		$row_pdt =array();
		
		ini_set('max_execution_time', 6000);
		$filename = "order_details.csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		$search = array();
		
		/*echo "<pre>";
		print_r($_SESSION['User']);
		echo "</pre>"; 
		exit;*/

		if($cdate == 0 && $edate == 0){

			$search = array();
		}else if($cdate==''){
			$search['created_date <='] = $edate;
		}else if($edate==''){
			$search['created_date >='] = $cdate;
		}else{

			$search = array('Order.created_date BETWEEN \'' . $cdate . '\' AND \'' . $edate . '\'');
		}
		
		$user_idd = array();
		$invoice = $this->request->params['pass'][3];
		
		if ($invoice != '0') {
			$order = $this->Order->find('first', array('conditions' => array('invoice' => $invoice)));
			$search['order_id'] = $order['Order']['order_id'];
		}

		if ($type == 0) {
			$user = $this->User->find('all', array('conditions' => array('user_type' => $type)));
			$i=0;
			foreach($user as $use){
				$user_idd[$i] = $use['User']['user_id'];
				$i++;
			}
			$search['user_id'] = $user_idd;
		}

		if ($type == 1) {
			$user = $this->User->find('all', array('conditions' => array('user_type' => $type)));
			$i=0;
			foreach($user as $use){
				$user_idd[$i] = $use['User']['user_id'];
				$i++;
			}
			$search['user_id'] = $user_idd;
		}
		
		/*  echo "<pre>";
		// print_r($search);
		echo "</pre>"; */
		
		//$this->Session->read('User.login_type')
		
		if($this->Session->read('User.login_type') == 'Vendor'){
		
			//echo "in if";
			//exit;
		
			$search['vendor_id'] = $this->Session->read('Adminuser.vendor_id');
			
			$options = array();
			
			$options['conditions'] = $search;
			
			$options['joins'] = array(
										array(
												'alias' => 'Shoppingcarts',
												'table' => 'shoppingcarts',
												'type' => 'LEFT',
												'conditions' => 'Shoppingcarts.order_id = Order.order_id'
											),array(
												'alias' => 'Products',
												'table' => 'products',
												'type' => 'LEFT',
												'conditions' => 'Shoppingcarts.product_id = Products.product_id'
											)
									);
									
			$options['fields'] = array('Order.*','Shoppingcarts.*','Products.*');
			
			$options['order'] = array('Order.order_id' => 'DESC');
			
			$options['group'] = "Order.order_id";
									   
									   
			
			$results = $this->Order->find('all', $options);
		
		}else{
		
			//echo "in else";
			//exit;
			
			$results = $this->Order->find('all',array('conditions' => $search));
		}
			
		//$results = $this->Order->find('all',array('conditions' => $search));

		
		
		$header_row = array("S.No", "User Name", "User Type",
							"Franchisee Code","First Name","Last Name","Date of Birth","Email","Phone Number", 
							"Order No", "Mode Type", "Order Status", "Payment Status", "Way Bill No","Sub Total","Total Amount","Amount Paid","Billing Address","Shipping Address", "Created Date",
							"Cheque/DD No","Bank Name","Bank Branch","Amount"); 

					$i = 1;
	
		foreach ($results as $results) {
			$user = $this->User->find('first', array('conditions' => array('user_id' => $results['Order']['user_id'])));/* 
			$shipping_add = $this->Shipping->find('first', array('conditions' => array('user_id' => $results['Order']['user_id']))); */
			/*  echo "<pre>";

			print_r($results);
			echo "</pre>"; */
			$shipping_add = $results['Order']['shipping_add'].', '.$results['Order']['slandmark'].', '.$results['Order']['sstate'].', '.$results['Order']['scity'].', '.$results['Order']['spincode'];
			$billing_add = $results['Order']['billing_add'].', '.$results['Order']['blandmark'].', '.$results['Order']['state'].', '.$results['Order']['city'].', '.$results['Order']['pincode'];
			$paymentdetails = $this->Paymentdetails->find('first', array('conditions' => array('order_id' => $results['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));


			$cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $results['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
			
			$paymentdetail = $this->Paymentdetails->find('first', array('conditions' => array('order_id' => $results['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));


			$netamount = $cart_amount[0]['subtotal'];
			$total_amount =$netamount+$results['Order']['shipping_amt'];


			if (($results['Order']['cod_status'] == 'PayU') && ($results['Orderstatus']['order_status'] != 'Pending')) {
				
				$paid = isset($paymentdetail['Paymentdetails']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
				
			} elseif (($results['Order']['cod_status'] == 'COD') && ($results['Orderstatus']['order_status'] != 'Pending')) {
				
				$paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
				$balance = $netamount - $results['Order']['cod_amount'];
				
			} elseif (($results['Order']['cod_status'] == 'CHQ/DD') && ($results['Orderstatus']['order_status'] != 'Pending')) {

				$paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
				
			}
			
			if(empty($paymentaldetails['Paymentdetails']['chq/dd'])){
				$ddno='-';
			}
			else{
				$ddno=$paymentaldetails['Paymentdetails']['chq/dd'];
			}
			
			if(empty($paymentaldetails['Paymentdetails']['bankname'])){
				$ddbank='-';
			}else{
				$ddbank=$paymentaldetails['Paymentdetails']['bankname'];
			}

			if(empty($paymentaldetails['Paymentdetails']['bankbranch'])){
				$ddbankbr='-';
			}else{
				$ddbankbr=$paymentaldetails['Paymentdetails']['bankbranch'];
			}

			if(empty($paymentaldetails['Paymentdetails']['amount'])){
				$ddamt='-';
			}else{
				$ddamt=$paymentaldetails['Paymentdetails']['amount'];
			}


			if ($user['User']['user_type'] == '0') {

				$usr_type = 'User';

				if ($results['Order']['cod_status'] == 'PayU') {
					$in = 'SGN-ON-';
					$paymentmode = 'Full Payment';

				} elseif ($results['Order']['cod_status'] == 'CHQ/DD') {
					$in = 'SGN-CHQ/DD-';
					$paymentmode = 'CHQ/DD';

				} elseif ($results['Order']['cod_status'] == 'COD') {
					$in = 'SGN-CD-';
					$paymentmode = 'Partial Payment';

				}

			} else {

				$usr_type = 'Franchisee';

				if ($results['Order']['cod_status'] == 'PayU') {
					$in = 'SGN-FN-';
					$paymentmode = 'Full Payment';

				} elseif ($results['Order']['cod_status'] == 'COD') {
					$in = 'SGN-FNCD-';
					$paymentmode = 'Partial Payment ';
				} elseif ($results['Order']['cod_status'] == 'CHQ/DD') {
					$in = 'SGN-FNCHQ/DD-';
					$paymentmode = 'CHQ/DD';

				}

			}
	
			$order_sts = $this->Orderstatus->find('first', array('conditions' => array('Orderstatus.order_sts_id' => $results['Order']['order_status_id'])));
			
			$ordercart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $results['Order']['order_id'])));
			$code=h($user['User']['franchisee_code']); 

			if(!empty($code))  $code=$code; else $code='-';
				$dobf=$user['User']['date_of_birth'];
				$dob=!empty($dobf)?date("Y-m-d",strtotime($dobf)):"-";

			$row = array($i,$user['User']['first_name'].' '.$user['User']['last_name'],$usr_type,
					$code,$user['User']['first_name'],$user['User']['last_name'],$dob, $user['User']['email'],$user['User']['phone_no'],
					$in . $results['Order']['invoice'],$paymentmode,$order_sts['Orderstatus']['order_status'],$results['Order']['status'],$results['Order']['way_bill_no'],$netamount,$total_amount,$paid,$billing_add,$shipping_add,$results['Order']['created_date'],$ddno,$ddbank,$ddbankbr,$ddamt,
				); 

			$row_count = count($row);

			/* echo "SI".$i."<br />";
			echo "count:".count($ordercart)."<br />"; */
			$row_cnt[$i] = count($ordercart);
			/* echo "<pre>";

			print_r($row_cnt);echo "</pre>"; */
   
			$product_type = array(
				'1' => 'Plain Gold',
				'2' => 'Diamond',
				'3' => 'Gemstone'
			);
			
			$collection_type = $this->Collectiontype->find('list', array('fields' => array('collectiontype_id', 'collection_name'), 'conditions' => '', 'order' => 'collectiontype_id ASC'));
			
			$product_view_type = array(
				'1' => 'New',
				'2' => 'Sale',
			);
	
			foreach ($ordercart as $ordercarts) {
				
				$productdetails = $this->Product->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));
				
				if(!empty($productdetails)){

					$product = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $ordercarts['Shoppingcart']['clarity'], 'color' => $ordercarts['Shoppingcart']['color'], 'product_id' => $productdetails['Product']['product_id'])));
					
					//$product = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id']), array(/* 'limit' => '1' */)));
   
					$productgem = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id'])));
    
					$productmetal = $this->Productmetal->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id'], 'type' => 'Size')));
  
					$productsize = $this->Productmetal->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id'], 'type' => 'Purity')));
  

					$category = $this->Category->find('first', array('conditions' => array('category_id' => $productdetails['Product']['category_id'])));

					$vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $productdetails['Product']['vendor_id'])));

					$stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $ordercarts['Shoppingcart']['clarity'], 'color' => $ordercarts['Shoppingcart']['color'], 'product_id' => $productdetails['Product']['product_id'])));

					/*
					$header_row = array("S.No", "Product Nmae", "Product Code", "Link", "Category", "Sub Category", "Vendor", "vendor product code",
								"Metal", "Metal Color", "Product weight", "Stone", "Special Work", "Gemstone", "Special Work Description",
								"Special work charge", "Vendor Making Charges Calculation", "vendor_making_charge", "vat_cst", "vendor_delivery_tat", "product_delivery_tat", "status",

								"Diamond", "Stone Clarity & Color", "Stone Carat", "no_of_diamonds", "stone_shape", "stone weight",
								"setting_type", "Gemstone ", "size ", "Shape ", "Stone weight ", "no of Stone ", "Setting type ", "Size ", "Purity",
								"Product Type", "Collection Type", "Product View type", "Best Seller", "Making Charges Calculation", "Making Charge", "Height", "Width", "Stock");
					*/

					if($i <= count($ordercart)){

						$header_row1[] ='Product Name'; 
						$header_row1[] ='Product Code'; 
						$header_row1[] ='Product Metal'; 
						$header_row1[] ='Product Metal Color';
						$header_row1[] ='Product Purity'; 
						$header_row1[] ='Product Size'; 
						$header_row1[] ='Product Weight'; 
						$header_row1[] ='Product Gold Amount'; 
						
						/*Abdul Worked*/

						$header_row1[] ='Diamond'; 
						$header_row1[] ='Stone Clarity and Color'; 
						$header_row1[] ='Stone Carat';
						$header_row1[] ='No Of Diamonds';
						$header_row1[] ='Stone Shape';
						$header_row1[] ='Stone Weight';
						$header_row1[] ='Setting Type';
						$header_row1[] ='Gemstone';
						$header_row1[] ='Size';
						$header_row1[] ='Shape';
						$header_row1[] ='Stone weight';
						$header_row1[] ='No of Stone';
						$header_row1[] ='Setting Type';
						$header_row1[] ='Size';
						$header_row1[] ='Purity';
						$header_row1[] ='Product Type'; 
						$header_row1[] ='Collection Type'; 
						$header_row1[] ='Product View Type';
						/*18th*/
						/*PRICE DETAILS*/
						$header_row1[] ='Metal Rate'; 
						$header_row1[] ='Metal Value';
						$header_row1[] ='Diamond Rate'; 
						$header_row1[] ='Diamond Value';
						$header_row1[] ='Making Charge (%)'; 
						$header_row1[] ='Making Charge Value';
						$header_row1[] ='Vat (%)'; 
						$header_row1[] ='Vat Value';
						$header_row1[] ='Total Amount'; 

						/*PRICE DETAILS END*/

						/*Heading abdul end*/
						$header_row1[] ='Vendor Code'; 
						$header_row1[] ='Vendor Company'; 
						$header_row1[] ='Vendor Phone'; 
						$header_row1[] ='Vendor Mobile'; 
						$header_row1[] ='Vendor Email'; 

					}

					$product_name = $productdetails['Product']['product_name'];

					$product_code = $category['Category']['category_code'] . ' ' . $productdetails['Product']['product_code'] . "-" . $ordercarts['Shoppingcart']['purity'] . "K" . $ordercarts['Shoppingcart']['clarity'] . $ordercarts['Shoppingcart']['color'];

					$product_metal = $ordercarts['Shoppingcart']['metal'];

					$product_metalcolor = $ordercarts['Shoppingcart']['metalcolor'];

					$product_purity = $ordercarts['Shoppingcart']['purity'];

					$product_size = $ordercarts['Shoppingcart']['size'];

					$product_weight = $ordercarts['Shoppingcart']['weight'] . ' gm';

					$product_metal_value = $ordercarts['Shoppingcart']['goldamount'];

					if(!empty($ordercarts['Shoppingcart']['stoneamount'])) {

						$product_stone_amount = $ordercarts['Shoppingcart']['stoneamount'];

					}else{

						$product_stone_amount = '0';

					}

					if(!empty($ordercarts['Shoppingcart']['gemstoneamount'])) {
						$product_stone_amount = $ordercarts['Shoppingcart']['gemstoneamount'];

					}else{

						$product_stone_amount = '0';

					}



					$product_making_charge = $ordercarts['Shoppingcart']['making_charge'];

					$product_making_per = $ordercarts['Shoppingcart']['making_per'];

					$product_vat = $ordercarts['Shoppingcart']['vat'];

					$product_vat_per = $ordercarts['Shoppingcart']['vat_per'];

					$product_total = $ordercarts['Shoppingcart']['total'];

					if (!empty($stone_details)) {
						foreach ($stone_details as $stone_detail) {
						}

					}

					$row[] = $product_name;
					$row[] = $product_code;
					$row[] = $product_metal;
					$row[] = $product_metalcolor;
					$row[] = $product_purity;
					$row[] = $product_size;
					$row[] = $product_weight;
					$row[] = $product_metal_value;

					/*18 col valu have to push Start*/
					/*PRODUCT DIAMOND*/
					$p_stone = $p_clr = $p_col = $p_car = $p_no_dia = $p_shp = $p_st_wgh = $p_set = '-';
					if(count( $product )>0){
						$p_stone = $p_clr = $p_col = $p_car = $p_no_dia = $p_shp = $p_st_wgh = $p_set = "";//count( $product ).'-';
						foreach ( $product as $key => $p_diamond) {
							$p_stone_name = $p_diamond['Productdiamond']['diamond'];
							$p_clr_name = $p_diamond['Productdiamond']['clarity'];
							$p_col_name = $p_diamond['Productdiamond']['color'];
							$p_car_name = $p_diamond['Productdiamond']['carat'];
							$p_no_dia_name = $p_diamond['Productdiamond']['noofdiamonds'];
							$p_shp_name = $p_diamond['Productdiamond']['shape'];
							$p_st_wgh_name = $p_diamond['Productdiamond']['stone_weight'];
							$p_set_name = $p_diamond['Productdiamond']['settingtype'];

							if ($p_stone_name != '') {
								$p_stone .= $key == 0 ? $p_stone_name : ', ' . $p_stone_name;
							}
							if ($p_clr_name != '' || $p_col_name != '') {
								$p_clr .= $key == 0 ? "$p_clr_name-$p_col_name" : ', ' . "$p_clr_name-$p_col_name";
							}
							if ($p_col_name != '') {
								$p_col .= $key == 0 ? $p_col_name : ', ' . $p_col_name;
							}
							if ($p_car_name != '') {
								$p_car .= $key == 0 ? $p_car_name : ', ' . $p_car_name;
							}
							if ($p_shp_name != '') {
								$p_shp .= $key == 0 ? $p_shp_name : ', ' . $p_shp_name;
							}
							if ($p_st_wgh_name != '') {
								$p_st_wgh .= $key == 0 ? $p_st_wgh_name : ', ' . $p_st_wgh_name;
							}
							if ($p_set_name != '') {
								$p_set .= $key == 0 ? $p_set_name : ', ' . $p_set_name;
							}
							if($p_no_dia_name!=''){
								
								$p_no_dia.=$key == 0 ? $p_no_dia_name : ', ' . $p_no_dia_name;
							}
						}
					}
					
					$row[] = $p_stone;
					$row[] = $p_clr;
					$row[] = $p_car;
					$row[] = $p_no_dia;
					$row[] = $p_shp;
					$row[] = $p_st_wgh;
					$row[] = $p_set;

				/*GEM*/

					$p_stone = $p_size = $p_no_dia = $p_shp = $p_st_wgh = $p_set = '-';
					if(count($productgem)>0){
						$p_stone = $p_size = $p_no_dia = $p_shp = $p_st_wgh = $p_set = "";//count($productgem)."-";
									foreach ($productgem as $key => $p_gem) {
										$p_stone_name = $p_gem['Productgemstone']['gemstone'];
										$p_no_dia_name = $p_gem['Productgemstone']['no_of_stone'];
										$p_shp_name = $p_gem['Productgemstone']['shape'];
										$p_st_wgh_name = $p_gem['Productgemstone']['stone_weight'];
										$p_set_name = $p_gem['Productgemstone']['settingtype'];
										$p_size_name = $p_gem['Productgemstone']['size'];

										if ($p_stone_name != '') {
											$p_stone .= $key == 0 ? $p_stone_name : ', ' . $p_stone_name;
										}
										if ($p_car_name != '') {
											$p_car .= $key == 0 ? $p_car_name : ', ' . $p_car_name;
										}
										if ($p_shp_name != '') {
											$p_shp .= $key == 0 ? $p_shp_name : ', ' . $p_shp_name;
										}
										if ($p_st_wgh_name != '') {
											$p_st_wgh .= $key == 0 ? $p_st_wgh_name : ', ' . $p_st_wgh_name;
										}
										if ($p_set_name != '') {
											$p_set .= $key == 0 ? $p_set_name : ', ' . $p_set_name;
										}
										if ($p_size_name != '') {
											$p_size .= $key == 0 ? $p_size_name : ', ' . $p_size_name;
										}
										if($p_no_dia_name!=''){
											
											$p_no_dia.=$key == 0 ? $p_no_dia_name : ', ' . $p_no_dia_name;
										}
									}
					}
					
					$row[] = $p_stone;
					$row[] = $p_no_dia;
					$row[] = $p_shp;
					$row[] = $p_st_wgh;
					$row[] = $p_set;
					$row[] = $p_size;
			   /*13 col over */

  
					$Productmetal_type = "";
					$Productmetal_value = "";
					
					if(count($productmetal)>0){
									foreach ($productmetal as $productmetaldiv) {
										$Productmetal_type = $productmetaldiv['Productmetal']['type'];
										if ($productmetaldiv['Productmetal']['category_id'] != '3') {
											$Productmetal_value.=$productmetaldiv['Productmetal']['value'] . ",";
										} else {
											$productbanglesize = $this->Size->find('first', array('conditions' => array('size_value' => $productmetaldiv['Productmetal']['value'])));
											isset($productbanglesize['Size']['size']) ? $Productmetal_value.=$productbanglesize['Size']['size'] . "," : '';
										}
									}
					}
                
					$Productmetal_type = rtrim($Productmetal_type, ",");
					$Productmetal_value = rtrim($Productmetal_value, ",");
					$row[] = $Productmetal_value;/*SIZE*/
          

					$Productmetal_type = "";
					$Productmetal_value = "";
					
					if(count($productsize)>0){
									foreach ($productsize as $productsizediv) {
										$Productmetal_type = $productsizediv['Productmetal']['type'];
										$Productmetal_value.=$productsizediv['Productmetal']['value'] . ",";
									}
					}
					$Productmetal_type = rtrim($Productmetal_type, ",");
					$Productmetal_value = rtrim($Productmetal_value, ",");
					
					$row[] = $Productmetal_value;  

					$p_type = $col_type = $p_v_type = $b_seller = '';
					if ($productdetails['Product']['product_type'] != '') {
						$p_type_exp = explode(',', $productdetails['Product']['product_type']);
						foreach ($p_type_exp as $key => $exp) {
							$p_type .= $key == 0 ? $product_type[$exp] : ', ' . $product_type[$exp];
						}
					}
					if ($productdetails['Product']['collection_type'] != '') {
						$col_type_exp = explode(',', $productdetails['Product']['collection_type']);
						foreach ($col_type_exp as $key => $exp) {
							$col_type .= $key == 0 ? $collection_type[$exp] : ', ' . $collection_type[$exp];
						}
					}
					if ($productdetails['Product']['product_view_type'] != '') {
						$p_v_type_exp = explode(',', $productdetails['Product']['product_view_type']);
						foreach ($p_v_type_exp as $key => $exp) {
							$p_v_type .= $key == 0 ? $product_view_type[$exp] : ', ' . $product_view_type[$exp];
						}
					}

					$row[] = $p_type;
					$row[] = $col_type;
					$row[] = $p_v_type;

					/*18 col valu have to push END*/
					$row[] = round($ordercarts['Shoppingcart']['goldprice'] * ($ordercarts['Shoppingcart']['purity'] / 24)) . '/gm';

					$row[] = $ordercarts['Shoppingcart']['goldamount'];

					$row[] = !empty($ordercarts['Shoppingcart']['stoneprice'])?$ordercarts['Shoppingcart']['stoneprice']:$ordercarts['Shoppingcart']['gemprice'];

					$row[] = !empty($ordercarts['Shoppingcart']['stoneamount'])?$ordercarts['Shoppingcart']['stoneamount']:$ordercarts['Shoppingcart']['gemstoneamount'];

					$row[] = $ordercarts['Shoppingcart']['making_per'];

					$row[] = $ordercarts['Shoppingcart']['making_charge'];

					$row[] = $ordercarts['Shoppingcart']['vat_per'];

					$row[] = $ordercarts['Shoppingcart']['vat'];

					$row[] = $ordercarts['Shoppingcart']['total'];


					$vendoroff = $this->Vendorcontact->find('first', array('conditions' => array('vendor_id' => $vendor['Vendor']['vendor_id'])));

					$vendor_code = $vendor['Vendor']['vendor_code']; 

					$vendor_company_name = $vendor['Vendor']['Company_name']; 

					$vendor_reg_phone = $vendor['Vendor']['reg_phone']; 

					$vendor_reg_mobile = $vendor['Vendor']['reg_mobile']; 

					$vendor_email = $vendoroff['Vendorcontact']['email']; 



					$row[] = $vendor_code;

					$row[] = $vendor_company_name;

					$row[] = $vendor_reg_phone;

					$row[] = $vendor_reg_mobile;

					$row[] = $vendor_email;



				}
				/*ORDER HISTORY*/

					}

					/* 
					  echo "<pre>";

				print_r($row_cnt);echo "</pre>"; 	 */	 
				
				if($i == 1){}
				
				$row_pdt[$i] = $row;
				$i++; 
		}
	
		$count_header = count($header_row);

		//this for check product count header	
		
		for($j=0;$j<max($row_cnt);$j++){	
			$k = 0;	
			foreach($header_row1 as $h_row1){
				$count_header = $j+$count_header+1;
				$header_row[$count_header] = $h_row1;
				$k++;	
			}
		}

		fputcsv($csv_file, $header_row, ',', '"'); 
		//print_r($header_row);
		//print_r($row_pdt);
		foreach($row_pdt as $row_p){	
			fputcsv($csv_file, $row_p, ',', '"'); 
		}/* foreach ($ordercart as $ordercarts) {	//fputcsv($csv_file, $row, ',', '"'); 	 echo "<pre>";

		print_r($row_pdt);echo "</pre>"; } */
		fclose($csv_file);	
	}
    public function track() {
        
    }

    public function admin_order_track_index() {
        $this->layout = 'admin';
        $this->checkadmin();
        if (isset($this->request->data['submit'])) {
            if (!empty($this->request->params['form']['importfile']['name'])) {
                $filename = $this->request->params['form']['importfile'];
                $filetype = $this->Image->getFileExtension($this->request->params['form']['importfile']['name']);
                if ($filetype == 'xls') {
                    $tmp_name = $filename["tmp_name"];
                    App::import('Vendor', 'php-excel-reader/excel_reader2');
                    $data = new Spreadsheet_Excel_Reader($tmp_name, true);
                    $datas = $data->dumpdata(true, true);
                } else {
                    $this->Session->setFlash("<div class='success msg'>" . __('Please upload CSV or XLS file.') . "</div>", '');
                    $this->redirect(array('action' => 'shippingrates_import'));
                }

                foreach ($datas as $datas) {
                    if (!empty($datas['Order_Id']) && !empty($datas['Way_Bill_No'])) {
                        $check = $this->Order->find('first', array('conditions' => array('invoice' => $datas['Order_Id'])));
                        if (!empty($check)) {
                            $this->request->data['Order']['order_id'] = $check['Order']['order_id'];
                            $this->request->data['Order']['way_bill_no'] = $datas['Way_Bill_No'];
                            $this->Order->save($this->request->data);
                            
                            //added by prakash
                            $user = $this->User->findByUserId($check['Order']['user_id']);
                            $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $check['Order']['order_id'])));
                            $productnames = '';
                            foreach ($cart as $carts) {
                                $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                                $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                                $productnames .= $sub_category['Subcategory']['subcategory'].',';
                            }
                            $productnames = rtrim($productnames, ',');
                            $date = date('d/m/Y');
                            $sms_message = $this->get_sms_message(2);
                            $sms_message = str_replace(array('{PRODUCT_NAME}','{WAY_BILL_NO}','{DATE}'), array($productnames,$datas['Way_Bill_No'],$date), $sms_message);
                            $this->sendsms($user['User']['phone_no'], $sms_message);
                        }
                    }
                }
                $this->Session->setFlash("<div class='success msg'>" . __('Way bill number updated successfully') . "</div>", '');
                $this->redirect(array('action' => 'index', 'controller' => 'orders'));
            }
        }
    }

    public function admin_view() {
        $this->layout = "admin";
        $this->checkadmin();

        $paymentdetails = $this->Paymentdetails->find('first', array('conditions' => array('paymentdetails_id' => $this->params['pass']['0'])));
        $this->set('paymentdetail', $paymentdetails);
    }

    public function admin_user_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $this->set('orderdetails', $orderdetails);
    }

    public function admin_franchisee_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $this->set('orderdetails', $orderdetails);
    }

    public function admin_product_view() {
        $this->layout = "admin";
        $this->checkadmin();
        /* $paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
          $this->set('paymentdetail',$paymentdetails); */
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $this->set('orderdetails', $orderdetails);
    }

    public function admin_billing_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $paymentdetails = $this->Paymentdetails->find('first', array('conditions' => array('paymentdetails_id' => $this->params['pass']['0'])));
        $this->set('paymentdetail', $paymentdetails);
    }

    public function admin_shipping_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $paymentdetails = $this->Paymentdetails->find('first', array('conditions' => array('paymentdetails_id' => $this->params['pass']['0'])));
        $this->set('paymentdetail', $paymentdetails);
    }

    public function admin_order_view() {
        $this->layout = "admin";
        $this->checkadmin();
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                if ($this->request->data['Order']['old_order_status_id'] != $this->request->data['Order']['order_status_id']) {
                    $orderhistory = array(
                        'Orderhistory' => array(
                            'order_id' => $this->data['Order']['order_id'],
                            'old_status_id' => $this->data['Order']['old_order_status_id'],
                            'new_status_id' => $this->data['Order']['order_status_id'],
                            'remarks' => $this->data['Order']['orderstatus_remarks'],
                    ));
                    $this->Orderhistory->save($orderhistory);
                    $this->Orderhistory->clear();
                    $this->order_status_mail($this->request->data['Order']['order_id']);
                    $order_status = $this->Orderstatus->findByOrderStsId($this->data['Order']['order_status_id']);
                    $haystack = array('Completed', 'completed', 'Finished', 'finished', 'Delivered', 'delivered', 'Cancelled', 'cancelled');
                    if(!empty($order_status) && in_array($order_status['Orderstatus']['order_status'], $haystack)){
                        $order = $this->Order->findByOrderId($this->data['Order']['order_id']);
                        $user = $this->User->findByUserId($order['Order']['user_id']);
                        $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $order['Order']['order_id'])));

                        $productnames = '';
                        foreach ($cart as $carts) {
                            $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                            $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                            $productnames .= $sub_category['Subcategory']['subcategory'].',';
                        }
                        if(!empty($user)){
                            $productnames = rtrim($productnames, ',');
                            $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $order['Order']['cod_status']);
//                            $message = "Dear {$user['User']['first_name']}, Your Order #{$in}{$order['Order']['invoice']} is {$order_status['Orderstatus']['order_status']}.";
                            if(in_array($order_status['Orderstatus']['order_status'], array('Cancelled', 'cancelled'))){
                                $sms_message = $this->get_sms_message(3);
                                $sms_message = str_replace(array('{PRODUCT_NAME}'), array($productnames), $sms_message);
                            }else{
                                $date = date('d/m/Y');
                                $sms_message = $this->get_sms_message(4);
                                $sms_message = str_replace(array('{PRODUCT_NAME}','{DATE}','{NAME}'), array($productnames,$date,$user['User']['first_name']), $sms_message);
                            }

                            $this->sendsms($user['User']['phone_no'], $sms_message);
                        }
                    }
                }
                if ($this->request->data['Order']['old_admin_status_id'] != $this->request->data['Order']['admin_status_id']) {
                    $orderhistory = array(
                        'Orderhistory' => array(
                            'order_id' => $this->data['Order']['order_id'],
                            'status_type' => 'adminstatus',
                            'old_status_id' => $this->data['Order']['old_admin_status_id'],
                            'new_status_id' => $this->data['Order']['admin_status_id'],
                            'remarks' => $this->data['Order']['adminstatus_remarks'],
                    ));
                    $this->Orderhistory->save($orderhistory);
                    $this->Orderhistory->clear();
                }
                if ($this->request->data['Order']['old_brokerage_status_id'] != $this->request->data['Order']['brokerage_status_id']) {
                    $orderhistory = array(
                        'Orderhistory' => array(
                            'order_id' => $this->data['Order']['order_id'],
                            'status_type' => 'brokeragestatus',
                            'old_status_id' => $this->data['Order']['old_brokerage_status_id'],
                            'new_status_id' => $this->data['Order']['brokerage_status_id'],
                            'remarks' => $this->data['Order']['brokeragestatus_remarks'],
                    ));
                    $this->Orderhistory->save($orderhistory);
                    $this->Orderhistory->clear();
                }

                $this->Session->setFlash('<div class="success msg">Order details updated successfully</div>', '');
            } else {
                $this->Session->setFlash('<div class="error msg">Failed to update</div>', '');
            }
            $this->redirect(array('action' => 'order_view', $this->data['Order']['order_id'], 'controller' => 'orders'));
        }
        /* $paymentdetails=$this->Paymentdetails->find('first',array('conditions'=>array('paymentdetails_id'=>$this->params['pass']['0'])));
          $this->set('paymentdetail',$paymentdetails); */
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $this->set('orderdetails', $orderdetails);
    }

    public function admin_chq_dd_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $user = $this->User->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
        $this->set('orderdetails', $orderdetails);
        $paymentaldetails = $this->Paymentdetails->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        if (empty($paymentaldetails)) {
            if ($this->request->is('post')) {
                $this->request->data['Paymentdetails']['order_id'] = $orderdetails['Order']['order_id'];
                $this->request->data['Paymentdetails']['user_id'] = $orderdetails['Order']['user_id'];
                $this->request->data['Paymentdetails']['status'] = 'Success';
                $this->request->data['Paymentdetails']['admin_status'] = 'Order in Progress';
                $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
                $this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');

                $this->Paymentdetails->save($this->request->data);
                $this->request->data['Order']['order_id'] = $orderdetails['Order']['order_id'];
                $this->request->data['Order']['status'] = 'Paid';
                if ($user['User']['user_type'] == '0') {
                    $this->request->data['Order']['order_status'] = 'BookedbyUser';
                } elseif ($user['User']['user_type'] == '1') {
                    $this->request->data['Order']['order_status'] = 'BookedbyFranchisee';
                }
                $this->Order->save($this->request->data);
                /* $id=$this->Paymentdetails->getLastInsertId();
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
                  $this->mailsend(SITE_NAME, $adminmailid['Adminuser']['email'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message); */

                $this->Session->setFlash('<div class="success msg">CHQ/DD details added successfully.</div>', '');
                $this->redirect(array('action' => 'chq_dd_view', $this->params['pass']['0']));
            }
        } else {
            $this->set('paymentaldetails', $paymentaldetails);
            if ($this->request->is('post')) {
                $this->request->data['Paymentdetails']['paymentdetails_id'] = $paymentaldetails['Paymentdetails']['paymentdetails_id'];
                $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
                $this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');
                $this->Paymentdetails->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">CHQ/DD details updated successfully.</div>', '');
                $this->redirect(array('action' => 'chq_dd_view', $this->params['pass']['0']));
            }
        }
    }

    /* public function apply_discount($id=''){                                                       $message = '';
      $message1='';
      if ($id != '') {
      $date = date('Y-m-d');
      $cart_product = $this->Discount->find('first', array('conditions' => array('voucher_code' => $id, '"' . $date . '" BETWEEN Discount.start_date AND  Discount.expired_date')));

      $user_id = $this->Session->read('User.user_id');

      if (!empty($cart_product)) {

      $type = $cart_product['Discount']['type'];
      $peroramou = $cart_product['Discount']['per_amou'];
      $percentage = $cart_product['Discount']['percentage'];
      $discount_id = $cart_product['Discount']['discount_id'];
      $coupon_code = $cart_product['Discount']['voucher_code'];
      $user_id_dis = explode(",", $cart_product['Discount']['user_id']);
      $category_id_dis = explode(",", $cart_product['Discount']['category_id']);
      $product_id_dis = explode(",", $cart_product['Discount']['product_id']);


      $already_used_or_not = $this->Discounthistory->find('count', array('conditions' => array('coupon_id' => $discount_id, 'user_id' => $user_id)));

      if($already_used_or_not==0) {

      $cart_product = $this->Shoppingcart->find('all', array('conditions' => array('cart_session' => $this->Session->read('cart_process'))));

      if (($type == "User" && in_array($user_id, $user_id_dis)) || $type == "Product" || $type == "Category" || $type == "Vouchercode")
      {
      foreach ($cart_product as $cart_products) {

      $cat_id_find = $this->Products->find('first', array('conditions' => array('product_id' => $cart_products['Shoppingcart']['product_id'])));

      if ((in_array($cart_products['Shoppingcart']['product_id'], $product_id_dis) && $type == "Product") || (in_array($cat_id_find['Products']['category_id'], $category_id_dis) && $type == "Category") || $type == "Vouchercode" || $type == "User")
      {
      if ($peroramou == 1) {

      $per_amount = $cart_products['Shoppingcart']['total'] * $percentage / 100;
      $remain_amount = $cart_products['Shoppingcart']['total'] - $per_amount;
      } else {

      $per_amount = $percentage;
      $remain_amount = $cart_products['Shoppingcart']['total'] - $per_amount;
      }
      $this->request->data['Shoppingcart']['cart_id'] = $cart_products['Shoppingcart']['cart_id'];
      $this->request->data['Shoppingcart']['total_amount'] = $cart_products['Shoppingcart']['total'];
      $this->request->data['Shoppingcart']['total'] = $remain_amount;
      $this->request->data['Shoppingcart']['detected_amount'] = $per_amount;
      $this->request->data['Shoppingcart']['is_coupon_used'] = '1';
      $this->Shoppingcart->save($this->request->data['Shoppingcart']);

      $this->request->data['Discounthistory']['user_id'] = $user_id;
      $this->request->data['Discounthistory']['coupon_code'] = $coupon_code;
      $this->request->data['Discounthistory']['coupon_id'] = $discount_id;
      $this->request->data['Discounthistory']['cart_id'] = $cart_products['Shoppingcart']['cart_id'];
      if ($peroramou == 1) {
      $this->request->data['Discounthistory']['percentage'] = $percentage;
      } else {
      $this->request->data['Discounthistory']['amount'] = $percentage;
      }
      $this->Discounthistory->save($this->request->data['Discounthistory']);
      $message="Discount Amount applied";
      } else if($message=='' ) {   $message1="Invalid Voucher Code";     }



      }
      if($message!='') {  $this->Session->setFlash("<div class='success msg'>".$message."</div>");        }
      else if($message1!='') { $this->Session->setFlash("<div class='error msg'>".$message1."</div>");   }
      $this->redirect(array('action' => 'order', 'controller' => 'orders'));

      }
      }
      else {

      $this->Session->setFlash("<div class='error msg'>Code Already used</div>");
      $this->redirect(array('action' => 'order', 'controller' => 'orders'));
      }

      } else {
      $this->Session->setFlash("<div class='error msg'>Invalid voucher code</div>");
      $this->redirect(array('action' => 'order', 'controller' => 'orders'));


      }


      }
      } */

    public function apply_discount() {
        if ($this->Session->read('User') == '' || $this->Session->read('cart_process') == '') {
            $this->redirect(BASE_URL);
        }
        if ($this->request->is('post')) {
            //$user_id = $this->Session->read('User.user_id');
			$user_id = $_SESSION['User']['user_id'];
			
			// echo "<pre>";
			// print_r($this->Session);
			//print_r($_SESSION);
			//echo "user id:  ".$_SESSION['User']['user_id'];
			
			//print_r($this->Session->read('Adminuser.user_id'));
			//$userid = $this->Session->read('User.user_id');
			//echo "user id: ".$user_id;
			// exit;
            $coupon = $this->request->data['coupon'];
            $check_discount = $this->Discount->find('first', array('conditions' => array('voucher_code' => $coupon, '"' . date('Y-m-d') . '" BETWEEN start_date AND expired_date')));
            $order = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
            $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
            if (!empty($check_discount)) {
                $already_used_or_not = $this->Discounthistory->find('first', array('conditions' => array('coupon_id' => $check_discount['Discount']['discount_id'], 'user_id' => $user_id)));
                if (empty($already_used_or_not)) {
                    if ($check_discount['Discount']['type'] == "Product") {
                        $cart = $this->Shoppingcart->find('first', array('conditions' => array('product_id' => explode(',', $check_discount['Discount']['product_id']), 'order_id' => $order['Order']['order_id']), 'fields' => array('SUM(total*quantity) AS total')));
                        if (!empty($cart[0]['total'])) {
                            if ($check_discount['Discount']['per_amou'] == 1) {
                                $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                                $order['Order']['discount_amount'] = round($cart['0']['total'] * $check_discount['Discount']['percentage'] / 100);
                            } else {
                                $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                            }
                            $this->Order->save($order);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>Please check the Product or Code.</div>");
                            $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                        }
                    } elseif ($check_discount['Discount']['type'] == "Category") {
                        $cart = $this->Shoppingcart->find('first', array('conditions' => array('Shoppingcart.product_id' => explode(',', $check_discount['Discount']['product_id']), 'Product.category_id' => explode(',', $check_discount['Discount']['category_id'])), 'joins' =>
                            array(
                                array(
                                    'table' => 'products',
                                    'alias' => 'Product',
                                    'type' => 'inner',
                                    'foreignKey' => false,
                                    'conditions' => array('Shoppingcart.product_id = Product.product_id')
                                )), 'fields' => array('SUM(total*quantity) AS total')));
                        if (!empty($cart[0]['total'])) {
                            if ($check_discount['Discount']['per_amou'] == 1) {
                                $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                                $order['Order']['discount_amount'] = round($cart['0']['total'] * $check_discount['Discount']['percentage'] / 100);
                            } else {
                                $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                            }
                            $this->Order->save($order);
                        } else {
                            $this->Session->setFlash("<div class='error msg'>Please check the Product or Code.</div>");
                            $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                        }
                    } elseif ($check_discount['Discount']['type'] == "User") {
                        if (!in_array($user_id, explode(",", $check_discount['Discount']['user_id']))) {
                            $this->Session->setFlash("<div class='error msg'>Invalid Coupon.</div>");
                            $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                        }
                        if ($check_discount['Discount']['per_amou'] == 1) {
                            $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                            $order['Order']['discount_amount'] = round($cart_amount[0]['subtotal'] * $check_discount['Discount']['percentage'] / 100);
                        } else {
                            $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                        }
                        $this->Order->save($order);
                    } elseif ($check_discount['Discount']['type'] == "Vouchercode") {
                        if ($check_discount['Discount']['per_amou'] == 1) {
                            $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                            $order['Order']['discount_amount'] = round($cart_amount[0]['subtotal'] * $check_discount['Discount']['percentage'] / 100);
                        } else {
                            $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                        }
                        $this->Order->save($order);
                    } else {
                        $this->Session->setFlash("<div class='error msg'>Invalid Coupon.</div>");
                        $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                    }

                    $this->request->data['Discounthistory']['user_id'] = $user_id;
                    $this->request->data['Discounthistory']['coupon_id'] = $check_discount['Discount']['discount_id'];
                    //$this->request->data['Discounthistory']['cart_id'] = $this->Session->read('cart_process');
                    $this->request->data['Discounthistory']['order_id'] = $this->Session->read('Order');
                    $this->request->data['Discounthistory']['date'] = date('Y-m-d H:i:s');
                    $this->request->data['Discounthistory']['coupon_code'] = $check_discount['Discount']['voucher_code'];
                    
                    //added by prakash
                    $this->request->data['Discounthistory']['Type'] = $check_discount['Discount']['type'];
                    if ($check_discount['Discount']['per_amou'] == 1) {
                        $this->request->data['Discounthistory']['percentage'] = $check_discount['Discount']['percentage'];
                    } else {
                        $this->request->data['Discounthistory']['amount'] = $check_discount['Discount']['percentage'];
                    }
                    $this->Discounthistory->save($this->request->data['Discounthistory']);
                    $this->Session->write('discount', '1');
                    $this->Session->setFlash("<div class='success msg'>Discount coupon applied Successfully</div>");
                    $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                } else {
                    $this->Session->setFlash("<div class='error msg'>You have already used in this coupon.</div>");
                    $this->redirect(array('action' => 'order', 'controller' => 'orders'));
                }
            } else {
                $this->Session->setFlash("<div class='error msg'>Please check the coupon validity or code.</div>");
                $this->redirect(array('action' => 'order', 'controller' => 'orders'));
            }
        } else {
            $this->redirect(BASE_URL);
        }
    }

    //New function written by Nad at 2015-03-27
    public function order_status_mail($order_id) {
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
        $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $orderdetails['Order']['cod_status']);

        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));

        App::uses('CakeEmail', 'Network/Email');

        $email = new CakeEmail();
        $email->emailFormat('html');
        $email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
        $email->template('default', 'default');
        $email->to(trim($user['User']['email']));
        $subject = " Order # " . $in . $orderdetails['Order']['invoice'] . " Order Status : " . $orderdetails['Orderstatus']['order_status'];
        $email->subject(SITE_NAME . $subject);
        $message = "<p>Dear {$user['User']['first_name']}</p>";
        $message .= "<p>Your Order status has been recently changed</p>";
        $message .= "<p>Your Order # {$in}{$orderdetails['Order']['invoice']}</p>";
        $message .= "<p>Order Status : {$orderdetails['Orderstatus']['order_status']}</p>";
        $message .= "<p>Thanks.</p>";
//        $invoice = $this->requestAction(array('action' => 'admin_orderpdf', $orderdetails['Order']['order_id'], 'F'), array('return', 'bare' => false));
//        $email->attachments('files/invoices/'.$in . $orderdetails['Order']['invoice'].'.pdf');

        $email->send($message);
        $email->reset();
    }

    //added by prakash
    public function admin_vendors_brokerage() {
        $is_search = false;
        $this->layout = "admin";
        $this->checkadmin();
        $this->Shoppingcart->bindModel(
                array(
            'belongsTo' => array(
                'Order' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.order_id = Order.order_id'),
                    'foreignKey' => false,
                ),
                'Orderstatus' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.order_status_id = Orderstatus.order_sts_id'),
                    'foreignKey' => false,
                ),
                'Brokeragestatus' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.brokerage_status_id = Brokeragestatus.brokerage_sts_id'),
                    'foreignKey' => false,
                ),
                'Product' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.product_id = Product.product_id'),
                    'foreignKey' => false,
                ),
                'Category' => array(
                    'type' => 'Inner',
                    'conditions' => array('Product.category_id = Category.category_id'),
                    'foreignKey' => false,
                ),
                'Vendor' => array(
                    'type' => 'Inner',
                    'conditions' => array('Product.vendor_id = Vendor.vendor_id'),
                    'foreignKey' => false,
                ),
                'User' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.user_id = User.user_id And User.user_type = "0"'),
                    'foreignKey' => false,
                ),
            )
                ), false
        );

        $search_string_url = '?export=vendor_brokerage';
        if ($this->request->is('get')) {
            $is_search = true;
            $search_string = array();

            $search = array('Shoppingcart.order_id is not NULL');
            if ($this->request->query('pname') != '') {
                $search[] = "Product.product_name Like '%" . $this->request->query('pname') . "%'";
                $search_string[] = 'pname=' . $this->request->query['pname'];
            }
            if ($this->request->query('vendor') != '') {
                $search[] = "Vendor.vendor_code Like '%" . $this->request->query('vendor') . "%'";
                $search_string[] = 'vendor=' . $this->request->query['vendor'];
            }
            if ($this->request->query('from_date') != '' && $this->request->query('to_date') != '') {
                $search[] = "DATE(Order.created_date) Between '" . $this->request->query('from_date') . "' And '" . $this->request->query('to_date') . "'";
                $search_string[] = 'from_date=' . $this->request->query['from_date'];
                $search_string[] = 'to_date=' . $this->request->query['to_date'];
            }

            if (!empty($search_string)) {
                $search_string_url .= '&' . implode('&', $search_string);
            }

            $this->paginate = array('conditions' => $search, 'order' => 'Order.order_id DESC');
            $this->set('orderdetails', $this->paginate('Shoppingcart'));
        } else {
            $this->paginate = array('conditions' => array('Shoppingcart.order_id is not NULL'), 'order' => 'Shoppingcart.order_id DESC');
            $this->set('orderdetails', $this->Paginator->paginate('Shoppingcart'));
        }

        $this->set(compact('is_search', 'search_string_url'));
    }

    public function admin_franchisee_brokerage() {
        $is_search = false;
        $this->layout = "admin";
        $this->checkadmin();
        $this->Shoppingcart->bindModel(
                array(
            'belongsTo' => array(
                'Order' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.order_id = Order.order_id'),
                    'foreignKey' => false,
                ),
                'Orderstatus' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.order_status_id = Orderstatus.order_sts_id'),
                    'foreignKey' => false,
                ),
                'Brokeragestatus' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.brokerage_status_id = Brokeragestatus.brokerage_sts_id'),
                    'foreignKey' => false,
                ),
                'Product' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.product_id = Product.product_id'),
                    'foreignKey' => false,
                ),
                'Category' => array(
                    'type' => 'Inner',
                    'conditions' => array('Product.category_id = Category.category_id'),
                    'foreignKey' => false,
                ),
                'Vendor' => array(
                    'type' => 'Inner',
                    'conditions' => array('Product.vendor_id = Vendor.vendor_id'),
                    'foreignKey' => false,
                ),
                'User' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.user_id = User.user_id And User.user_type = "1"'),
                    'foreignKey' => false,
                ),
            )
                ), false
        );

        $search_string_url = '?export=franchisee_brokerage';
        if ($this->request->is('get')) {
            $is_search = true;
            $search_string = array();
            $search = array('Shoppingcart.order_id is not NULL', 'User.user_type = "1"');
            if ($this->request->query('pname') != '') {
                $search[] = "Product.product_name Like '%" . $this->request->query('pname') . "%'";
                $search_string[] = 'pname=' . $this->request->query['pname'];
            }
            if ($this->request->query('from_date') != '' && $this->request->query('to_date') != '') {
                $search[] = "DATE(Order.created_date) Between '" . $this->request->query('from_date') . "' And '" . $this->request->query('to_date') . "'";
                $search_string[] = 'from_date=' . $this->request->query['from_date'];
                $search_string[] = 'to_date=' . $this->request->query['to_date'];
            }

            if (!empty($search_string)) {
                $search_string_url .= '&' . implode('&', $search_string);
            }
            $this->paginate = array('conditions' => $search, 'order' => 'Order.order_id DESC');
            $this->set('orderdetails', $this->paginate('Shoppingcart'));
        } else {
            $this->paginate = array('conditions' => array('Shoppingcart.order_id is not NULL'), 'order' => 'Shoppingcart.order_id DESC');
            $this->set('orderdetails', $this->Paginator->paginate('Shoppingcart'));
        }

        $this->set(compact('is_search', 'search_string_url'));
    }

    public function admin_brokerage_export($type,$cdate,$edate) {
		$filename = $type . ".csv";
        $user_type = $type == 'vendor_brokerage' ? 0 : 1;
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
		$this->Shoppingcart->bindModel( 
			array('belongsTo' => 
					array('Order' => array('type' => 'Inner','conditions' => array('Shoppingcart.order_id = Order.order_id'),'foreignKey' => false,),
					'Orderstatus' => array('type' => 'Inner','conditions' => array('Order.order_status_id = Orderstatus.order_sts_id'),'foreignKey' => false,),
					
					'Brokeragestatus' => array('type' => 'Inner','conditions' => array('Order.brokerage_status_id =		Brokeragestatus.brokerage_sts_id'),'foreignKey' => false,),
					
					'Product' => array('type' => 'Inner','conditions' => array('Shoppingcart.product_id = Product.product_id'), 'foreignKey' => false,),

					'Category' => array('type' => 'Inner','conditions' => array('Product.category_id = Category.category_id'),'foreignKey' => false,),

					'Vendor' => array('type' => 'Inner','conditions' => array('Product.vendor_id = Vendor.vendor_id'),                    'foreignKey' => false,),

					'User' => array('type' => 'Inner','conditions' => array('Order.user_id = User.user_id And user_type = "' . $user_type . '"'),'foreignKey' => false,),            
					)                
				), false        
		);

		$conditions = array('Shoppingcart.order_id !=' => NULL);

		if($cdate != 0 && $edate != 0){					
				$conditions = array('DATE(Order.created_date) >='=>$cdate,'DATE(Order.created_date) <='=>$edate);
			}else if($cdate==''){
				$conditions = array('DATE(Order.created_date) <='=>$edate);
			}else if($edate==''){
				$conditions = array('DATE(Order.created_date) >='=>$cdate);
			}

			$results = $this->Shoppingcart->find('all', array('conditions' => $conditions, 'order' => 'Shoppingcart.order_id DESC'));
			//print_r($results);
			//exit;

			$header_row = array(
								"S.No",
								"Order ID",
								"Date",
								"Customer Name",
								"Vendor Code",
								"Company name",
								"Franchisee code",
								"Product Code",
								"Product Name",
								"Price",
								"Order Status",
								"Brokerage Status",
								"Brokeage Amount",
								"Order Value",
								"Gold Weight",
								"Gold Amount",
								"Total Diamond Pcs",
								"Diamond Amount",
								"Making Charge",
								"VAT",
								"Total Amount",
								"Mode of Payment",
								"Payment Status"
							);

			if ($type == 'franschisee_brokerage') {
				unset($header_row[array_search('Vendor Code', $header_row)]);
				unset($header_row[array_search('Company name', $header_row)]);
				$header_row[3] = 'Franchisee Name';        
			}elseif($type == 'vendor_brokerage'){
				unset($header_row[array_search('Franchisee code', $header_row)]);
			}        
			fputcsv($csv_file, $header_row, ',', '"');
			$i = 1;
			$pay_mode = "";
			foreach ($results as $result) {
				$in = $this->admin_get_invoice_prefix($result['User']['user_type'], $result['Order']['cod_status']);            $brokerage_amount = $this->requestAction(array('controller' => 'products', 'action' => 'admin_get_brokerage_amount', $result['Product']['product_id'], $result['Shoppingcart']['cart_id']));
				$netamount = $this->admin_get_net_amount($result['Order']['order_id']);
				
				if($result['Order']['cod_status'] == "PayU"){
					$pay_mode = "Full Payment";
				}else if($result['Order']['cod_status'] == "COD"){
					$pay_mode = "Partial Payment";
				}else if($result['Order']['cod_status'] == "CHQ/DD"){
					$pay_mode = "CHQ/DD";
				}else{
					$pay_mode = "";
				}
				
				
				$row = array($i,
								$in . $result['Order']['invoice'],
								date("Y-m-d", strtotime($result['Order']['created_date'])),
								$result['User']['first_name'] . ' ' . $result['User']['last_name'],
								$result['Vendor']['vendor_code'],
								$result['Vendor']['Company_name'],
								$result['User']['franchisee_code'],
								$result['Category']['category_code'] . ' ' . $result['Product']['product_code'] . "-" . $result['Shoppingcart']['purity'] . "K" . $result['Shoppingcart']['clarity'] . $result['Shoppingcart']['color'],
								$result['Product']['product_name'],
								indian_number_format($result['Shoppingcart']['total'] * $result['Shoppingcart']['quantity']),
								$result['Orderstatus']['order_status'],
								$result['Brokeragestatus']['brokerage_status'],
								indian_number_format($brokerage_amount),
								indian_number_format($netamount),
								
								$result['Shoppingcart']['weight'],
								$result['Shoppingcart']['goldamount'],
								$result['Shoppingcart']['no_of_diamond'],
								$result['Shoppingcart']['stoneamount'],
								$result['Shoppingcart']['making_charge'],
								$result['Shoppingcart']['vat'],
								$result['Shoppingcart']['total'],
								
								$pay_mode,
								$result['Order']['status']
								
								
							);

				if ($type == 'franschisee_brokerage') {
						unset($row[4]);
						unset($row[5]);
					}elseif($type == 'vendor_brokerage'){
						unset($row[6]);            
					}            
					
					$i++; 
					fputcsv($csv_file, $row, ',', '"');        
				
			}

					
			fclose($csv_file);    
	}

    public function admin_get_invoice_prefix($user_type, $cod_status) {
        $prefix = '';
        if ($user_type == '0') {
            if ($cod_status == 'PayU') {
                $prefix = 'SGN-ON-';
            } elseif ($cod_status == 'CHQ/DD') {
                $prefix = 'SGN-CHQ/DD-';
            } elseif ($cod_status == 'COD') {
                $prefix = 'SGN-CD-';
            }
        } else {
            if ($cod_status == 'PayU') {
                $prefix = 'SGN-FN-';
            } elseif ($cod_status == 'COD') {
                $prefix = 'SGN-FNCD-';
            } elseif ($cod_status == 'CHQ/DD') {
                $prefix = 'SGN-FNCHQ/DD-';
            }
        }
        return $prefix;
    }

    public function admin_get_net_amount($order_id) {
        $netamount = 0;
        $this->Shoppingcart->bindModel(
                array(
            'belongsTo' => array(
                'Order' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.order_id = Order.order_id'),
                    'foreignKey' => false,
                ),
            )
                ), false
        );
        $cart_amount = $this->Shoppingcart->find('first', array(
            'conditions' => array('Shoppingcart.order_id' => $order_id),
            'fields' => 'SUM(Shoppingcart.quantity*Shoppingcart.total) AS subtotal, Order.discount_amount, Order.shipping_amt'));
        if (!empty($cart_amount)) {
            $netamount = $cart_amount[0]['subtotal'];
            $netamount-=$cart_amount['Order']['discount_amount'];
            $netamount+=$cart_amount['Order']['shipping_amt'];
        }
        return $netamount;
    }

    public function orderpdf($order_id = NULL, $output = 'D') {
		//echo "1";
		//exit;
		
        $this->usercheck();
        $userid = $this->Session->read('User.user_id');

        $this->layout = '';
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        if ($userid == $orderdetails['Order']['user_id']) {
            $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
            $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $orderdetails['Order']['cod_status']);

            $this->set(compact('orderdetails', 'user', 'in'));
            $filename = str_replace('/', '_', $in . $orderdetails['Order']['invoice'] . '.pdf');
            $this->Mpdf->init(array('en-GB-x', 'A4', '', '', 10, 10, 10, 10, 6, 3));
//            $this->Mpdf->Image(BASE_URL.'img/icons/logo.png',0,0,210,297,'png','',true, false);
            $filepath = 'files/invoices/' . $filename;
            $this->Mpdf->setFilename($filepath);
            $this->Mpdf->setOutput($output);
//            $this->Mpdf->Output($filename, 'D');
        } else {
            $this->Session->setFlash("<div class='error msg'>" . __('Access denied.') . "</div>");
            $this->redirect(array('controller' => 'orders', 'action' => 'my_orders'));
        }
//        $this->Mpdf->SetWatermarkText("Draft");
    }

    public function admin_orderpdf($order_id = NULL, $output = 'D') {
		//echo "2";
		//exit;
        $this->checkadmin();

        $this->layout = '';
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
        $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $orderdetails['Order']['cod_status']);

        $this->set(compact('orderdetails', 'user', 'in'));
        $filename = str_replace('/', '_', $in . $orderdetails['Order']['invoice'] . '.pdf');
        $this->Mpdf->init(array('en-GB-x', 'A4', '', '', 10, 10, 10, 10, 6, 3));
        $filepath = 'files/invoices/' . $filename;
        $this->Mpdf->setFilename($filepath);
        $this->Mpdf->setOutput($output);
//            $this->Mpdf->Output($filename, 'D');
//        $this->Mpdf->SetWatermarkText("Draft");
    }

    public function admin_orderhistory_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $orderhistory = $this->Orderhistory->find('all', array(
            'recursive' => 2,
            'conditions' => array('Orderhistory.order_id' => $this->params['pass']['0'])));
        $this->set(compact('orderhistory', 'orderdetails'));
    }

    public function franchisee_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function product_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $vendor = $this->Vendor->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
            $product_ids = $this->Product->find('list', array('conditions' => array('vendor_id' => $vendor['Vendor']['vendor_id'])));
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails', 'product_ids', 'vendor'));
        } else {
            return $this->redirect('/');
        }
    }

    public function billing_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function shipping_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function user_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function order_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->request->data['Order']['old_admin_status_id'] != $this->request->data['Order']['admin_status_id']) {
                    if ($this->Order->save($this->request->data)) {
                        $this->vendor_status_mail_to_admin($this->request->data['Order']['order_id']);
                        $this->Session->setFlash('<div class="success msg">Vendor status updated successfully</div>', '');
                    } else {
                        $this->Session->setFlash('<div class="error msg">Failed to update</div>', '');
                    }
                }
                if ($this->request->data['Order']['old_order_status_id'] != $this->request->data['Order']['order_status_id']) {
                    $orderhistory = array(
                        'Orderhistory' => array(
                            'order_id' => $this->data['Order']['order_id'],
                            'old_status_id' => $this->data['Order']['old_order_status_id'],
                            'new_status_id' => $this->data['Order']['order_status_id'],
                            'remarks' => $this->data['Order']['orderstatus_remarks'],
                            'changed_by' => $this->Session->read('User.first_name').' '.$this->Session->read('User.last_name'),
                    ));
                    $this->Orderhistory->save($orderhistory);
                    $this->Orderhistory->clear();
                    if ($this->Order->save($this->request->data)) {
                        $this->order_status_mail_to_admin($this->request->data['Order']['order_id']);
                        $this->Session->setFlash('<div class="success msg">Order status updated successfully</div>', '');
                    } else {
                        $this->Session->setFlash('<div class="error msg">Failed to update</div>', '');
                    }
                }
                if ($this->request->data['Order']['old_admin_status_id'] != $this->request->data['Order']['admin_status_id']) {
                    $orderhistory = array(
                        'Orderhistory' => array(
                            'order_id' => $this->data['Order']['order_id'],
                            'status_type' => 'adminstatus',
                            'old_status_id' => $this->data['Order']['old_admin_status_id'],
                            'new_status_id' => $this->data['Order']['admin_status_id'],
                            'remarks' => $this->data['Order']['adminstatus_remarks'],
                            'changed_by' => $this->Session->read('User.first_name').' '.$this->Session->read('User.last_name'),
                    ));
                    $this->Orderhistory->save($orderhistory);
                    $this->Orderhistory->clear();
                }
                $this->redirect(array('action' => 'order_view', $this->data['Order']['order_id'], 'controller' => 'orders'));
            }
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function orderhistory_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $orderhistory = $this->Orderhistory->find('all', array(
                'recursive' => 2,
                'conditions' => array('Orderhistory.order_id' => $this->params['pass']['0'])));
            $this->set(compact('orderhistory', 'orderdetails'));
        } else {
            return $this->redirect('/');
        }
    }

    public function chq_dd_view() {
        $this->usercheck();
        if ($this->Session->read('User.user_type') == 2) {
            $this->layout = 'webpage';
            $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            $user = $this->User->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
            $this->set('orderdetails', $orderdetails);
            $paymentaldetails = $this->Paymentdetails->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            if (empty($paymentaldetails)) {
                if ($this->request->is('post')) {
                    $this->request->data['Paymentdetails']['order_id'] = $orderdetails['Order']['order_id'];
                    $this->request->data['Paymentdetails']['user_id'] = $orderdetails['Order']['user_id'];
                    $this->request->data['Paymentdetails']['status'] = 'Success';
                    $this->request->data['Paymentdetails']['admin_status'] = 'Order in Progress';
                    $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
                    $this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');

                    $this->Paymentdetails->save($this->request->data);
                    $this->request->data['Order']['order_id'] = $orderdetails['Order']['order_id'];
                    $this->request->data['Order']['status'] = 'Paid';
                    if ($user['User']['user_type'] == '0') {
                        $this->request->data['Order']['order_status'] = 'BookedbyUser';
                    } elseif ($user['User']['user_type'] == '1') {
                        $this->request->data['Order']['order_status'] = 'BookedbyFranchisee';
                    }
                    $this->Order->save($this->request->data);
                    $this->Session->setFlash('<div class="success msg">CHQ/DD details added successfully.</div>', '');
                    $this->redirect(array('action' => 'chq_dd_view', $this->params['pass']['0']));
                }
            } else {
                $this->set('paymentaldetails', $paymentaldetails);
                if ($this->request->is('post')) {
                    $this->request->data['Paymentdetails']['paymentdetails_id'] = $paymentaldetails['Paymentdetails']['paymentdetails_id'];
                    $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
                    $this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');
                    $this->Paymentdetails->save($this->request->data);
                    $this->Session->setFlash('<div class="success msg">CHQ/DD details updated successfully.</div>', '');
                    $this->redirect(array('action' => 'chq_dd_view', $this->params['pass']['0']));
                }
            }
        } else {
            return $this->redirect('/');
        }
    }

    public function vendor_status_mail_to_admin($order_id) {
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
        $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $orderdetails['Order']['cod_status']);

        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
        App::uses('CakeEmail', 'Network/Email');

        $email = new CakeEmail();
        $email->emailFormat('html');
        $email->from(trim($user['User']['email']));
        $email->template('default', 'default');
        $email->to(trim($adminmailid['Adminuser']['email']));
        $subject = " Order # " . $in . $orderdetails['Order']['invoice'] . " Vendor Status : " . $orderdetails['Adminstatus']['admin_status'];
        $email->subject(SITE_NAME . $subject);
        $message = "<p>Dear {$adminmailid['Adminuser']['admin_name']}</p>";
        $message .= "<p>A vendor status has been recently changed by {$user['User']['first_name']} for the below order: </p>";
        $message .= "<p>Order # {$in}{$orderdetails['Order']['invoice']}</p>";
        $message .= "<p>Vendor Status : {$orderdetails['Adminstatus']['admin_status']}</p>";
        $message .= "<p>Thanks.</p>";
        $email->send($message);
        $email->reset();
    }

    public function order_status_mail_to_admin($order_id) {
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
        $in = $this->admin_get_invoice_prefix($user['User']['user_type'], $orderdetails['Order']['cod_status']);

        $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
        App::uses('CakeEmail', 'Network/Email');

        $email = new CakeEmail();
        $email->emailFormat('html');
        $email->from(trim($user['User']['email']));
        $email->template('default', 'default');
        $email->to(trim($adminmailid['Adminuser']['email']));
        $subject = " Order # " . $in . $orderdetails['Order']['invoice'] . " Order Status : " . $orderdetails['Orderstatus']['order_status'];
        $email->subject(SITE_NAME . $subject);
        $message = "<p>Dear {$adminmailid['Adminuser']['admin_name']}</p>";
        $message .= "<p>An order status has been recently changed by {$user['User']['first_name']} for the below order: </p>";
        $message .= "<p>Order # {$in}{$orderdetails['Order']['invoice']}</p>";
        $message .= "<p>Order Status : {$orderdetails['Orderstatus']['order_status']}</p>";
        $message .= "<p>Thanks.</p>";
        $email->send($message);
        $email->reset();
    }

/////////////////////////////////////////////////////////////////////////////////////////////////

    public function generate_invoice_number() {
        $count = 0;
//        $count = $this->Order->find('count');
        $new_inv_no = INVOICE_PREFIX .(str_pad((1+ $count),INVOICE_STR_PAD,'0',STR_PAD_LEFT));
        do {
            $inv_no = $this->Order->findByOrgInvoice($new_inv_no);
            if (!empty($inv_no)) {
                $check_inv_no = $inv_no['Order']['org_invoice'];
                $count++;
                $new_inv_no = INVOICE_PREFIX .(str_pad((1+ $count),INVOICE_STR_PAD,'0',STR_PAD_LEFT));
            } else {
                break;
            }
        } while ($check_inv_no != $new_inv_no);
        return $new_inv_no;
    }

}
