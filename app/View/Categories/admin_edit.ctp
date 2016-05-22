<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Categories List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Category" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Category</legend>
        <dl class="inline">
         <dt><label for="name">Category Code</label></dt>
          <dd><input type="text" name="data[Category][category_code]" id="category_code"  class="validate[required]" size="50" value="<?php if(isset($category['Category']['category_code'])){ echo $category['Category']['category_code'];}?>"/></dd>
          <dt><label for="name">Category<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Category][category]" id="category"  class="validate[required]" size="50" value="<?php if(isset($category['Category']['category'])){ echo $category['Category']['category'];}?>"/>
          </dd>
           <dt><label for="name">Meta Title<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Category][meta_title]" id="meta_title"  class="validate[required]" size="50" value="<?php if(isset($category['Category']['meta_title'])){ echo $category['Category']['meta_title'];}?>"/></dd>
          <dt><label for="name">Meta Description</label></dt>
          <dd><textarea name="data[Category][meta_description]" cols="50" rows="5" id="meta_description"><?php if(isset($category['Category']['meta_description'])){ echo $category['Category']['meta_description'];}?></textarea></dd>
          <dt><label for="name">Meta Keywords</label></dt>
          <dd><textarea name="data[Category][meta_keywords]" cols="50" rows="5"  id="meta_keywords"><?php if(isset($category['Category']['meta_keywords'])){ echo $category['Category']['meta_keywords'];}?></textarea></dd>
          <dt><label for="name">Status</label></dt>
          <dd><select name="data[Category][status]" id="status">
          <option value="Active" <?php if(isset($category['Category']['status']) && $category['Category']['status']=='Active'){ echo 'selected="selected"';}?> >Active</option>
          <option value="Inactive" <?php if(isset($category['Category']['status']) && $category['Category']['status']=='Inactive'){ echo 'selected="selected"';}?> >Inactive</option>
          </select></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>