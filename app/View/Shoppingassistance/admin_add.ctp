<?php echo $this->Html->script(array('ckeditor/ckeditor')); ?> 
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Shopping Assistance'), array('action' => 'index'), array('class' => 'button')); ?></div>        
        <?php echo $this->Form->create('ShoppingAssistance', array('id' => 'myForm', 'enctype' => 'multipart/form-data', 'type' => 'file', 'inputDefaults' => array('fieldset' => false, 'legend' => false))); ?>        	
        <fieldset>
            <legend><?php echo __('Add Shopping Assistance'); ?></legend>
            <dl class="inline">
                <?php
                echo $this->Form->input('title', array('div' => false, 'error' => false, 'label' => array('text' => 'Title' . '<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required]', 'size' => '50'));
                echo $this->Form->input('description', array('div' => false, 'error' => false, 'label' => array('text' => __('Content') . '<span class="required">*</span>'), 'type' => 'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required] text-input ckeditor', 'rows' => '5', 'cols' => '50'));
                ?>
				<dt><label for="name">Image<span class="required">*</span></label></dt>
				<dd><input type="file" name="data[ShoppingAssistance][image]" id="category"  class="validate[required,custom[image]]" /></dd>
				<!-- <dt><label>&nbsp;</label></dt><dd><p><strong>Upload image size 111 x 111</strong></p></dd> -->
				<?php
				echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'value' => __('Submit')));
                ?>
            </dl>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>





