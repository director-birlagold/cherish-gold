<div id="content"  class="clearfix">	
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Product Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Add Product</legend>
                <dl class="inline">

                    <fieldset><legend>Product Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Vendor<span class="required">*</span></label></dt>

                            <dd>
                                <select  name="data[Product][vendor_id]" id="vendor_id" class="validate[required]"  >

                                    <option value="0">Vendor</option>
                                    <?php
                                    foreach ($vendorstatus as $vendorstatus) {

                                        echo '<option value="' . $vendorstatus['Vendor']['vendor_id'] . '" >' . $vendorstatus['Vendor']['Company_name'] . '</option>';
                                    }
                                    ?>
                                </select>         
                            </dd>
                            <div class="vendor_code" style="display:none;">
                                <dt><label for="name">Vendors code<span class="required">*</span></label></dt>     
                                <dd><p class="vendorcode"></p></dd>
                            </div>
                            <dt><label for="name">Vendor Product Code<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][vendor_product_code]" id="product_code"  class="validate[required]" size="50"/></dd>

                            <dt><label for="name">Category<span class="required">*</span></label></dt>   
                            <dd><select class="validate[required] category" name="data[Product][category_id]" id="category">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories as $category) {

                                        echo '<option value="' . $category['Category']['category_id'] . '" >' . $category['Category']['category'] . '</option>';
                                    }
                                    ?>
                                </select></dd>

                            <dt><label for="name">Sub Category</label></dt>  
                            <dd>
                                <select  name="data[Product][subcategory_id]" id="subcategory">

                                    <option value="">Select SubCategory</option>

                                </select>         
                            </dd>

                            <dt><label for="name">Product Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][product_name]" id="product_name"  class="validate[required]" size="50"/></dd>
                            <!--<dd><input type="text" name="data[Product][product_name]" id="product_name"  class="validate[required,custom[onlyLetterSp]]" size="50"/></dd>-->

                            <dt><label for="name">Product Type</label></dt>
                            <dd><input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="1"  /> Plain Gold &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="2" /> Diamond &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="3"  /> Gemstone &nbsp;&nbsp; </dd>
                            <dt><label for="name">Collection Type</label></dt>
                            <dd>
                           <!-- <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="1" />Enchanced collection &nbsp;&nbsp; 
                            <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="2" />Sapphire collection &nbsp;&nbsp;  
                            <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="3" />Emerald collection &nbsp;&nbsp; 
                            <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="4" />Best Discount &nbsp;&nbsp; 
                           <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="5" />Ready Shipping &nbsp;&nbsp;            -->

                                <?php foreach ($collectiontype as $collectiontype) { ?>

                                    <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="<?php echo $collectiontype['Collectiontype']['collectiontype_id'] ?>" /><?php echo $collectiontype['Collectiontype']['collection_name']; ?>&nbsp;&nbsp;


                                <?php } ?>


                            </dd>
							<dt><label for="name">Shopping Assistance Type</label></dt>
                            <dd>
							<?php foreach ($shopping_assistance_type as $shopping_assistance_type) { ?>
								<input type="checkbox" name="data[Product][shopping_assistance_type][]"  id="shopping_assistance_type" size="50" value="<?php echo $shopping_assistance_type['ShoppingAssistance']['shopping_assistance_id'] ?>" /><?php echo $shopping_assistance_type['ShoppingAssistance']['title']; ?>&nbsp;&nbsp;
							<?php } ?>
                            </dd>
                            <dt><label for="name">Product View type</label></dt>
                            <dd>
                                <input type="checkbox" name="data[Product][product_view_type][]"  id="product_view_type" size="50" value="1" />New &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_view_type][]"  id="product_view_type" size="50" value="2" />Sale &nbsp;&nbsp;  
                            </dd>

                            <dt><label for="name">Best Seller</label></dt>
                            <dd>
                                <input type="checkbox" name="data[Product][best_seller]"  id="bestseller" size="50" value="1" />Yes &nbsp;&nbsp; 

                            </dd>
							
							<dt><label for="name">Popular</label></dt>
                            <dd>
                                <input type="checkbox" name="data[Product][popular]"  id="popular" size="50" value="1" />Yes &nbsp;&nbsp; 

                            </dd>
							
							<dt><label for="name">Sub Menu Image</label></dt>
                            <dd>
                                <input type="checkbox" name="data[Product][sub_menu_image]"  id="sub_menu_image" size="50" value="1" />Yes &nbsp;&nbsp; 
							</dd>
							<dt><label for="name">Short Description </label></dt>
                            <dd>
                                <textarea rows="5" cols="50" name="data[Product][short_description]" id="short_description"></textarea>
                            </dd>
                    </fieldset>

                    <fieldset class="sizesdiv2"><legend>Top Menu</legend>
                        <dl class="inline">
                            <div>        
                                <?php
                                ClassRegistry::init('Menu')->Behaviors->attach('Containable');
                                $menus = ClassRegistry::init('Menu')->find('all', array(
                                    'contain' => array(
                                        'Submenu' => array(
                                            'Offer' => array(
                                                'conditions' => array('Offer.is_active' => '1')
                                            ),
                                            'conditions' => array(
                                                'Submenu.is_active' => '1'
                                            )
                                        )),
                                    'conditions' => array(
                                        'Menu.is_active' => '1',
                                        'Menu.menu_id' => array(3, 4, 5, 6, 7, 8)
                                )));
                                
                                foreach ($menus as $menu_id => $menu) {
                                    ?>
                                    <dt><label for="name"><?php echo $menu['Menu']['menu_name'] ?> Menu</label></dt>
                                    <dd>  
                                        <?php foreach ($menu['Submenu'] as $key => $submenu) { ?>
                                            <input type="checkbox" name="data[Product][submenu_ids][]"  size="50" value="<?php echo $submenu['submenu_id'] ?>"
                                                   data-offer="<?php echo $submenu['submenu_id'] ?>" class="submenu_ids <?php echo!empty($submenu['Offer']) ? 'submenu_offer_ids' : '' ?>"/><?php echo $submenu['submenu_name'] ?> &nbsp;&nbsp; 
                                               <?php } ?>
                                    </dd>

                                    <?php
                                    foreach ($menu['Submenu'] as $key => $submenu) {
                                        if (!empty($submenu['Offer'])) {
                                            ?>
                                            <dt class="offer_menu offer_menu_<?php echo $submenu['submenu_id'] ?>">
                                            <label for="name"><?php echo $submenu['submenu_name'] ?> Offer</label>
                                            </dt>
                                            <dd class="offer_menu offer_menu_<?php echo $submenu['submenu_id'] ?>">
                                                <?php foreach ($submenu['Offer'] as $offer) { ?>
                                                    <input type="checkbox" name="data[Product][offer_ids][]"  size="50" value="<?php echo $offer['offer_id'] ?>" class="offer_ids_<?php echo $submenu['submenu_id'] ?>" /><?php echo $offer['offer_name'] ?> &nbsp;&nbsp; 
                                            <?php } ?> 
                                            </dd>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>

                        </dl>
                    </fieldset>


                    <fieldset class="sizediv2" style="display:none;"><legend>Product Size</legend>
                        <dl class="inline">
                            <div >        
                                <dt><label for="name">Size</label></dt>
                                <dd>  <div class="sizesdiv" >  </div>
                                </dd>
                            </div>
                            <!-- <dt><label for="name">Height(in mm)</label></dt>
                             <dd><input type="text" name="data[Product][height]" id="regpincode" onkeypress="return floatnumbers(this,event)" maxlength="6"   size="50"  /></dd>
                              
                             <dt><label for="name">Width(in mm)</label></dt>
                             <dd><input type="text" name="data[Product][width]" id="regphone"  onkeypress="return floatnumbers(this,event)"  size="50" maxlength="6" /></dd>
                             
                             <dt><label for="name">Weight(in gms)<span class="required">*</span></label></dt>
                             <dd><input type="text" name="data[Product][weight]" id="weight"  class="validate[required,custom[number],maxSize[8]]"  onkeypress="return floatnumbers(this,event)"  maxlength="6" size="50" /></dd>
                            </dl>-->
                    </fieldset>


                    <fieldset><legend>Metal Details</legend>
                        <dl class="inline">

                            <dt><label for="name">Metals<span class="required">*</span></label></dt>
                            <dd><select name="data[Product][metal]" class="validate[required] metals" id="metalsdiv" >
                                    <option value="0">Select Metals</option>
                                    <?php
                                    foreach ($metal as $metals) {

                                        echo '<option value="' . $metals['Metal']['metal_name'] . '">' . $metals['Metal']['metal_name'] . '</option>\n';
                                    }
                                    ?>
                                </select></dd>
                            <div class="colors" style="display:none;">
                                <dt><label for="name">Metal Color<span class="required">*</span></label></dt>
                                <dd><div class="metal_colordiv"></div></dd>
                            </div>
                            <div class="purity_div" style="display:none;">
                                <dt><label for="name">Metal Purity<span class="required">*</span></label></dt>
                                <dd><div class="metalpurity_div"></div></dd>
                            </div>
                            <dt><label for="name">Gold Weight<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][metal_weight]" id="weightg"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10  value="<?php
                                if (isset($product['Product']['metal_weight'])) {
                                    echo $new_metal['Product']['metal_weight'];
                                }
                                ?>"/>&nbsp;gm</dd>  
                        </dl>
                        <dt class="goldcoins_only"><label for="name">Metal Fineness<span class="required">*</span></label></dt>
                        <dd class="goldcoins_only">
                            <input type="radio" name="data[Product][metal_fineness][]" class="validate[required]" size="50" value="995"<?php
//                                if (in_array("1", $productviewtype)) {
//                                    echo 'Checked';
//                                }
                            ?> />995 &nbsp;&nbsp; 
                            <input type="radio" name="data[Product][metal_fineness][]" class="validate[required]" size="50" value="999" <?php
//                                if (in_array("2", $productviewtype)) {
//                                    echo 'Checked';
//                                }
                            ?> />999 &nbsp;&nbsp;  
                        </dd>
                    </fieldset>
                    <dl class="inline weight" style="display:none;">
                        <fieldset><legend>Metal Details</legend> <dt><label for="name">Gold Purity <span class="required">*</span></label></dt><dd>
                                <div class="purities_div"></div>
                            </dd></fieldset>
                    </dl>

                    <fieldset><legend>Product Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Making Charges Calculation<span class="required">*</span></label></dt>                                               
                            <dd>
                                <input type="hidden" name="data[Product][making_charge_calc]" value="PER" id="making_charge_calc" />
                                <input type="radio" name="making_charge_calc" class="making_charge_calc validate[required]" value="PER" checked/>&nbsp; % &nbsp; 
                                <input type="radio" name="making_charge_calc" class="making_charge_calc validate[required]" value="INR" />&nbsp; INR
                            </dd>

                            <dt><label for="name">Making Charge<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][making_charge]" id="making_charge"  class="validate[required,custom[number]]" size="50" onkeypress="return intnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['making_charge'])) {
                                    echo $product['Product']['making_charge'];
                                }
                                ?>"/>&nbsp; <span id="making_charge_indicator"></span></dd>  

                            <dt class="goldcoins"><label for="name">Width</label></dt>
                            <dd class="goldcoins">  <input type="text" name="data[Product][width]" id="width"  class="validate-removed[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($this->request->data['Product']['width'])) {
                                    echo $this->request->data['Product']['width'];
                                }
                                ?>"/>&nbsp; mm </dd>

                            <dt class="goldcoins"><label for="name">Height</label></dt>
                            <dd class="goldcoins">   <input type="text" name="data[Product][height]" id="height"  class="validate-removed[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($this->request->data['Product']['height'])) {
                                    echo $this->request->data['Product']['height'];
                                }
                                ?>"/>&nbsp; mm</dd>
                            <dt><label for="name">Stock</label></dt>
                            <dd>
                                <input type="text" name="data[Product][stock_quantity]" id="width"  class="validate-removed[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['stock_quantity'])) {
                                    echo $product['Product']['stock_quantity'];
                                }
                                ?>" />&nbsp;




                        </dl>

                    </fieldset> 


                    <fieldset class="goldcoins"><legend>Diamond Details</legend>
                        <fieldset id="stone_details" ><legend>Is this Diamond?</legend> 
                            <dl class="inline">
                                <dt></dt>
                                <dd> <input type="radio" id="checklist" class="validate[required] radio yes" name="data[Product][stone]" value="Yes"  />Yes&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="checklist" class="validate[required] radio no" name="data[Product][stone]" value="No" checked="checked"/>No&nbsp;&nbsp;&nbsp;</dd>
                            </dl>  
                        </fieldset>

                        <dl class="inline" id="addstone" style="display:none;">
                            <fieldset ><legend>Diamond Details</legend>
                                <dt><label for="name">Diamond<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productdiamond][0][diamond]" class="validate[required]" id="stone0">
                                        <option value="">Select </option>
                                        <?php
                                        foreach ($stone as $stones) {
                                            echo '<option value="' . $stones['Diamond']['name'] . '">' . $stones['Diamond']['name'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>   
                                <dt><label for="name">Stone Clarity<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productdiamond][0][clarity]" class="validate[required] stone_clarity" id="stone_clarity0" rel="0">
                                        <option value="">Select Stone Clarity</option>
                                        <?php
                                        foreach ($clarity as $clarities) {
                                            echo '<option value="' . $clarities['Clarity']['clarity'] . '">' . $clarities['Clarity']['clarity'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd> 
                                <div class="stonecolor_div"></div>                       

                                <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productdiamond][0][shape]" class="validate[required]" id="stone_shape0">
                                        <option value="">Select Stone Shape  </option>
                                        <?php
                                        foreach ($shape as $new_shapes) {
                                            echo '<option value="' . $new_shapes['Shape']['shape'] . '">' . $new_shapes['Shape']['shape'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd> 

                                <dt><label for="name">Setting Type<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productdiamond][0][settingtype]" class="validate[required]" id="setting_type0">
                                        <option value="">Select Setting Type  </option>
                                        <?php
                                        foreach ($type as $new_type) {
                                            echo '<option value="' . $new_type['Settingtype']['settingtype'] . '">' . $new_type['Settingtype']['settingtype'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">No. of Diamonds<span class="required">*</span></label></dt> 
                                <dd><input type="text" name="data[Productdiamond][0][noofdiamonds]" id="noofdiamonds0" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" />  </dd>
                                <dt><label for="name">Stone Weight</label></dt>  
                                <dd><input type="text" name="data[Productdiamond][0][stone_weight]"  id="stone_weight0" class="validate[required]"  onkeypress="return floatnumbers(this, event)" maxlength="6"  />&nbsp; Carat 


                                    &nbsp;&nbsp;&nbsp;<button type="button"  class="button add_stone" name="addstone" value="">ADD STONE</button></dd> </fieldset></dl>   

                        <input type="hidden" name="offical_contacts" id="offical_contacts" value="0"/> 
                    </fieldset>

                    <fieldset class="goldcoins"><legend>Gemstone Details</legend>
                        <fieldset id="stone_details" ><legend>Is this Gemstone?</legend> 
                            <dl class="inline">
                                <dt></dt>
                                <dd> <input type="radio" id="checklist" class="validate[required] radio gemstone1" name="data[Product][gemstone]" value="Yes"  />Yes&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="checklist" class="validate[required] radio gemstone2" name="data[Product][gemstone]" value="No" checked="checked"/>No&nbsp;&nbsp;&nbsp;</dd>
                            </dl>  
                        </fieldset>
                        <dl class="inline addgemstone" style="display:none;">
                            <fieldset ><legend>Gemstone Details</legend>
                                <dt><label for="name">Gemstone<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][gemstone]" class="validate[required]" id="stone_clarity1">
                                        <option value="">Select Gemstone</option>
                                        <?php
                                        foreach ($gem as $gem) {
                                            echo '<option value="' . $gem['Gemstone']['stone'] . '">' . $gem['Gemstone']['stone'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">Size</label></dt> 
                                <dd><input type="text" name="data[Productgemstone][0][size]"  size="50"  id="productsize"/></dd>   
                                <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][shape]" class="validate[required]" id="stone_clarity2">
                                        <option value="">Select Shape</option>
                                        <?php
                                        foreach ($shape as $shape) {
                                            echo '<option value="' . $shape['Shape']['shape'] . '">' . $shape['Shape']['shape'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">Setting Type<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][settingtype]" class="validate[required]" id="setting_type">
                                        <option value="">Select Setting Type  </option>
                                        <?php
                                        foreach ($type as $new_type) {
                                            echo '<option value="' . $new_type['Settingtype']['settingtype'] . '">' . $new_type['Settingtype']['settingtype'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">No. of Gemstone<span class="required">*</span></label></dt> 
                                <dd><input type="text" name="data[Productgemstone][0][no_of_stone]" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" />  </dd>
                                <dt><label for="name">Stone Weight</label></dt>  
                                <dd><input type="text" name="data[Productgemstone][0][stone_weight]"  id="stone_weight"  onkeypress="return floatnumbers(this, event)" maxlength="6"  />&nbsp; Carat 
                                    &nbsp;&nbsp;&nbsp;<button type="button"  class="button addgem" name="addgem" value="">ADD</button></dd> </fieldset></dl>   

                        <input type="hidden" name="offical_contacts" id="gemstone_details" value="0"/> 
                    </fieldset>



                    <fieldset ><legend>Vendor Charges</legend>
                        <fieldset><legend>Do you have any special vendor charges?</legend>
                            <dl class="inline">
                                <dt></dt>
                                <dd> <input type="radio" id="checklist" class="charges_yes" name="data[Product][special_work]" value="Yes" />Yes&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="checklist" class="charges_no" name="data[Product][special_work]" value="No"  checked="checked"/>No&nbsp;&nbsp;&nbsp;</dd>
                            </dl>
                        </fieldset>
                        <fieldset class="charges" style="display:none;"><legend>Vendor Charges</legend>
                            <dl class="inline">
                                <dt><label for="name">Special Work Description&nbsp;<span class="required">*</span></label></dt>                  
                                <dd><input type="text" name="data[Product][special_work_description]"  id="special_work_description" size="50" class="validate[required]"/></dd>

                                <dt><label for="name">Special Work Charges&nbsp;(Rs.)<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Product][special_work_charge]"   id="special_work_charge" size="50" class="validate[required]" /></dd>

                                <dt><label for="name">Making Charges Calculation<span class="required">*</span></label></dt>                                               
                                <dd>
                                    <input type="hidden" name="data[Product][vendor_making_charge_calc]" value="PER" id="vendor_making_charge_calc" />
                                    <input type="radio" name="vendor_making_charge_calc" class="vendor_making_charge_calc validate[required]" value="PER" checked />&nbsp; % &nbsp; 
                                    <input type="radio" name="vendor_making_charge_calc" class="vendor_making_charge_calc validate[required]" value="INR" />&nbsp; INR
                                </dd>

                                <dt><label for="name">Making Charges<span class="required">*</span></label></dt>                                               
                                <dd><input type="text" name="data[Product][vendor_making_charge]" class="validate[required,custom[number]]" id="vendor_making_charge" size="50"  />&nbsp;<span id="vendor_making_charge_indicator">%</span></dd>

                            </dl>
                        </fieldset>
                    </fieldset>
                    <fieldset><legend>VAT</legend>
                        <dl class="inline">                    
                            <dt><label for="name">VAT/CST<span class="required">*</span></label></dt>                                               
                            <dd><input type="text" name="data[Product][vat_cst]" id="vat_cst" size="50" class="validate[required,custom[number]]" onkeypress="return floatnumbers(this, event)" maxlength="6"  />&nbsp;&nbsp;%</dd>               
                        </dl>
                    </fieldset>
                    <fieldset><legend>Product Delivery</legend>
                        <dl class="inline">
                            <dt><label for="name">Vendor delivery TAT<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Product][vendor_delivery_tat]"  id="vendor_delivery_tat" size="10" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)"/> &nbsp;&nbsp;Days  </dd>

                            <dt><label for="name">Product delivery TAT<span class="required">*</span></label></dt>                  
                            <dd><input type="text" name="data[Product][product_delivery_tat]"  id="product_delivery_tat" size="10" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)"/> &nbsp;&nbsp;Days    </dd>

                        </dl>                                                    
                    </fieldset>

                    <fieldset><legend>Certificate Image</legend>
                        <dt>
                        <label for="name">Upload image</label>
                        </dt>
                        <dd>
                            <input name="data[Product][certificate_image]"  id="certificate_image" type="file">
                        </dd>
                        <dt>&nbsp;</dt>
                        <dd><strong>(Please Upload Image size 500 x 166)</strong></dd>
                    </fieldset>


                    <fieldset><legend>Images</legend>
                        <dt>
                        <label for="name">Upload image<span class="required">*</span></label>
                        </dt>
                        <dd>
                            <input name="data[Productimage][image][]" class="validate[required,custom[image]]" id="image0" multiple type="file">
                        </dd>
                        <dt>&nbsp;</dt>
                        <dd><strong>(Please Upload Image size 480 x 385)</strong></dd>
                        <dt>&nbsp;</dt>
                        <dd><strong>( Please click images while a press of Ctrl key ) </strong></dd>
                    </fieldset>
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
    </div>
</div> 
<script>
    $(document).ready(function () {
        $('.add_stone').click(function () {
            var values = parseInt($('#offical_contacts').val()) + 1;
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/stone/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productdiamond][" + values + "][diamond]' id='stonetype" + values + "' class='validate[required] input-md'><option value=''>Select Stone</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Diamond.name + "' '>" + v.Diamond.name + " </option>";
                    });
                    appenddata += "</select>";
                    $('#stone' + values).html(appenddata);
                    $('#stone' + values + ' select').uniform();
                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/stone_clarity/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productdiamond][" + values + "][clarity]' id='stoneclarity" + values + "'  class='validate[required] input-md stone_clarity' rel='" + values + "'><option value=''>Select Stone Clarity</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Clarity.clarity + "' '>" + v.Clarity.clarity + " </option>";
                    });
                    appenddata += "</select>";
                    $('#stone_clarity' + values).html(appenddata);
                    $('#stone_clarity' + values + ' select').uniform();

                }
            });
            //$.ajax({
//		type: "POST",
//		url: "<?php echo BASE_URL; ?>products/stone_color/",
//	    dataType: 'json',
//		success: function (data) {
//			appenddata = "<select name='data[Productdiamond]["+values+"][color]' class='validate[required] input-md'><option value=''>Select Stone Color</option>";
//			$.each(data, function (k, v) {
//			appenddata += "<option value = '" +v.Color.color + "' '>" +v.Color.color + " </option>";
//			});
//			appenddata += "</select>";
//			$('#stone_color'+values).html(appenddata);
//             $('#stone_color'+values+' select').uniform();          
//          }
//		});


            /*$.ajax({
             type: "POST",
             url: "<?php echo BASE_URL; ?>products/stone_carat/",
             dataType: 'json',
             success: function (data) {
             appenddata = "<select name='data[Productdiamond]["+values+"][carat]' class='validate[required] input-md'><option value=''>Select Stone Carat</option>";
             $.each(data, function (k, v) {
             appenddata += "<option value = '" +v.Carat.carat + "' '>" +v.Carat.carat + " </option>";
             });
             appenddata += "</select>";
             $('#stone_carat'+values).html(appenddata);
             $('#stone_carat'+values+' select').uniform();         
             }
             });*/
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/stone_shape/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productdiamond][" + values + "][shape]' id='stoneshape" + values + "'    class='validate[required] input-md'><option value=''>Select Stone Shape</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Shape.shape + "' '>" + v.Shape.shape + " </option>";
                    });
                    appenddata += "</select>";
                    $('#stone_shape' + values).html(appenddata);
                    $('#stone_shape' + values + ' select').uniform();
                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/setting_type/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productdiamond][" + values + "][settingtype]' id='settingtype" + values + "'   class='validate[required] input-md'><option value='0'>Select Setting Type</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Settingtype.settingtype + "' '>" + v.Settingtype.settingtype + " </option>";
                    });
                    appenddata += "</select>";
                    $('#setting_type' + values).html(appenddata);
                    $('#setting_type' + values + ' select').uniform();
                }
            });

        });
    });
