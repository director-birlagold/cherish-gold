<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Vendor Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Add Vendor</legend>
                <dl class="inline">

                    <fieldset><legend>Company</legend>
                        <dl class="inline">
                            <dt><label for="name">Vendor Status<span class="required">*</span></label></dt>

                            <dd>
                                <select  name="data[Vendor][vendor_status]" id="status1" class="validate[required]"  >

                                    <option value="">Status</option>
                                    <?php
                                    foreach ($statues as $status) {

                                        if (isset($this->request->data['Vendor']['vendor_status']) && $this->request->data['Vendor']['vendor_status'] == $status['Status']['vendor_status_id']) {
                                            echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                        } else {
                                            echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select>         
                            </dd>

                            <dt><label for="name">Company<span class="required">*</span></label></dt>     
                            <dd><input type="text" name="data[Vendor][Company_name]" id="Companyname"  class="validate[required]" size="50"
                                       value="<?php if (isset($this->request->data['Vendor']['Company_name'])) {
                                        echo $this->request->data['Vendor']['Company_name'];
                                    } ?>"/></dd>

                            <dt><label for="name">Preferred Billing Address<span class="required">*</span></label></dt>   
                            <dd><select class="validate[required]]" name="data[Vendor][preferred_billing]" id="perferedbilling">
                                    <option value="">Select</option>
                                    <option value="Reg.off" <?php if (isset($this->request->data['Vendor']['preferred_billing']) && ($this->request->data['Vendor']['preferred_billing'] == 'Reg.off')) {
                                        echo 'Selected';
                                    } ?>>
                                        Register Office Address</option>
                                    <option value="Ho" <?php if (isset($this->request->data['Vendor']['preferred_billing']) && ($this->request->data['Vendor']['preferred_billing'] == 'Ho')) {
                                        echo 'Selected';
                                    } ?>>Head Office Address</option>
                                </select></dd>

                            <dt><label for="name">Vendor Type<span class="required">*</span></label></dt>  
                            <dd>
                                <select class="validate[required]" name="data[Vendor][vendor_type]" id="vendortype">

                                    <option value="">Select</option>
                                    <?php
                                    foreach ($type as $type) {

                                        if (isset($this->request->data['Vendor']['vendor_type']) && $this->request->data['Vendor']['vendor_type'] == $type['Type']['vendor_type_id']) {
                                            echo '<option value="' . $type['Type']['vendor_type_id'] . '" selected="selected">' . $type['Type']['vendor_type'] . '</option>';
                                        } else {
                                            echo '<option value="' . $type['Type']['vendor_type_id'] . '">' . $type['Type']['vendor_type'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select>         
                            </dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Register Office Address</legend>
                        <dl class="inline">
                            <dt><label for="name">Address<span class="required">*</span></label></dt>

                            <dd><input type="text" name="data[Vendor][reg_address]" id="regaddress"  class="validate[required]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_address'])) {
                                        echo $this->request->data['Vendor']['reg_address'];
                                    } ?>"/></dd>
                            <dt><label for="name">&nbsp;</label></dt>
                            <dd><input type="text" name="data[Vendor][reg_address1]" id="regaddress1"   size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_address1'])) {
                                        echo $this->request->data['Vendor']['reg_address1'];
                                    } ?>"/></dd>
                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][reg_city]" id="regcity"  class="validate[required]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_city'])) {
                                        echo $this->request->data['Vendor']['reg_city'];
                                    } ?>"/></dd>
                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[Vendor][reg_state]" class="validate[required]" id="regstate">
                                    <option value="">State</option>
                                    <?php
                                    foreach ($state as $states) {
                                        if (isset($this->request->data['Vendor']['reg_state']) && $this->request->data['Vendor']['reg_state'] == $states['State']['state']) {
                                            echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
                                        } else {
                                            echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
                                        }
                                    }
                                    ?>
                                </select></dd>
                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][reg_pincode]" id="regpincode" onkeypress="return intnumbers(this, event)" maxlength="6"  class="validate[required,custom[integer],minSize[6]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_pincode'])) {
                                        echo $this->request->data['Vendor']['reg_pincode'];
                                    } ?>"/></dd>
                            <dt><label for="name">Phone No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][reg_phone]" id="regphone"  onkeypress="return intnumbers(this, event)" class="validate[required,custom[integer]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_phone'])) {
                                        echo $this->request->data['Vendor']['reg_phone'];
                                    } ?>"/></dd>
                            <dt><label for="name">Phone  No.(2)&nbsp;</label></dt>
                            <dd><input type="text" name="data[Vendor][reg_phone1]" id="regphone1" onkeypress="return intnumbers(this, event)"  class="validate[custom[integer]]" size="50"
                                       value="<?php if (isset($this->request->data['Vendor']['reg_phone1'])) {
                                        echo $this->request->data['Vendor']['reg_phone1'];
                                    } ?>"/></dd>
                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][reg_mobile]" id="regmobile" onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['reg_mobile'])) {
                                        echo $this->request->data['Vendor']['reg_mobile'];
                                    } ?>"/></dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Head Office Address</legend>
                        <dl class="inline">
                            <dt><label for="name"><input type="checkbox" name="regofficeaddresscheck" id="regofficeaddress"   value=""  /></label></dt>
                            <dd style="font-weight:bold;"><label for="name"> Address same as Registered Office</label></dd>
                            <dt><label for="name">Address<span class="required">*</span></label></dt>

                            <dd><input type="text" name="data[Vendor][ho_address]" id="hoaddress"   size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_address'])) {
                                        echo $this->request->data['Vendor']['ho_address'];
                                    } ?>"/></dd>
                            <dt><label for="name"></label></dt>
                            <dd><input type="text" name="data[Vendor][ho_address1]" id="hoaddress1"  size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_address1'])) {
                                        echo $this->request->data['Vendor']['ho_address1'];
                                    } ?>"/></dd>
                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][ho_city]" id="hocity"  class="validate[required]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_city'])) {
                                        echo $this->request->data['Vendor']['ho_city'];
                                    } ?>"/></dd>
                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[Vendor][ho_state]" class="validate[required]" id="hostate">
                                    <option value="">State</option>
