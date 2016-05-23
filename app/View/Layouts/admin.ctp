<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo SITE_NAME;?> - Admin panel</title>
<meta name="description" content="<?php echo SITE_NAME;?> - Admin panel" />
<meta name="keywords" content="<?php echo SITE_NAME;?> - Admin panel" />
<meta name="author" content="<?php echo SITE_NAME;?>" />
<meta name="copyright" content="<?php echo SITE_NAME;?>" />
<?php
	echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon')
);

	echo $this->Html->css(array('style','reset','jqueryslidemenu','jQuery.validation/validationEngine.jquery','jquery.confirm/jquery.confirm','ui/jquery-ui-timepicker-addon','uniform/uniform.default','smoothness/jquery-ui-1.8.16.custom','jquery.fancybox-1.3.4'));
    echo $this->Html->script(array('jquery-1.8.3','jqueryslidemenu','jquery.cookie','styleswitch','ui/jquery-ui-1.8.16.custom.min','uniform/jquery.uniform','charts/highcharts','jquery.fancybox-1.3.4.pack','jQuery.validation/jquery.validationEngine','jQuery.validation/languages/jquery.validationEngine-en','confirm/jquery.confirm','ui/jquery-ui-timepicker-addon','admin-common'));	

	/*echo $this->Html->css(array('skins/blue'),'alternate stylesheet', array('media' => "screen",'title'=>'blue')); 
	echo $this->Html->css(array('skins/red'),'alternate stylesheet', array('media' => "screen",'title'=>'red')); 
	echo $this->Html->css(array('skins/orange'),'alternate stylesheet', array('media' => "screen",'title'=>'orange')); 
	echo $this->Html->css(array('skins/black'),'alternate stylesheet', array('media' => "screen",'title'=>'black')); 
	echo $this->Html->css(array('skins/grey'),'alternate stylesheet', array('media' => "screen",'title'=>'grey')); 
	echo $this->Html->css(array('skins/green'),'alternate stylesheet', array('media' => "screen",'title'=>'green')); */
	
	/*if(!empty($stylename))
	echo $this->Html->css(array('skins/'.$stylename),'alternate stylesheet', array('media' => "screen"));*/
	
	echo $this->Html->css(array('skins/black'),'stylesheet', array('media' => "screen"));
	
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>
<div class="helpfade"></div>
<div class="helptips"><div class="loader_block"><div class="loader_block_inner"></div><div class="loader_text">Please wait...</div></div></div>
<div class="dismsg" id="msginfo"><?php $msg=$this->Session->flash(); if(!empty($msg)) echo $msg.'<div class="close">Click to close.</div>'; ?></div>
	<div id="mainContainer"> 	
		<div id="header" class="clearfix">
			<div id="topHeader" >			
				<div id="logo"><?php echo $this->Html->link($this->Html->image('logo.png',array('border'=>0,'alt'=>'logo')),array('action'=>'index','controller'=>'dashboard'),array('escape'=>false)); ?></div>				
				<div id="topLinks">
                    <a href="<?php echo BASE_URL;?>" class="settings" target="_blank">Visit Site</a>
					<?php echo $this->Html->link('My Account',array('controller'=>'adminusers','action'=>'profile'),array('class'=>'settings')); ?> 
					<?php echo $this->Html->link('Logout',array('action'=>'logout'),array('class'=>'logout')); ?>
                </div>
				<!--<div id="colorstyle">
					<div>Change Color</div>
					<a rel="green" href="#" id="colorstyle" ></a>
					<a rel="blue" href="#"></a>
					<a rel="red" href="#"></a>
					<a rel="orange" href="#"></a>
					<a rel="black" href="#"></a>
					<a rel="grey" href="#"></a>
				</div>-->				
				<div id="welcomeUser" >Welcome, <?php echo $sessionadmin['Adminuser']['admin_name']; ?></div>
			</div>			
			<div id="myslidemenu" class="jqueryslidemenu">
				<?php if($sessionadmin['Adminuser']['role_id'] == "8") 
				{ ?>
				<ul>
				<?php 
					 $dasarray=array('dashboard');
                    if(in_array($this->params['controller'],$dasarray)):$current='class="active"';else:$current='';endif;
                    echo '<li '.$current.'>'.$this->Html->link('Dashboard',array('controller'=>'dashboard','action'=>'index')).'</li>'; 
					
					 $adminusers=array('adminusers','shippingrates','payus');
                    if(in_array($this->params['controller'],$adminusers)):$current='class="active"';else:$current='';endif;
                    echo '<li '.$current.'><a href="#">Settings</a>'; 
                    ?>
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('My Account',array('controller'=>'adminusers','action'=>'profile'));?></li>
                        <li id="changepass"><?php echo $this->Html->link('Change Password',array('controller'=>'adminusers','action'=>'changepass'));?></li>
					</ul>
					<?php $user=array('relationshipmanager');
                    if(in_array($this->params['controller'],$user)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'>'.$this->Html->link('Relationship Manager',array('controller'=>'relationshipmanager','action'=>'index')).'</li>';?>		
   
						
                   </ul>     
				<?php } else
				{ ?>
				<ul>
					<?php  
                   $dasarray=array('dashboard');
                    if(in_array($this->params['controller'],$dasarray)):$current='class="active"';else:$current='';endif;
                    echo '<li '.$current.'>'.$this->Html->link('Dashboard',array('controller'=>'dashboard','action'=>'index')).'</li>'; 
                    ?>
                    <?php 
                    $adminusers=array('adminusers','shippingrates','payus');
                    if(in_array($this->params['controller'],$adminusers)):$current='class="active"';else:$current='';endif;
                    echo '<li '.$current.'><a href="#">Settings</a>'; 
                    ?>
                      <ul>  
						<li id="changeinfo"><?php echo $this->Html->link('Admin Users',array('controller'=>'adminusers','action'=>'index'));?></li>
						<li id="changeinfo"><?php echo $this->Html->link('User Permissions',array('controller'=>'userpermissions','action'=>'index'));?></li>
						<li id="changeinfo"><?php echo $this->Html->link('User Roles',array('controller'=>'userroles','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('My Account',array('controller'=>'adminusers','action'=>'profile'));?></li>
                        <li id="changepass"><?php echo $this->Html->link('Change Password',array('controller'=>'adminusers','action'=>'changepass'));?></li>
                         <li id="changeinfo"><?php echo $this->Html->link('Shipping Rates',array('controller'=>'shippingrates','action'=>'admin_index'));?></li>
                         <li id="changeinfo"><?php echo $this->Html->link('Payment',array('controller'=>'payus','action'=>'admin_payu'));?></li>
                          <li id="changeinfo"><?php echo $this->Html->link('Partial Payment',array('controller'=>'partialpays','action'=>'admin_partialpay'));?>
                          <li id="changeinfo"><?php echo $this->Html->link('Redeem Point',array('controller'=>'Redeem','action'=>'admin_redeem'));?>
                            
                       </ul>
                    </li>
                    
                     <?php 
                    $emailcontents=array('emailcontents','banners','advertisements','staticpages');
                    if(in_array($this->params['controller'],$emailcontents)):$current='class="active"';else:$current='';endif;
                    echo '<li '.$current.'><a href="#">CMS</a>'; 
                    ?>
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('Email Content',array('controller'=>'emailcontents','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Content Page',array('controller'=>'staticpages','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Banner',array('controller'=>'banners','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Ads Banner',array('controller'=>'advertisements','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Newsletter',array('controller'=>'newsletters','action'=>'index'));?></li>
                         <li id="changeinfo"><?php echo $this->Html->link('Testimonial ',array('controller'=>'testimonials','action'=>'index','testimonial'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Customer say',array('controller'=>'testimonials','action'=>'index','customer_says'));?></li>
<!--                         <li id="changeinfo"><?php echo $this->Html->link('Locate us',array('controller'=>'locateus','action'=>'index'));?></li>
-->                         <li id="changeinfo"><?php echo $this->Html->link('Collection Type',array('controller'=>'collectiontypes','action'=>'admin_index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Order Status', array('controller' => 'orderstatus', 'action' => 'admin_index')); ?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Admin Status', array('controller' => 'adminstatus', 'action' => 'admin_index')); ?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Brokerage Status', array('controller' => 'brokeragestatus', 'action' => 'admin_index')); ?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('SMS Template', array('controller' => 'smstemplates', 'action' => 'admin_index')); ?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Shopping Assistance', array('controller' => 'shoppingassistance', 'action' => 'admin_index')); ?></li>
                       </ul>
                    </li>
					
                    
                    
                      <?php  
                   $shop=array('shop');
                    if(in_array($this->params['controller'],$shop)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">Shop Mgnt</a>'
					
					  ;?>		
                    
                      <ul>  
                       <li><a href="#">Vendor  Mgnt</a>
                      <ul>
                       <li id="changeinfo"><?php echo $this->Html->link('Vendor Status',array('controller'=>'statuses','action'=>'index'));?> </li>
                        <li id="changeinfo"><?php echo $this->Html->link('Vendor Types',array('controller'=>'types','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Account Types ',array('controller'=>'accounttypes','action'=>'index'));?></li>                    
                        <li id="changeinfo"><?php echo $this->Html->link('Add Vendor',array('controller'=>'vendors','action'=>'index'));?>
                      </ul>
                       </li>
                       
                       
                          
                          <li><a href="#">Metal Mgnt</a>
                       <ul>
                      <li id="changeinfo"><?php echo $this->Html->link('Metal',array('controller'=>'Metals','action'=>'index'));?></li>
                     <li id="changeinfo"><?php echo $this->Html->link('Metal Color',array('controller'=>'metalcolors','action'=>'index'));?></li>  
                     <li id="changeinfo"><?php echo $this->Html->link('Purity',array('controller'=>'purities','action'=>'index'));?></li>                        
                          <li id="changeinfo"><?php echo $this->Html->link('Size',array('controller'=>'sizes','action'=>'index'));?></li>
                       
                       </ul>
                       
                       </li>
                           <li><a href="#">Stone Mgnt</a>
                       <ul>
                    
                       <li id="changeinfo"><?php echo $this->Html->link('Diamond Type',array('controller'=>'diamonds','action'=>'index'));?></li>
                       <li id="changeinfo"><?php echo $this->Html->link('Diamond Clarity',array('controller'=>'Clarities','action'=>'index'));?></li>
                       <li id="changeinfo"><?php echo $this->Html->link('Diamond Color',array('controller'=>'Colors','action'=>'index'));?></li>
                       <li id="changeinfo"><?php echo $this->Html->link('Gemstone',array('controller'=>'Gemstones','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Shape',array('controller'=>'shapes','action'=>'index'));?></li>
                         <li id="changeinfo"><?php echo $this->Html->link('Setting Type',array('controller'=>'settingtypes','action'=>'index'));?></li>
                       
                       </ul>
                       
                       </li>
                         
                          <li><a href="#">Product Mgnt</a>
                         <ul>
                          <li id="changeinfo"><?php echo $this->Html->link('Category',array('controller'=>'categories','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Sub Category',array('controller'=>'subcategories','action'=>'index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Add Product',array('controller'=>'products','action'=>'index'));?></li>
                          </ul>
                          </li> 
                         <li><a href="#">Order Mgnt</a>
                         <ul>
                         <!-- <li id="changeinfo"><?php //echo $this->Html->link('Order',array('controller'=>'orders','action'=>'index'));?></li>-->
                           <li id="changeinfo"><?php echo $this->Html->link('Order',array('controller'=>'orders','action'=>'admin_order_index'));?></li>
<li id="changeinfo"><?php echo $this->Html->link('Order Tracking',array('controller'=>'orders','action'=>'admin_order_track_index'));?></li>                           
<!-- <li id="changeinfo"><?php //echo $this->Html->link('Quality Check Team',array('controller'=>'qualitychecks','action'=>'admin_index'));?></li>-->
                         </ul> 
                         </li>
                       <li><a href="#">Discount Mgnt</a>
                       <ul>
                       <li id="changeinfo"><?php echo $this->Html->link('Discount',array('controller'=>'discounts','action'=>'admin_index'));?></li>
                       
                       </ul>
                       
                       </li>
                                    <li id="changeinfo"><?php echo $this->Html->link('Menu Mgnt', array('controller' => 'menus', 'action' => 'admin_index')); ?>
                   
                   </ul> 

                <?php  
                   $user=array('signin');
                    if(in_array($this->params['controller'],$user)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">User Mgnt</a>';?>		
                    
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('User Registration',array('controller'=>'signin','action'=>'admin_index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Franchisee Registration',array('controller'=>'franchisees','action'=>'admin_index'));?></li>
						<li id="changeinfo"><?php echo $this->Html->link('Customer Master',array('controller'=>'customermaster','action'=>'admin_index'));?></li>
						<li id="changeinfo"><?php echo $this->Html->link('Customer Approvals',array('controller'=>'customermaster','action'=>'admin_approvals'));?></li>
                   </ul>     
                   
                   
                    <?php  
                   $enquiry=array('enquiry');
                    if(in_array($this->params['controller'],$enquiry)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">Enquiries</a>';?>		
                    
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('Home Enquiries',array('controller'=>'webpages','action'=>'admin_home_enquiries'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Have a Question',array('controller'=>'webpages','action'=>'admin_question'));?></li>
<li id="changeinfo"><?php echo $this->Html->link('Customized Request',array('controller'=>'webpages','action'=>'admin_customizedrequest'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Contact Us',array('controller'=>'contactuses','action'=>'admin_index'));?></li>
                   </ul>     
                   
                    <?php  
                   $review=array('review');
                    if(in_array($this->params['controller'],$review)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">Review & Rating</a>';?>		
                    
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('Rating',array('controller'=>'webpages','action'=>'rating_list'));?></li>
                         <li id="changeinfo"><?php echo $this->Html->link('Wish List',array('controller'=>'wishlists','action'=>'admin_index'));?></li>
                   
                   </ul>   
                   
                     <?php  
                   $price=array('price');
                    if(in_array($this->params['controller'],$price)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">Price Mgnt</a>'
					
					  ;?>		
                    
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('Price',array('controller'=>'prices','action'=>'admin_index'));?></li>
                        <li id="changeinfo"><?php echo $this->Html->link('Gold Price',array('controller'=>'goldprice','action'=>'admin_index'));?></li>
                       
                   
                   </ul>     
                            
                            <li><a href="#">Brokerage</a>     
                            <ul>  
                                <li id="changeinfo"><?php echo $this->Html->link(' Vendor Brokerage', array('controller' => 'orders', 'action' => 'admin_vendors_brokerage')); ?></li>
                                <li id="changeinfo"><?php echo $this->Html->link('Franchise Brokerage', array('controller' => 'orders', 'action' => 'admin_franchisee_brokerage')); ?></li>

                            </ul>
							<?php 
								$user=array('relationshipmanager');
									if(in_array($this->params['controller'],$user)):$current='class="active"';else:$current='';endif;
								  echo '<li '.$current.'>'.$this->Html->link('Relationship Manager',array('controller'=>'relationshipmanager','action'=>'index')).'</li>';?>		
                  <!-- <?php  
                   $discount=array('discounts');
                    if(in_array($this->params['controller'],$discount)):$current='class="active"';else:$current='';endif;
                      echo '<li '.$current.'><a href="#">Discount Mgnt</a>'
					
					  ;?>		
						
                      <ul>  
                        <li id="changeinfo"><?php echo $this->Html->link('Discount',array('controller'=>'discounts','action'=>'admin_index'));?></li>
                       
                   
                   </ul> -->
                  <?php } ?>
			</div>
		</div>
		  <?php echo $this->fetch('content'); ?>
		<div id="footer" class="clearfix">
        
			<div class="copyright">Copyrights &copy; All rights are reserved</div>
			<div class="designInfo"></div>
		</div>
	</div>
</body>

</html>
