<?php
	echo $this->Html->css(array('ui/jquery-ui-timepicker-addon'));
    echo $this->Html->script(array('ui/jquery-ui-timepicker-addon'));	
?>
<div class="main">
<header> &nbsp; </header>
<div style="clear:both;">&nbsp;</div>
<!--- New HTML Start -->
<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
<div id="" class="tabsDiv">
	<div class="middleContent">
    	<h2>Account Dashboard</h2>
        <p> Manage your personal information and track your orders by clicking the sections below. Your Order items are not the same as your cart items(link at the top of this page).
The cart is the set of items that have been readied for purchase but have not been paid for. </p>
    </div>
  </div>
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/address_book"  class="ui-tabs-anchor">Address Book</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>orders/my_order"  class="ui-tabs-anchor">My Order</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/wishlist"  class="ui-tabs-anchor">Wishlist</a></li>

</ul>
<div id="tabs-1" class="">
<p></p>
<div class="account_details" id="account_details">
<h2>View Account Details</h2>
<div style="float:left; width:100%;">
		<table cellpadding="0" cellspacing="0" border="0" width="45%" class="bdrdottTd" >	
        	<tr>
            	<td width="140">Name</td>
            	<td width="30">:</td>
            	<td width="350"  class="details"><?php echo $user['User']['first_name'];?><?php echo $user['User']['last_name'];?></td>                
                <td class="detail" style="display:none;">
                <input type="text" name="data[User][first_name]"  value="<?php echo $user['User']['first_name']?>" style="width:130px;"/>
                <input type="text" name="data[User][last_name]"  value="<?php echo $user['User']['last_name']?>" style="width:130px;"/>
                </td>
                
            	<!--<td><a class="edit">Edit</a></td>-->
            </tr>
        	<tr>
            	<td>Mobile No.</td>
            	<td>:</td>
            	<td  class="details"><?php echo $user['User']['phone_no'];?></td>
                
                <td class="detail" style="display:none;">
                
                 
                <input type="text" name="data[User][phone_no]" value="<?php echo $user['User']['phone_no'];?>" />
             
                </td>                
            	<!--<td><a class="edit">Edit</a></td>-->
            </tr><tr>
            	<td>Email ID</td>
            	<td>:</td>
            	<td  class="details"><?php echo $user['User']['email'];?></td>
                
                <td class="detail" style="display:none;">
                
                  
                <input type="text" name="data[User][email]"  value="<?php echo $user['User']['email'];?>"/>
            
                
                </td>
              </tr>
              <tr>
            	<td>Date of Birth</td>
            	<td>:</td>
                <?php
				/*if(!empty($user)){
					if($user['User']['user_type']==0){
					$key= $user['User']['date_of_birth'];
					$pattern = "/(\d+)/";
					
					$array = preg_split($pattern, $key, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					}
					if($user['User']['user_type']==1){
					$key= $user['User']['date_of_birth'];
					$pattern = "/(\d+)/";
					
					$array = preg_split($pattern, $key, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					}
				}*/
                        ?>
            	<td  class="details"><?php //if(!empty($user)){ if($user['User']['user_type']==0) {  if(!empty($user['User']['date_of_birth'])) { echo $array[0]."-".$array[2]."-".$array[4]; } } } ?><?php echo $user['User']['date_of_birth'];?> </td>
                <td class="detail" style="display:none;">
                
                
             <?php /*?><select name="data[User][date]" style="width:75px;" class="validate[required] date"><option value="">DD</option>
                                    <?php
                                    for ($i = 1; $i < 32; $i++) { ?>
                                    <option value="<?php echo $i;?>" <?php if(!empty($user)){ if($user['User']['user_type']==1) { if(!empty($user['User']['date_of_birth'])) { if($array[0]==$i) { echo 'selected="selected"'; }   }} }?>><?php echo $i;?></option>
                                     <?php
                                    }
                                    ?>
                                </select>
                          <select name="data[User][month]" style="width:100px;" class="validate[required] month"><option value="">MM</option>
                                    <?php
                                    for ($i = 1; $i < 13; $i++) { ?>
                                     <option value="<?php echo $i;?>" <?php if(!empty($user)){ if($user['User']['user_type']==1) { if(!empty($user['User']['date_of_birth'])) { if($array[2]==$i) { echo 'selected="selected"'; } } } } ?>><?php echo date('F', strtotime('01.' . $i . '.2001'));?></option>
                                     <?php
                                       
                                    }
                                    ?>
                                </select>
                                <select name="data[User][year]" style="width:110px;" class="validate[required] year"><option value="">YYYY</option>
                                    <?php
                                    for ($i = 1980; $i <2015; $i++) { ?>
                                    
                                     <option value="<?php echo $i;?>"<?php if(!empty($user)){ if($user['User']['user_type']==1) { if(!empty($user['User']['date_of_birth'])) { if($array[4]==$i) { echo 'selected="selected"'; } }} } ?>><?php echo $i;?></option>
                                        
                                            <?php }?> 
                                  
                                </select><?php */?>
             
                </td>
                
            	<!--<td><a class="edit">Edit</a></td>-->
            </tr>
            <tr>
            	<td>Anniversary date</td>
            	<td>:</td>
            	<td  class="details"><?php echo $user['User']['anniversary'];?></td>
                
                <td class="detail" style="display:none;">
                
                  
               
            
                
                </td>
              </tr>
            
              <tr>             
              <td colspan="2"><button onclick="edit_details();" >Edit Account</button></td>             
              <td colspan="2"><button  id="pass_chage_button">Change Password</button></td>
              </tr>
            
        </table>
        <br/><br/><br/><br/>
       
