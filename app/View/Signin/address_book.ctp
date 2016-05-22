<style>
.billingAddDiv {
    border: 1px solid rgb(204, 204, 204);
    float: left;
    line-height: 25px;
    padding: 15px 50px 15px 15px;
    width: 670px;
}
.addressBdrRight {
    border-right: 1px solid rgb(204, 204, 204);
    padding-right: 10px;
}
</style>
<div class="main">
<header> &nbsp; </header>
<div style="clear:both;">&nbsp;</div>

<!--- New HTML Start -->

<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
<div id="" class="tabsDiv">
	<div class="middleContent">
    	<h2>Account Dashboard</h2>
        <p> Manage your personal information and track your orders by clicking the sections below. Your Order items are not the same as your cart items(link at the top of this page).
The cart is the set of items that have been readied for purchase but have not been paid for. </p>
    </div>
  </div>
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a  href="<?php echo BASE_URL ?>signin/details"  class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo BASE_URL ?>signin/address_book"  class="ui-tabs-anchor">Address Book</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a  class="ui-tabs-anchor" href="<?php echo BASE_URL ?>orders/my_order">My Order</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/wishlist"  class="ui-tabs-anchor">Wishlist</a></li>
</ul>
<div id="tabs-1" class="">
<p></p>
<div class="account_details">


        <div class="account_details">
            	<h2>Billing Address</h2>
                <p>Add or edit billing and shipping addresses. You can have one Billing address and upto 3 shipping addresses</p>
               
                   <?php $i=0; foreach($address as $addres){  if($i==0) { if($addres['Shippingdetails']['billing_address']!='') { ?>
                    <div class="billingAddDiv">
                   <?php  echo nl2br($addres['Shippingdetails']['billing_address']); ?> <br>
                                 <?php  echo $addres['Shippingdetails']['city']; ?> <br>
                                  <?php  echo $addres['Shippingdetails']['state']; ?> <br>
                                 <?php  echo $addres['Shippingdetails']['pincode']; ?><br>                               
                                  <?php  echo $addres['Shippingdetails']['billing_landmark']; ?>   <br>
                                  
                   
                    <a href="<?php  echo BASE_URL."signin/billing_address/edit"; ?>" style="color:rgb(198, 166, 66)">Edit Address</a>     
                    <?php } else { ?> 
                    <a href="<?php  echo BASE_URL."signin/billing_address"; ?>">Add Billing Address</a>         	
                    <?php } ?>
                </div>

                  <div style="clear:both;">&nbsp;</div>

            	<h2>Shipping Address</h2>
                <p>Select a default shipping address by choosing the appropriate radio button  &nbsp;&nbsp;&nbsp;&nbsp;<?php if($count<3) { ?><a href="<?php  echo BASE_URL."signin/shipping_address"; ?>">Add New Shipping Address</a><?php } ?></p>
                <div class="billingAddDiv">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    	<tbody><tr>
                        <?php } if($addres['Shippingdetails']['shipping_address']!='') {  ?>
                        	<td class=" <?php if($count!=$i+1) {  ?>addressBdrRight  <?php }  ?>">
                                 <?php  echo nl2br($addres['Shippingdetails']['shipping_address']); ?> <br>
                    <?php  echo $addres['Shippingdetails']['shipping_city']; ?> <br>
                    <?php  echo $addres['Shippingdetails']['shipping_state']; ?><br>
                    <?php  echo $addres['Shippingdetails']['shipping_pincode']; ?> <br>
                    <?php  echo $addres['Shippingdetails']['shipping_landmark']; ?> <br>
<a href="<?php echo BASE_URL."signin/shipping_address/".$addres['Shippingdetails']['shipping_id']; ?>" style="color:rgb(198, 166, 66)">Edit Address</a><br>
<input type="radio" value="" <?php if($addres['Shippingdetails']['default']==1) {  echo "checked" ;} ?> id="<?php $addres['Shippingdetails']['shipping_id']; ?>" name="checkbox_default" onclick="change_default(<?php echo $addres['Shippingdetails']['shipping_id']; ?>);"> &nbsp;Default address<br>                
                            </td>
                           
                            <td width="20"></td>
                          
                        	<?php } $i++; } ?>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <?php if($i==0) { ?> <a href="<?php  echo BASE_URL."signin/billing_address"; ?>" style="color:rgb(198, 166, 66)">Add Billing Address</a>  </div>
                
                  <div style="clear:both;">&nbsp;</div>

            	<h2>Shipping Address</h2>
                <p>Select a default shipping address by choosing the appropriate radio button  &nbsp;&nbsp;&nbsp;&nbsp;<a style="color:rgb(198, 166, 66)" href="<?php  echo BASE_URL."signin/shipping_address"; ?>">Add New Shipping Address</a></p> 
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    	<tbody><tr> <td class="addressBdrRight">   </tr> <?php } ?>
                    </tbody></table>	              	
              
                	
            </div>
  </div>
  </div>
  </div>
  <div style="clear:both;">&nbsp;</div>
  
<script>
function change_default(val)
{
	$.ajax({
        url: '<?php echo BASE_URL."/signin/update_default/" ?>'+val, 
        type: "post",        
        success: function(){
           $('#'+val).prop('checked', true);
        }
    });       
}
</script>

</body>
</html>