</script>


<script>
    $(document).ready(function () {
        /***start****/
        $('.add_stone').click(function () {
            var values = parseInt($('#offical_contacts').val()) + 1;
            $('#addstone').append('<div class="stone"> <fieldset><legend>Stone Details</legend> <dt> <dt><label for="name">Diamond<span class="required">*</span></label></dt> </dt><dd id="stone' + values + '"></dd>' + ' <dt><label for="name">Stone Clarity<span class="required">*</span></label></dt>' + ' <dd id="stone_clarity' + values + '"></dd>' + '<div class="stonecolor_div"></div>' + ' <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> ' + ' <dd id="stone_shape' + values + '">&nbsp;' + ' <dt><label for="name">Setting Type<span class="required">*</span></label></dt> ' + ' <dd id="setting_type' + values + '"></dd>' + '<dt><label for="name">No. of Diamonds<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Productdiamond][' + values + '][noofdiamonds]" onkeypress="return intnumbers(this,event)" class="validate[required,custom[integer]]" id="diamonds' + values + '" size="21" value=""/></dd>' + '<dt><label for="name">Stone Weight</label></dt> <dd><input type="text" name="data[Productdiamond][' + values + '][stone_weight]"  id="stone_weight' + values + '" onkeypress="return floatnumbers(this,event)" maxlength="6" class="validate[required]" />&nbsp;Carat<dt></dt><dd><a class="remove_field">Remove Stone Details</a></dd></fieldset></div>');
            $('.stone input').uniform();
            jQuery("#myForm").validationEngine('attach', {
                autoHidePrompt: true,
                autoHideDelay: 3000,
                onValidationComplete: function (form, status) {
                    if (status == true) {
                        jQuery('.helpfade').show();
                        jQuery('.helptips').show();
                        var id = $('.ckeditor').attr('id');
                        if (typeof id != 'undefined') {
                            var editorcontent = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
                            if (editorcontent.length <= 10) {
                                jQuery('.helpfade').hide();
                                jQuery('.helptips').hide();
                                message("This field is required, Please give minimum 10 characters in the field of " + id);
                                return false;
                            }
                        }
                        form.validationEngine('detach');
                        form.submit();
                    }
                }
            });

            $('#offical_contacts').val(values);

        });
    });
    /********end****/


    $('.remove_field').live('click', function (e) {
        $(this).parents('.stone').remove();
    });

    $('.remove_field_plant').live('click', function (e) {
        $(this).parents('.aplant').remove();
    });
    $('.remove_field_client').live('click', function (e) {
        $(this).parents('.aclient').remove();
    });

