<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Content Page'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Staticpage',array('id'=>'myForm_static','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo $this->request->data['Staticpage']['pagename'];?> - <?php echo __('Edit Content Page');?></legend>
                 <fieldset>
                <legend><?php echo __('Page Name');?></legend>
                 <dl class="inline">                
				<?php
                    echo $this->Form->input('pagename',array('div'=>false,'error'=>false,'label' => array('text'=>__('Page Name').'<span class="required">*</span>'),'name'=>'data[Staticpage][pagename]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50','value'=> ((!empty($this->request->data['Staticpage']['pagename'])) ? $this->request->data['Staticpage']['pagename'] : '')));
					?>
                  </dl>
                  </fieldset>
                <?php if($this->request->data['Staticpage']['seo']=="Yes"){?>
                <fieldset>
                <legend><?php echo __('SEO');?></legend>
                <dl class="inline">
				<?php						
					echo $this->Form->input('meta_title',array('div'=>false,'error'=>false,'label' => array('text'=>__('Meta Title').'<span class="required">*</span>'),'name'=>'data[Staticpage][meta_title]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','cols'=>'46','rows'=>'5', 'class'=>'validate[required]','size'=>'50','value'=> ((!empty($this->request->data['Staticpage']['meta_title'])) ? $this->request->data['Staticpage']['meta_title'] : '')));
					
					echo $this->Form->input('meta_description',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Meta Description').''),'name'=>'data[Staticpage][meta_description]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','cols'=>'46','rows'=>'5','value'=> ((!empty($this->request->data['Staticpage']['meta_description'])) ? $this->request->data['Staticpage']['meta_description'] : '')));
					
					echo $this->Form->input('meta_keyword',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Meta Keyword').''),'name'=>'data[Staticpage][meta_keyword]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','cols'=>'46','rows'=>'5','value'=> ((!empty($this->request->data['Staticpage']['meta_keyword'])) ? $this->request->data['Staticpage']['meta_keyword'] : '')));
					?>
                  </dl>
                  </fieldset>
                  <?php }?>
                  <?php if($this->request->data['Staticpage']['content']=="Yes"){?>
                  <fieldset>
                <legend><?php echo __('Content');?></legend>
                <dl class="inline">
				<?php					
					echo $this->Form->input('pagecontent',array('div'=>false,'error'=>false,'type'=>'textarea','label' => array('text'=>__('Content').'<span class="required">*</span>'),'name'=>'data[Staticpage][pagecontent]', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required] ckeditor','cols'=>'46','rows'=>'5','value'=>((!empty($this->request->data['Staticpage']['pagecontent'])) ? $this->request->data['Staticpage']['pagecontent'] : '')));
					?>
                     </dl>
                     </fieldset> 
					 <?php }?>
                      <fieldset>
				 <?php 	
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
                
                </dl>
                 </fieldset>
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>