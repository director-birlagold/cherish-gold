<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Email Contents List'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Emailcontent',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Edit Mail Content');?></legend>
                 <dl class="inline">
				<?php	
				   		  echo $this->Form->input('title',array('div'=>false,'error'=>false,'label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50'));
						
						echo $this->Form->input('fromname',array('div'=>false,'error'=>false,'label'=>array('text'=>'From Name'.'<span class="required">*</span>'),'before'=>'<dt>','after'=>'</dd>','between'=>'</dt><dd>','class'=>'validate[required]','size'=>'50'));
						
						echo $this->Form->input('fromemail',array('div'=>false,'error'=>false,'label'=>array('text'=>'From Email'.'<span class="required">*</span>'),'before'=>'<dt>','after'=>'</dd>','between'=>'</dt><dd>','class'=>'validate[required]','size'=>'50'));
						
						//echo $this->Form->input('label',array('div'=>false,'error'=>'false','label'=>array('text'=>'Label'.'<span class="required">*</span>'),'before'=>'<dt>','after'=>'</dd>','between'=>'</dt><dd>','class'=>'validate[required]','rows'=>'1','cols'=>'47'));
					
					echo $this->Form->input('subject',array('div'=>false,'error'=>'false','label'=>array('text'=>'Subject'.'<span class="required">*</span>'),'before'=>'<dt>','after'=>'</dd>','between'=>'</dt><dd>','class'=>'validate[required]','rows'=>'1','cols'=>'47'));
							
                    
					
					echo $this->Form->input('content',array('div'=>false,'error'=>false,'label' => array('text'=>__('Content').'<span class="required">*</span>'),'type'=>'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required] text-input ckeditor','rows'=>'5','cols'=>'40'));
					              		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





