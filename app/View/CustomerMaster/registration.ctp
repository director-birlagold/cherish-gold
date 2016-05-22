
		
		<link href="<?php echo BASE_URL ?>css/bootstrap1.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
		
		<link href="<?php echo BASE_URL ?>css/icons.css" rel="stylesheet" type="text/css"  />
<style>

#podob .error{
	margin-left: 3px !important;
    margin-right: -115px;
    margin-top: -31px !important;
}

.swMain ul.anchor li
{
	width: 20% !important;
}
.identitydetails .form-row
{
	width: 49% !important;
	float: left !important;
}
.identitydetails
{
	border : 1px solid #C4C4C4;
}
.stepContainer
{
	height: auto !important;
	
	border-top: none !important;
}
.popover
{
	width: 14% !important;
}
.form-row textarea
{
	margin-bottom: 5px !important;
}
.swMain
{
	width:auto !important;
	border : 1px solid #C4C4C4 !important;
}
fieldset{
	border :none !important;	
	margin-bottom: 1px;
}
.form-label{
	font-size: 13px !important;
}
.row-fluid > label{
	font-size: 13px !important;
}
</style>
<div id="container">
	<!----------------Slider Start---------------->
	<div id="container" class="">
		<div class="wrapper">
			<div class="sliderDiv lF">
							</div>
		</div>
	</div>
	<!----------------Slider End----------------> 
	<div class="clr"></div>
		<div class="wrapper">
			<div class="MidSection">
				<h4>BGP Plan Registration</h4>
				<p>&nbsp;</p>
				<form action="#" method="POST" class="form-horizontal" id="wizzard-form11">
					<!-- Smart Wizard -->
					<input type="hidden" id="customer_id" name="data[CustomerBGP][customer_id]" value="" />
					<input type="hidden" id="user_id" name="data[CustomerBGP][user_id]" value="<?php echo $this->Session->read("User.user_id"); ?>" />
					<input type="hidden" id="application_no" name="data[CustomerBGP][application_no]" value="" />
					<div id="wizard-validation" class="swMain" style="width: 100% ! important;">
						<ul>
							<li>
								<a href="#step-1">
									<label class="stepNumber">1</label> 
									<span class="stepDesc">Initial Details</span>
								</a>
							</li>
							<li>
								<a href="#step-2">
									<label class="stepNumber">2</label> 
									<span class="stepDesc">Personal details</span>
								</a>
							</li>
							<li>
								<a href="#step-3">
									<label class="stepNumber">3</label>
									<span class="stepDesc">Nomination details</span>
								</a>
							</li>
							<li>
								<a href="#step-4">
									<label class="stepNumber">4</label> 
									<span class="stepDesc">Payment details</span>
								</a>
							</li>
							<li>
								<a href="#step-5">
									<label class="stepNumber">5</label> 
									<span class="stepDesc">Confirm &amp; Submit</span>
								</a>
							</li>
						</ul>
						
												
						<div id="step-1" class="identitydetails" style="width: 97%; float: left; border-bottom: 1px solid rgb(196, 196, 196);">
							<div>
								<div class="form-row row-fluid">
									<div class="span12">
										<div class="row-fluid">
											<label class="form-label span4" for="contact_email"><label class="error" style="float: left; margin-right: 3px;">*</label>Your Email:</label>												
											<input class="span7" id="contact_email" name="data[CustomerBGP][contact_email]" type="email" value="<?php echo $email; ?>"  onchange="copyvalue('contact_email','contact_email_previous');"/>
										</div>
									</div>
								</div>
								<div class="form-row row-fluid">
									<div class="span12">
										<div class="row-fluid">
											<label class="form-label span4" for="contact_mobile"><label class="error" style="float: left; margin-right: 3px;">*</label>Your Mobile:</label>
											<input class="span7" id="contact_mobile" maxlength="10" name="data[CustomerBGP][contact_mobile]" type="text" value="<?php echo $phone; ?>" onchange="copyvalue('contact_mobile','contact_mobile_previous');"/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="step-2" class="identitydetails" style="width: 97%; float: left; border-bottom: 1px solid rgb(196, 196, 196);">
							<div>
								<fieldset>
									<legend>Fulfillment</legend>										
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span7" for="applicant_title" style="padding-top: 0px;height:55px;">Please select the fulfillment preference :</label>												
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="fulfilment1" name="data[CustomerBGP][fulfilment]" type="radio" data-check="fulfilment" value="Coin" checked="checked"/>Gold Jewellery.</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="fulfilment2" name="data[CustomerBGP][fulfilment]" type="radio" data-check="fulfilment" value="Jewellery" />Diamond Jewellery.</label>												
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="fulfilment3" name="data[CustomerBGP][fulfilment]" type="radio" data-check="fulfilment" value="Pendant" />Gold Pendant.</label>												
												</div>
											</div>
										</div>
									</div>	
								</fieldset>
								<fieldset>
									<legend>Distributor Details</legend>
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="partner_code">Distributor Code :</label>						
														<input class="span7" id="partner_code" name="data[CustomerBGP][partner_code]" type="text" value="" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="sub_partner_code">Sub-Partner Code :</label>
													<input class="span7" id="sub_partner_code" name="data[CustomerBGP][sub_partner_code]" type="text" value="" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="lead_source">Lead Source :</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="lead_source1" name="data[CustomerBGP][lead_source]" data-check="lead_source" type="radio" value="Website" checked="checked"  onchange="otherChange(this,'lead_source_other','Other');"/>Website</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="lead_source2" name="data[CustomerBGP][lead_source]" data-check="lead_source" type="radio" value="Social Media"  onchange="otherChange(this,'lead_source_other','Other');"/>Social Media</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="lead_source3" name="data[CustomerBGP][lead_source]" data-check="lead_source" type="radio" value="Mobile App"  onchange="otherChange(this,'lead_source_other','Other');"/>Mobile App</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="lead_source4" name="data[CustomerBGP][lead_source]" data-check="lead_source" type="radio" value="Newspaper"  onchange="otherChange(this,'lead_source_other','Other');"/>Newspaper</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="lead_source5" name="data[CustomerBGP][lead_source]" data-check="lead_source" type="radio" value="Other" onchange="otherChange(this,'lead_source_other','Other');"/>Other</label>
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="lead_source_other_lbl" style="display:none;"></label>
													<input class="span7" id="lead_source_other" name="data[CustomerBGP][lead_source_other]" type="text" value="" style="display:none;"/>
												</div>
											</div>
										</div>
									</div>								
								</fieldset>
								<fieldset class="identitydetails">
									<legend>Applicant Details</legend>
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_title">Title :</label>												
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="applicant_title1" name="data[CustomerBGP][applicant_title]" data-check="applicant_title" type="radio" value="Mr" checked="checked"/>Mr.</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="applicant_title2" name="data[CustomerBGP][applicant_title]" data-check="applicant_title"  type="radio" value="Ms" />Ms.</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;" id="applicant_title3" name="data[CustomerBGP][applicant_title]" data-check="applicant_title"  type="radio" value="Mrs" />Mrs.</label>
													
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_name"><label class="error" style="float: left; margin-right: 3px;">*</label>Name of Applicant :</label>
													<input class="span7" id="applicant_name" name="data[CustomerBGP][applicant_name]" type="text" value=""  onchange="copyvalue('applicant_name','pick_name');"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_status" style="height: 60px;">Status :</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_status1" name="data[CustomerBGP][applicant_status]" data-check="applicant_status" type="radio" value="Resident Individual" checked="checked"/>Resident Individual</label>
													<!-- <label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_status2" name="data[CustomerBGP][applicant_status]" data-check="applicant_status" type="radio" value="NRI" />NRI</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_status3" name="data[CustomerBGP][applicant_status]" data-check="applicant_status" type="radio" value="HUF" />HUF</label> -->
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_status4" name="data[CustomerBGP][applicant_status]" data-check="applicant_status" type="radio" value="On behalf of Minor" />On behalf of Minor</label>
												</div>
											</div>
										</div>
										
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_gender">Gender :</label>												
													<label class="span2"><input class="" id="applicant_gender1" style="margin-top: -3px; margin-right: 5px;"  name="data[CustomerBGP][applicant_gender]" data-check="applicant_gender" type="radio" value="Male" checked="checked"/>Male</label>
													<label class="span2"><input class="" id="applicant_gender2" style="margin-top: -3px; margin-right: 5px;"  name="data[CustomerBGP][applicant_gender]" data-check="applicant_gender" type="radio" value="Female" />Female</label>
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_dob">Date of Birth :</label>												
													<input class="span5" id="applicant_dob" name="data[CustomerBGP][applicant_dob]" type="text" value="" maxlength="0" /><a style="cursor: pointer;" onclick="clearTB('applicant_dob')">Clear</a>
													<div id="ageValidn" class="error" style="display: none">As applicant is minor please enter guardian details.</div>
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<table cellpadding="0" cellspacing="0" border="0" id="podob">
														<tr>
															<td>Proof of DOB :</td><td><input class="PODOB" style="margin-top: -3px; margin-right: 5px;"  id="applicant_dob_proof" name="data[CustomerBGP][applicant_dob_proof]" type="radio"  data-check="applicant_dob_proof" value="UID" ></td><td><span>UID AAdhar</span></td>
														</tr>
														<tr>
															<td></td><td><input class="PODOB" style="margin-top: -3px; margin-right: 5px;"  id="applicant_dob_proof" name="data[CustomerBGP][applicant_dob_proof]" type="radio"   data-check="applicant_dob_proof" value="Passport"  /></td><td><span>Passport</span></td>
														</tr>
														<tr>
															<td></td><td><input class="PODOB" style="margin-top: -3px; margin-right: 5px;"  id="applicant_dob_proof" name="data[CustomerBGP][applicant_dob_proof]" type="radio"  data-check="applicant_dob_proof" value="Voter Id" /></td><td><span>Voter Id</span></td>
														</tr>
														<tr>
															<td></td><td><input class="PODOB" style="margin-top: -3px; margin-right: 5px;"  id="applicant_dob_proof" name="data[CustomerBGP][applicant_dob_proof]" type="radio"  data-check="applicant_dob_proof" value="Pan Card" /></td><td><span>Pan Card</span></td>
														</tr>
														<tr>
															<td></td><td><input class="PODOB" style="margin-top: -3px; margin-right: 5px;"  id="applicant_dob_proof" name="data[CustomerBGP][applicant_dob_proof]" type="radio"  data-check="applicant_dob_proof" value="Other" /></td><td><span>Other</span></td>
														</tr>
														<tr><td></td><td></td><td><label class="span7" id="applicant_dob_proof_other_lbl" style="display: block;margin-left: 0;"><input class="span12" id="applicant_dob_proof_other" name="data[CustomerBGP][applicant_dob_proof_other]" type="text" value="" style="display: block;" /></label></td></tr>
													</table>
												
												
													<label class="form-label span4" for="applicant_dob_proof" style="height: 89px;"></label>
													<label style="float: left; margin-right: 20px;"></label>
													<label style="float: left; margin-right: 20px;"></label>
													<label style="float: left; margin-right: 20px;"></label>													
													<label style="float: left; margin-right: 20px;"></label>
													
												</div>
											</div>
										</div>
									</div>																															
								</fieldset>
								<fieldset class="identitydetails">
									<legend>Guardian Details <span style="font-size: 14px;">(in case applicant is minor)</span></legend>
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_guardian_title">Title :</label>												
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_guardian_title1" name="data[CustomerBGP][applicant_guardian_title]"   data-check="applicant_guardian_title" type="radio" value="Mr" checked="checked"/>Mr.</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_guardian_title2" name="data[CustomerBGP][applicant_guardian_title]" data-check="applicant_guardian_title" type="radio" value="Ms" />Ms.</label>
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_guardian_name">Name of Guardian :</label>
													<input class="span7" id="applicant_guardian_name" name="data[CustomerBGP][applicant_guardian_name]" type="text" value="" />
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_guardian_country_resident">Country of Residence :</label>
													<input class="span7" id="applicant_guardian_country_resident" name="data[CustomerBGP][applicant_guardian_country_resident]" type="text" value="India" readOnly="readOnly" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="applicant_guardian_relationship" style="height: 44px;">Relationship with minor :</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_guardian_relationship1" name="data[CustomerBGP][applicant_guardian_relationship]" data-check="applicant_guardian_relationship" type="radio" value="Father" checked="checked" onchange="otherChange(this,'applicant_guardian_relationship_other','Other');" />Father</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_guardian_relationship1" name="data[CustomerBGP][applicant_guardian_relationship]" data-check="applicant_guardian_relationship" type="radio" value="Mother"  onchange="otherChange(this,'applicant_guardian_relationship_other','Other');" />Mother</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="applicant_guardian_relationship2" name="data[CustomerBGP][applicant_guardian_relationship]" data-check="applicant_guardian_relationship" type="radio" value="Other" onchange="otherChange(this,'applicant_guardian_relationship_other','Other');" />Other</label>
													<label class="span7" id="applicant_guardian_relationship_other_lbl" style="display: none; margin-left: 0;"><input class="span12" id="applicant_guardian_relationship_other" name="data[CustomerBGP][applicant_guardian_relationship_other]" type="text" value="" style="display: none;" /></label>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset class="identitydetails">
									<legend>Mailing Details</legend>
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_address"><label class="error" style="float: left; margin-right: 3px;">*</label>Address :</label>
													<textarea class="span7" id="mailing_address" name="data[CustomerBGP][mailing_address]" onchange="copyvalue('mailing_address','pick_address');"></textarea>
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_landmark"><label class="error" style="float: left; margin-right: 3px;">*</label>Landmark :</label>
													<input class="span7" id="mailing_landmark" name="data[CustomerBGP][mailing_landmark]" type="text" value="" />
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_city"><label class="error" style="float: left; margin-right: 3px;">*</label>City :</label>
													<input class="span7" id="mailing_city" name="data[CustomerBGP][mailing_city]" type="text" value="" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_state"><label class="error" style="float: left; margin-right: 3px;">*</label>State :</label>
													<span id="ajax_mailing_state">
													<select class="span7" id="mailing_state" name="data[CustomerBGP][mailing_state]">
														<option value="">--State--</option>
																											</select>
													</span>
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_country"><label class="error" style="float: left; margin-right: 3px;">*</label>Country :</label>
													<input class="span7" id="mailing_country" name="data[CustomerBGP][mailing_country]" type="text" value="India" readonly="readOnly" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="mailing_pincode"><label class="error" style="float: left; margin-right: 3px;">*</label>Pincode :</label>
													<input class="span7" id="mailing_pincode" name="data[CustomerBGP][mailing_pincode]" type="text" value="" />
												</div>
											</div>
										</div>										
									</div>	
									<!--<div class="span12">
										<div class="row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span2"  style="margin-right: 8px;" for="mailing_overseas_address">Overseas Address (Mandatory for NRI) :</label>
													<input class="span9" style="width:77.068%;" id="mailing_overseas_address" name="data[CustomerBGP][mailing_overseas_address]" value="" type="text" />
												</div>
											</div>
										</div>																
									</div>-->	
								</fieldset>
								<fieldset class="identitydetails">
									<legend>Contact Details</legend>
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="contact_phone_residence">Phone Residence :</label>
													<input class="span7 digits" id="contact_phone_residence" name="data[CustomerBGP][contact_phone_residence]" type="text" value="" />
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="contact_phone_office">Phone Office :</label>
													<input class="span7 digits" id="contact_phone_office" name="data[CustomerBGP][contact_phone_office]" type="text" value="" />
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="contact_email_previous">Email :</label>
													<input class="span7" id="contact_email_previous" name="data[CustomerBGP][contact_email_previous]" type="email" value="" readonly="readonly"/>
												</div>
											</div>
										</div>
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="contact_mobile_previous">Mobile :</label>
													<input class="span7" id="contact_mobile_previous" name="data[CustomerBGP][contact_mobile_previous]" type="text" value="" readonly="readonly"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="span12">
										<div class="form-row row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span4" for="contact_pan_no">Pan No :</label>
													<input class="span7" id="contact_pan_no" name="data[CustomerBGP][contact_pan_no]" type="text" value="" />
												</div>
											</div>
										</div>										
									</div>
									<!--<div class="span12">
										<div class="row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span2" for="occupation" style="height: 60px;">Occupation :</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Private Sector" checked="checked" onchange="otherChange(this,'occupation_other','Other');" />Private Sector</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Government Service"  onchange="otherChange(this,'occupation_other','Other');" />Government Service</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Business" onchange="otherChange(this,'occupation_other','Other');" />Business</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Professional"  onchange="otherChange(this,'occupation_other','Other');" />Professional</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Agriculturist" onchange="otherChange(this,'occupation_other','Other');" />Agriculturist</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Retired"  onchange="otherChange(this,'occupation_other','Other');" />Retired</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation1" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Housewife" onchange="otherChange(this,'occupation_other','Other');" />Housewife</label>
													<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="occupation2" name="data[CustomerBGP][occupation]" type="radio" data-check="occupation" value="Other" onchange="otherChange(this,'occupation_other','Other');" />Other</label>
													<label class="span7" id="occupation_other_lbl" style="display: none;margin-left: 7px;"><input class="span6" id="occupation_other" name="data[CustomerBGP][occupation_other]" type="text" value="" style="display: none;" /></label>
												</div>
											</div>
										</div>																
									</div>-->
									<div class="span12">
										<div class="row-fluid">
											<div class="span12">
												<div class="row-fluid">
													<label class="form-label span12" for="occupation" style="height: 60px;">
														<input type="checkbox" class="" id="accept_terms" name="accept_terms" checked title=""/>
														I agree to receive updates via SMS on my registered mobile and receive Account Statements / Other Statutory as well as other information documents on my registered email in lieu of physical documents.
													</label>													
												</div>
											</div>
										</div>																
									</div>	
								</fieldset>
							</div>
						</div>
						<div id="step-3" class="identitydetails" style="width: 97%; float: left; border-bottom: 1px solid rgb(196, 196, 196);">
							<div>									
								<fieldset class="identitydetails">
									<legend>Nomination Details (Mandatory)</legend>										
									<div class="form-row row-fluid" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="nomination_name"><label class="error" style="float: left; margin-right: 3px;">*</label>Name :</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_name" name="data[CustomerBGP][nomination_name]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span5" for="nomination_guardian_name">Guardian Name (if nominee is minor):</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_guardian_name" name="data[CustomerBGP][nomination_guardian_name]" type="text"/>
												</div>
											</div>
										</div>
									</div>											
									<div class="form-row row-fluid" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="nomination_address"><label class="error" style="float: left; margin-right: 3px;">*</label>Address :</label>
												<div class="span7">
													<textarea class="span12 nominee" id="nomination_address" name="data[CustomerBGP][nomination_address]" type="text"></textarea>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span5" for="nomination_city"><label class="error" style="float: left; margin-right: 3px;">*</label>City :</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_city" name="data[CustomerBGP][nomination_city]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span5" for="nomination_state"><label class="error" style="float: left; margin-right: 3px;">*</label>State :</label>
												<div class="span7">
													<span id="ajax_nomination_state">
													<select class="span7" id="nomination_state" name="data[CustomerBGP][nomination_state]">
														<option value="">--State--</option>
																											</select>
													</span>
													<!-- <input class="span12 nominee" id="nomination_state" name="data[CustomerBGP][nomination_state]" type="text"/> -->
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="nomination_pincode"><label class="error" style="float: left; margin-right: 3px;">*</label>Pincode :</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_pincode" name="data[CustomerBGP][nomination_pincode]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span5" for="nomination_guardian_realtion">Guardian Relationship with minor :</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_guardian_realtion" name="data[CustomerBGP][nomination_guardian_realtion]" type="text"/>
												</div>
											</div>
										</div>
									</div>										
									<div class="form-row row-fluid" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="nomination_applicant_realtion"><label class="error" style="float: left; margin-right: 3px;">*</label>Relationship with Applicant :</label>
												<div class="span7">
													<input class="span12 nominee" id="nomination_applicant_realtion" name="data[CustomerBGP][nomination_applicant_realtion]" type="text"/>
												</div>
											</div>
										</div>
									</div>		
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span5" for="nomination_dob">Date of Birth (In case of Minor):</label>
												<div class="span7">
													<input class="span10 nominee" id="nomination_dob" name="data[CustomerBGP][nomination_dob]" type="text" maxlength="0" /><a style="cursor: pointer;" onclick="clearTB('nomination_dob')">Clear</a>
												</div>
												<div id="ageNonValidn" class="error span8" style="display: none; margin-left: 0px !important">As nominee is minor please enter guardian details.</div>
											</div>
										</div>
									</div>																																									
								</fieldset>									
							</div>
						</div>
						<div id="step-4" class="identitydetails" style="width: 97%; float: left; border-bottom: 1px solid rgb(196, 196, 196);">
							<div>
								<fieldset class="identitydetails">
									<legend>Initial Subscription Details</legend>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="initial_pay_by" style=""><label class="error" style="float: left; margin-right: 3px;">*</label>Payment Method :</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by" name="data[CustomerBGP][initial_pay_by]" type="radio"  data-check="initial_pay_by" value="Online" checked="checked" onchange="toggleFields1('online');"/>Online</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by1" name="data[CustomerBGP][initial_pay_by]" type="radio" data-check="initial_pay_by" value="Cheque"  onchange="toggleFields1('cheque');" />Cheque</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by2" name="data[CustomerBGP][initial_pay_by]" type="radio" data-check="initial_pay_by" value="Cash Pickup"  onchange="toggleFields1('pick');" />Cash Pickup</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by3" name="data[CustomerBGP][initial_pay_by]" type="radio" data-check="initial_pay_by" value="Self Deposit"  onchange="toggleFields1('self');" />Self Deposit</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by4" name="data[CustomerBGP][initial_pay_by]" type="radio" data-check="initial_pay_by" value="NEFT/RTGS"  onchange="toggleFields1('self');" />NEFT/RTGS</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="initial_pay_by5" name="data[CustomerBGP][initial_pay_by]" type="radio" data-check="initial_pay_by" value="ECS"  onchange="toggleFields1('ecs');" />ECS</label>														
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid online cheque all">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="initial_amount"><label class="error" style="float: left; margin-right: 3px;">*</label>Amount :</label>
												<div class="span7">
													<input class="span12 divisible100 digits" id="initial_amount" name="data[CustomerBGP][initial_amount]" type="text" min="1000" value="1000"  onchange="copyvalue('initial_amount','amount');"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid cheque all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="first_cheque_no"><label class="error" style="float: left; margin-right: 3px;">*</label>Cheque No. :</label>
												<div class="span7">
													<input class="span12 " id="first_cheque_no" name="data[CustomerBGP][first_cheque_no]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid cheque all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="first_cheque_bank"><label class="error" style="float: left; margin-right: 3px;">*</label>Bank Name :</label>
												<div class="span7">
													<input class="span12 " id="first_cheque_bank" name="data[CustomerBGP][first_cheque_bank]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid cheque all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="first_cheque_date"><label class="error" style="float: left; margin-right: 3px;">*</label>Date:</label>
												<div class="span7">
													<input class="span12" id="first_cheque_date" name="data[CustomerBGP][first_cheque_date]" value=""  type="text"/>
													
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">Bank Name:</label>
												<div class="span7">
													<input class="span12 " id="" value="ICICI Bank" disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">ICICI Account No:</label>
												<div class="span7">
													<input class="span12 " id="" value="102805001090" disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">ICICI Account Name:</label>
												<div class="span7">
													<input class="span12 " id="" value="Birla Gold And Precious Metals Limited" disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">ICICI IFSC/MICR:</label>
												<div class="span7">
													<input class="span12 " id="" value="ICIC0001028/400229097"  disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">Bank Name:</label>
												<div class="span7">
													<input class="span12 " id="" value="Axis Bank Ltd." disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">AXIS Account No:</label>
												<div class="span7">
													<input class="span12 " id="" value="916020009287419" disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">AXIS Account Name:</label>
												<div class="span7">
													<input class="span12 " id="" value="Birla Gold And Precious Metals Limited" disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid self all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="">AXIS IFSC/MICR:</label>
												<div class="span7">
													<input class="span12 " id="" value="UTIB0000020/400211006"  disabled type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid pick all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
											<label class="form-label span4" for="pick_name"><label class="error" style="float: left; margin-right: 3px;">*</label>Name:</label>
												<div class="span7">
													<input class="span12" id="pick_name" name="data[CustomerBGP][pick_name]" value=""  type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid pick all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="pick_address"><label class="error" style="float: left; margin-right: 3px;">*</label>Address:</label>
												<div class="span7">
													<textarea class="span12" id="pick_address" name="data[CustomerBGP][pick_address]"></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid pick all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="pick_date"><label class="error" style="float: left; margin-right: 3px;">*</label>Date:</label>
												<div class="span7">
													<input class="span12" id="pick_date" name="data[CustomerBGP][pick_date]" value=""  type="text"/>
													
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid pick all" style="display: block;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="pick_time"><label class="error" style="float: left; margin-right: 3px;">*</label>Time:</label>
												<div class="span7">
													<select name="data[CustomerBGP][pick_time]" id="pick_time" class="span12">
															<option value="10-12">10 am - 12 pm</option>
															<option value="12-14">12 pm - 2 pm</option>
															<option value="14-16">2 pm - 4pm</option>
															<option value="16-18">4pm - 6pm</option>
															<option value="18-20">6pm - 8pm</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset class="identitydetails">
									<legend>Monthly Subscription Details</legend>	
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="monthly_sip_pdc" style="">Type :</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="monthly_sip_pdc1" name="data[CustomerBGP][monthly_sip_pdc]" type="radio"  data-check="monthly_sip_pdc" value="SIP" checked="checked" onchange="toggleFields('SIP','PDC');"/>ECS / NACH</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="monthly_sip_pdc1" name="data[CustomerBGP][monthly_sip_pdc]" type="radio"  data-check="monthly_sip_pdc" value="PDC" onchange="toggleFields('PDC','SIP');"/>PDC</label>												
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="monthly_sip_pdc1" name="data[CustomerBGP][monthly_sip_pdc]" type="radio"  data-check="monthly_sip_pdc" value="CASH" onchange="toggleFields('PDC','SIP');"/>CASH</label>												
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="monthly_sip_pdc1" name="data[CustomerBGP][monthly_sip_pdc]" type="radio"  data-check="monthly_sip_pdc" value="ONLINE" onchange="toggleFields('PDC','SIP');"/>ONLINE</label>												
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span12" for="monthly_sip_through_auto_debit" style=""><input class="span1" checked="checked" id="monthly_sip_through_auto_debit" name="data[CustomerBGP][monthly_sip_through_auto_debit]" type="checkbox" value="YES" disabled="disabled"/>SIP through <span class="SIP">Auto-Debit(ECS/DIRECT-DEBIT)</span><span class="PDC" style="display: none;">Post Dated Cheque</span></label>																							
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid SIP" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="bank_name">Bank Name & Bank Branch :</label>
												<div class="span7">
													<input class="span12" id="bank_name" name="data[CustomerBGP][bank_name]" type="text"/>
												</div>
											</div>
										</div>
									</div>		
									<div class="form-row row-fluid SIP" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="account_number">Account No :</label>
												<div class="span7">
													<input class="span12" id="account_number" name="data[CustomerBGP][account_number]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid SIP"  style="clear: both;">
										<div class="span12">
											<div class="row-fluid">												
												<label class="form-label span4" for="account_type" style="">Account Type :</label>
												<label style="float: left; margin-right: 20px;"><input class="AT" style="margin-top: -3px; margin-right: 5px;"  id="account_type1" name="data[CustomerBGP][account_type]"  data-check="account_type"  type="radio" value="Saving" checked="checked" />Saving</label>
												<label style="float: left; margin-right: 20px;"><input class="AT" style="margin-top: -3px; margin-right: 5px;"  id="account_type1" name="data[CustomerBGP][account_type]" data-check="account_type"   type="radio" value="Current"/>Current</label>
												<label style="float: left; margin-right: 20px;"><input class="AT" style="margin-top: -3px; margin-right: 5px;"  id="account_type1" name="data[CustomerBGP][account_type]" data-check="account_type"   type="radio" value="NRE" />NRE</label>
												<label style="float: left; margin-right: 20px;"><input class="AT" style="margin-top: -3px; margin-right: 5px;"  id="account_type1" name="data[CustomerBGP][account_type]" data-check="account_type"   type="radio" value="NRO" />NRO</label>
											</div>
										</div>
									</div>							
									<div class="form-row row-fluid " style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4 digits" for="amount">Amount(&nbsp;<span style="font-family:rupee;font-size:13px">Rs.</span>&nbsp;) :</label>
												<div class="span7">
													<input class="span12" id="amount" name="data[CustomerBGP][amount]" value="1000" type="text" readonly/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="tenure">Tenure :</label>
												<div class="span8">
													<!-- <input class="span3" id="tenure" name="data[CustomerBGP][tenure]" type="text" max="15" min="1" placeholder="Years"  /> -->
													<input class="span3" id="tenure" name="data[CustomerBGP][tenure]" type="text" value="11" readonly placeholder="11 months"  /> months
												</div>
												
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="initial_cheque_dd_no_date">Cheque/DD/Payorder Date :</label>
												<div class="span7">
													<input class="span12" id="initial_cheque_dd_no_date"  class="initial_cheque_dd_no_date" name="data[CustomerBGP][initial_cheque_dd_no_date]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="period_from">Period From :</label>
												<div class="span7">
													<input class="span12" id="period_from" name="data[CustomerBGP][period_from]" readonly="readonly" type="text" onblur="1calDates()"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="period_to">Period To :</label>
												<div class="span7">
													<input class="span12" id="period_to" name="data[CustomerBGP][period_to]" type="text" readonly="readonly"/>
												</div>
											</div>
										</div>
									</div>
									<!-- PDC Starts -->									
									
									<div class="form-row row-fluid PDC" style="display: none;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="cheque_number_from">Cheque No From :</label>
												<div class="span7">
													<input class="span12" id="cheque_number_from" name="data[CustomerBGP][cheque_number_from]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid PDC" style="display: none;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="cheque_number_to">Cheque No To :</label>
												<div class="span7">
													<input class="span12" id="cheque_number_to" name="data[CustomerBGP][cheque_number_to]" type="text"/>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<!--  ECS Form -->
								<fieldset class="identitydetails SIP" >
									<legend>ECS Details</legend>	
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_bank_account_number">Bank Account No :</label>
												<div class="span7">
													<input class="span12" id="ecs_bank_account_number" name="data[CustomerBGP][ecs_bank_account_number]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">												
												<label class="form-label span4" for="ecs_bank_account_type" style="">Account Type :</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="ecs_bank_account_type" name="data[CustomerBGP][ecs_bank_account_type]" data-check="ecs_bank_account_type"   type="radio" value="Saving" checked="checked" />Saving</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="ecs_bank_account_type" name="data[CustomerBGP][ecs_bank_account_type]" data-check="ecs_bank_account_type"   type="radio" value="Current"/>Current</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="ecs_bank_account_type" name="data[CustomerBGP][ecs_bank_account_type]" data-check="ecs_bank_account_type"   type="radio" value="NRE" />NRE</label>
												<label style="float: left; margin-right: 20px;"><input class="" style="margin-top: -3px; margin-right: 5px;"  id="ecs_bank_account_type" name="data[CustomerBGP][ecs_bank_account_type]" data-check="ecs_bank_account_type"   type="radio" value="NRO" />NRO</label>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid ">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_account_holder_name">Bank Account Holder's Name :</label>
												<div class="span7">
													<input class="span12" id="ecs_account_holder_name" name="data[CustomerBGP][ecs_account_holder_name]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_bank_name">Bank Name :</label>
												<div class="span7">
													<input class="span12" id="ecs_bank_name" name="data[CustomerBGP][ecs_bank_name]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" style="clear:both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_branch_address">Bank Branch Name/Address :</label>
												<div class="span7">
													<textarea class="span12" id="ecs_branch_address" name="data[CustomerBGP][ecs_branch_address]" ></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_city">Bank City/Town :</label>
												<div class="span7">
													<input class="span12" id="ecs_city" name="data[CustomerBGP][ecs_city]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_pincode">Pincode :</label>
												<div class="span7">
													<input class="span12" id="ecs_pincode" name="data[CustomerBGP][ecs_pincode]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_branch_micr">Bank Branch MICR Number (9 Digits) :</label>
												<div class="span7">
													<input class="span12" id="ecs_branch_micr" name="data[CustomerBGP][ecs_branch_micr]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_ifsc_code">IFSC Code :</label>
												<div class="span7">
													<input class="span12" id="ecs_ifsc_code" name="data[CustomerBGP][ecs_ifsc_code]" maxlength="11" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" style="clear:both;">
										<div class="span12">
											<div class="row-fluid">												
												<label class="form-label span4" for="ecs_debit_date" style="">Debit Date :</label>
												<label style="float: left; margin-right: 20px;"><input class="DebitDate" style="margin-top: -3px; margin-right: 5px;"  id="ecs_debit_date" name="data[CustomerBGP][ecs_debit_date]" data-check="ecs_debit_date" type="radio" value="10" checked="checked" />10</label>
												<label style="float: left; margin-right: 20px;"><input class="DebitDate" style="margin-top: -3px; margin-right: 5px;"  id="ecs_debit_date" name="data[CustomerBGP][ecs_debit_date]" data-check="ecs_debit_date" type="radio" value="20"/>20</label>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_amount_of_subscription">Amount of Subscription :</label>
												<div class="span7">
													<input class="span12" id="ecs_amount_of_subscription" name="data[CustomerBGP][ecs_amount_of_subscription]" type="text"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid " >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_from">From :</label>
												<div class="span7">
													<input class="span6 date1" id="ecs_from" name="data[CustomerBGP][ecs_from]" type="text" readonly="readonly"/>(MM-YYYY)
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid" >
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="ecs_to">To :</label>
												<div class="span7">
													<input class="span6 date1" id="ecs_to" name="data[CustomerBGP][ecs_to]" type="text" readonly="readonly"/>(MM-YYYY)
												</div>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="step-5" class="identitydetails" style="width: 97%; float: left; border-bottom: 1px solid rgb(196, 196, 196);">
							<div>
								<fieldset class="identitydetails">
									<legend>Declaration</legend>	
									<div class="row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="span12" for="bank_name">
													<small style="text-align: justify;"><p>I propose to enroll with Birla Gold Plus, Subject to Terms &amp; Conditions of the product brochures as amended from time to time. I have read and understood (before filling the application form) terms &amp; Conditions in the product brouchers, and I accept the same. I have neither recived nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Plus. I hereby declare that the subscriptions proposed to be remitted in Birla Gold Plus will be from legitimate sources only and will not be with any intention to contravene/evade/avoid any legal/statutory/regulatory requirements. I understand that Birla Gold & Precious Metals Ltd., may at its absolute direction, discontinue any or all of the services by giving prior notice to me. I hereby authorise the aforesaid nominee to receive all the gold accumulated to my account, in the event of my death.</p></small>
												</label>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="declaration_date"><label class="error" style="float: left; margin-right: 3px;">*</label>Date :</label>
												<div class="span7">
													<input class="span9" id="declaration_date" name="data[CustomerBGP][declaration_date]" type="text" maxlength="0" readOnly="readOnly" value="<?php echo date("d-m-y"); ?>" /><a style="cursor: pointer;" onclick="clearTB('declaration_date')">Clear</a>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="declaration_place"><label class="error" style="float: left; margin-right: 3px;">*</label>Place :</label>
												<div class="span7">
													<input class="span12" id="declaration_place" name="data[CustomerBGP][declaration_place]" type="text"/>
												</div>
											</div>
										</div>
									</div>								
								</fieldset>	
								<!-- 
								<fieldset class="identitydetails">
									<legend>Upload Documents</legend>	
									<div class="form-row row-fluid" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_doc_status">Documents :</label>
												<label style="float: left; margin-right: 20px;">
													<input class="" id="upload_doc_status1" style="margin-top: -3px; margin-right: 5px;"  name="data[CustomerBGP][upload_doc_status]" type="radio" data-check="upload_doc_status" onchange="toggleFields('docs','');" value="Upload Now" checked="checked"/>Upload Now
												</label>
												<label style="float: left; margin-right: 20px;">
													<input class="" id="upload_doc_status2" style="margin-top: -3px; margin-right: 5px;"  name="data[CustomerBGP][upload_doc_status]" type="radio" data-check="upload_doc_status"  onchange="toggleFields('','docs');" value="Later"/>Later
												</label>
												<label style="float: left; margin-right: 20px;">
													<input class="" id="upload_doc_status3" style="margin-top: -3px; margin-right: 5px;"  name="data[CustomerBGP][upload_doc_status]" type="radio" data-check="upload_doc_status"  onchange="toggleFields('','docs');" value="Send Via Courier"/>Send Via Courier
												</label>
												
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid docs" style="clear: both;">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_id">Identity Proof :</label>
												<div class="span6">
													<input class="span12" id="upload_id" name="data[CustomerBGP][upload_id]" type="file" onchange="checkFileExtension(this);"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_id">Identity Proof :</label>
												<div class="span6" id="upload_id_proof">
													Not Uploaded
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_address">Address Proof :</label>
												<div class="span6">
													<input class="span12" id="upload_address" name="data[CustomerBGP][upload_address]" type="file" onchange="checkFileExtension(this);"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="file_upload_address">Address Proof :</label>
												<div class="span6" id="upload_address_proof">
													Not Uploaded
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_bank">Bank Proof :</label>
												<div class="span6">
													<input class="span12" id="upload_bank" name="data[CustomerBGP][upload_bank]" type="file" onchange="checkFileExtension(this);"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="file_upload_bank">Bank Proof:</label>
												<div class="span6" id="upload_bank_proof">
													Not Uploaded
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="upload_photo">Photo (Passport Size) :</label>
												<div class="span6">
													<input class="span12" id="upload_photo" name="data[CustomerBGP][upload_photo]" type="file" onchange="checkFileExtension(this);"/>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="form-label span4" for="file_upload_photo">Photo (Passport Size) :</label>
												<div class="span6" id="upload_photo_proof">
													Not Uploaded
												</div>
											</div>
										</div>
									</div>
									<div class="form-row row-fluid docs">
										<div class="span12">
											<div class="row-fluid">
												<label class="FontSize-11 span12" style="float: left; line-height: 29px;">Allowed File Types :- .pdf, .tiff, .jpg</label>
											</div>
										</div>
									</div>											
								</fieldset>
								-->
							</div>
						</div>
					</div>
					<!-- End SmartWizard Content -->
				</form>
				<div class="clr">&nbsp;</div>	
				<div class="clr">&nbsp;</div>	
			</div>
		</div>
	</div>
	

		<!-- DD menu-->
		<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.extension.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL ?>js/additional-methods.js"></script>
	
		<!-- UI -->
		<script type="text/JavaScript" src="<?php echo BASE_URL ?>js/jquery-ui.js"></script>
		
		<link href="<?php echo BASE_URL ?>css/smart_wizard.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.smartWizard-2.0.min.js"></script>	
