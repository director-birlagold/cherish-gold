<script>
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
 if(key != ','){
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }else{
	return true;
  }
  }
}
</script>
<?php echo $this->Html->script(array('ui/jquery.ui.datepicker')); ?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Franchisee Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data">   
            <fieldset><legend>Edit Franchisee</legend>
                <dl class="inline">

                    <fieldset><legend>Personal Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Title<span class="required">*</span></label></dt>

                            <dd>
                                <input type="radio" name="data[User][title]" value="Mr"  class="validate[required] radio title" <?php
                                if ($user['User']['title'] == 'Mr') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Mr &nbsp;
                                <input type="radio" name="data[User][title]" value="Ms"  class="validate[required] radio title" <?php
                                if ($user['User']['title'] == 'Ms') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Ms &nbsp;
                                <input type="radio" name="data[User][title]" value="Mrs"  class="validate[required] radio title" <?php
                                if ($user['User']['title'] == 'Mrs') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Mrs &nbsp;
                                <input type="radio" name="data[User][title]" value="Others"  class="validate[required] radio title" <?php
                                if ($user['User']['title'] == 'Others') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Others &nbsp;
                                <input type="text" name="data[User][other]" class="validate[required] other" <?php
                                if ($user['User']['title'] != 'Others') {
                                    echo 'style="display:none;"';
                                } else {
                                    
                                }
                                ?> size="30" value="<?php echo $user['User']['other']; ?>"/>

                            </dd>

                            <dt><label for="name">First Name<span class="required">*</span></label></dt>     
                            <dd><input type="text" name="data[User][first_name]" id="first_name"  class="validate[required,custom[onlyLetterSp]]" size="50" value="<?php echo $user['User']['first_name']; ?>"  /></dd>
                            <dt><label for="name">Last Name<span class="required">*</span></label></dt>     
                            <dd><input type="text" name="data[User][last_name]" id="last_name"  class="validate[required,custom[onlyLetterSp]]" size="50" value="<?php echo $user['User']['last_name']; ?>"  /></dd>

                            <dt><label for="name">DOB</label></dt>   
                            <dd><input type="text"  readonly name="data[User][date_of_birth]" id="enddate"  size="50" value="<?php echo $user['User']['date_of_birth']; ?>"/></dd>

                            <dt><label for="name">Martial Status<span class="required">*</span></label></dt>  
                            <dd><input type="radio" name="data[User][martial_status]" value="Married"  class="validate[required] radio" <?php
                                if ($user['User']['martial_status'] == 'Married') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Married &nbsp;
                                <input type="radio" name="data[User][martial_status]" value="Unmarried"  class="validate[required] radio" <?php
                                if ($user['User']['martial_status'] == 'Unmarried') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Unmarried &nbsp;      </dd>

                            <dt><label for="name">PAN Number<span class="required">*</span></label></dt>   
                            <dd><input type="text" name="data[User][pan_no]" class="validate[required,custom[pan]]" id="pannumber" size="50" value="<?php echo $user['User']['pan_no']; ?>"/></dd>
                            <dt><label for="name">&nbsp;</label></dt> 
                            <dd><label for="name" style="font-weight:bold;">Eg : The Pancard format is ABCDE1234Z</label></dd></dd>

                            <dt><label for="name">Address<span class="required">*</span></label></dt>   
                            <dd><textarea rows="3" cols="50" class="validate[required]"  name="data[User][address]"><?php echo $user['User']['address']; ?></textarea></dd>

                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[User][city]" id="city"  class="validate[required]" size="50" value="<?php echo $user['User']['city']; ?>"  /></dd>

                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[User][state]" class="validate[required]" id="state">
                                    <option value="">State</option>
                                    <?php
                                    foreach ($state as $states) {
                                        if (isset($user['User']['state']) && $user['User']['state'] == $states['State']['state']) {
                                            echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
                                        } else {
                                            echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select></dd>

                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><textarea name="data[User][pincode]" id="regpincode"  onkeypress="return validate(event)" class="validate[required]" size="50"><?php echo $user['User']['pincode']; ?></textarea></dd>
							<!--<dd><input type="text" name="data[User][pincode]" id="regpincode" onkeypress="return intnumbers(this, event)" maxlength="6"  class="validate[required,custom[integer],minSize[6]]" size="50" value="<?php echo $user['User']['pincode']; ?>"  /></dd>-->
                            
                            
                            <dt><label for="name">Brokerage Charges Calculation<span class="required">*</span></label></dt>                                               
                            <dd>
                                <input type="hidden" name="data[Franchiseebrokerage][brkge_calc]" value="PER" id="brkge_calc" />
                                <input type="radio" name="brkge_calc" class="brkge_calc validate[required]" value="PER" <?php echo !empty($brokerage) && $brokerage['Franchiseebrokerage']['brkge_calc'] == 'PER' ? 'checked' : '' ?>/>&nbsp; % &nbsp; 
                                <input type="radio" name="brkge_calc" class="brkge_calc validate[required]" value="INR" <?php echo !empty($brokerage) && $brokerage['Franchiseebrokerage']['brkge_calc'] == 'INR' ? 'checked' : '' ?>/>&nbsp; INR
                            </dd>
                            
                            <dt><label for="name">Pincode wise<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Franchiseebrokerage][pincodewise_brkge_value]" class="validate[required,custom[number]]" id="pincodewise_brkge_value" size="50"  value="<?php echo !empty($brokerage) ? $brokerage['Franchiseebrokerage']['pincodewise_brkge_value'] : ''  ?>" />&nbsp; <span class="brkge_calc_indicator"></span></dd>
                            
                            <dt><label for="name">General<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Franchiseebrokerage][general_brkge_value]" class="validate[required,custom[number]]" id="general_brkge_value" size="50"  value="<?php echo !empty($brokerage) ? $brokerage['Franchiseebrokerage']['general_brkge_value'] : '' ?>" />&nbsp; <span class="brkge_calc_indicator"></span></dd>
                        

                            <dt><label for="name">Phone No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[User][phone_no]" id="regphone"  onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $user['User']['phone_no']; ?>" /></dd>

                            <dt><label for="name">Phone  No.(2)&nbsp;</label></dt>
                            <dd><input type="text" name="data[User][phone_no2]" id="regphone1" onkeypress="return intnumbers(this, event)"  class="validate[custom[integer]]" size="50" value="<?php echo $user['User']['phone_no2']; ?>" maxlength="10" /></dd>

                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[User][mobile_no]" id="rmobile" onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $user['User']['mobile_no']; ?>"  /></dd>

                            <dt><label for="name">Fax No.</label></dt>
                            <dd><input type="text" name="data[User][fax_no]" id="fax_no" onkeypress="return intnumbers(this, event)" maxlength="13" class="validate[custom[integer],maxSize[13]]" size="50"  value="<?php echo $user['User']['fax_no']; ?>" /></dd>

                            <dt><label for="name">Email<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[User][email]" id="email" class="validate[required,custom[email]]" size="50" value="<?php echo $user['User']['email']; ?>" /></dd>

                        </dl>
                    </fieldset>

                    
                    <fieldset><legend>Nomination Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Title<span class="required">*</span></label></dt>

                            <dd>
                                <input type="radio" name="data[Nomination][title]" value="Mr"  class="validate[required] radio" <?php
                                if ($nomination['Nomination']['title'] == 'Mr') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Mr &nbsp;
                                <input type="radio" name="data[Nomination][title]" value="Ms"  class="validate[required] radio" <?php
                                if ($nomination['Nomination']['title'] == 'Ms') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Ms &nbsp;
                                <input type="radio" name="data[Nomination][title]" value="Mrs"  class="validate[required] radio" <?php
                                if ($nomination['Nomination']['title'] == 'Mrs') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>Mrs &nbsp;

                            </dd>
                            <dt><label for="name">Nominee Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Nomination][name]" id="name"   size="50" class="validate[required]" value="<?php echo $nomination['Nomination']['name']; ?>" /></dd>


                            <div class="guard">
                                <dt><label for="name">Guardian Name</label></dt>
                                <dd><input type="text" name="data[Nomination][guardian_name]" id="guardian_name"    size="50"  value="<?php echo $nomination['Nomination']['guardian_name']; ?>" /></dd>
                            </div>

                            <div class="guardian" style="display:none;">
                                <dt><label for="name">Guardian Name<span class="required">*</span></label></dt>
                                <dd><input type="text" name="data[Nomination][guardian_name]" id="guardian_name" class="validate[required]"  size="50"   value="<?php echo $nomination['Nomination']['guardian_name']; ?>" /></dd>
                            </div>

                            <dt><label for="name">DOB</label></dt>   
                            <dd><input type="text"  readonly name="data[Nomination][dob]" id="dob" size="50" value="<?php echo $nomination['Nomination']['dob']; ?>"/></dd>

                            <dt><label for="name">Address<span class="required">*</span></label></dt>   
                            <dd><textarea rows="3" cols="50" class="validate[required]"  name="data[Nomination][address]"><?php echo $nomination['Nomination']['address']; ?></textarea></dd>

                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Nomination][city]" id="ncity"  class="validate[required]" size="50" value="<?php echo $nomination['Nomination']['city']; ?>"  /></dd>

                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[Nomination][state]" class="validate[required]" id="nstate">
                                    <option value="">State</option>
                                    <?php
                                    foreach ($state as $states) {
                                        if (isset($nomination['Nomination']['state']) && $nomination['Nomination']['state'] == $states['State']['state']) {
                                            echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
                                        } else {
                                            echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select></dd>

                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Nomination][pincode]" id="nregpincode" onkeypress="return intnumbers(this, event)" maxlength="6"  class="validate[required,custom[integer],minSize[6]]" size="50" value="<?php echo $nomination['Nomination']['pincode']; ?>"   /></dd>

                            <dt><label for="name">Phone No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Nomination][phone_no1]" id="nregphone"  onkeypress="return intnumbers(this, event)" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $nomination['Nomination']['phone_no1']; ?>" maxlength="10"   /></dd>

                            <dt><label for="name">Phone  No.(2)&nbsp;</label></dt>
                            <dd><input type="text" name="data[Nomination][phone_no2]" id="nregphone1" onkeypress="return intnumbers(this, event)"  class="validate[custom[integer]]" size="50" value="<?php echo $nomination['Nomination']['phone_no2']; ?>" maxlength="10"  /></dd>

                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Nomination][mobile_no]" id="nrmobile" onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $nomination['Nomination']['mobile_no']; ?>"   /></dd>


                            <dt><label for="name">Email</label></dt>
                            <dd><input type="text" name="data[Nomination][email]" id="email" class="validate[custom[email]]" size="50" value="<?php echo $nomination['Nomination']['email']; ?>"  /></dd>
                        </dl>
                    </fieldset>


                    <fieldset><legend>Bank Details</legend>
                        <dl class="inline">

                            <dt><label for="name">Bank Name<span class="required">*</span></label></dt>

                            <dd><input type="text" name="data[Bankdetail][name]" id="bankname"   size="50" class="validate[required]" value="<?php echo $bank['Bankdetail']['name']; ?>" /></dd>

                            <dt><label for="name">Account No<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Bankdetail][account_no]" id="account_no" class="validate[required]"   size="50" value="<?php echo $bank['Bankdetail']['account_no']; ?>" /></dd>

                            <dt><label for="name">Bank Branch Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Bankdetail][branch_name]" id="branch_name"  class="validate[required]" size="50" value="<?php echo $bank['Bankdetail']['branch_name']; ?>"/></dd>

                            <dt><label for="name">A/C Type<span class="required">*</span></label></dt>
                            <dd><?php foreach ($accounttype as $accounttype) { ?>
                                    <input type="radio" name="data[Bankdetail][type]" value="<?php echo $accounttype['Accounttype']['account_id']; ?>" class="validate[required] radio" <?php
                                    if ($bank['Bankdetail']['type'] == $accounttype['Accounttype']['account_id']) {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?> /><?php echo $accounttype['Accounttype']['account_type']; ?>

                                <?php } ?></dd>

                            <dt><label for="name">IFSC CODE<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Bankdetail][ifsc_code]" class="validate[required,minSize[11]]" id="ifsccode" size="50"  maxlength="11"  value="<?php echo $bank['Bankdetail']['ifsc_code']; ?>"/></dd> 

                        </dl>
                    </fieldset>
                    <fieldset><legend>Other Details</legend>
                        <dl class="inline">
                            <fieldset><legend>Are you in Jewellery Business?</legend>
                                <dt></dt>
                                <dd><input type="radio" name="data[Otherdetail][jewellery]" class="jewelleryyes" value="Yes" <?php
                                    if ($other['Otherdetail']['jewellery'] == 'Yes') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?>  />Yes &nbsp;
                                    <input type="radio" name="data[Otherdetail][jewellery]" class="jewelleryno" value="No"   <?php
                                    if ($other['Otherdetail']['jewellery'] == 'No') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?>/>No &nbsp;
                                </dd>
                                <div class="jewellery1" <?php
                                if ($other['Otherdetail']['jewellery'] == 'No') {
                                    echo 'style="display:none";';
                                }
                                ?>>
                                    <dt><label for="name">If Yes,specify the city you operate. </label></dt>
                                    <dd><input type="text" name="data[Otherdetail][city]"  id="otherdetail" size="50"  value="<?php echo $other['Otherdetail']['city']; ?>" /></dd>

                                    <dt><label for="name">How many stores do you have?</label></dt>
                                    <dd><input type="text" name="data[Otherdetail][store]"  id="store" size="50" nkeypress="return intnumbers(this, event)"  class="validate[required,custom[integer]]"  value="<?php echo $other['Otherdetail']['store']; ?>"/></dd>

                                    <dt><label for="name">Do you have any others business beside jewellery?</label></dt>
                                    <dd><input type="text" name="data[Otherdetail][other_business]"  id="other_business" size="50"  value="<?php echo $other['Otherdetail']['other_business']; ?>"/></dd>
                                </div>
                            </fieldset>

                            <fieldset><legend>Do you have franchisee agreement with others jewellery companies?</legend>
                                <dt></dt>
                                <dd><input type="radio" name="data[Otherdetail][agreement]" value="Yes" class="agreementyes"  <?php
                                    if ($other['Otherdetail']['agreement'] == 'Yes') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?> />Yes &nbsp;
                                    <input type="radio" name="data[Otherdetail][agreement]" value="No"   class="agreementno"  <?php
                                    if ($other['Otherdetail']['agreement'] == 'No') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?> />No &nbsp;
                                </dd>
                                <div class="jewellery2" <?php
                                if ($other['Otherdetail']['agreement'] == 'No') {
                                    echo 'style="display:none";';
                                }
                                ?>>
                                    <dt><label for="name">If yes,specify which company? </label></dt>
                                    <dd><input type="text" name="data[Otherdetail][details]" id="details" size="50" value="<?php echo $other['Otherdetail']['details']; ?>"/></dd>

                                </div>
                            </fieldset>

                            <fieldset><legend>Where do you plan to open a outlet?</legend>
                                <dt></dt>
                                <dd><input type="radio" name="data[Otherdetail][outlet]" value="Mall"  <?php
                                    if ($other['Otherdetail']['outlet'] == 'Mall') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?>   class="outletyes" class="validate[required] radio"/>Mall &nbsp;
                                    <input type="radio" name="data[Otherdetail][outlet]" value="Other" <?php
                                    if ($other['Otherdetail']['outlet'] == 'Other') {
                                        echo 'checked="checked"';
                                    } else {
                                        
                                    }
                                    ?>    class="outletno" class="validate[required] radio"/>Other &nbsp;
                                </dd>
                                <div class="jewellery3" <?php
                                if ($other['Otherdetail']['outlet'] == 'Other') {
                                    echo 'style="display:none";';
                                }
                                ?>>
                                    <dt><label for="name">If yes,specify the name of Mall?<span class="required">*</span> </label></dt>
                                    <dd><input type="text" name="data[Otherdetail][special_details]" class="validate[required]" id="special_details" size="50" value="<?php echo $other['Otherdetail']['special_details']; ?>"/></dd>
                                </div>
                                <div class="jewellery4" <?php
                                if ($other['Otherdetail']['outlet'] == 'Mall') {
                                    echo 'style="display:none";';
                                }
                                ?>>
                                    <dt><label for="name">if Others Place,specify the address,area of office?<span class="required">*</span> </label></dt>
                                    <dd><input type="text" name="data[Otherdetail][other_place]" class="validate[required]" id="other_place" size="50" value="<?php echo $other['Otherdetail']['other_place']; ?>"/></dd>
                                </div>

                            </fieldset>
                        </dl>
                    </fieldset>         
                    <fieldset><legend>Payment Details</legend>        
                        <dl class="inline" id="addpayment">
                            <?php
                            $vccount = count($payment);
                            $i = 0;
                            foreach ($payment as $payment) {
                                ?>
                                <div class="payment">
                                    <fieldset><legend>Mode of payment</legend> 

                                        <dt><label for="name">Payment<span class="required">*</span></label></dt>  

                                        <dd><select name="data[Payment][<?php echo $i; ?>][payment]" class="validate[required]" id="cheque<?php echo $i; ?>">
                                                <option value="">Select</option>

                                                <option value="Cheque"  <?php
                                                if ($payment['Payment']['payment'] == 'Cheque') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    
                                                }
                                                ?>  > Cheque</option>
                                                <option value="Demand Draft"  <?php
                                                if ($payment['Payment']['payment'] == 'Demand Draft') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    
                                                }
                                                ?>  >Demand Draft</option>
                                                <option value="NEFT"  <?php
                                                if ($payment['Payment']['payment'] == 'NEFT') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    
                                                }
                                                ?>  >NEFT </option>
                                                <option value="RTGS"  <?php
                                                if ($payment['Payment']['payment'] == 'RTGS') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    
                                                }
                                                ?>  >RTGS</option>
                                            </select></dd>

                                        <dt><label for="name">Amount<span class="required">*</span></label></dt>                                               
                                        <dd><input type="text" name="data[Payment][<?php echo $i; ?>][amount]" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)"  id="amount<?php echo $i; ?>" size="50"  value="<?php echo $payment['Payment']['amount']; ?>" /></dd>

                                        <dt><label for="name">Cheque No/DD No./NEFT/RTGS No<span class="required">*</span></label></dt>                                               
                                        <dd><input type="text" name="data[Payment][<?php echo $i; ?>][cheque_no]" class="validate[required]"  id="cheque_no<?php echo $i; ?>"  onkeypress="return intnumbers(this, event)" size="50" value="<?php echo $payment['Payment']['cheque_no']; ?>"  /></dd>

                                        <dt><label for="name">Bank Name<span class="required">*</span></label></dt>

                                        <dd><input type="text" name="data[Payment][<?php echo $i; ?>][bank_name]" id="cbankname<?php echo $i; ?>"   size="50" class="validate[required]" value="<?php echo $payment['Payment']['bank_name']; ?>"/></dd>

                                        <dt><label for="name">Account No<span class="required">*</span></label></dt>
                                        <dd><input type="text" name="data[Payment][<?php echo $i; ?>][account_no]" id="naccount_no<?php echo $i; ?>" class="validate[required]"   size="50"  value="<?php echo $payment['Payment']['account_no']; ?>" /></dd>

                                        <dt><label for="name">Bank Branch Name<span class="required">*</span></label></dt>
                                        <dd><input type="text" name="data[Payment][<?php echo $i; ?>][branch_name]" id="nbranch_name<?php echo $i; ?>"  class="validate[required]" size="50" value="<?php echo $payment['Payment']['branch_name']; ?>" />
                                            <?php if ($i > 0) { ?>
                                                <a class="remove_field">Remove</a>
                                            <?php } else {
                                                ?>
                                                <button type="button" class="button add_field_button" name="addpayment"  value="">Add</button>
                                            <?php } ?>
                                        </dd>
                                    </fieldset>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                        </dl>
                        <input type="hidden" name="paymentnew" id="payment_details" value="<?php echo $vccount; ?>"/>
                    </fieldset>
                    <fieldset><legend>Outlet Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Name of outlet<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Outlet][outlet_name]" class="validate[required]" id="outlet_name" size="50"  value="<?php echo $out['Outlet']['outlet_name']; ?>"  /></dd>

                            <dt><label for="name">Outlet address<span class="required">*</span></label></dt>                                               
                            <dd><textarea  rows="3" cols="50 "name="data[Outlet][address]" class="validate[required]"  id="addressno" ><?php echo $out['Outlet']['address']; ?></textarea></dd>

                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Outlet][city]" id="citied"  class="validate[required]" size="50" value="<?php echo $out['Outlet']['city']; ?>"  /></dd>

                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[Outlet][state]" class="validate[required]" id="states">
                                    <option value="">State</option>
                                    <?php
                                    foreach ($state as $states) {
                                        if (isset($out['Outlet']['state']) && $out['Outlet']['state'] == $states['State']['state']) {
                                            echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
                                        } else {
                                            echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select></dd>

                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Outlet][pincode]" id="newpincode" onkeypress="return intnumbers(this, event)" maxlength="6"  class="validate[required,custom[integer],minSize[6]]" size="50" value="<?php echo $out['Outlet']['pincode']; ?>" /></dd>

                            <dt><label for="name">Phone No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Outlet][phone_no1]" id="newphone"  onkeypress="return intnumbers(this, event)" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $out['Outlet']['phone_no1']; ?>" maxlength="10" /></dd>

                            <dt><label for="name">Phone  No.(2)&nbsp;</label></dt>
                            <dd><input type="text" name="data[Outlet][phone_no2]" id="newregphone1" onkeypress="return intnumbers(this, event)"  class="validate[custom[integer]]" size="50"  value="<?php echo $out['Outlet']['phone_no2']; ?>" maxlength="10" /></dd>

                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Outlet][mobile_no]" id="newrmobile" onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" value="<?php echo $out['Outlet']['mobile_no']; ?>" /></dd>

                            <dt><label for="name">Fax No.</label></dt>
                            <dd><input type="text" name="data[Outlet][fax]" id="newfax_no" onkeypress="return intnumbers(this, event)" maxlength="13" class="validate[custom[integer],maxSize[13]]" size="50" value="<?php echo $out['Outlet']['fax']; ?>" /></dd>

                            <dt><label for="name">Email</label></dt>
                            <dd><input type="text" name="data[Outlet][email]" id="newemail" class="validate[custom[email]]" size="50" value="<?php echo $out['Outlet']['email']; ?>" /></dd>
                        </dl>
                    </fieldset>


                    <fieldset><legend>For Office Use Only</legend>
                        <dl class="inline">

                            <dt><label for="name">Source By<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Officeuse][sourceby]" id="sourceby" class="validate[required]" size="50"  value="<?php echo $use['Officeuse']['sourceby']; ?>"  /></dd>

                            <dt><label for="name">Source Person Name<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Officeuse][source_person_name]" id="source_person_name" class="validate[required]" size="50"  value="<?php echo $use['Officeuse']['source_person_name']; ?>"  /></dd>

                            <dt><label for="name">Date of recieve<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Officeuse][date_of_receive]" id="date_of_receive" class="validate[required]" size="50" value="<?php echo $use['Officeuse']['date_of_receive']; ?>"   /></dd>


                            <dt><label for="name">Accepted By<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Officeuse][acceptedby]" id="acceptedby" class="validate[required]" size="50"  value="<?php echo $use['Officeuse']['acceptedby']; ?>"  /></dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Document Submitted/Requirement</legend>
                        <dl class="inline">
                            <dt><label for="name">Permamnent Account Number(PAN No) </label></dt>
                            <dd> <input type="radio" id="pan1"  name="data[Franchiseeproof][pan]" value="Yes" <?php
                                if ($franchisee['Franchiseeproof']['pan'] == 'Yes') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?> class="validate[required] radio"  />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="pan2"  name="data[Franchiseeproof][pan]" value="No"  class="validate[required] radio"  <?php
                                if ($franchisee['Franchiseeproof']['pan'] == 'No') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>/>No&nbsp;&nbsp;&nbsp;            </dd>


                            <dt><label for="name">Address Proof</label></dt>
                            <dd><input type="radio" id="checklist" class="yes"  name="data[Franchiseeproof][checklist1]" value="Yes" class="validate[required] radio"  <?php
                                if ($franchisee['Franchiseeproof']['checklist1'] == 'Yes') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>  />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Franchiseeproof][checklist1]" value="No"   class="validate[required] radio"  <?php
                                if ($franchisee['Franchiseeproof']['checklist1'] == 'No') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?> />No&nbsp;&nbsp;&nbsp;

                                <div class="sheet" <?php
                                if ($franchisee['Franchiseeproof']['checklist1'] == 'No') {
                                    echo 'style="display:none";';
                                }
                                ?>>
                                         <?php $emp = explode(',', $franchisee['Franchiseeproof']['proof']); ?>
                                         <?php foreach ($proof as $proof) { ?>
                                        <input type="checkbox" name="data[Franchiseeproof][proof][]" class="validate[required]" <?php
                                        if (in_array($proof['Proof']['proof_id'], $emp)) {
                                            echo 'checked="checked"';
                                        } else {
                                            
                                        }
                                        ?>  value="<?php echo $proof['Proof']['proof_id']; ?>" /><?php echo $proof['Proof']['name']; ?>
                                           <?php } ?>
                                </div>

                            </dd>

                            <dt><label for="name">Bank Proof (Cheque Copy) </label></dt>
                            <dd><input type="radio" id="bankproof"  name="data[Franchiseeproof][bankproof]" value="Yes" class="validate[required] radio" <?php
                                if ($franchisee['Franchiseeproof']['bankproof'] == 'Yes') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>   />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="bankproof1"  name="data[Franchiseeproof][bankproof]" value="No" class="validate[required] radio"  <?php
                                if ($franchisee['Franchiseeproof']['bankproof'] == 'No') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?> />No
                            </dd>

                            <dt><label for="name">Signed Franchisee Agreement </label></dt>
                            <dd><input type="radio" id="sign_proof"  name="data[Franchiseeproof][sign_proof]" value="Yes" class="validate[required] radio" <?php
                                if ($franchisee['Franchiseeproof']['sign_proof'] == 'Yes') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>    />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="sign_proof1"  name="data[Franchiseeproof][sign_proof]" value="No"  class="validate[required] radio" <?php
                                if ($franchisee['Franchiseeproof']['sign_proof'] == 'No') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                                ?>   />No&nbsp;&nbsp;&nbsp;

                            </dd>
                            <dt><label for="name">Loan Franchisee </label></dt>
                            <dd><input type="radio" id="loan"  name="data[Franchiseeproof][loan]" value="Yes" class="validate[required] radio" <?php
                                if (isset($franchisee['Franchiseeproof']['loan'])) {
									if ($franchisee['Franchiseeproof']['loan'] == 'Yes') {
										echo 'checked="checked"';
									}
								}
                                ?>    />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="loan"  name="data[Franchiseeproof][loan]" value="No"  class="validate[required] radio" <?php
								if (!isset($franchisee['Franchiseeproof']['loan'])) {
									echo 'checked="checked"';
								}else{
									if ($franchisee['Franchiseeproof']['loan'] == 'No') {
										echo 'checked="checked"';
									}
								}
                                       ?>   />No&nbsp;&nbsp;&nbsp;

                            </dd>

                        </dl>
                    </fieldset>
                    <?php echo $this->Form->submit(__('Save'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
    </div>
</div> 

<script>
    $(document).ready(function () {
        /***start****/
        $('.add_field_button').click(function () {
            var values = parseInt($('#payment_details').val()) + 1;
            if ($('.payment').length < 5) {
                $('#addpayment').append('<div class="payment"> <fieldset><legend>Payment Details</legend> <dt><label for="name">Payment<span class="required">*</span></label></dt>' + '<dd><select name="data[Payment][' + values + '][payment]" class="validate[required]" id="cheque' + values + '" ><option value="">Select</option> <option value="Cheque"> Cheque</option><option value="Demand Draft">Demand Draft</option> <option value="NEFT">NEFT </option><option value="RTGS">RTGS</option></select></dd>' + '<dt><label for="name">Amount<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Payment][' + values + '][amount]" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)"  id="amount' + values + '" size="50"  /></dd>' + '<dt><label for="name">Cheque No/DD No./NEFT/RTGS No<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Payment][' + values + '][cheque_no]" class="validate[required]"  id="cheque_no' + values + '"  onkeypress="return intnumbers(this, event)" size="50"   /></dd>' + ' <dt><label for="name">Bank Name<span class="required">*</span></label></dt> ' + ' <dd><input type="text" name="data[Payment][' + values + '][bank_name]" id="cbankname' + values + '"   size="50" class="validate[required]" /></dd>' + '<dt><label for="name">Account No<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Payment][' + values + '][account_no]" id="naccount_no' + values + '" class="validate[required]"   size="50"  /></dd>' + '<dt><label for="name">Bank Branch Name<span class="required">*</span></label></dt>' + '<dd> <input type="text" name="data[Payment][' + values + '][branch_name]" id="nbranch_name' + values + '"  class="validate[required]" size="50" />&nbsp;<a class="remove_field">Remove</a></dd></fieldset></div>');
                $('.payment:last input,.payment:last select').uniform();
                jQuery("#myForm").validationEngine('attach', {
                    autoHidePrompt: true,
                    autoHideDelay: 3000,
                    onValidationComplete: function (form, status) {
                        if (status == true) {
                            jQuery('.helpfade').show();
                            jQuery('.helptips').show();
                            var id = $('.ckeditor').attr('id');
                            if (typeof id != 'undefined') {
                                var editorcontent = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
                                if (editorcontent.length <= 10) {
                                    jQuery('.helpfade').hide();
                                    jQuery('.helptips').hide();
                                    message("This field is required, Please give minimum 10 characters in the field of " + id);
                                    return false;
                                }
                            }
                            form.validationEngine('detach');
                            form.submit();
                        }
                    }
                });

                $('#offical_contacts').val(values);
            } else {
                alert('You must enter only 6 contacts');
            }
        });
        /********end****/



    });

    $('.remove_field').live('click', function (e) {
        $(this).parents('.payment').remove();
    });

</script>


<script>
    $(document).ready(function () {
        $(".yes").click(function () {
            if ($(this).val() == 'Yes') {
                $('.sheet').show();

            }

        });
        $(".no").click(function () {
            if ($(this).val() == 'No') {
                $('.sheet').hide();

            }

        });

        $(".jewelleryyes").click(function () {
            if ($(this).val() == 'Yes') {
                $('.jewellery1').show();

            }

        });
        $(".jewelleryno").click(function () {
            if ($(this).val() == 'No') {
                $('.jewellery1').hide();

            }

        });
        $(".agreementyes").click(function () {
            if ($(this).val() == 'Yes') {
                $('.jewellery2').show();

            }

        });
        $(".agreementno").click(function () {
            if ($(this).val() == 'No') {
                $('.jewellery2').hide();

            }

        });
        $(".outletyes").click(function () {
            if ($(this).val() == 'Mall') {
                $('.jewellery3').show();
                $('.jewellery4').hide();
            }

        });
        $(".outletno").click(function () {
            if ($(this).val() == 'Other') {
                $('.jewellery4').show();
                $('.jewellery3').hide();
            }

        });
    });

</script>
<script>
    $(document).ready(function () {
        $("#enddate").datepicker({
            dateFormat: 'yy-mm-dd',
            showOn: "button",
            buttonImage: "<?php echo BASE_URL; ?>img/calendar.gif",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "-90",
        });
        $("#dob").datepicker({
            dateFormat: 'yy-mm-dd',
            showOn: "button",
            buttonImage: "<?php echo BASE_URL; ?>img/calendar.gif",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "-90",
            onSelect: function (date) {
                var dob = new Date(date);
                var today = new Date();
                var sum = today.getFullYear() - dob.getFullYear();
                if (dob.getFullYear() + 18 < today.getFullYear()) // calculate selected date is greater 18 or not
                {
                    $('.guardian').hide();
                    $('.guard').show();
                }
                else
                {
                    $('.guardian').show();
                    $('.guard').hide();
                }
            }
        });
        $("#date_of_receive").datepicker({
            dateFormat: 'yy-mm-dd',
            showOn: "button",
            buttonImage: "<?php echo BASE_URL; ?>img/calendar.gif",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "-90",
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.title').click(function () {
            if ($(this).val() == 'Others') {
                $('.other').show();
            } else
            {
                $('.other').hide();
            }
        });

    });

</script>

<script type="text/javascript">
    //added by prakash
    
    $(document).ready(function () {
        brkge_charge($("input[name='brkge_calc']:checked").val());
        
        $('.brkge_calc').click(function(){
            brkge_charge($(this).val());
        });
    });
    
    function brkge_charge(calc){
        if(calc == 'PER'){
            $('.brkge_calc_indicator').html('%');
        }else{
            $('.brkge_calc_indicator').html('INR');
        }
        $('#brkge_calc').val(calc);
    }
</script>