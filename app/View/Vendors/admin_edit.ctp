<style>
form dl.inline dd {
	display: inline-flex;
}
</style>
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Vendor Details'), array('action' => 'index'), array('class' => 'button')); ?></div>
    <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>Edit Vendor</legend>
        <dl class="inline">
          <fieldset>
            <legend>Company</legend>
            <dl class="inline">
              <dt>
                <label for="name">Vendor Code&nbsp;</label>
              </dt>
              <dd><?php echo $vendor['Vendor']['vendor_code']; ?></dd>
              <dt>
                <label for="name">Vendor Status<span class="required">*</span></label>
              </dt>
              <dd>
                <select  name="data[Vendor][vendor_status]" id="status1" class="validate[required]"  >
                  <option value="">Status</option>
                  <?php
                                    foreach ($statues as $status) {

                                        echo "<option value='" . $status['Status']['vendor_status_id'] . "' " . ($vendor['Vendor']['vendor_status'] == $status['Status']['vendor_status_id'] ? 'selected="selected"' : '') . ">" . $status['Status']['vendor_status'] . "</option>";
                                    }
                                    ?>
                </select>
              </dd>
              <dt>
                <label for="name">Company<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][Company_name]" id="Companyname"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['Company_name'] ?>"/>
              </dd>
              <dt>
                <label for="name">Preferred Billing Address<span class="required">*</span></label>
              </dt>
              <dd>
                <select class="validate[required]]" name="data[Vendor][preferred_billing]" id="perferedbilling">
                  <option value="">Select</option>
                  <option value="Reg.off" <?php if ($vendor['Vendor']['preferred_billing'] == 'Reg.off') {
                                        echo 'Selected';
                                    } ?>>Register Office Address</option>
                  <option value="Ho"  <?php if ($vendor['Vendor']['preferred_billing'] == 'Ho') {
                                        echo 'Selected';
                                    } ?>>Head Office Address</option>
                </select>
              </dd>
              <dt>
                <label for="name">Vendor Type<span class="required">*</span></label>
              </dt>
              <dd>
                <select class="validate[required]" name="data[Vendor][vendor_type]" id="vendortype">
                  <option value="">Select</option>
                  <?php
                                    foreach ($type as $type) {

                                        echo "<option value='" . $type['Type']['vendor_type_id'] . "' " . ($vendor['Vendor']['vendor_type'] == $type['Type']['vendor_type_id'] ? 'selected="selected"' : '') . ">" . $type['Type']['vendor_type'] . "</option>";
                                    }
                                    ?>
                </select>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Register Office Address</legend>
            <dl class="inline">
              <dt>
                <label for="name">Address<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_address]" id="regaddress"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['reg_address'] ?>"/>
              </dd>
              <dt>
                <label for="name"></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_address1]" id="regaddress1"  size="50" value="<?php echo $vendor['Vendor']['reg_address1'] ?>"/>
              </dd>
              <dt>
                <label for="name">City<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_city]" id="regcity"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['reg_city'] ?>"/>
              </dd>
              <dt>
                <label for="name">State<span class="required">*</span></label>
              </dt>
              <dd>
                <select name="data[Vendor][reg_state]" class="validate[required]" id="regstate">
                  <option value="">State<span class="required">*</span></option>
                  <?php
                                    foreach ($state as $states) {
                                        echo "<option value='" . $states['State']['state'] . "' " . ($vendor['Vendor']['reg_state'] == $states['State']['state'] ? 'selected="selected"' : '') . ">" . $states['State']['state'] . "</option>";
                                    }
                                    ?>
                </select>
              </dd>
              <dt>
                <label for="name">Pincode<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_pincode]" id="regpincode"  class="validate[required,custom[integer],minSize[6]]" onkeypress="return intnumbers(this, event)" maxlength="6"
                                       size="50" value="<?php echo $vendor['Vendor']['reg_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone No.(1)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_phone]" id="regphone"  class="validate[required,custom[integer]]" 
                                       onkeypress="return intnumbers(this, event)" size="50" value="<?php echo $vendor['Vendor']['reg_phone'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone No.(2)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_phone1]" id="regphone1"   onkeypress="return intnumbers(this, event)"
                                       size="50" value="<?php echo $vendor['Vendor']['reg_phone1'] ?>"/>
              </dd>
              <dt>
                <label for="name">Mobile No.<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][reg_mobile]" id="regmobile"  class="validate[required,custom[integer],minSize[10]]"  onkeypress="return intnumbers(this, event)" maxlength="10"
                                       size="50" value="<?php echo $vendor['Vendor']['reg_mobile'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Head Office Address</legend>
            <dl class="inline">
              <dt>
                <label for="name">
                  <input type="checkbox" name="regofficeaddresscheck" id="regofficeaddress"   value=""  />
                </label>
              </dt>
              <dd style="font-weight:bold;">
                <label for="name"> Address same as Registered Office</label>
              </dd>
              <dt>
                <label for="name">Address<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_address]" id="hoaddress"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['ho_address'] ?>"/>
              </dd>
              <dt>
                <label for="name"></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_address1]" id="hoaddress1"   size="50" value="<?php echo $vendor['Vendor']['ho_address1'] ?>"/>
              </dd>
              <dt>
                <label for="name">City<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_city]" id="hocity"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['ho_city'] ?>"/>
              </dd>
              <dt>
                <label for="name">State<span class="required">*</span></label>
              </dt>
              <dd>
                <select name="data[Vendor][ho_state]" class="validate[required]" id="hostate">
                  <option value="">State</option>
                  <?php
                                    foreach ($state as $states) {
                                        echo "<option value='" . $states['State']['state'] . "' " . ($vendor['Vendor']['ho_state'] == $states['State']['state'] ? 'selected="selected"' : '') . ">" . $states['State']['state'] . "</option>";
                                    }
                                    ?>
                </select>
              </dd>
              <dt>
                <label for="name">Pincode<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_pincode]" id="hopincode"  class="validate[required,minSize[6]]" onkeypress="return intnumbers(this, event)"  maxlength="6"
                                       size="50" value="<?php echo $vendor['Vendor']['ho_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone  No.(1)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_phone]" id="hophone"  class="validate[required]]" onkeypress="return intnumbers(this, event)"  
                                       size="50" value="<?php echo $vendor['Vendor']['ho_phone'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone No.(2)&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_phone1]" id="hophone1"   onkeypress="return intnumbers(this, event)" 
                                       size="50" value="<?php echo $vendor['Vendor']['ho_phone1'] ?>"/>
              </dd>
              <dt>
                <label for="name">Mobile No.<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ho_mobile]" id="homobile"  class="validate[required,minSize[10]]" size="50" onkeypress="return intnumbers(this, event)" maxlength="10" 
                                       value="<?php echo $vendor['Vendor']['ho_mobile'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Workshop/Factory Address</legend>
            <dl class="inline">
              <dt>
                <label for="name">
                  <input type="checkbox" name="regofficeaddresscheck" id="regofficeaddress_work"   value=""  />
                </label>
              </dt>
              <dd style="font-weight:bold;">
                <label for="name"> Address same as Registered Office</label>
              </dd>
              <dt>
                <label for="name">Address<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_address]" id="workaddress"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['ho_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name"></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_address1]" id="workaddress1"  class="" size="50" value="<?php echo $vendor['Vendor']['ho_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name">City<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_city]" id="workcity"  class="validate[required]" size="50" value="<?php echo $vendor['Vendor']['ho_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name">State<span class="required">*</span></label>
              </dt>
              <dd>
                <select name="data[Vendor][work_state]" class="validate[required]" id="workstate">
                  <option value="">State</option>
                  <?php
                                    foreach ($state as $states) {
                                        echo "<option value='" . $states['State']['state'] . "' " . ($vendor['Vendor']['work_state'] == $states['State']['state'] ? 'selected="selected"' : '') . ">" . $states['State']['state'] . "</option>";
                                    }
                                    ?>
                </select>
              </dd>
              <dt>
                <label for="name">Pincode<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_pincode]" id="workpincode"  class="validate[required,custom[integer],minSize[6]]" onkeypress="return intnumbers(this, event)" maxlength="6"
                                       size="50"   value="<?php echo $vendor['Vendor']['work_pincode'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone  No.(1)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_phone]" id="workphone"  class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" 
                                       size="50" value="<?php echo $vendor['Vendor']['work_phone'] ?>"/>
              </dd>
              <dt>
                <label for="name">Phone No.(2)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_phone1]" id="workphone1"   onkeypress="return intnumbers(this, event)" 
                                       size="50" value="<?php echo $vendor['Vendor']['work_phone1'] ?>"/>
              </dd>
              <dt>
                <label for="name">Mobile No.<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_mobile]" id="workmobile"  class="validate[required,custom[integer],minSize[10]]" onkeypress="return intnumbers(this, event)" maxlength="10"
                                       size="50" value="<?php echo $vendor['Vendor']['work_mobile'] ?>"/>
              </dd>
            </dl>
          </fieldset>
           <?php
			              if(!empty($vendorcontact)){
						  
			  
                            $vccount = count($vendorcontact);
                            $i = 0;
                            foreach ($vendorcontact as $vcontact) {
                                ?>
          <fieldset>
            <legend>Officials Contacts</legend>
            <dl class="inline" id="addcontact">
             
              <div class="acontact">
                <fieldset>
                  <legend>Contacts</legend>
                  <dt>
                    <label for="name">Name<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][<?php echo $i; ?>][name]" class="validate[required]" id="cname<?php echo $i; ?>" size="50" value="<?php echo $vcontact['Vendorcontact']['name'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Designation<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][<?php echo $i; ?>][designation]" class="validate[required]" id="cdesignation<?php echo $i; ?>" size="50" value="<?php echo $vcontact['Vendorcontact']['designation'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Phone No<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][<?php echo $i; ?>][phone]" class="validate[required]" id="cphone<?php echo $i; ?>"  onkeypress="return intnumbers(this, event)"
                                                   size="50"  value="<?php echo $vcontact['Vendorcontact']['phone'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Mobile No<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][<?php echo $i; ?>][mobile]"  class="validate[required,minSize[10]]"  id="cmobile<?php echo $i; ?>"  onkeypress="return intnumbers(this, event)" 
                                                   maxlength="10"  size="50" value="<?php echo $vcontact['Vendorcontact']['mobile'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Email ID<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][<?php echo $i; ?>][email]" class="validate[required,custom[email]]" id="cemail<?php echo $i; ?>" size="50" value="<?php echo $vcontact['Vendorcontact']['email'] ?>"/>
                    &nbsp;
                    <?php if ($i > 0) { ?>
                    <a class="remove_field">Remove</a>
                    <?php } else {
                                                ?>
                    <button type="button" class="button add_field_button" name="addcontacts"  value="">Add</button>
                    <?php } ?>
                  </dd>
                </fieldset>
              </div>
              
            </dl>
            <input type="hidden" name="offical_contacts" id="offical_contacts" value="0"/>
          </fieldset>
          <?php $i++;
}}
else{
	$vccount=0;
	 ?>
 <fieldset>
            <legend>Officials Contacts</legend>
            <dl class="inline" id="addcontact">
             
              <div class="acontact">
                <fieldset>
                  <legend>Contacts</legend>
                  <dt>
                    <label for="name">Name<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][0][name]" class="validate[required]" id="cname0"  size="50" value=""/>
                  </dd>
                  <dt>
                    <label for="name">Designation<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][0][designation]" class="validate[required]" id="cdesignation0"   size="50" value=""/>
                  </dd>
                  <dt>
                    <label for="name">Phone No<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][0][phone]" class="validate[required]" id="cphone0"  onkeypress="return intnumbers(this, event)"
                                                   size="50"  value=""/>
                  </dd>
                  <dt>
                    <label for="name">Mobile No<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][0][mobile]"  class="validate[required,minSize[10]]"    onkeypress="return intnumbers(this, event)" 
                                                   maxlength="10"  size="50" value=""/>
                  </dd>
                  <dt>
                    <label for="name">Email ID<span class="required">*</span></label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorcontact][0][email]" class="validate[required,custom[email]]"  size="50" value=""/>
                    &nbsp;
                  
                    <button type="button" class="button add_field_button" name="addcontacts"  value="">Add</button>
                   
                  </dd>
                </fieldset>
              </div>
              
            </dl>
            <input type="hidden" name="offical_contacts" id="offical_contacts" value="<?php echo $vccount; ?>"/>
          </fieldset>
