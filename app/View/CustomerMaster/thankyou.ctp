<?php $pageTitle = 'Customer'; ?>
<link href="<?php echo BASE_URL ?>css/bootstrap1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
<div id="container">
	<!----------------Slider Start---------------->
	<div id="container" class="">
		<div class="wrapper">
			<div class="sliderDiv lF">
				<div class=""><img src="<?php echo BASE_URL;?>img/in_banner.png" alt=""></div>
			</div>
		</div>
	</div>
	<!----------------Slider End----------------> 
	<div class="clr"></div>
	<div class="wrapper">		
		<div class="MidSection">
			<?php if(isset($title)) 
			{ 
				echo "<h4>".$title."</h4>"; 
			} 
			else
			{
				?>
			<h4>Thank You</h4>
			<?php } ?>
			<p>&nbsp;</p>
			<div class="clr"></div>
			<p>
				<?php
				// log post data
					if(isset($msg))
					{
						echo $msg;
					}
					else
					{
					echo 'Your Application registered successfully, requested to please save/download the application form.<br/> Please fill all the incomplete details, paste the photograph and sign the application form and submit at Birla Gold Office.<br /><br />'; 
					echo '<a style="color:#8C472B" href="'.BASE_URL.'customer/generateForm_dn?id='.$application_no.'">Download Form</a>';
					
					// echo "Your Application registered successfully, requested to please save/download the application form.<br/>Please fill all the incomplete details, paste the photograph and sign the application form and submit at any nearest CAMS Branches";
					//echo "Thank you for register with us. Distributor Code is ".$_SESSION["birlagold"]['application_no']." <br/>Welcome letter is emailed to you at your registered email id.";
					//unset($_SESSION["birlagold"]['application_no']);
					}
					echo '<br><br><a style="color:#8C472B" href="'.BASE_URL.'customer/dashboard">Goto Dashboard</a>';
				?>
			</p>			
		</div>
	</div>
</div>
</div>