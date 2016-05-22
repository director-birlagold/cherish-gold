<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:50px;"><?php //echo $this->Html->link(__('Back to Admin Users'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Adminuser',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Edit Profile');?></legend>
                 <dl class="inline">               
              <?php   echo $this->Form->input('username',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Username').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,minSize[5]]','size'=>'50'));				
                    echo $this->Form->input('admin_name',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Name').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50'));
                    echo $this->Form->input('email',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Email').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[email]]','size'=>'50')); 
					echo $this->Form->input('phone',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Mobile').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[integer],minSize[10],maxSize[12]]','size'=>'50'));             	
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





