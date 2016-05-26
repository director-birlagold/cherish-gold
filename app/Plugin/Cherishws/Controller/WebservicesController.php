<?php
App::uses('CherishwsAppController', 'Cherishws.Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WebservicesController extends CherishwsAppController {

  /**
   * Components
   *
   * @var array
   */
    public $components = array('Paginator', 'Session', 'Image', 'Mpdf');
    public $uses = array('Shoppingcart', 'Product','Productimage','Order','Discounthistory', 'User', 'Whislist','Category','Productgemstone', 'Productdiamond', 'Gemstone', 'Clarity', 'Color', 'Price', 'Metalcolor', 'Metal', 'Diamond', 'Shape', 'Product', 'Vendorcontact', 'Vendor', 'Category', 'Subcategory', 'Productstone', 'Productimage', 'Size',
        'Metalcolor', 'Metal', 'Diamond', 'Clarity', 'Color', 'Carat', 'Shape', 'Settingtype', 'Purity', 'Productmetal', 'Referral', 'RelationshipManager','CustomerBGP',
        'Productgemstone', 'Productdiamond', 'Gemstone', 'Price', 'Collectiontype', 'Order', 'Franchiseebrokerage','PaymentMaster', 'Menu', 'Rating', 'Staticpage', 'States', 'Cities', 'Contactus', 'Emailcontent', 'Discount', 'Jewellrequest', 'Jewelldiamond', 'Jewellstone', 'Paymentdetails', 'Adminuser');
  
  /** 
    *  Add or Update Cart
    **/
  
  public function manageCart(){
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['product_id']) || empty($_REQUEST['customid']) || empty($_REQUEST['quantity']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $product_id = $_REQUEST['product_id'];
        $quantity = $_REQUEST['quantity'];
        $user_id = $_REQUEST['user_id'];
        
        if ($_REQUEST['cart_session'] == '') 
        {
          $this->Session->write('cart_process');
          $cart_session = $this->str_rand(15);
        } 
        else 
        {
          $cart_session = $_REQUEST['cart_session'];
        }
        
        
        $carts = $this->Shoppingcart->find('first', array('conditions' => array('product_id' => $product_id,'user_id'=>$user_id,'order_status_id'=>1),'order' => array('Shoppingcart.cart_id' => 'desc')));
        
        if(!empty($carts) && !empty($carts['Shoppingcart']['order_id']))
        {
          $order_status = $this->Order->find('first',array('conditions'=>array('order_id'=>$carts['Shoppingcart']['order_id'],'order_status_id != ' => 1)));
          
          if(!empty($order_status))
          {
            $carts = '';
          }
        }
        
        if (empty($carts)) 
        {
          $product_id = $_REQUEST['product_id'];
          $customid = $_REQUEST['customid'];
          $user_id = $_REQUEST['user_id'];

          if(isset($_REQUEST['color']))
          {
            $color = $_REQUEST['color'];
          }

          if(isset($_REQUEST['size']))
          {
            $size = $_REQUEST['size'];
          }

          $product = $this->Product->find('first', array('conditions' => array('product_id' => $product_id)));
          $category = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
          $product_code = $category['Category']['category_code'].$product['Product']['product_code'];
          $productid = $product['Product']['product_id'];

          if(!empty($color))
          {
            $gcolor = $color;
          }
          else if(!empty($product['Product']['stone_color_id']))
          {
            $colors = $this->Color->find('first', array('conditions' => array('color_id' => $product['Product']['stone_color_id'])));
            $customid = $product['Product']['metal_purity']."K".$colors['Color']['clarity']."-".$colors['Color']['color'];
            $gcolor = $product['Product']['metal_color'];
            $product_code .= " - ".str_replace("-","",$customid);
          }
          else
          {
            $customid = $product['Product']['metal_purity']."K";
            $gcolor = $product['Product']['metal_color'];
          }

          //gold
          $propurity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
          $material = explode("K", $customid);

          $size_data = $this->Size->find('first', array('conditions' => array('goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active')));

          if(!empty($size_data))
          {
            $size = 9;
          }

          if ($product['Product']['stone'] == 'Yes') 
          {
            $diamond = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('diamonddetails', $diamond);
          }

          if ($product['Product']['gemstone'] == 'Yes') 
          {
            $gemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('sgemstone', $gemstone);
          }

          if (!empty($size)) 
          {
            $product_wt = $product['Product']['metal_weight'];
            if ($category['Category']['category'] != "Bangles") {
              $t = '1';
            } else {
              $t = '0.125';
            }

            $minsize = $this->Productmetal->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
            $minsizenew = $minsize[0]['minsizes'];
            if ($size == $minsizenew) {
              $add_wt = 0;
            } else {
              $nsize = $this->Size->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

              $add_wt = $nsize[0]['tot_wt'];
            }
            $tot_weight = $product_wt + $add_wt;
          } 
          else 
          {
            $tot_weight = $product['Product']['metal_weight'];
          }

          if (!empty($gcolor)) {
            $mcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
            //modified by prakash
            $goldprice = $this->Price->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
            // echo $goldprice['Price']['price'];
            // exit;
            $gprice = !empty($goldprice['Price']['price']) ? $goldprice['Price']['price'] : 0;

            $gold_price = round(round($gprice * ($material[0] / 24)) * $tot_weight);
          //            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
            $purity = $material[0];
            $making_charge = $product['Product']['making_charge'];
          } else {
            $gold_price = '0';
            $making_charge = '0';
            $purity = '';
          }

          //diamond
          if (!empty($material[1])) {
            list($clarity, $color) = explode("-", $material[1]);
            $stone_price = '0';
            $diamond_wt = '0';
            $stone_details = $this->Productdiamond->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
            $clarities = $this->Clarity->find('first', array('conditions' => array('clarity' => $clarity)));
            $colors = $this->Color->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
            $stoneprice = $this->Price->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
            $stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight'], 0, PHP_ROUND_HALF_DOWN);
            $diamond_wt = $stone_details['0']['sweight'] / 5;
            $all_stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

          } else {
            $clarity = $color = '';
            $stone_price = '0';
            $diamond_wt = '0';
          }

          //gemstone
          if (!empty($gemstone)) {
            $gemprice = 0;
            $gemstone_wt = 0;
            foreach ($gemstone as $gemstones) {
              $stone = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
              $stone_shape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
              $prices = $this->Price->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
              $gemprice+=round($prices['Price']['price'] * $gemstones['Productgemstone']['stone_weight']);
              $gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
            }
          } else {
            $gemprice = '0';
            $gemstone_wt = '';
          }

          $sub_total = $gold_price + $stone_price + $gemprice;
          $making = 0;
          //addded by prakash
          if ($product['Product']['making_charge_calc'] == 'PER') {
            $making = round($gold_price * ($making_charge / 100), 0, PHP_ROUND_HALF_DOWN);
          } elseif ($product['Product']['making_charge_calc'] == 'INR') {
            $making = $making_charge;
          }
          $making = floatval($making);
          $vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100), 0, PHP_ROUND_HALF_DOWN);
          $total = $sub_total + $making + $vat;

          $total_weight = $tot_weight + $diamond_wt + $gemstone_wt;


          // echo $product_id." ".$product['Product']['metal']." ".$purity." ".$size." ".$clarity." ".$color." ".$product['Product']['metal_color']." ".$tot_weight." ".$quantity." ".$gold_price." ".$stone_price." ".$gemprice." ".$making." ".$vat;
          // // echo $gold_price." gold price ".$stone_price." stone price ".$total." sub total ".$sub_total." making ".$making;
          // exit;
          $vat_per = ($product['Product']['vat_cst'] / 100);
          
          $this->request->data['Shoppingcart']['cart_session'] = $cart_session;
          
          if(!empty($_REQUEST['order_id']))
          {
            $this->request->data['Shoppingcart']['order_id'] = $_REQUEST['order_id'];
          }
          
          $this->request->data['Shoppingcart']['product_id'] = $product_id;
          $this->request->data['Shoppingcart']['metal'] = $product['Product']['metal'];
          $this->request->data['Shoppingcart']['purity'] = $purity;
          $this->request->data['Shoppingcart']['size'] = $size;
          $this->request->data['Shoppingcart']['clarity'] = $clarity;
          $this->request->data['Shoppingcart']['color'] = $color;
          $this->request->data['Shoppingcart']['metalcolor'] = $product['Product']['metal_color'];
          $this->request->data['Shoppingcart']['weight'] = $tot_weight;
          $this->request->data['Shoppingcart']['quantity'] = $quantity;
          $this->request->data['Shoppingcart']['vat_per'] = $vat_per;
          $this->request->data['Shoppingcart']['vat'] = $vat;
          $this->request->data['Shoppingcart']['making_per'] = ($making_charge / 100);
          $this->request->data['Shoppingcart']['making_charge'] = $making;
          $this->request->data['Shoppingcart']['goldprice'] = $gprice;
          $this->request->data['Shoppingcart']['goldamount'] = $gold_price;
          $this->request->data['Shoppingcart']['stoneprice'] = (!empty($stoneprice['Price']['price']))?$stoneprice['Price']['price']:'';
          $this->request->data['Shoppingcart']['stoneamount'] = $stone_price;
          $this->request->data['Shoppingcart']['gemstoneamount'] = $gemprice;
          $this->request->data['Shoppingcart']['no_of_diamond'] = (!empty($_REQUEST['no_of_diamond']))?str_replace(",", '', $_REQUEST['no_of_diamond']):'';
          $this->request->data['Shoppingcart']['total'] = $total;
          $this->request->data['Shoppingcart']['user_id'] = $user_id;
          $this->request->data['Shoppingcart']['order_status_id'] = 1;
          $this->request->data['Shoppingcart']['created_date'] = date('Y-m-d H:i:s');
          
          $this->Shoppingcart->save($this->request->data);
        } 
        else 
        {
          // $this->request->data['Shoppingcart']['cart_id'] = $carts['Shoppingcart']['cart_id'];
          // $carts['Shoppingcart']['quantity'] = ($carts['Shoppingcart']['quantity']+$_REQUEST['quantity']);
          $carts['Shoppingcart']['quantity'] = $_REQUEST['quantity'];
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
        
        $resp_arr = array('code'=>'200','success'=>'Cart updated successfully','error'=>false,'data'=>array('cart_session'=>$cart_session));
      }
    }
    
    $this->apiResponse($resp_arr);
    }
  
  /**
    Get Cart Items
  */
  
  public function getCart()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $cart_product['sub_total'] = 0;
        $cart_product['vat'] = 0;
        $cart_product['total'] = 0;
        $cart_product['total_quantity'] = 0;
        $cart_session = $_REQUEST['cart_session'];
        $user_id = $_REQUEST['user_id'];
        
        if(empty($_REQUEST['product_id']))
        {
          $cart_item = $this->Shoppingcart->find('all', array('conditions' => array('user_id' => $user_id)));
        }
        else
        {
          $cart_item = $this->Shoppingcart->find('all', array('conditions' => array('user_id' => $user_id,'product_id'=>$_REQUEST['product_id'])));
        }
          
        if(!empty($cart_item))
        {
          $flag = false;
          $i = 0;
          foreach($cart_item as $cart)
          {
            if(!empty($cart['Shoppingcart']['order_id']))
            {
              $order_data = $this->Order->find('first',array('conditions'=>array('order_id'=>$cart['Shoppingcart']['order_id'],'order_status_id'=>1)));
              
              if(!empty($order_data))
              {
                $flag = true;
              }
            }
            else
            {
              $flag = true;
            }
            
            if($flag==true && !empty($cart['Shoppingcart']['product_id']))
            {
              $product_images = $this->Productimage->find('first',array('conditions' =>array('product_id' => $cart['Shoppingcart']['product_id'])));
              $product_data = $this->Product->find('first',array('conditions' =>array('product_id' => $cart['Shoppingcart']['product_id'])));
              $category = $this->Category->find('first', array('conditions' => array('category_id' => $product_data['Product']['category_id'])));
              
              $product_code = $category['Category']['category_code'].$product_data['Product']['product_code'];
              
              if(!empty($product_data['Product']['stone_color_id']))
              {
                $colors = $this->Color->find('first', array('conditions' => array('color_id' => $product_data['Product']['stone_color_id'])));
                $customid = $product_data['Product']['metal_purity']."K".$colors['Color']['clarity']."-".$colors['Color']['color'];
                $product_code .= " - ".str_replace("-","",$customid);
              }
              else
              {
                $customid = $product_data['Product']['metal_purity']."K";
                $product_code .= " - ".str_replace("-","",$customid);
              }
              
              $color = explode(",",$product_data['Product']['metal_color']);
              
              if(!empty($color))
              {
                $color_arr = array();
                
                foreach($color as $val)
                {
                  if($val==$cart['Shoppingcart']['metalcolor'])
                  {
                    $color_arr[$val] = true;
                    $color_arr['selected_color'] = $val;
                  }
                  else
                  {
                    $color_arr[$val] = false;
                  }
                }
              }
              
              $size = $this->Size->find('all',array('conditions'=>array('category_id='.$category['Category']['category_id']),'order'=>'size_value asc'));
              
              if(!empty($size))
              {
                $size_arr = array();
                $size_value = array();
                
                foreach($size as $val)
                {
                  if($val['Size']['size']==$cart['Shoppingcart']['size'])
                  {
                    $size_arr[$val['Size']['size']] = true;
                    $size_arr['selected_size'] = $val['Size']['size'];
                  }
                  else
                  {
                    $size_arr[$val['Size']['size']] = false;
                  }
                }
              }
              
              $cart_product['item'][$i]['product_id'] = $cart['Shoppingcart']['product_id'];
              $cart_product['item'][$i]['product_name'] = $product_data['Product']['product_name'];
              $cart_product['item'][$i]['product_code'] = $product_code;
              $cart_product['item'][$i]['color'][] = $color_arr;
              $cart_product['item'][$i]['size'][] = $size_arr;
              $cart_product['item'][$i]['customid'] = $customid;
              $cart_product['item'][$i]['price'] = $cart['Shoppingcart']['total'];
              $cart_product['item'][$i]['quantity'] = $cart['Shoppingcart']['quantity'];
              $cart_product['item'][$i]['img'] = 'http://shagunn.in/img/product/small/'.$product_images['Productimage']['imagename'];
              $cart_product['sub_total'] += ($cart['Shoppingcart']['total']*$cart['Shoppingcart']['quantity']);
              $cart_product['total_quantity'] += $cart['Shoppingcart']['quantity'];
              $cart_product['vat'] += $cart['Shoppingcart']['vat'];
              $i++;
              $flag = false;
            }
          }
        }
        
        $cart_product['total'] += ($cart_product['sub_total']+$cart_product['vat']);
        $cart_product['cart_total'] = $cart_product['total_quantity'].' item(s) - Rs. '.$cart_product['total'];
        
        if(!empty($cart_product['item']))
        {
          $resp_arr = array('code'=>'200','success'=>'Cart item found successfully','error'=>false,'data'=>$cart_product);
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'shopping cart is empty','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  /**
    Remove Cart Items
  */
  
  public function removeCart()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>400,'success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['product_id']))
      {
        $resp_arr = array('code'=>400,'success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $product_id = $_REQUEST['product_id'];
        
        $cart = $this->Shoppingcart->find('first', array('conditions' => array('product_id' => $product_id, 'user_id' => $user_id)));
        $this->Shoppingcart->delete(array('cart_id' => $cart['Shoppingcart']['cart_id']));
        $resp_arr = array('code'=>200,'success'=>'product removed from cart successfully','error'=>false,'data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  /**
    Add Items To Users Whishlist
  */
  
  public function addToWishlist()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['product_id']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $product_id = $_REQUEST['product_id'];
        
        if(!empty($_REQUEST['custom_id']))
        {
          $custom_id = $_REQUEST['custom_id'];
        }
        else
        {
          $custom_id = '';
        }
        
        if(!empty($_REQUEST['gcolor']))
        {
          $gcolor = $_REQUEST['gcolor'];
        }
        else
        {
          $gcolor = '';
        }
        
        if(!empty($_REQUEST['size']))
        {
          $size = $_REQUEST['size'];
        }
        else
        {
          $size = '';
        }
        
        $whishlist = $this->Whislist->find('first', array('conditions' => array('product_id' => $product_id, 'user_id' => $user_id, 'status' => 'Active')));
        
        if(!empty($whishlist))
        {
          $resp_arr = array('code'=>400,'success'=>false,'error'=>'product already exist in whishlist','data'=>null);
        }
        else
        {
          $product_images = $this->Productimage->find('first',array('conditions' =>array('product_id' => $product_id)));
          $this->request->data['Whislist']['image_id'] = $product_images['Productimage']['image_id'];
          $this->request->data['Whislist']['user_id'] = $user_id;
          $this->request->data['Whislist']['user_id'] = $user_id;
          $this->request->data['Whislist']['product_id'] = $product_id;
          $this->request->data['Whislist']['custom_id'] = $custom_id;
          $this->request->data['Whislist']['gcolor'] = $gcolor;
          $this->request->data['Whislist']['size'] = $size;
          $this->request->data['Whislist']['status'] = 'Active';
          $this->Whislist->save($this->request->data);
          $resp_arr = array('code'=>200,'success'=>'product added to wishlist successfully','error'=>null,'data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  /**
    Get Items From Users Whishlist
  */
  
  public function getWishlist()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        
        $whishlist = $this->Whislist->find('all', array('conditions' => array('user_id' => $user_id, 'status' => 'Active')));
        
        if(empty($whishlist))
        {
          $resp_arr = array('success'=>true,'error'=>'whishlist is empty','data'=>null);
        }
        else
        {
          $i = 0;
          
          foreach($whishlist as $item)
          {
            $product = $this->Product->find('first', array('conditions' => array('product_id' => $item['Whislist']['product_id'])));
            $category = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
            $product_code = $category['Category']['category_code'].$product['Product']['product_code'];
            $productid = $product['Product']['product_id'];
            
            if(!empty($product['Product']['stone_color_id']))
            {
              $colors = $this->Color->find('first', array('conditions' => array('color_id' => $product['Product']['stone_color_id'])));
              $customid = $product['Product']['metal_purity']."K".$colors['Color']['clarity']."-".$colors['Color']['color'];
              $gcolor = $product['Product']['metal_color'];
              $product_code .= " - ".str_replace("-","",$customid);
            }
            else
            {
              $customid = $product['Product']['metal_purity']."K";
              $gcolor = $product['Product']['metal_color'];
            }
            
            // echo $customid;
            // exit;
            
            //gold
            $propurity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
            $material = explode("K", $customid);
            
            $size_data = $this->Size->find('first', array('conditions' => array('goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active')));
            
            if(!empty($size_data))
            {
              $size = 9;
            }
            
            if ($product['Product']['stone'] == 'Yes') 
            {
              $diamond = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productid)));
              $this->set('diamonddetails', $diamond);
            }
            
            if ($product['Product']['gemstone'] == 'Yes') 
            {
              $gemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productid)));
              $this->set('sgemstone', $gemstone);
            }
            
            if (!empty($size)) 
            {
              $product_wt = $product['Product']['metal_weight'];
              if ($category['Category']['category'] != "Bangles") {
                $t = '1';
              } else {
                $t = '0.125';
              }

              $minsize = $this->Productmetal->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
              $minsizenew = $minsize[0]['minsizes'];
              if ($size == $minsizenew) {
                $add_wt = 0;
              } else {
                $nsize = $this->Size->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

                $add_wt = $nsize[0]['tot_wt'];
              }
              $tot_weight = $product_wt + $add_wt;
            } 
            else 
            {
              $tot_weight = $product['Product']['metal_weight'];
            }

            if (!empty($gcolor)) {
              $mcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
              //modified by prakash
              $goldprice = $this->Price->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
              // echo $goldprice['Price']['price'];
              // exit;
              $gprice = !empty($goldprice['Price']['price']) ? $goldprice['Price']['price'] : 0;

              $gold_price = round(round($gprice * ($material[0] / 24)) * $tot_weight);
        //            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
              $purity = $material[0];
              $making_charge = $product['Product']['making_charge'];
            } else {
              $gold_price = '0';
              $making_charge = '0';
              $purity = '';
            }

            //diamond
            if (!empty($material[1])) {
              list($clarity, $color) = explode("-", $material[1]);
              $stone_price = '0';
              $diamond_wt = '0';
              $stone_details = $this->Productdiamond->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
              $clarities = $this->Clarity->find('first', array('conditions' => array('clarity' => $clarity)));
              $colors = $this->Color->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
              $stoneprice = $this->Price->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
              $stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight'], 0, PHP_ROUND_HALF_DOWN);
              $diamond_wt = $stone_details['0']['sweight'] / 5;
              $all_stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

            } else {
              $clarity = $color = '';
              $stone_price = '0';
              $diamond_wt = '0';
            }

            //gemstone
            if (!empty($gemstone)) {
              $gemprice = 0;
              $gemstone_wt = 0;
              foreach ($gemstone as $gemstones) {
                $stone = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
                $stone_shape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
                $prices = $this->Price->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
                $gemprice+=round($prices['Price']['price'] * $gemstones['Productgemstone']['stone_weight']);
                $gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
              }
            } else {
              $gemprice = '0';
              $gemstone_wt = '';
            }

            $sub_total = $gold_price + $stone_price + $gemprice;
            $making = 0;
            //addded by prakash
            if ($product['Product']['making_charge_calc'] == 'PER') {
              $making = round($gold_price * ($making_charge / 100), 0, PHP_ROUND_HALF_DOWN);
            } elseif ($product['Product']['making_charge_calc'] == 'INR') {
              $making = $making_charge;
            }
            $making = floatval($making);
            $vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100), 0, PHP_ROUND_HALF_DOWN);
            $total = $sub_total + $making + $vat;

            $total_weight = $tot_weight + $diamond_wt + $gemstone_wt;
            // echo $gold_price." gold ".$stone_price." diamond ".$sub_total." subtotal ".$making." making ".$vat." vat ";
            // echo $gold_price." G ".$stone_price." S ".$gemprice$total." G ".$total_weight." t ";
            // echo "<pre>";
            // print_r($product);
            // print_r($category);
            // exit;
          

          
            
            if(!empty($product))
            {
              $whish_list['item'][$i]['product_id'] = $product['Product']['product_id'];
              $whish_list['item'][$i]['product_name'] = $product['Product']['product_name'];
              $whish_list['item'][$i]['product_code'] = $product_code;
              $whish_list['item'][$i]['product_price'] = $total;
              $whish_list['item'][$i]['custom_id'] = $item['Whislist']['custom_id'];
              $whish_list['item'][$i]['gcolor'] = $item['Whislist']['gcolor'];
              $whish_list['item'][$i]['size'] = $item['Whislist']['size'];
            }
            
            $product_image = $this->Productimage->find('first', array('conditions' => array('product_id' => $item['Whislist']['product_id'])));
            
            if(!empty($product_image))
            {
              $whish_list['item'][$i]['product_image'] = 'http://shagunn.in/img/product/small/'.$product_image['Productimage']['imagename'];
            }
            
            $i++;
          }
          
          $resp_arr = array('success'=>true,'error'=>null,'data'=>$whish_list);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  /**
    Remove Items From Users Whishlist
  */
  
  public function removeFromWishlist()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>400,'success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['product_id']))
      {
        $resp_arr = array('code'=>400,'success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $product_id = $_REQUEST['product_id'];
        
        $whishlist = $this->Whislist->find('first', array('conditions' => array('product_id' => $product_id, 'user_id' => $user_id, 'status' => 'Active')));
        
        if(empty($whishlist))
        {
          $resp_arr = array('code'=>400,'success'=>true,'error'=>'product not exist in whishlist','data'=>null);
        }
        else
        {
          $whishlist['Whislist']['status'] = 'Trash';
          $this->Whislist->save($whishlist);
          $resp_arr = array('code'=>200,'success'=>'product removed from wishlist successfully','error'=>null,'data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function goldPrice()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['metalcolor_id']) || empty($_REQUEST['metal_fineness']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $metalcolor_id = $_REQUEST['metalcolor_id'];
        $metal_fineness = $_REQUEST['metal_fineness'];
        $goldprice = $this->Price->find('all', array('select'=>'price','conditions' => array('metal_id' => '1'),'order'=>'modify_date desc','limit'=>'2'));
        
        if(!empty($goldprice[0]['Price']['price']) && !empty($goldprice[1]['Price']['price']))
        {
          if($goldprice[0]['Price']['price']>$goldprice[1]['Price']['price'])
          {
            $difference = ($goldprice[0]['Price']['price']-$goldprice[1]['Price']['price']);
            $indicate = 'increase';
          }
          else if($goldprice[0]['Price']['price']<$goldprice[1]['Price']['price'])
          {
            $difference = ($goldprice[1]['Price']['price']-$goldprice[0]['Price']['price']);
            $indicate = 'decrease';
          }
          else
          {
            $difference = ($goldprice[0]['Price']['price']-$goldprice[1]['Price']['price']);
            $indicate = 'equal';
          }
          
          $percentage = round((($difference/$goldprice[1]['Price']['price'])*100),2);
        }
        
        $gprice = (!empty($goldprice[0]['Price']['price'])) ? $goldprice[0]['Price']['price'] : 0;
        $resp_arr = array('code'=>'200','success'=>'Gold Price get successfully','error'=>null,'data'=>array('gold_price'=>$gprice,'date'=>date('l,d M Y'),'caret'=>'22','difference'=>$difference,'indicate'=>$indicate,'per_difference'=>$percentage));
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function addReview()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['email']) || empty($_REQUEST['review']) || empty($_REQUEST['rating']) || empty($_REQUEST['product_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $email = $_REQUEST['email'];
        $review = $_REQUEST['review'];
        $rating = $_REQUEST['rating'];
        $product_id = $_REQUEST['product_id'];
        
        $this->Rating->deleteAll(array('email'=>$email));
        
        if(!empty($_REQUEST['name']))
        {
          $name = $_REQUEST['name'];
        }
        else
        {
          $name = '';
        }
        
        if(!empty($_REQUEST['title']))
        {
          $title = $_REQUEST['title'];
        }
        else
        {
          $title = '';
        }
        
        $this->request->data['Rating']['product_id'] = $product_id;
        $this->request->data['Rating']['name'] = $name;
        $this->request->data['Rating']['title'] = $title;
        $this->request->data['Rating']['email'] = $email;
        $this->request->data['Rating']['comments'] = $review;
        $this->request->data['Rating']['rate'] = $rating;
        $this->Rating->save($this->request->data);
        $resp_arr = array('code'=>'200','success'=>'Review added successfully','error'=>false,'data'=>array('msg'=>'Your review send successfully'));
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getReview()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['product_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $rating_data = $this->Rating->find('all',array('conditions'=>array('product_id'=>$_REQUEST['product_id'])));
        
        if(!empty($rating_data))
        {
          $i = 0;
          $rating_sum = 0;
          $one_rating_count = 0;
          $two_rating_count = 0;
          $three_rating_count = 0;
          $four_rating_count = 0;
          $five_rating_count = 0;
          
          foreach($rating_data as $rating)
          {
            switch($rating['Rating']['rate'])
            {
              case 1: $one_rating_count++;
                      break;
              case 2: $two_rating_count++;
                      break;
              case 3: $three_rating_count++;
                      break;
              case 4: $four_rating_count++;
                      break;
              case 5: $five_rating_count++;
                      break;
            }
            
            $rating_sum += $rating['Rating']['rate'];
            $item[$i]['title'] = $rating['Rating']['title'];
            $item[$i]['name'] = $rating['Rating']['name'];
            $item[$i]['email'] = $rating['Rating']['email'];
            $item[$i]['comments'] = $rating['Rating']['comments'];
            $item[$i]['rate'] = $rating['Rating']['rate'];
            $item[$i]['created_date'] = $rating['Rating']['created_date'];
            $i++;
          }
          
          $rating['item'] = $item;
          $rating['rating_count'] = ($rating_sum/$i);
          $rating['review_count'] = $i;
          $rating['one_rating_count'] = $one_rating_count;
          $rating['two_rating_count'] = $two_rating_count;
          $rating['three_rating_count'] = $three_rating_count;
          $rating['four_rating_count'] = $four_rating_count;
          $rating['five_rating_count'] = $five_rating_count;
          $rating['total_rating'] = $i;
          
          $resp_arr = array('code'=>'200','success'=>'Review get successfully','error'=>false,'data'=>array('rating'=>$rating));
        } 
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getPages()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['link']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $content = $this->Staticpage->find('first', array('conditions' => array('link' => $_REQUEST['link'])));

        $data['title'] = $content['Staticpage']['meta_title'];
        $data['metakeyword'] = $content['Staticpage']['meta_keyword'];
        $data['metadescription'] = $content['Staticpage']['meta_description'];
        $data['static'] = $content['Staticpage']['pagecontent'];
        
        $resp_arr = array('code'=>'200','success'=>'Page content found successfully','error'=>null,'data'=>array('content'=>$data));
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getState()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      $state = $this->States->find('all');
      
      if(!empty($state))
      {
        $i = 0;
        foreach($state as $states)
        {
          $data[$i]['state_id'] = $states['States']['state_id'];
          $data[$i]['state'] = $states['States']['state'];
          $i++;
        }
        
        $resp_arr = array('code'=>'200','success'=>'state get successfully','error'=>false,'data'=>array('state'=>$data));
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getCity()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['state_id']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $state_id = $_REQUEST['state_id'];
        $cities = $this->Cities->find('all',array('conditions'=>array('state_id'=>$state_id)));
        
        if(!empty($cities))
        {
          $i = 0;
          foreach($cities as $city)
          {
            $data[$i]['city_id'] = $city['Cities']['city_id'];
            $data[$i]['city'] = $city['Cities']['city'];
            $i++;
          }
          
          $resp_arr = array('success'=>true,'error'=>null,'data'=>array('city'=>$data));
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getNearBy()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['state']) || empty($_REQUEST['city']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $state = $_REQUEST['state'];
        $city = $_REQUEST['city'];
        
        $search = array();
        $search = array('user_type' => '1', 'status !=' => 'Trash');
        $search['city LIKE'] = '%' . $city . '%';
        $search['state LIKE'] = '%' . $state . '%';
        
        $user_data = $this->User->find('all',array('conditions'=>$search));
        
        if(!empty($user_data))
        {
          $i = 0;
          
          foreach($user_data as $franchisee)
          {
            if(!empty($franchisee['User']['map_address']))
            {
              $lat_lon = explode("@",$franchisee['User']['map_address']);
              $lat_lon_arr = explode(",",$lat_lon[1]);
              $lat = $lat_lon_arr[0];
              $lon = $lat_lon_arr[1];
            }
            $data[$i]['name'] = $franchisee['User']['fullname'];
            $data[$i]['email'] = $franchisee['User']['email'];
            $data[$i]['franchisee_code'] = $franchisee['User']['franchisee_code'];
            $data[$i]['phone_no'] = $franchisee['User']['phone_no'];
            $data[$i]['mobile_no'] = $franchisee['User']['mobile_no'];
            $data[$i]['address'] = $franchisee['User']['address'];
            $data[$i]['city'] = $franchisee['User']['city'];
            $data[$i]['state'] = $franchisee['User']['state'];
            $data[$i]['pincode'] = $franchisee['User']['pincode'];
            $data[$i]['map_address'] = $franchisee['User']['map_address'];
            $data[$i]['map_address'] = $franchisee['User']['map_address'];
            $data[$i]['lat'] = $lat;
            $data[$i]['lon'] = $lon;
            $i++;
          }
          
          $resp_arr = array('code'=>'200','success'=>'Franchisee found successfully','error'=>false,'data'=>array('franchisee'=>$data));
        }
        else
        {
          $data = array();
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Franchisee found successfully','data'=>array('franchisee'=>$data));
        }
        
        
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function helpUs()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['first_name']) || empty($_REQUEST['email_id']))
      {
        $resp_arr = array('code'=>'400','success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $this->request->data['Contactus']['type'] = 'User';
        $this->request->data['Contactus']['name'] = $_REQUEST['first_name'];
        
        if(!empty($_REQUEST['last_name']))
        {
          $this->request->data['Contactus']['name'] .= " ".$_REQUEST['last_name'];
        }
        
        if(!empty($_REQUEST['mobile_no']))
        {
          $this->request->data['Contactus']['mobile'] = $_REQUEST['mobile_no'];
        }
        $this->request->data['Contactus']['email'] = $_REQUEST['email_id'];
        
        if(!empty($_REQUEST['message']))
        {
          $this->request->data['Contactus']['query'] = $_REQUEST['message'];
        }
        
        $this->Contactus->save($this->request->data);
        $emailcontent = $this->Emailcontent->find('first', array('conditions' => array('eid' => '7')));
        $to = $this->request->data['Contactus']['email'];
        $name = $this->request->data['Contactus']['name'];
        $message = str_replace(array('{name}'), array($name), $emailcontent['Emailcontent']['content']);
        $this->mailsend($emailcontent['Emailcontent']['fromname'], $emailcontent['Emailcontent']['fromemail'], $to, $emailcontent['Emailcontent']['subject'], $message);
        
        $resp_arr = array('code'=>'200','success'=>'Data submitted successfully','error'=>false,'data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function contactUs()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      $content = $this->Staticpage->find('first', array('conditions' => array('link' => 'contact-us')));
      $resp_arr = array('success'=>true,'error'=>null,'data'=>$content);
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getUserDetails()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user = $this->User->find('first', array('conditions' => array('user_id' => $_REQUEST['user_id'])));
        
        if(!empty($user))
        {
          $user_data['id'] = $user['User']['user_id'];
          $user_data['first_name'] = $user['User']['first_name'];
          $user_data['last_name'] = $user['User']['last_name'];
          $user_data['email'] = $user['User']['email'];
          $user_data['address'] = $user['User']['address'];
          $user_data['city'] = $user['User']['city'];
          $user_data['state'] = $user['User']['state'];
          $user_data['pincode'] = $user['User']['pincode'];
          
          if(!empty($user['User']['profile_pic']))
          {
            $user_data['profile_pic'] = $user['User']['profile_pic'];
          }
          else
          {
            $user_data['profile_pic'] = '';
          }
          
          $user_data['phone_no'] = $user['User']['phone_no'];
          $user_data['mobile_no'] = $user['User']['mobile_no'];
          $user_data['date_of_birth'] = $user['User']['date_of_birth'];
          $user_data['anniversary'] = $user['User']['anniversary'];
          
          $resp_arr = array('code'=>'200','success'=>'Users details get successfully','error'=>false,'data'=>$user_data);
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Users details not found','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function editUserDetails()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['name']) || empty($_REQUEST['mobile_no']) || empty($_REQUEST['email_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user = $this->User->find('first', array('conditions' => array('user_id' => $_REQUEST['user_id'])));
        
        if(!empty($user))
        {
          $this->request->data['User']['user_id'] = $_REQUEST['user_id'];
          $this->request->data['User']['first_name'] = $_REQUEST['name'];
          $this->request->data['User']['email'] = $_REQUEST['email_id'];
          $this->request->data['User']['phone_no'] = $_REQUEST['mobile_no'];
          $this->request->data['User']['mobile_no'] = $_REQUEST['mobile_no'];
          
          if(!empty($_REQUEST['password']))
          {
            $this->request->data['User']['password'] = $_REQUEST['password'];
          }
          
          
          if(!empty($_FILES['fileupload']))
          {
            $profile_pic = $this->Image->upload_image_and_thumbnail($_FILES['fileupload'], 400, 400, 150, 150, "profile_pic", '1');
            $this->request->data['User']['profile_pic'] = $_REQUEST['profile_pic'];
          }
          else
          {
            $profile_pic = $_REQUEST['profile_pic'];
            $this->request->data['User']['profile_pic'] = $_REQUEST['profile_pic'];
          }
          
          
          if($_REQUEST['title'])
          {
            $this->request->data['User']['title'] = $_REQUEST['title'];
          }
          
          if($_REQUEST['address'])
          {
            $this->request->data['User']['address'] = $_REQUEST['address'];
          }
          
          if($_REQUEST['city'])
          {
            $this->request->data['User']['city'] = $_REQUEST['city'];
          }
          
          if($_REQUEST['state'])
          {
            $this->request->data['User']['state'] = $_REQUEST['state'];
          }
          
          if($_REQUEST['pincode'])
          {
            $this->request->data['User']['pincode'] = $_REQUEST['pincode'];
          }
          
          if($_REQUEST['anniversary'])
          {
            $this->request->data['User']['anniversary'] = $_REQUEST['anniversary'];
          }
          
          if($_REQUEST['date_of_birth'])
          {
            $this->request->data['User']['date_of_birth'] = $_REQUEST['date_of_birth'];
          }
          
          $this->User->save($this->request->data);
          
          $user_data['name'] = $_REQUEST['name'];
          $user_data['email_id'] = $_REQUEST['email_id'];
          $user_data['mobile_no'] = $_REQUEST['mobile_no'];
          $user_data['password'] = $_REQUEST['password'];
          $user_data['address'] = $_REQUEST['address'];
          
          if(!empty($profile_pic))
          {
            $user_data['profile_pic'] = 'http://shagunn.in/img/profile_pic/small/'.$profile_pic;
          }
          
          
          $resp_arr = array('code'=>'200','success'=>'Users details updated successfully','error'=>false,'data'=>$user_data);
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Users details not found','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function editProfilePic()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user = $this->User->find('first', array('conditions' => array('user_id' => $_REQUEST['user_id'])));
        
        if(!empty($user))
        {
          $this->request->data['User']['user_id'] = $_REQUEST['user_id'];
          // $this->request->data['User']['first_name'] = $_REQUEST['name'];
          // $this->request->data['User']['email'] = $_REQUEST['email_id'];
          // $this->request->data['User']['mobile_no'] = $_REQUEST['mobile_no'];
          
          if(!empty($_REQUEST['password']))
          {
            $this->request->data['User']['password'] = $_REQUEST['password'];
          }
          
          if(!empty($_FILES['profile_pic']))
          {
            $profile_pic = $this->Image->upload_image_and_thumbnail($_FILES['profile_pic'], 400, 400, 150, 150, "profile_pic", '1');
          }
          else
          {
            $profile_pic = $user['User']['profile_pic'];
          }
          
          
          if($_REQUEST['title'])
          {
            $this->request->data['User']['title'] = $_REQUEST['title'];
          }
          
          if($_REQUEST['address'])
          {
            $this->request->data['User']['address'] = $_REQUEST['address'];
          }
          
          if($_REQUEST['city'])
          {
            $this->request->data['User']['city'] = $_REQUEST['city'];
          }
          
          if($_REQUEST['state'])
          {
            $this->request->data['User']['state'] = $_REQUEST['state'];
          }
          
          if($_REQUEST['pincode'])
          {
            $this->request->data['User']['pincode'] = $_REQUEST['pincode'];
          }
          
          if($_REQUEST['anniversary'])
          {
            $this->request->data['User']['anniversary'] = $_REQUEST['anniversary'];
          }
          
          if($_REQUEST['date_of_birth'])
          {
            $this->request->data['User']['date_of_birth'] = $_REQUEST['date_of_birth'];
          }
          
          $this->User->save($this->request->data);
          
          $user_data['name'] = $_REQUEST['name'];
          $user_data['email_id'] = $_REQUEST['email_id'];
          $user_data['mobile_no'] = $_REQUEST['mobile_no'];
          $user_data['password'] = $_REQUEST['password'];
          $user_data['address'] = $_REQUEST['address'];
          
          if(!empty($profile_pic))
          {
            $user_data['profile_pic'] = 'http://shagunn.in/cakephp_api/img/profile_pic/small/'.$profile_pic;
          }
          
          $resp_arr = array('code'=>'200','success'=>'Users details updated successfully','error'=>false,'data'=>$user_data);
          // $resp_arr = array('code'=>'200','success'=>'Users details updated successfully','error'=>false,'data'=>$user_data);
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Users details not found','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getShippingDetails()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        if(empty($_REQUEST['order_id']))
        {
          $user = $this->User->find('first', array('conditions' => array('user_id' => $_REQUEST['user_id'])));
        
          if(!empty($user))
          {
            // $user_data['id'] = $user['User']['user_id'];
            // $user_data['first_name'] = $user['User']['first_name'];
            // $user_data['last_name'] = $user['User']['last_name'];
            // $user_data['email'] = $user['User']['email'];
            // $user_data['address'] = $user['User']['address'];
            // $user_data['city'] = $user['User']['city'];
            // $user_data['state'] = $user['User']['state'];
            // $user_data['pincode'] = $user['User']['pincode'];
            // $user_data['mobile_no'] = $user['User']['mobile_no'];
            // $user_data['date_of_birth'] = $user['User']['date_of_birth'];
            
            $user_data['order_id'] = '';
            $user_data['name'] = $user['User']['first_name'].' '.$user['User']['last_name'];
            $user_data['email_id'] = $user['User']['email'];
            $user_data['contact_no'] = $user['User']['mobile_no'];
            $user_data['address'] = $user['User']['address'];
            $user_data['landmark'] = '';
            $user_data['pincode'] = $user['User']['pincode'];
            $user_data['city'] = $user['User']['city'];
            $user_data['state'] = $user['User']['state'];
            
            $resp_arr = array('code'=>'200','success'=>'Users details get successfully','error'=>false,'data'=>$user_data);
          }
          else
          {
            $resp_arr = array('code'=>'400','success'=>false,'error'=>'Users details not found','data'=>null);
          }
        }
        else
        {
          $order = $this->Order->find('first', array('conditions' => array('order_id' => $_REQUEST['order_id'])));
          
          // echo "<pre>";
          // print_r($order);
          // exit;
          
          if(!empty($order))
          {
            $order_data['order_id'] = $order['Order']['order_id'];
            $order_data['name'] = $order['Order']['name'];
            $order_data['email_id'] = $order['Order']['email_id'];
            $order_data['contact_no'] = $order['Order']['contact_no'];
            $order_data['address'] = $order['Order']['shipping_add'];
            $order_data['landmark'] = $order['Order']['slandmark'];
            $order_data['pincode'] = $order['Order']['spincode'];
            $order_data['city'] = $order['Order']['scity'];
            $order_data['state'] = $order['Order']['sstate'];
            
            $resp_arr = array('code'=>'200','success'=>'Shipping details get successfully','error'=>false,'data'=>$order_data);
          }
          else
          {
            $resp_arr = array('code'=>'400','success'=>false,'error'=>'Shipping details not found','data'=>null);
          }
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function shippingDetails()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['name']) || empty($_REQUEST['email_id']) || empty($_REQUEST['contact_no']) || empty($_REQUEST['user_id']) || empty($_REQUEST['shipping_add']) || empty($_REQUEST['slandmark']) || empty($_REQUEST['spincode']) || empty($_REQUEST['scity']) || empty($_REQUEST['sstate']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $this->request->data['Order']['name'] = $_REQUEST['name'];
        $this->request->data['Order']['email_id'] = $_REQUEST['email_id'];
        $this->request->data['Order']['contact_no'] = $_REQUEST['contact_no'];
        $this->request->data['Order']['shipping_add'] = $_REQUEST['shipping_add'];
        $this->request->data['Order']['slandmark'] = $_REQUEST['slandmark'];
        $this->request->data['Order']['spincode'] = $_REQUEST['spincode'];
        $this->request->data['Order']['scity'] = $_REQUEST['scity'];
        $this->request->data['Order']['sstate'] = $_REQUEST['sstate'];
        $this->request->data['Order']['billing_add'] = $_REQUEST['shipping_add'];
        $this->request->data['Order']['blandmark'] = $_REQUEST['slandmark'];
        $this->request->data['Order']['pincode'] = $_REQUEST['spincode'];
        $this->request->data['Order']['city'] = $_REQUEST['scity'];
        $this->request->data['Order']['state'] = $_REQUEST['sstate'];
          
        if(!empty($_REQUEST['order_id'])) 
        {
          $order_id = $_REQUEST['order_id'];
          $check = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
          
          if (!empty($check)) 
          {
            $this->request->data['Order']['order_id'] = $check['Order']['order_id'];
            $this->request->data['Order']['user_id'] = $user_id;
            $this->Order->save($this->request->data);
            
            if(empty($_REQUEST['product_id']))
            {
              $shopping_data = $this->Shoppingcart->updateAll(array('Shoppingcart.order_id'=>$order_id),array('user_id'=>$user_id,'order_id'=>NULL));
            }
            else
            {
              $shopping_data = $this->Shoppingcart->updateAll(array('Shoppingcart.order_id'=>$order_id),array('user_id'=>$user_id,'product_id'=>$_REQUEST['product_id'],'order_id'=>NULL));
            }
          }
        } 
        else 
        {
          $this->request->data['Order']['user_id'] = $user_id;
          $invoice = $this->Order->find('first', array('fields' => array('MAX(Order.invoice) AS maxid', '*')));
          if (!empty($invoice[0]['maxid'])) 
          {
            $tiid = $invoice[0]['maxid'] + 1;
          } 
          else 
          {
            $tiid = 1;
          }
          $invoice_code = sprintf("%06d", $tiid);
          $this->request->data['Order']['invoice'] = $invoice_code;

          $this->request->data['Order']['created_date'] = date('Y-m-d H:i:s');
          $this->Order->save($this->request->data);
          $order_id = $this->Order->getLastInsertID();
          
          if(!empty($order_id))
          {
            if(empty($_REQUEST['product_id']))
            {
              $shopping_data = $this->Shoppingcart->updateAll(array('Shoppingcart.order_id'=>$order_id),array('user_id'=>$user_id,'order_id'=>NULL));
            }
            else
            {
              $shopping_data = $this->Shoppingcart->updateAll(array('Shoppingcart.order_id'=>$order_id),array('user_id'=>$user_id,'product_id'=>$_REQUEST['product_id'],'order_id'=>NULL));
            }
          }
        }
        
        $resp_arr = array('code'=>'200','success'=>'Shipping details saved successfully','error'=>false,'data'=>array('order_id'=>$order_id));
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getPartialAmount()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']) || empty($_REQUEST['order_id']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $order_id = $_REQUEST['order_id'];
        $total_amount = $this->Shoppingcart->find('first',array('fields'=>'sum(total) as total','conditions'=>array('user_id'=>$user_id,'order_id'=>$order_id)));
        
        if(!empty($total_amount[0]))
        {
          $partial_amount = round(($total_amount[0]['total']*30)/100);
        }
        
        if(!empty($partial_amount))
        {
          $resp_arr = array('code'=>'200','success'=>'Partial amount calculated successfully','error'=>false,'data'=>array('partial_amount'=>$partial_amount));
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Partial amount not found','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function setPartialPayment()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['order_id']) || empty($_REQUEST['partial_amount']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $order_id = $_REQUEST['order_id'];
        $partial_amount = $_REQUEST['partial_amount'];
        $order = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        
        if (!empty($order)) 
        {
          $this->request->data['Order']['order_id'] = $order['Order']['order_id'];
          $this->request->data['Order']['cod_status'] = 'PayU';
          $this->request->data['Order']['netpayamt'] = $partial_amount;
                    $this->Order->saveAll($this->request->data);
        
          $resp_arr = array('code'=>'200','success'=>'Partial amount updated successfully','error'=>false,'data'=>null);
        }
        else
        {
          $resp_arr = array('code'=>'200','success'=>false,'error'=>'Partial amount update unsuccessful','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function applyCoupen()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['order_id']) || empty($_REQUEST['user_id']) || empty($_REQUEST['coupen']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $coupen = $_REQUEST['coupen'];
        $order_id = $_REQUEST['order_id'];
        
        // $order = $this->Order->find('first', array('conditions' => array('order_id' => $order_id,'discount_amount'=>0))); for multiple apply
        $order = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        
        if(!empty($order))
        {
          $check_discount = $this->Discount->find('first', array('conditions'=>array('voucher_code="'.$coupen.'"')));
        
          // $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
          
          if (!empty($check_discount) && $check_discount['Discount']['start_date']<=date('Y-m-d') && $check_discount['Discount']['expired_date']>=date('Y-m-d')) 
          {
            // $already_used_or_not = $this->Discounthistory->find('first', array('conditions' => array('coupon_id' => $check_discount['Discount']['discount_id'], 'user_id' => $user_id)));
            $already_used_or_not = '';
            
            if (empty($already_used_or_not)) 
            {
              if ($check_discount['Discount']['type'] == "Vouchercode") 
              {
                $cart = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order_id), 'fields' => array('SUM(total*quantity) AS total')));
                
                if(empty($cart[0]['total']))
                {
                  $resp_arr = array('code'=>'400','success'=>false,'error'=>'Order not found','data'=>null);
                }
                else
                {
                  $order['Order']['order_id'] = $order_id;
                  
                  if ($check_discount['Discount']['per_amou'] == 1) 
                  {
                    $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                    $order['Order']['discount_amount'] = round($cart[0]['total'] * $check_discount['Discount']['percentage'] / 100);
                    $resp_per = $check_discount['Discount']['percentage'];
                    $resp_amount = $order['Order']['discount_amount'];
                  } 
                  else 
                  {
                    $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                    $resp_per = 'NA';
                    $resp_amount = $order['Order']['discount_amount'];
                  }
                  
                  $this->Order->save($order);
                }
              }
              else if ($check_discount['Discount']['type'] == "Product") 
              {
                $product_ids = explode(',', $check_discount['Discount']['product_id']);
                
                $cart = $this->Shoppingcart->find('first', array('conditions' => array('product_id' => $product_ids, 'order_id' => $order_id), 'fields' => array('SUM(total*quantity) AS total')));
                
                if(empty($cart[0]['total']))
                {
                  $resp_arr = array('code'=>'400','success'=>false,'error'=>'Order not found','data'=>null);
                }
                else
                {
                  if ($check_discount['Discount']['per_amou'] == 1) 
                  {
                    $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                    $order['Order']['discount_amount'] = round($cart['0']['total'] * $check_discount['Discount']['percentage'] / 100);
                    $resp_per = $order['Order']['discount_per'];
                    $resp_amount = $order['Order']['discount_amount'];
                  } 
                  else 
                  {
                    $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                    $resp_per = 'NA';
                    $resp_amount = $order['Order']['discount_amount'];
                  }
                  
                  $this->Order->save($order);
                }
              }
              elseif ($check_discount['Discount']['type'] == "User") 
              {
                if (!in_array($user_id, explode(",", $check_discount['Discount']['user_id']))) 
                {
                  $resp_arr = array('code'=>'400','success'=>false,'error'=>'User is not allowed to use this coupen','data'=>null);
                }
                else
                {
                  $cart = $this->Shoppingcart->find('first', array('conditions' => array('user_id' => $user_id, 'order_id' => $order_id), 'fields' => array('SUM(total*quantity) AS total')));
                  
                  if(empty($cart[0]['total']))
                  {
                    $resp_arr = array('code'=>'400','success'=>false,'error'=>'Order not found','data'=>null);
                  }
                  else
                  {
                    if ($check_discount['Discount']['per_amou'] == 1) 
                    {
                      $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                      $order['Order']['discount_amount'] = round($cart_amount[0]['subtotal'] * $check_discount['Discount']['percentage'] / 100);
                      $resp_per = $order['Order']['discount_per'];
                      $resp_amount = $order['Order']['discount_amount'];
                    } 
                    else 
                    {
                      $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                      $resp_per = 'NA';
                      $resp_amount = $order['Order']['discount_amount'];
                    }
                    
                    $this->Order->save($order);
                  }
                }
              }
              elseif ($check_discount['Discount']['type'] == "Category") 
              {
                $category_ids = explode(',', $check_discount['Discount']['category_id']);
                $cart = $this->Shoppingcart->find('first', array('conditions' => array('Product.category_id' => $category_ids), 'joins' =>
                  array(
                    array(
                      'table' => 'products',
                      'alias' => 'Product',
                      'type' => 'inner',
                      'foreignKey' => false,
                      'conditions' => array('Shoppingcart.product_id = Product.product_id')
                    )), 'fields' => array('SUM(total*quantity) AS total')));
                
                if (!empty($cart[0]['total'])) 
                {
                  if ($check_discount['Discount']['per_amou'] == 1) 
                  {
                    $order['Order']['discount_per'] = $check_discount['Discount']['percentage'];
                    $order['Order']['discount_amount'] = round($cart['0']['total'] * $check_discount['Discount']['percentage'] / 100);
                    $resp_per = $order['Order']['discount_per'];
                    $resp_amount = $order['Order']['discount_amount'];
                  } 
                  else 
                  {
                    $order['Order']['discount_amount'] = $check_discount['Discount']['percentage'];
                    $resp_per = 'NA';
                    $resp_amount = $order['Order']['discount_amount'];
                  }
                  $this->Order->save($order);
                } 
                else 
                {
                  $resp_arr = array('code'=>'400','success'=>false,'error'=>'Order not found','data'=>null);
                }
              }
              
              if(!empty($cart[0]['total']))
              {
                $this->request->data['Discounthistory']['user_id'] = $user_id;
                $this->request->data['Discounthistory']['coupon_id'] = $check_discount['Discount']['discount_id'];
                $this->request->data['Discounthistory']['order_id'] = $order_id;
                $this->request->data['Discounthistory']['date'] = date('Y-m-d H:i:s');
                $this->request->data['Discounthistory']['coupon_code'] = $check_discount['Discount']['voucher_code'];
                
                //added by prakash
                $this->request->data['Discounthistory']['Type'] = $check_discount['Discount']['type'];
                if ($check_discount['Discount']['per_amou'] == 1) 
                {
                  $this->request->data['Discounthistory']['percentage'] = $check_discount['Discount']['percentage'];
                  $this->request->data['Discounthistory']['amount'] = round($cart['0']['total'] * $check_discount['Discount']['percentage'] / 100);
                } 
                else 
                {
                  $this->request->data['Discounthistory']['amount'] = $check_discount['Discount']['percentage'];
                }
                
                $this->Discounthistory->save($this->request->data['Discounthistory']);
                $discount_history_id = $this->Discounthistory->getLastInsertID();
                
                $resp_arr = array('code'=>'200','success'=>'Coupen applied successfully','error'=>false,'data'=>array('id'=>$discount_history_id,'amount'=>$resp_amount,'percentage'=>$resp_per));
              }
            }
            else
            {
              $resp_arr = array('code'=>'400','success'=>false,'error'=>'Coupen code already used','data'=>null);
            }
          } 
          else 
          {
            $resp_arr = array('code'=>'400','success'=>false,'error'=>'Invalid or expired coupen code','data'=>null);
          }
        }
        else 
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Already applied coupen this order','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function completeOrder()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('code'=>'400','success'=>false,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['order_id']) || empty($_REQUEST['payment_status']) || empty($_REQUEST['amount']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $order_id = $_REQUEST['order_id'];
        $status = $_REQUEST['payment_status'];
        $natpayamt = $_REQUEST['amount'];
        $order1 = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
        
        
        $user = $this->User->find('first',array('conditions' => array('user_id' => $order1['Order']['user_id'])));
        $cart = $this->Shoppingcart->find('all',array('conditions' => array('order_id' => $order_id)));
        $order1['Order']['status'] = $status;
        $order1['Order']['natpayamt'] = $natpayamt;
        $order1['Order']['order_status_id'] = 2;
        
        $this->Order->save($order1);
        
        
        // $this->request->data['Paymentdetails']['order_id'] = $order1['Order']['order_id'];
        // $this->request->data['Paymentdetails']['user_id'] = $order1['Order']['user_id'];
        // $this->request->data['Paymentdetails']['status'] = 'Success';
        // $this->request->data['Paymentdetails']['admin_status'] = 'Order in Progress';
        // $this->request->data['Paymentdetails']['ip'] = $_SERVER['REMOTE_ADDR'];
        // $this->request->data['Paymentdetails']['amount'] = $natpayamt;
        // //$this->request->data['Paymentdetails']['created_date'] = date('Y-m-d H:i:s');
        
        // $this->Paymentdetails->save($this->request->data);
                  
                  
        // if ($user['User']['user_type'] == '0') 
        // {
          // if ($order1['Order']['cod_status'] == 'PayU') 
          // {
            // $in = 'SGN-ON-';
          // } elseif ($order1['Order']['cod_status'] == 'CHQ/DD') 
          // {
            // $in = 'SGN-CHQ/DD-';
          // } elseif ($order1['Order']['cod_status'] == 'COD') 
          // {
            // $in = 'SGN-CD-';
          // }
        // } 
        // else 
        // {
          // if ($order1['Order']['cod_status'] == 'PayU') 
          // {
            // $in = 'SGN-FN-';
          // } 
          // elseif ($order1['Order']['cod_status'] == 'COD') 
          // {
            // $in = 'SGN-FNCD-';
          // } 
          // elseif ($order1['Order']['cod_status'] == 'CHQ/DD') 
          // {
            // $in = 'SGN-FNCHQ/DD-';
          // }
        // }

        // $msg = '';
        // if (!empty($cart)) 
        // {
          // $msg = '<table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000; border-bottom:none;" width="100%">
            // <tr>
            // <th width="10" height="27" style="border-bottom:1px solid #000;border-right:1px solid #000; " >S.No</th>
            // <th style=" border-bottom:1px solid #000;border-right:1px solid #000; " >Product Code</th>
            // <th style="border-bottom:1px solid #000;border-right:1px solid #000; " >Product Description</th>
            // <th width="10" style="border-bottom:1px solid #000;border-right:1px solid #000; "  >Quantity</th>
            // <th style=" border-bottom:1px solid #000;" >Price</th>
            // </tr>';
          // $i = 1;
          // $productnames = '';
          // foreach ($cart as $carts) 
          // {
            // $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
            // $productdiamond = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'], 'clarity' => $carts['Shoppingcart']['clarity'], 'color' => $carts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));

            // $productgemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));

            // $product = $this->Product->find('first', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
            // $cat = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
            // $image = $this->Productimage->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'])));
            // $orders = $this->Order->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
            
            // $sub_category = $this->Subcategory->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
            // $productnames .= $sub_category['Subcategory']['subcategory'].',';
            // $msg.='<tr align="center" >
              // <td valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000; " >' . $i . '</td>
              // <td valign="top" style=" border-bottom:1px solid #000;border-right:1px solid #000; ">' . $cat['Category']['category_code'] . '' . $product['Product']['product_code'] . '-' . $carts['Shoppingcart']['purity'] . 'K' . $carts['Shoppingcart']['clarity'] . $carts['Shoppingcart']['color'] . '</td>
              // <td  valign="middle" style=" border-bottom:1px solid #000;border-right:1px solid #000; " ><table  cellspacing="0" cellpadding="4" align="center" style="border:1px solid #000;" width="80%">
                // <tr >
                  // <td style="border-bottom:1px solid #000;">' . $product['Product']['product_name'] . ',</td>
                // </tr>
                // <tr>
                  // <td style="border-bottom:1px solid #000;">' . ($carts['Shoppingcart']['size'] != '' ? '<strong>Size -</strong> 12,<br />' : '') . '
                  // <strong>Metals:</strong> ' . $carts['Shoppingcart']['purity'] . 'K ' . $carts['Shoppingcart']['metalcolor'] . ' Glod</td>
                // </tr>
                // <tr>
                  // <td style="line-height:0.5;"><p><strong>Matels Wt:</strong> ' . $carts['Shoppingcart']['weight'] . ' gms</p>';
                      // if ($carts['Shoppingcart']['stoneamount'] > 0) {
                        // $msg.='<p><strong>Stone:</strong> Diamond</p>
                  // <p><strong>Stone Wt:</strong> ' . $productdiamond[0]['sweight'] . ' carat</p>
                  // <p><strong>Quality:</strong> ' . $carts['Shoppingcart']['clarity'] . '-' . $carts['Shoppingcart']['color'] . '</p>
                  // <p><strong>Number of Stone:</strong> ' . $productdiamond[0]['no_diamond'] . '</p>';
                      // }
                      // if ($carts['Shoppingcart']['gemstoneamount'] > 0) {
                        // foreach ($productgemstone as $productgemstone) {
                          // $msg.='<p><strong>Stone:</strong> ' . $productgemstone['Productgemstone']['gemstone'] . '</p>
                      // <p><strong>Stone Wt:</strong>  ' . $productgemstone['Productgemstone']['stone_weight'] . ' carat</p>
                      // <p><strong>Number of Stone:</strong> ' . $productgemstone['Productgemstone']['no_of_stone'] . '</p>';
                        // }
                      // }
                      // $msg.='</td>
                // </tr>
                // </table></td>
              // <td style=" border-bottom:1px solid #000;border-right:1px solid #000; " valign="top">' . $carts['Shoppingcart']['quantity'] . '</td>
              // <td style=" border-bottom:1px solid #000; " valign="top">' . ($carts['Shoppingcart']['quantity'] * $carts['Shoppingcart']['total']) . '</td>
              // </tr>';
          // }
          
          // $msg.='</table>';
        // }

        // $shipping_details = ' <p><strong>' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . '</strong></p>
              // <p>' . str_replace('/n', '<br/>', $order1['Order']['shipping_add']) . '</p>
              // <p>' . $order1['Order']['scity'] . '-' . $order1['Order']['spincode'] . '</p>
              // <p>' . $order1['Order']['sstate'] . '</p>';
                  // $cart_amount = $this->Shoppingcart->find('first', array('conditions' => array('order_id' => $order1['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
                  // $netamount = $cart_amount[0]['subtotal'];
                  // $paymentdetails = '<table border="1" cellpadding="5" align="center">
              // <tr>
              // <th>Sub Total Amount</th>
              // <th>Rs. ' . $cart_amount[0]['subtotal'] . '</th>
              // </tr>';
                  // if ($order1['Order']['discount_amount'] > 0) {
                    // $paymentdetails.='<tr>
              // <th>Offer Discount Amount</th>
              // <th>Rs. ' . $order1['Order']['discount_amount'] . '</th>
              // </tr>';
                    // $netamount-=$order1['Order']['discount_amount'];
                  // }
                  // if ($order1['Order']['shipping_amt'] > 0) {
                    // $paymentdetails.=' <tr>
              // <th>Shipping Charges :</th>
              // <th>Rs. ' . $order1['Order']['shipping_amt'] . '</th>
              // </tr>';
                    // $netamount+=$order1['Order']['shipping_amt'];
                  // }
                  // $paymentdetails.='<tr>
              // <th>Total Amount</th>
              // <th>Rs. ' . $netamount . '</th>
              // </tr>';
                  // if ($order1['Order']['status'] == 'PartialPaid') {
                    // $paymentdetails.='<tr>
              // <td>Amount Paid</td>
              // <td>Rs. ' . $order1['Order']['cod_amount'] . '</td>
               // </tr>';
                    // $balance = $netamount - $order1['Order']['cod_amount'];
                    // $paymentdetails.='<tr>
              // <th>Balance Payable Amount :</th>
              // <th>Rs. ' . $balance . '</th>
              // </tr>';
                  // }

          // $paymentdetails.='</table>';
          
          

          // $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 11)));
          // $message = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $activateemail['Emailcontent']['content']);
          // $adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
          
          // //added by prakash
          // $invoice = $this->requestAction(array('action' => 'orderpdf', $order1['Order']['order_id'], 'F'), array('return', 'bare' => false));
          // $file = 'files/invoices/' . str_replace('/', '_', $in . $order1['Order']['invoice'] . '.pdf');
           
           // echo "<pre> ".$msg;
        // print_r($in);
        // exit;
           
           // // $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message, '', 1, $file, 'acknowledgment', '');
          // //send sms
          // $productnames = rtrim($productnames,',');
          // $sms_message = $this->get_sms_message(1);
          // $sms_message = str_replace(array('{PRODUCT_NAME}'), array($productnames), $sms_message);
          // $this->sendsms($user['User']['phone_no'], $sms_message);
          
          // $email = $this->Emailcontent->find('first', array('conditions' => array('eid' => 12)));

          // $messagen = str_replace(array('{name}', '{details}', '{order_no}', '{order_date}', '{shipping_details}', '{payment_details}'), array($name, $msg, $in . $order1['Order']['invoice'], date('d-m-Y', strtotime($order1['Order']['created_date'])), $shipping_details, $paymentdetails), $email['Emailcontent']['content']);
        
          $resp_arr = array('code'=>'200','success'=>'Order status updated successfully','error'=>false,'data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function orderpdf($order_id = NULL, $output = 'D') {
    // echo "1";
    // exit;
    
        $userid = $_REQUEST['user_id'];

        $this->layout = '';
        $orderdetails = $this->Order->find('first', array('conditions' => array('order_id' => $order_id)));
    
    if ($userid == $orderdetails['Order']['user_id']) 
    {
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
  
  public function orderHistory()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['user_id']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $user_id = $_REQUEST['user_id'];
        $order_data = $this->Order->find('all', array('conditions' => array('user_id' => $user_id,'order_status_id != ' => '1')));
        
        // echo "<pre>";
        // print_r($order_data);
        // exit;
        if(!empty($order_data))
        {
          $j = 0;
          
          foreach($order_data as $order)
          {
            $cart_item = $this->Shoppingcart->find('all', array('conditions' => array('user_id' => $user_id,'order_id'=>$order['Order']['order_id'])));
            
            if(!empty($cart_item))
            {
              $i = 0;
              
              foreach($cart_item as $cart)
              {
                $product_images = $this->Productimage->find('first',array('conditions' =>array('product_id' => $cart['Shoppingcart']['product_id'])));
                $product_data = $this->Product->find('first',array('conditions' =>array('product_id' => $cart['Shoppingcart']['product_id'])));
                $category = $this->Category->find('first', array('conditions' => array('category_id' => $product_data['Product']['category_id'])));
                
                $product_code = $category['Category']['category_code'].$product_data['Product']['product_code'];
                
                if(!empty($product_data['Product']['stone_color_id']))
                {
                  $colors = $this->Color->find('first', array('conditions' => array('color_id' => $product_data['Product']['stone_color_id'])));
                  $customid = $product_data['Product']['metal_purity']."K".$colors['Color']['clarity']."-".$colors['Color']['color'];
                  $product_code .= " - ".str_replace("-","",$customid);
                }
                
                $color = explode(",",$product_data['Product']['metal_color']);
                
                if(!empty($color))
                {
                  $color_arr = array();
                  
                  foreach($color as $val)
                  {
                    if($val==$cart['Shoppingcart']['metalcolor'])
                    {
                      $color_arr[$val] = true;
                    }
                    else
                    {
                      $color_arr[$val] = false;
                    }
                  }
                }
                
                $size = $this->Size->find('all',array('conditions'=>array('category_id='.$category['Category']['category_id']),'order'=>'size_value asc'));
                
                if(!empty($size))
                {
                  $size_arr = array();
                  
                  foreach($size as $val)
                  {
                    if($val['Size']['size']==$cart['Shoppingcart']['size'])
                    {
                      $size_arr[$val['Size']['size']] = true;
                    }
                    else
                    {
                      $size_arr[$val['Size']['size']] = false;
                    }
                  }
                }
                
                
                $cart_product[$j]['item'][$i]['product_id'] = $cart['Shoppingcart']['product_id'];
                $cart_product[$j]['item'][$i]['product_name'] = $product_data['Product']['product_name'];
                $cart_product[$j]['item'][$i]['product_code'] = $product_code;
                $cart_product[$j]['item'][$i]['color'][] = $color_arr;
                $cart_product[$j]['item'][$i]['size'][] = $size_arr;
                $cart_product[$j]['item'][$i]['customid'] = $customid;
                $cart_product[$j]['item'][$i]['price'] = $cart['Shoppingcart']['total'];
                $cart_product[$j]['item'][$i]['quantity'] = $cart['Shoppingcart']['quantity'];
                $cart_product[$j]['item'][$i]['img'] = 'http://shagunn.in/img/product/small/'.$product_images['Productimage']['imagename'];
                $cart_product[$j]['sub_total'] += ($cart['Shoppingcart']['total']*$cart['Shoppingcart']['quantity']);
                $cart_product[$j]['total_quantity'] += $cart['Shoppingcart']['quantity'];
                $cart_product[$j]['vat'] += $cart['Shoppingcart']['vat'];
                $cart_product[$j]['order_date'] = $order['Order']['created_date'];
                $cart_product[$j]['order_id'] = ($cart['Shoppingcart']['order_id']);
                $i++;
                
              }
              
              $j++;
            }
            
            
          }
          
          // echo "<pre>";
          // print_r($cart_product);
          // exit;
          
          if(!empty($cart_product))
          {
            $resp_arr = array('code'=>'200','success'=>'order history found successfully','error'=>false,'data'=>$cart_product);
          }
          else
          {
            $resp_arr = array('code'=>'400','success'=>false,'error'=>'order history is empty','data'=>null);
          }
          
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'order history is empty','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getPersonalizeJwellery()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      $category = $this->Category->find('all',array('fields'=>'category_id,category','conditions'=>array('status'=>'Active')));
      $purity = $this->Purity->find('all',array('fields'=>'purity_id,purity','conditions'=>array('status'=>'Active')));
      $metal = $this->Metal->find('all',array('fields'=>'metal_name','conditions'=>array('status'=>'Active')));
      $metal_color = $this->Metalcolor->find('all',array('fields'=>'metalcolor','conditions'=>array('status'=>'Active')));
      $setting_type = $this->Settingtype->find('all',array('fields'=>'settingtype','conditions'=>array('status'=>'Active')));
      $gemstone = $this->Gemstone->find('all',array('fields'=>'stone','conditions'=>array('status'=>'Active')));
      $shape = $this->Shape->find('all',array('fields'=>'shape','conditions'=>array('status'=>'Active')));
      
      $data = array();
      
      if(!empty($category))
      {
        $i = 0;
        
        foreach($category as $cat)
        {
          if($i==0)
          {
            $data['category'][$i]['category_name'] = 'Select Category';
            $data['category'][$i]['category_value'] = '';
            $i++;
            $data['category'][$i]['category_name'] = $cat['Category']['category'];
            $data['category'][$i]['category_value'] = $cat['Category']['category'];
          }
          else
          {
            $data['category'][$i]['category_name'] = $cat['Category']['category'];
            $data['category'][$i]['category_value'] = $cat['Category']['category'];
          }
          
          $i++;
        }
      }
      
      if(!empty($purity))
      {
        $i = 0;
        
        foreach($purity as $pure)
        {
          if($i==0)
          {
            $data['purity'][$i]['purity_name'] = 'Select Purity';
            $data['purity'][$i]['purity_value'] = '';
            $i++;
            $data['purity'][$i]['purity_name'] = $pure['Purity']['purity'];
            $data['purity'][$i]['purity_value'] = $pure['Purity']['purity'];
          }
          else
          {
            $data['purity'][$i]['purity_name'] = $pure['Purity']['purity'];
            $data['purity'][$i]['purity_value'] = $pure['Purity']['purity'];
          }
          
          $i++;
        }
      }
      
      if(!empty($metal))
      {
        $i = 0;
        
        foreach($metal as $metals)
        {
          if($i==0)
          {
            $data['metal'][$i]['metal_name'] = 'Select Metal';
            $data['metal'][$i]['metal_value'] = '';
            $i++;
            $data['metal'][$i]['metal_name'] = $metals['Metal']['metal_name'];
            $data['metal'][$i]['metal_value'] = $metals['Metal']['metal_name'];
          }
          else
          {
            $data['metal'][$i]['metal_name'] = $metals['Metal']['metal_name'];
            $data['metal'][$i]['metal_value'] = $metals['Metal']['metal_name'];
          }
          
          $i++;
        }
      }
      
      if(!empty($metal_color))
      {
        $i = 0;
        
        foreach($metal_color as $metal_col)
        {
          if($i==0)
          {
            $data['metal_color'][$i]['metal_color_name'] = 'Select Metal Color';
            $data['metal_color'][$i]['metal_color_value'] = '';
            $i++;
            $data['metal_color'][$i]['metal_color_name'] = $metal_col['Metalcolor']['metalcolor'];
            $data['metal_color'][$i]['metal_color_value'] = $metal_col['Metalcolor']['metalcolor'];
          }
          else
          {
            $data['metal_color'][$i]['metal_color_name'] = $metal_col['Metalcolor']['metalcolor'];
            $data['metal_color'][$i]['metal_color_value'] = $metal_col['Metalcolor']['metalcolor'];
          }
          
          $i++;
        }
      }
      
      if(!empty($setting_type))
      {
        $i = 0;
        
        foreach($setting_type as $setting)
        {
          if($i==0)
          {
            $data['setting_type'][$i]['setting_type_name'] = 'Select Setting Type';
            $data['setting_type'][$i]['setting_type_value'] = '';
            $i++;
            $data['setting_type'][$i]['setting_type_name'] = $setting['Settingtype']['settingtype'];
            $data['setting_type'][$i]['setting_type_value'] = $setting['Settingtype']['settingtype'];
          }
          else
          {
            $data['setting_type'][$i]['setting_type_name'] = $setting['Settingtype']['settingtype'];
            $data['setting_type'][$i]['setting_type_value'] = $setting['Settingtype']['settingtype'];
          }
          
          $i++;
        }
      }
      
      if(!empty($gemstone))
      {
        $i = 0;
        
        foreach($gemstone as $stone)
        {
          if($i==0)
          {
            $data['gemstone'][$i]['gemstone_name'] = 'Select Gemstone';
            $data['gemstone'][$i]['gemstone_value'] = '';
            $i++;
            $data['gemstone'][$i]['gemstone_name'] = $stone['Gemstone']['stone'];
            $data['gemstone'][$i]['gemstone_value'] = $stone['Gemstone']['stone'];
          }
          else
          {
            $data['gemstone'][$i]['gemstone_name'] = $stone['Gemstone']['stone'];
            $data['gemstone'][$i]['gemstone_value'] = $stone['Gemstone']['stone'];
          }
          
          $i++;
        }
      }
      
      if(!empty($shape))
      {
        $i = 0;
        
        foreach($shape as $shapes)
        {
          if($i==0)
          {
            $data['shape'][$i]['shape_name'] = 'Select Shape';
            $data['shape'][$i]['shape_value'] = '';
            $i++;
            $data['shape'][$i]['shape_name'] = $shapes['Shape']['shape'];
            $data['shape'][$i]['shape_value'] = $shapes['Shape']['shape'];
          }
          else
          {
            $data['shape'][$i]['shape_name'] = $shapes['Shape']['shape'];
            $data['shape'][$i]['shape_value'] = $shapes['Shape']['shape'];
          }
          
          $i++;
        }
      }
      
      if(!empty($data))
      {
        $resp_arr = array('code'=>'200','success'=>'Product features found successfully','error'=>false,'data'=>$data);
      }
      else
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'Product features not found','data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function getJwellerySize()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['category']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $category = $this->Category->find('first',array('fields'=>'category_id','conditions'=>array('category'=>$_REQUEST['category'],'status'=>'Active')));
        
        if(!empty($category))
        {
          $size = $this->Size->find('all',array('fields'=>'size_value','conditions'=>array('category_id'=>$category['Category']['category_id'],'status'=>'Active')));
        }
        
        $data = array();
      
        if(!empty($size))
        {
          $i = 0;
          
          foreach($size as $sizes)
          {
            if($i==0)
            {
              $data['size'][$i]['size_name'] = 'Select Size';
              $data['size'][$i]['size_value'] = '';
              $i++;
              $data['size'][$i]['size_name'] = $sizes['Size']['size_value'];
              $data['size'][$i]['size_value'] = $sizes['Size']['size_value'];
            }
            else
            {
              $data['size'][$i]['size_name'] = $sizes['Size']['size_value'];
              $data['size'][$i]['size_value'] = $sizes['Size']['size_value'];
            }
            
            $i++;
          }
        }
      
        if(!empty($data))
        {
          $resp_arr = array('code'=>'200','success'=>'Category sizes found successfully','error'=>false,'data'=>$data);
        }
        else
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Category sizes not found','data'=>null);
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function addPersonalizeJwellery()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['name']) || empty($_REQUEST['email']) || empty($_REQUEST['mobile']) || empty($_REQUEST['address']))
      {
        $resp_arr = array('success'=>true,'error'=>'required parameter is missing','data'=>null);
      }
      else
      {
        $image = '';
  
        // if ($_FILES["image"]["name"] != '') 
        // {
          // $image = $destination = 'img/request/' . $_FILES["image"]["name"];
          // move_uploaded_file($_FILES["image"]['tmp_name'], $destination);
          // $this->request->data['Jewellrequest']['image'] = $_FILES["image"]["name"];
        // }

        $email_template = '
          <h3>Order Details</h3>
          <br/><table border="1" cellspacing="2" cellpadding="2">
          <thead>
          <th>Name</th>
          <th>Address</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Category</th>
          </thead>
          <tbody>
          <tr>
          <td>' . $_REQUEST['name'] . '</td>
          <td>' . $_REQUEST['address'] . '</td>
          <td>' . $_REQUEST['mobile'] . '</td>
          <td>' . $_REQUEST['email'] . '</td>
          <td>' . $_REQUEST['category'] . '</td>
          </tr>
          </tbody>
          </table>
          <br/>
          <h3>Product Details</h3>
          <br/>
          <table border="1" cellspacing="2" cellpadding="2">
          <thead>
          <th>Size</th>
          <th>Height</th>
          <th>Width</th>
          <th>Length</th>
          <th>Total Weight</th>
          <th>Image</th>
          </thead>
          <tbody>
          <tr>
          <td>' . $_REQUEST['size'] . '</td>
          <td>' . $_REQUEST['height'] . '</td>
          <td>' . $_REQUEST['width'] . '</td>
          <td>' . $_REQUEST['length'] . '</td>
          <td>' . $_REQUEST['tweight'] . '</td>
           <td><img src="' . BASE_URL . $image . '" alt="Not uploaded"></td>
          </tr>
          </tbody>
          </table>
          <br/>
          <h3>Metals Details</h3>
          <br/>
          <table border="1" cellspacing="2" cellpadding="2">
          <thead>
          <th>Metals Weight</th>
          <th>Purity</th>
          <th>Width</th>
          <th>Color</th>
          <th>Metals</th>
          </thead>
          <tbody>
          <tr>
          <td>' . $_REQUEST['mweight'] . '</td>
          <td>' . $_REQUEST['mpurity'] . '</td>
          <td>' . $_REQUEST['width'] . '</td>
          <td>' . $_REQUEST['mcolor'] . '</td>
          <td>' . $_REQUEST['mmetal'] . '</td>
            </tr>
          </tbody>
          </table>';

        $this->request->data['Jewellrequest']['name'] = $_REQUEST['name'];
        $this->request->data['Jewellrequest']['address'] = $_REQUEST['address'];
        $this->request->data['Jewellrequest']['mobile'] = $_REQUEST['mobile'];
        $this->request->data['Jewellrequest']['email'] = $_REQUEST['email'];
        $this->request->data['Jewellrequest']['product_cat'] = $_REQUEST['category'];
        $this->request->data['Jewellrequest']['size'] = $_REQUEST['size'];
        $this->request->data['Jewellrequest']['height'] = $_REQUEST['height'];
        $this->request->data['Jewellrequest']['weight'] = $_REQUEST['width'];
        $this->request->data['Jewellrequest']['length'] = $_REQUEST['length'];
        $this->request->data['Jewellrequest']['total_weight'] = $_REQUEST['tweight'];
        $this->request->data['Jewellrequest']['metal_weight'] = $_REQUEST['mweight'];
        $this->request->data['Jewellrequest']['purity'] = $_REQUEST['mpurity'];
        $this->request->data['Jewellrequest']['width'] = $_REQUEST['width'];
        $this->request->data['Jewellrequest']['color'] = $_REQUEST['mcolor'];
        $this->request->data['Jewellrequest']['metals'] = $_REQUEST['mmetal'];
        $this->Jewellrequest->save($this->request->data);
        $id = $this->Jewellrequest->getLastInsertId();
        
        $this->request->data['Jewelldiamond']['si_ij'] = $_REQUEST['dsiij'];
        $this->request->data['Jewelldiamond']['si_gh'] = $_REQUEST['dsigh'];
        $this->request->data['Jewelldiamond']['vs_gh'] = $_REQUEST['dvsgh'];
        $this->request->data['Jewelldiamond']['vvs_ef'] = $_REQUEST['dvvsef'];
        $this->request->data['Jewelldiamond']['setting'] = $_REQUEST['dsettings'];
        $this->request->data['Jewelldiamond']['shape'] = $_REQUEST['dshape'];
        $this->request->data['Jewelldiamond']['no_of_stone'] = $_REQUEST['dstonecount'];
        $this->request->data['Jewelldiamond']['weight'] = $_REQUEST['dweight'];
        $this->request->data['Jewelldiamond']['request_id'] = $id;
        $this->Jewelldiamond->save($this->request->data);

        $email_template.='<tr>
                  <td>' . $_REQUEST['dsiij'] . '</td>
                  <td>' . $_REQUEST['dsigh'] . '</td>
                  <td>' . $_REQUEST['dvsgh'] . '</td>
                  <td>' . $_REQUEST['dvvsef'] . '</td>
                  <td>' . $_REQUEST['dsettings'] . '</td>
                  <td>' . $_REQUEST['dshape'] . '</td>
                  <td>' . $_REQUEST['dstonecount'] . '</td>
                  <td>' . $_REQUEST['dweight'] . '</td>
                  </tr>';
                  
        $this->request->data['Jewellstone']['name'] = $_REQUEST['sname'];
          $this->request->data['Jewellstone']['shape'] = $_REQUEST['sshape'];
          $this->request->data['Jewellstone']['weight'] = $_REQUEST['sweight'];
          $this->request->data['Jewellstone']['setting'] = $_REQUEST['ssetting'];
          $this->request->data['Jewellstone']['no_of_stone'] = $_REQUEST['sstonecount'];
          $this->request->data['Jewellstone']['req_id'] = $id;
          $this->Jewellstone->save($this->request->data);

          $email_template.='<tr>
                    <td>' . $_REQUEST['sname'] . '</td>
                    <td>' . $_REQUEST['sshape'] . '</td>
                    <td>' . $_REQUEST['sweight'] . '</td>
                    <td>' . $_REQUEST['ssetting'] . '</td>
                    <td>' . $_REQUEST['sstonecount'] . '</td>                                                                   
                    </tr>';
        // }

        $email_template.='</tbody></table>';

        $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 15)));
        $message = str_replace(array('{name}', '{details}'), array($_REQUEST['name'], $email_template), $activateemail['Emailcontent']['content']);
        $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $_REQUEST['email'], $activateemail['Emailcontent']['subject'], $message);

        $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 16)));
        $message = str_replace(array('{name}', '{details}'), array($_REQUEST['name'], $email_template), $activateemail['Emailcontent']['content']);
        $this->mailsend(SITE_NAME, $_REQUEST['email'], $activateemail['Emailcontent']['fromemail'], $activateemail['Emailcontent']['subject'], $message);
        
        $resp_arr = array('code'=>'200','success'=>'Request submitted successfully','error'=>false,'data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function userRegistration()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['name']) || empty($_REQUEST['mobile_no']) || empty($_REQUEST['email_id']) || empty($_REQUEST['password']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'Required Parameter Missing','data'=>null);
      }
      else
      {
        $user_data = $this->User->find('first',array('conditions'=>array('email'=>$_REQUEST['email_id'])));
        
        if(!empty($user_data) && empty($_REQUEST['mode']))
        {
          if($user_data['User']['status']=='Inactive')
          {
            $is_validate = "N";
          }
          else if($user_data['User']['status']=='Active')
          {
            $is_validate = "Y";
          }
          
          $data = array('is_validate'=>$is_validate,'user_id'=>$user_data['User']['user_id'],'tokenhash'=>$user_data['User']['tokenhash'],'first_name'=>$user_data['User']['first_name']." ".$user_data['User']['last_name'],'email'=>$user_data['User']['email'],'password'=>$user_data['User']['password'],'phone_no'=>$user_data['User']['phone_no'],'status'=>$user_data['User']['status']);
          
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Email Id is already used','data'=>$data);
        }
        else if(!empty($_REQUEST['mode']) && $_REQUEST['mode']=='R')
        {
          $OTP = $this->generateOTP();
          
          $password = $_REQUEST['password'];
          $hash = sha1($_REQUEST['email_id'] . rand(0, 100));
          $this->request->data['User']['user_id'] = $user_data['User']['user_id'];
          $this->request->data['User']['user_type'] = 0;
          $this->request->data['User']['first_name'] = $_REQUEST['name'];
          $this->request->data['User']['email'] = $_REQUEST['email_id'];
          $this->request->data['User']['password'] = sha1($password);
          $this->request->data['User']['tokenhash'] = $hash;
          $this->request->data['User']['phone_no'] = $_REQUEST['mobile_no'];
          $this->request->data['User']['status'] = 'Inactive';
          $this->request->data['User']['otp'] = $OTP;
          $this->request->data['User']['otp_expiry'] = strtotime("+30 minutes");
          $this->request->data['User']['status'] = 'Inactive';
          
          //extract data from the post
          //set POST variables
          $url = 'http://api.alerts.sinfini.com/v3/';
          $fields = array(
            'method' => urlencode('sms'),
            'api_key' => urlencode('14328fib06qu253pb9z4d'),
            'to' => urlencode($_REQUEST['mobile_no']),
            'sender' => urlencode('BirlaG'),
            'message' => urlencode('Your OTP is '.$OTP),
            'format' => urlencode('json'),
            'flash' => 0
          );

          //url-ify the data for the POST
          foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
          rtrim($fields_string, '&');

          $resp = $this->sendSmsMessage($url,$fields,$fields_string);
          
          $this->User->save($this->request->data);
          $resp_arr = array('code'=>'200','success'=>'To complete registration enter OTP','error'=>false,'data'=>array('OTP'=>$OTP)); 
        }
        else
        {
          $OTP = $this->generateOTP();
          
          $password = $_REQUEST['password'];
          $hash = sha1($_REQUEST['email_id'] . rand(0, 100));
          $this->request->data['User']['user_type'] = 0;
          $this->request->data['User']['first_name'] = $_REQUEST['name'];
          $this->request->data['User']['email'] = $_REQUEST['email_id'];
          $this->request->data['User']['password'] = sha1($password);
          $this->request->data['User']['tokenhash'] = $hash;
          $this->request->data['User']['phone_no'] = $_REQUEST['mobile_no'];
          $this->request->data['User']['status'] = 'Inactive';
          $this->request->data['User']['otp'] = $OTP;
          $this->request->data['User']['otp_expiry'] = strtotime("+30 minutes");
          $this->request->data['User']['status'] = 'Inactive';
          
          //extract data from the post
          //set POST variables
          $url = 'http://api.alerts.sinfini.com/v3/';
          $fields = array(
            'method' => urlencode('sms'),
            'api_key' => urlencode('14328fib06qu253pb9z4d'),
            'to' => urlencode($_REQUEST['mobile_no']),
            'sender' => urlencode('BirlaG'),
            'message' => urlencode('Your OTP is '.$OTP),
            'format' => urlencode('json'),
            'flash' => 0
          );

          //url-ify the data for the POST
          foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
          rtrim($fields_string, '&');

          $resp = $this->sendSmsMessage($url,$fields,$fields_string);
          
          $this->User->save($this->request->data);
          $resp_arr = array('code'=>'200','success'=>'To complete registration enter OTP','error'=>false,'data'=>array('OTP'=>$OTP)); 
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function validateOtp()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if(empty($_REQUEST['otp']))
      {
        $resp_arr = array('code'=>'400','success'=>false,'error'=>'Required Parameter Missing','data'=>null);
      }
      else
      {
        $user_data = $this->User->find('first',array('conditions'=>array('otp'=>$_REQUEST['otp'],'otp_expiry >= '=>time())));
        
        if(empty($user_data))
        {
          $resp_arr = array('code'=>'400','success'=>false,'error'=>'Invalid or Expired OTP','data'=>null);
        }
        else
        {
          $this->request->data['User']['user_id'] = $user_data['User']['user_id'];
          $this->request->data['User']['status'] = 'Active';
          
          $to = $user_data['User']['email'];
          $from_email = 'info@shagunn.in';
          $subject = "Login Credential From Cherishgold";
          // $message = 'Your Login Credentials For Cherishgold.com :-<br/><br/>Username :- '.$user_data['User']['email'].'<br/>Password :- '.$password.'<br/><br/>--Regards,<br/>Cherishgold Team';
          $message = 'Your are successfully register at Cherishgold.com<br/><br/>--Regards,<br/>Cherishgold Team';
          
          $headers =  "From:$from_email" . "\r\n" .
              "Reply-To: $from_email" . "\r\n" .
              'X-Mailer: PHP/' . phpversion()."\r\n";
          $headers  .= 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          
          
          
          if(mail($to , $subject , $message , $headers ))
          {
            $this->User->save($this->request->data);
            $user_data = $this->User->find('first',array('conditions'=>array('otp'=>$_REQUEST['otp'],'otp_expiry >= '=>time())));
            $data = array('user_id'=>$user_data['User']['user_id'],'tokenhash'=>$user_data['User']['tokenhash'],'first_name'=>$user_data['User']['first_name']." ".$user_data['User']['last_name'],'email'=>$user_data['User']['email'],'password'=>$user_data['User']['password'],'phone_no'=>$user_data['User']['phone_no'],'status'=>$user_data['User']['status']);
            $resp_arr = array('code'=>'200','success'=>'Successfully Register','error'=>false,'data'=>$data);
          }
          else
          {
            $resp_arr = array('code'=>'400','success'=>false,'error'=>'There is some problem,try again','data'=>null);
          }
          
        }
      }
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function generateOTP()
  {
    $otp = rand(1000,9999);
    $otp_data = $this->User->find('first',array('conditions'=>array('otp'=>$otp)));
    
    if(!empty($otp_data))
    {
      $this->generateOTP();
    }
    else
    {
      return $otp;
    }
  }
  
  public function sendSmsMessage($url,$fields,$fields_string)
  {
    //open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);
    
    return $result;
  }
  
  public function homepage()
  {
    
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      $data1['bigslider'] = array(array("category_pointer"=>"-1","image_path"=>BASE_URL."cakephp_api/img/bigslider/B1.jpg"),array("category_pointer"=>"3","image_path"=>BASE_URL."cakephp_api/img/bigslider/B5.jpg"),array("category_pointer"=>"4","image_path"=>BASE_URL."cakephp_api/img/bigslider/B6.jpg"),array("category_pointer"=>"10","image_path"=>BASE_URL."cakephp_api/img/bigslider/B11.jpg"));
      $data1['squareimages'] = array(array("category_pointer"=>"0","image_path"=>BASE_URL."cakephp_api/img/squareimages/1.jpg"),array("category_pointer"=>"2","image_path"=>BASE_URL."cakephp_api/img/squareimages/3.jpg"),array("category_pointer"=>"5","image_path"=>BASE_URL."cakephp_api/img/squareimages/6.jpg"),array("category_pointer"=>"6","image_path"=>BASE_URL."cakephp_api/img/squareimages/7.jpg"),array("category_pointer"=>"8","image_path"=>BASE_URL."cakephp_api/img/squareimages/8.jpg"),array("category_pointer"=>"8","image_path"=>BASE_URL."cakephp_api/img/squareimages/11.jpg"),array("category_pointer"=>"8","image_path"=>BASE_URL."cakephp_api/img/squareimages/12.jpg"));
      $data1['minislider'] = array(array("category_pointer"=>"0","image_path"=>BASE_URL."cakephp_api/img/minislider/1.jpg"),array("category_pointer"=>"1","image_path"=>BASE_URL."cakephp_api/img/minislider/2.jpg"),array("category_pointer"=>"2","image_path"=>BASE_URL."cakephp_api/img/minislider/3.jpg"),array("category_pointer"=>"3","image_path"=>BASE_URL."cakephp_api/img/minislider/4.jpg"),array("category_pointer"=>"4","image_path"=>BASE_URL."cakephp_api/img/minislider/5.jpg"),array("category_pointer"=>"5","image_path"=>BASE_URL."cakephp_api/img/minislider/6.jpg"),array("category_pointer"=>"6","image_path"=>BASE_URL."cakephp_api/img/minislider/7.jpg"));
      $data["data"] = $data1;
      $resp_arr = array('success'=>true,'error'=>null,'data'=>$data);
    }
    
    $this->apiResponse($resp_arr);
  }
  
  public function relationManager()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if($_GET["manager_id"])
      {
        $relation = $this->RelationshipManager->find('first',array('conditions' => array("manager_id" => $_GET["manager_id"])));
        $data["data"] = $relation;
        $resp_arr = array('success'=>true,'error'=>null,'data'=>$data);
      }
      else
      {
        $resp_arr = array('success'=>true,'error'=>'manager id is missing','data'=>null);
      }
    }
    $this->apiResponse($resp_arr);
  }
  
  public function setDistributor()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if($_POST["customer_id"])
      {
        $data['customer_id'] = $_POST["customer_id"];
        $data['distributor'] = "yes";
        $data['distributor_date'] = date("Y-m-d");
        $result = $this->CustomerBGP->save($data);
        $resp_arr = array('success'=>true,'error'=>null,'data'=>array('data'=>"Success"));
      }
      else
      {
        $resp_arr = array('success'=>true,'error'=>'customer id is missing','data'=>null);
      }
    }
    $this->apiResponse($resp_arr);
  }
  
  public function listreferral()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if($_GET["customer_id"])
      {
        $referral = $this->Referral->find('all',array('conditions' => array("distributor_id" => $_GET["customer_id"])));
        $data["referral"] = $relation;
        $resp_arr = array('success'=>true,'error'=>null,'data'=>$referral);
      }
      else
      {
        $resp_arr = array('success'=>true,'error'=>'customer id is missing','data'=>null);
      }
    }
    $this->apiResponse($resp_arr);
  }
  
  public function addreferral()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if ($this->request->is('post')) {
        $search = array();
        $customer = $this->CustomerBGP->find('first', array('conditions' => array("customer_id" => $this->request->data['customer_id'])));
        $search["contact_email"] = $this->request->data['contact_email'];
        $customer_email = $this->CustomerBGP->find('first', array('conditions' => $search));
        
        $search = array();
        $search["contact_mobile"] = $this->request->data['contact_mobile'];
        $customer_mobile = $this->CustomerBGP->find('first', array('conditions' => $search));
        $error = "no";
        if($customer_email || $customer_mobile)
        {
          $error = "yes";
        }
        
        $search = array();
        $search["email"] = $this->request->data['contact_email'];
        $customer_email = $this->User->find('first', array('conditions' => $search));
        $search = array();
        $search["phone_no"] = $this->request->data['contact_mobile'];
        $customer_mobile = $this->User->find('first', array('conditions' => $search));
        
        if($customer_email || $customer_mobile)
        {
          $error = "yes";
        }
        
        $check = $this->Referral->find('first', array('conditions' => array(
            'contact_email =' => $this->request->data['contact_email'],
            'contact_mobile =' => $this->request->data['contact_mobile'],
          )
        ));

        if (empty($check) && $error == "no") {
          $this->request->data['manager_id'] = $customer['CustomerBGP']['relationship_manager'];
          $this->request->data['distributor_id'] = $customer['CustomerBGP']['customer_id'];
          $this->request->data['referral_dob'] = date("Y-m-d",strtotime($this->request->data['referral_dob']));
          
          $this->Referral->save($this->request->data);
          $resp_arr = array('success'=>true,'error'=>null,'data'=>array('data' => "Referral added successfully"));
        } else {
          $resp_arr = array('success'=>true,'error'=>"Email Id/Mobile already exists, Try another!",'data'=> null);
        }
      }
      else
      {
        $resp_arr = array('success'=>true,'error'=>'customer id is missing','data'=>null);
      }
    }
    $this->apiResponse($resp_arr);
  }
  
  public function dashboard()
  {
    $resp = $this->validateRequest();
    
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {

      if($_GET['customer_id'])
      { $search['customer_id'] = $_GET['customer_id'];
        $data1['customer'] = $this->CustomerBGP->find('first', array('conditions' => $search));
        $data1['price'] = $this->Price->find('first', array('conditions' => array('type' => "Metals", 'metal_id ' => 1, 'metalcolor_id' => 2,'metal_fineness' => '995')));
        $data1['relation'] = $this->RelationshipManager->find('first',array('conditions' => array("manager_id" => $customer["CustomerBGP"]["relationship_manager"])));
        $data1['payment'] = $this->PaymentMaster->find('all',array('conditions' => array("mer_txn" => $customer["CustomerBGP"]["application_no"],'f_code' => 'Ok')));
        $data['data'] = $data1;
        $resp_arr = array('success'=>true,'error'=>null,'data'=>$data);
      }
      else
      {
        $resp_arr = array('success'=>true,'error'=>'customer Id is missing','data'=>null);
      }
    }
    
    $this->apiResponse($resp_arr);
  }

  
  public function lastpayment()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if ($_GET['application_no']) {
          $search["mer_txn"] = $_GET["application_no"];
          $search["f_code"] = "'Ok'";
          $payment = $this->PaymentMaster->find('first',array('conditions' => $search, 'order' => 'payment_id DESC'));
          $data["data"] = $payment;
          $resp_arr = array('success'=>true,'error'=>null,'data'=>$data);
      } 
      else 
      {
        $resp_arr = array('success'=>true,'error'=>"Something went wrong, Try again!",'data'=> null);
      }
    }
    $this->apiResponse($resp_arr);
  }
  
      
  public function atomresponse()
  {
    $resp = $this->validateRequest();
    if($resp=='401')
    {
      $resp_arr = array('success'=>true,'error'=>'authentication key is missing','data'=>null);
    }
    else
    {
      if ($this->request->is('post')) {
          $this->PaymentMaster->save($this->request->data);
          $resp_arr = array('success'=>true,'error'=>null,'data'=>array('data' => "Payment added successfully"));
      }
      else 
      {
          $resp_arr = array('success'=>true,'error'=>"Something went wrong, Try again!",'data'=> null);
      }
    }
    $this->apiResponse($resp_arr);
  }

  public function phpInfo(){
      echo phpinfo();
  }

  /*
   * function to validate request for parameters.
   */
  public function validateRequest(){
    if(empty($_REQUEST['key'])){
      $resp = '401';
    }else{
      if(md5($this->key)!=$_REQUEST['key']){
        $resp = '401';
      }else{
        $resp = '200';
      }
    }
    
    return $resp;
  }

  /*
   * function to give response in xml or json
   */
  public function apiResponse($resp_arr,$resp_type=''){
    if($resp_type=='xml')
    { 
      header('Content-Type: application/xml');
      $resp = $this->arrayToXml($resp_arr,'response');
    }
    else
    {
      header('Content-Type: application/json');
      $resp = json_encode(array('response'=>$resp_arr));
    }
    
    echo $resp;
  }
  
}
?>