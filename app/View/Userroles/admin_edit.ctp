<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to User Roles'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Edit Role</legend>
                <dl class="inline">

                    <fieldset><legend>Role Details</legend>
                        <dl class="inline">
                            
                            <input type="hidden" name="some" class="role_id" value="<?php echo $role['Userroles']['role_id']; ?>"/>
                            

                            <dt><label for="name">Role Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Userroles][role_name]" id="role_name"  class="validate[required]" size="50" value="<?php echo $role['Userroles']['role_name']; ?>"/></dd>
							
                            <dt><label for="name">&nbsp;</label></dt>
							<dd>      
								<!--<input type="button" name="btn_check" id="btn_check" value="Check All" />-->
								<input type="checkbox" id="selecctall"/> Check / Uncheck All
                            </dd>


                            <!--<dt><label for="name">Permissions</label></dt>
							<!--<dd>-->
							<div style="width:613px;margin:0 auto;">
								<?php 
								//echo "<pre>";
								//print_r($new_perms);
								//exit;
								//$selected_perms = array();
								//for($i=0;$i < sizeof($new_perms);$i++){
									//echo $new_perms[$i]['Roleperm']['perm_id'];
									//$selected_perms[] = $new_perms[$i]['Roleperm']['perm_id'];
								//}
								//echo "<pre>";
								//print_r($permissions);
								//exit;
								
								//for($i = 0; $i < sizeof($permissions);$i++){
									//$sel = (in_array($permissions[$i]['Permissions']['perm_id'], $selected_perms)) ? 'Checked' : '';
								?>
								
									
									<!--<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="<?php echo $permissions[$i]['Permissions']['perm_id']; ?>" class="checkbox1" <?php echo $sel;?>  /><?php echo $permissions[$i]['Permissions']['perm_desc']; ?>-->
									
									

                                <?php //if($i != 0 && $i % 3 == 0)
										//echo '<br />';
										//} ?>
							<!-- </div>	-->
                            <!--</dd>-->

							
                                    


                        </dl>
                    </fieldset>
					
					<?php 
						$selected_perms = array();
						for($i=0;$i < sizeof($new_perms);$i++){
							//echo $new_perms[$i]['Roleperm']['perm_id'];
							$selected_perms[] = $new_perms[$i]['Roleperm']['perm_id'];
						}
					?>
					
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Settings (Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Admin User</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="178" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('178', $selected_perms)){?> checked <?php }?> > AdminUserAdd 
											<input type="checkbox" class="checkbox1" value="181" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('178', $selected_perms)){?> checked <?php }?> > AdminUserDelete 
											<input type="checkbox" class="checkbox1" value="181" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('181', $selected_perms)){?> checked <?php }?> > AdminUserEdit 
											<input type="checkbox" class="checkbox1" value="180" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('180', $selected_perms)){?> checked <?php }?> > AdminUserList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>User Permissions</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="7" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('7', $selected_perms)){?> checked <?php }?>  > PermissionAdd 
											<input type="checkbox" class="checkbox1" value="8" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('8', $selected_perms)){?> checked <?php }?>  > PermissionEdit 
											<input type="checkbox" class="checkbox1" value="6" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('6', $selected_perms)){?> checked <?php }?>  > PermissionList
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>User Roles</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="2" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('2', $selected_perms)){?> checked <?php }?>  > RoleAdd  
											<input type="checkbox" class="checkbox1" value="5" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('5', $selected_perms)){?> checked <?php }?>  > RoleDelete  
											<input type="checkbox" class="checkbox1" value="3" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('3', $selected_perms)){?> checked <?php }?>  > RoleEdit  
											<input type="checkbox" class="checkbox1" value="4" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('4', $selected_perms)){?> checked <?php }?>  > RoleList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>My Account</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="9" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('9', $selected_perms)){?> checked <?php }?>  > MyAccount 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Change Password</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="10" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('10', $selected_perms)){?> checked <?php }?> > ChangePassword  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Shipping Rates</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="12" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('12', $selected_perms)){?> checked <?php }?> > ShippingRatesAdd 
											<input type="checkbox" class="checkbox1" value="14" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('14', $selected_perms)){?> checked <?php }?> > ShippingRatesDelete 
											<input type="checkbox" class="checkbox1" value="13" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('13', $selected_perms)){?> checked <?php }?> > ShippingRatesEdit 
											<input type="checkbox" class="checkbox1" value="16" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('16', $selected_perms)){?> checked <?php }?> > ShippingRatesExport 
											<input type="checkbox" class="checkbox1" value="15" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('15', $selected_perms)){?> checked <?php }?> > ShippingRatesImport 
											<input type="checkbox" class="checkbox1" value="11" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('11', $selected_perms)){?> checked <?php }?> > ShippingRatesList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Payment</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="17" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('17', $selected_perms)){?> checked <?php }?> > Payment   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Partial Payment</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="18" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('18', $selected_perms)){?> checked <?php }?> > PartialPayment    
										</dd>
									</dl>
							</fieldset>
							
						</div>
					</fieldset>
					
					
					<fieldset><legend class="togvis" style="cursor: pointer;">CMS (Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Email Contents</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="20" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('20', $selected_perms)){?> checked <?php }?> > EmailContentsEdit  
											<input type="checkbox" class="checkbox1" value="19" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('19', $selected_perms)){?> checked <?php }?> > EmailContentsList  
											
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Content Pages</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="22" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('22', $selected_perms)){?> checked <?php }?> > ContentPagesEdit 
											<input type="checkbox" class="checkbox1" value="21" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('21', $selected_perms)){?> checked <?php }?> > ContentPagesList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Banner</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="24" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('24', $selected_perms)){?> checked <?php }?> > BannerAdd  
											<input type="checkbox" class="checkbox1" value="26" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('26', $selected_perms)){?> checked <?php }?> > BannerDelete 
											<input type="checkbox" class="checkbox1" value="25" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('25', $selected_perms)){?> checked <?php }?> > BannerEdit  
											<input type="checkbox" class="checkbox1" value="23" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('23', $selected_perms)){?> checked <?php }?> > BannerList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Advertisement Banner</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="28" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('28', $selected_perms)){?> checked <?php }?> > AdvertisementBannerEdit   
											<input type="checkbox" class="checkbox1" value="27" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('27', $selected_perms)){?> checked <?php }?> > AdvertisementBannerList  
											
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>News Letter</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="30" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('30', $selected_perms)){?> checked <?php }?> > NewsletterAdd   
											<input type="checkbox" class="checkbox1" value="32" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('32', $selected_perms)){?> checked <?php }?> > NewsletterDelete  
											<input type="checkbox" class="checkbox1" value="31" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('31', $selected_perms)){?> checked <?php }?> > NewsletterEdit   
											<input type="checkbox" class="checkbox1" value="177" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('177', $selected_perms)){?> checked <?php }?> > NewsletterExport  
											<input type="checkbox" class="checkbox1" value="29" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('29', $selected_perms)){?> checked <?php }?> > NewsletterList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Testimonial</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="34" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('34', $selected_perms)){?> checked <?php }?> > TestimonialAdd    
											<input type="checkbox" class="checkbox1" value="36" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('36', $selected_perms)){?> checked <?php }?> > TestimonialDelete   
											<input type="checkbox" class="checkbox1" value="35" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('35', $selected_perms)){?> checked <?php }?> > TestimonialEdit    
											<input type="checkbox" class="checkbox1" value="33" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('33', $selected_perms)){?> checked <?php }?> > TestimonialList   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Customer Says</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="38" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('38', $selected_perms)){?> checked <?php }?> > CustomerSaysAdd     
											<input type="checkbox" class="checkbox1" value="40" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('40', $selected_perms)){?> checked <?php }?> > CustomerSaysDelete    
											<input type="checkbox" class="checkbox1" value="39" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('39', $selected_perms)){?> checked <?php }?> > CustomerSaysEdit     
											<input type="checkbox" class="checkbox1" value="37" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('37', $selected_perms)){?> checked <?php }?> > CustomerSaysList    
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>CollectionTypes</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="42" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('42', $selected_perms)){?> checked <?php }?> > CollectionTypesEdit      
											<input type="checkbox" class="checkbox1" value="41" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('41', $selected_perms)){?> checked <?php }?> > CustomerSaysDelete    
											    
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Order Status</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="43" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('43', $selected_perms)){?> checked <?php }?> > OrderStatusList      
											<input type="checkbox" class="checkbox1" value="44" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('44', $selected_perms)){?> checked <?php }?> > OrderStatusListAdd     
											<input type="checkbox" class="checkbox1" value="46" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('46', $selected_perms)){?> checked <?php }?> > OrderStatusListDelete      
											<input type="checkbox" class="checkbox1" value="45" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('45', $selected_perms)){?> checked <?php }?> > OrderStatusListEdit 
											<input type="checkbox" class="checkbox1" value="47" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('47', $selected_perms)){?> checked <?php }?> > OrderStatusListExport 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Admin Status </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="49" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('49', $selected_perms)){?> checked <?php }?> > AdminStatusAdd       
											<input type="checkbox" class="checkbox1" value="51" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('51', $selected_perms)){?> checked <?php }?> > AdminStatusDelete      
											<input type="checkbox" class="checkbox1" value="50" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('50', $selected_perms)){?> checked <?php }?> > AdminStatusEdit       
											<input type="checkbox" class="checkbox1" value="52" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('52', $selected_perms)){?> checked <?php }?> > AdminStatusExport  
											<input type="checkbox" class="checkbox1" value="48" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('48', $selected_perms)){?> checked <?php }?> > AdminStatusList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Brokerage Status </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="54" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('54', $selected_perms)){?> checked <?php }?> > BrokerageStatusAdd        
											<input type="checkbox" class="checkbox1" value="56" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('56', $selected_perms)){?> checked <?php }?> > BrokerageStatusDelete       
											<input type="checkbox" class="checkbox1" value="55" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('55', $selected_perms)){?> checked <?php }?> > BrokerageStatusEdit        
											<input type="checkbox" class="checkbox1" value="57" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('57', $selected_perms)){?> checked <?php }?> > BrokerageStatusExport   
											<input type="checkbox" class="checkbox1" value="53" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('53', $selected_perms)){?> checked <?php }?> > BrokerageStatusList   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>SMS Templates </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="59" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('59', $selected_perms)){?> checked <?php }?> > SMSTemplatesEdit         
											<input type="checkbox" class="checkbox1" value="58" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('58', $selected_perms)){?> checked <?php }?> > SMSTemplatesList        
										</dd>
									</dl>
							</fieldset>
							
							
						</div>
					</fieldset>
					
					<fieldset><legend class="togvis" style="cursor: pointer;" >Shop Mgnt.(Click to Toggle)</legend>
						<div class="colsp">
							
							<fieldset ><legend class="togvis" style="cursor: pointer;">Vendor Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Vendor Status</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="61" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('61', $selected_perms)){?> checked <?php }?> > VendorStatusAdd  
											<input type="checkbox" class="checkbox1" value="63" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('63', $selected_perms)){?> checked <?php }?> > VendorStatusDelete  
											<input type="checkbox" class="checkbox1" value="62" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('62', $selected_perms)){?> checked <?php }?> > VendorStatusEdit  
											<input type="checkbox" class="checkbox1" value="60" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('60', $selected_perms)){?> checked <?php }?> > VendorStatusList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="65" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('65', $selected_perms)){?> checked <?php }?> > VendorTypeAdd  
											<input type="checkbox" class="checkbox1" value="67" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('67', $selected_perms)){?> checked <?php }?> > VendorTypeDelete 
											<input type="checkbox" class="checkbox1" value="66" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('66', $selected_perms)){?> checked <?php }?> > VendorTypeEdit 
											<input type="checkbox" class="checkbox1" value="64" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('64', $selected_perms)){?> checked <?php }?> > VendorTypeList 
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor Account Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="69" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('69', $selected_perms)){?> checked <?php }?> > VendorAccountTypeAdd   
											<input type="checkbox" class="checkbox1" value="71" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('71', $selected_perms)){?> checked <?php }?> > VendorAccountTypeDelete  
											<input type="checkbox" class="checkbox1" value="70" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('70', $selected_perms)){?> checked <?php }?> > VendorAccountTypeEdit  
											<input type="checkbox" class="checkbox1" value="68" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('68', $selected_perms)){?> checked <?php }?> > VendorAccountTypeList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="73" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('73', $selected_perms)){?> checked <?php }?> > VendorAdd    
											<input type="checkbox"  class="checkbox1" value="75" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('75', $selected_perms)){?> checked <?php }?> > VendorDelete   
											<input type="checkbox"  class="checkbox1" value="74" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('74', $selected_perms)){?> checked <?php }?> > VendorEdit   
											<input type="checkbox"  class="checkbox1" value="76" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('76', $selected_perms)){?> checked <?php }?> > VendorExport 
											<input type="checkbox"  class="checkbox1" value="72" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('72', $selected_perms)){?> checked <?php }?> > VendorList 
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							
							<fieldset ><legend style="cursor: pointer;">Metal Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Metal</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="78" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('78', $selected_perms)){?> checked <?php }?> > MetalAdd   
											<input type="checkbox"  class="checkbox1" value="80" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('80', $selected_perms)){?> checked <?php }?> > MetalDelete   
											<input type="checkbox"  class="checkbox1" value="79" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('79', $selected_perms)){?> checked <?php }?> > MetalEdit   
											<input type="checkbox"  class="checkbox1" value="77" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('77', $selected_perms)){?> checked <?php }?> > MetalList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Color </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="82" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('82', $selected_perms)){?> checked <?php }?> > MetalColorAdd   
											<input type="checkbox" class="checkbox1" value="84" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('84', $selected_perms)){?> checked <?php }?> > MetalColorDelete  
											<input type="checkbox" class="checkbox1" value="83" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('83', $selected_perms)){?> checked <?php }?> > MetalColorEdit  
											<input type="checkbox" class="checkbox1" value="81" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('81', $selected_perms)){?> checked <?php }?> > MetalColorList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Purity</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="86" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('86', $selected_perms)){?> checked <?php }?> > MetalPurityAdd    
											<input type="checkbox"  class="checkbox1" value="88" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('88', $selected_perms)){?> checked <?php }?> > MetalPurityDelete   
											<input type="checkbox"  class="checkbox1" value="87" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('87', $selected_perms)){?> checked <?php }?> > MetalPurityEdit   
											<input type="checkbox"  class="checkbox1" value="85" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('85', $selected_perms)){?> checked <?php }?> > MetalPurityList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Size </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="90" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('90', $selected_perms)){?> checked <?php }?> > MetalSizeAdd     
											<input type="checkbox"  class="checkbox1" value="92" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('92', $selected_perms)){?> checked <?php }?> > MetalSizeDelete    
											<input type="checkbox"  class="checkbox1" value="91" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('91', $selected_perms)){?> checked <?php }?> > MetalSizeEdit    
											<input type="checkbox"  class="checkbox1" value="89" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('89', $selected_perms)){?> checked <?php }?> > MetalSizeList  
											 
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							
							
							<fieldset ><legend style="cursor: pointer;">Stone Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Stone Diamond Clarity</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="94" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('94', $selected_perms)){?> checked <?php }?> > StoneDiamondClarityAdd    
											<input type="checkbox"  class="checkbox1" value="96" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('96', $selected_perms)){?> checked <?php }?> > StoneDiamondClarityDelete    
											<input type="checkbox"  class="checkbox1" value="95" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('95', $selected_perms)){?> checked <?php }?> > StoneDiamondClarityEdit    
											<input type="checkbox"  class="checkbox1" value="93" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('93', $selected_perms)){?> checked <?php }?> > StoneDiamondClarityList    
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Diamond Color</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="98" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('98', $selected_perms)){?> checked <?php }?> > StoneDiamondColorAdd    
											<input type="checkbox"  class="checkbox1" value="100" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('100', $selected_perms)){?> checked <?php }?> > StoneDiamondColorDelete   
											<input type="checkbox"  class="checkbox1" value="99" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('99', $selected_perms)){?> checked <?php }?> > StoneDiamondColorEdit   
											<input type="checkbox"  class="checkbox1" value="97" id="perm_id" name="data[Roleperm][perm_id][]" <?php if(in_array('97', $selected_perms)){?> checked <?php }?> > StoneDiamondColorList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Gemstone</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="102" class="checkbox1"  <?php if(in_array('102', $selected_perms)){?> checked <?php }?> /> StoneGemstoneAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="104" class="checkbox1" <?php if(in_array('104', $selected_perms)){?> checked <?php }?>  /> StoneGemstoneDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="103" class="checkbox1"  <?php if(in_array('103', $selected_perms)){?> checked <?php }?> /> StoneGemstoneEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="101" class="checkbox1" <?php if(in_array('101', $selected_perms)){?> checked <?php }?>  /> StoneGemstoneList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Shape</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="106" class="checkbox1" <?php if(in_array('106', $selected_perms)){?> checked <?php }?> />StoneShapeAdd     
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="108" class="checkbox1" <?php if(in_array('108', $selected_perms)){?> checked <?php }?> />StoneShapeDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="107" class="checkbox1" <?php if(in_array('107', $selected_perms)){?> checked <?php }?> />StoneShapeEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="105" class="checkbox1" <?php if(in_array('105', $selected_perms)){?> checked <?php }?> />StoneShapeList 
											 
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Setting Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="110" class="checkbox1" <?php if(in_array('110', $selected_perms)){?> checked <?php }?> />StoneSettingTypeAdd     
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="112" class="checkbox1" <?php if(in_array('112', $selected_perms)){?> checked <?php }?> />StoneSettingTypeDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="111" class="checkbox1" <?php if(in_array('111', $selected_perms)){?> checked <?php }?> />StoneSettingTypeEdit  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="109" class="checkbox1" <?php if(in_array('109', $selected_perms)){?> checked <?php }?> />StoneSettingTypeList	
											 
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							
							<fieldset ><legend style="cursor: pointer;">Product Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Product Category</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="114" class="checkbox1" <?php if(in_array('114', $selected_perms)){?> checked <?php }?> />ProductCategoryAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="116" class="checkbox1" <?php if(in_array('116', $selected_perms)){?> checked <?php }?> />ProductCategoryDelete	   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="115" class="checkbox1" <?php if(in_array('115', $selected_perms)){?> checked <?php }?> />ProductCategoryEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="113" class="checkbox1" <?php if(in_array('113', $selected_perms)){?> checked <?php }?> />ProductCategoryList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="185" class="checkbox1" <?php if(in_array('185', $selected_perms)){?> checked <?php }?> />ProductCategoryExport
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Product Subcategory</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="118" class="checkbox1" <?php if(in_array('118', $selected_perms)){?> checked <?php }?> />ProductSubcategoryAdd	    
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="120" class="checkbox1" <?php if(in_array('120', $selected_perms)){?> checked <?php }?> />ProductSubcategoryDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="119" class="checkbox1" <?php if(in_array('119', $selected_perms)){?> checked <?php }?> />ProductSubcategoryEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="117" class="checkbox1" <?php if(in_array('117', $selected_perms)){?> checked <?php }?> />ProductSubcategoryList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="184" class="checkbox1" <?php if(in_array('184', $selected_perms)){?> checked <?php }?> />ProductSubcategoryExport											
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Product</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="122" class="checkbox1" <?php if(in_array('122', $selected_perms)){?> checked <?php }?> />ProductAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="124" class="checkbox1" <?php if(in_array('124', $selected_perms)){?> checked <?php }?> />ProductDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="123" class="checkbox1" <?php if(in_array('123', $selected_perms)){?> checked <?php }?> />ProductEdit  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="125" class="checkbox1" <?php if(in_array('125', $selected_perms)){?> checked <?php }?> />ProductExport	
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="121" class="checkbox1" <?php if(in_array('121', $selected_perms)){?> checked <?php }?> />ProductList
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							
							<fieldset ><legend style="cursor: pointer;">Order Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Order</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="128" class="checkbox1" <?php if(in_array('128', $selected_perms)){?> checked <?php }?> />OrderInvoice 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="126" class="checkbox1" <?php if(in_array('126', $selected_perms)){?> checked <?php }?> />OrderList	   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="127" class="checkbox1" <?php if(in_array('127', $selected_perms)){?> checked <?php }?> />OrderView
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="186" class="checkbox1" <?php if(in_array('186', $selected_perms)){?> checked <?php }?> />OrderExport
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Order Tracking</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="129" class="checkbox1" <?php if(in_array('129', $selected_perms)){?> checked <?php }?> />OrderTracking	    
										</dd>
									</dl>
								</fieldset>
								
							</div>	
							</fieldset>
							
							
							<fieldset ><legend style="cursor: pointer;">Discount Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Discount</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="131" class="checkbox1" <?php if(in_array('131', $selected_perms)){?> checked <?php }?> />DiscountAdd 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="133" class="checkbox1" <?php if(in_array('133', $selected_perms)){?> checked <?php }?> />DiscountDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="132" class="checkbox1" <?php if(in_array('132', $selected_perms)){?> checked <?php }?> />DiscountEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="130" class="checkbox1" <?php if(in_array('130', $selected_perms)){?> checked <?php }?> />DiscountList
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							<fieldset ><legend style="cursor: pointer;">Menu Mgnt.(Click to Toggle)</legend>
							<div class="colsp">
								<fieldset class="frits"><legend class='togvis'>Menu</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="135" class="checkbox1" <?php if(in_array('135', $selected_perms)){?> checked <?php }?> />MenuEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="137" class="checkbox1" <?php if(in_array('137', $selected_perms)){?> checked <?php }?> />MenuExport  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="134" class="checkbox1" <?php if(in_array('134', $selected_perms)){?> checked <?php }?> />MenuList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="136" class="checkbox1" <?php if(in_array('136', $selected_perms)){?> checked <?php }?> />MenuView
										</dd>
									</dl>
								</fieldset>
							</div>	
							</fieldset>
							
							
						</div>
					</fieldset>
					
					<fieldset><legend class="togvis" style="cursor: pointer;">User Mgnt.(Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>User Registration.</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="140" class="checkbox1" <?php if(in_array('140', $selected_perms)){?> checked <?php }?> />UserRegistrationDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="139" class="checkbox1" <?php if(in_array('139', $selected_perms)){?> checked <?php }?> />UserRegistrationEdit 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="141" class="checkbox1" <?php if(in_array('141', $selected_perms)){?> checked <?php }?> />UserRegistrationExport 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="138" class="checkbox1" <?php if(in_array('138', $selected_perms)){?> checked <?php }?> />UserRegistrationList 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Franchisee Registration</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="143" class="checkbox1" <?php if(in_array('143', $selected_perms)){?> checked <?php }?> />FranchiseeAdd
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="145" class="checkbox1" <?php if(in_array('145', $selected_perms)){?> checked <?php }?> />FranchiseeDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="144" class="checkbox1" <?php if(in_array('144', $selected_perms)){?> checked <?php }?> />FranchiseeEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="146" class="checkbox1" <?php if(in_array('146', $selected_perms)){?> checked <?php }?> />FranchiseeExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="142" class="checkbox1" <?php if(in_array('142', $selected_perms)){?> checked <?php }?> />FranchiseeList
										</dd>
									</dl>
								
							</fieldset>
							
						</div>
					</fieldset>
					
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Enquires(Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Home Enquires</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="148" class="checkbox1" <?php if(in_array('148', $selected_perms)){?> checked <?php }?> />HomeEnquiriesDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="149" class="checkbox1" <?php if(in_array('149', $selected_perms)){?> checked <?php }?> />HomeEnquiriesExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="147" class="checkbox1" <?php if(in_array('147', $selected_perms)){?> checked <?php }?> />HomeEnquiriesList 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Have a Question</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="152" class="checkbox1" <?php if(in_array('152', $selected_perms)){?> checked <?php }?> />HaveQuestionDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="153" class="checkbox1" <?php if(in_array('153', $selected_perms)){?> checked <?php }?> />HaveQuestionExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="150" class="checkbox1" <?php if(in_array('150', $selected_perms)){?> checked <?php }?> />HaveQuestionList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="151" class="checkbox1" <?php if(in_array('151', $selected_perms)){?> checked <?php }?> />HaveQuestionView
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Customized Request</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="155" class="checkbox1" <?php if(in_array('155', $selected_perms)){?> checked <?php }?> />CustomizedRequestDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="157" class="checkbox1" <?php if(in_array('157', $selected_perms)){?> checked <?php }?> />CustomizedRequestExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="154" class="checkbox1" <?php if(in_array('154', $selected_perms)){?> checked <?php }?> />CustomizedRequestList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="156" class="checkbox1" <?php if(in_array('156', $selected_perms)){?> checked <?php }?> />CustomizedRequestView	
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Contact Us</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="160" class="checkbox1" <?php if(in_array('160', $selected_perms)){?> checked <?php }?>  />ContactusDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="161" class="checkbox1" <?php if(in_array('161', $selected_perms)){?> checked <?php }?>  />ContactusExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="158" class="checkbox1" <?php if(in_array('158', $selected_perms)){?> checked <?php }?>  />ContactusList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="159" class="checkbox1" <?php if(in_array('159', $selected_perms)){?> checked <?php }?>  />ContactusView	
										</dd>
									</dl>
								
							</fieldset>
							
						</div>
					</fieldset>
					
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Review & Rating(Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Rating</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="164" class="checkbox1" <?php if(in_array('164', $selected_perms)){?> checked <?php }?> />RatingDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="162" class="checkbox1" <?php if(in_array('162', $selected_perms)){?> checked <?php }?> />RatingList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="163" class="checkbox1" <?php if(in_array('163', $selected_perms)){?> checked <?php }?> />RatingView 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>WishList</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="165" class="checkbox1" <?php if(in_array('165', $selected_perms)){?> checked <?php }?> />WishList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="166" class="checkbox1" <?php if(in_array('166', $selected_perms)){?> checked <?php }?> />WishListDelete
											
										</dd>
									</dl>
								
							</fieldset>
							
							
						</div>
					</fieldset>
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Price Mgnt.(Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Price</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd>
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="167" class="checkbox1" <?php if(in_array('167', $selected_perms)){?> checked <?php }?> />PriceList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="168" class="checkbox1" <?php if(in_array('168', $selected_perms)){?> checked <?php }?> />PriceAdd
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="170" class="checkbox1" <?php if(in_array('170', $selected_perms)){?> checked <?php }?> />PriceDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="169" class="checkbox1" <?php if(in_array('169', $selected_perms)){?> checked <?php }?> />PriceEdit	
											
										</dd>
									</dl>
								
							</fieldset>
							
							
							
							
						</div>
					</fieldset>
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Brokerage(Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Vendor Brokerage</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="173" class="checkbox1" <?php if(in_array('173', $selected_perms)){?> checked <?php }?> />VendorBrokerageExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="171" class="checkbox1" <?php if(in_array('171', $selected_perms)){?> checked <?php }?> />VendorBrokerageList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="172" class="checkbox1" <?php if(in_array('172', $selected_perms)){?> checked <?php }?> />VendorBrokerageView	
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset ><legend>Franchise Brokerage</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="174" class="checkbox1" <?php if(in_array('174', $selected_perms)){?> checked <?php }?> />FranchiseeBrokerage
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="176" class="checkbox1" <?php if(in_array('176', $selected_perms)){?> checked <?php }?> />FranchiseeBrokerageExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="175" class="checkbox1" <?php if(in_array('175', $selected_perms)){?> checked <?php }?> />FranchiseeBrokerageView	
										</dd>
									</dl>
								
							</fieldset>
							
							
							
							
						</div>
					</fieldset>

                    
                    
                        
                    
            
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
            </dl>
            </fieldset>
        </form>



        
<?php echo $this->Form->end(); ?>
    </div>
</div> 



<script type="text/javascript">
    $(document).ready(function () {
	
	$('fieldset .colsp').hide();
    $('legend').click(function(){
        $(this).parent().find('.colsp').slideToggle("slow");
    });
	
	$('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	
        $('#selecctall').live('click', function (event) {
            //on click

            if (this.checked) { // check select status
                $('.checkbox1').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').addClass('checked');
                    this.checked = true;  //select all checkboxes with class "checkbox1"              
                });
            } else {
                $('.checkbox1').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').removeClass('checked');
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
            }
        });

    });
</script>

