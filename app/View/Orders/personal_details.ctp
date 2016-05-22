
<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>
<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top  ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top"><a <?php if($this->Session->read('Order')!='') { echo' href="'.BASE_URL.'orders/shipping_details" '; } ?> class="ui-tabs-anchor" >SHIPPING DETAILS</a></li>
<li class="ui-state-default ui-corner-top"><a <?php if($this->Session->read('Order')!='') { echo 'href="'.BASE_URL.'orders/order"'; } ?> class="ui-tabs-anchor" >REVIEW ORDER AND PAY</a></li>
</ul>

<div id="tabs-2">
	<p>
      <form action="" method="post" name="personal_details" id="formSubmit">	
    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
        	<tr>
            	<td colspan="4">Title</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr> 
        	<tr>
            	 <td colspan="4"><select  style="width:100px;" name="data[User][title]" class="validate[required] title">
                                    <option value="">Select</option>
                                    <option <?php if(!empty($user['User']['title'])) { echo $user['User']['title']=="Mr"?'selected="selected"':'';  }?> value="Mr">Mr.</option>
                                    <option <?php if(!empty($user['User']['title'])) { echo $user['User']['title']=="Ms"?'selected="selected"':'';  }?> value="Ms">Ms.</option>
                                    <option <?php if(!empty($user['User']['title'])) { echo $user['User']['title']=="Mrs"?'selected="selected"':'';  }?> value="Mrs">Mrs.</option> 
                                    <option <?php if(!empty($user['User']['title'])) { echo $user['User']['title']=="Miss"?'selected="selected"':'';  }?> value="Miss">Miss.</option></select></td>
            </tr>

            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	<td colspan="4">Name</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	 <td colspan="4"><input name="data[User][first_name]"  type="text" style="width:150px;" class="validate[required] first_name" value="<?php if(!empty($user['User']['first_name'])) { echo $user['User']['first_name'];  } ?>"> &nbsp; <input name="data[User][last_name]"  type="text" style="width:151px;" class="validate[required] last_name" value="<?php if(!empty($user['User']['last_name'])) { echo $user['User']['last_name'];  }?>"> </td></td>
            </tr>

            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	<td colspan="4">Mobile Number</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
  <td colspan="4"><input name="data[User][phone_no]" type="text" class="validate[required,custom[integer],minSize[10]] mobile" onkeypress="return intnumbers(this, event)" value="<?php if(!empty($user['User']['phone_no'])) { echo $user['User']['phone_no'];  } else { } ?>" maxlength="10"></td>
              </tr>

            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	<td colspan="4">Email-ID</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	 <td colspan="4"><input name="data[User][email]" type="text" class="validate[required,custom[email]] email"  value="<?php if(!empty($user['User']['email'])) { echo $user['User']['email'];  } ?>"></td>
            </tr>
             <tr><td colspan="4" height="10"></td></tr>
            <tr>
            	<td colspan="4">Address</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
        	<tr>
            	 <td colspan="4"><textarea name="data[User][address]" class="address"><?php if(!empty($user['User']['address'])) { echo $user['User']['address'];  } else { } ?></textarea></td>
            </tr>
            
            
            <tr><td colspan="4">&nbsp;</td></tr>

            <tr>
            	<td colspan="4"><h3> Your Memorable Days</h3></td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
            <tr>
            	<td colspan="4">Let Us Surprise You!</td>
            </tr>
            <tr><td colspan="4" height="10"></td></tr>
          
                            <td width="100">Birthday</td>
                            <td width="20">:</td>
                            <td width="116">
                            <?php  $dob=$user['User']['date_of_birth'];
							if(!empty($dob)){
								if(count(explode("-",$dob))>=3){
									list($year,$month,$day) = split('[/.-]', $dob);
								}
							}
							?>
                            <select name="data[User][date]" style="width:110px;" class="date"><option value="">DD</option>
                                    <?php
                                    for ($i = 1; $i < 32; $i++) { ?>
                                    <?php if(!empty($day)){?>
                                    <option value="<?php echo $i;?>"<?php if ($i == $day) { echo 'selected="selected"';  }else{} ?>><?php echo $i;?>
                                                              
                                    </option>
                                     <?php }else{?> 
                                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                     <?php }?>
                                     <?php
                                    }
                                    ?>
                                </select></td>
                            <td width="116"><select name="data[User][month]" style="width:110px;float:left;" class="month"><option value="">MM</option>
                                    <?php
                                    for ($i = 01; $i < 13; $i++) { ?>
                                    <?php if(!empty($month)){?>
                                     <option value="<?php echo $i;?>" <?php if ($i == $month) { echo 'selected="selected"';  } ?>><?php echo date('F', strtotime('01.' . $i . '.2001'));?></option>                          <?php }else{?> 
                                      <option value="<?php echo $i;?>"><?php echo date('F', strtotime('01.' . $i . '.2001'));?></option>
                                       <?php }?>
                                     <?php
                                       
                                    }
                                    ?>
                                </select></td>
                                <td><select name="data[User][year]" style="width:110px;float:left;" class="month"><option value="">YYYY</option>
                                    <?php
                                    for ($i = 1980; $i <2015; $i++) { ?>
                                     <?php if(!empty($year)){?>
                                     <option value="<?php echo $i;?>"<?php if ($i ==$year) { echo 'selected="selected"';  } ?>><?php echo $i;?></option>
                                         <?php }else{?> 
                                           <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php }?> 
                                     <?php
                                       
                                    }
                                    ?>
                                </select></td>
                        </tr>
                        <tr><td colspan="4" height="10"></td></tr>
                        <tr class="anniversary">
                            <td>Anniversary</td>
                            <td>:</td>
                            <td>
                            <?php
                             $anniversary=$user['User']['anniversary'];
							 if(!empty($anniversary)){
								if(count(explode("-",$anniversary))>=3){
									list($ayear,$amonth,$aday) = split('[/.-]', $anniversary);
								}
							 }
							?>
                            <select name="data[User][annu_date]" style="width:110px;" ><option value="">DD</option>
                                  <?php
                                    for ($i = 1; $i < 32; $i++) { ?>
                                     <?php if(!empty($aday)){?>
                                    <option value="<?php echo $i;?>"<?php if ($i == $aday) { echo 'selected="selected"';  } ?>><?php echo $i;?></option>
                                      <?php }else{?> 
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                      <?php }?>
                                     <?php
                                    }
                                    ?>
                                </select></td>
                            <td><select name="data[User][annu_month]" style="width:110px;" ><option value="">MM</option>
                                   <?php
                                    for ($i = 01; $i < 13; $i++) { ?>
                                     <?php if(!empty($amonth)){?>
                                     <option value="<?php echo $i;?>"<?php if ($i == $amonth) { echo 'selected="selected"'; } ?> ><?php echo date('F', strtotime('01.' . $i . '.2001'));?>
                                     </option>
                                      <?php }else{?> 
                                      <option value="<?php echo $i;?>"><?php echo date('F', strtotime('01.' . $i . '.2001'));?></option>
                                     <?php
                                       
                                    }}
                                    ?>
                                </select></td>
                                 <td><select name="data[User][annu_year]" style="width:110px;" class="year"><option value="">YYYY</option>
                                    <?php
                                    for ($i = 1980; $i <2015; $i++) { ?>
                                     <?php if(!empty($ayear)){?>
                                     <option value="<?php echo $i;?>"<?php if ($i == $ayear) { echo 'selected="selected"'; } ?>><?php echo $i;?></option>
                                      <?php }else{?> 
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                     <?php
									  }
                                    }
                                    ?>
                                </select></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr><td colspan="4"><input type="submit" class="button" id="nextBtn" value="Save" /></td></tr>
            
            

        </table>
    </p>
</div>
</div>
<script>
        $(document).ready(function () {
         $("#formSubmit").validationEngine();

        });
    </script>