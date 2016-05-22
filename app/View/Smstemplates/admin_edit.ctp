<?php // echo $this->Html->script(array('ckeditor/ckeditor')); ?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Sms templates'), array('action' => 'index'), array('class' => 'button')); ?></div>        
        <?php echo $this->Form->create('Smstemplate', array('id' => 'myForm', 'type' => 'file', 'inputDefaults' => array('fieldset' => false, 'legend' => false))); ?>        	
        <fieldset>
            <legend><?php echo __('Edit Sms template'); ?></legend>
            <dl class="inline">
                <dt><label>Title</label></dt>
                <dd><?php echo $this->data['Smstemplate']['title']?></dd>
                <?php
                echo $this->Form->input('content', array('div' => false, 'error' => false, 'label' => array('text' => __('Content') . '<span class="required">*</span>'), 'type' => 'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required] text-input', 'rows' => '5', 'cols' => '50'));
                echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'value' => __('Submit')));
                ?>
            </dl>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>





