<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Categories List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Category" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Category</legend>
        <dl class="inline">
          <dt><label for="name">Category<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Category][category]" id="category"  class="validate[required]" size="50" value="<?php if(isset($this->request->data['Category']['category'])){ echo $this->request->data['Category']['category'];}?>"/>
          </dd>
          <dt><label for="name">Category Code<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Category][category_code]" id="category_code"  class="validate[required]" size="50" value="<?php if(isset($this->request->data['Category']['category_code'])){ echo $this->request->data['Category']['category_code'];}?>"/>
          </dd>
          
          <dt><label for="name">Meta Title<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Category][meta_title]" id="meta_title"  class="validate[required]" size="50" value="<?php if(isset($this->request->data['Category']['meta_title'])){ echo $this->request->data['Category']['meta_title'];}?>"/></dd>
          <dt><label for="name">Meta Description</label></dt>
          <dd><textarea name="data[Category][meta_description]" cols="50" rows="5" id="meta_description"><?php if(isset($this->request->data['Category']['meta_description'])){ echo $this->request->data['Category']['meta_description'];}?></textarea></dd>
          <dt><label for="name">Meta Keywords</label></dt>
          <dd><textarea name="data[Category][meta_keywords]" cols="50" rows="5"  id="meta_keywords"><?php if(isset($this->request->data['Category']['meta_keywords'])){ echo $this->request->data['Category']['meta_keywords'];}?></textarea></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
