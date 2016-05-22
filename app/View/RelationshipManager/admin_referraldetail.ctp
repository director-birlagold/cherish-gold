<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Referral List'),array('action'=>'referral', $referral['Referral']['distributor_id']),array('class'=>'button')); ?></div>
    <form name="Referral" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Referral</legend>
        <dl class="inline">
         <dt><label for="name">Referral Name<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][referral_name]" id="referral_name"  class="validate[required]" size="50" value="<?php if(isset($referral['Referral']['referral_name'])){ echo $referral['Referral']['referral_name'];}?>"/></dd>
          <dt><label for="name">Referral Email<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][contact_email]" id="contact_email"  class="validate[required]" size="50" value="<?php if(isset($referral['Referral']['contact_email'])){ echo $referral['Referral']['contact_email'];}?>"/></dd>
          <dt><label for="name">Referral Mobile<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][contact_mobile]" id="contact_mobile"  class="validate[required]" size="50" value="<?php if(isset($referral['Referral']['contact_mobile'])){ echo $referral['Referral']['contact_mobile'];}?>"/></dd>
          
		  <dt><label for="name">Referral Phone<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][contact_phone]"  class="validate[required]" size="50" id="contact_phone" value="<?php if(isset($referral['Referral']['contact_phone'])){ echo $referral['Referral']['contact_phone']; } ?>"/></dd>
          
		  <dt><label for="name">Address<span class="required">*</span> </label></dt>
          <dd><textarea name="data[Referral][mailing_address]" cols="50" rows="5"  class="validate[required]"  id="mailing_address"><?php if(isset($referral['Referral']['mailing_address'])){ echo $referral['Referral']['mailing_address'];}?></textarea></dd>
          
		  <dt><label for="name">Landmark<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][mailing_landmark]"  class="validate[required]" size="50" id="mailing_landmark" value="<?php if(isset($referral['Referral']['mailing_landmark'])){ echo $referral['Referral']['mailing_landmark']; } ?>"/></dd>
          <dt><label for="name">City<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][mailing_city]"  class="validate[required]" size="50" id="mailing_city" value="<?php if(isset($referral['Referral']['mailing_city'])){ echo $referral['Referral']['mailing_city']; } ?>"/></dd>
          <dt><label for="name">State<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][mailing_state]"  class="validate[required]" size="50" id="mailing_state" value="<?php if(isset($referral['Referral']['mailing_state'])){ echo $referral['Referral']['mailing_state']; } ?>"/></dd>
          <dt><label for="name">Pincode<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][mailing_pincode]"  class="validate[required]" size="50" id="mailing_pincode" value="<?php if(isset($referral['Referral']['mailing_pincode'])){ echo $referral['Referral']['mailing_pincode']; } ?>"/></dd>
          <dt><label for="name">Country<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Referral][mailing_country]"  class="validate[required]" size="50" id="mailing_country" value="<?php if(isset($referral['Referral']['mailing_country'])){ echo $referral['Referral']['mailing_country']; } ?>"/></dd>
          <dt><label for="name">Status<span class="required">*</span></label></dt>
          <dd>
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status1" value="Pending" <?php if($referral['Referral']['status'] == "Pending"){ echo "checked"; } ?> />&nbsp;&nbsp;Pending
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status2" value="Converted" <?php if($referral['Referral']['status'] == "Converted"){ echo "checked"; } ?> />&nbsp;&nbsp;Converted
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status3" value="Follow Up" <?php if($referral['Referral']['status'] == "Follow Up"){ echo "checked"; } ?> />&nbsp;&nbsp;Follow Up
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status4" value="Not Reachable" <?php if($referral['Referral']['status'] == "Not Reachable"){ echo "checked"; } ?> />&nbsp;&nbsp;Not Reachable
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status5" value="Not Interested" <?php if($referral['Referral']['status'] == "Not Interested"){ echo "checked"; } ?> />&nbsp;&nbsp;Not Interested
		  <input type="radio" name="data[Referral][status]"  class="validate[required]" size="50" id="status5" value="Others" <?php if($referral['Referral']['status'] == "Others"){ echo "checked"; } ?> />&nbsp;&nbsp;Others
		  </dd>
          <dt><label for="name">Comments </label></dt>
          <dd><textarea name="data[Referral][comments]" cols="50" rows="5" id="comments"><?php if(isset($referral['Referral']['comments'])){ echo $referral['Referral']['comments']; } ?></textarea></dd>
          
		  
		  <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
		  <?php echo $this->Html->link(__('Back'),array('action'=>'referral',$referral['Referral']['distributor_id']),array('class'=>'button')); ?>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
		$("input,textarea").attr("disabled","disabled");
		
		$('#status1').removeAttr("disabled"); 
		$('#status2').removeAttr("disabled"); 
		$('#status3').removeAttr("disabled"); 
		$('#status4').removeAttr("disabled"); 
		$('#status5').removeAttr("disabled"); 
		$('#submit').removeAttr("disabled"); 
		$('#comments').removeAttr("disabled"); 
});
</script>