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
        	<div class="orderPayLeft">
            	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td class="thBdr" align="left" width="300"><strong>Description</strong></td>
                    	<td class="thBdr" align="center"><strong>Price</strong></td>
                    	<td class="thBdr" align="center"><strong>Quantity</strong></td>
                    	<td class="thBdr" align="center"><strong>Remove</strong></td>
                    	<td class="thBdr bdrRightNone" align="center"><strong>Total</strong></td>
                    </tr>
                    <?php
					if(!empty($cart)) {
					$amount='';
					foreach($cart as $carts) {
					$product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' =>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
					$images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
					$tamount=$carts['Shoppingcart']['total']*$carts['Shoppingcart']['quantity'];
					$amount+=$tamount;
					
					?>
                	<tr>
                    	<td class="tdBdr">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td><?php  echo $this->Html->image('product/small/'.$images['Productimage']['imagename'] ,array("alt" => "index","height"=>"100","width"=>"120")); ?></td>
                                    <td><?php echo $product['Product']['product_name'];?> <br /><br /> 
                                    	<!--<span class="wishlist_icn"><a href="<?php echo BASE_URL;?>orders/movetowishlist"> Move to Wishlist</a></span>-->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    	<td align="center" class="tdBdr">Rs. <?php echo indian_number_format($carts['Shoppingcart']['total']);?></td>
                    	<td align="center" class="tdBdr fetch"><?php echo $carts['Shoppingcart']['quantity'];?>&nbsp;&nbsp;</td>
                         <td valign="top" class="quantity_change" style="display:none;"><select name="data[Shoppingcart][quantity]" class="quantity" >
						<?php
                        for($i=1;$i<=10;$i++){
                        ?>
                        <?php echo '<option value="'.$i.'" ' . ($carts['Shoppingcart']['quantity'] == $i ? 'selected="selected"' : '') . ' >'.$i.'</option>';?>
                        <?php } ?>
                        </select>
                        </td>
                    	<td align="center" class="tdBdr"><a href="<?php echo BASE_URL;?>orders/delete/<?php echo $carts['Shoppingcart']['cart_id']?>"><?php echo  $this->Html->image("remove_icn.jpg",array("alt" => "index")); ?></a></td>
                    	<td align="center" class="tdBdr bdrRightNone">Rs.<?php echo indian_number_format($carts['Shoppingcart']['total']*$carts['Shoppingcart']['quantity']);  ?></td>
                    </tr>
                    <?php
					}
					}
					else
					{
					echo "<tr><td>NO PRODUCT FOUND</td></tr>";
					}
					
					?>
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
					 /*  $date=date('Y-m-d');
					  $coupon=ClassRegistry::init('Discount')->find('first',array('conditions' => array('"'.$date.'" BETWEEN Discount.start_date AND  Discount.expired_date', 'Discount.user_id'=>$this->Session->read('User.user_id'),'type'=>'User','Discount.status'=> 'Active')));*/
                  
				   
				   ?>
                   <tr>
                    <input type="hidden" name="amount" value="<?php echo $amount;?>" class="amount" />
                    	<!--<td colspan="2" class="tdBdr bdrRightNone" <?php //if(!empty($coupon)) { ?> style="display:block;" <?php // } else {  echo 'style="display:block;"';} ?>>
                        	<form id="deliveryForm" name="myForm" method="post">Apply shagunn coupon <br /><br />
                            <input name="coupon" type="text" style="width:180px;" class="validate[required] coupon" value=""> &nbsp;<span class="fetch_value" style="display:none;"></span> <button class="apply" type="submit">apply</button></form>
                            <span class="invalid"></span>
                        </td>-->
                    	  <td align="center" class="tdBdr bdrRightNone"></td>
                          <td align="center" class="tdBdr bdrRightNone"></td>
                        <td colspan="2" class="tdBdr bdrRightNone">
                        <!--	<h2 style="color:#6f6f6f;">Discount Amount</h2><br />-->
                            <h2 style="color:#6f6f6f; font-weight:bold;">Net Amount Payable</h2>
                        </td>
                        <td align="center" class="tdBdr bdrRightNone">
                        	<!--<h2 class="greenColor">Rs. 500</h2><br />-->
                            <h2 style="color:#eab92d;">Rs. <?php  if(!empty($cart)) { echo indian_number_format($amount); }?></h2>
                        </td>
                         
                    </tr>
                   <tr><td colspan="5" height=""></td></tr>
                   
                    <?php
					if($this->Session->read('Franchisee.User.user_id')=='') { ?>
                    <tr>
                   		<td><div class="continueBtn"><a href="<?php echo BASE_URL;?>webpages/jewellery">Continue Shopping</a></div></td>
                         <td></td>
                         <td colspan="2"> <h2 style="color:#6f6f6f; font-weight:bold;">Payment Mode</h2> </td>
                        <td colspan="3" align="left">
                        <form method="post" name="payment_mode" id="userSubmit">
                        <div class="payment_mode">
                        <input type="radio" name="cod_status" value="PayU" class="validate[required] radio"  checked="checked"/>&nbsp; PayU<br />
                         <input type="radio" name="cod_status" value="CHQ/DD" class="validate[required] radio" />&nbsp; CHQ/DD
                        <input type="hidden" name="amountpay" value="<?php  if(!empty($cart)) { echo $amount; }?>" />
                        </div>
                        <div class="but_pay" align="center">
                        <button class="apply" type="submit" name="data[Paymentdetails][payment]" value="payment">Proceed To Pay</button>
                        </div>
                        </div>
                       </form>
                        
                        </td>
                        
                        </tr>                     
                      
                      <?php } else {
						  
						  $orderstatus=ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' =>$this->Session->read('Order'))));
						 
						   ?>
                      <tr>
                   		<td><div class="continueBtn"><a href="<?php echo BASE_URL;?>webpages/jewellery">Continue Shopping</a></div></td>
                         <td></td>
                         <td colspan="2"> <h2 style="color:#6f6f6f; font-weight:bold;">Payment Mode</h2> </td>
                        <td colspan="3" align="left">
                        <form method="post" name="payment_mode" id="formSubmit">
                        <div class="payment_mode">
                        <input type="radio" name="cod_status" value="COD"  class="validate[required] radio"/>&nbsp; COD (30%)
                        <input type="radio" name="cod_status" value="PayU" class="validate[required] radio"  checked="checked"/>&nbsp; PayU<br />
                         <input type="radio" name="cod_status" value="CHQ/DD" class="validate[required] radio" />&nbsp; CHQ/DD
                        <input type="hidden" name="amountpay" value="<?php  if(!empty($cart)) { echo $amount; }?>" />
                        </div>
                        <div class="but_pay" align="center">
                        <button class="apply" type="submit" name="data[Paymentdetails][payment]" value="payment">Proceed To Pay</button>
                        </div>
                        </div>
                       </form>
                        
                        </td>
                        
                        </tr>                     
                      
                      <?php  } ?>
                   <tr><td colspan="5">&nbsp;</td></tr>
				</table>
            </div>
        	
            <div class="orderPayRight">
            	<h2>Billing Address</h2>
                <p>
                    <?php echo $order['Order']['billing_add'];?>
                </p>

            	<h2>Your Contact Details</h2>
                <p>
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                        	<td width="130">Name</td>
                        	<td width="20">:</td>
                        	<td><?php echo $user['User']['first_name'];?>&nbsp;<?php echo $user['User']['last_name'];?></td>
                        </tr>
                        <tr><td colspan="3" height="10"></td></tr>
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
					?>
                <p>
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                        	<td width="130">Product Code </td>
                        	<td width="20">:</td>
                        	<td><?php echo $category['Category']['category_code'];?><?php echo $product['Product']['product_code'];?></td>
                        </tr>
                        <tr><td colspan="3" height="10"></td></tr>
                    	<tr>
                        	<td>Product Name</td>
                        	<td>:</td>
                        	<td><?php echo $product['Product']['product_name'];?></td>
                        </tr>
                        <tr><td colspan="3" height="10"></td></tr>
                    	<tr>
                        	<td>Quantity</td>
                        	<td>:</td>
                        	<td><?php echo $carts['Shoppingcart']['quantity'];?></td>
                        </tr>
                        <tr><td colspan="3" height="10"></td></tr>
                    	
                        <tr><td colspan="3" height="10"></td></tr>
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
		   var values=$('.coupon').val();
		   var amount=$('.amount').val();
		    $.ajax({
                      url: "<?php echo BASE_URL;?>orders/coupon",
                      type:'POST',
                       data: 'value=' +values+"&amount="+amount,
					   dataType: 'json',
                       success: function(msg){
						 if(msg.check=='20')
						  {
							  $('.apply').hide();
							  $('.fetch_value').show();
							   $('.fetch_value').html(msg.val);
							   $('.invalid').hide();
							   $('.netamount').html(msg.net);
							   $('.headdis').show();
							   $('.discount').show();
							     $('.discountamount').html(msg.discount);
							}
							else
							{
								$('.invalid').html(msg.val);
							}
						 
					  }
		 });
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
</script>