<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:50px;"><?php //echo $this->Html->link(__('Back to Admin Users'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Payu',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __(' Payment');?></legend>
                 <dl class="inline">               
                   	
                    <?php
                    echo $this->Form->input('mode',array('div'=>false,'error'=>false,'type'=>'radio','before' => '<dt><label for="Mode">'.__('Mode').'<span class="required">*</span></label></dt><dd>', 'after' => '</dd>', 'options' =>  array('Test'=>'Test','Live'=>'Live'), 'class'=>'validate[required]'));
					
					
					echo $this->Form->input('key',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Key').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50'));				
                    echo $this->Form->input('salt',array('type'=>'text','div'=>false,'error'=>false,'label' => array('text'=> __('Salt').'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50'));
	?>
                    
                    
                    <?php  echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>

