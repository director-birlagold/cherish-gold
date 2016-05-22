<?php echo $this->Form->create('',array('id'=>'myForm','type' => 'file')); ?>
<div id="loginBox" class="loginBox clearfix" <?php if(isset($result)){ if($result!='') echo ' style="display:none;"'; } ?>>
    <h2><?php echo  __('Admin Secure Login');?></h2>
    <div id="login">
        <dl>
         <?php
			echo $this->Form->input(__('username'),array('div'=>false,'error'=>false,'label' => 'Username', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','name'=>'username'));
			echo $this->Form->input(__('password'),array('div'=>false,'error'=>false,'label' => 'Password', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','name'=>'password'));			
		?> 

		<dt><label for="name">Role</label></dt>
		<dd>
			<select name="role_id" id="AdminuserRoleid" class="validate[required]"  >

				<option value="">Select</option>
				<?php
				foreach ($roles as $role) {

					echo '<option value="' . $role['Userroles']['role_id'] . '" >' . $role['Userroles']['role_name'] . '</option>';
				}
				?>
			</select>         
		</dd>
        
        </dl>
		
		
		
		
        <div id="loginDiv">
            <div class="loginbtn"><?php echo $this->Form->submit(__('Login'),array('div'=>false, 'class'=>'button gray','name'=>'login'));	?></div>
            <div class="forgottab loginlink"><?php  echo  __('Can\'t access your account?');?></div>
        </div>
    </div>
</div>
<div id="loginBox" class="forgotBox clearfix" <?php if(isset($result)){ if($result!='') echo ' style="display:block;"'; else echo ' style="display:none;"';}  else echo ' style="display:none;"';?>>
    <h2><?php  echo  __('Admin Forgot Password');?></h2>
    <div id="login">
    	<p style="padding:10px;width:90%;"><?php  echo  __('Forgot your username or password? No worries, enter your email address below and we will hook you up.');?></p>
        <dl>
        <?php
       		echo $this->Form->input(__('email'),array('div'=>false,'error'=>false,'label' => 'Email Address', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[email]]','name'=>'email'));
		?>          
        </dl>
        <div id="loginDiv">
            <div class="loginbtn"><?php echo $this->Form->submit(__('Request Details'),array('div'=>false, 'class'=>'button gray','name'=>'forgot'));?></div>
            <div class="logintab loginlink"><?php  echo  __('Back to login page');?></div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>