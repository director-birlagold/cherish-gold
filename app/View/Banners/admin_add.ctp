<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Banner List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Category" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Banner</legend>
        <dl class="inline">
          <?php 
		  echo $this->Form->input('title',array('div'=>false,'error'=>false,'name'=>'data[Banner][title]','label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50')); 
		   echo $this->Form->input('link',array('div'=>false,'error'=>false,'name'=>'data[Banner][link]','label' => array('text'=>'Link'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[url]]','size'=>'50')); ?> 
         
          <dt><label for="name">Image<span class="required">*</span></label></dt>
          <dd><input type="file" name="data[Banner][images]" id="category"  class="validate[required,custom[image]]" /></dd>
           <dt><label>&nbsp;</label></dt><dd><p><strong>Minimum Upload image size 480 x 390</strong></p></dd>
          <?php	echo $this->Form->input('description',array('div'=>false,'error'=>false,'name'=>'data[Banner][description]','label' => array('text'=>__('Description').'<span class="required">*</span>'),'type'=>'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'text-input ckeditor','rows'=>'5','cols'=>'40')); ?>

          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
