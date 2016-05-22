<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:50px;"><?php //echo $this->Html->link(__('Back to Admin Users'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Adminuser',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Change Password');?></legend>
                 <dl class="inline">                 
				<?php
                    echo $this->Form->input('oldpassword',array('div'=>false,'error'=>false,'label' => array('text'=>__('Old Password').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','type'=>'password','size'=>'50'));
                    echo $this->Form->input('passwords',array('div'=>false,'error'=>false,'label' => array('text'=>__('New Password').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,minSize[6]]','type'=>'password','size'=>'50'));
					 echo $this->Form->input('cpassword',array('div'=>false,'error'=>false,'label' => array('text'=>__('Confirm Password').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,minSize[6],equals[AdminuserPasswords]]','type'=>'password','size'=>'50'));                    	
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