</script>


<script>
    $(document).ready(function () {
        $(".yes").click(function () {
            $('#addstone').show();
        });
        $(".no").click(function () {
            $('#addstone').hide();

        });
        $(".charges_yes").click(function () {
            $('.charges').show();
        });
        $(".charges_no").click(function () {
            $('.charges').hide();

        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#vendor_id').on("change", function () {
            var name = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/vendor_code/",
                data: 'id=' + name,
                success: function (msg) {
                    $('.vendor_code').show();
                    $('.vendorcode').html(msg);

                }
            });

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.category').on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/category/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Product][subcategory_id]' class='input-md'><option value=''>Select SubCategory</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Subcategory.subcategory_id + "'>" + v.Subcategory.subcategory + " </option>";
                    });
                    appenddata += "</select>";
                    $('#subcategory').html(appenddata);

                }
            });

            $('#subcategory').parents('.selector').find('span').html('Select Subcategory');

            //added by prakash
            change_category();
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#selecctall').live('click', function (event) {
            //on click

            if (this.checked) { // check select status
                $('.checkbox1').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"              
                });
            } else {
                $('.checkbox1').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
            }
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#selecctall_purity').live('click', function (event) {
            //on click

            if (this.checked) { // check select status
                $('.checkboxp').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').addClass('checked');
                    this.checked = true;  //select all checkboxes with class "checkbox1"              
                });
            } else {
                $('.checkboxp').each(function () { //loop through each checkbox
                    $(this).parents('.checker').find('span').removeClass('checked');
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
            }


        });

        /*   $('#selecctall_purity input').uniform();
         $('#selecctall_purity').css('display','block');*/
    });