<script>
function otherChange(obj,other_id,comp_val)
{
	if($(obj).attr("checked") == "checked" && $(obj).val() == comp_val)
	{
		$("#"+other_id).show();
		$("#"+other_id+"_lbl").show();
	}
	else
	{
		$("#"+other_id).hide();	
		$("#"+other_id+"_lbl").hide();	
	}
}
function otherSelect(obj,other_id,comp_val)
{
	if($(obj).attr("selected") == "selectded" && $(obj).val() == comp_val)
	{
		$("#"+other_id).show();
		$("#"+other_id+"_lbl").show();
	}
	else
	{
		$("#"+other_id).hide();	
		$("#"+other_id+"_lbl").hide();	
	}
}
function toggleFields1(a)
{
//	alert(a+"==="+b+"==="+c);
	$(".all").hide();
	$("."+a).show();
}


function addEditAjax(step,finish)
{
	if(finish)
	{
		var laststep = true;
	}
	else
	{
		var laststep = false;
	}
	$("#wizzard-form11").ajaxSubmit({
 		url: '<?php echo BASE_URL ?>bgp-plan/registration',
 		data:{'laststep':laststep,'step':step.attr('rel')},		
 		type: 'post',
		cache: false,
		enctype:"multipart/form-data",
		clearForm: false,
 		success: function(response)
 		{
			// alert("hi.."+response.toSource());
 			var res = eval('('+response+')');
			if(res['msg'])
 			{
 				displayMsg("error",res['msg']);
 				return false;
 			}
 			step.find('.stepNumber').stop(true, true).remove();
			step.find('.stepDesc').stop(true, true).before('<span class="stepNumber"><span class="icon16 iconic-icon-checkmark"></span></span>');					

 			$("#wizzard-form11 input[type='hidden'],#wizzard-form11 input[type='text'],#wizzard-form11 select").each(function() {
 				if($(this).attr("readonly") && $(this).val() != ''){
 				}else{
 					$("#"+$(this).attr("id")).val(res[$(this).attr("id")]);
 				}
 			});
 			$("#wizzard-form11 textarea").each(function() {
     			$("#"+$(this).attr("id")).html(res[$(this).attr("id")]);
 			});
 			$("#wizzard-form11 input[type='file']").each(function() {
 	 			if(res[$(this).attr("id")+"_proof"] != "")
 	 			{
 	 	 			var fileName = res[$(this).attr("id")+"_proof"];
 	 	 			if(fileName != null)
 	 	 			{
	 	 	 			var divId = $(this).attr("id")+"_proof";
	 	 	 			var removeControl = "#"+$(this).attr("id")+"_proof_remove";
	     				$("#"+$(this).attr("id")+"_proof").html('<a target="_blank" href="<?php echo BASE_URL ?>images/customer/'+res[$(this).attr("id")+"_proof"]+'">File</a><a id="'+$(this).attr("id")+"_proof_remove"+'" class="minia-icon-file-remove btn" data-placement="right" onConfirm="removeFile();" data-toggle="confirmation" data-original-title="" title="Are you sure to remove this file?"></a>');
	     				$("#"+$(this).attr("id")+"_proof_remove").confirmation({
	         				onConfirm : function() {
	     						removeFile(fileName,divId,removeControl);
							}
	         			});
 	 	 			}
 	 			}
 			}); 			
			//console.log(res["applicant_title"]);
 			// For Radio Buttons
 			$("input[type=radio]").each(function(){
 	 			var name = $(this).attr("name");
				var data_check = $(this).attr("data-check");
 				$("input[name='"+name+"']").each(function(){
 					$(this).removeAttr("checked").parent().removeClass("checked");
 				});			
				$("[name='"+name+"'][value='"+res[data_check]+"']").attr("checked",true);
				if(res[data_check] == "Other")
				{
					var nameO = data_check+"_other";
					var namel = data_check+"_other_lbl";
					//console.log(nameO);
					$("#"+nameO).show();
					$("#"+namel).show();
				}
 				if(res[data_check] == "Cheque")
				{
					$(".online").hide();
				}
 			});
 			 
			if(finish)
			{		
				
				if(!$('#initial_pay_by1').is(':checked') && !$('#initial_pay_by2').is(':checked')  && !$('#initial_pay_by3').is(':checked')  && !$('#initial_pay_by4').is(':checked')  && !$('#initial_pay_by5').is(':checked')) 
				{
					window.location.href="<?php echo BASE_URL ?>pay?text="+res['encode_application_no'];				
				}else{
					window.location.href="<?php echo BASE_URL ?>customermaster/thankyou";
				}	
				
			}
       	},
       	error:function(response,obj)
       	{
			//console.log("response "+response+" - "+obj);
			window.location.href="<?php echo BASE_URL ?>bgp-plan/registration";
       	}
  	});	
}
function removeFile(fileName,divId,removeControl)
{
	$.ajax({
 		url: '<?php echo BASE_URL ?>customer/removeFile',
 		data:{'fileName':fileName,'column':divId}, 		
 		type: 'post',
		cache: false,
		clearForm: false,
 		success: function(response) 		
 		{
 			var res = eval('('+response+')');
 			if(res['msg']=="success")
 			{
 				displayMsg("success","File removed successfully");
 				$(removeControl).confirmation('destroy');
 	 			$("#"+divId).html("Not Uploaded");
 			}
 			else
 			{
 				displayMsg("error","Problem in file removing.");
 			} 			
 			
 		}
	});
}
$(document).ready(function () {
	$(".all").hide();
	$(".online").show();
	copyvalue('contact_email','contact_email_previous');
	copyvalue('contact_mobile','contact_mobile_previous');
	copyvalue('initial_amount','amount');
	
	calcAge();
	$.ajax({
 		url: '<?php echo BASE_URL ?>customermaster/getState',
 		data:'', 		
 		type: 'post',
		cache: false,
		clearForm: false,
 		success: function(response) 		
 		{
			var resp = response.split('::');
			
			if(response!='')
			{
				$('#ajax_mailing_state').html(resp[0]);
				$('#ajax_nomination_state').html(resp[1]);
			}
		}
	});
	
	/*Wizard with validation*/
	$('#wizard-validation').smartWizard({
		transitionEffect: 'slide', // Effect on navigation, none/fade/slide/
		onLeaveStep: leaveAStepCallbackValidation,
		onFinish: onFinishCallbackValidaton
	});

	function leaveAStepCallbackValidation(obj) {

		var step = obj;
		var stepN = step.attr('rel');
				
		if (stepN == 1) {
			if ($("#contact_email").valid() == true) {
				var validate1 = true;
			} else {
				var validate1 = false;
			}			
			if ($("#contact_mobile").valid() == true) {
				var validate2 = true;
			} else {
				var validate2 = false;
			}				
			if (validate1 == true && validate2 == true) {					
				addEditAjax(step);
				step.find('.stepNumber').stop(true, true).remove();
				step.find('.stepDesc').stop(true, true).before('<span class="stepNumber"><span class="icon16 iconic-icon-checkmark"></span></span>');							
				return true;					
			} else {
				return false;
			}
		}
		//validate step 2
		if (stepN == 2) {	

			if ($("#contact_pan_no").valid() == true) {
				var validate3 = true;
			} else {
				var validate3 = false;
			}
			if ($("#applicant_name").valid() == true) {
				var validate4 = true;
			} else {
				var validate4 = false;
			}
			
//			if($("#applicant_status4").attr("checked") == "checked")
//			{
//				if ($("#applicant_dob").valid() == true) {
//					var validate5 = true;
//				} else {
//					var validate5 = false;
//				}
//			}else{
//				var validate5 = true;
//			}
			
			if($("[name='data[CustomerBGP][applicant_dob_proof]'][value='Other']").attr("checked") == "checked")
			{			
				if ($("#applicant_dob_proof_other").valid() == true) {
					var validate6 = true;
				}else {
					var validate6 = false;
				}	
			}else{
				var validate6 = true;   				
			}	
			if ($("#mailing_address").valid() == true) {
				var validate7 = true;
			} else {
				var validate7 = false;
			}
			if ($("#mailing_landmark").valid() == true) {
				var validate8 = true;
			} else {
				var validate8 = false;
			}
			if ($("#mailing_city").valid() == true) {
				var validate9 = true;
			} else {
				var validate9 = false;
			}
			if ($("#mailing_state").valid() == true) {
				var validate10 = true;
			} else {
				var validate10 = false;
			}
			if ($("#mailing_country").valid() == true) {
				var validate11 = true;
			} else {
				var validate11 = false;
			}
			if ($("#mailing_pincode").valid() == true) {
				var validate12 = true;
			} else {
				var validate12 = false;
			}			
			// if($("[name='data[CustomerBGP][occupation]'][value='Other']").attr("checked") == "checked")
			// {			
				// if ($("#occupation_other").valid() == true) {
					// var validate13 = true;
				// }else {
					// var validate13 = false;
				// }	
			// }else{
				// var validate13 = true;   				
			// }	
			if($("[name='data[CustomerBGP][applicant_guardian_relationship]'][value='Other']").attr("checked") == "checked")
			{			
				if ($("#applicant_guardian_relationship_other").valid() == true) {
					var validate14 = true;
				}else {
					var validate14 = false;
				}	
			}else{
				var validate14 = true;   				
			}	
			if ($("#accept_terms").valid() == true) {
				var validate114 = true;
			}else {
				var validate114 = false;
			}	

			// if ($("#mailing_overseas_address").valid() == true) {
				// var validate_MOA = true;
			// } else {
				// var validate_MOA = false;
			// }

			if ($("#applicant_guardian_name").valid() == true) {
				var validate_AGD = true;
			} else {
				var validate_AGD = false;
			}

			if ($("#applicant_guardian_country_resident").valid() == true) {
				var validate_AGCR = true;
			} else {
				var validate_AGCR = false;
			}
			
			//var validateappAGE = validateAge($("#applicant_dob").val());	
			if ($("#applicant_dob").valid() == true) {
				var validate_ABOB_minor = true;
			} else {
				var validate_ABOB_minor = false;
			}

			if ($("#applicant_dob_proof").valid() == true) {
				var validate_DOB_proof = true;
			} else {
				var validate_DOB_proof = false;
			}
//			
			
			if (validate3 == true && validate4 == true && validate6 == true && validate7 == true && validate8 == true && validate9 == true && validate10 == true && validate11 == true && validate12 == true && validate14 == true && validate114 == true && validate_AGD == true && validate_AGCR == true && validate_ABOB_minor == true) {
				addEditAjax(step);
				return true;
			} else {
				//alert(validate3+"--"+validate4+"--"+validate5+"--"+validate6+"--"+validate7+"--"+validate8+"--"+validate9+"--"+validate10+"--"+validate11+"--"+validate12+"--"+validate13+"--"+validate14);
				return false;
			}
			
		}
		//validate step 3
		if (stepN == 3) {
			if ($("#nomination_name").valid() == true) {
				var validate15 = true;
			} else {
				var validate15 = false;
			}
			if ($("#nomination_address").valid() == true) {
				var validate16 = true;
			} else {
				var validate16 = false;
			}
			if ($("#nomination_city").valid() == true) {
				var validate17 = true;
			} else {
				var validate17 = false;
			}
			if ($("#nomination_state").valid() == true) {
				var validate18 = true;
			} else {
				var validate18 = false;
			}
			if ($("#nomination_pincode").valid() == true) {
				var validate19 = true;
			} else {
				var validate19 = false;
			}
			if ($("#nomination_applicant_realtion").valid() == true) {
				var validate20 = true;
			} else {
				var validate20 = false;
			}			
			if($("#nomination_guardian_name").val() != "")
			{
				$("#nomination_dob").rules("add", { required: true });
				if ($("#nomination_dob").valid() == true) {
					var validate21 = true;
				} else {
					var validate21 = false;
				}
			}
			else
			{
				$('#nomination_dob').rules("remove", "required");
				var validate21 = true;
			}

			var validateNonAGE = validateNonAge($("#nomination_dob").val());
			
			if (validate15 == true && validate16 == true && validate17 == true && validate18 == true && validate19 == true && validate20 == true && validate21 == true && validateNonAGE == true) {
				addEditAjax(step);
				return true;
			} else {
				return false;
			}
		}
		//validate step 4
		if (stepN == 4) {
			if(!$('#initial_pay_by1').is(':checked')) 
			{			
				if ($("#initial_amount").valid() == true) {
					if($("#initial_amount").val() % 1000 == 0)
					{
						var validate22 = true;
						$("#initial_amount").removeClass("error").addClass("error").next().hide();
					}
					else
					{
						$("#initial_amount").removeClass("valid").addClass("error").parent().append('<label class="error" for="initial_amount">Minimum amount should be 1000 & multiples of 1000 \'s.</label>').show();
						var validate22 = false;
					}
					
				}else {
					var validate22 = false;
				}	
			}else{
				var validate22 = true;   				
			}
			if($("[name='data[CustomerBGP][monthly_sip_pdc]'][value='SIP']").attr("checked") == "checked")
			{			
				if ($("#bank_name").valid() == true) {
					var validate23 = true;
				} else {
					var validate23 = false;
				}
				if ($("#account_number").valid() == true) {
					var validate24 = true;
				} else {
					var validate24 = false;
				}
			}else{
				if ($("#cheque_number_from").valid() == true) {
					var validate23 = true;
				} else {
					var validate23 = false;
				}		
				if ($("#cheque_number_to").valid() == true) {
					var validate24 = true;
				} else {
					var validate24 = false;
				}		
			}
				
			if ($("#amount").valid() == true) {
				var validate25 = true;
			} else {
				var validate25 = false;
			}	
			if ($("#tenure").valid() == true) {
				var validate26 = true;
			} else {
				var validate26 = false;
			}	
			/*if ($("#initial_cheque_dd_no_date").valid() == true) {
				var validate27 = true;
			} else {
				var validate27 = false;
			}*/
			var validate27 = true;	
			if ($("#period_from").valid() == true) {
				var validate28 = true;
			} else {
				var validate28 = false;
			}	
			if ($("#period_to").valid() == true) {
				var validate29 = true;
			} else {
				var validate29 = false;
			}

			// ECS
			
			if($("[name='data[CustomerBGP][monthly_sip_pdc]'][value='SIP']").attr("checked") == "checked")
			{
				if ($("#ecs_bank_account_number").valid() == true) {
					var validate30 = true;
				} else {
					var validate30 = false;
				}
				if ($("#ecs_account_holder_name").valid() == true) {
					var validate31 = true;
				} else {
					var validate31 = false;
				}
				if ($("#ecs_bank_name").valid() == true) {
					var validate32 = true;
				} else {
					var validate32 = false;
				}
				if ($("#ecs_branch_address").valid() == true) {
					var validate33 = true;
				} else {
					var validate33 = false;
				}
				if ($("#ecs_city").valid() == true) {
					var validate34 = true;
				} else {
					var validate34 = false;
				}
				if ($("#ecs_pincode").valid() == true) {
					var validate35 = true;
				} else {
					var validate35 = false;
				}
				if ($("#ecs_branch_micr").valid() == true) {
					var validate36 = true;
				} else {
					var validate36 = false;
				}
				if ($("#ecs_ifsc_code").valid() == true) {
					var validate37 = true;
				} else {
					var validate37 = false;
				}
				if ($("#ecs_amount_of_subscription").valid() == true) {
					var validate38 = true;
				} else {
					var validate38 = false;
				}
				if ($("#ecs_from").valid() == true) {
					var validate39 = true;
				} else {
					var validate39 = false;
				}
				if ($("#ecs_to").valid() == true) {
					var validate40 = true;
				} else {
					var validate40 = false;
				}
				
				if (validate22 == true && validate23 == true && validate24 == true && validate25 == true && validate26 == true && validate27 == true && validate28 == true && validate29 == true && validate30 == true && validate31 == true && validate32 == true && validate33 == true && validate34 == true && validate35 == true && validate36 == true && validate37 == true && validate38 == true && validate39 == true && validate40 == true) {
					addEditAjax(step);
					return true;
				} else {
					return false;
				}
			}else{
				if (validate22 == true && validate23 == true && validate24 == true && validate25 == true && validate26 == true && validate27 == true && validate28 == true && validate29 == true) {
					addEditAjax(step);
					return true;
				} else {
					return false;
				}
			}
			
			
		}
		//validate step 5
		if (stepN == 5) {
			if ($("#declaration_date").valid() == true) {
				var validate41 = true;
			} else {
				var validate41= false;
			}
			if ($("#declaration_place").valid() == true) {
				var validate42 = true;
			} else {
				var validate42 = false;
			}			
			if (validate41 == true && validate42 == true) {
				//addEditAjax(step);
				return true;
			} else {
				return false;
			}
		}
	}

	function onFinishCallbackValidaton(obj) {
		var step = obj;
		if ($("#declaration_date").valid() == true) {
			var validate41 = true;
		} else {
			var validate41= false;
		}
		if ($("#declaration_place").valid() == true) {
			var validate42 = true;
		} else {
			var validate42 = false;
		}				
		if (validate41 == true && validate42 == true) {
			addEditAjax(step,true);
			step.find('.stepNumber').stop(true, true).remove();
			step.find('.stepDesc').stop(true, true).before('<span class="stepNumber"><span class="icon16 iconic-icon-checkmark"></span></span>');			
			return true;
		} else {
			return false;
		}
	}
	
	$("#declaration_date").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true,
	}).datepicker("setDate", "0");
	
	$("#pick_date").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true,
	}).datepicker("setDate", "0");
	
	$("#first_cheque_date").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true
	}).datepicker("setDate", "0");
	
	$("#nomination_dob").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true
	});
	
	$("#applicant_dob").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true
	}).datepicker("setDate", "0");

	$("#initial_cheque_dd_no_date").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true
	}).datepicker("setDate", "0");
	
