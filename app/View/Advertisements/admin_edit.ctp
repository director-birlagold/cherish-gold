<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Ads Banner List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="advertisement" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Edit Advertisement Banner</legend>
        <dl class="inline">
         <?php $adetails=ClassRegistry::init('Advertisementdetails')->find('first',array('conditions'=>array('ads_id'=>$this->params['pass']['0']))); ?>
          
		 <?php echo $this->Form->input('title',array('div'=>false,'error'=>false,'name'=>"data[Advertisement][title]",'label' => array('text'=>'Title'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>','value'=>$this->request->data['Advertisement']['title'], 'class'=>'validate[required]','size'=>'50')); ?>
         <?php if($this->params['pass']['0']==3 || $this->params['pass']['0']==4 ) { 
		
		  $image=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>$this->params['pass']['0']))); ?>
          <dt><label for="name">Image</label></dt>
          <dd><input type="file" name="data[Advertisement][images]" id="category"  class="validate[custom[image]]"/> </dd>
          <dt></dt><dd><?php echo $this->Html->image('advertisement/'.$image['Advertisement']['images'],array('width'=>'200'));?></dd>
      
          <?php
		  if($image['Advertisement']['ads_id']==3){	
		  $adetails=ClassRegistry::init('Advertisementdetails')->find('all',array('conditions'=>array('ads_id'=>$this->params['pass']['0']),'order'=>'advertisement_id ASC')); 
		 
		  if(!empty($adetails[0])){
			  $id0=$adetails[0]['Advertisementdetails']['advertisement_id'];
			  $type0=$adetails[0]['Advertisementdetails']['type'];
			  $title0=$adetails[0]['Advertisementdetails']['video'];
			  $link0=$adetails[0]['Advertisementdetails']['values'];
		  }else{
			  $id0='';
			  $type0='';
			  $title0='';
			  $link0='';
			  $image0='';
		  }
		  if(!empty($adetails[1])){
			  $id1=$adetails[1]['Advertisementdetails']['advertisement_id'];
			  $type1=$adetails[1]['Advertisementdetails']['type'];
			  $title1=$adetails[1]['Advertisementdetails']['video'];
			  $link1=$adetails[1]['Advertisementdetails']['values'];
		  }else{
			  $id1='';
			  $type1='';
			  $title1='';
			  $link1='';
			  $image1='';
		  }
          ?>
          <dt><label for="name">Type </label></dt>
		  <dd><input type="radio" id="checklist" name="data[Advertisementdetails][0][type]" value="Link"  class="validate[] radio yes1" <?php echo ($type0=="Link"?'checked="checked"':'');?>  <?php echo ($type0==""?'checked="checked"':'');?> />Youtube Link&nbsp;&nbsp;
			  <input type="radio" id="checklist" name="data[Advertisementdetails][0][type]" value="File"  class="validate[] radio no1" <?php echo ($type0=="File"?'checked="checked"':'');?> />File &nbsp;&nbsp;&nbsp;<?php if($id0!=''){?><a class="remove_type" rel="<?php echo $id0;?>" style="cursor:pointer">Remove</a><?php }?></dd>
              <?php
			  if($id0!=""){
				  ?>
                  <input type="hidden" name="data[Advertisementdetails][0][advertisement_id]" value="<?php echo $id0;?>"/>
                  <?php
			  }
			  ?>
                 <dt><label for="name">Title</label></dt>  
                    <dd><input type="text" name="data[Advertisementdetails][0][video]"  id="video0" size="50" class="validate[]" value="<?php echo $title0;?>"/></dd>  
                <div class="link1" <?php if(!empty($type0)){ if($type0=="File"){ echo 'style="display:none"';}}?> >                  
                    <dt><label for="name">Link</label></dt>  
                    <dd><input type="text" name="data[Advertisementdetails][0][link]"  id="link0" size="50" class="validate[custom[url]]" value="<?php echo $link0;?>"/></dd>
                </div>
				<div class="pdf1" <?php if(!empty($type0)){ if($type0=="Link"){ echo 'style="display:none"';}}else{ echo 'style="display:none"';}?>>
                    <dt><label for="name">PDF/PPT</label></dt>  
                    <dd><input type="file" name="data[Advertisementdetails][0][image]"  id="file0" size="50" class="validate[custom[pdf_ppt]] " /></dd>
                   <?php if($type0=="File"){?> <dt><label></label></dt><dd><a href="<?php echo BASE_URL;?>img/advertisement/<?php echo $link0;?>" target="_blank">Link</a></dd><?php }?>                  
				</div>
                 <?php
			  if($id1!=""){
				  ?>
                  <input type="hidden" name="data[Advertisementdetails][1][advertisement_id]" value="<?php echo $id1;?>"/>
                  <?php
			  }
			  ?>
            <dt><label for="name">Type </label></dt>
			<dd><input type="radio" id="checklist" name="data[Advertisementdetails][1][type]" value="Link"  class="validate[] radio yes2"  <?php echo ($type1=="Link"?'checked="checked"':'');?> <?php echo ($type1==""?'checked="checked"':'');?> />Youtube Link&nbsp;&nbsp;
				 <input type="radio" id="checklist"  name="data[Advertisementdetails][1][type]" value="File"  class="validate[] radio no2" <?php echo ($type1=="File"?'checked="checked"':'');?>/>File &nbsp;&nbsp;&nbsp;<?php if($id1!=''){?><a class="remove_type" rel="<?php echo $id1;?>" style="cursor:pointer">Remove</a><?php }?></dd>
                 <dt><label for="name">Title</label></dt>  
                 <dd><input type="text" name="data[Advertisementdetails][1][video]"  id="video1" size="50" class="validate[]" value="<?php echo $title1;?>"/></dd>  
                <div class="link2" <?php if(!empty($type1)){ if($type1=="File"){ echo 'style="display:none"';}}?>>                  
                    <dt><label for="name">Link</label></dt>  
                    <dd><input type="text" name="data[Advertisementdetails][1][link]"  id="link1" size="50" class="validate[custom[url]]" value="<?php echo $link1;?>"/></dd>
                </div>
				<div class="pdf2" <?php if(!empty($type1)){ if($type1=="Link"){ echo 'style="display:none"';}}else{ echo 'style="display:none"';}?> >
                    <dt><label for="name">PDF/PPT</label></dt>  
                    <dd><input type="file" name="data[Advertisementdetails][1][image]"  id="file1" size="50" class="validate[custom[pdf_ppt]]" /></dd> 
                    <?php if($type1=="File"){?> <dt><label></label></dt><dd><a href="<?php echo BASE_URL;?>img/advertisement/<?php echo $link1;?>" target="_blank">Link</a></dd><?php }?>                  
				</div>
          <?php
		  }
		  ?>
            <?php  } ?>
           <?php $image=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>$this->params['pass']['0'])));
		  if($image['Advertisement']['ads_id']==2){
		   ?>
          <?php echo $this->Form->input('link',array('div'=>false,'error'=>false,'name'=>"data[Advertisementdetails][values]",'label' => array('text'=>'Link'.'<span class="required">*</span>'), 'before' => '<dt>', 'after' => '</dd>', 'between' => '</dt><dd>', 'class'=>'validate[required,custom[url]]','size'=>'50','value'=>$adetails['Advertisementdetails']['values'])); ?>
           <dt><label for="name">Image</label></dt>
          <dd><input type="file" name="data[Advertisement][images]" id="category"  class="validate[custom[image]]"/> </dd>
          <dt></dt><dd><?php echo $this->Html->image('advertisement/'.$image['Advertisement']['images'],array('width'=>'200'));?></dd>
          
          <?php } ?>
          <?php $image=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>$this->params['pass']['0'])));
		  if($image['Advertisement']['ads_id']==1){
		   ?>
          <dt><label for="name">Image</label></dt>
          <dd><input type="file" name="data[Advertisementdetails][image][]" id="category"  class="validate[custom[image]]" multiple /> </dd>
           <dt><label>&nbsp;</label></dt><dd><p><strong>Upload image size 546 x 226</strong></p></dd>
          <dt><label for="name">&nbsp;</label></dt>
          <dd><strong>( Please click images while a press of Ctrl key ) </strong></dd>
          <?php } ?>
        <!--  <dt><label for="name">Status<span class="required">*</span></label></dt>
          <dd><select name="data[Advertisement][status]" id="status">
          <option value="Active" <?php //echo  $this->request->data['Advertisement']['status']=='Active'?'selected="selected"':'';?>>Active</option>
          <option value="Inactive" <?php //echo  $this->request->data['Advertisement']['status']=='Inactive'?'selected="selected"':'';?>>Inactive</option>
          </select>
          </dd>-->
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
  
    <?php $image=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>$this->params['pass']['0'])));
		  if($image['Advertisement']['ads_id']==1){
		   ?>
  <?php echo $this->Form->create('', array('Controller'=>'advertisements','action' => 'deleteimages/'.$this->params['pass']['0'],'id'=>'myForm')); ?>
    <fieldset style="padding:20px 0;">
      <legend>Images</legend>
      <label style="margin-left:20px">
     
      <div style="float:left; width:100%;">
        <ul id="gallery" style="padding:10px 0;">
          <?php
            if(!empty($images)) { 
            foreach($images as $image){ ?>
          <li style="position:relative;margin:15px 8px;min-height:130px;width:175px; display: inline; float: left;">
            <div><?php echo $this->Html->image('advertisement/small/'.$image['Advertisementdetails']['values'],array('class'=>'img','width'=>'170','height'=>'120px'));?></div>
            <div style="margin:10px 0">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
             <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'deleteimages',$this->params['pass']['0'],$image['Advertisementdetails']['advertisement_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete') ));?></td>
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
       <!-- <div class="actions">
          <input type="submit" id="action_btn" class="button" value="Delete" />
        </div>-->
      </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
    <?php } ?>
