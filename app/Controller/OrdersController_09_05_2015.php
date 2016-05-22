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
    public $uses = array('Order', 'User', 'Shipping', 'Shoppingcart', 'Discount', 'Paymentdetails', 'Discounthistory', 'Product', 'Productimage', 'Category', 'Productdiamond', 'Productgemstone', 'Vendorcontact', 'Products', 'Shippingrate', 'Partialpay');
    public $layout = 'webpage';

    public function personal_details() {
        if ($this->Session->read('User') != '') {
            $user_id = $this->Session->read('User.user_id');
            $user = $this->User->find('first', array('conditions' => array('user_id' => $user_id)));
            $this->set('user', $user);
            if (!empty($this->request->data)) {

                $check = $this->User->find('first', array('conditions' => array('user_id' => $user_id)));
                if (!empty($check)) {
                    $this->request->data['User']['user_id'] = $check['User']['user_id'];
                    $this->request->data['User']['created_date'] = date('Y-m-d H:i:s');
                    if(!empty($this->request->data['User']['year']) && !empty($this->request->data['User']['month']) && !empty($this->request->data['User']['date']))
						{
								$this->request->data['User']['date_of_birth'] = $this->request->data['User']['year'] . "-" . $this->request->data['User']['month'] . 
								"-" . $this->request->data['User']['date'];
						}else{
							$this->request->data['User']['date_of_birth']='';
						}
                   if(!empty($this->request->data['User']['annu_year']) && !empty($this->request->data['User']['annu_month']) && !empty($this->request->data['User']['annu_date']))
						{
                        $this->request->data['User']['anniversary'] = $this->request->data['User']['annu_year'] . "-" . $this->request->data['User']['annu_month'] . "-" . $this->request->data['User']['annu_date'];
						}else{
							$this->request->data['User']['anniversary'] = '';
						}
                    $this->User->save($this->request->data);
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
                    $invoice = $this->Order->find('first', array('fields' => array('MAX(Order.invoice) AS maxid', '*')));
                    if (!empty($invoice[0]['maxid'])) {
                        $tiid = $invoice[0]['maxid'] + 1;
                    } else {
                        $tiid = 1;
                    }
                    $invoice_code = sprintf("%06d", $tiid);
                    $this->request->data['Order']['invoice'] = $invoice_code;

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
                    $this->Order->saveAll($this->request->data);
                    $order1 = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                    $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'))));
                    $name = $user['User']['first_name'].' '.$user['User']['last_name'];
                    $cart = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $this->Session->read('Order'))));
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
                        foreach ($cart as $carts) {
                            $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                            $productdiamond = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'], 'clarity' => $carts['Shoppingcart']['clarity'], 'color' => $carts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));

                            $productgemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));

                            $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
                            $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                            $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
                            $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
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
							<p><strong>Number of Sto