<?php //print_r($roles);?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:50px;"><?php //echo $this->Html->link(__('Back to Admin Users'),array('action'=>'index'),array('class'=>'button')); ?></div>
        
       <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Add Admin User</legend>
                <dl class="inline">

                    <fieldset><legend>User Details</legend>
                        <dl class="inline">
                            
							<dt><label for="name">Role<span class="required">*</span></label></dt>
                            <dd>
                                <select name="data[Adminuser][role_id]" id="AdminuserRoleid" class="validate[required]"  >

                                    <option value="">Select</option>
                                    <?php
                                    foreach ($roles as $role) {

                                        echo '<option value="' . $role['Userroles']['role_id'] . '" >' . $role['Userroles']['role_name'] . '</option>';
                                    }
                                    ?>
                                </select>         
                            </dd>
							
							<dt><label for="name">Username<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][username]" id="AdminuserUsername"  class="validate[required]" size="80"/></dd>
							
							<dt><label for="name">Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][admin_name]" id="AdminuserAdminName"  class="validate[required]" size="80" /></dd>
							
							<dt><label for="name">Email<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][email]" id="AdminuserAdminName"  class="validate[required,custom[email]]" size="80" /></dd>
							
							<dt><label for="name">Mobile<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Adminuser][phone]" id="AdminuserPhone"  class="validate[required,custom[integer],minSize[10],maxSize[12]] text" size="80" /></dd>
                            
                    </fieldset>

                    
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
	   
    </div>
</div>





