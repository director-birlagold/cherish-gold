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
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a  class="ui-tabs-anchor">My Order</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/wishlist"  class="ui-tabs-anchor">Wishlist</a></li>
</ul>
<div id="tabs-1" class="">
<p></p>
<div class="account_details">


        <div class="account_details">
            	<h2><?php if(isset($this->params['pass']['0'])) { echo "Edit"; } else { echo "Add"; } ?> Shipping Address</h2>
                <p>&nbsp;</p>
                    <form action="" method="post" name="Order_details" id="formSubmit">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Shipping Address</td>
                        </tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td><textarea name="data[Shippingdetails][shipping_address]" cols="" rows="" class="validate[required,[minSize[10]]"><?php if(isset($user['Shippingdetails']['shipping_address'])) echo $user['Shippingdetails']['shipping_address'];  ?></textarea></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Landmark</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shippingdetails][shipping_landmark]" type="text" class="validate[required]" value="<?php if(isset($user['Shippingdetails']['shipping_landmark'])) echo $user['Shippingdetails']['shipping_landmark'];  ?>" /></td>
                        </tr>

                        <tr><td height="10"></td></tr>


                        <tr>
                            <td>Pincode</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shippingdetails][shipping_pincode]" type="text" class="validate[required,custom[integer],[minSize[6]] pincode" onkeypress="return intnumbers(this, event)" value="<?php if(isset($user['Shippingdetails']['shipping_pincode'])) echo $user['Shippingdetails']['shipping_pincode'];  ?>" maxlength="6"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>City</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shippingdetails][shipping_city]" type="text" class="validate[required]"  value="<?php if(isset($user['Shippingdetails']['shipping_city'])) echo $user['Shippingdetails']['shipping_city'];  ?>"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>State</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shippingdetails][shipping_state]" type="text" class="validate[required]" value="<?php if(isset($user['Shippingdetails']['shipping_state'])) echo $user['Shippingdetails']['shipping_state'];  ?>"></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td> <input type="submit" class="button" id="nextBtn" name="nextBtn" value="Submit" /></td>
                        </tr>

                    </table>
                </form>           	
                </div>
                	
            </div>
  </div>
  </div>
  </div>
  <div style="clear:both;">&nbsp;</div>
  


</body>
</html>
<script>
        $(document).ready(function () {
         $("#formSubmit").validationEngine();

        });
    </script>