</div>


</div>

 <div id="password_change" class="account_details" style="display:none;">
        <h2>Change Password</h2><br/>
           <form name="account" method="post" action="" id="myForm">      
                <div style="float:left; width:100%;">
	                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                          
                            <tr>
                                <td>Password * </td>
                                <td>:</td>
                                <td><input type="password" name="data[User][password]" class="validate[required,minSize[6]]" id="password" style="width:330px;"></td>
                            </tr>
                            <tr><td colspan="3" height="10"></td></tr>
                            <tr>
                                <td>Repeat Password * </td>
                                <td>:</td>
                                <td><input type="password" name="repassword" class="validate[required,minSize[6],equals[password]]" id="repassword" style="width:330px;"></td>
                            </tr>
                            <tr><td colspan="3" height="10"></td></tr>                       
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><button type="submit" name="data[User][submit]" id="submit" >Save Changes</button>&nbsp;<button type="button" name="pass_chage_button1" id="pass_chage_button1" >Cancel</button></td>
                            </tr>
                            
                        </table>              
        </div>
    </form>
</div>



</div>
</div>

  <div style="clear:both;">&nbsp;</div>
  <div class="shadow"><?php echo $this->Html->Image('shadow.png',array('alt'=>''));?></div>
  <div style="clear:both;"></div>
  <div class="newletter">
    <div style="float:left; width:40%; border-right:dashed 1px #edc432; padding-right:15px;">
      <h1 style="color:#b29232;">Newsletter</h1>
      <p>Provide your email address and get notified about our latest products as well as other awesome offers.</p>
      <p> Email<br />
        <input type="text" name="newletter" placeholder="Enter Email">
        <br />
        <br />
        <input name="" type="button" value="Submit">
      </p>
    </div>

    <div style="float:left; width:56%; padding-left:20px;">
      <h1 style="color:#b29232;">Try at Home</h1>
      <p>(Delhi NCR, Gurgaon, Noida, Faridabad, Ghaziabad, Mumbai, Pune, Bangalore, Chennai, Chandigarh, Hyderabad, Ludhiana, Ambala, Patiala)</p>
      <p>Now you can try on our jewellery from the comfort of your home. Please provide us your contact details below and our jewellery consultant will get in touch with you soon.</p>
      <div style="float:left;">
        <div style="float:left; margin-right:10px;">Name <br />
          <input style="width:100px;" type="text" name="newletter">
        </div>
        <div style="float:left; margin-right:10px;">Phone <br />
          <input style="width:100px;" type="text" name="newletter" >
        </div>
        <div style="float:left; margin-right:10px;">City <br />
          <select style="width:100px;" class="validate[required]" name="try_city" id="try_city">
            <option value="">Select</option>
            <option value="Delhi">Delhi (NCR)</option>
            <option value="Gurgaon">Gurgaon</option>
            <option value="Noida">Noida</option>
            <option value="Faridabad">Faridabad</option>
            <option value="Ghaziabad">Ghaziabad</option>
            <option value="Mumbai">Mumbai</option>
            <option value="Pune">Pune</option>
            <option value="Bangalore">Bangalore</option>
            <option value="Chennai">Chennai</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Hyderabad">Hyderabad</option>
            <option value="Ludhiana">Ludhiana</option>
            <option value="Ambala">Ambala</option>
            <option value="Patiala">Patiala</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div style="float:left; margin-right:10px;">Pincode <br />
          <input style="width:100px;" type="text" name="newletter" >
        </div>
        <div style="float:left;"><br />
          <input style="padding:4px 15px 4px 15px;" name="" type="button" value="Submit">
        </div>
      </div>
    </div>
    </div>
    <script>
    $(document).ready(function(){
    $("#myForm").validationEngine();
  
    });
</script>
    <script>
	function edit_details()
	{
		window.location="<?php echo BASE_URL ?>signin/personal";
	}		
	$(document).ready(function(){		
		$('.edit').click(function(){
         $('.detail').show();
		 $('.details').hide();
		});		
		$('#pass_chage_button').click(function(){		
          $('#account_details').toggle('slow');
		 $('#password_change').toggle('slow');		
		});
		$('#pass_chage_button1').click(function(){		
          $('#account_details').toggle('slow');
		 $('#password_change').toggle('slow');		
		});		
	});
	</script>
<script>
     $(document).ready(function(){
                   $( "#enddate").datepicker({
                        dateFormat: 'yy-mm-dd',
                        showOn: "button",
			buttonImage: "<?php echo BASE_URL;?>img/calendar.gif",
			buttonImageOnly: true,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-30"
                   });
                   });
</script>