<?php  echo $this->Html->script(array('ckeditor/ckeditor')); ?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Locateus Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        <?php  //pr($locateus);exit;?>
            <form  name="Discount" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Edit Locateus');?></legend>
                 <dl class="inline">
					                         
                          <dt><label for="name">Name<span class="required">*</span></label></dt>     
                         <dd> <input type="text" name="data[Locateus][name]" id="name"   class="validate[required]" 	size="50" value="<?php echo $locateus['Locateus']['name']?>"/></dd>
                          <dt><label for="name">Address <span class="required">*</span></label></dt>     
                         <dd><textarea  name="data[Locateus][address]" id="address"   class="validate[required]" style="width:272px;height:75px;"><?php echo $locateus['Locateus']['address']?>  </textarea></dd>
                           <div class="contact-list">
                          <dt><label for="name">State<span class="required">*</span></label></dt>     
                         <dd><?php  echo $this->Form->input('',array('div'=>false,'error'=>false,'class'=>'validate[required] state_type','name'=>'data[Locateus][state]','options'=>$state,'empty'=>'Select State','default'=>$locateus['Locateus']['state'])); 	
					 	 
        ?> </dd></div>
         <div class="contact-list">
         <dt><label for="name">City<span class="required">*</span></label></dt>     
                         <dd> <?php  
						 $city= ClassRegistry::init('Cities')->find('list',array('conditions'=>array('state_id'=>$locateus['Locateus']['state']),'fields'=>array('city_id','city')));?>    <div class="city_type"> 
                         <?php 
						 echo $this->Form->input('',array('div'=>false,'error'=>false,'class'=>'validate[required] city_type','name'=>'data[Locateus][city]','options'=>$city,'empty'=>'Select City','default'=>$locateus['Locateus']['city'])); 		 
        ?></div></dd></div>
        
                         <dt><label for="name">Pincode<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Locateus][pincode]" id="pincode" onkeypress="return intnumbers(this, event)" maxlength="6"  
                            class="validate[required,custom[integer],minSize[6]]" size="50"  value="<?php echo $locateus['Locateus']['pincode']?>"/></dd>
                          <dt><label for="name">Email ID<span class="required">*</span></label></dt>                                               
                          <dd><input type="text" name="data[Locateus][email]" class="validate[required,custom[email]]" id="email" size="50" value="<?php echo $locateus['Locateus']['email']?>"/> 
                           <dt><label for="name">Phone<span class="required">*</span></label></dt>                                               
                          <dd>
                          <textarea  name="data[Locateus][phone]" id="phone"   class="validate[required]" style="width:272px;height:75px;"><?php echo $locateus['Locateus']['phone']?>    </textarea>
                          </dd><dt></dt>
                          <dd><strong>more than one phone number seperate by comma </strong></dd>
                          
                          <dt><label for="name">Fax<span class="required">*</span></label></dt>                                               
                          <dd>
                           <textarea  name="data[Locateus][fax]" id="fax"   class="validate[required]" style="width:272px;height:75px;"><?php echo $locateus['Locateus']['fax']?>  </textarea>
                         </dd>
                           <dt></dt>
                          <dd><strong>more than one fax number seperate by comma </strong></dd>                                                                  
                 <?php echo $this->Form->submit(__('Submit'),array('div' => false,'before'=>'<div class="buttons">','after' =>'</div>','class' =>'button','name'=>'submit', 'value' => __('Submit'))); ?>
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

</script>
<script>
$(document).ready(function(){
	$('.state_type').on("change",function(){
		var id=$(this).val();
		//alert(id);
		$.ajax({
		type: "POST",
		url: "<?php echo BASE_URL; ?>locateus/register_state/",
		data: 'id='+id,
	    dataType: 'json',
		success: function (data) {
			 appenddata = "<select name='data[Locateus][city]' class='input-md'><option value=''>Select City</option>";
                        $.each(data, function (k, v) {
                            appenddata += "<option value = '" +v.Cities.city_id + "' '>" +v.Cities.city + " </option>";
                        });
                        appenddata += "</select>";
                        $('.city_type').html(appenddata);
					 //$('.city_type').parents('.contact-list').html('Select City');
                      
          }
		});
		
	});
});

</script>