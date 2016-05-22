<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Banner List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Category" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Banner</legend>
        <dl class="inline">
		 <?php echo $this->Form->input('title',array('div'=>false,'error'=>false,'name'=>"data[Banner][title]",'label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['Banner']['title'], 'class'=>'validate[required]','size'=>'50')); ?>
          <?php echo $this->Form->input('link',array('div'=>false,'error'=>false,'name'=>"data[Banner][link]",'label' => array('text'=>'Link'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['Banner']['link'], 'class'=>'validate[required,custom[url]]','size'=>'50')); ?>
          <dt><label for="name">Image</label></dt>
          <dd><input type="file" name="data[Banner][images]" id="category"  class="validate[custom[image]]" />
          </dd>
           <dt><label>&nbsp;</label></dt><dd><p><strong>Minimum Upload image size 480 x 390</strong></p></dd>
          <dt><label for="name">&nbsp;</label></dt>
          <dd><?php echo  $this->Html->image('banner/'.$this->request->data['Banner']['image'],array('height'=>'120','style'=>'padding:5px;'));?></dd>
          
          <?php echo $this->Form->input('description',array('div'=>false,'error'=>false,'name'=>"data[Banner][description]",'label' => array('text'=>__('Content').'<span class="required">*</span>'),'type'=>'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['Banner']['description'], 'class'=>'text-input ckeditor','rows'=>'5','cols'=>'40'));?>
          <dt><label for="name">Status<span class="required">*</span></label></dt>
          <dd><select name="data[Banner][status]" id="status">
          <option value="Active" <?php echo  $this->request->data['Banner']['status']=='Active'?'selected="selected"':'';?>>Active</option>
          <option value="Inactive" <?php echo  $this->request->data['Banner']['status']=='Inactive'?'selected="selected"':'';?>>Inactive</option>
          </select>
          </dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