</script>
<script>
    $(document).ready(function () {
        $('.category').on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/productsize/",
                data: 'id=' + id,
                dataType: 'html',
                success: function (msg) {

                    if (msg != 'No' && msg != '') {
                        $('.sizediv2').css('display', 'block');
                        $('.sizesdiv').html(msg);
                        $('.metal_colordiv select').uniform();
                    } else if (msg == 'No') {
                        $('.sizediv2').css('display', 'none');
                    }

                }

            });
            $('.sizediv2').css('display', 'none');

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#metalsdiv').on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/metalcolor/",
                data: 'id=' + id,
                dataType: 'html',
                success: function (data) {
                    if (data != 'No') {
                        $('.colors').css('display', 'block');
                        $('.metal_colordiv').html(data);
                        $('.metal_colordiv select').uniform();
                    } else

                    {
                        $('.colors').css('display', 'none');
                    }
                }
            });

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.add_weight').live('click', function () {
            var values = parseInt($('#add_weight_cat').val()) + 1;
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/gold_purity/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productmetal][purity][" + values + "]' class='validate[required] input-md'><option value=''>Select </option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Purity.purity_id + "' '>" + v.Purity.purity + "K </option>";
                    });
                    appenddata += "</select>";
                    $('#goldpurity' + values).html(appenddata);
                    $('#goldpurity' + values + ' select').uniform();

                }

            });

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.category').on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/metal_weight/",
                data: 'id=' + id,
                dataType: 'html',
                success: function (msg) {

                    if (msg != '')
                    {
                        $('.weight').css('display', 'block');
                        $('.purities_div').html(msg);
                        $('.purity_div').css('display', 'none');
                        $('.weight select').uniform();
                        $('.weight input').uniform();

                    }

                }
            });

            $('.purity_div').css('display', 'none');

        });
    });
