<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Metal Color Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Metalcolor',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Add Metal Color');?></legend>
                 <dl class="inline">
                 
                 <dt><label for="name">Metal<span class="required">*</span></label></dt>
                       <dd>
                        <select name="data[Metalcolor][metal_id]" class="validate[required]">
                        <option value="">Select Metal</option>
						<?php 
                        foreach($metal as $metal){
                        
						if (isset($this->request->data['Metalcolor']['metal_id']) && $this->request->data['Metalcolor']['metal_id'] == $metal['Metal']['metal_id']) {
						echo '<option value="' . $metal['Metal']['metal_id'] . '" selected="selected">' . $metal['Metal']['metal_name'] . '</option>';
						} else {
						echo '<option value="'.$metal['Metal']['metal_id'].'" >'.$metal['Metal']['metal_name'].'</option>';
						} 
                        
                        } ?></select>
                        </dd>

				<?php	
				   			
                     echo $this->Form->input('metalcolor',array('div'=>false,'error'=>false,'label' => array('text'=>'Metal Color'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>',  'class'=>'validate[required,custom[onlyLetterSp]]','size'=>'50','maxlength'=>'50'));
					              		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





