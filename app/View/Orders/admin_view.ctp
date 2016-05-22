<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Order Details'),array('action'=>'index'),array('class'=>'button')); ?></div>        
       <?php echo $this->Form->create('Order',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>        	
            <fieldset>
                <legend><?php echo __('View Order Details');?></legend>
                             <dl class="inline">
                          <fieldset><legend>User  Details</legend>
                          <?php $user=ClassRegistry::init('User')->find('first',array('conditions'=>array('user_id'=>$paymentdetail['Paymentdetails']['user_id'])));?>
                          <table width="600" align="center">
                           <tr><td width="150"><strong>Type</strong></td>                    
                          <td><p><?php
						  if($user['User']['user_type']=='0'){
							  echo 'User';
						  }elseif($user['User']['user_type']=='1'){
							  echo 'Franchisee';
						  }
						  
						     ?></p></td></tr>
                          
                          <tr><td width="150"><strong>First Name</strong></td>                    
                          <td><p><?php $firstname=h($user['User']['first_name']); if(!empty($firstname))echo $firstname; else '-';  ?></p></td></tr>
							<tr><td width="150"><strong>Last Name</strong></td>                    
                          <td><p><?php $lastname=h($user['User']['last_name']); if(!empty($lastname))echo $lastname; else '-';  ?></p></td></tr>

							<tr><td width="150"><strong>Date of Birth</strong></td>                    
                          <td><p><?php $dobf=h($user['User']['date_of_birth']);
						 $dob=date("Y-m-d",strtotime($dobf));
						  if(!empty($dob))echo $dob; else '-';  ?></p></td></tr>

							<tr><td width="150"><strong>Email</strong></td>                    
                          <td><p><?php $email=h($user['User']['email']); if(!empty($email))echo $email; else '-';  ?></p></td></tr>

						<tr><td width="150"><strong>Phone Number</strong></td>                    
                          <td><p><?php $phone=h($user['User']['phone_no']); if(!empty($phone))echo $phone; else '-';  ?></p></td></tr>

                          </table>
                          
                                                 
            </fieldset>
           
                     
                         <fieldset><legend>Product   Details</legend>
            			 <dl class="inline">
                        
                          <table cellpadding="0" cellspacing="0" id="example" class="table gtable chgovr">
        <thead>
        <tr>
             <th width="30" align="center"><?php echo __('#');?></th>   
 
          <th  width="600"align="left">Product Details</th>
          <th width="300" align="left">Vendor Details </th>
          <th width="50" align="left">Quantity </th>
           <th width="50" align="left">Price </th>
        </tr>
        </thead>
        <tbody>
    
		<?php 
		$k=1;
	      $ordercart=ClassRegistry::init('Shoppingcart')->find('all',array('conditions'=>array('order_id'=>$paymentdetail['Paymentdetails']['order_id'])));
		   $ordercartamount=ClassRegistry::init('Shoppingcart')->find('first',array('conditions'=>array('order_id'=>$paymentdetail['Paymentdetails']['order_id']),'fields'=>array('SUM(total) AS totamount')));
         foreach($ordercart as $ordercarts){
		 $productdetails=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$ordercarts['Shoppingcart']['product_id'])));
		 $category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$productdetails['Product']['category_id'])));
		 $vendor=ClassRegistry::init('Vendor')->find('first',array('conditions'=>array('vendor_id'=>$productdetails['Product']['vendor_id'])));
		 
		 
		 
		  ?>
        <tr>
        <td align="center" valign="top"><?php echo ($k); ?></td>	
        <td  width="600" align="left">
        <table width="600px">
        <tr style="padding-bottom:10px;">
        <td width="150px" valign="top">
        <?php  $images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$productdetails['Product']['product_id'],'status'=>'Active')));?>
         <?php //$link=BASE_URL.'img/product/home/'.$images['Productimage']['imagename'];?>
                <?php $image=$images['Productimage']['imagename'];
				 echo  $this->Html->image('product/small/'.$images['Productimage']['imagename'],array("alt" => "Image",'width'=>'120','height'=>'90'));
				
				?>
        </td>
        
        <td  width="450px" > <dt><label for="name">Product Name </label></dt><dd> <p><?php echo $productdetails['Product']['product_name']?>  </p></dd> 
         <dt><label for="name">Product Code </label></dt><dd> <p><?php echo $category['Category']['category_code'].' '.$productdetails['Product']['product_code'];?>  </p></dd>
           
              
              
         </td>
        </tr>
        <tr>
        <td width="600" colspan="2">
        <table width="600">
        <tr><th colspan="2"><strong>Metal Details</strong></th></tr>
        <tr><td width="300px">
        <table width="300px">
        <tr><td width="100"><strong>Metal</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['metal']?></strong></p></td></tr>
        <tr><td ><strong>Metal Color</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['metalcolor']?></strong></p></td></tr>
        <tr><td ><strong>Purity</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['purity']?></strong></p></td></tr>
         </table>    
        </td>
        <td valign="top">
         <table width="300px">
        <tr><td width="100"><strong>Size</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['size']?></strong></p></td></tr>
        <tr><td ><strong>Metal Weight</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['weight'].' gm';?></strong></p></td></tr>
         </table>   
        </td></tr>
        </table>      
        </td>
        </tr>
         <tr>
        <td width="600" colspan="2">
        
        <?php
		$stone_details=ClassRegistry::init('Productdiamond')->find('all',array('conditions'=>array('clarity'=> $ordercarts['Shoppingcart']['clarity'],'color'=> $ordercarts['Shoppingcart']['color'],'product_id'=>$productdetails['Product']['product_id'])));
		
        if(!empty($stone_details)){	
	$sd_clarity='<tr><td width="70">Clarity</td>';
	$sd_color='<tr><td>Color</td>';
	$sd_nostones='<tr><td>No.of Stones</td>';
	$sd_weight='<tr><td>Weight</td>';
	$sd_shape='<tr><td>Shape</td>';
	$sd_setting_type='<tr><td>Setting Type</td>';
	$i=1;
	foreach($stone_details as $stone_detail){
		$sd_clarity.='<td class="widthtd">'.$stone_detail['Productdiamond']['clarity'].'</td>';
		$sd_color.='<td class="widthtd">'.$stone_detail['Productdiamond']['color'].'</td>';		
		$sd_nostones.='<td class="widthtd">'.$stone_detail['Productdiamond']['noofdiamonds'].'</td>';
		$sd_weight.='<td class="widthtd">'.$stone_detail['Productdiamond']['stone_weight'].'</td>';
		$sd_shape.='<td class="widthtd">'.$stone_detail['Productdiamond']['shape'].'</td>';
		$sd_setting_type.='<td class="widthtd">'.$stone_detail['Productdiamond']['settingtype'].'</td>';
		$i++;
	}
	$sd_clarity.='</tr>';
	$sd_color.='</tr>';
	$sd_shape.='</tr>';
	$sd_setting_type.='</tr>';
	$sd_nostones.='</tr>';
	$sd_weight.='</tr>';
	$stonehtml='<p><strong><b>Diamonds Details</b></strong></p>';
	$stonehtml.=(($i>3)?('<div style="overflow-x:scroll;overflow:y:hidden; width:600px;">'):'');
	$stonehtml.='<table cellpadding="0" cellspacing="0" border="0" width="600">
     '.$sd_clarity.$sd_color.$sd_nostones.$sd_weight.$sd_shape.$sd_setting_type.'	 
     </table>';
	$stonehtml.=(($i>3)?('</div>'):'');	
	$stonehtml.='<table >
	<tr><td colspan="'.$i.'">&nbsp;</td></tr></table>';
	echo $stonehtml; 
}else{
	
}
		?>
               
       
          
        </td>
        </tr>
         <tr>
        <td width="600" colspan="2">
        
        <?php
		$gemstone_details=ClassRegistry::init('Productgemstone')->find('all',array('conditions'=>array('product_id'=>$productdetails['Product']['product_id'])));
		
        if(!empty($gemstone_details)){	
	$sd_clarity1='<tr><td width="70">Gemstone</td>';
	$sd_color1='<tr><td>Size</td>';
	$sd_nostones1='<tr><td>No.of Stones</td>';
	$sd_weight1='<tr><td>Weight</td>';
	$sd_shape1='<tr><td>Shape</td>';
	$sd_setting_type1='<tr><td>Setting Type</td>';
	$i=1;
	foreach($gemstone_details as $gemstone_details){
		$sd_clarity1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['gemstone'].'</td>';
		$sd_color1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['size'].'</td>';		
		$sd_nostones1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['no_of_stone'].'</td>';
		$sd_weight1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['stone_weight'].'</td>';
		$sd_shape1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['shape'].'</td>';
		$sd_setting_type1.='<td class="widthtd">'.$gemstone_details['Productgemstone']['settingtype'].'</td>';
		$i++;
	}
	$sd_clarity1.='</tr>';
	$sd_color1.='</tr>';
	$sd_shape1.='</tr>';
	$sd_setting_type1.='</tr>';
	$sd_nostones1.='</tr>';
	$sd_weight1.='</tr>';
	$stonehtml1='<p><strong><b>Gemstone Details</b></strong></p>';
	$stonehtml1.=(($i>3)?('<div style="overflow-x:scroll;overflow:y:hidden; width:600px;">'):'');
	$stonehtml1.='<table cellpadding="0" cellspacing="0" border="0" width="600">
     '.$sd_clarity1.$sd_color1.$sd_nostones1.$sd_weight1.$sd_shape1.$sd_setting_type1.'	 
     </table>';
	$stonehtml1.=(($i>3)?('</div>'):'');	
	$stonehtml1.='<table >
	<tr><td colspan="'.$i.'">&nbsp;</td></tr></table>';
	echo $stonehtml1; 
}else{
	
}
		?>
      
        </td>
        </tr>
      <tr>
        <td width="600" colspan="2">
        <table width="600">
         <tr><th colspan="2"><strong>Price Details</strong></th></tr>
         <tr><td  width="300px" valign="top">
         <table width="300px">
        <tr><td width="150"><strong>Metal Rate</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['goldprice']?></strong></p></td></tr>
        <?php   if(!empty($ordercarts['Shoppingcart']['stoneprice'])){	?>
        <tr><td ><strong>Diamond  Rate</strong></td><td><pRs.><?php echo $ordercarts['Shoppingcart']['stoneprice']?></strong></p></td></tr>
        <?php }?>
         <?php   if(!empty($ordercarts['Shoppingcart']['gemprice'])){	?>
        <tr><td ><strong>Gemstone Rate</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['gemprice']?></strong></p></td></tr>
       <?php }?>
          <tr><td ><strong>Making Charge (%)</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['making_per']?></strong></p></td></tr>
            <tr><td ><strong>Vat (%)</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['vat_per']?></strong></p></td></tr>
         </table>   
           </td>
         <td  width="300px" valign="top">
         <table width="300px">
         <tr><td width="150"><strong>Metal Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['goldamount']?></p></td></tr>
         <?php   if(!empty($ordercarts['Shoppingcart']['stoneamount'])){	?>
        <tr><td ><strong>Diamond Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['stoneamount'];?></strong></p></td></tr>
        <?php }?>
         <?php   if(!empty($ordercarts['Shoppingcart']['gemstoneamount'])){	?>
         <tr><td ><strong>Gemstone Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['gemstoneamount'];?></strong></p></td></tr>
          <?php }?>
        <tr><td ><strong>Making Charge Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['making_charge'];?></strong></p></td></tr>
        <tr><td ><strong>Vat  Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['vat'];?></strong></p></td></tr>
         <tr><td ><strong>Total Amount</strong></td><td><p>Rs.<?php echo indian_number_format($ordercarts['Shoppingcart']['total']);?></strong></p></td></tr>
         </table>   
           </td>
         
         
         </tr>
        </table>
        </td></tr>
        
          </table>
         </td>
        <td  width="300"align="left " valign="top">
        <table width="300" >
        <?php $vendoroff=classRegistry::init('Vendorcontact')->find('first',array('conditions'=>array('vendor_id'=> $vendor['Vendor']['vendor_id'])));?>
        <tr><td width="100" valign="top"><strong>Vendor Code</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['vendor_code'];?></p></td></tr>
         <tr><td width="100" valign="top"><strong>Company</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['Company_name'];?> </p></td></tr>
          <tr><td width="100" valign="top"><strong>Phone No(1)</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['reg_phone'];?> </p></td></tr>
           <tr><td width="100" valign="top"><strong>Mobile</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['reg_mobile'];?> </p></td></tr>
            <tr><td width="100" valign="top"><strong>Email</strong></td><td width="200" valign="top"><p><?php 
			
			echo $vendoroff['Vendorcontact']['email'];?></p></td></tr>
                   
        </table>
               
         </td>
         <td   width="50"align="left " valign="top"><?php echo $ordercarts['Shoppingcart']['quantity']?>  </td>
         <td   width="50"align="left "valign="top"><span>Rs.</span><?php echo indian_number_format($ordercarts['Shoppingcart']['total']*$ordercarts['Shoppingcart']['quantity'])?> </td>
          </tr>
        <?php  $k++; }  
        ?>
        </tbody>
        </table> 
                     
                                       
                          </dl>                
                        
            </fieldset>
            
                         <fieldset><legend>Billing Address Details</legend>
            			 <dl class="inline">
                          <?php   $billingdetails=ClassRegistry::init('Order')->find('first',array('conditions'=>array('user_id'=>$paymentdetail['Paymentdetails']['user_id'],'order_id'=>$paymentdetail['Paymentdetails']['order_id'])));
						  ?>
                             <table width="600" align="center" >
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
            
            <fieldset><legend>Shipping Address Details</legend>
           
            			<dl class="inline">
                          <?php   $shippingdetails=ClassRegistry::init('Order')->find('first',array('conditions'=>array('user_id'=>$paymentdetail['Paymentdetails']['user_id'],'order_id'=>$paymentdetail['Paymentdetails']['order_id'])));
						  ?>
                            <table width="600" align="center" >
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
           <fieldset><legend>Order   Details</legend>
           
           <table width="600" align="center">
           <?php $orderinvoice=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$paymentdetail['Paymentdetails']['order_id'])));?>
            <tr><td width="150"><strong>Invoice Number</strong></td>
              <td><p>SGN-ON-<?php  echo $orderinvoice['Order']['invoice'];?></p></td>
             <tr><td width="150"><strong>Transaction Id </strong></td>
             <td><p><?php $txid=h($paymentdetail['Paymentdetails']['txnid']); if(!empty($txid))echo $txid; else '-';  ?></p></td></tr>
             <tr><td width="150"><strong >Total Amount</strong></td><td>Rs. <?php echo indian_number_format($ordercartamount['0']['totamount']);?></td></tr>
             <tr><td width="150"><strong >Paid Amount</strong></td>
             <td><p><?php 
			 $type=$user['User']['user_type'];
						  if($type=='0'){
						 $paid=h($paymentdetail['Paymentdetails']['amount']);	 
						  }elseif($type=='1'){
						$order_franchisee=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$paymentdetail['Paymentdetails']['order_id'])));
						 	if($order_franchisee['Order']['cod_status']=='COD'){
							$per=$order_franchisee['Order']['cod_percentage'];
							$amount=$ordercartamount['0']['totamount'];
						    $paid=$paymentdetail['Paymentdetails']['amount'];
							$balanceamt=$amount-$paid; 
							}
							else
							{
							
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
              <tr><td width="150"><strong >Created Date</strong></td>
             <td><p><?php $dt=h($paymentdetail['Paymentdetails']['created_date']);
						 $ndt=date("d-m-Y",strtotime($dt));
						  if(!empty($ndt))echo $ndt; else '-';  ?></p></td></tr>
                          
                          
              <tr><td width="150"><strong>Ip No </strong></td>
             <td><p><?php $ip=h($paymentdetail['Paymentdetails']['ip']); if(!empty($ip))echo $ip; else '-';  ?></p></td></tr>
              <tr><td width="150"><strong>Status </strong></td>
             <td><p><?php $st=h($paymentdetail['Paymentdetails']['status']); if(!empty($st))echo $st; else '-';  ?></p></td></tr>
             
           </table>         
                        
            </fieldset>
           
           
           </dl>
           
           
           
           
            </fieldset>
       <?php echo $this->Form->end(); ?>
    </div>
</div>






