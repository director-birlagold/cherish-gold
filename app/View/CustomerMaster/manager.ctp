<?php $pageTitle = 'Customer'; ?>
<link href="<?php echo BASE_URL ?>css/bootstrap1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
<div id="container">
<div class="clr"></div>
	<div class="wrapper">		
		<div class="MidSection">
			<h4>Relationship Manager Details</h4>
			<div class="clr"></div>
			<div class="row">                
				<div id="content" class="col-sm-12">      
      
				<fieldset>
				  <h3><b>Name: <?php echo $relation['RelationshipManager']['manager_name']; ?></h3>
				  <h3><b>Mobile: <?php echo $relation['RelationshipManager']['manager_mobile']; ?></b></h3>
				  <h3><b>Phone: <?php echo $relation['RelationshipManager']['manager_phone']; ?></b></h3>
				  <h3><b>Email: <?php echo $relation['RelationshipManager']['manager_email']; ?></b></h3>
				  <h3><b>Address: <?php echo $relation['RelationshipManager']['manager_address']; ?></b></h3>
				</fieldset>
			<div class="buttons clearfix">
			
			  <div class="pull-left"><?php echo $this->Html->link('Back',array('controller'=>'customermaster','action'=>'dashboard'),array('class'=>'button'));?></div>
			</div>
      </div>
    </div>
		</div>
	</div>
</div>