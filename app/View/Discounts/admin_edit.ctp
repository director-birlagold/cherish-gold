<?php echo $this->Html->script(array('ckeditor/ckeditor'));
//print_r($discount);exit;
?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Discount Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
            <form  name="Discount" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Edit Discount');?></legend>
                 <dl class="inline">
						 <dt><label for="name">Type </label></dt>
                            <dd><p><?php echo $discount['Discount']['type'];?></p></dd>
                            
                               <?php // if( $discount['Discount']['type']=='Vouchercode'){?> 
                           <dt ><label for="name">Voucher Code<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][voucher_code]" id="voucher_code"   class="validate[required]" size="50" 
                           value="<?php echo $discount['Discount']['voucher_code']?>"  /></dd>
                           <?php // }?>  
                                 <?php if( $discount['Discount']['type']=='Product'){?> 
                             
                             
                            <dt ><label for="name">Product<span class="required">*</span></label></dt>     
                           <dd>
                                <select  style="width:300px;height:100px;" name="productname[]" id="product_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">Product</option>
                                    <?php
									$productid=explode(",",$discount['Discount']['product_id']);
                                    foreach ($products as $products) {
	
										//echo "<option value='".$products['Product']['product_id']."'>".$products['Product']['product_name']."</option>";
										echo "<option value='" . $products['Product']['product_id']. "' " . (in_array($products['Product']['product_id'],$productid) ? 'selected="selected"' : '') . ">" .$products['Product']['product_name'] . "</option>";
                                    }
                                    ?>
                                </select>         
                            </dd>
                           
                            <?php }?> 
                             <?php if( $discount['Discount']['type']=='User'){?>  
                           
                            <dt ><label for="name">User<span class="required">*</span></label></dt>
                            <dd>
                                <select  style="width:300px;height:100px;" name="username[]" id="user_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">User</option>
                                    <?php
									$useid=explode(",",$discount['Discount']['user_id']);
                                    foreach ($users as $users) {
	
										
										
										/*echo "<option value='" . $users['User']['user_id']. "' " . ($users['User']['user_id']==$discount['Discount']['user_id'] ? 'selected="selected"' : '') . ">" .$users['User']['first_name'].' '.$users['User']['last_name'] . "</option>";
										*/
										echo "<option value='" . $users['User']['user_id']. "' " . (in_array($users['User']['user_id'],$useid) ? 'selected="selected"' : '') . ">" .$users['User']['first_name'].' '.$users['User']['last_name'] . "</option>";
										
                                    }
                                    ?>
                                </select>         
                            </dd>
                             <?php }?> 
                               
                                 <?php if( $discount['Discount']['type']=='Category'){?> 
                             
                             
                            <dt ><label for="name">Category<span class="required">*</span></label></dt>     
                           <dd>
                                <select  style="width:300px;height:100px;" name="category[]" id="category_id" class="validate[required]"  multiple="multiple"  >

                                    <option value="">Category</option>
                                    <?php
									$categoryid=explode(",",$discount['Discount']['category_id']);
                                    foreach ($category as $category) {
	
										//echo "<option value='".$products['Product']['product_id']."'>".$products['Product']['product_name']."</option>";
										echo "<option value='" . $category['Category']['category_id']. "' " . (in_array($category['Category']['category_id'],$categoryid) ? 'selected="selected"' : '') . ">" .$category['Category']['category'] . "</option>";
                                    }
                                    ?>
                                </select>         
                            </dd>
                           
                            <?php }?> 
                             
                             
                                <dt><label for="name">Select Percentage / Amount <span class="required">*</span></label></dt>     
                           <dd>
                           <select name="data[Discount][per_amou]" id="per_amou" onchange="span_display(this.value)">
                           <option value="1" <?php if($discount['Discount']['per_amou']==1){ echo "selected";}?>>Percentage</option>
                           <option value="2" <?php if($discount['Discount']['per_amou']==2){ echo "selected";}?>>Amount</option>                           
                           </select>
                          </dd>
                             
                            <dt><label for="name">Discount<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][percentage]" id="percentage"  onkeypress="return floatnumbers(this,event)" maxlength="5" class="validate[required]" 
                           size="50"  value="<?php echo $discount['Discount']['percentage']?>" / ><span id="discount_span" style="display:<?php if($discount['Discount']['per_amou']==1){ echo "block";} else { echo "none";}?>"> &nbsp;&nbsp;% </span><span id="amount_span" style="display:<?php if($discount['Discount']['per_amou']==2){ echo "block";} else { echo "none";}?>">&nbsp;&nbsp;Rs </span></dd>
                              <dt><label for="name">Start Date<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][start_date]" id="startdate"   class="validate[required]" size="50" value="<?php echo date("d-m-Y", strtotime($discount['Discount']['start_date']));?>"  /></dd>
                             <dt><label for="name">End Date<span class="required">*</span></label></dt>     
                           <dd><input type="text" name="data[Discount][expired_date]" id="expireddate"   class="validate[required]" size="50"  value="<?php echo date("d-m-Y", strtotime($discount['Discount']['expired_date']));?>"  /></dd>
                           
                            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
      </form>
    </div>
</div>
<script type="text/javascript">
$(function() {
	$( "#startdate" ).datepicker({ dateFormat: 'dd-mm-yy'  ,minDate: 0});
	$( "#expireddate" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: 0 });
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
function span_display(val)
{
if(val==1)
{
	$('#discount_span').css('display','block');
	$('#amount_span').css('display','none');
}
else
{
	$('#amount_span').css('display','block');
	$('#discount_span').css('display','none');	
}
}
</script>
<!--<script>
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
		}if($(this).val()=='Product') {
			$('.product').show();
			$('.code').hide();
			$('.user').hide();
			
		}
		if($(this).val()=='User') {
			$('.user').show();
			$('.product').hide();
			$('.code').hide();
			
		}
		
	});
	
});

</script>-->




