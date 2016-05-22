<link href="<?php echo BASE_URL ?>css/bootstrap1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
<div id="container">
<div class="clr"></div>
	<div class="wrapper">		
		<div class="MidSection">
			<h4>Referral Details</h4>
			<div class="clr"></div>
				
			<div class="row">                
			<div id="content" class="col-sm-12">      
            <div class="table-responsive">
				<table class="table table-bordered table-hover">
				  <thead>
					<tr>
					  <td class="text-right">ID</td>
					  <td class="text-left">Referral Name</td>
					  <td class="text-left">Referral Gender</td>
					  <td class="text-right">Referral DOB</td>
					  <td class="text-left">Contact Mobile</td>
					  <td class="text-left">Contact Phone</td>
					  <td class="text-left">Contact Email</td>
					  <td class="text-left">Status</td>
					</tr>
				  </thead>
				  <tbody>
					<?php foreach($referral as $key=>$ref)
					{ 
					?>
					<tr>
					  <td class="text-right"><?php echo $key+1; ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["referral_title"]; ?> <?php echo $ref["Referral"]["referral_name"]; ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["referral_gender"]; ?></td>
					  <td class="text-right"><?php echo date("d-m-Y",strtotime($ref["Referral"]["referral_dob"])); ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["contact_mobile"]; ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["contact_phone"]; ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["contact_email"]; ?></td>
					  <td class="text-left"><?php echo $ref["Referral"]["status"]; ?></td>				  
					</tr>
					<?php } ?>
							  </tbody>
				</table>
      </div>
	   <div class="text-right"></div>
            <div class="buttons clearfix">
        <div class="pull-left">
		<?php echo $this->Html->link('Back',array('controller'=>'customermaster','action'=>'dashboard'),array('class'=>'button'));?>
		</div>
		<div class="pull-right">
		<?php echo $this->Html->link('Add Referral',array('controller'=>'customermaster','action'=>'addreferral'),array('class'=>'button'));?>
		</div>
      </div>
      </div>
      </div>
    </div>
    
		</div>
	</div>
</div>