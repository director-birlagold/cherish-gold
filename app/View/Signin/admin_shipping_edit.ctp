
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;"><?php echo $this->Html->link('Back to User',array('action'=>'index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
         <?php echo $this->Form->create('User',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>    
      <?php foreach($this->request->data as $ship) { ?>
	  <fieldset>
        <legend><?php if($ship['Shipping']['default'] == 1) { echo "Default"; } ?> Shipping Details</legend>
        <dl class="inline">
     
          <dt><label for="name">Shipping Address</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_address'])) { echo $ship['Shipping']['shipping_address']; } else { echo '-'; } ?></textarea></dd>
          
          <dt><label for="name">LandMark</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_landmark'])) { echo $ship['Shipping']['shipping_landmark']; } else { echo '-'; }?></dd>
           <dt><label for="name">Pincode</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_pincode'])) { echo $ship['Shipping']['shipping_pincode']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">City</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_city'])) { echo $ship['Shipping']['shipping_city']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">State</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_state'])) { echo $ship['Shipping']['shipping_state']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">Billing Address</label></dt>
          <dd><?php if(!empty($ship['Shipping']['shipping_landmark'])) { echo $ship['Shipping']['billing_address']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">LandMark</label></dt>
          <dd><?php if(!empty($ship['Shipping']['billing_landmark'])) { echo $ship['Shipping']['billing_landmark']; }else { echo '-'; } ?></dd>
          
           <dt><label for="name">Pincode</label></dt>
          <dd><?php if(!empty($ship['Shipping']['pincode'])) { echo $ship['Shipping']['pincode']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">City</label></dt>
          <dd><?php if(!empty($ship['Shipping']['city'])) { echo $ship['Shipping']['city']; }else { echo '-'; } ?></dd>
          
          <dt><label for="name">State</label></dt>
          <dd><?php if(!empty($ship['Shipping']['state'])) { echo $ship['Shipping']['state']; }else { echo '-'; } ?></dd>
           
     	 </dl>	
      </fieldset>
	  <?php } ?>
    </form>      
        </div>
       </div> 
    </div>
</div>
</td>
</tr>
</table>
