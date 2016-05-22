<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Color Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Color',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Edit Color');?></legend>
                 <dl class="inline">
                 <dt><label for="clarity">Clarity</label></dt>
                  <dd><select name="data[Color][clarity]" class="validate[required]">
                 <option value="">Select Clarity</option>
                 <?php
				 foreach($clarity as $clarities) {
					  
                echo '<option value="' . $clarities['Clarity']['clarity'] . '" '.($clarities['Clarity']['clarity'] == $this->request->data['Color']['clarity'] ? 'selected="selected"':'').'>' . $clarities['Clarity']['clarity'] . '</option>';
                                      
				 }?>
                 </select>
                 </dd>
                 
				<?php	
				   			
                     echo $this->Form->input('color',array('div'=>false,'error'=>false,'label' => array('text'=>'Color'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>',  'class'=>'validate[required,custom[onlyLetterSp]]','size'=>'50','maxlength'=>'50'));
					              		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>