<?php }?>
          <fieldset>
            <legend>Financial Details</legend>
            <dl class="inline">
              <dt>
                <label for="name">Bank Name<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][bank_name]" class="validate[required]" id="bankname" size="50" value="<?php echo $vendor['Vendor']['bank_name'] ?>"/>
              </dd>
              <dt>
                <label for="name">Account No<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][account_no]" class="validate[required]"  id="accountno" size="50" value="<?php echo $vendor['Vendor']['account_no'] ?>"/>
              </dd>
              <dt>
                <label for="name">Account Type <span class="required">*</span></label>
              </dt>
              <dd>
                <select class="validate[required]]" name="data[Vendor][account_type]"  id="accounttype">
                  <option value="">Select</option>
                  <?php
foreach ($accounttype as $accounttype) {
    echo "<option value='" . $accounttype['Accounttype']['account_id'] . "'" . ($vendor['Vendor']['account_type'] == $accounttype['Accounttype']['account_id'] ? 'selected="selected"' : '') . "'>" . $accounttype['Accounttype']['account_type'] . "</option>";
}
?>
                </select>
              </dd>
              <dt>
                <label for="name">MICR CODE<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][micr_code]" class="validate[required,custom[integer],minSize[9]]" onkeypress="return intnumbers(this, event)"
                                       id="micrcode" size="50" maxlength="9" value="<?php echo $vendor['Vendor']['micr_code'] ?>"/>
              </dd>
              <dt>
                <label for="name">IFSC CODE<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][ifsc_code]" class="validate[required,minSize[11]]" id="ifsccode"  maxlength="11" size="50" value="<?php echo $vendor['Vendor']['ifsc_code'] ?>"/>
              </dd>
              <dt>
                <label for="name">Pincode<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][bank_pincode]" class="validate[required]"  onkeypress="return intnumbers(this, event)" maxlength="6"
                                       id="bankpincode" size="50" value="<?php echo $vendor['Vendor']['bank_pincode'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Taxation/Registration Details</legend>
            <dl class="inline">
              <dt>
                <label for="name">State Sales Tax (SST)&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][state_sales_tax]"  id="statesalestax" size="50" value="<?php echo $vendor['Vendor']['state_sales_tax'] ?>"/>
              </dd>
              <dt>
                <label for="name">Central Sales Tax(CST)&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][central_sales_tax]"   id="centralsalestax" size="50" value="<?php echo $vendor['Vendor']['central_sales_tax'] ?>"/>
              </dd>
              <dt>
                <label for="name">Tax Index No.(TIN) (for VAT)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][tax_index_no]" class="validate[required]" id="taxindexno" size="50" value="<?php echo $vendor['Vendor']['tax_index_no'] ?>"/>
              </dd>
              <dt>
                <label for="name">Work Contract Tax (WCT)&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][work_contact_tax]"  id="workcontacttax" size="50" value="<?php echo $vendor['Vendor']['work_contact_tax'] ?>"/>
              </dd>
              <dt>
                <label for="name">Goods &Services Tax (GST)&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][good_service_tax]"  id="goodservicetax" size="50" value="<?php echo $vendor['Vendor']['good_service_tax'] ?>"/>
              </dd>
              <dt>
                <label for="name">Vaue Added Tax (VAT)<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][value_add_tax]" class="validate[required]" id="valueaddtax" size="50" value="<?php echo $vendor['Vendor']['value_add_tax'] ?>"/>
              </dd>
              <dt>
                <label for="name">PAN NO<span class="required">*</span></label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][panno]" class="validate[required,custom[pan]]" id="pannumber" size="50" value="<?php echo $vendor['Vendor']['panno'] ?>"/>
              </dd>
              <dt>
                <label for="name">&nbsp;</label>
              </dt>
              <dd>
                <label for="name" style="font-weight:bold;">Eg : The Pancard format is ABCDE1234Z</label>
              </dd>
              <dt>
                <label for="name">Tax Relaxation&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][taxrelexation]"  id="taxrelexation1" size="50" value="<?php echo $vendor['Vendor']['taxrelexation'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Business Statistics</legend>
            <dl class="inline">
              <dt>
                <label for="name">Total Experience</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][total_experience]"  id="totalexperience" size="50" value="<?php echo $vendor['Vendor']['total_experience'] ?>"/>
              </dd>
              <dt>
                <label for="name">Turnover for last 1 years</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][turnover_first_year]"  id="turnoverfirstyear" size="50" value="<?php echo $vendor['Vendor']['turnover_first_year'] ?>"/>
              </dd>
              <dt>
                <label for="name">Turnover for last 1 years</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][turnover_second_year]"  id="turnoversecondyear" size="50" value="<?php echo $vendor['Vendor']['turnover_first_year'] ?>"/>
              </dd>
              <dt>
                <label for="name">Paid Up Capital</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][capital_amount]"   id="capitalamount" size="50" value="<?php echo $vendor['Vendor']['capital_amount'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Product</legend>
            <dl class="inline">
              <?php $page = explode(",", $vendor['Vendor']['Product_category']);
//print_r($page);exit;
?>
              <dt>
                <label for="name">Category&nbsp;</label>
              </dt>
              <dd>
                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" 
                                       <?php if (in_array('Gold', $page)) {
                                           echo 'checked="checked"';
                                       } ?> value="Gold" />
                Gold
                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Silver" 
                                       <?php if (in_array('Silver', $page)) {
                                           echo 'checked="checked"';
                                       } ?>/>
                Silver
                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Diamond"
<?php if (in_array('Diamond', $page)) {
    echo 'checked="checked"';
} ?>/>
                Diamond
                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Platinum" 
<?php if (in_array('Platinum', $page)) {
    echo 'checked="checked"';
} ?>/>
                Platinum
                <input type="checkbox" name="data[Vendor][Product_category][]"  id="Productcategory" size="50" value="Palladium" 
                            <?php if (in_array('Palladium', $page)) {
                                echo 'checked="checked"';
                            } ?>/>
                Palladium </dd>
              <dt>
                <label for="name">Certification/Standardization&nbsp;</label>
              </dt>
              <dd>
                <input type="text" name="data[Vendor][product_certificate]"  id="turnoverfirstyear" size="50" value="<?php echo $vendor['Vendor']['product_certificate'] ?>"/>
              </dd>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Jewellery Making Plant and Machinery Specification</legend>
            <dl class="inline" id="addplantmachinery">
              <?php
$vplantcount = count($vendorplant);
$j = 0;
if (!empty($vendorplant)) {
    foreach ($vendorplant as $vplant) {
        ?>
              <div class="aplant">
                <fieldset>
                  <legend>Plant&nbsp;</legend>
                  <dt>
                    <label for="name">Manufacturer Name</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorplant][<?php echo $j; ?>][manufacture_name]"  id="manufacturename<?php echo $j; ?>" size="50" value="<?php echo $vplant['Vendorplant']['manufacture_name'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Year of Mfg&nbsp;</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorplant][<?php echo $j ?>][year]"  id="years<?php echo $j; ?>" size="50" value="<?php echo $vplant['Vendorplant']['year'] ?>"/>
                    &nbsp;
                    <?php if ($j > 0) { ?>
                    <a class="remove_field_plant">Remove</a>
                    <?php } else {
            ?>
                    <button type="button" class="button add_field_button_plant" name="addplant"  value="">Add</button>
                    <?php } ?>
                  </dd>
                </fieldset>
              </div>
              <?php
        $j++;
    }
} else {
    ?>
              <div class="aplant">
                <fieldset>
                  <legend>Plant&nbsp;</legend>
                  <dt>
                    <label for="name">Manufacturer Name</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorplant][0][manufacture_name]"  id="manufacturename0" size="50" 
                                                   value="<?php if (isset($this->request->data['Vendorplant']['0']['manufacture_name'])) {
        echo $this->request->data['Vendorplant']['0']['manufacture_name'];
    } ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Year of Mfg</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorplant][0][year]"  id="year10" size="50" 
                                                   value="<?php if (isset($this->request->data['Vendorplant']['0']['year'])) {
                                echo $this->request->data['Vendorplant']['0']['year'];
                            } ?>"/>
                    &nbsp;
                    <button type="button" 
                                                    class="button add_field_button_plant" name="addplant"  value="">Add</button>
                  </dd>
                </fieldset>
              </div>
              <?php }