<?php
foreach ($state as $states) {
    if (isset($this->request->data['Vendor']['ho_state']) && $this->request->data['Vendor']['ho_state'] == $states['State']['state']) {
        echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
    } else {
        echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
    }
}
?>
                                </select></dd>
                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][ho_pincode]" id="hopincode"  class="validate[required,custom[integer],minSize[6]]"  onkeypress="return intnumbers(this, event)"  maxlength="6" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_pincode'])) {
    echo $this->request->data['Vendor']['ho_pincode'];
} ?>"/></dd>
                            <dt><label for="name">Phone  No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][ho_phone]" id="hophone"  onkeypress="return intnumbers(this, event)" class="validate[required,custom[integer]]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_phone'])) {
    echo $this->request->data['Vendor']['ho_phone'];
} ?>"/></dd>
                            <dt><label for="name">Phone  No.(2)&nbsp;</label></dt>
                            <dd><input type="text" name="data[Vendor][ho_phone1]" id="hophone1"  onkeypress="return intnumbers(this, event)" class="validate[custom[integer]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_phone1'])) {
                                        echo $this->request->data['Vendor']['ho_phone1'];
                                    } ?>"/></dd>
                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][ho_mobile]" id="homobile" onkeypress="return intnumbers(this, event)" maxlength="10" class="validate[required,custom[integer],minSize[10]]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['ho_mobile'])) {
                                        echo $this->request->data['Vendor']['ho_mobile'];
                                    } ?>"/></dd>
                        </dl>
                    </fieldset>
                    <fieldset><legend>Workshop/Factory Address</legend>
                        <dl class="inline">
                            <dt><label for="name"><input type="checkbox" name="regofficeaddresscheck" id="regofficeaddress_work"   value=""  /></label></dt>
                            <dd style="font-weight:bold;"><label for="name"> Address same as Registered Office</label></dd>
                            <dt><label for="name">Address<span class="required">*</span></label></dt>

                            <dd><input type="text" name="data[Vendor][work_address]" id="workaddress"  class="validate[required]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_address'])) {
                                        echo $this->request->data['Vendor']['work_address'];
                                    } ?>"/></dd>
                            <dt><label for="name"></label></dt>
                            <dd><input type="text" name="data[Vendor][work_address1]" id="workaddress1"   size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_address1'])) {
                                        echo $this->request->data['Vendor']['work_address1'];
                                    } ?>"/></dd>
                            <dt><label for="name">City<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][work_city]" id="workcity"  class="validate[required]" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_city'])) {
                                        echo $this->request->data['Vendor']['work_city'];
                                    } ?>"/></dd>
                            <dt><label for="name">State<span class="required">*</span></label></dt>
                            <dd><select name="data[Vendor][work_state]" class="validate[required]" id="workstate">
                                    <option value="">State</option>
