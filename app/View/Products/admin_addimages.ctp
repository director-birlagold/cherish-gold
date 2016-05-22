<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Product List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="addimages" id="myForm1" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Images</legend>
        <dl class="inline">
          <dt>
            <label for="name">Vendor Name<span class="required">*</span></label>
          </dt>
          <dd><?php echo $vendor[0]['Vendor']['Company_name'];?></dd>
          <dt>
            <label for="name">Vendor Code<span class="required">*</span></label>
          </dt>
          <dd><?php echo $vendor[0]['Vendor']['vendor_code'];?></dd>
          <dt>
            <label for="name">Product Name<span class="required">*</span></label>
          </dt>
          <dd><?php echo $product['Product']['product_name'];?></dd>
          <dt>
            <label for="name">Vendor Product Name<span class="required">*</span></label>
          </dt>
          <dd><?php echo $product['Product']['vendor_product_code'];?></dd>
          <dt>
            <label for="name">Upload image<span class="required">*</span></label>
          </dt>
          <dd>
            <input name="data[Productimage][image][]" class="validate[required,custom[image]]" id="image0" multiple type="file">
          </dd>
          <dt>&nbsp;</dt>
          <dd><strong>(Please Upload Image size 480 x 385)</strong></dd>
          <div class="buttons" >
            <input type="submit" class="button" id="submit_btn" value="Save" />
          </div>
        </dl>
      </fieldset>
    </form>
    <?php echo $this->Form->create('', array('Controller'=>'products','action' => 'deleteimages/'.$this->params['pass']['0'],'id'=>'myForm')); ?>
    <fieldset style="padding:20px 0;">
      <legend>Images</legend>
      <label style="margin-left:20px">
        <input type="checkbox" id="checkAllAuto" name="action[]" value="0"  class="validate[minCheckbox[1]] checkbox" rel="action" />
        Select All</label>
      <div style="float:left; width:100%;">
        <ul id="gallery" style="padding:10px 0;">
          <?php
            if(!empty($images)) { 
            foreach($images as $image){?>
          <li style="position:relative;margin:15px 8px;min-height:130px;width:175px;">
            <div><?php echo $this->Html->image('product/small/'.$image['Productimage']['imagename'],array('class'=>'img','width'=>'170','height'=>'120px'));?></div>
            <div style="margin:10px 0">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="center"><input type="checkbox" name="action[]" value="<?php echo $image['Productimage']['image_id']; ?>" rel="action" /></td>
                  <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'deleteimages',$this->params['pass']['0'],$image['Productimage']['image_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete') ));?></td>
                </tr>
              </table>
            </div>
          </li>
		<?php }
        } else{?>
        <li style="width:100%;text-align:center;color:#F00;" > NO IMAGE FOUND</li>
        <?php }?>
       </ul>
      </div>
      <div class="tablefooter clearfix">
        <div class="actions">
          <input type="submit" id="action_btn" class="button" value="Delete" />
        </div>
      </div>
    </fieldset>
    <?php echo $this->Form->end(); ?> </div>
</div>
<style>
#gallery li {
    float: left;
    padding: 0 10px;
}
</style>
