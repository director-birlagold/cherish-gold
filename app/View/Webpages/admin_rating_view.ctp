
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back '),array('action'=>'rating_list'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('webpages',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('View Rating Details');?></legend>
                
                     <dl class="inline">
                                           
                         <dt><label for="name"> Name</label></dt>
                         <dd><p><?php $firstname=h($rating['Rating']['name']); if(!empty($firstname))echo $firstname; else '-';  ?></p></dd>
                         
                         <dt><label for="name">Product Name</label></dt>
                         <dd><p><?php echo h($product['Product']['product_name']); ?></p></dd> 
                         
                          <dt><label for="name">Title</label></dt>
                          <dd><p><?php echo h($rating['Rating']['title']); ?></p></dd>
                        
                         <dt><label for="name">Email</label></dt>
                          <dd><p><?php echo h($rating['Rating']['email']); ?></p></dd>
                         
                         <dt><label for="name">phone</label></dt>
                          <dd><p><?php $phone= h($rating['Rating']['mobile']); if(!empty($phone)) echo $phone; else echo '-';  ?></p></dd>
                         
                          <dt><label for="name">Message</label></dt>
                         <dd><p><?php echo h($rating['Rating']['comments']); ?></p></dd> 
                       
                            <dt><label for="name">Rating</label></dt>
                         <dd><p><?php echo h($rating['Rating']['rate']); ?> Star</p></dd> 
                         
                           <dt><label for="name">Created Date</label></dt>
                         <dd><p><?php echo h($rating['Rating']['created_date']); ?></p></dd> 
                         
                         </fieldset>
   
   
    </div>
</div></div></div>


</script>
