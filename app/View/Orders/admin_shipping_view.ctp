<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_order_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;">
            <?php   
            $shippingdetails=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
            $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $shippingdetails['Order']['user_id']))); 
                        if ($user['User']['user_type'] == '0') {
                            echo $this->Html->link('Back to Vendor Brokerage', array('action' => 'vendors_brokerage'), array('class' => 'button'));
                        } elseif ($user['User']['user_type'] == '1') {
                            echo $this->Html->link('Back to Franchisee Brokerage', array('action' => 'franchisee_brokerage'), array('class' => 'button'));
                        }
            echo $this->Html->link('Back to Order Details',array('action'=>'order_index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
            <form> 
             <fieldset><legend>Shipping  Details</legend>
           
            			<dl class="inline">
                            <table width="600" align="left" style="padding-left:50px;" >
                            <tr><td width="150"><strong> Shipping Address</strong></td><td>
                            <p><?php $sbill=h($shippingdetails['Order']['shipping_add']); if(!empty($sbill))echo $sbill; else '-';  ?></p>
                            </td></tr>
                            <tr><td width="150"><strong>Shipping Landmark</strong></td><td>
                            <p><?php $sbillland=h($shippingdetails['Order']['slandmark']); if(!empty($sbillland))echo $sbillland; else '-';  ?></p>
                            </td></tr>
                             <tr><td width="150"><strong>Shipping Pincode</strong></td><td>
                            <p><?php $sbillpin=h($shippingdetails['Order']['spincode']); if(!empty($sbillpin))echo $sbillpin; else '-';  ?></p>
                            </td></tr>
                             <tr><td width="150"><strong>Shipping State</strong></td><td>
                            <p><?php $sbillstate=h($shippingdetails['Order']['sstate']); if(!empty($sbillstate))echo $sbillstate; else '-';  ?></p>
                            </td></tr>
                             <tr><td width="150"><strong>Shipping City</strong></td><td>
                            <p><?php $sbillcity=h($shippingdetails['Order']['scity']); if(!empty($sbillcity))echo $sbillcity; else '-';  ?></p>
                            </td></tr>
                            
                            </table>             
                         
                         </dl>
                        
                                        
                        
            </fieldset>      	
          </form>
          </div>
       </div> 
    </div>
</div>
</td>
</tr>
</table>
