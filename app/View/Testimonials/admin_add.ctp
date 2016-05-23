
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to ' .$cms),array('action'=>'index',$this->params['pass']['0']),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create($cms ,array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Add '.$cms);?></legend>
                 <dl class="inline">
				<?php	
				   			
                     echo $this->Form->input('name',array('div'=>false,'error'=>false,'name'=>'data[Testimonial][name]','label' => array('text'=>'Name'.''), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>"validate[custom[onlyLetterSp]]",'size'=>'50'));                 
                    if($this->params['pass']['0']=='customer_says') { 
					
					 echo $this->Form->input('customer_name',array('div'=>false,'error'=>false,'name'=>'data[Testimonial][customer_name]','label' => array('text'=>'Customer Name'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>"validate[required,custom[onlyLetterSp]]",'size'=>'50'));
					 
					 echo $this->Form->input('facebook_link',array('div'=>false,'error'=>false,'name'=>'data[Testimonial][facebook_link]','label' => array('text'=>'Facebook Link'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>"validate[required,custom[url]]",'size'=>'50'));
					 
					 }
					 
					  echo $this->Form->input('image',array('div'=>false,'type'=>'file','error'=>false,'name'=>'data[Testimonial][images]','label' => array('text'=>'Image'.''), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>"validate[custom[image]]",'size'=>'50'));
					  
					  echo $this->Form->input('content',array('div'=>false,'type'=>'textarea','rows'=>'6','cols'=>'50','error'=>false,'name'=>'data[Testimonial][content]','label' => array('text'=>'Content'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>"validate[required]",'size'=>'50'));
					              		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