</script>
<script>
    $(document).ready(function () {
        /***start****/
        $('.add_weight').live('click', function () {
            var values = parseInt($('#add_weight_cat').val()) + 1;
            /*$('.weight').append('<div class="weightdiv"><fieldset><legend>Details</legend><dt><label for="name">Gold Purity<span class="required">*</span></label></dt> </dt><dd id="goldpurity'+values+'"></dd>'+'<dt><label for="name">Weight<span class="required">*</span></label></dt>'+'<dd><input type="text" name="data[Productmetal]['+values+'][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value=""/></dd>'+'<dt><label for="name">Gold Difference</label></dt>'+'<dd><input type="text" name="data[Productmetal]['+values+'][gold_diff]" id="gold_diff"  class="validate[custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value=""/><a class="remove_weight">Remove </a></dd></fieldset></div>');*/

            $('.weight').append('<div class="weightdiv"><fieldset><legend>Details</legend><dt><label for="name">Gold Purity<span class="required">*</span></label></dt> </dt><dd id="goldpurity' + values + '"><a class="remove_weight">Remove </a></dd></fieldset></div>');
            $('.weightdiv input').uniform();


            $('#add_weight_cat').val(values);

        });
    });
    /********end****/


    $('.remove_weight').live('click', function (e) {
        $(this).parents('.weightdiv').remove();
    });



