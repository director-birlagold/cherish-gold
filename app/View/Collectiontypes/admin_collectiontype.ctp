<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:50px;"><?php echo $this->Html->link(__('Back to Collection Type Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Collectiontype',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('Collection  Type');?></legend>
                 <dl class="inline">  
                 
            
                     <dt><label for="name">CATEGORY <span class="required">*</span></label></dt> <dd>           
                    <input type ="text" name="data[Collectiontype][collection_name]" value="<?php echo $collectiontype['Collectiontype']['collection_name']?>" class="validate[required]"  /> 
                       
                     
                      </dd>
                   
                    
                    <?php  echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>

