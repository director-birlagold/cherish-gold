<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Customer Master'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Customer" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Partner/Distributor Details</legend>
        <dl class="inline">
         <dt><label for="name">Partner Code</label></dt>
          <dd><input type="text" name="data[CustomerBGP][partner_code]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['partner_code']; ?>"/></dd>
          <dt><label for="name">Sub Partner Code</label></dt>
          <dd><input type="text" name="data[CustomerBGP][sub_partner_code]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['sub_partner_code']; ?>"/>
          </dd>
        </dl>
      </fieldset>
	  <fieldset>
        <legend>Fulfilment Details</legend>
        <dl class="inline">
         <dt><label for="name">Preferrence</label></dt>
          <dd><input type="text" name="data[CustomerBGP][fulfilment]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['fulfilment']; ?>"/></dd>
          
        </dl>
      </fieldset>
	  <fieldset>
        <legend>Applicant Details</legend>
        <dl class="inline">
         <dt><label for="name">Applicant Title</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_title]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_title']; ?>"/></dd>
          <dt><label for="name">Applicant Name</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_name']; ?>"/></dd>
		  <dt><label for="name">Gender</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_gender]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_gender']; ?>"/></dd>
			<dt><label for="name">Applicant Status</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_status]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_status']; ?>"/></dd>
		  <dt><label for="name">Date of Birth</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_dob]" id=""  class="validate[required]" size="50" value="<?php if($customer['CustomerBGP']['applicant_dob'] != "0000-00-00") {  echo $customer['CustomerBGP']['applicant_dob']; } ?>"/></dd>
		  <dt><label for="name">DOB Proof</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_dob_proof]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_dob_proof']; ?>"/></dd>
		  <?php if($customer['CustomerBGP'][applicant_dob_proof] == "Other") { ?>
			<dt><label for="name"></label></dt>
			<dd><input type="text" name="data[CustomerBGP][applicant_dob_proof_other]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_dob_proof_other']; ?>"/></dd>
			<?php } ?>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Guardian Details(in case application is minor)</legend>
        <dl class="inline">
         <dt><label for="name">Title</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_guardian_title]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_guardian_title']; ?>"/></dd>
          <dt><label for="name">Guardian Name</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_guardian_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_guardian_name']; ?>"/></dd>
		  <dt><label for="name">Country of Residence</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_guardian_country_resident]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_guardian_country_resident']; ?>"/></dd>
			<dt><label for="name">Guardian Relationship</label></dt>
          <dd><input type="text" name="data[CustomerBGP][applicant_guardian_relationship]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_guardian_relationship']; ?>"/></dd>
			<?php if($customer['CustomerBGP'][applicant_guardian_relationship] == "Other") { ?>
			<dt><label for="name"></label></dt>
			<dd><input type="text" name="data[CustomerBGP][applicant_guardian_relationship_other]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['applicant_guardian_relationship_other']; ?>"/></dd>
			<?php } ?>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Mailing Details</legend>
        <dl class="inline">
         <dt><label for="name">Address</label></dt>
          <dd><textarea name="data[CustomerBGP][mailing_address]"  class="validate[required]" rows="5" style="width:40%"><?php echo  $customer['CustomerBGP'][mailing_address]; ?></textarea></dd>
          <dt><label for="name">Landmark</label></dt>
          <dd><input type="text" name="data[CustomerBGP][mailing_landmark]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_landmark']; ?>"/></dd>
		  <dt><label for="name">City</label></dt>
          <dd><input type="text" name="data[CustomerBGP][mailing_city]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_city']; ?>"/></dd>
			<dt><label for="name">State</label></dt>
          <dd><input type="text" name="data[CustomerBGP][mailing_state]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_state']; ?>"/></dd>
			<dt><label for="name">Country</label></dt>
			<dd><input type="text" name="data[CustomerBGP][mailing_country]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_country']; ?>"/></dd>
			<dt><label for="name">Pincode</label></dt>
			<dd><input type="text" name="data[CustomerBGP][mailing_pincode]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_pincode']; ?>"/></dd>
			<dt><label for="name">Overseas Address (in case NRI)</label></dt>
			<dd><input type="text" name="data[CustomerBGP][mailing_overseas_address]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['mailing_overseas_address']; ?>"/></dd>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Contact Details</legend>
        <dl class="inline">
         <dt><label for="name">Phone Residence</label></dt>
          <dd><input type="text" name="data[CustomerBGP][contact_phone_residence]"  class="validate[required]" size="50" value="<?php echo  $customer['CustomerBGP'][contact_phone_residence]; ?>" /></dd>
          <dt><label for="name">Phone Office</label></dt>
          <dd><input type="text" name="data[CustomerBGP][contact_phone_office]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['contact_phone_office']; ?>"/></dd>
		  <dt><label for="name">Email</label></dt>
          <dd><input type="text" name="data[CustomerBGP][contact_email]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['contact_email']; ?>"/></dd>
			<dt><label for="name">Mobile</label></dt>
          <dd><input type="text" name="data[CustomerBGP][contact_mobile]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['contact_mobile']; ?>"/></dd>
			<dt><label for="name">Occupation</label></dt>
			<dd><input type="text" name="data[CustomerBGP][occupation]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['occupation']; ?>"/></dd>
			<?php if($customer['CustomerBGP'][occupation] == "Other") { ?>
			<dt><label for="name"></label></dt>
			<dd><input type="text" name="data[CustomerBGP][occupation_other]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['occupation_other']; ?>"/></dd>
			<?php } ?>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Nomination Details</legend>
        <dl class="inline">
         <dt><label for="name">Name</label></dt>
          <dd><input type="text" name="data[CustomerBGP][nomination_name]"  class="validate[required]" size="50" value="<?php echo  $customer['CustomerBGP'][nomination_name]; ?>" /></dd>
          <dt><label for="name">Guardian (if nominee is minor)</label></dt>
          <dd><input type="text" name="data[CustomerBGP][nomination_guardian_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_guardian_name']; ?>"/></dd>
		  <dt><label for="name">Address</label></dt>
           <dd><textarea name="data[CustomerBGP][nomination_address]"  class="validate[required]" rows="5" style="width:40%"><?php echo  $customer['CustomerBGP'][nomination_address]; ?></textarea></dd>
			<dt><label for="name">City</label></dt>
          <dd><input type="text" name="data[CustomerBGP][nomination_city]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_city']; ?>"/></dd>
			<dt><label for="name">State</label></dt>
			<dd><input type="text" name="data[CustomerBGP][nomination_state]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_state']; ?>"/></dd>
			<dt><label for="name">Pincode</label></dt>
			<dd><input type="text" name="data[CustomerBGP][nomination_pincode]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_pincode']; ?>"/></dd>
			<dt><label for="name">Guardian Relationship with minor</label></dt>
			<dd><input type="text" name="data[CustomerBGP][nomination_guardian_realtion]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_guardian_realtion']; ?>"/></dd>
			<dt><label for="name">Relationship with applicant</label></dt>
			<dd><input type="text" name="data[CustomerBGP][nomination_applicant_realtion]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['nomination_applicant_realtion']; ?>"/></dd>
			<dt><label for="name">DOB in case minor</label></dt>
			<dd><input type="text" name="data[CustomerBGP][nomination_dob]" id=""  class="validate[required]" size="50" value="<?php if($customer['CustomerBGP']['nomination_dob'] != "0000-00-00") { echo $customer['CustomerBGP']['nomination_dob']; } ?>"/></dd>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Initial Subscription Detials</legend>
        <dl class="inline">
         <dt><label for="name">Payment Method</label></dt>
          <dd><input type="text" name="data[CustomerBGP][initial_pay_by]"  class="validate[required]" size="50" value="<?php echo  $customer['CustomerBGP'][initial_pay_by]; ?>" /></dd>
		  <?php if($customer['CustomerBGP'][initial_pay_by] == "Online") { ?>
          <dt><label for="name">Amount</label></dt>
          <dd><input type="text" name="data[CustomerBGP][initial_amount]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['initial_amount']; ?>"/></dd>
			<?php } ?>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Monthly Subscription Detials</legend>
        <dl class="inline">
         <dt><label for="name">Type</label></dt>
          <dd><input type="text" name="data[CustomerBGP][monthly_sip_pdc]"  class="validate[required]" size="50" value="<?php echo  $customer['CustomerBGP'][monthly_sip_pdc]; ?>" /></dd>
          <dt><label for="name">SIP through auto debit</label></dt>
          <dd><input type="text" name="data[CustomerBGP][monthly_sip_through_auto_debit]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['monthly_sip_through_auto_debit']; ?>"/></dd>
		  <dt><label for="name">Bank</label></dt>
          <dd><input type="text" name="data[CustomerBGP][bank_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['bank_name']; ?>"/></dd>
		  <dt><label for="name">Account No</label></dt>
          <dd><input type="text" name="data[CustomerBGP][account_number]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['account_number']; ?>"/></dd>
		  <dt><label for="name">Account Type</label></dt>
          <dd><input type="text" name="data[CustomerBGP][account_type]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['account_type']; ?>"/></dd>
		  <dt><label for="name">Amount</label></dt>
          <dd><input type="text" name="data[CustomerBGP][amount]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['amount']; ?>"/></dd>
		  <dt><label for="name">Tenure</label></dt>
          <dd><input type="text" name="data[CustomerBGP][tenure]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['tenure']; ?>"/></dd>
		  <dt><label for="name">Period From</label></dt>
          <dd><input type="text" name="data[CustomerBGP][period_from]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['period_from']; ?>"/></dd>
		  <dt><label for="name">Period To</label></dt>
          <dd><input type="text" name="data[CustomerBGP][period_to]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['period_to']; ?>"/></dd>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>ECS Detials</legend>
        <dl class="inline">
         <dt><label for="name">Bank Account No.</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_bank_account_number]"  class="validate[required]" size="50" value="<?php echo  $customer['CustomerBGP'][ecs_bank_account_number]; ?>" /></dd>
          <dt><label for="name">Bank Account Type</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_bank_account_type]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_bank_account_type']; ?>"/></dd>
		  <dt><label for="name">Bank Holders Name</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_account_holder_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_account_holder_name']; ?>"/></dd>
		  <dt><label for="name">Bank Name</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_bank_name]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_bank_name']; ?>"/></dd>
		  <dt><label for="name">Branch/ Bank Address</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_branch_address]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_branch_address']; ?>"/></dd>
		  <dt><label for="name">City</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_city]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_city']; ?>"/></dd>
		  <dt><label for="name">Pincode</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_pincode]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_pincode']; ?>"/></dd>
		  <dt><label for="name">MICR Code</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_branch_micr]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_branch_micr']; ?>"/></dd>
		  <dt><label for="name">IFSC Code</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_ifsc_code]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_ifsc_code']; ?>"/></dd>
		   <dt><label for="name">Debit Date</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_debit_date]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_debit_date']; ?>"/></dd>
		  <dt><label for="name">Amount of Subscription</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_amount_of_subscription]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_amount_of_subscription']; ?>"/></dd>
		  <dt><label for="name">Period From</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_from]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_from']; ?>"/></dd>
		  <dt><label for="name">Period To</label></dt>
          <dd><input type="text" name="data[CustomerBGP][ecs_to]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['ecs_to']; ?>"/></dd>
		</dl>
      </fieldset>
	   <fieldset>
        <legend>Declaration</legend>
        <dl class="inline">
		<p style="text-align: justify;">I propose to enroll with Birla Gold Saving Plan, Subject to Terms &amp; Conditions of the product brochures as amended from time to time. I have read and understood (before filling the application form) &amp; Conditions in the product brouchers, and I accept the same. I have neither recived nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Saving Plan. I hereby declare that the subscriptions proposed to be remitted in Birla Gold Sabing Plan will be from legitimate sources only and will not be with any intention to contravene/evade/avoid andy legal/statutory/regulatory requirements. I understand that Birla Gold &amp; Precious Metals Ltd., may at its absolute direction, discontinue any or all of the services by giving prior notice to me. I hereby authorise to BGPM debit my customer ID with the service charges as applicable from time to time. I hereby authorise the aforesaid nominee to receive all the gold accrued to my credit, in the event of my death. Signature of the nominee acknowledging receipts of the proceeds of Birla Gold Shall condtiture full discharge of liablities of Birla Gold in respect of my Customer ID.</p>
		<br>
		<dt><label for="name">Date</label></dt>
          <dd><input type="text" name="data[CustomerBGP][declaration_date]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['declaration_date']; ?>"/></dd>
		  <dt><label for="name">Place</label></dt>
          <dd><input type="text" name="data[CustomerBGP][declaration_place]" id=""  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['declaration_place']; ?>"/></dd>
		   <?php if($customer["CustomerBGP"]["distributor"] == "yes") { ?>
		   <dt><label for="name">Distributor</label></dt>
          <dd>
		  <select name="data[CustomerBGP][relationship_manager]" id="relationship_manager"  class="validate[required]">
				<option value="">Select Relationship Manager</option>
		  <?php foreach($relation as $rel) { ?>
				<option value="<?php echo $rel['RelationshipManager']['manager_id']; ?>" <?php if($rel['RelationshipManager']['manager_id'] == $customer["CustomerBGP"]["relationship_manager"]) { echo "selected"; } ?>><?php echo $rel['RelationshipManager']['manager_name']; ?></option>
		  <?php } ?>
		  </select>
		  </dd>
    
		   <?php  } ?>
		  <div class="buttons">
				<?php echo $this->Html->link(__('Back'),array('action'=>'index'),array('class'=>'button')); ?>
				<button id="Approved" style="display: none;" onclick="chageStatus('Approved');" type="button" class="button">Approve</button>
				<button id="Rejected" style="display: none;" onclick="chageStatus('Rejected');" type="button" class="button" >Reject</button>
				<input type="hidden" value="<?php echo $customer['CustomerBGP']['approve_status']; ?>" name="approve_status" id="approve_status" />
				<input type="hidden" value="<?php echo $customer['CustomerBGP']['customer_id']; ?>" name="data[CustomerBGP][customer_id]" id="customer_id" />
				<input type="hidden" value="<?php echo $customer['CustomerBGP']['user_id']; ?>" name="data[CustomerBGP][user_id]" id="user_id" />
				<input type="submit" value="Submit" id="submit" class="button"/>
		  </div>
		  
		   <dt><label for="name" id="reason1" style="display:none">Reason</label></dt>
          <dd><input type="text" name="data[CustomerBGP][reason]" id="reason"  class="validate[required]" size="50" value="<?php echo $customer['CustomerBGP']['reason']; ?>" style="display:none;"/></dd>
			 <div class="buttons">
				<button id="reason2" style="display: none;" onclick="ajaxStatuUpdate();" type="button" class="button" >Process</button>
		  </div>
		</dl>
      </fieldset>	  
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
		$("input,select,textarea").attr("disabled","disabled");
		$("#relationship_manager").removeAttr("disabled");
		$("#customer_id").removeAttr("disabled");
		$("#submit").removeAttr("disabled");
		
		var reason = $("#reason").val();
		
		var status = $("#approve_status").val();
		if(status == "Pending")
 			{
 	 			$("#Approved").show();
 	 			$("#Rejected").show();
 			}
 			else if(status == "Approved")
 			{
 				$("#Approved").hide();
 				$("#reason").hide();
				$('#reason1').hide();
				$('#reason2').hide();
 	 			$("#Rejected").show();
 			}
 			else if(status == "Rejected")
 			{
 				$("#Approved").show();
 				$("#reason").show();
				$('#reason1').show();
				$('#reason2').show();
 	 			$("#Rejected").hide();
				$('#reason').removeAttr("disabled"); 
 			}
	
});
var id1="<?php echo $customer['CustomerBGP']['customer_id']; ?>";
var status1="Rejected";    	
function chageStatus(status)
{
	id1 = '<?php echo $customer['CustomerBGP']['customer_id']; ?>';
	status1 = status;
	if(status == "Approved")
	{
		ajaxStatuUpdate();
	}
	else
	{        			
		$('#reason').show();
		$('#reason1').show();
		$('#reason2').show();
		$('#reason').removeAttr("disabled");      		
	}    			
}
function ajaxStatuUpdate()
{
	$.ajax({
 		url: '<?php echo BASE_URL; ?>admin/customermaster/changeStatus',
 		data: 'id='+id1+'&status='+status1+'&text='+$("#reason").val(),
 		type: 'post',
 		success: function(response)
 		{
 			var res = eval('('+response+')');
			//console.log(res['msg']);
			if(res['msg']=="success")
			{
				msg = "";
				if(status1 == "Approved")
				{
					msg = "Customer approved";
					$("#Approved").hide();
	 	 			$("#Rejected").show();
				}
				else if(status1 == "Rejected")
				{
					msg = "Customer rejected";
					$("#Approved").show();
	 	 			$("#Rejected").hide();
				}        
				//alert("success",msg);									
				location.reload()
			}
			else
			{
				alert('Status could not be changed. Please try after some time.');									
			}
			$("#reason").val("");
       	}
  	});    	
}
</script>