</script>

//        <script>
//$(document).ready(function(){
//	$('.category').on('change',function(){
//
//		$.ajax({
//		type: "POST",
//		url: "<?php echo BASE_URL; ?>products/gold_purity_check/",
//	    dataType: 'html',
//		success: function (data) {
//			if(data!=''){
//		  $('.purity_div').css('display','block');
//		   $('.metalpurity_div').html(data);
//			}
//		 }
//	
//		});
//		
//	});
//});
//</script>
<script>
    $(document).ready(function () {
        /***start****/
        $('.addgem').live('click', function () {
            var values = parseInt($('#gemstone_details').val()) + 1;
            $('.addgemstone').append('<div class="addgems"><fieldset><legend>Details</legend> <dt><label for="name">Gemstone<span class="required">*</span></label></dt> </dt><dd id="gem' + values + '"></dd>' + '<dt><label for="name">Size</label></dt><input type="text" name="data[Productgemstone][' + values + '][size]"  size="50"  id="productsize"/><br><br>' + '<dt><label for="name">Stone Shape<span class="required">*</span></label></dt>' + ' <dd id="clarity' + values + '"></dd>' + '<dt><label for="name">Setting Type<span class="required">*</span></label></dt> ' + ' <dd id="type' + values + '"></dd>' + '<dt><label for="name">No. of Gemstone<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Productgemstone][' + values + '][no_of_stone]" onkeypress="return intnumbers(this,event)" class="validate[required,custom[integer]]" id="diamonds' + values + '" size="21" value=""/></dd>' + '<dt><label for="name">Stone Weight</label></dt> <dd><input type="text" name="data[Productgemstone][' + values + '][stone_weight]"  id="stone_weight' + values + '" onkeypress="return floatnumbers(this,event)" maxlength="6"  />&nbsp;Carat<dt></dt><dd><a class="remove_gemstone">Remove </a></dd></fieldset></div>');
            $('.addgems input').uniform();

            $('#gemstone_details').val(values);

        });
    });
    /********end****/

    $('.remove_gemstone').live('click', function (e) {
        $(this).parents('.addgems').remove();
    });



