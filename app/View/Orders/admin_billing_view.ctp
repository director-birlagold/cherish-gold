<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_order_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;">
                          <?php   $billingdetails=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$this->params['pass']['0'])));
                        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $billingdetails['Order']['user_id']))); 
                        if ($user['User']['user_type'] == '0') {
                            echo $this->Html->link('Back to Vendor Brokerage', array('action' => 'vendors_brokerage'), array('class' => 'button'));
                        } elseif ($user['User']['user_type'] == '1') {
                            echo $this->Html->link('Back to Franchisee Brokerage', array('action' => 'franchisee_brokerage'), array('class' => 'button'));
                        }
                        ?>

            <?php echo $this->Html->link('Back to Order Details',array('action'=>'order_index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
            <form>       	
           <fieldset><legend>Billing  Details</legend>
            			 <dl class="inline">
                             <table width="600" align="left" >
                               <tr><td width="150"><strong> Billing Address</strong></td><td>
                            <p><?php $bill=h($billingdetails['Order']['billing_add']); if(!empty($bill))echo $bill; else '-';  ?></p>
                            </td></tr>
                              <tr><td width="150"><strong> Billing Landmark</strong></td><td>
                            <p><?php $billland=h($billingdetails['Order']['blandmark']); if(!empty($billland))echo $billland; else '-';  ?></p>
                            </td></tr>
                              <tr><td width="150"><strong> Billing Pincode</strong></td><td>
                            <p><?php $billpin=h($billingdetails['Order']['pincode']); if(!empty($billpin))echo $billpin; else '-';  ?></p>
                            </td></tr>
                              <tr><td width="150"><strong> Billing State</strong></td><td>
                            <p><?php $billstate=h($billingdetails['Order']['state']); if(!empty($billstate))echo $billstate; else '-';  ?></p>
                            </td></tr>
                              <tr><td width="150"><strong> Billing City</strong></td><td>
                            <p><?php $billcity=h($billingdetails['Order']['city']); if(!empty($billcity))echo $billcity; else '-';  ?></p>
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