<?php
foreach ($state as $states) {
    if (isset($this->request->data['Vendor']['work_state']) && $this->request->data['Vendor']['work_state'] == $states['State']['state']) {
        echo '<option value="' . $states['State']['state'] . '" selected="selected">' . $states['State']['state'] . '</option>';
    } else {
        echo '<option value="' . $states['State']['state'] . '">' . $states['State']['state'] . '</option>\n';
    }
}
?>
                                </select></dd>
                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][work_pincode]" id="workpincode"  class="validate[required,custom[integer],minSize[6]]"  onkeypress="return intnumbers(this, event)" maxlength="6"size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_pincode'])) {
    echo $this->request->data['Vendor']['work_pincode'];
} ?>"/></dd>
                            <dt><label for="name">Phone  No.(1)<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][work_phone]" id="workphone"  class="validate[required,custom[integer]]"  onkeypress="return intnumbers(this, event)" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_phone'])) {
    echo $this->request->data['Vendor']['work_phone'];
} ?>"/></dd>
                            <dt><label for="name">Phone No.(2)</label></dt>
                            <dd><input type="text" name="data[Vendor][work_phone1]" id="workphone1"    onkeypress="return intnumbers(this, event)" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_phone1'])) {
    echo $this->request->data['Vendor']['work_phone1'];
} ?>"/></dd>
                            <dt><label for="name">Mobile No.<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Vendor][work_mobile]" id="workmobile"  class="validate[required,custom[integer],minSize[10]]"  onkeypress="return intnumbers(this, event)" maxlength="10" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_mobile'])) {
                                        echo $this->request->data['Vendor']['work_mobile'];
                                    } ?>"/></dd>
                        </dl>
                    </fieldset>         
                    <fieldset><legend>Officials Contacts</legend>        
                        <dl class="inline" id="addcontact">
                            <fieldset><legend>Contacts</legend> 
                                <dt><label for="name">Name<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Vendorcontact][0][name]" class="validate[required]" id="cname0" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorcontact']['0']['name'])) {
                                        echo $this->request->data['Vendorcontact']['0']['name'];
                                    } ?>"/></dd>
                                <dt><label for="name">Designation<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Vendorcontact][0][designation]" class="validate[required]" id="cdesignation0" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorcontact']['0']['designation'])) {
                                        echo $this->request->data['Vendorcontact']['0']['designation'];
                                    } ?>"/></dd>
                                <dt><label for="name">Phone No<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Vendorcontact][0][phone]" class="validate[required,custom[integer]]"  id="cphone0"  onkeypress="return intnumbers(this, event)" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorcontact']['0']['phone'])) {
                                        echo $this->request->data['Vendorcontact']['0']['phone'];
                                    } ?>"/></dd>
                                <dt><label for="name">Mobile No<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Vendorcontact][0][mobile]"  class="validate[required,custom[integer],minSize[10]]"  id="cmobile0"   onkeypress="return intnumbers(this, event)" maxlength="10" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorcontact']['0']['mobile'])) {
                                        echo $this->request->data['Vendorcontact']['0']['mobile'];
                                    } ?>"/></dd>
                                <dt><label for="name">Email ID<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Vendorcontact][0][email]" class="validate[required,custom[email]]" id="cemail0" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorcontact']['0']['email'])) {
                                        echo $this->request->data['Vendorcontact']['0']['email'];
                                    } ?>"/>&nbsp;<button type="button" 
                                           class="button add_field_button" name="addcontacts" value="">Add</button></dd>
                            </fieldset>
                        </dl>
                        <input type="hidden" name="offical_contacts" id="offical_contacts" value="0"/> 
                    </fieldset>
                    <fieldset><legend>Financial Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Bank Name<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Vendor][bank_name]" class="validate[required]" id="bankname" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['bank_name'])) {
                                        echo $this->request->data['Vendor']['bank_name'];
                                    } ?>"/></dd>
                            <dt><label for="name">Account No<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][account_no]" class="validate[required]"  id="accountno" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['account_no'])) {
                                        echo $this->request->data['Vendor']['account_no'];
                                    } ?>"/></dd>
                            <dt><label for="name">Account Type<span class="required">*</span> </label></dt>                                               
                            <dd><select class="validate[required]]" name="data[Vendor][account_type]"  id="accounttype">
                                    <option value="">Select</option>
