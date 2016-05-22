
<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
<div id="container">
<div class="clr"></div>
	<div class="wrapper">		
		<div class="MidSection">
			<h4>Add Referral</h4>
			<div class="clr"></div>
			<?php echo $this->Session->flash('form1') ?>
			 <div class="row">               
			 <div id="content" class="col-sm-12">  
			 
			  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" name="addreferral" id="addreferral">
				<div class="form-group required custom-field" data-sort="0">
				<label class="col-sm-2 control-label">Title</label>
				<div class="col-sm-10 boss-input">
					<div class="radio">
									<label>
					<input type="radio" name="data[Referral][referral_title]" id="referral_title1" value="Mr" checked="checked" />
					Mr.</label>
								  
									<label>
					<input type="radio" name="data[Referral][referral_title]" id="referral_title2" value="Ms" />
					Ms.</label>
								 
									<label>
					<input type="radio" name="data[Referral][referral_title]" id="referral_title3" value="Mrs" />
					Mrs.</label>
					</div>
				</div>
			
				</div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="referral_name">Referral Name </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][referral_name]" value="" id="referral_name" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="referral_gender">Referral Gender </label>
				<div class="col-sm-10 boss-input">
					<div class="radio">
									<label>
					<input type="radio" name="data[Referral][referral_gender]" id="referral_gender1" value="Male" checked="checked" />
					Male</label>
								  
									<label>
					<input type="radio" name="data[Referral][referral_gender]" id="referral_gender2" value="Female" />
					Female</label>
								 
					</div>
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="referral_dob">Referral DOB </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][referral_dob]" value="" id="referral_dob" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_address">Address </label>
				<div class="col-sm-10 boss-input">
				  <textarea name="data[Referral][mailing_address]" id="mailing_address" class="form-control"></textarea>
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_landmark">Landmark </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][mailing_landmark]" value="" id="mailing_landmark" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_city">City </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][mailing_city]" value="" id="mailing_city" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_state">State </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][mailing_state]" value="" id="mailing_state" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_pincode">Pincode </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][mailing_pincode]" value="" id="mailing_pincode" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="mailing_country">Country </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][mailing_country]" value="India" readonly="readonly" id="mailing_country" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="contact_mobile">Mobile </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][contact_mobile]" value="" id="contact_mobile" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="contact_phone">Phone </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][contact_phone]" value="" id="contact_phone" class="form-control" />
				</div>
			    </div>
				
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="contact_email">Email </label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="data[Referral][contact_email]" value="" id="contact_email" class="form-control" />
				</div>
			    </div>
				
				<div class="buttons clearfix">
				  <div class="pull-left">
				  <?php echo $this->Html->link('Back',array('controller'=>'customermaster','action'=>'listreferral'),array('class'=>'button'));?>
				  </div>
				  <div class="pull-right">
					<input type="submit" value="Submit" class="btn btn-primary" />
				  </div>
				</div>
			</from>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.extension.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>js/additional-methods.js"></script>
<!-- UI -->
<script type="text/JavaScript" src="<?php echo BASE_URL ?>js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$("#referral_dob").datepicker({ 
		dateFormat: "dd-mm-yy",
		changeYear: true,
		changeMonth:true
	}).datepicker("setDate", "0");
});

$("#addreferral").validate({
	rules: {
		//Step 1
		"data[Referral][referral_dob]": {required: true},
		"data[Referral][referral_name]": {required: true},
		"data[Referral][contact_email]": {email: true, required: true},
		"data[Referral][contact_mobile]": {required: true,minlength: 10,digits:true,maxlength:10},
		"data[Referral][contact_phone]": {required: true,minlength: 11,digits:true,maxlength:11},
		"data[Referral][mailing_address]":{required: true},
		"data[Referral][mailing_landmark]":{required: true},
		"data[Referral][mailing_city]":{required: true},
		"data[Referral][mailing_state]":{required: true},
		"data[Referral][mailing_country]":{required: true},
		"data[Referral][mailing_pincode]":{required: true,digits:true,maxlength:6,minlength:6}
		
	},
	messages: {
		"data[Referral][contact_email]": {required: "Please enter email id"},
		"data[Referral][referral_dob]": {required: "Please enter referral dob"},
		"data[Referral][referral_name]": {required: "Please enter referral name"},
		"data[Referral][contact_mobile]": {required: "Please enter mobile no"},
		"data[Referral][contact_phone]": {required: "Please enter phone no"},
		"data[Referral][mailing_address]":{required: "Please enter address"},
		"data[Referral][mailing_landmark]":{required: "Please enter landmark"},
		"data[Referral][mailing_city]":{required: "Please enter city"},
		"data[Referral][mailing_state]":{required: "Please enter state"},
		"data[Referral][mailing_country]":{required: "Please enter country"},
		"data[Referral][mailing_pincode]":{required: "Please enter pincode"}
	}	
});


</script>