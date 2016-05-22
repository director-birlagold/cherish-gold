<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Subcategories List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Subcategory" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Subcategory</legend>
        <dl class="inline">
          <dt><label for="name">Subcategory<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Subcategory][subcategory]" id="Subcategory"  class="validate[required]" size="50" value="<?php if(isset($subcategory['Subcategory']['subcategory'])){ echo $subcategory['Subcategory']['subcategory'];}?>"/>
          </dd>
          <dt><label for="name">Subcategory Code<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Subcategory][subcategory_code]" id="subcategory_code"  class="validate[required]" size="50" value="<?php if(isset($subcategory['Subcategory']['subcategory_code'])){ echo $subcategory['Subcategory']['subcategory_code'];}?>"/>
          </dd>
          
          <dt><label for="name">Category<span class="required">*</span></label></dt>
          <dd><select name="data[Subcategory][category_id]" id="category_id"  class="validate[required]">
          <option value="">Select Category</option>
          <?php
		  foreach($category as $category){
			  echo '<option value="'.$category['Category']['category_id'].'" '.(isset($subcategory['Subcategory']['category_id']) && $subcategory['Subcategory']['category_id']==$category['Category']['category_id']?'selected="selected"':'').'>'.$category['Category']['category'].'</option>';
		  }
		  ?>
          </select>
          </dd>
          <dt><label for="name">Meta Title<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Subcategory][meta_title]" id="meta_title"  class="validate[required]" size="50" value="<?php if(isset($subcategory['Subcategory']['meta_title'])){ echo $subcategory['Subcategory']['meta_title'];}?>"/></dd>
          <dt><label for="name">Meta Description</label></dt>
          <dd><textarea name="data[Subcategory][meta_description]" cols="50" rows="5" id="meta_description"><?php if(isset($subcategory['Subcategory']['meta_description'])){ echo $subcategory['Subcategory']['meta_description'];}?></textarea></dd>
          <dt><label for="name">Meta Keywords</label></dt>
          <dd><textarea name="data[Subcategory][meta_keywords]" cols="50" rows="5"  id="meta_keywords"><?php if(isset($subcategory['Subcategory']['meta_keywords'])){ echo $subcategory['Subcategory']['meta_keywords'];}?></textarea></dd>
          <dt><label for="name">Status</label></dt>
          <dd><select name="data[Subcategory][status]" id="status">
          <option value="Active" <?php if(isset($subcategory['Subcategory']['status']) && $subcategory['Subcategory']['status']=='Active'){ echo 'selected="selected"';}?> >Active</option>
          <option value="Inactive" <?php if(isset($subcategory['Subcategory']['status']) && $subcategory['Subcategory']['status']=='Inactive'){ echo 'selected="selected"';}?> >Inactive</option>
          </select></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>



