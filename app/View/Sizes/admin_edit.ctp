<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>

<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Size Details'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <?php echo $this->Form->create('Size',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>
    <fieldset>
      <legend><?php echo __('Edit Size');?></legend>
      <dl class="inline">
       
        <dt>
          <label for="category">Category<span class="required">*</span></label>
        </dt>
        <dd>
          <select name="data[Size][category_id]" class="validate[required] category">
            <option value="">Select Category</option>
            <?php 
            
            foreach($category as $category){
            
            echo '<option value="'.$category['Category']['category_id'].'" '.($this->request->data['Size']['category_id']==$category['Category']['category_id']?'selected="selected"':'').' >'.$category['Category']['category'].'</option>';
            
            }
            ?>
          </select>
        </dd>
      <dt>
          <label for="name">Gold Purity<span class="required">*</span></label>
        </dt>
        <dd>
          <select name="data[Size][goldpurity]" class="validate[required]">
            <option value="">Select Gold Purity</option>
            <?php 
                        foreach($purity as $purity){ 
                         echo '<option value="'.$purity['Purity']['purity'].'" '.($this->request->data['Size']['goldpurity']==$purity['Purity']['purity']?'selected="selected"':'').' >'.$purity['Purity']['purity'].'K</option>';
                        
                        } ?>
          </select>
        </dd>
       <!-- <dt>
          <label for="name">Weight<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if(!empty($this->request->data['Size']['weight'])) { echo $this->request->data['Size']['weight']; } else {} ?>"/>
          &nbsp;</dd>-->
        <dt>
          <label for="name">Gold Difference<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][gold_diff]" id="gold_diff"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value="<?php if(!empty($this->request->data['Size']['gold_diff'])) { echo $this->request->data['Size']['gold_diff']; } else {} ?>" />
          &nbsp;</dd>
       <!-- <dt>
          <label for="name">Making Charge<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][making_charge]" id="making_charge"  class="validate[required,custom[integer]]" size="50" onkeypress="return intnumbers(this,event)" maxlength=10   value="<?php if(!empty($this->request->data['Size']['making_charge'])) { echo $this->request->data['Size']['making_charge']; } else {} ?>"/>
          &nbsp; %</dd>
        <dt>
          <label for="name">Height<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][height]" id="height"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if(!empty($this->request->data['Size']['height'])) { echo $this->request->data['Size']['height']; } else { echo '0';} ?>" />
          &nbsp; </dd>
        <dt>
          <label for="name">Width<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][width]" id="width"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if(!empty($this->request->data['Size']['width'])) { echo $this->request->data['Size']['width']; } else { echo '0';} ?>"/>
          &nbsp; </dd>-->
           <?php	
				   			
                     echo $this->Form->input('size',array('div'=>false,'error'=>false,'label' => array('text'=>'Size'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required]','size'=>'50','maxlength'=>'20'));
					   ?>
                       
           <?php
		   $category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('status'=>'Active','category_id'=>$this->request->data['Size']['category_id'],'category'=>'Bangles')));
		   if(!empty($category)){
		   ?>            
           <div class="size_div" style="display:block;">
           <?php }else{?>
         <div class="size_div" style="display:none;">
           <?php }?>  <dt>
          <label for="name">Size Value<span class="required">*</span></label>
        </dt>
        <dd>
          <input type="text" name="data[Size][size_value]" id="size_value"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if (isset($this->request->data['Size']['size_value'])) {
                                        echo $this->request->data['Size']['size_value'];
                                    } ?>"/>
          &nbsp;</dd>
          </div>
          
        <?php           		
                     echo $this->Form->submit(__('Submit'),array('div'=>false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class'=>'button', 'value'=>__('Submit')));
                ?>
      </dl>
    </fieldset>
    <?php echo $this->Form->end(); ?> </div>
</div>
<script>

$(document).ready(function(){
	
	$('.category').on('change',function(){
		var id=$(this).val();
		$.ajax({
		type:"POST",
		url:"<?php echo BASE_URL;?>sizes/size_value/",
		data: 'id='+id,	
		dataType:"html",
		success:function (data){
			if(data!='No') {
				$('.size_div').css('display','block');	
			}else{
				$('.size_div').css('display','none');	
			}
			
		}
			});
		
		});
	
	
});
</script>