<?php
foreach ($accounttype as $accounttype) {
    //echo "<option value='".$accounttype['Accounttype']['account_id']."'>".$accounttype['Accounttype']['account_type']."</option>";
    if (isset($this->request->data['Vendor']['account_type']) && $this->request->data['Vendor']['account_type'] == $accounttype['Accounttype']['account_id']) {
        echo '<option value="' . $accounttype['Accounttype']['account_id'] . '" selected="selected">' . $accounttype['Accounttype']['account_type'] . '</option>';
    } else {
        echo '<option value="' . $accounttype['Accounttype']['account_id'] . '">' . $accounttype['Accounttype']['account_type'] . '</option>\n';
    }
    ?>
<?php } ?>
                                </select></dd>
                            <dt><label for="name">MICR CODE<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][micr_code]" class="validate[required,custom[integer],minSize[9]]" onkeypress="return intnumbers(this, event)"  maxlength="9" id="micrcode" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['micr_code'])) {
    echo $this->request->data['Vendor']['micr_code'];
} ?>"/></dd>
                            <dt><label for="name">IFSC CODE<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][ifsc_code]" class="validate[required,minSize[11]]" id="ifsccode" size="50"  maxlength="11"
                                       value="<?php if (isset($this->request->data['Vendor']['ifsc_code'])) {
    echo $this->request->data['Vendor']['ifsc_code'];
} ?>"/></dd>
                            <dt><label for="name">Pincode<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][bank_pincode]" class="validate[required]" onkeypress="return intnumbers(this, event)" maxlength="6" id="bankpincode" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['bank_pincode'])) {
                                           echo $this->request->data['Vendor']['bank_pincode'];
                                       } ?>"/></dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Taxation/Registration Details</legend>
                        <dl class="inline">
                            <dt><label for="name">State Sales Tax (SST)&nbsp;</label></dt>                  
                            <dd><input type="text" name="data[Vendor][state_sales_tax]"  id="statesalestax" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['state_sales_tax'])) {
                                           echo $this->request->data['Vendor']['state_sales_tax'];
                                       } ?>"/></dd>
                            <dt><label for="name">Central Sales Tax(CST)&nbsp;</label></dt>                                               
                            <dd><input type="text" name="data[Vendor][central_sales_tax]"   id="centralsalestax" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['central_sales_tax'])) {
                                           echo $this->request->data['Vendor']['central_sales_tax'];
                                       } ?>"/></dd>
                            <dt><label for="name">Tax Index No.(TIN) (for VAT)<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][tax_index_no]" class="validate[required]" id="taxindexno" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['tax_index_no'])) {
                                           echo $this->request->data['Vendor']['tax_index_no'];
                                       } ?>"/></dd>
                            <dt><label for="name">Work Contract Tax (WCT)&nbsp;</label></dt>                                               
                            <dd><input type="text" name="data[Vendor][work_contact_tax]"  id="workcontacttax" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['work_contact_tax'])) {
                                           echo $this->request->data['Vendor']['work_contact_tax'];
                                       } ?>"/></dd>
                            <dt><label for="name">Goods &Services Tax (GST)&nbsp;</label></dt>                                               
                            <dd><input type="text" name="data[Vendor][good_service_tax]"  id="goodservicetax" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['good_service_tax'])) {
                                           echo $this->request->data['Vendor']['good_service_tax'];
                                       } ?>"/></dd>
                            <dt><label for="name">Vaue Added Tax (VAT)<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][value_add_tax]" class="validate[required]" id="valueaddtax" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['value_add_tax'])) {
                                           echo $this->request->data['Vendor']['value_add_tax'];
                                       } ?>"/></dd>
                            <dt><label for="name">PAN NO<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Vendor][panno]" class="validate[required,custom[pan]]" id="pannumber" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['panno'])) {
                                           echo $this->request->data['Vendor']['panno'];
                                       } ?>"/></dd>
                            <dt><label for="name">&nbsp;</label></dt> 
                            <dd><label for="name" style="font-weight:bold;">Eg : The Pancard format is ABCDE1234Z</label></dd>
                            <dt><label for="name">Tax Relaxation&nbsp;</label></dt>                                               
                            <dd><input type="text" name="data[Vendor][taxrelexation]"  id="taxrelexation1" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['taxrelexation'])) {
                                           echo $this->request->data['Vendor']['taxrelexation'];
                                       } ?>"/></dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Business Statistics</legend>
                        <dl class="inline">
                            <dt><label for="name">Total Experience</label></dt>                  
                            <dd><input type="text" name="data[Vendor][total_experience]"  id="totalexperience" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['total_experience'])) {
                                            echo $this->request->data['Vendor']['total_experience'];
                                        } ?>"/></dd>
                            <dt><label for="name">Turnover for last 1 years</label></dt>  
                            <dd><input type="text" name="data[Vendor][turnover_first_year]"  id="turnoverfirstyear" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['turnover_first_year'])) {
                                            echo $this->request->data['Vendor']['turnover_first_year'];
                                        } ?>"/></dd> 
                            <dt><label for="name">Turnover for last 2 years</label></dt>  
                            <dd><input type="text" name="data[Vendor][turnover_second_year]"  id="turnoversecondyear" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['turnover_second_year'])) {
                                            echo $this->request->data['Vendor']['turnover_second_year'];
                                        } ?>"/></dd>                                             
                            <dt><label for="name">Paid Up Capital</label></dt>                                               
                            <dd><input type="text" name="data[Vendor][capital_amount]" id="capitalamount" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['capital_amount'])) {
                                            echo $this->request->data['Vendor']['capital_amount'];
                                        } ?>"/></dd>

                        </dl>
                    </fieldset>
                    <fieldset><legend>Product</legend>
                        <dl class="inline">
                            <dt><label for="name">Category</label></dt>                  
                            <dd><input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Gold"
                                        <?php if (isset($this->request->data['Vendor']['Product_category']) && (in_array('Gold', $this->request->data['Vendor']['Product_category']))) {
                                            echo 'Checked';
                                        } ?>/> Gold
                                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Silver" 
                                        <?php if (isset($this->request->data['Vendor']['Product_category']) && (in_array('Silver', $this->request->data['Vendor']['Product_category']))) {
                                            echo 'Checked';
                                        } ?>/> Silver
                                <input type="checkbox" name="data[Vendor][Product_category][]" id="Productcategory" size="50" value="Diamond"
                                        <?php if (isset($this->request->data['Vendor']['Product_category']) && (in_array('Diamond', $this->request->data['Vendor']['Product_category']))) {
                                            echo 'Checked';
                                        } ?>/> Diamond
                                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Platinum"
