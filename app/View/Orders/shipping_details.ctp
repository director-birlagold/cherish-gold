<div class="container">
<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible">
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top"><a href="<?php echo BASE_URL;?>orders/personal_details" class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a class="ui-tabs-anchor" >SHIPPING DETAILS</a></li>
<li class="ui-state-default ui-corner-top"><a  <?php if($this->Session->read('Order')!='') {  echo 'href="'.BASE_URL.'orders/order"'; } ?> class="ui-tabs-anchor">REVIEW ORDER AND PAY</a></li>
</ul>

<div id="tabs-3">
    <p>
 <form action="" method="post" name="Order_details" id="formSubmit" class="new_shipping_details_div_box">

                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Shipping Address</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><textarea name="data[Order][shipping_add]" cols="" rows="" class="validate[required,minSize[10]]" id="shipping_address"><?php  if(!empty($order)) { echo $order['Order']['shipping_add']; } if(!empty($shipping)) { echo $shipping['Shipping']['shipping_address'];  } ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Landmark</td>
                        </tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td><input name="data[Order][slandmark]" type="text" value="<?php  if(!empty($order)) { echo $order['Order']['slandmark']; } if(!empty($shipping)) { echo $shipping['Shipping']['shipping_landmark'];  } else {  echo ''; }?>" id="shipping_landmark" /></td>
                        </tr>
 <tr>
                            <td>Pincode</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Order][spincode]" type="text" class="validate[required,custom[integer],[minSize[6]] spincode" onkeypress="return intnumbers(this, event)" value="<?php  if(!empty($order)) { echo $order['Order']['spincode']; } if(!empty($shipping)) { echo $shipping['Shipping']['shipping_pincode'];  }else { echo ''; }?>" maxlength="6" id="shipping_pincode"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>City</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Order][scity]" type="text" class="validate[required]"  value="<?php  if(!empty($order)) { echo $order['Order']['scity']; } if(!empty($shipping)) { echo $shipping['Shipping']['shipping_city'];  }else { echo ''; }?>" id="shipping_city"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>State</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                       <tr>
                            <td>
								<?php
									$states = array('Andaman and Nicobar Islands' =>'Andaman and Nicobar Islands',
									'Andhra Pradesh' =>'Andhra Pradesh',
									'Arunachal Pradesh' =>'Arunachal Pradesh',
									'Assam' =>'Assam',
									'Bihar' =>'Bihar',
									'Chandigarh' =>'Chandigarh',
									'Chhattisgarh' =>'Chhattisgarh',
									'Dadra and Nagar Haveli' =>'Dadra and Nagar Haveli',
									'Daman and Diu' =>'Daman and Diu',
									'New Delhi' =>'New Delhi',
									'Goa' =>'Goa',
									'Gujarat' =>'Gujarat',
									'Haryana' =>'Haryana',
									'Himachal Pradesh' =>'Himachal Pradesh',
									'Jammu and Kashmir' =>'Jammu and Kashmir',
									'Jharkhand' =>'Jharkhand',
									'Karnataka' =>'Karnataka',
									'Kerala' =>'Kerala',
									'Lakshadweep' =>'Lakshadweep',
									'Madhya Pradesh' =>'Madhya Pradesh',
									'Maharashtra' =>'Maharashtra',
									'Manipur' =>'Manipur',
									'Meghalaya' =>'Meghalaya',
									'Mizoram' =>'Mizoram',
									'Nagaland' =>'Nagaland',
									'Odisha' =>'Odisha',
									'Puducherry' =>'Puducherry',
									'Punjab' =>'Punjab', 
									'Rajasthan' =>'Rajasthan',
									'Sikkim' =>'Sikkim',
									'Tamil Nadu' =>'Tamil Nadu' ,
									'Telangana' =>'Telangana',
									'Tripura' =>'Tripura',
									'Uttar Pradesh' =>'Uttar Pradesh',
									'Uttarakhand' =>'Uttarakhand',
									'West Bengal' =>'West Bengal');
								/*
								?>
							
							<input name="data[Order][sstate]" type="text" class="validate[required]" value="<?php  if(!empty($order)) { echo $order['Order']['sstate']; } if(!empty($shipping)) { echo $shipping['Shipping']['shipping_state'];  }else { echo ''; }?>">
							<?php */?>
							<select name="data[Order][sstate]" id="shipping_state">
							<?php
								$options = '';
								if(!empty($shipping)) {
									$sel_state = $shipping['Shipping']['shipping_state'];
								}else if(!empty($order)) { 
									$sel_state = $order['Order']['sstate'];
								}else {
									$sel_state = '';
								}
								
								foreach ($states as $state) {
									if($sel_state == $state){
										$options .= '<option value="'.$state.'" selected>'.$state.'</option>'."\n";
									}else{
										$options .= '<option value="'.$state.'" >'.$state.'</option>'."\n";
									}
								}
								echo $options;
							?>
							</select>
							</td>
                        </tr>
                        <tr><td height="10"></td></tr>
                         <tr>
                            <td><strong>Same as above</strong> &nbsp;&nbsp;<input type="checkbox" name="sameasabove"  id="check-address"/></td>
                        </tr>
                         <tr><td height="10"></td></tr>
                         <tr><td> </td></tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Billing Address</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><textarea name="data[Order][billing_add]" cols="" rows="" class="validate[required,minSize[10]]" id="billing_address"><?php  if(!empty($order)) { echo $order['Order']['billing_add']; } if(!empty($shipping)) { echo $shipping['Shipping']['billing_address'];  } else {  echo ''; }?></textarea></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>Landmark</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Order][blandmark]" type="text" class="validate[required]" value="<?php  if(!empty($order)) { echo $order['Order']['blandmark']; } if(!empty($shipping)) { echo $shipping['Shipping']['billing_landmark'];  }else {  echo ''; }?>" id="billing_landmark"/></td>
                        </tr>

                        <tr><td height="10"></td></tr>


                        <tr>
                            <td>Pincode</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Order][pincode]" type="text" class="validate[required,custom[integer],[minSize[6]] pincode" onkeypress="return intnumbers(this, event)" value="<?php  if(!empty($order)) { echo $order['Order']['pincode']; } if(!empty($shipping)) { echo $shipping['Shipping']['pincode'];  }else { echo ''; }?>" maxlength="6" id="billing_pincode"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>City</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td><input name="data[Order][city]" type="text" class="validate[required]"  value="<?php  if(!empty($order)) { echo $order['Order']['city']; } if(!empty($shipping)) { echo $shipping['Shipping']['city'];  }else { echo ''; }?>" id="billing_city"></td>
                        </tr>

                        <tr><td height="10"></td></tr>
                        <tr>
                            <td>State</td>
                        </tr>
                        <tr><td height="10"></td></tr>

                        <tr>
                            <td>
							<?php /*
							 <input name="data[Order][state]" type="text" class="validate[required]" value="<?php  if(!empty($order)) { echo '1'.$order['Order']['state']; } if(!empty($shipping)) { echo '2'.$shipping['Shipping']['state'];  }else { echo ''; }?>"> 
							 
							 */
							 if(!empty($shipping)) {
									$sel_state1 = $shipping['Shipping']['shipping_state'];
								}else if(!empty($order)) { 
									$sel_state1 = $order['Order']['state'];
									//echo $sel_state1;
									} else {
									$sel_state1 = '';
								}
								
							 ?>
							<select name="data[Order][state]" id="billing_state">
							<?php
								$options1 = '';
								
								foreach ($states as $state1) {
									if($sel_state1 == $state1){
										$options1 .= '<option value="'.$state1.'" selected>'.$state1.'</option>'."\n";
									}else{
										$options1 .= '<option value="'.$state1.'" >'.$state1.'</option>'."\n";
									}
								}
								echo $options1;
							?>
							</select>
							</td>
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
<script>
        $(document).ready(function () {
         $("#formSubmit").validationEngine();

        });
    </script>
    
    
<script>
$(document).ready(function () {
	$('#check-address').click(function(){
        if($('#check-address').attr('checked')){
            $('#billing_address').val($('#shipping_address').val());
			$('#billing_landmark').val($('#shipping_landmark').val());
			$('#billing_pincode').val($('#shipping_pincode').val());
			$('#billing_city').val($('#shipping_city').val());
			state_val = $('#shipping_state').val();
			$('#billing_state option[value='+state_val+']').attr('selected','selected');
			//$('#billing_state').val($('#shipping_state').val());
			          
           
        } else { 
            //Clear on uncheck
            $('#billing_address').val("");
            $('#billing_landmark').val("");
            $('#billing_pincode').val("");
			$('#billing_city').val("");
			$('#billing_state').val("");
            
        };

    });
	
	});
</script>    