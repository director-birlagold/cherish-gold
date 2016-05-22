<?php //print_r($adminuser);exit;
//echo $adminuser['Adminuser']['role_id'];
?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Admin User'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Edit Admin User</legend>
                <dl class="inline">

                    <fieldset><legend>Admin User Details</legend>
                        <dl class="inline">
                            
                            <input type="hidden" name="some" class="admin_id" value="<?php echo $adminuser['Adminuser']['admin_id']; ?>"/>
                            

                            <dt><label for="name">Role<span class="required">*</span></label></dt>
                            <dd>
                                <select name="data[Adminuser][role_id]" id="AdminuserRoleid" class="validate[required]"  >

                                    <option value="">Select</option>
                                    <?php
                                    foreach ($roles as $role) {
										$sel = ($role['Userroles']['role_id'] == $adminuser['Adminuser']['role_id']) ? 'selected="selected"' : '';
                                        echo '<option value="' . $role['Userroles']['role_id'] . '" '.$sel.'>' . $role['Userroles']['role_name'] . '</option>';
                                    }
                                    ?>
                                </select>         
                            </dd>
							
							<dt><label for="name">Username<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][username]" id="AdminuserUsername"  class="validate[required]" size="80" value="<?php echo $adminuser['Adminuser']['username']; ?>" readonly /></dd>
							
							<dt><label for="name">Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][admin_name]" id="AdminuserAdminName"  class="validate[required]" size="80" value="<?php echo $adminuser['Adminuser']['admin_name']; ?>" /></dd>
							
							<dt><label for="name">Email<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][email]" id="AdminuserAdminName"  class="validate[required,custom[email]]" size="80" value="<?php echo $adminuser['Adminuser']['email']; ?>" readonly /></dd>
							
							<dt><label for="name">Mobile<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][phone]" id="AdminuserPhone"  class="validate[required,custom[integer],minSize[10],maxSize[12]] text" size="80" value="<?php echo $adminuser['Adminuser']['phone']; ?>" /></dd>

							
                                    


                        </dl>
                    </fieldset>

                    
                    
                        
                    
            
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
            </dl>
            </fieldset>
        </form>



        
<?php echo $this->Form->end(); ?>
    </div>
</div> 



<script type="text/javascript">
    $(document).ready(function () {
	
	$('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	
        $('#selecctall').live('click', function (event) {
            //on click

            if (this.checked) { // check select status
                $('.checkbox1').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').addClass('checked');
                    this.checked = true;  //select all checkboxes with class "checkbox1"              
                });
            } else {
                $('.checkbox1').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').removeClass('checked');
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
            }
        });

    });
</script>