<?php if (isset($this->request->data['Vendor']['Product_category']) && (in_array('Platinum', $this->request->data['Vendor']['Product_category']))) {
    echo 'Checked';
} ?>/> Platinum
                                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Palladium"
<?php if (isset($this->request->data['Vendor']['Product_category']) && (in_array('Palladium', $this->request->data['Vendor']['Product_category']))) {
    echo 'Checked';
} ?>/> Palladium
                            </dd>
                            <dt><label for="name">Certification/Standardization</label></dt>  
                            <dd><input type="text" name="data[Vendor][product_certificate]"  id="turnoverfirstyear" size="50" 
                                       value="<?php if (isset($this->request->data['Vendor']['product_certificate'])) {
                                            echo $this->request->data['Vendor']['product_certificate'];
                                        } ?>"/></dd>                                             

                        </dl>
                    </fieldset>
                    <fieldset><legend>Jewellery Making Plant and Machinery Specification</legend>
                        <dl class="inline" id="addplantmachinery">  <fieldset><legend>Plant</legend>
                                <dt><label for="name">Manufacturer Name</label></dt>                  
                                <dd><input type="text" name="data[Vendorplant][0][manufacture_name]"  id="manufacturename0" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorplant']['0']['manufacture_name'])) {
                                            echo $this->request->data['Vendorplant']['0']['manufacture_name'];
                                        } ?>"/></dd>    
                                <dt><label for="name">Year of Mfg</label></dt>  
                                <dd><input type="text" name="data[Vendorplant][0][year]"  id="year10" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorplant']['0']['year'])) {
                                            echo $this->request->data['Vendorplant']['0']['year'];
                                        } ?>"/>&nbsp;<button type="button" 
                                           class="button add_field_button_plant" name="addplant"  value="">Add</button></dd>                                             
                            </fieldset>  
                            <input type="hidden" name="jewellery_machinery" id="jewellery_machinery" value="0"/>                                            
                        </dl>
                    </fieldset>
                    <fieldset><legend>Please enclose list of top 3 clientele</legend>
                        <dl class="inline" id="addclentele" ><fieldset><legend>Clientele</legend>
                                <dt><label for="name">Client Name</label></dt>                  
                                <dd><input type="text" name="data[Vendorclient][0][client]"  id="client10" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorclient']['0']['client'])) {
                                            echo $this->request->data['Vendorclient']['0']['client'];
                                        } ?>"/></dd>    
                                <dt><label for="name">Average Turnover(in lakhs)</label></dt>  
                                <dd><input type="text" name="data[Vendorclient][0][turnover]"  id="turnover0" size="50" 
                                           value="<?php if (isset($this->request->data['Vendorclient']['0']['turnover'])) {
                                            echo $this->request->data['Vendorclient']['0']['turnover'];
                                        } ?>"/>&nbsp;<button type="button" class="button add_field_button_client" name="addclient" value="">Add</button></dd>                                             
                            </fieldset>     <input type="hidden" name="client" id="client" value="0"/>                                              
                        </dl>
                    </fieldset>
                    <!-- <fieldset><legend>Do you want to use checklist for Vendor Assessment?</legend>
                     <dt></dt><dd> <?php echo $this->Form->input('', array('div' => false, 'name' => 'data[Vendor][checklist]', 'id' => 'checklist', 'class' => "validate[required]", 'label' => true, 'type' => 'radio', 'options' => array(1 => 'Yes' . "&nbsp;&nbsp;&nbsp;&nbsp;", 2 => 'No'))); ?></dd>
                    </fieldset>-->

                    <fieldset class="checklist">
                        <legend>Checklist for Vendor Assessment, Selection & Negotiation</legend>
                        <dl class="inline">
                            <dt><label for="name">Central Sales Tax Number(CST) </label></dt>
                            <dd> <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist']) && ($this->request->data['Vendor']['checklist']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist]" value="No"  checked="checked" 
                                 <?php if(isset($this->request->data['Vendor']['checklist']) && ($this->request->data['Vendor']['checklist']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][cst]" id="checklist_cst" class="validate[required]">
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['cst']) && $this->request->data['Checklist']['cst'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Local Sales Tax (LST) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist1]" value="Yes" 
                            <?php if(isset($this->request->data['Vendor']['checklist1']) && ($this->request->data['Vendor']['checklist1']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist1]" value="No"  checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist1']) && ($this->request->data['Vendor']['checklist1']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][lst]" id="checklist_lst" class="validate[required]">
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['lst']) && $this->request->data['Checklist']['lst'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Value Added Tax (VAT) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist2]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist2']) && ($this->request->data['Vendor']['checklist2']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist2]" value="No"  checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist2']) && ($this->request->data['Vendor']['checklist2']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][vat]" id="checklist_vat" class="validate[required]" >
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['vat']) && $this->request->data['Checklist']['vat'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Permanent Account No. (PAN) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist3]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist3']) && ($this->request->data['Vendor']['checklist3']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist3]" value="No"  checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist1']) && ($this->request->data['Vendor']['checklist1']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][pan]" id="checklist_pan" class="validate[required]">
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['pan']) && $this->request->data['Checklist']['pan'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Proof of Authorised Signatory </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist4]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist4']) && ($this->request->data['Vendor']['checklist4']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist4]" value="No"  checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist4']) && ($this->request->data['Vendor']['checklist4']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][signature_proof]" id="checklist_signature_proof" class="validate[required]" >
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['signature_proof']) && $this->request->data['Checklist']['signature_proof'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Proof of Bank Account </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist5]" value="Yes"
                             <?php if(isset($this->request->data['Vendor']['checklist5']) && ($this->request->data['Vendor']['checklist5']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist5]" value="No" checked="checked" 
                                 <?php if(isset($this->request->data['Vendor']['checklist5']) && ($this->request->data['Vendor']['checklist5']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][bank_proof]" id="checklist_bank_proof" class="validate[required]">
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['bank_proof']) && $this->request->data['Checklist']['bank_proof'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Non-Disclosure Agreement (NDA) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist6]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist6']) && ($this->request->data['Vendor']['checklist6']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist6]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist6']) && ($this->request->data['Vendor']['checklist6']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][nda]" id="checklist_nda" class="validate[required]">
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['nda']) && $this->request->data['Checklist']['nda'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Memorandum of Association (MOA) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist7]" value="Yes"
                             <?php if(isset($this->request->data['Vendor']['checklist7']) && ($this->request->data['Vendor']['checklist7']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist7]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist7']) && ($this->request->data['Vendor']['checklist7']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;

                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][moa]" id="checklist_moa" class="validate[required]" >
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['moa']) && $this->request->data['Checklist']['moa'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Article of Association (AOA) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist8]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist8']) && ($this->request->data['Vendor']['checklist8']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist8]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist8']) && ($this->request->data['Vendor']['checklist8']=='Yes') )
								 	{echo 'checked="checked"';}?> />No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][aoa]" id="checklist_aoa" class="validate[required]" >
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['aoa']) && $this->request->data['Checklist']['aoa'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Certificate of Incorporation </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist9]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist9']) && ($this->request->data['Vendor']['checklist9']=='Yes') )
								 	{echo 'checked="checked"';}?>/>Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist9]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist9']) && ($this->request->data['Vendor']['checklist9']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][certificate_incorporation]" id="checklist_certificate_incorporation" class="validate[required]" >
                                        <option value="">Select Types</option>
                                        <?php
                                        foreach ($statues as $status) {
                                            if (isset($this->request->data['Checklist']['certificate_incorporation']) && $this->request->data['Checklist']['certificate_incorporation'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Board Resolution / Power of Attorney </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist10]" value="Yes" 
                             <?php if(isset($this->request->data['Vendor']['checklist10']) && ($this->request->data['Vendor']['checklist10']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist10]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist10']) && ($this->request->data['Vendor']['checklist10']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][power_attorney]" id="checklist_power_attorney"  class="validate[required]" >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['power_attorney']) && $this->request->data['Checklist']['power_attorney'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd> 
                            <dt><label for="name">Power of Attorney for signing the docs Form 32 </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist11]" value="Yes"
                             <?php if(isset($this->request->data['Vendor']['checklist11']) && ($this->request->data['Vendor']['checklist11']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist11]" value="No" checked="checked"
                                 <?php if(isset($this->request->data['Vendor']['checklist11']) && ($this->request->data['Vendor']['checklist11']=='No') )
								 	{echo 'checked="checked"';}?>/>No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][attorney_doc]" id="checklist_attorney_doc" class="validate[required]"  >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['attorney_doc']) && $this->request->data['Checklist']['attorney_doc'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd>                   
                            <dt><label for="name">Acknowledgement of Annual Return last file to ROC </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist12]" value="Yes" 
                            <?php if(isset($this->request->data['Vendor']['checklist12']) && ($this->request->data['Vendor']['checklist12']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist12]" value="No" checked="checked"
                                <?php if(isset($this->request->data['Vendor']['checklist12']) && ($this->request->data['Vendor']['checklist12']=='No') )
								 	{echo 'checked="checked"';}?> />No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][roc]" id="checklist_roc" class="validate[required]"  >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['roc']) && $this->request->data['Checklist']['roc'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Partnership Deed </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist13]" value="Yes" 
                            <?php if(isset($this->request->data['Vendor']['checklist13']) && ($this->request->data['Vendor']['checklist13']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist13]" value="No" checked="checked"
                                <?php if(isset($this->request->data['Vendor']['checklist13']) && ($this->request->data['Vendor']['checklist13']=='No') )
								 	{echo 'checked="checked"';}?>  />No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][partnership_deed]" id="checklist_partnership_deed" class="validate[required]" >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['partnership_deed']) && $this->request->data['Checklist']['partnership_deed'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Price List (Accepted by Sourcing Dept) </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist14]" value="Yes" 
                            <?php if(isset($this->request->data['Vendor']['checklist14']) && ($this->request->data['Vendor']['checklist14']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist14]" value="No" checked="checked"
                                <?php if(isset($this->request->data['Vendor']['checklist14']) && ($this->request->data['Vendor']['checklist14']=='No') )
								 	{echo 'checked="checked"';}?> />No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][price_list]" id="checklist_price_list" class="validate[required]"  >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['price_list']) && $this->request->data['Checklist']['price_list'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd>
                            <dt><label for="name">Terms of Trade Sheet </label></dt>
                            <dd><input type="radio" id="checklist" class="yes" name="data[Vendor][checklist15]" value="Yes" 
                            <?php if(isset($this->request->data['Vendor']['checklist15']) && ($this->request->data['Vendor']['checklist15']=='Yes') )
								 	{echo 'checked="checked"';}?> />Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist15]" value="No" checked="checked" 
                                <?php if(isset($this->request->data['Vendor']['checklist15']) && ($this->request->data['Vendor']['checklist15']=='No') )
								 	{echo 'checked="checked"';}?> />No&nbsp;&nbsp;&nbsp;
                                <div class="sheet" style="display:none;">
                                    <select  name="data[Checklist][trade_sheet]" id="checklist_trade_sheet" class="validate[required]" >
                                        <option value="">Select Types</option>