</script>
<script>
    $(document).ready(function () {
        $('.addgem').click(function () {
            var values = parseInt($('#gemstone_details').val()) + 1;
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/setting_type/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productgemstone][" + values + "][settingtype]' class='validate[required] input-md'><option value='0'>Select Setting Type</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Settingtype.settingtype + "' '>" + v.Settingtype.settingtype + " </option>";
                    });
                    appenddata += "</select>";
                    $('#type' + values).html(appenddata);
                    $('#type' + values + ' select').uniform();
                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/stone_shape/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productgemstone][" + values + "][shape]' class='validate[required] input-md'><option value=''>Select Stone Shape</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Shape.shape + "' '>" + v.Shape.shape + " </option>";
                    });
                    appenddata += "</select>";
                    $('#clarity' + values).html(appenddata);
                    $('#clarity' + values + ' select').uniform();
                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/gem/",
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Productgemstone][" + values + "][gemstone]' class='validate[required] input-md'><option value=''>Select Stone Shape</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Gemstone.stone + "' '>" + v.Gemstone.stone + " </option>";
                    });
                    appenddata += "</select>";
                    $('#gem' + values).html(appenddata);
                    $('#gem' + values + ' select').uniform();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.gemstone1').click(function () {
            $('.addgemstone').show();
        });

        $('.gemstone2').click(function () {
            $('.addgemstone').hide();
        });
    });
