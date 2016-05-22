<?php echo $this->Html->script(array('ckeditor/ckeditor'));
//pr($category);exit;
?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Discount Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
            <form  name="Discount" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Add Discount');?></legend>
                 <dl class="inline">
						 <dt><label for="name">Type </label></dt>
                            <dd><input type="radio" id="type" class="yes" name="data[Discount][type]" value="Vouchercode" checked="checked" />Voucher Code&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="type" class="yes" name="data[Discount][type]" value="Product" />Product&nbsp;&nbsp;&nbsp;
                                 <input type="radio" id="type" class="yes" name="data[Discount][type]" value="User" />User&nbsp;&nbsp;&nbsp;
                                   <input type="radio" id="type" class="yes" name="data[Discount][type]" value="Category" />Category&nbsp;&nbsp;&nbsp;
                                 
                                 </dd>
                              <div class="code" style="display:block;">   
                            <dt ><label for="name">Voucher Code<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][voucher_code]" id="voucher_code"   class="validate[required]" size="50"  /></dd>
                             </div>    
                             <div  class="product" style="display:none;">
                            <dt ><label for="name">Product<span class="required">*</span></label></dt>     
                           <dd>
                                <select  style="width:300px;height:100px;" name="productname[]" id="product_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">Product</option>
                                    <?php
                                    foreach ($products as $products) {
	
										echo "<option value='".$products['Product']['product_id']."'>".$products['Product']['product_name']."</option>";
                                    }
                                    ?>
                                </select>         
                            </dd>
                            </div>
                            <div class="user" style="display:none;">
                            <dt ><label for="name">User<span class="required">*</span></label></dt>
                            <dd>
                                <select  style="width:300px;height:100px;" name="username[]" id="user_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">User</option>
                                    <?php
                                    foreach ($users as $users) {
	
										echo "<option value='".$users['User']['user_id']."'>".$users['User']['first_name'].' '.$users['User']['last_name']."</option>";
                                    }
                                    ?>
                                </select>         
                            </dd>
                            </div>
                             <div  class="category" style="display:none;">
                            <dt ><label for="name">Category<span class="required">*</span></label></dt>     
                           <dd>
                                <select  style="width:300px;height:100px;" name="category[]" id="category_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">Category</option>
                                    <?php
                                    foreach ($category as $category) {
	
										echo "<option value='".$category['Category']['category_id']."'>".$category['Category']['category']."</option>";
                                    }
                                    ?>
                                </select>         
                            </dd>
                            </div>
                            
                            
                            <dt><label for="name">Percentage (%)<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][percentage]" id="percentage"  onkeypress="return floatnumbers(this,event)" maxlength="5" class="validate[required]" 
                           size="50"  /></dd>
                              <dt><label for="name">Start Date<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][start_date]" id="startdate"   class="validate[required]" size="50"  /></dd>
                             <dt><label for="name">End Date<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][expired_date]" id="expireddate"   class="validate[required]" size="50"  /></dd>
                           
                            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
      </form>
    </div>
</div>
<script type="text/javascript">
$(function() {
	$( "#startdate" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#expireddate" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
$(function(){
  $.uniform.restore("#user_id");
});
$(function(){
  $.uniform.restore("#product_id");
});
$(function(){
  $.uniform.restore("#category_id");
});
</script>
<script>
$(document).ready(function() {
  if($(".yes").is(':checked'))
  	if($(this).val()=='Vouchercode') {
    $('.code').show();
	}
   
	$('.yes').click(function(){
		if($(this).val()=='Vouchercode') {
			$('.code').show();
			$('.product').hide();
			$('.user').hide();
			$('.category').hide();
		}if($(this).val()=='Product') {
			$('.product').show();
			$('.code').hide();
			$('.user').hide();
			$('.category').hide();
			
		}
		if($(this).val()=='User') {
			$('.user').show();
			$('.product').hide();
			$('.code').hide();
			$('.category').hide();
			
		}
		if($(this).val()=='Category') {
			$('.category').show();
			$('.user').hide();
			$('.product').hide();
			$('.code').hide();
			
		}
		
	});
	
});

</script>




