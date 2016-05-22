<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Manager List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Manager" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Manager</legend>
        <dl class="inline">
         <dt><label for="name">Manager Name<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[RelationshipManager][manager_name]" id="manager_name"  class="validate[required]" size="50" value="<?php if(isset($relation['RelationshipManager']['manager_name'])){ echo $relation['RelationshipManager']['manager_name'];}?>"/></dd>
          <dt><label for="name">Manager Email<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[RelationshipManager][manager_email]" id="manager_email"  class="validate[required]" size="50" value="<?php if(isset($relation['RelationshipManager']['manager_email'])){ echo $relation['RelationshipManager']['manager_email'];}?>"/></dd>
          <dt><label for="name">Manager Mobile<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[RelationshipManager][manager_mobile]" id="manager_mobile"  class="validate[required]" size="50" value="<?php if(isset($relation['RelationshipManager']['manager_mobile'])){ echo $relation['RelationshipManager']['manager_mobile'];}?>"/></dd>
          <dt><label for="name">Manager Phone<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[RelationshipManager][manager_phone]"  class="validate[required]" size="50" id="manager_phone" value="<?php if(isset($relation['RelationshipManager']['manager_phone'])){ echo $relation['RelationshipManager']['manager_phone']; } ?>"/></dd>
          <dt><label for="name">Manager Address</label></dt>
          <dd><textarea name="data[RelationshipManager][manager_address]" cols="50" rows="5"  id="manager_address"><?php if(isset($relation['RelationshipManager']['manager_address'])){ echo $relation['RelationshipManager']['manager_address'];}?></textarea></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>