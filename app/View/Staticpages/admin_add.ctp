<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Content Page'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Staticpage',array('id'=>'myForm_static','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('New Content Page');?></legend>
                 <fieldset>
                <legend><?php echo __('Page Name');?></legend>
                 <dl class="inline">
				<?php
                    echo $this->Form->input('pagename',array('div'=>false,'error'=>false,'label' => array('text'=>__('Page Name').'<span class="required">*</span>'),'name'=>'data[Staticpage][pagename]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50'));
					?>
                  </dl>
                  </fieldset>
                <fieldset>
                <legend><?php echo __('Settings');?></legend>
                <dl class="inline">
				<?php
                    echo $this->Form->input('seo',array('div'=>false,'error'=>false,'type'=>'radio','before' => '<dt><label for="Staticpageseo">'.__('SEO').'<span class="required">*</span></label></dt><dd>', 'after' => '</dd>', 'options' =>  array('Yes'=>'Yes','No'=>'No'), 'class'=>'validate[required]'));
					echo $this->Form->input('content',array('div'=>false,'error'=>false,'type'=>'radio','before' => '<dt><label for="Staticpagepagecontent">'.__('Page Content').'<span class="required">*</span></label></dt><dd>', 'after' => '</dd>', 'class'=>'validate[required]', 'options' =>  array('Yes'=>'Yes','No'=>'No')));
					?>
                  </dl>
                  </fieldset>
                  <fieldset>
                <legend><?php echo __('SEO');?></legend>
                <dl class="inline">
				<?php						
					echo $this->Form->input('meta_title',array('div'=>false,'error'=>false,'label' => array('text'=>__('Meta Title')),'name'=>'data[Staticpage][meta_title]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','cols'=>'46','rows'=>'5'));	
					echo $this->Form->input('meta_description',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Meta Description').''),'name'=>'data[Staticpage][meta_description]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','cols'=>'46','rows'=>'5'));	
					echo $this->Form->input('meta_keyword',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Meta Keyword').''),'name'=>'data[Staticpage][meta_keyword]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','cols'=>'46','rows'=>'5'));	
					?>
                  </dl>
                  </fieldset>
                  <fieldset>
                <legend><?php echo __('Content');?></legend>
                <dl class="inline">
				<?php						
					echo $this->Form->input('pagecontent',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Content').'<span class="required">*</span>'),'name'=>'data[Staticpage][pagecontent]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required] ckeditor','cols'=>'46','rows'=>'5'));	
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                </dl>
                 </fieldset>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>
