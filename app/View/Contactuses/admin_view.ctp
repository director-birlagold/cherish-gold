<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<?php //print_r($member);exit;?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back '),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Contactus',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('View Contact Details');?></legend>
                
                     <dl class="inline">
                                           
                            <dt><label for="name"> Type</label></dt>
                         <dd><p><?php $type=h($contact['Contactus']['type']); 
						if(!empty($type))echo $type;else'-';
						 
						   ?></p></dd>                
                                           
                         <dt><label for="name"> Name</label></dt>
                         <dd><p><?php $firstname=h($contact['Contactus']['name']); if(!empty($firstname))echo $firstname; else '-';  ?></p></dd>
                        
                         <dt><label for="name">Email</label></dt>
                          <dd><p><?php echo h($contact['Contactus']['email']); ?></p></dd>
                         
                         <dt><label for="name">phone</label></dt>
                          <dd><p><?php $phone= h($contact['Contactus']['mobile']); if(!empty($phone)) echo $phone; else echo '-';  ?></p></dd>
                         
                          <dt><label for="name">City</label></dt>
                          <dd><p><?php $city= h($contact['Contactus']['city']); if(!empty($city)) echo $city; else echo '-';  ?></p></dd>      
                        
                  
                         <dt><label for="name">Message</label></dt>
                         <dd><p><?php echo h($contact['Contactus']['query']); ?></p></dd> 
                       
                            <dt><label for="name">Created date</label></dt>
                         <dd><p><?php echo h($contact['Contactus']['created_date']); ?></p></dd> 
                          <?php if($contact['Contactus']['reply']=='0'){?>
                          <dt><label for="name">&nbsp;</label></dt>
                          <dd><input name="submit" type="button" class="button" value="Reply" id="replybutton" /></dd> 
                           <?php }?> 
                         </dl>  
                         </fieldset>
        <?php if($contact['Contactus']['reply']=='0'){?>
    <div class="replydiv" style="display:none;">  
     <fieldset>
	<legend>Reply</legend>
    <dl class="inline">
    <dt><label for="name">E-mail</label></dt>
    <dd><input type="text" name="data[Contactus][email]" id="email" size="30" value="<?php  echo $contact['Contactus']['email'];?>" readonly="readonly"/></dd>
     <dt><label for="name">Subject</label></dt>
    <dd><input type="text" name="data[Contactus][replysubject]" maxlength="25" size="30" id="replysubject" class="validate[required]" value=""/></dd>
    <dt><label for="name">Reply Message</label></dt>
    <dd><textarea rows="10" cols="60" name="data[Contactus][replymessage]" class="validate[required] ckeditor"  id="message"></textarea></dd>
    <dt><label for="name">&nbsp;</label></dt>
    <dd><input name="submit" type="submit" class="button" value="Submit" id="submit_btn" />&nbsp;<input name="cancel" type="button" class="button white" value="Cancel" id="cancel" /></dd> 
    </dl>      
    </fieldset>    
    </div> 
    <?php }else{?>   
     <fieldset>
	<legend>Reply</legend>
    <dl class="inline">
    <dt><label for="name">E-mail</label></dt>
    <dd><p><?php  echo $contact['Contactus']['email'];?></p></dd>
     <dt><label for="name">Subject</label></dt>
    <dd><p><?php  echo $contact['Contactus']['replysubject'];?></p></dd>
    <dt><label for="name" class="validate[required] text-input ckeditor">Reply Message</label></dt>
    <dd><p><?php echo $contact['Contactus']['replymessage'];?></p></dd> 
     <dt><label for="name">Reply Date</label></dt>
    <dd><p><?php echo $contact['Contactus']['replydate'];?></p></dd>    
    </dl>      
    </fieldset>
   
    <?php }?> 


       <?php echo $this->Form->end(); ?>
    </div>
</div></div></div>

<script type="text/javascript">
$('#replybutton').live('click',function(){
	$('.replydiv').show();
	$('#replybutton').hide();
});
$('#cancel').live('click',function(){
	$('.replydiv').hide();
	$('#replybutton').show();
});

</script>