//	$(".date1").datepicker({ 
//		dateFormat: "mm-yy",
//		changeYear: true,
//		changeMonth:true,
//		minDate: '0'
//	});
});
$("#wizzard-form11").validate({
	rules: {

		// mailing_overseas_address:{
		   // required:{
			   // depends: function(element){
					// if( $("#applicant_status2:checked").val() == 'NRI'){
			   			// return true;
		   		 // }
			  // }
		   // }
		// },

		"data[CustomerBGP][applicant_guardian_name]":{
		   required:{
			   depends: function(element){
			   		
					if( $("#applicant_status4:checked").val() == 'On behalf of Minor'){
			   			return true;
		   		 	}
					
					if($('#applicant_dob').val() != ''){
						//alert($('#applicant_dob').val());
						
						var bdate = $('#applicant_dob').val();
						var res = bdate.split('-'); 
						
						if(res.length == 3){
							
							var day = res[0];
							var month = res[1];
							var year = res[2];
							
							var age = 18;
							var mydate = new Date();
							mydate.setFullYear(year, month-1, day);
							
							var currdate = new Date();
							currdate.setFullYear(currdate.getFullYear() - age);

							//alert(currdate);
							//alert(mydate);
							
							if ((currdate - mydate) < 0){
								if($('#applicant_guardian_name').val() == '' || $('#applicant_guardian_country_resident').val() == ''){
									//$('#ageValidn').show();
									//return false;
									return true;
								}else{
									//$('#ageValidn').hide();
									//return true;
								}
							}else{
								//$('#ageValidn').hide();
								//return true;
							}
						}else{
							alert("Enter date in correct format (dd-mm-yyyy)");
							return false;
						}
					}else if($('#applicant_status').val() == 'On behalf of Minor'){
						if($('#applicant_guardian_name').val() == '' || $('#applicant_guardian_country_resident').val() == ''){
							//$('#ageValidn').show();
							//return false;
							return true;
						}else{
							//$('#ageValidn').hide();
							//return true;
						}
					}else{
						//$('#ageValidn').hide();
						//return true;
					}
			  }
		   }
		},

		"data[CustomerBGP][applicant_guardian_country_resident]":{
			   required:{
			   		depends: function(element){
						if($("#applicant_status4:checked").val() == 'On behalf of Minor'){
				   			return true;
		   		 		}

						if($('#applicant_dob').val() != ''){
							//alert($('#applicant_dob').val());
							
							var bdate = $('#applicant_dob').val();
							var res = bdate.split('-'); 
							
							if(res.length == 3){
								
								var day = res[0];
								var month = res[1];
								var year = res[2];
								
								var age = 18;
								var mydate = new Date();
								mydate.setFullYear(year, month-1, day);
								
								var currdate = new Date();
								currdate.setFullYear(currdate.getFullYear() - age);

								//alert(currdate);
								//alert(mydate);
								
								if ((currdate - mydate) < 0){
									if($('#applicant_guardian_name').val() == '' || $('#applicant_guardian_country_resident').val() == ''){
										//$('#ageValidn').show();
										//return false;
										return true;
									}else{
										//$('#ageValidn').hide();
										//return true;
									}
								}else{
									//$('#ageValidn').hide();
									//return true;
								}
							}else{
								alert("Enter date in correct format (dd-mm-yyyy)");
								return false;
							}
						}else if($('#applicant_status').val() == 'On behalf of Minor'){
							if($('#applicant_guardian_name').val() == '' || $('#applicant_guardian_country_resident').val() == ''){
								//$('#ageValidn').show();
								//return false;
								return true;
							}else{
								//$('#ageValidn').hide();
								//return true;
							}
						}else{
							//$('#ageValidn').hide();
							//return true;
						}
			  		}
	   			}
			},
		
		//Step 1
		"data[CustomerBGP][contact_email]": {email: true, required: true},
		"data[CustomerBGP][contact_mobile]": {required: true,minlength: 10,digits:true,maxlength:10},
		//Step 2
		
		//applicant_dob: {required: true},
		"data[CustomerBGP][applicant_dob]":{
		   required:{
			   depends: function(element){
					if( $("#applicant_status4:checked").val() == 'On behalf of Minor'){
			   			return true;
		   		 }
			  }
		   }
		},

		//applicant_dob_proof: {required: true},
		"data[CustomerBGP][applicant_dob_proof]":{
			   required:{
				   depends: function(element){
						if( $("#applicant_dob").val() != ''){
							
				   			return true;
			   		 }
				  }
			   }
			},
		
		"data[CustomerBGP][partner_code]": {required: true},
		"data[CustomerBGP][applicant_name]": {required: true},
		"data[CustomerBGP][identity_communication_address]":{required: true},
		"data[CustomerBGP][mailing_address]":{required: true},
		"data[CustomerBGP][mailing_landmark]":{required: true},
		"data[CustomerBGP][mailing_city]":{required: true},
		"data[CustomerBGP][mailing_state]":{required: true},
		"data[CustomerBGP][mailing_country]":{required: true},
		"data[CustomerBGP][mailing_pincode]":{required: true,digits:true,maxlength:6,minlength:6},
		"data[CustomerBGP][contact_pan_no]":{pancard:true},
		// occupation_other:{required: true},
		"data[CustomerBGP][applicant_dob_proof_other]":{required: true},
		"data[CustomerBGP][applicant_guardian_relationship_other]":{required: true},
		accept_terms:{required: true},
		
		//Step 3
		"data[CustomerBGP][nomination_name]": {required: true},
		"data[CustomerBGP][nomination_address]":{required: true},
		"data[CustomerBGP][nomination_city]": {required: true},
		"data[CustomerBGP][nomination_state]": {required: true},
		"data[CustomerBGP][nomination_pincode]": {required: true,digits:true,maxlength:6,minlength:6},
		"data[CustomerBGP][nomination_dob]": {required: true},
		"data[CustomerBGP][nomination_applicant_realtion]": {required: true},
		
		//Step 4
		"data[CustomerBGP][initial_amount]":{required: true,digits:true},
		"data[CustomerBGP][tenure]": {required: true,digits:true},
		"data[CustomerBGP][ecs_ifsc_code]": {minlength:11,alphanumeric:true, IFSC: true},
		"data[CustomerBGP][ecs_branch_micr]": {required: true,digits:true,maxlength:9,minlength:9},
		"data[CustomerBGP][ecs_ifsc_code]": {required: true,alphanumeric:true,maxlength:11,minlength:11},
		/*bank_name: {required: true},
		account_number: {required: true},
		amount: {required: true,digits:true},
		tenure: {required: true,digits:true},
		initial_cheque_dd_no_date: {required: true},
		period_from: {required: true},
		period_to: {required: true},*/
		/*cheque_number_from: {required: true,digits:true},
		cheque_number_to: {required: true,digits:true},*/
		/*ecs_bank_account_number: {required: true},
		ecs_account_holder_name: {required: true},
		ecs_bank_name: {required: true},
		ecs_branch_address: {required: true},
		ecs_city: {required: true},
		ecs_pincode: {required: true,digits:true,maxlength:6,minlength:6},
		
		ecs_amount_of_subscription: {required: true,digits:true},
		ecs_from: {required: true},
		ecs_to: {required: true},*/
		"data[CustomerBGP][pick_name]": {required: true},
		"data[CustomerBGP][pick_address]": {required: true},
		"data[CustomerBGP][pick_date]": {required: true},
		"data[CustomerBGP][first_cheque_date]": {required: true},
		"data[CustomerBGP][first_cheque_no]":{required: true,digits:true},
		"data[CustomerBGP][first_cheque_bank]":{required: true},
		
		//step 5
		"data[CustomerBGP][declaration_date]":{required: true},
		"data[CustomerBGP][declaration_place]":{required: true}
		
	},
	messages: {

		// mailing_overseas_address: {required: "Please enter overseas address "},
		//Step 1
		"data[CustomerBGP][contact_email]": {required: "Please enter email id"},
		"data[CustomerBGP][contact_mobile]": {required: "Please enter mobile no"},
		//Step 2
		
		"data[CustomerBGP][applicant_dob_proof]": {required: "Please select DOB proof"},
		"data[CustomerBGP][applicant_guardian_name]": {required: "Please enter guardian name"},
		"data[CustomerBGP][applicant_guardian_country_resident]": {required: "Please enter country of residence"},
		
		"data[CustomerBGP][partner_code]": {required: "Please enter partner code"},
		"data[CustomerBGP][applicant_name]": {required: "Please enter applicant name"},
		"data[CustomerBGP][applicant_dob]": {required: "Please enter applicant date of birth"},
		"data[CustomerBGP][applicant_guardian_country_resident]": {required: "Please enter country resident"},    		    		
		"data[CustomerBGP][identity_communication_address]":{required: "Please enter address"},
		"data[CustomerBGP][mailing_address]":{required: "Please enter address"},
		"data[CustomerBGP][mailing_landmark]":{required: "Please enter landmark"},
		"data[CustomerBGP][mailing_city]":{required: "Please enter city"},
		"data[CustomerBGP][mailing_state]":{required: "Please enter state"},
		"data[CustomerBGP][mailing_country]":{required: "Please enter country"},
		"data[CustomerBGP][mailing_pincode]":{required: "Please enter pincode"},
		"data[CustomerBGP][contact_pan_no]":{required: "Please enter pancard no"},
		// occupation_other:{required: "Please enter occupation"},
		"data[CustomerBGP][applicant_dob_proof_other]":{required: "Please enter dob proof"},
		"data[CustomerBGP][applicant_guardian_relationship_other]":{required: "Please enter relationship"},
		accept_terms:{required: "Please accept terms and conditions"},
		
		//Step 3
		"data[CustomerBGP][nomination_name]": {required: "Please enter nominee name"},
		"data[CustomerBGP][nomination_address]": {required: "Please enter address"},
		"data[CustomerBGP][nomination_city]": {required: "Please enter city"},
		"data[CustomerBGP][nomination_state]": {required: "Please enter state"},
		"data[CustomerBGP][nomination_pincode]": {required: "Please enter pincode"},
		"data[CustomerBGP][nomination_dob]": {required: "Please enter date of birth"},
		"data[CustomerBGP][nomination_applicant_realtion]": {required: "Please enter relationship"},
		
		//Step 4
		"data[CustomerBGP][initial_amount]":{required: "Please enter amount"},
		"data[CustomerBGP][bank_name]": {required: "Please enter bank name"},
		"data[CustomerBGP][account_number]": {required: "Please enter account number"},
		"data[CustomerBGP][amount]": {required: "Please enter amount"},
		"data[CustomerBGP][tenure]": {required: "Please enter tenure"},
		"data[CustomerBGP][initial_cheque_dd_no_date]": {required: "Please enter Cheque/DD/Payorder no"},
		"data[CustomerBGP][period_from]": {required: "Please enter period from"},
		"data[CustomerBGP][period_to]": {required: "Please enter period to"},
		"data[CustomerBGP][cheque_number_from]": {required: "Please enter cheque from"},
		"data[CustomerBGP][cheque_number_to]": {required: "Please enter cheque to"},
		"data[CustomerBGP][ecs_bank_account_number]": {required: "Please enter account no"},
		"data[CustomerBGP][ecs_account_holder_name]": {required: "Please enter account holder name"},
		"data[CustomerBGP][ecs_bank_name]": {required: "Please enter bank name"},
		"data[CustomerBGP][ecs_branch_address]": {required: "Please enter address"},
		"data[CustomerBGP][ecs_city]": {required: "Please enter city"},
		"data[CustomerBGP][ecs_pincode]": {required: "Please enter pincode"},
		"data[CustomerBGP][ecs_branch_micr]": {required: "Please enter micr code"},
		//ecs_ifsc_code: {required: "Please enter ifsc code"},
		"data[CustomerBGP][ecs_amount_of_subscription]": {required: "Please enter amount"},
		"data[CustomerBGP][ecs_from]": {required: "Please enter from date"},
		"data[CustomerBGP][ecs_to]": {required: "Please enter to date"},
		"data[CustomerBGP][pick_name]":{required: "Please enter name"},
		"data[CustomerBGP][pick_address]":{required: "Please enter address"},
		"data[CustomerBGP][pick_date]":{required: "Please enter date"},
		"data[CustomerBGP][first_cheque_date]":{required: "Please enter date"},
		"data[CustomerBGP][first_cheque_no]":{required: "Please enter cheque number"},
		"data[CustomerBGP][first_cheque_bank]":{required: "Please enter bank name"},
		
		//step 5
		"data[CustomerBGP][declaration_date]":{required: "Please enter date"},
		"data[CustomerBGP][declaration_place]":{required: "Please enter place"}
	}	
});

