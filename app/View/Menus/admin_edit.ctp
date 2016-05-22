<style>
    form dl.inline dd{
        display: inline-block !important;
    }
</style>
<?php // echo $this->Html->script(array('ckeditor/ckeditor')); ?> 
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Menu'), array('action' => 'index'), array('class' => 'button')); ?></div>        
        <?php echo $this->Form->create('Menu', array('id' => 'myForm', 'type' => 'file', 'inputDefaults' => array('fieldset' => false, 'legend' => false))); ?>        	
        <fieldset>
            <legend><?php echo __('Edit Menu'); ?></legend>
            <dl class="inline">
                <?php
                echo $this->Form->input('menu_name', array('div' => false, 'error' => false, 'label' => array('text' => 'Title' . '<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class' => 'validate[required]', 'size' => '50'));
                ?>
                <?php
                $show_cats = array(1);
                if(in_array($this->data['Menu']['menu_id'], $show_cats)){
                ?>
                <dt><label for="name">Category</label></dt>
                <dd>
                <?php
                $cats = explode(',', $this->data['Menu']['category_ids']);
                foreach($categories as $category){?>
                    <input type="checkbox" 
                           name="data[Menu][category_ids][]" 
                           value="<?php echo $category['Category']['category_id']?>" 
                            <?php echo in_array($category['Category']['category_id'], $cats) ? 'checked' : ''?>/>
                            <?php echo $category['Category']['category'];?>&nbsp;&nbsp;
                <?php }?>
                </dd>
                <?php }?>
                <dt><label for="name">Status</label></dt>
                <dd><?php echo $this->Form->input('is_active', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false));?></dd>
                <?php
                echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'value' => __('Submit')));
                ?>
            </dl>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
