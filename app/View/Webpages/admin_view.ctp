
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back '),array('action'=>'question'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('webpages',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('View Question Details');?></legend>
                
                     <dl class="inline">
                                           
                         <dt><label for="name"> Name</label></dt>
                         <dd><p><?php $firstname=h($question['Question']['name']); if(!empty($firstname))echo $firstname; else '-';  ?></p></dd>
                         
                         <dt><label for="name">Product Name</label></dt>
                         <dd><p><?php echo h($product['Product']['product_name']); ?></p></dd> 
                        
                         <dt><label for="name">Email</label></dt>
                          <dd><p><?php echo h($question['Question']['email']); ?></p></dd>
                         
                         <dt><label for="name">phone</label></dt>
                          <dd><p><?php $phone= h($question['Question']['contact_no']); if(!empty($phone)) echo $phone; else echo '-';  ?></p></dd>
                         
                          <dt><label for="name">Message</label></dt>
                         <dd><p><?php echo h($question['Question']['question']); ?></p></dd> 
                       
                            <dt><label for="name">Created date</label></dt>
                         <dd><p><?php echo h($question['Question']['created_date']); ?></p></dd> 
                         
                         </fieldset>
   
   
    </div>
</div></div></div>


</script>