function copyvalue(a,b)
{
	$("#"+b).val($("#"+a).val());
}
function toggleFields(a,b)
{
	//alert(a+"==="+b);
	if(a != "")
	{
		$("."+a).show();
	}
	if(b != "")
	{
		$("."+b).hide();
	}
}
function checkFileExtension(obj)
{
	var ext = $(obj).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['jpg','tiff','pdf']) == -1) {
	    $(obj).val("");
	    displayMsg("error","Invalid file selected. Please upload file having this extentions jpg, tiff or pdf.");	    
	}
}
function calculateAge(birthday)
{
	splitdate = birthday.split("-"); 
	
	birthDay = splitdate[0];
	birthMonth = splitdate[1];
	birthYear = splitdate[2];

	todayDate = new Date();
  	todayYear = todayDate.getFullYear();
  	todayMonth = todayDate.getMonth();
  	todayDay = todayDate.getDate();
  	age = todayYear - birthYear;
	
  	if (todayMonth < birthMonth - 1)
  	{
    	age--;
  	}

  	if (birthMonth - 1 == todayMonth && todayDay < birthDay)
  	{
    	age--;
 	}
  	return age;
}

function validateNonAge(bdate){
	if(bdate != ''){
		var res = bdate.split('-'); 
		if(res.length == 3){
		
			var day = res[0];
			var month = res[1];
			var year = res[2];
		
			var age = 18;
			var mydate = new Date();
			mydate.setFullYear(year, month-1, day);
		
			var currdate = new Date();
			currdate.setFullYear(currdate.getFullYear() - age);
			if ((currdate - mydate) < 0){
				if($('#nomination_guardian_name').val() == '' || $('#nomination_guardian_realtion').val() == ''){
					$('#ageNonValidn').show();
					return false;
				}else{
					$('#ageNonValidn').hide();
					return true;
				}
			}else{
				$('#ageNonValidn').hide();
				return true;
			}
		}else{
			alert("Enter date in correct format (dd-mm-yyyy)");
			return false;
		}
	}else{
		$('#ageNonValidn').hide();
		return true;
	}
}

