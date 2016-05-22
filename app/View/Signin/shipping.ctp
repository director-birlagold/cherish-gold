<?php
echo $this->Html->script(array('jquery.fancybox-1.3.4.pack'));
echo $this->Html->css(array('jquery.fancybox-1.3.4'));
?>
<script type="text/javascript">
$( "#tabs2" ).tabs({
		collapsible: true
	});
</script>
<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>

    <!--- New HTML Start -->

<div id="tabs2"  class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >

  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
      <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor" href="#tabs-3">SHIPPING DETAILS</a></li>
  </ul>

<div id="tabs-3">
                <p>
                <form action="" method="post" name="shipping_details" id="shipping_details">

                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Order Address</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><textarea name="data[Shipping][shipping_address]" cols="" rows="" class="validate[required,[minSize[10]]"></textarea></td>
                        </tr>
                        <tr>
                            <td>Landmark</td>
                        </tr>
                          
                        <tr>
                            <td><input name="data[Shipping][shipping_landmark]" type="text" class="validate[required]" ></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Pincode</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][shipping_pincode]" type="text" class="validate[required,custom[integer],[minSize[6]] pincode" onkeypress="return intnumbers(this, event)" maxlength="6"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>City</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][shipping_city]" type="text" class="validate[required]"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>State</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][shipping_state]" type="text" class="validate[required]"></td>
                        </tr>
                       <tr>
                            <td>Billing Address</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><textarea name="data[Shipping][billing_address]" cols="" rows="" class="validate[required,[minSize[10]]" ></textarea></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Landmark</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][billing_landmark]" type="text" class="validate[required]"></td>
                        </tr>

                        <tr><td height="10"></td></tr>


                        <tr>
                            <td>Pincode</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][pincode]" type="text" class="validate[required,custom[integer],[minSize[6]] pincode" onkeypress="return intnumbers(this, event)" maxlength="6"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>City</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][city]" type="text" class="validate[required]"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>State</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Shipping][state]" type="text" class="validate[required]"></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td> <input type="submit" class="button" id="nextBtn" value="Submit" /></td>
                        </tr>

                    </table>
                </form>
                </p>
            </div>
    </div>