?>
              <input type="hidden" name="jewellery_machinery" id="jewellery_machinery" value="<?php echo $vplantcount; ?>"/>
            </dl>
          </fieldset>
          <fieldset>
            <legend>Please enclose list of top 3 clientele</legend>
            <dl class="inline" id="addclentele" >
              <?php
                                        $vclientcount = count($vendorclient);
                                        $k = 0;
                                        if (!empty($vendorclient)) {
                                            foreach ($vendorclient as $vclient) {
                                                ?>
              <div class="aclient">
                <fieldset>
                  <legend>Clientele&nbsp;</legend>
                  <dt>
                    <label for="name">Client Name</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorclient][<?php echo $k ?>][client]"  id="clients<?php echo $k ?>" size="50" 
                                                       value="<?php echo $vclient['Vendorclient']['client'] ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Average Turnover(in lakhs)&nbsp;</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorclient][<?php echo $k ?>][turnover]"  id="turnover<?php echo $k ?>" size="50"
                                                       value="<?php echo $vclient['Vendorclient']['turnover'] ?>"/>
                    &nbsp;
                    <?php if ($k > 0) { ?>
                    <a class="remove_field_client">Remove</a>
                    <?php } else {
            ?>
                    <button type="button" class="button add_field_button_client" name="addclient"  value="">Add</button>
                    <?php } ?>
                  </dd>
                </fieldset>
              </div>
              <?php $k++;
    } ?>
              <?php } else { ?>
              <div class="aclient">
                <fieldset>
                  <legend>Clientele&nbsp;</legend>
                  <dt>
                    <label for="name">Client Name</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorclient][0][client]"  id="client10" size="50" 
                                                   value="<?php if (isset($this->request->data['Vendorclient']['0']['client'])) {
                            echo $this->request->data['Vendorclient']['0']['client'];
                        } ?>"/>
                  </dd>
                  <dt>
                    <label for="name">Average Turnover(in lakhs)</label>
                  </dt>
                  <dd>
                    <input type="text" name="data[Vendorclient][0][turnover]"  id="turnover0" size="50" 
                                                   value="<?php if (isset($this->request->data['Vendorclient']['0']['turnover'])) {
                            echo $this->request->data['Vendorclient']['0']['turnover'];
                        } ?>"/>
                    &nbsp;
                    <button type="button" class="button add_field_button_client" name="addclient" value="">Add</button>
                  </dd>
                </fieldset>
              </div>
              <?php } ?>
              <input type="hidden" name="client" id="client" value="<?php echo $vclientcount; ?>"/>
            </dl>
          </fieldset>
          <!--<fieldset><legend>Do you want to use checklist for Vendor Assessment?</legend>
                      <dt></dt><dd><?php
                                        $value = ($vendor['Vendor']['checklist'] == 1) ? "1" : "2";
                                        echo $this->Form->input('checklist', array('div' => false, 'type' => 'radio', 'id' => 'checklist', 'legend' => false, 'name' => 'data[Vendor][checklist]', 'value' => $value, 'options' => array('1' => 'Yes' . "&nbsp;&nbsp;&nbsp;&nbsp;", '2' => 'No')));
                                        ?></dd>
                     <input type="hidden" id="vendorcheck" value="<?php echo $vendor['Vendor']['checklist']; ?>"/>
                     </fieldset>-->
          
          <fieldset class="checklist">
            <legend>Checklist for Vendor Assessment, Selection & Negotiation</legend>
            <dl class="inline">
              <dt>
                <label for="name">Central Sales Tax Number(CST) </label>
              </dt>
              <dd>
                <?php
                                if (!empty($checklist['Checklist']['cst'])) {
                                    $yes = 'checked="checked"';
                                }
                                if (empty($checklist['Checklist']['cst'])) {
                                    $no = 'checked="checked"';
                                }
                                ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist]" value="Yes" <?php  if (!empty($checklist['Checklist']['cst'])) { echo $yes; }?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist]" value="No" <?php if (empty($checklist['Checklist']['cst'])) {
                                    echo 'checked="checked"';
                                } ?>/>
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet"  <?php if (empty($checklist['Checklist']['cst'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['cst']; ?>" />
                  <select  name="data[Checklist][cst]" id="checklist_cst"  class="validate[required]">
                    <option value="">Select Types</option>
                    <?php
                                        foreach ($statues as $status) {
                                            if (!empty($checklist['Checklist']['cst']) && $checklist['Checklist']['cst'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Local Sales Tax (LST) </label>
              </dt>
              <dd>
                <?php
                                if (!empty($checklist['Checklist']['lst'])) {
                                    $yes = 'checked="checked"';
                                }
                                if (empty($checklist['Checklist']['lst'])) {
                                    $no = 'checked="checked"';
                                }
                                ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist1]" value="Yes" <?php if (!empty($checklist['Checklist']['lst'])) { echo $yes; }?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist1]" value="No" <?php if (empty($checklist['Checklist']['lst'])) {
                                    echo 'checked="checked"';
                                } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['lst'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['lst']; ?>" />
                  <select  name="data[Checklist][lst]" id="checklist_lst" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                        foreach ($statues as $status) {
                                            if (!empty($checklist['Checklist']['lst']) && $checklist['Checklist']['lst'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Value Added Tax (VAT) </label>
              </dt>
              <dd>
                <?php
                                if (!empty($checklist['Checklist']['vat'])) {
                                    $yes = 'checked="checked"';
                                }
                                if (empty($checklist['Checklist']['vat'])) {
                                    $no = 'checked="checked"';
                                }
                                ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist2]" value="Yes"  <?php if (!empty($checklist['Checklist']['vat'])) { echo $yes; } ?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist2]" value="No"  <?php if (empty($checklist['Checklist']['vat'])) {
                                            echo 'checked="checked"';
                                        } ?>/>
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['vat'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['vat']; ?>" />
                  <select  name="data[Checklist][vat]" id="checklist_vat" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                        foreach ($statues as $status) {
                                            if (!empty($checklist['Checklist']['vat']) && $checklist['Checklist']['vat'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Permanent Account No. (PAN) </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['pan'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['pan'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist3]" value="Yes"  <?php if (!empty($checklist['Checklist']['pan'])) { echo $yes; } ?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist3]" value="No" <?php if (empty($checklist['Checklist']['pan'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['pan'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['pan']; ?>" />
                  <select  name="data[Checklist][pan]" id="checklist_pan" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['pan']) && $checklist['Checklist']['pan'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Proof of Authorised Signatory </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['signature_proof'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['signature_proof'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist4]" value="Yes"  <?php if (!empty($checklist['Checklist']['signature_proof'])) { echo $yes; } ?>  />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist4]" value="No" <?php if (empty($checklist['Checklist']['signature_proof'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['signature_proof'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['signature_proof']; ?>" />
                  <select  name="data[Checklist][signature_proof]" id="checklist_signature_proof" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['signature_proof']) && $checklist['Checklist']['signature_proof'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Proof of Bank Account </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['bank_proof'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['bank_proof'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist5]" value="Yes" <?php if (!empty($checklist['Checklist']['bank_proof'])) { echo $yes; } ?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist5]" value="No" <?php if (empty($checklist['Checklist']['signature_proof'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['bank_proof'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['bank_proof']; ?>" />
                  <select  name="data[Checklist][bank_proof]" id="checklist_bank_proof" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['bank_proof']) && $checklist['Checklist']['bank_proof'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Non-Disclosure Agreement (NDA) </label>
              </dt>
              <dd>
                <?php
                                        if (!empty($checklist['Checklist']['nda'])) {
                                            $yes = 'checked="checked"';
                                        }
                                        if (empty($checklist['Checklist']['nda'])) {
                                            $no = 'checked="checked"';
                                        }
                                        ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist6]" value="Yes" <?php   if (!empty($checklist['Checklist']['nda'])) { echo $yes; } ?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist6]" value="No" <?php if (empty($checklist['Checklist']['nda'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['nda'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['moa']; ?>" />
                  <select  name="data[Checklist][nda]" id="checklist_nda" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                foreach ($statues as $status) {
                                    if (!empty($checklist['Checklist']['nda']) && $checklist['Checklist']['moa'] == $status['Status']['vendor_status_id']) {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                    } else {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                    }
                                }
                                ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Memorandum of Association (MOA) </label>
              </dt>
              <dd>
                <?php
                                        if (!empty($checklist['Checklist']['moa'])) {
                                            $yes = 'checked="checked"';
                                        }
                                        if (empty($checklist['Checklist']['moa'])) {
                                            $no = 'checked="checked"';
                                        }
                                        ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist7]" value="Yes" <?php  if (!empty($checklist['Checklist']['moa'])) { echo $yes; }?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist7]" value="No" <?php if (empty($checklist['Checklist']['moa'])) {
                                            echo 'checked="checked"';
                                        } ?>  />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['moa'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['moa']; ?>" />
                  <select  name="data[Checklist][moa]" id="checklist_moa" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                foreach ($statues as $status) {
                                    if (!empty($checklist['Checklist']['moa']) && $checklist['Checklist']['moa'] == $status['Status']['vendor_status_id']) {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                    } else {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                    }
                                }
                                ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Article of Association (AOA) </label>
              </dt>
              <dd>
                <?php
                                        if (!empty($checklist['Checklist']['aoa'])) {
                                            $yes = 'checked="checked"';
                                        }
                                        if (empty($checklist['Checklist']['aoa'])) {
                                            $no = 'checked="checked"';
                                        }
                                        ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist8]" value="Yes" <?php if (!empty($checklist['Checklist']['aoa'])) { echo $yes; } ?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist8]" value="No" <?php if (empty($checklist['Checklist']['aoa'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['aoa'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['aoa']; ?>" />
                  <select  name="data[Checklist][aoa]" id="checklist_aoa" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                foreach ($statues as $status) {
                                    if (!empty($checklist['Checklist']['aoa']) && $checklist['Checklist']['aoa'] == $status['Status']['vendor_status_id']) {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                    } else {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                    }
                                }
                                ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Certificate of Incorporation </label>
              </dt>
              <dd>
                <?php
                                        if (!empty($checklist['Checklist']['certificate_incorporation'])) {
                                            $yes = 'checked="checked"';
                                        }
                                        if (empty($checklist['Checklist']['certificate_incorporation'])) {
                                            $no = 'checked="checked"';
                                        }
                                        ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist9]" value="Yes" <?php  if (!empty($checklist['Checklist']['certificate_incorporation'])) { echo $yes; } ?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist9]" value="No" <?php if (empty($checklist['Checklist']['certificate_incorporation'])) {
                                            echo 'checked="checked"';
                                        } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['certificate_incorporation'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['certificate_incorporation']; ?>" />
                  <select  name="data[Checklist][certificate_incorporation]" id="checklist_certificate_incorporation" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
                                foreach ($statues as $status) {
                                    if (!empty($checklist['Checklist']['certificate_incorporation']) && $checklist['Checklist']['certificate_incorporation'] == $status['Status']['vendor_status_id']) {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                    } else {
                                        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                    }
                                }
                                ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Board Resolution / Power of Attorney </label>
              </dt>
              <dd>
                <?php
                                        if (!empty($checklist['Checklist']['power_attorney'])) {
                                            $yes = 'checked="checked"';
                                        }
                                        if (empty($checklist['Checklist']['power_attorney'])) {
                                            $no = 'checked="checked"';
                                        }
                                        ?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist10]" value="Yes" <?php if (!empty($checklist['Checklist']['power_attorney'])) { echo $yes; } ?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist10]" value="No" <?php if (empty($checklist['Checklist']['power_attorney'])) {
                                    echo 'checked="checked"';
                                } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['power_attorney'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['power_attorney']; ?>" />
                  <select  name="data[Checklist][power_attorney]" id="checklist_power_attorney"  class="validate[required]">
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['power_attorney']) && $checklist['Checklist']['power_attorney'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Power of Attorney for signing the docs Form 32 </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['attorney_doc'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['attorney_doc'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist11]" value="Yes" <?php if (!empty($checklist['Checklist']['attorney_doc'])) { echo $yes; } ?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist11]" value="No"  <?php if (empty($checklist['Checklist']['attorney_doc'])) {
                                    echo 'checked="checked"';
                                } ?>  />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['attorney_doc'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['attorney_doc']; ?>" />
                  <select  name="data[Checklist][attorney_doc]" id="checklist_attorney_doc" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['attorney_doc']) && $checklist['Checklist']['attorney_doc'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Acknowledgement of Annual Return last file to ROC </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['roc'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['roc'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist12]" value="Yes"  <?php if (!empty($checklist['Checklist']['roc'])) { echo $yes; }?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist12]" value="No" <?php if (empty($checklist['Checklist']['roc'])) {
                                    echo 'checked="checked"';
                                } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['roc'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['roc']; ?>" />
                  <select  name="data[Checklist][roc]" id="checklist_roc" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['roc']) && $checklist['Checklist']['roc'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Partnership Deed </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['partnership_deed'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['partnership_deed'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist13]" value="Yes"  <?php if (!empty($checklist['Checklist']['partnership_deed'])) { echo $yes; }?> />
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist13]" value="No"  <?php if (empty($checklist['Checklist']['partnership_deed'])) {
                                    echo 'checked="checked"';
                                } ?> />
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['partnership_deed'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['partnership_deed']; ?>" />
                  <select  name="data[Checklist][partnership_deed]" id="checklist_partnership_deed"  class="validate[required]">
                    <option value="">Select Types</option>
                    <?php
                                        foreach ($statues as $status) {
                                            if (!empty($checklist['Checklist']['partnership_deed']) && $checklist['Checklist']['partnership_deed'] == $status['Status']['vendor_status_id']) {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
                                            } else {
                                                echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
                                            }
                                        }
                                        ?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Price List (Accepted by Sourcing Dept) </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['price_list'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['price_list'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist14]" value="Yes" <?php if (!empty($checklist['Checklist']['price_list'])) { echo $yes; }?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist14]" value="No"  <?php if (empty($checklist['Checklist']['price_list'])) {
    echo 'checked="checked"';
} ?>/>
                No&nbsp;&nbsp;&nbsp;
                <div class="sheet" <?php if (empty($checklist['Checklist']['price_list'])) { echo 'style="display:none;"';}?>>
                  <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['price_list']; ?>" />
                  <select  name="data[Checklist][price_list]" id="checklist_price_list" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['price_list']) && $checklist['Checklist']['price_list'] == $status['Status']['vendor_status_id']) {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '" selected="selected">' . $status['Status']['vendor_status'] . '</option>';
    } else {
        echo '<option value="' . $status['Status']['vendor_status_id'] . '">' . $status['Status']['vendor_status'] . '</option>\n';
    }
}
?>
                  </select>
                </div>
              </dd>
              <dt>
                <label for="name">Terms of Trade Sheet </label>
              </dt>
              <dd>
                <?php
if (!empty($checklist['Checklist']['trade_sheet'])) {
    $yes = 'checked="checked"';
}
if (empty($checklist['Checklist']['trade_sheet'])) {
    $no = 'checked="checked"';
}
?>
                <input type="radio" id="checklist" class="yes" name="data[Vendor][checklist15]" value="Yes"   <?php if (!empty($checklist['Checklist']['trade_sheet'])) { echo $yes; } ?>/>
                Yes&nbsp;&nbsp;&nbsp;
                <input type="radio" id="checklist" class="no" name="data[Vendor][checklist15]" value="No" <?php if (empty($checklist['Checklist']['trade_sheet'])) {
    echo 'checked="checked"';
} ?> />
                No&nbsp;&nbsp;&nbsp;
                <input type="hidden" class="new_vendor" value="<?php echo $checklist['Checklist']['trade_sheet']; ?>" />
                <div class="sheet" <?php if (empty($checklist['Checklist']['trade_sheet'])) { echo 'style="display:none;"';}?>>
                  <select  name="data[Checklist][trade_sheet]" id="checklist_trade_sheet" class="validate[required]" >
                    <option value="">Select Types</option>
                    <?php
foreach ($statues as $status) {
    if (!empty($checklist['Checklist']['trade_sheet']) && $checklist['Checklist']['trade_sheet'] == $status['Status']['vendor_status_id']) {
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
          <?php echo $this->Form->submit(__('Save'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Save'))); ?>
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
            var contactphone = $('#cphone0').val()!=''?$('#cphone0').val():'';
            if ($('.acontact').length < 6) {
                $('#addcontact').append('<div class="acontact"> <fieldset><legend>Contacts</legend> <dt><label for="name">Name<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Vendorcontact][' + values + '][name]" class="validate[required]" id="cname' + values + '" size="50" value=""/></dd>' + ' <dt><label for="name">Designation<span class="required">*</span></label></dt>' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][designation]" class="validate[required]" id="cdesignation' + values + '" size="50" value=""/></dd>' + '<dt><label for="name">Phone No.&nbsp;</label></dt>' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][phone]"  id="cphone' + values + '" size="50" onkeypress="return intnumbers(this,event)" value="' + contactphone + '"/></dd>' + '<dt><label for="name">Mobile No.<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Vendorcontact][' + values + '][mobile]"  class="validate[required]"  id="cmobile' + values + '" size="50" onkeypress="return intnumbers(this,event)" maxlength="12" value=""/></dd>' + ' <dt><label for="name">Email ID<span class="required">*</span></label></dt> ' + ' <dd><input type="text" name="data[Vendorcontact][' + values + '][email]" class="validate[required,custom[email]]" id="cemail' + values + '" size="50" value=""/>&nbsp;<a class="remove_field">Remove</a></dd></fieldset></div>');
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
            if ($('.aplant').length < 5) {
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
            if ($('.aclient').length < 3) {
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
<script>
    $(document).ready(function () {
      
        $(".yes").click(function () {
            thisvar = $(this);
            thisvar.parents("dd").find('.sheet').show();

        });
        $(".no").click(function () {
            thisvar = $(this);
            thisvar.parents("dd").find('.sheet').find('select').find('option').removeAttr("selected");
			thisvar.parents("dd").find('.sheet').hide();

        });
    });

</script>