<?php
foreach ($statues as $status) {
    if (isset($this->request->data['Checklist']['trade_sheet']) && $this->request->data['Checklist']['trade_sheet'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                                    </select>
                                </div>
                            </dd>                   
                        </dl>
                    </fieldset>
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
    </div>
</div> 

<script>
    $(document).ready(function () {
        /***start****/
        $('.add_field_button').click(function () {
            var values = parseInt($('#offical_contacts').val()) + 1;
            var contactphone = $('#cphone0').val();
            if ($('.acontact').length < 5) {
                $('#addcontact').append('<div class="acontact"> <fieldset><legend>Contacts</legend> <dt><label for="name">Name<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Vendorcontact]['+ values+'][name]" class="validate[required]" id="cname' +values+'" size="50" value="Cheque"/></dd>' + ' <dt><label for="name">Designation<span class="required">*</span></label></dt>' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][designation]" class="validate[required]" id="cdesignation' + values + '" size="50" value=""/></dd>' + '<dt><label for="name">Phone No.&nbsp;</label></dt>' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][phone]"  id="cphone' + values + '" size="50" onkeypress="return intnumbers(this,event)" value="' + contactphone + '"/></dd>' + '<dt><label for="name">Mobile No.<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Vendorcontact][' + values + '][mobile]"  class="validate[required]"  id="cmobile' + values + '" size="50" onkeypress="return intnumbers(this,event)" maxlength="12" value=""/></dd>' + ' <dt><label for="name">Email ID<span class="required">*</span></label></dt> ' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][email]" class="validate[required,custom[email]]" id="cemail' + values + '" size="50" value=""/>&nbsp;<a class="remove_field">Remove</a></dd></fieldset></div>');
                $('.acontact input').uniform();
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
        /***start****/
        $('.add_field_button_plant').click(function () {
            var values = parseInt($('#jewellery_machinery').val()) + 1;
            if ($('.aplant').length < 4) {
                $('#addplantmachinery').append('<div class="aplant"> <fieldset><legend>Plant</legend><dt><label for="name">Manufacturer Name</label></dt>' + '<dd><input type="text" name="data[Vendorplant][' + values + '][manufacture_name]" class="validate[required]" id="manufacturename' + values + '" size="50" value=""/></dd>' + '<dt><label for="name">Year of Mfg</label></dt>' + '<dd><input type="text" name="data[Vendorplant][' + values + '][year]" class="validate[required]" id="year1' + values + '" size="50" value=""/>&nbsp;<a class="remove_field_plant">Remove</a></dd></fieldset></div>');
                $('.aplant input').uniform();
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

                $('#jewellery_machinery').val(values);
            } else {
                alert('You must enter only 5 jewellery plant');
            }
        });
        /********end****/
        /***start****/
        $('.add_field_button_client').click(function () {
            var values = parseInt($('#client').val()) + 1;
            if ($('.aclient').length < 2) {
                $('#addclentele').append('<div class="aclient"> <fieldset><legend>Clientele</legend><dt><label for="name">Client Name</label></dt>' + '<dd><input type="text" name="data[Vendorclient][' + values + '][client]" class="validate[required]" id="client1' + values + '" size="50" value=""/></dd>' + '<dt><label for="name">Average Turnover(in lakhs)</label></dt>' + '<dd><input type="text" name="data[Vendorclient][' + values + '][turnover]" class="validate[required]" id="turnover' + values + '" size="50" value=""/>&nbsp;<a class="remove_field_client">Remove</a></dd></fieldset></div>');
                $('.aclient input').uniform();
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

                $('#client').val(values);
            } else {
                alert('You must enter only 3 clients');
            }
        });
        /********end****/

    });

    $('.remove_field').live('click', function (e) {
        $(this).parents('.acontact').remove();
    });

    $('.remove_field_plant').live('click', function (e) {
        $(this).parents('.aplant').remove();
    });
    $('.remove_field_client').live('click', function (e) {
        $(this).parents('.aclient').remove();
    });
</script>




<script type="text/javascript">
    $(document).ready(function () {
        $('#regofficeaddress').click(function () {
            if ($('#regofficeaddress').is(':checked')) {

                $('#hoaddress').val($('#regaddress').val());
                $('#hoaddress1').val($('#regaddress1').val());
                $('#hocity').val($('#regcity').val());
                $('#hopincode').val($('#regpincode').val());
                $('#hophone').val($('#regphone').val());
                $('#hophone1').val($('#regphone1').val());
                $('#homobile').val($('#regmobile').val());

                var state = $('#regstate').val();
                if (state != '') {
                    $('#hostate').val(state);
                    $('#hostate').parents('.selector').find('span').html(state);
                }
            } else {
//Clear on uncheck
                $('#hoaddress').val("");
                $('#hoaddress1').val("");
                $('#hocity').val("");
                $('#hopincode').val("");
                $('#hophone').val("");
                $('#hophone1').val("");
                $('#homobile').val("");
                $('#hostate').val('');
                $('#hostate').parents('.selector').find('span').html('state');

            }
            ;

        });
        $('#regofficeaddress_work').click(function () {
            if ($('#regofficeaddress_work').is(':checked')) {

                $('#workaddress').val($('#regaddress').val());
                $('#workaddress1').val($('#regaddress1').val());
                $('#workcity').val($('#regcity').val());
                $('#workpincode').val($('#regpincode').val());
                $('#workphone').val($('#regphone').val());
                $('#workphone1').val($('#regphone1').val());
                $('#workmobile').val($('#regmobile').val());

                var state = $('#regstate').val();
                if (state != '') {
                    $('#workstate').val(state);
                    $('#workstate').parents('.selector').find('span').html(state);
                }
            } else {
//Clear on uncheck
                $('#workaddress').val("");
                $('#workaddress1').val("");
                $('#workcity').val("");
                $('#workpincode').val("");
                $('#workphone').val("");
                $('#workphone1').val("");
                $('#homobile').val("");
                $('#workstate').val('');
                $('#workstate').parents('.selector').find('span').html('state');

            }
            ;

        });
    });

</script>
<!-- <script>
$(document).ready(function(){
$('#checklist1').click(function() {
var checklist1=$('#checklist1').val();
if($('#checklist1').val()==1){
        $('.checklist').show();
}
});
$('#checklist2').click(function() {
var checklist2=$('#checklist2').val();
if($('#checklist2').val()==2){
        $('.checklist').hide();
}
});

});
</script>-->
<script>
    $(document).ready(function () {
        $(".yes").click(function () {
            thisvar = $(this);
            thisvar.parents("dd").find('.sheet').show();


        });
        $(".no").click(function () {
            thisvar = $(this);
            thisvar.parents("dd").find('.sheet').hide();

        });
    });

</script>