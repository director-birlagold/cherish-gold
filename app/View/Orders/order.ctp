<?php $coupon_used=0;
$ship_avail='1';
 ?>

<div class="main">
<header> &nbsp; </header>
<div style="clear:both;">&nbsp;</div>
<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible">
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
    <li class="ui-state-default ui-corner-top"><a href="<?php echo BASE_URL;?>orders/personal_details" class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
    <li class="ui-state-default ui-corner-top "><a href="<?php echo BASE_URL;?>orders/shipping_details"  class="ui-tabs-anchor" >SHIPPING DETAILS</a></li>
    <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a class="ui-tabs-anchor" >REVIEW ORDER AND PAY</a></li>
  </ul>
  
  <div id="tabs-4">
    <p>
    <div class="orderPayDiv">
      <div class="orderPayLeft" style="width:72%;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td class="thBdr" align="left" width="300"><strong>Description</strong></td>
            <td class="thBdr" align="center" width="150"><strong>Price</strong></td>
            <td class="thBdr" align="center"><strong>Quantity</strong></td>
            <td class="thBdr" align="center"><strong>Remove</strong></td>
            <td class="thBdr bdrRightNone" align="center"><strong>Total</strong></td>
          </tr>
          <?php
					if(!empty($cart)) {
					$amount='';					
					$discount_amount_applied_for=0;
					foreach($cart as $carts) {
						$product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' =>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
						$category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'],'status'=>'Active')));
						$subcategory=ClassRegistry::init('Subcategory')->find('first',array('conditions'=>array('subcategory_id' =>$product['Product']['subcategory_id'],'status'=>'Active')));						
						$images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$carts['Shoppingcart']['product_id'],'status'=>'Active')));											
					?>
          <tr>
            <td class="tdBdr">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']))."/".$product['Product']['product_id']."/".str_replace(' ','_',trim($product['Product']['product_name']));?>">
                    <?php  echo $this->Html->image('product/small/'.$images['Productimage']['imagename'] ,array("alt" => "index","height"=>"100","width"=>"120")); ?>
                    </a></td>
                  <td><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',$category['Category']['category'])."/".str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']))."/".$product['Product']['product_id']."/".str_replace(' ','_',trim($product['Product']['product_name']))?>"><?php echo $product['Product']['product_name'];?></a></td>
                </tr>
              </table>
            </td>
            <td align="center" class="tdBdr"  >Rs. <?php echo indian_number_format(round($carts['Shoppingcart']['total']));?></td>
            <td align="center" class="tdBdr fetch"><?php echo $carts['Shoppingcart']['quantity'];?>&nbsp;&nbsp;</td>
            <td align="center" class="tdBdr"><a href="<?php echo BASE_URL;?>orders/delete/<?php echo $carts['Shoppingcart']['cart_id']?>"><?php echo  $this->Html->image("remove_icn.jpg",array("alt" => "index")); ?></a></td>
            <td align="center" class="tdBdr bdrRightNone">Rs.
              <?php  echo indian_number_format(round($carts['Shoppingcart']['total'])*$carts['Shoppingcart']['quantity']);   ?></td>
          </tr>
          <?php
					 }
					}else{
					   echo "<tr><td>NO PRODUCT FOUND</td></tr>";
					}	?>
          <tr>
            <td colspan="5"></td>
          </tr>
          <tr>
            <td class="freeShippingDiv">Enjoy <span class="greenColor">FREE SHIPPING</span> on all orders !</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" class="tdBdr bdrRightNone"></td>
          </tr>
          <?php
      		  $cart_amount=ClassRegistry::init('Shoppingcart')->find('first',array('conditions'=>array('order_id'=>$order['Order']['order_id']),'fields'=>'SUM(quantity*total) AS subtotal'));
      		  $amount=$cart_amount['0']['subtotal'];  ?>
          <tr>
            <td class="tdBdr bdrRightNone">
            <?php
        			 if($this->Session->read('discount')!=''){
        				  $coupon_code=ClassRegistry::init('Discounthistory')->find('first',array('conditions'=>array('order_id'=>$order['Order']['order_id']))); 	?>
                        <span class="invalid" style="font-size:16px;color:#090" >This Coupon code  <?php echo $coupon_code['Discounthistory']['coupon_code']; ?>  Applied.</span>
                        <?php
                }else{	?>
              <form id="deliveryForm" name="myForm" method="post" action="<?php echo BASE_URL;?>orders/apply_discount">
                <p style="font-weight:bold; font-size:12px;">Enter Coupon Code/Voucher Code/Refferal Code</p> 
                <input id="coupon" name="coupon" type="text" style="width:180px;" class="validate[required] coupon" value="">
                &nbsp;<span class="fetch_value" style="display:none;"></span>
                <button class="apply" type="submit">apply</button>
              </form>
                <?php  } ?>
              <span class="invalid"></span></td>
            <td  colspan="2" style="padding-left:10px; text-align:right" class="tdBdr bdrRightNone">
              <h2 style="color:#6f6f6f; font-weight:bold;">Sub Total</h2><br/>
             <?php if($order['Order']['shipping_amt']>0){
				              $amount+=$order['Order']['shipping_amt']; ?>
              <h2 style="color:#6f6f6f; font-weight:bold;">Shipping&nbsp;Amount&nbsp;(<?php echo $order['Order']['shipping_per'];?>%)</h2> <br/>
             <?php }?> 
             <?php if($order['Order']['discount_amount']>0){
				            $amount-=$order['Order']['discount_amount']; ?>
             <h2 style="color:#6f6f6f; font-weight:bold;">Discount Amount <?php echo ($order['Order']['discount_per']>0?'('.$order['Order']['discount_per'].'%)':'');?></h2> <br/>
             <?php }?>   
             <h2 style="color:#6f6f6f; font-weight:bold;">Net&nbsp;Payable&nbsp;Amount</h2>          
            </td>
            <td  colspan="2" align="center" style="padding-left:10px; text-align:right" class="tdBdr bdrRightNone">
              <h2 style="color:#eab92d;">Rs. <?php echo indian_number_format($cart_amount['0']['subtotal']);?></h2><br/>

              <?php if($order['Order']['shipping_amt']>0){?>
              <h2 style="color:#eab92d;"> Rs. <?php echo indian_number_format($order['Order']['shipping_amt']);?></h2><br/>
              <?php }?>
              <?php if($order['Order']['discount_amount']>0){  ?>
                <h2 style="color:#eab92d;"> Rs. <?php echo indian_number_format($order['Order']['discount_amount']);?></h2><br/>  
              <?php } ?>
             <h2 style="color:#eab92d;">Rs. <?php echo indian_number_format($amount);?></h2>
            </td>
          </tr>
          <tr>
            <td colspan="5" height="">&nbsp;</td>
          </tr>
            <?php 
          			$partialpay=ClassRegistry::init('Partialpay')->find('first',array('conditions'=>array('partialpay_id'=>'1')));
          			$partialpay_percentage=$partialpay['Partialpay']['partialpay_per'];              
          					  
          			$orderstatus=ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' =>$this->Session->read('Order'))));
          			$ship_avail=ClassRegistry::init('Shippingrates')->find('count', array('conditions' => array('pincode' =>$orderstatus['Order']['spincode'])));
          			?>
          <tr>
            <td style="padding:10px;">
              <div class="continueBtn"><a href="<?php echo BASE_URL;?>webpages/jewellery">Continue Shopping</a>
              </div>
              <input type="hidden" name="ship_avail" id="ship_avail" value="<?php echo $ship_avail;?>">
              <input type="hidden" name="per" class="partialpercentage" value="<?php echo $partialpay_percentage;?>">
            </td>
                       
            <td colspan="2" style="padding-left:10px">
                <h2 style="color:#6f6f6f; font-weight:bold;">Payment Mode</h2><br>
                <div class="netamtpayable" style="display:none;">
                  <h2 style="color:#6f6f6f; font-weight:bold;">
                  <!--Partial Payment-->&nbsp;&nbsp;</h2>
                </div>
            </td>
            <td colspan="2" align="left">
                <form method="post" name="payment_mode" id="formSubmit">
                    <div class="payment_mode">
                        <?php $order1 = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $this->Session->read('Order'))));
                						$sesspay='';
                						if(!empty($order1)){
                							$sesspay=$order1['Order']['cod_status'];
                						}		?>
						          <input type="radio" name="cod_status" value="PayU" class="validate[required] radio" id="fullpay" <?php if($sesspay=='' || $sesspay=="PayU"){echo 'checked="checked"';}?>/>
                &nbsp; Full Payment<br />
                  <?php if(!empty($ship_avail)){?>
                        <input type="radio" name="cod_status"  value="COD"  class="validate[required] radio" id="partialpay" <?php if($sesspay=="COD"){echo 'checked="checked"';}?>/>&nbsp; 
                        Partial Payment (<?php echo round($partialpay_percentage);?>%)<br />
                  <?php }?>
                          <?php
					           if($this->Session->read('Franchisee.User.user_id')!='') { ?>
                         <input type="radio" name="cod_status" value="CHQ/DD" class="validate[required] radio"  id="chqddpay"/>&nbsp; CHQ/DD
                         <?php }?>
                        <input type="hidden" name="amountpay" class="amtpay" value="<?php  if(!empty($cart)) { echo round($amount); }?>" />
                    </div>
                    <div>
                        <h2 style="color:#eab92d; display: block; margin: 0 10px; padding: 10px 0 12px;" class="partialpay_amt"><?php if($sesspay=="COD"){ echo 'Rs. '.$order1['Order']['cod_amount']; }?></h2>
                    </div>
                    <div class="but_pay" align="">
                        <button class="apply" type="submit" name="data[Paymentdetails][payment]" value="payment" onClick="return ship_avail();">Proceed To Pay</button>
                    </div>
                  </form>
            </td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
        </table>
      </div>
      <div class="orderPayRight">
        <h2>Billing Address</h2>
        <p>
          <?php 					
				echo nl2br($order['Order']['billing_add']).'</br>';
				echo $order['Order']['blandmark'].',</br>';
				echo $order['Order']['city'].' - '.$order['Order']['pincode'].',</br>';
				echo $order['Order']['state'];
					?>
        </p>
        <h2>Shipping Address</h2>
        <p>
          <?php 
					echo nl2br($order['Order']['shipping_add']).'</br>';
				echo $order['Order']['slandmark'].',</br>';
				echo $order['Order']['scity'].' - '.$order['Order']['spincode'].',</br>';
				echo $order['Order']['sstate'];
					
					?>
        </p>
        <h2>Your Contact Details</h2>
        <p>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="130">Name</td>
            <td width="20">:</td>
            <td><?php echo $user['User']['first_name'];?>&nbsp;<?php echo $user['User']['last_name'];?></td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td>Mobile Number</td>
            <td>:</td>
            <td><?php echo $user['User']['phone_no'];?></td>
          </tr>
        </table>
        </p>
        <h2>Order Summary</h2>
        <?php
					foreach($cart as $carts) {
					$product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' =>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
					$category=ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' =>$product['Product']['category_id'])));
					
					$metals=ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id'],'type'=>'Purity')));
					$diamond=ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id'])));					
					if(!empty($carts['Shoppingcart']['clarity'])&& (!empty($carts['Shoppingcart']['color']))){
						$dc=$carts['Shoppingcart']['clarity'];
						$dcol=$carts['Shoppingcart']['color'];

					}else{
						$dc='';
						$dcol='';	
					}
					?>
        <p>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="130">Product Code </td>
            <td width="20">:</td>
            <td><?php echo $category['Category']['category_code'];?><?php echo $product['Product']['product_code'].'-'.$metals['Productmetal']['value'].'K'.$dc.$dcol;?></td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td>Product Name</td>
            <td>:</td>
            <td><?php echo $product['Product']['product_name'];?></td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td>Quantity</td>
            <td>:</td>
            <td><?php echo $carts['Shoppingcart']['quantity'];?></td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td>Total Amount</td>
            <td>:</td>
            <td>Rs. <?php echo indian_number_format($carts['Shoppingcart']['total']*$carts['Shoppingcart']['quantity']);?></td>
          </tr>
        </table>
        </p>
        <?php } ?>
      </div>
    </div>
    </p>
  </div>
  <!--<script>