$( "#account_number" ).keyup(function() {
	$( "#ecs_bank_account_number" ).val($( "#account_number" ).val());
});

$( "#bank_name" ).keyup(function() {
	$( "#ecs_bank_name" ).val($( "#bank_name" ).val());
});

$( ".AT" ).change(function(){
	$("input[name='data[CustomerBGP][ecs_bank_account_type]'][value="+$('.AT:checked').val()+"]").prop("checked",true);
});

$( "#tenure" ).keyup(function() {
	calcAge();
});

$( ".DebitDate" ).change(function(){
	calcAge();
});

$( "#amount" ).keyup(function(){
	$( "#ecs_amount_of_subscription" ).val($( "#amount" ).val());
});

function clearTB(id){
	$("#"+id+"").val('');
}

function calcAge(){

	var curr_date = new Date();
	var day = curr_date.getDate();
	var tenure = $("#ecs_debit_date:checked").val();
	var tenure_Year = $("#tenure").val();
	var currDate = new Date();
	var myDate = new Date();

	//alert(myDate.getDate()+" "+myDate.getMonth()+" "+myDate.getFullYear());
	if(tenure_Year > 0 && tenure_Year != ''){
	
			 
			$("#period_from").val((currDate.getMonth()+1)+'-'+currDate.getFullYear());
			$("#ecs_from").val((currDate.getMonth()+1)+'-'+currDate.getFullYear());
			
			if(parseInt(currDate.getMonth())+1+parseInt(tenure_Year) > 12)
			{
				$("#period_to").val((parseInt(currDate.getMonth())+parseInt(tenure_Year)-12)+'-'+(parseInt(currDate.getFullYear())+1));
				$("#ecs_to").val((parseInt(currDate.getMonth())+parseInt(tenure_Year)-12)+'-'+(parseInt(currDate.getFullYear())+1));
			}
			else
			{
				$("#period_to").val(((currDate.getMonth())+tenure_Year)+'-'+currDate.getFullYear());
				$("#ecs_to").val(((currDate.getMonth())+tenure_Year)+'-'+currDate.getFullYear());
			}
		
		 /*if(tenure < day){
			 currDate.setMonth(parseInt(currDate.getMonth()) + 1);
			$("#period_from").val((currDate.getMonth()+2)+'-'+currDate.getFullYear());
			 $("#ecs_from").val((currDate.getMonth()+2)+'-'+currDate.getFullYear());
			
			 myDate.setFullYear(myDate.getFullYear() + parseInt(tenure_Year));
			 $("#period_to").val((myDate.getMonth()+1)+'-'+myDate.getFullYear());
			 $("#ecs_to").val((myDate.getMonth()+1)+'-'+myDate.getFullYear());
			
		 }else{
			currDate.setMonth(parseInt(currDate.getMonth()) + 1);
			 $("#period_from").val((currDate.getMonth()+2)+'-'+currDate.getFullYear());
			 $("#ecs_from").val((currDate.getMonth()+2)+'-'+currDate.getFullYear());
			
			 myDate.setFullYear(myDate.getFullYear() + parseInt(tenure_Year));
			 $("#period_to").val((myDate.getMonth())+'-'+myDate.getFullYear());
			 $("#ecs_to").val((myDate.getMonth())+'-'+myDate.getFullYear());
		 }*/
		
		/*$("#period_from").val('04-2016');
		$("#ecs_from").val('04-2016');
		
		$("#period_to").val('03-2017');
		$("#ecs_to").val('03-2017');*/
		
	}else{
		$("#period_from").val('');
		$("#ecs_from").val('');
		
		$("#period_to").val('');
		$("#ecs_to").val('');
	}
}



</script></div>
