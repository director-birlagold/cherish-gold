<div id="content"  class="clearfix">	
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Roles Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Add Role</legend>
                <dl class="inline">

                    <fieldset><legend>Role Details</legend>
                        <dl class="inline">
                            
							<dt><label for="name">Role Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Userroles][role_name]" id="role_name"  class="validate[required]" size="80"/></dd>
                            
							<dt><label for="name">&nbsp;</label></dt>
							<dd>
								<input type="checkbox" id="selecctall" /> Check / Uncheck All
                            </dd>
							
							<!--<dt><label for="name">Permissions</label></dt>-->
                            <!--<dd>-->
							<!--<div style="width:613px;margin:0 auto;">
								<?php 
								for($i = 0; $i < sizeof($permissions);$i++){
									//echo $permissions[$i]['Permissions']['perm_id'];
								?>
								
									
									<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="<?php echo $permissions[$i]['Permissions']['perm_id']; ?>" class="checkbox1"/><?php echo $permissions[$i]['Permissions']['perm_desc']; ?>
									
									

                                <?php if($i != 0 && $i % 3 == 0)
										echo '<br />';
										} ?>
							</div>-->

							
							
                            <!--</dd>-->
                            

                            
                    </fieldset>
					
					
					
					
					
					<fieldset><legend class="togvis" style="cursor: pointer;">Settings (Click to Toggle)</legend>
						<div class="colsp">
							<fieldset ><legend>Admin User</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="178" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminUserAdd 
											<input type="checkbox" class="checkbox1" value="181" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminUserDelete 
											<input type="checkbox" class="checkbox1" value="179" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminUserEdit 
											<input type="checkbox" class="checkbox1" value="180" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminUserList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>User Permissions</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="7" id="perm_id" name="data[Roleperm][perm_id][]"  > PermissionAdd 
											<input type="checkbox" class="checkbox1" value="8" id="perm_id" name="data[Roleperm][perm_id][]"  > PermissionEdit 
											<input type="checkbox" class="checkbox1" value="6" id="perm_id" name="data[Roleperm][perm_id][]"  > PermissionList
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>User Roles</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="2" id="perm_id" name="data[Roleperm][perm_id][]"  > RoleAdd  
											<input type="checkbox" class="checkbox1" value="5" id="perm_id" name="data[Roleperm][perm_id][]"  > RoleDelete  
											<input type="checkbox" class="checkbox1" value="3" id="perm_id" name="data[Roleperm][perm_id][]"  > RoleEdit  
											<input type="checkbox" class="checkbox1" value="4" id="perm_id" name="data[Roleperm][perm_id][]"  > RoleList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>My Account</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="9" id="perm_id" name="data[Roleperm][perm_id][]"  > MyAccount 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Change Password</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="10" id="perm_id" name="data[Roleperm][perm_id][]"  > ChangePassword  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Shipping Rates</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="12" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesAdd 
											<input type="checkbox" class="checkbox1" value="14" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesDelete 
											<input type="checkbox" class="checkbox1" value="13" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesEdit 
											<input type="checkbox" class="checkbox1" value="16" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesExport 
											<input type="checkbox" class="checkbox1" value="15" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesImport 
											<input type="checkbox" class="checkbox1" value="11" id="perm_id" name="data[Roleperm][perm_id][]"  > ShippingRatesList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Payment</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="17" id="perm_id" name="data[Roleperm][perm_id][]"  > Payment   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Partial Payment</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="18" id="perm_id" name="data[Roleperm][perm_id][]"  > PartialPayment    
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
											<input type="checkbox" class="checkbox1" value="20" id="perm_id" name="data[Roleperm][perm_id][]"  > EmailContentsEdit  
											<input type="checkbox" class="checkbox1" value="19" id="perm_id" name="data[Roleperm][perm_id][]"  > EmailContentsList  
											
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Content Pages</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="22" id="perm_id" name="data[Roleperm][perm_id][]"  > ContentPagesEdit 
											<input type="checkbox" class="checkbox1" value="21" id="perm_id" name="data[Roleperm][perm_id][]"  > ContentPagesList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Banner</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="24" id="perm_id" name="data[Roleperm][perm_id][]"  > BannerAdd  
											<input type="checkbox" class="checkbox1" value="26" id="perm_id" name="data[Roleperm][perm_id][]"  > BannerDelete 
											<input type="checkbox" class="checkbox1" value="25" id="perm_id" name="data[Roleperm][perm_id][]"  > BannerEdit  
											<input type="checkbox" class="checkbox1" value="23" id="perm_id" name="data[Roleperm][perm_id][]"  > BannerList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Advertisement Banner</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="28" id="perm_id" name="data[Roleperm][perm_id][]"  > AdvertisementBannerEdit   
											<input type="checkbox" class="checkbox1" value="27" id="perm_id" name="data[Roleperm][perm_id][]"  > AdvertisementBannerList  
											
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>News Letter</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="30" id="perm_id" name="data[Roleperm][perm_id][]"  > NewsletterAdd   
											<input type="checkbox" class="checkbox1" value="32" id="perm_id" name="data[Roleperm][perm_id][]"  > NewsletterDelete  
											<input type="checkbox" class="checkbox1" value="31" id="perm_id" name="data[Roleperm][perm_id][]"  > NewsletterEdit   
											<input type="checkbox" class="checkbox1" value="177" id="perm_id" name="data[Roleperm][perm_id][]"  > NewsletterExport  
											<input type="checkbox" class="checkbox1" value="29" id="perm_id" name="data[Roleperm][perm_id][]"  > NewsletterList 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Testimonial</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="34" id="perm_id" name="data[Roleperm][perm_id][]"  > TestimonialAdd    
											<input type="checkbox" class="checkbox1" value="36" id="perm_id" name="data[Roleperm][perm_id][]"  > TestimonialDelete   
											<input type="checkbox" class="checkbox1" value="35" id="perm_id" name="data[Roleperm][perm_id][]"  > TestimonialEdit    
											<input type="checkbox" class="checkbox1" value="33" id="perm_id" name="data[Roleperm][perm_id][]"  > TestimonialList   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Customer Says</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="38" id="perm_id" name="data[Roleperm][perm_id][]"  > CustomerSaysAdd     
											<input type="checkbox" class="checkbox1" value="40" id="perm_id" name="data[Roleperm][perm_id][]"  > CustomerSaysDelete    
											<input type="checkbox" class="checkbox1" value="39" id="perm_id" name="data[Roleperm][perm_id][]"  > CustomerSaysEdit     
											<input type="checkbox" class="checkbox1" value="37" id="perm_id" name="data[Roleperm][perm_id][]"  > CustomerSaysList    
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>CollectionTypes</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="42" id="perm_id" name="data[Roleperm][perm_id][]"  > CollectionTypesEdit      
											<input type="checkbox" class="checkbox1" value="41" id="perm_id" name="data[Roleperm][perm_id][]"  > CustomerSaysDelete    
											    
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Order Status</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="43" id="perm_id" name="data[Roleperm][perm_id][]"  > OrderStatusList      
											<input type="checkbox" class="checkbox1" value="44" id="perm_id" name="data[Roleperm][perm_id][]"  > OrderStatusListAdd     
											<input type="checkbox" class="checkbox1" value="46" id="perm_id" name="data[Roleperm][perm_id][]"  > OrderStatusListDelete      
											<input type="checkbox" class="checkbox1" value="45" id="perm_id" name="data[Roleperm][perm_id][]"  > OrderStatusListEdit 
											<input type="checkbox" class="checkbox1" value="47" id="perm_id" name="data[Roleperm][perm_id][]"  > OrderStatusListExport 
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Admin Status </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="49" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminStatusAdd       
											<input type="checkbox" class="checkbox1" value="51" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminStatusDelete      
											<input type="checkbox" class="checkbox1" value="50" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminStatusEdit       
											<input type="checkbox" class="checkbox1" value="52" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminStatusExport  
											<input type="checkbox" class="checkbox1" value="48" id="perm_id" name="data[Roleperm][perm_id][]"  > AdminStatusList  
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>Brokerage Status </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="54" id="perm_id" name="data[Roleperm][perm_id][]"  > BrokerageStatusAdd        
											<input type="checkbox" class="checkbox1" value="56" id="perm_id" name="data[Roleperm][perm_id][]"  > BrokerageStatusDelete       
											<input type="checkbox" class="checkbox1" value="55" id="perm_id" name="data[Roleperm][perm_id][]"  > BrokerageStatusEdit        
											<input type="checkbox" class="checkbox1" value="57" id="perm_id" name="data[Roleperm][perm_id][]"  > BrokerageStatusExport   
											<input type="checkbox" class="checkbox1" value="53" id="perm_id" name="data[Roleperm][perm_id][]"  > BrokerageStatusList   
										</dd>
									</dl>
							</fieldset>
							
							<fieldset><legend>SMS Templates </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="59" id="perm_id" name="data[Roleperm][perm_id][]"  > SMSTemplatesEdit         
											<input type="checkbox" class="checkbox1" value="58" id="perm_id" name="data[Roleperm][perm_id][]"  > SMSTemplatesList        
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
											<input type="checkbox" class="checkbox1" value="61" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorStatusAdd  
											<input type="checkbox" class="checkbox1" value="63" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorStatusDelete  
											<input type="checkbox" class="checkbox1" value="62" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorStatusEdit  
											<input type="checkbox" class="checkbox1" value="60" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorStatusList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="65" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorTypeAdd  
											<input type="checkbox" class="checkbox1" value="67" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorTypeDelete 
											<input type="checkbox" class="checkbox1" value="66" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorTypeEdit 
											<input type="checkbox" class="checkbox1" value="64" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorTypeList 
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor Account Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="69" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorAccountTypeAdd   
											<input type="checkbox" class="checkbox1" value="71" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorAccountTypeDelete  
											<input type="checkbox" class="checkbox1" value="70" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorAccountTypeEdit  
											<input type="checkbox" class="checkbox1" value="68" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorAccountTypeList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Vendor </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="73" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorAdd    
											<input type="checkbox"  class="checkbox1" value="75" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorDelete   
											<input type="checkbox"  class="checkbox1" value="74" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorEdit   
											<input type="checkbox"  class="checkbox1" value="76" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorExport 
											<input type="checkbox"  class="checkbox1" value="72" id="perm_id" name="data[Roleperm][perm_id][]"  > VendorList 
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
											<input type="checkbox"  class="checkbox1" value="78" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalAdd   
											<input type="checkbox"  class="checkbox1" value="80" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalDelete   
											<input type="checkbox"  class="checkbox1" value="79" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalEdit   
											<input type="checkbox"  class="checkbox1" value="77" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Color </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" class="checkbox1" value="82" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalColorAdd   
											<input type="checkbox" class="checkbox1" value="84" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalColorDelete  
											<input type="checkbox" class="checkbox1" value="83" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalColorEdit  
											<input type="checkbox" class="checkbox1" value="77" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalColorList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Purity</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="86" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalPurityAdd    
											<input type="checkbox"  class="checkbox1" value="88" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalPurityDelete   
											<input type="checkbox"  class="checkbox1" value="87" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalPurityEdit   
											<input type="checkbox"  class="checkbox1" value="85" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalPurityList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Metal Size </legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="90" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalSizeAdd     
											<input type="checkbox"  class="checkbox1" value="92" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalSizeDelete    
											<input type="checkbox"  class="checkbox1" value="91" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalSizeEdit    
											<input type="checkbox"  class="checkbox1" value="89" id="perm_id" name="data[Roleperm][perm_id][]"  > MetalSizeList  
											 
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
											<input type="checkbox"  class="checkbox1" value="94" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondClarityAdd    
											<input type="checkbox"  class="checkbox1" value="96" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondClarityDelete    
											<input type="checkbox"  class="checkbox1" value="95" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondClarityEdit    
											<input type="checkbox"  class="checkbox1" value="93" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondClarityList    
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Diamond Color</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox"  class="checkbox1" value="98" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondColorAdd    
											<input type="checkbox"  class="checkbox1" value="100" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondColorDelete   
											<input type="checkbox"  class="checkbox1" value="99" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondColorEdit   
											<input type="checkbox"  class="checkbox1" value="97" id="perm_id" name="data[Roleperm][perm_id][]"  > StoneDiamondColorList   
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Gemstone</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="102" class="checkbox1"   /> StoneGemstoneAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="104" class="checkbox1"   /> StoneGemstoneDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="103" class="checkbox1"   /> StoneGemstoneEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="101" class="checkbox1"   /> StoneGemstoneList  
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Shape</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="106" class="checkbox1"  />StoneShapeAdd     
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="108" class="checkbox1"  />StoneShapeDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="107" class="checkbox1"  />StoneShapeEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="105" class="checkbox1"  />StoneShapeList 
											 
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Stone Setting Type</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="110" class="checkbox1"  />StoneSettingTypeAdd     
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="112" class="checkbox1"  />StoneSettingTypeDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="111" class="checkbox1"  />StoneSettingTypeEdit  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="109" class="checkbox1"  />StoneSettingTypeList	
											 
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="114" class="checkbox1"  />ProductCategoryAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="116" class="checkbox1"  />ProductCategoryDelete	   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="115" class="checkbox1"  />ProductCategoryEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="113" class="checkbox1"  />ProductCategoryList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="185" class="checkbox1"  />ProductCategoryExport
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Product Subcategory</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="118" class="checkbox1"  />ProductSubcategoryAdd	    
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="120" class="checkbox1"  />ProductSubcategoryDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="119" class="checkbox1"  />ProductSubcategoryEdit   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="117" class="checkbox1"  />ProductSubcategoryList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="184" class="checkbox1"  />ProductSubcategoryExport											
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Product</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="122" class="checkbox1"  />ProductAdd   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="124" class="checkbox1"  />ProductDelete  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="123" class="checkbox1"  />ProductEdit  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="125" class="checkbox1"  />ProductExport	
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="121" class="checkbox1"  />ProductList
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="128" class="checkbox1"  />OrderInvoice 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="126" class="checkbox1"  />OrderList	   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="127" class="checkbox1"  />OrderView
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="186" class="checkbox1"  />OrderExport
										</dd>
									</dl>
								</fieldset>
								
								<fieldset class="frits"><legend>Order Tracking</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="129" class="checkbox1"  />OrderTracking	    
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="131" class="checkbox1"  />DiscountAdd 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="133" class="checkbox1"  />DiscountDelete   
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="132" class="checkbox1"  />DiscountEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="130" class="checkbox1"  />DiscountList
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="135" class="checkbox1"  />MenuEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="137" class="checkbox1"  />MenuExport  
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="134" class="checkbox1"  />MenuList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="136" class="checkbox1"  />MenuView
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="140" class="checkbox1"  />UserRegistrationDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="139" class="checkbox1"  />UserRegistrationEdit 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="141" class="checkbox1"  />UserRegistrationExport 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="138" class="checkbox1"  />UserRegistrationList 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Franchisee Registration</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="143" class="checkbox1"  />FranchiseeAdd
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="145" class="checkbox1"  />FranchiseeDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="144" class="checkbox1"  />FranchiseeEdit
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="146" class="checkbox1"  />FranchiseeExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="142" class="checkbox1"  />FranchiseeList
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="148" class="checkbox1"  />HomeEnquiriesDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="149" class="checkbox1"  />HomeEnquiriesExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="147" class="checkbox1"  />HomeEnquiriesList 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Have a Question</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="152" class="checkbox1"  />HaveQuestionDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="153" class="checkbox1"  />HaveQuestionExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="150" class="checkbox1"  />HaveQuestionList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="151" class="checkbox1"  />HaveQuestionView
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Customized Request</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="155" class="checkbox1"  />CustomizedRequestDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="157" class="checkbox1"  />CustomizedRequestExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="154" class="checkbox1"  />CustomizedRequestList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="156" class="checkbox1"  />CustomizedRequestView	
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>Contact Us</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="160" class="checkbox1"  />ContactusDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="161" class="checkbox1"  />ContactusExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="158" class="checkbox1"  />ContactusList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="159" class="checkbox1"  />ContactusView	
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="164" class="checkbox1"  />RatingDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="162" class="checkbox1"  />RatingList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="163" class="checkbox1"  />RatingView 
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset><legend>WishList</legend>
								
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="165" class="checkbox1"  />WishList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="166" class="checkbox1"  />WishListDelete
											
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="167" class="checkbox1"  />PriceList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="168" class="checkbox1"  />PriceAdd
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="170" class="checkbox1"  />PriceDelete
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="169" class="checkbox1"  />PriceEdit	
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
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="173" class="checkbox1"  />VendorBrokerageExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="171" class="checkbox1"  />VendorBrokerageList
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="172" class="checkbox1"  />VendorBrokerageView	
										</dd>
									</dl>
								
							</fieldset>
							
							<fieldset ><legend>Franchise Brokerage</legend>
									<dl class="inline">
										<dt></dt>
										<dd> 
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="174" class="checkbox1"  />FranchiseeBrokerage
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="176" class="checkbox1"  />FranchiseeBrokerageExport
											<input type="checkbox" name="data[Roleperm][perm_id][]" id="perm_id" value="175" class="checkbox1"  />FranchiseeBrokerageView	
										</dd>
									</dl>
								
							</fieldset>
							
							
							
							
						</div>
					</fieldset>

                    
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
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