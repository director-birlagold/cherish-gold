
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Ads Banner List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="advertisement" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Advertisement Banner</legend>
        <dl class="inline">
          <?php echo $this->Form->input('title',array('div'=>false,'error'=>false,'name'=>'data[Advertisement][title]','label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50')); 
           echo $this->Form->input('link',array('div'=>false,'error'=>false,'name'=>'data[Advertisement][link]','label' => array('text'=>'Link'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[url]]','size'=>'50')); ?>
          <dt><label for="name">Image<span class="required">*</span></label></dt>
          <dd><input type="file" name="data[Advertisement][images]" id="category"  class="validate[required,custom[image]]" /> </dd>
          <dt><label>&nbsp;</label></dt><dd><p><strong>Upload image size 546 x 226</strong></p></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
