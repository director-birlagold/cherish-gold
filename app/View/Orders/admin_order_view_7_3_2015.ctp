<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_order_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;"><?php echo $this->Html->link('Back to Order Details',array('action'=>'order_index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
            <form> 
             <fieldset><legend>Order   Details</legend>
           
           <table width="600" align="left">
           <?php $orderinvoice=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$orderdetails['Order']['order_id'])));
		    $ordercartamount=ClassRegistry::init('Shoppingcart')->find('first',array('conditions'=>array('order_id'=>$orderdetails['Order']['order_id']),'fields'=>array('SUM(total) AS totamount')));
			$user=ClassRegistry::init('User')->find('first',array('conditions'=>array('user_id'=>$orderdetails['Order']['user_id'])));
			$paymentdetail=ClassRegistry::init('Paymentdetails')->find('first',array('conditions'=>array('order_id'=>$orderdetails['Order']['order_id'])));
		   ?>
            <tr><td width="150"><strong>Invoice Number</strong></td>
              <td><p>
				  <?php if($user['User']['user_type']=='0'){
                
                if($orderdetails['Order']['cod_status']=='PayU'){
                $in='SGN-ON-';
                }elseif($orderdetails['Order']['cod_status']=='CHQ/DD'){
                    $in='SGN-CHQ/DD-';
                }
            }
		else
			{
				if($orderdetails['Order']['cod_status']=='PayU'){
					$in='SGN-FN-';
				}elseif($orderdetails['Order']['cod_status']=='COD'){
					$in='SGN-FNCD-';
				}elseif($orderdetails['Order']['cod_status']=='CHQ/DD'){
					$in='SGN-FNCHQ/DD-';
				}
				
				
			}?>
              
              <?php  echo $in.$orderinvoice['Order']['invoice'];?></p></td></tr>
               <tr><td width="150"><strong >Payment Mode</strong></td><td><?php echo $orderdetails['Order']['cod_status']; ?></td></tr>
             <?php   if(($orderdetails['Order']['cod_status']!='CHQ/DD') && ($orderdetails['Order']['order_status']!='Pending')){?>
             <tr><td width="150"><strong>Transaction Id </strong></td>
             <td><p><?php $txid=h($paymentdetail['Paymentdetails']['txnid']); if(!empty($txid))echo $txid; else '-';  ?></p></td></tr>
             <?php }?>
             <tr><td width="150"><strong >Total Amount</strong></td><td>Rs. <?php echo indian_number_format($ordercartamount['0']['totamount']);?></td></tr>
             <tr><td width="150"><strong >Paid Amount</strong></td>
             <td><p><?php 
			 $type=$user['User']['user_type'];
						  if($type=='0'){
							  if(($orderdetails['Order']['cod_status']=='PayU') && ($orderdetails['Order']['order_status']!='Pending')){
								$paid=h($paymentdetail['Paymentdetails']['amount']);  
							  }else if(($orderdetails['Order']['cod_status']=='CHQ/DD') && ($orderdetails['Order']['order_status']!='Pending')){
								  $paid=h($paymentdetail['Paymentdetails']['amount']);  
							  }				 	 
						  }elseif($type=='1'){
						$order_franchisee=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$orderdetails['Order']['order_id'])));
						 	if(($order_franchisee['Order']['cod_status']=='COD') &&($order_franchisee['Order']['order_status']!='Pending')){
							$per=$order_franchisee['Order']['cod_percentage'];
							 $amount=$ordercartamount['0']['totamount'];
						    $paid=h($paymentdetail['Paymentdetails']['amount']);
							$balanceamt=$amount-$paid; 
							}
							elseif(($orderdetails['Order']['cod_status']=='PayU') && ($orderdetails['Order']['order_status']!='Pending'))
							{
							$paid=h($paymentdetail['Paymentdetails']['amount']);	 
							}elseif(($orderdetails['Order']['cod_status']=='CHQ/DD') && ($orderdetails['Order']['order_status']!='Pending')){
							$paid=h($paymentdetail['Paymentdetails']['amount']); 
							}
						
						  }
			 
			 if(!empty($paid)) {echo 'Rs.';echo indian_number_format($paid);} else '-';  ?></p></td></tr>
             <?php   if($type=='1'){
				 if($order_franchisee['Order']['cod_status']=='COD') {?>
              <tr><td width="150"><strong>Balance Amount </strong></td>
             <td><p><?php  if(!empty($balanceamt))
			 {echo 'Rs.';echo indian_number_format($balanceamt);
			 } else{ echo '-';};  ?></p></td></tr>
             
             <?php } }?>
               <tr><td width="150"><strong >Order Created Date</strong></td>
             <td><p><?php $dtt=h($orderdetails['Order']['created_date']);
						 $ndtt=date("d-m-Y",strtotime($dtt));
						  if(!empty($ndtt))echo $ndtt; else '-';  ?></p></td></tr>
                           <tr><td width="150"><strong>Order Status </strong></td>
             <td><p><?php $st=h($orderdetails['Order']['order_status']); if(!empty($st))echo $st; else '-';  ?></p></td></tr>
                           <?php    if(($orderdetails['Order']['cod_status']!='CHQ/DD') && ($orderdetails['Order']['order_status']!='Pending')){?>
              <tr><td width="150"><strong >Payment Created Date</strong></td>
             <td><p><?php $dt=h($paymentdetail['Paymentdetails']['created_date']);
						 $ndt=date("d-m-Y",strtotime($dt));
						  if(!empty($ndt))echo $ndt; else '-';  ?></p></td></tr>
                         <?php }?>   
                 
              <tr><td width="150"><strong>Payment Status </strong></td>
             <td><p><?php $st=h($orderdetails['Order']['status']); if(!empty($st))echo $st; else '-';  ?></p></td></tr>
             
              <?php    if(($orderdetails['Order']['cod_status']!='CHQ/DD') && ($orderdetails['Order']['order_status']!='Pending')){?>         
              <tr><td width="150"><strong>Ip No </strong></td>
              <td><p><?php $ip=h($paymentdetail['Paymentdetails']['ip']); if(!empty($ip))echo $ip; else '-';  ?></p></td></tr>
              <?php }?>
           </table>         
                        
            </fieldset>
          </form>
          </div>
       </div> 
    </div>
</div>
</td>
</tr>
</table>
