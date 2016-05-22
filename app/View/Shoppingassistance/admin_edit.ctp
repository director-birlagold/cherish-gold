<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Shopping Assistance'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Category" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Shopping Assistance</legend>
        <dl class="inline">
		 <?php echo $this->Form->input('title',array('div'=>false,'error'=>false,'name'=>"data[ShoppingAssistance][title]",'label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['ShoppingAssistance']['title'], 'class'=>'validate[required]','size'=>'50')); ?>
          <?php echo $this->Form->input('description',array('div'=>false,'error'=>false,'name'=>"data[ShoppingAssistance][description]",'label' => array('text'=>__('Description').'<span class="required">*</span>'),'type'=>'textarea', 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['ShoppingAssistance']['description'], 'class'=>'text-input ckeditor','rows'=>'5','cols'=>'40'));?>
          <dt><label for="name">Image</label></dt>
          <dd><input type="file" name="data[ShoppingAssistance][image]" id="category"  class="validate[custom[image]]" />
          </dd>
           <dt><label>&nbsp;</label></dt><dd><p><strong>Upload image size 111 x 111</strong></p></dd>
          <dt><label for="name">&nbsp;</label></dt>
          <dd><?php echo  $this->Html->image('shoppingAssistance/'.$this->request->data['ShoppingAssistance']['image'],array('height'=>'111','style'=>'padding:5px;'));?></dd>
          <dt><label for="name">Status<span class="required">*</span></label></dt>
          <dd><select name="data[ShoppingAssistance][status]" id="status">
          <option value="Active" <?php echo  $this->request->data['ShoppingAssistance']['status']=='Active'?'selected="selected"':'';?>>Active</option>
          <option value="Inactive" <?php echo  $this->request->data['ShoppingAssistance']['status']=='Inactive'?'selected="selected"':'';?>>Inactive</option>
          </select>
          </dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
