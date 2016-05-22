<style>
    form dl.inline dd{
        display: inline-block !important;
    }
</style>
<?php // echo $this->Html->script(array('ckeditor/ckeditor')); ?> 
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;">
            <?php echo $this->Html->link(__('Back to Mainmenu'), array('controller' => 'menus', 'action' => 'index'), array('class' => 'button')); ?>
            <?php echo $this->Html->link(__('Back to Submenu'), array('action' => 'index',$submenu['Menu']['menu_id']), array('class' => 'button')); ?>
        </div>        
        <?php echo $this->Form->create('Submenu', array('id' => 'myForm', 'type' => 'file', 'inputDefaults' => array('fieldset' => false, 'legend' => false))); ?>        	
        <fieldset>
            <legend><?php echo __('Edit Submenu'); ?></legend>
            <dl class="inline">
                <dt><label>Main menu</label></dt>
                <dd><?php echo $submenu['Menu']['menu_name']?></dd>
                <?php echo $this->Form->input('submenu_name', array('div' => false, 'error' => false, 'label' => array('text' => 'Submenu Title' . '<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required]', 'size' => '50'));?>
                <dt><label for="name">Status</label></dt>
                <dd><?php echo $this->Form->input('is_active', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false));?></dd>
                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'value' => __('Submit')));?>
            </dl>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