$(document).ready(function(){
$('.remove').clik(function(){
thivar=$(this);
thisvar.parents('tr').remove();

});

});
</script>--> 
</div>
<script>
$(document).ready(function(){
$("#deliveryForm").validationEngine('attach', { 
		autoHidePrompt:true,
		autoHideDelay:50000,
		onValidationComplete: function(form, status){
			if (status == true) {	
		    var values=$('#coupon').val();
		    var amount=$('.amount').val();
		    	$("#deliveryForm").submit();
			}
		}
		
	});
});

</script> 
<script>
    $(document).ready(function(){
	  $("#formSubmit").validationEngine();
	   $("#deliveryForm").validationEngine();
	
    });
    function ship_avail(){
		var ship_avail=$('#ship_avail').val();	
		if(ship_avail=='0' && $("input[name='cod_status']:checked").val()=="COD"){
			 window.location="<?php echo BASE_URL ?>orders/shipping_details/sna";
			 return false;
		}
		else 
		{
			return true;
		}		
		return false;
	}
    
</script> 
<script type="text/javascript">
                 $(document).ready(function () {                   
                });
                 $('#partialpay').live('click',function () {
						
						var per=$('.partialpercentage').val();
						var amt=$('.amtpay').val();                  
					   $.ajax({
							url: "<?php echo BASE_URL;?>orders/partialpayment_amt",
							type:'POST',
							data: 'percentage=' +per+"&amount="+amt,
							dataType: 'json',
							success: function(data){
								$('.partialpay_amt').html(data);
								$('.partialpay_amt').show();
								
								$(".netamtpayable").css("display", "block");									 
							}
						});	 
						$('#fullpay').click(function(){	
							$('.partialpay_amt').hide();
							$('.netamtpayable').hide();
						 })
                    $('#chqddpay').click(function(){
						$('.partialpay_amt').hide();
						$('.netamtpayable').hide();
					})
                    
                    
                
               });
</script>