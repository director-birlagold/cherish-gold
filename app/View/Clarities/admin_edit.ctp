<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Clarity Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Clarity',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Edit Clarity');?></legend>
                 <dl class="inline">
				<?php	
				   			
                     echo $this->Form->input('clarity',array('div'=>false,'error'=>false,'label' => array('text'=>'Clarity'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>',  'class'=>'validate[required,custom[onlyLetterSp]]','size'=>'50','maxlength'=>'50'));
					              		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