</div>
<!-- <script>
        $(document).ready(function() {
			$('.add').live('click',function(){
				var values=parseInt($('#add_link').val())+1;
				$('.link').append('<div class="linknew"><dt><label for="name">Video Title<span class="required">*</span></label></dt> <dd><input type="text" name="data[Advertisementdetails][title]['+values+']"  id="video'+values+'" size="50" class="validate[required]" /></dd><dt><label for="name">Link</label></dt> </dt><dd><input type="text" name="data[Advertisementdetails][link]['+values+']" id="link'+values+'" size="50" "class"="validate[required,custom[url]]" /><a class="remove_weight"> Remove </a></dd></div>');
				$('#add_link').val(values);
				 $('.linknew input').uniform();  
			});
		});
 $('.remove_weight').live('click',function(e){	
			$(this).parents('.linknew').remove();			
}); 
  </script>
   <script>
        $(document).ready(function() {
			$('.add_pdf').live('click',function(){
				var values=parseInt($('#add_file').val())+1;
				$('.pdf').append('<div class="filenew"><dt><label for="name">PDF/PPT</label></dt> </dt><dd id="file'+values+'"><input type="file" name="data[Advertisementdetails][file]['+values+']"  id="file'+values+'" size="50" class="file" "class"="validate[required]"/><a class="remove_file"> Remove </a></dd></div>');
				$('#add_file').val(values);
				 $('#file'+values+' input').uniform();  
			});
		});
 $('.remove_file').live('click',function(e){	
			$(this).parents('.filenew').remove();			
}); 
  </script>-->
  <script>
   $(document).ready(function() {
	   $('.yes').live('click',function(){
		   thisvar=$(this);
		   thisvar.parents('dd').next('div').show();
		   thisvar.parents('dd').next('div').next('div').hide(); 
	   });
	   $('.no').live('click',function(){
		  thisvar=$(this);
		  thisvar.parents('dd').next('div').hide(); 
		  thisvar.parents('dd').next('div').next('div').show();
		  
	   });
	   
   });
  
  
  </script>
  
    <script>
   $(document).ready(function() {
	   $('.yes1').live('click',function(){
		   $('.link1').show();
		    $('#link0').val('');
		    $('.pdf1').hide();
 
	   });
	   $('.no1').live('click',function(){
		 $('.link1').hide();
		  $('.pdf1').show();

	   });
	    $('.yes2').live('click',function(){
		   $('.link2').show();
		      $('#link1').val('');
		    $('.pdf2').hide();
 
	   });
	   $('.no2').live('click',function(){
		 $('.link2').hide();
		  $('.pdf2').show();

	   });
	   
	   $('.remove_type').live('click',function(){
		   relid=$(this).attr('rel');
		   if(confirm('Are you sure want to delete this record?')){
			   window.location="../deletead/"+relid+"/<?php echo $this->params['pass']['0'];?>";
		   }
	   });
	   
   });
  


  </script>
 