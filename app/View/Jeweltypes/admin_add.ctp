<?php
if($type=="Size"){
	$label="Size";$valid=""; $onkeypress=''; $maxlength='';$suffix="";
}elseif($type=="Metals"){
	$label="Metals";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}elseif($type=="Purity"){
	$label="Purity";$valid=",custom[integer]"; $onkeypress='onkeypress="return intnumbers(this,event)"'; $maxlength='maxlength=2';$suffix="K";
}
elseif($type=="Stone"){
	$label="Stone ";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
elseif($type=="Stone Clarity"){
	$label="Stone Clarity ";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
elseif($type=="Stone Color"){
	$label="Stone Color ";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
elseif($type=="Stone Carat"){
	$label="Stone Carat ";$valid=",custom[number]"; $onkeypress='onkeypress="return floatnumbers(this,event)"'; $maxlength='maxlength=9';$suffix="Carat";
}
elseif($type=="Stone Shape"){
	$label="Stone Shape ";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
elseif($type=="Setting Type"){
	$label="Setting Type ";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
elseif($type=="Metal Color"){
	$label="Metal Color";$valid=",custom[onlyLetterSp]"; $onkeypress=''; $maxlength='maxlength=50';$suffix="";
}
?>
<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to '.$type.' List'),array('action'=>'index',$this->params['pass']['0']),array('class'=>'button')); ?></div>
    <form name="Jeweltype" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add <?php echo $type;?></legend>
        <dl class="inline">
        
          <?php if($type=="Size"){ ?>
          <dt><label for="category">Category<span class="required">*</span></label></dt>
           <dd>
          <select name="data[Productsize][category_id]" class="validate[required]">
          <option value="">Select Category</option>
           <?php 
            
            foreach($category as $category){
             
			  if (isset($this->request->data['Productsize']['category_id']) && $this->request->data['Productsize']['category_id'] == $category['Category']['category_id']) {
                                                echo '<option value="' . $category['Category']['category_id'] . '" selected="selected">' . $category['Category']['category'] . '</option>';
                                            } else {
                                                 echo '<option value="'.$category['Category']['category_id'].'" >'.$category['Category']['category'].'</option>';
                                            }
			 
         
            
            }
            ?>
            </select></dd><?php } ?>
            
             <?php if($type=="Metal Color"){ ?>
              <dt><label for="name">Metal<span class="required">*</span></label></dt>
                       <dd>
                        <select name="data[Metalcolor][metals]" class="validate[required]">
                        <option value="">Select Metal</option>
						<?php 
                        foreach($metal as $metal){
                        
						if (isset($this->request->data['Metalcolor']['metals']) && $this->request->data['Metalcolor']['metals'] == $metal['Jeweltype']['type_id']) {
						echo '<option value="' . $metal['Jeweltype']['type_id'] . '" selected="selected">' . $metal['Jeweltype']['name'] . '</option>';
						} else {
						echo '<option value="'.$metal['Jeweltype']['type_id'].'" >'.$metal['Jeweltype']['name'].'</option>';
						} 
                        
                        } ?></select>
                        </dd>
             
             <?php } ?>    
             <dt><label for="name"><?php echo $label;?><span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Jeweltype][name]" id="name"  class="validate[required<?php echo $valid;?>]" size="50" <?php echo $maxlength;?> <?php echo $onkeypress;?>    value="<?php if (isset($this->request->data['Jeweltype']['name'])) {
                                        echo $this->request->data['Jeweltype']['name'];
                                    } ?>" />&nbsp;<?php echo $suffix;?></dd> 
           <?php if($type=="Size"){ ?>
            <dt><label for="name">Gold Purity<span class="required">*</span></label></dt>
                       <dd>
                        <select name="data[Productsize][goldpurity]" class="validate[required]">
                        <option value="">Select Gold Purity</option>
						<?php 
                        foreach($golds as $golds){
                        
						if (isset($this->request->data['Productsize']['goldpurity']) && $this->request->data['Productsize']['goldpurity'] == $golds['Jeweltype']['type_id']) {
						echo '<option value="' . $golds['Jeweltype']['type_id'] . '" selected="selected">' . $golds['Jeweltype']['name'] . '</option>';
						} else {
						echo '<option value="'.$golds['Jeweltype']['type_id'].'" >'.$golds['Jeweltype']['name'].'K</option>';
						} 
                        
                        } ?></select>
                        </dd>
              <dt><label for="name">Weight<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Productsize][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if (isset($this->request->data['Productsize']['weight'])) {
                                        echo $this->request->data['Productsize']['weight'];
                                    } ?>"/>&nbsp;</dd>  
          
           <dt><label for="name">Gold Difference<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Productsize][gold_diff]" id="gold_diff"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value="<?php if (isset($this->request->data['Productsize']['gold_diff'])) {
                                        echo $this->request->data['Productsize']['gold_diff'];
                                    } ?>"/>&nbsp;</dd> 
          
           <dt><label for="name">Making Charge<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Productsize][making_charge]" id="making_charge"  class="validate[required,custom[integer]]" size="50" onkeypress="return intnumbers(this,event)" maxlength=10 value="<?php if (isset($this->request->data['Productsize']['making_charge'])) {
                                        echo $this->request->data['Productsize']['making_charge'];
                                    } ?>"/>&nbsp; %</dd>  
          
           <dt><label for="name">Height<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Productsize][height]" id="height"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value="<?php if (isset($this->request->data['Productsize']['height'])) {
                                        echo $this->request->data['Productsize']['height'];
                                    } ?>" />&nbsp; </dd>  
          
           <dt><label for="name">Width<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[Productsize][width]" id="width"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value="<?php if (isset($this->request->data['Productsize']['width'])) {
                                        echo $this->request->data['Productsize']['width'];
                                    } ?>" />&nbsp; </dd>        
        
           <?php } ?>  
            
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