</script>

<script>
//$(document).ready(function(){
    $('.stone_clarity').live("change", function () {
        thisvar = $(this);
        var id = $(this).val();
        var rel = $(this).attr('rel');
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL; ?>products/stone_color/",
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                appenddata = "<dt><label for='color'>Stone Color<span class='required'>*</span></label><dd><select name='data[Productdiamond][" + rel + "][color]' id='stonecolor" + rel + "' class='validate[required]input-md stone_color'><option value=''>Select Color</option>";
                $.each(data, function (k, v) {
                    appenddata += "<option value = '" + v.Color.color + "'>" + v.Color.color + " </option>";
                });
                appenddata += "</select></dd>";
                thisvar.parents('dd').next('.stonecolor_div').html(appenddata);
                thisvar.parents('dd').next('.stonecolor_div').find('select').uniform();

            }
        });

        thisvar.parents('dd').next('.stonecolor_div').html('');
    });
//});
</script>


<script type="text/javascript">
    //added by prakash

    $(document).ready(function () {
        change_category();
        vendor_making_charge($("input[name='vendor_making_charge_calc']:checked").val());
        making_charge($("input[name='making_charge_calc']:checked").val());

        $('.vendor_making_charge_calc').click(function () {
            vendor_making_charge($(this).val());
        });
        $('.making_charge_calc').click(function () {
            making_charge($(this).val());
        });
        $('.submenu_ids').click(function () {
            if ($(this).is(':checked')) {
                show_offers($(this).data('offer'), 'show');
            } else {
                show_offers($(this).data('offer'), 'hide');
            }
        });
        $('.submenu_offer_ids').each(function () {
            if ($(this).is(':checked')) {
                show_offers($(this).data('offer'), 'show');
            } else {
                show_offers($(this).data('offer'), 'hide');
            }
        });
    });

    function vendor_making_charge(calc) {
        if (calc == 'PER') {
            $('#vendor_making_charge_indicator').html('%');
        } else {
            $('#vendor_making_charge_indicator').html('INR');
        }
        $('#vendor_making_charge_calc').val(calc);
    }

    function making_charge(calc) {
        if (calc == 'PER') {
            $('#making_charge_indicator').html('%');
        } else {
            $('#making_charge_indicator').html('INR');
        }
        $('#making_charge_calc').val(calc);
    }

    function change_category() {
        var category = $("#category :selected").text();
        if (category.indexOf('Gold Coins') > -1 || category.indexOf('Gold Coin') > -1) {
            $(".goldcoins").hide();
            $(".goldcoins_only").show();
        } else {
            $(".goldcoins").show();
            $(".goldcoins_only").hide();
            if ($('.yes').is(':checked')) {
                $("#addstone").show();
            } else {
                $("#addstone").hide();
            }
        }
    }

    function show_offers(id, mode) {
        if (mode == 'show') {
            $('.offer_menu_' + id).show();
        } else if (mode == 'hide') {
            $('.offer_menu_' + id).hide();
            $('.offer_ids_' + id).prop('checked', false);
            $.uniform.update();
        }
    }

</script>