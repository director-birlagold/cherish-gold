<?php // echo $this->Html->script(array('ckeditor/ckeditor')); ?> 
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Order status'), array('action' => 'index'), array('class' => 'button')); ?></div>        
        <?php echo $this->Form->create('Orderstatus', array('id' => 'myForm', 'type' => 'file', 'inputDefaults' => array('fieldset' => false, 'legend' => false))); ?>        	
        <fieldset>
            <legend><?php echo __('Add Order status'); ?></legend>
            <dl class="inline">
                <?php
                echo $this->Form->input('order_status', array('div' => false, 'error' => false, 'label' => array('text' => 'Title' . '<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required]', 'size' => '50'));
                echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'value' => __('Submit')));
                ?>
            </dl>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>





