<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Product Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
        <form name="Leftadverstiment" id="myForm" method="post" enctype="multipart/form-data" action>   
            <fieldset><legend>Edit Product</legend>
                <dl class="inline">

                    <fieldset><legend>Product Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Vendor Name<span class="required">*</span></label></dt>

                            <dd>
                                <select  name="data[Product][vendor_id]" id="vendor_id" class="validate[required]"  >
                                    <option value="">Vendor Name</option>
                                    <?php
                                    foreach ($vendorstatus as $vendorstatus) {
                                        echo '<option value="' . $vendorstatus['Vendor']['vendor_id'] . '" ' . ($product['Product']['vendor_id'] == $vendorstatus['Vendor']['vendor_id'] ? 'selected="selected"' : '') . ' >' . $vendorstatus['Vendor']['Company_name'] . '</option>';
                                    }
                                    ?>
                                </select>         
                            </dd>
                            <input type="hidden" name="some" class="product_id" value="<?php echo $product['Product']['product_id']; ?>"/>
                            <div class="code">
                                <dt><label for="name">Vendors code<span class="required">*</span></label></dt>     
                                <dd><p class="vendor_code"><?php echo $vendor[0]['Vendor']['vendor_code'] ?></p></dd>
                            </div>

                            <div class="new_vendor_code" style="display:none;">
                                <dt><label for="name">Vendors code<span class="required">*</span></label></dt>     
                                <dd><p class="vendorcode"></p></dd>
                            </div>

                            <dt><label for="name">Vendor Product Code<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][vendor_product_code]" id="product_code"  class="validate[required]" size="50" value="<?php echo $product['Product']['vendor_product_code'] ?>" /></dd>

                            <dt><label for="name">Category<span class="required">*</span></label></dt>   
                            <dd><select class="validate[required] category " name="data[Product][category_id]" id="category">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories as $category) {

                                        echo '<option value="' . $category['Category']['category_id'] . '" ' . ($product['Product']['category_id'] == $category['Category']['category_id'] ? 'selected="selected"' : '') . '>' . $category['Category']['category'] . '</option>';
                                    }
                                    ?>
                                </select></dd>

                            <dt><label for="name">Sub Category</label></dt>  
                            <dd>

                                <?php $subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $product['Product']['category_id']))); ?>
                                <select  name="data[Product][subcategory_id]" id="subcategory">

                                    <option value="">Select SubCategory</option>
                                    <?php
                                    foreach ($subcategory as $subcategories) {

                                        echo '<option value="' . $subcategories['Subcategory']['subcategory_id'] . '" ' . ($product['Product']['subcategory_id'] == $subcategories['Subcategory']['subcategory_id'] ? 'selected="selected"' : '') . ' >' . $subcategories['Subcategory']['subcategory'] . '</option>';
                                    }
                                    ?>
                                </select>         
                            </dd>

                            <dt><label for="name">Product Name<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][product_name]" id="product_name"  class="validate[required]" size="50" value="<?php echo $product['Product']['product_name'] ?>"/></dd>
                            <!--<dd><input type="text" name="data[Product][product_name]" id="product_name"  class="validate[required,custom[onlyLetterSp]]" size="50" value="<?php echo $product['Product']['product_name'] ?>"/></dd>-->
                            <dt><label for="name">Product Type</label></dt>
                            <?php $producttype = explode(",", $product['Product']['product_type']); ?>          
                            <dd><input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="1"  
                                <?php
                                if (in_array("1", $producttype)) {
                                    echo 'Checked';
                                }
                                ?>/> Plain Gold &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="2"  
                                <?php
                                if (in_array("2", $producttype)) {
                                    echo 'Checked';
                                }
                                ?>/> Diamond &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_type][]"  id="product_type1" size="50" value="3" 
                                <?php
                                if (in_array("3", $producttype)) {
                                    echo 'Checked';
                                }
                                ?>/> Gemstone &nbsp;&nbsp; </dd> 


                            <dt><label for="name">Collection Type</label></dt>
                            <?php $collectiontype_val = explode(",", $product['Product']['collection_type']); ?>          
                        <dd><!--<input type="checkbox" name="data[Product][collection_type][]"  id="product_type1" size="50" value="1"   
                                <?php
                                if (in_array("1", $collectiontype)) {
                                    echo 'Checked';
                                }
                                ?>/> Enchanced collection &nbsp;&nbsp; 
                          <input type="checkbox" name="data[Product][collection_type][]"  id="product_type1" size="50" value="2"  
                                <?php
                                if (in_array("2", $collectiontype)) {
                                    echo 'Checked';
                                }
                                ?>/>Sapphire collection &nbsp;&nbsp; 
                            <input type="checkbox" name="data[Product][collection_type][]"  id="product_type1" size="50" value="3"  
                                <?php
                                if (in_array("3", $collectiontype)) {
                                    echo 'Checked';
                                }
                                ?>/>Emerald collection  &nbsp;&nbsp;
                             <input type="checkbox" name="data[Product][collection_type][]"  id="product_type1" size="50" value="4"  
                                <?php
                                if (in_array("4", $collectiontype)) {
                                    echo 'Checked';
                                }
                                ?>/>Best Discount  &nbsp;&nbsp;
                             <input type="checkbox" name="data[Product][collection_type][]"  id="product_type1" size="50" value="5"  
                                <?php
                                if (in_array("5", $collectiontype)) {
                                    echo 'Checked';
                                }
                                ?>/>Ready Shipping  &nbsp;&nbsp;-->

                                <?php foreach ($collectiontype as $collectiontype) { ?>
                                    <input type="checkbox" name="data[Product][collection_type][]"  id="collection_type" size="50" value="<?php echo $collectiontype['Collectiontype']['collectiontype_id'] ?>" <?php
                                    if (in_array($collectiontype['Collectiontype']['collectiontype_id'], $collectiontype_val)) {
                                        echo 'Checked';
                                    }
                                    echo " />";
                                    echo $collectiontype['Collectiontype']['collection_name']; ?>&nbsp;&nbsp;
                                <?php } ?>        

                            </dd> 
                            <?php $productviewtype = explode(",", $product['Product']['product_view_type']); ?>       

                            <dt><label for="name">Product View type</label></dt>
                            <dd>
                                <input type="checkbox" name="data[Product][product_view_type][]"  id="product_view_type" size="50" value="1"<?php
                                if (in_array("1", $productviewtype)) {
                                    echo 'Checked';
                                }
                                ?> />New &nbsp;&nbsp; 
                                <input type="checkbox" name="data[Product][product_view_type][]"  id="product_view_type" size="50" value="2" <?php
                                if (in_array("2", $productviewtype)) {
                                    echo 'Checked';
                                }
                                ?> />Sale &nbsp;&nbsp;  
                            </dd>     

                            <dt><label for="name">Best Seller</label></dt>
                            <dd>

                                <input type="checkbox" name="data[Product][best_seller]"  id="bestseller" size="50" value="1"  <?php
                                if ($product['Product']['best_seller'] == '1') {
                                    echo 'Checked';
                                } else {
                                    echo '';
                                }
                                ?>/>Yes &nbsp;&nbsp; 

                            </dd>         


                        </dl>
                    </fieldset>

                    <fieldset class="sizesdiv2"><legend>Top Menu</legend>
                        <dl class="inline">
                            <div>        
                                <?php
                                $menus = ClassRegistry::init('Menu')->find('all', array('recursive' => 2, 'conditions' => array('is_active' => 1, 'menu_id' => array(4, 5, 6, 7, 8))));
                                $product_menus = explode(",", $product['Product']['submenu_ids']);
                                $product_offers = explode(",", $product['Product']['offer_ids']);
                                foreach ($menus as $menu_id => $menu) {
                                    ?>
                                    <dt><label for="name"><?php echo $menu['Menu']['menu_name'] ?> Menu</label></dt>
                                    <dd>  
                                        <?php foreach ($menu['Submenu'] as $key => $submenu) { ?>
                                            <input type="checkbox" name="data[Product][submenu_ids][]"  size="50" value="<?php echo $submenu['submenu_id'] ?>"<?php
                                            if (in_array($submenu['submenu_id'], $product_menus)) {
                                                echo 'Checked';
                                            }
                                            ?> data-offer="<?php echo $submenu['submenu_id']?>" class="submenu_ids <?php echo !empty($submenu['Offer']) ? 'submenu_offer_ids' : ''?>"/><?php echo $submenu['submenu_name'] ?> &nbsp;&nbsp; 
                                    <?php } ?>
                                    </dd>
                                    
                                    <?php 
                                    foreach ($menu['Submenu'] as $key => $submenu) { 
                                        if(!empty($submenu['Offer'])){?>
                                                <dt class="offer_menu offer_menu_<?php echo $submenu['submenu_id']?>">
                                                    <label for="name"><?php echo $submenu['submenu_name'] ?> Offer</label>
                                                </dt>
                                                <dd class="offer_menu offer_menu_<?php echo $submenu['submenu_id']?>">
                                                <?php foreach ($submenu['Offer'] as $offer) {?>
                                                    <input type="checkbox" name="data[Product][offer_ids][]"  size="50" value="<?php echo $offer['offer_id'] ?>"<?php
                                                    if (in_array($offer['offer_id'], $product_offers)) {
                                                        echo 'Checked';
                                                    }
                                                    ?> class="offer_ids_<?php echo $submenu['submenu_id']?> validate[required]" /><?php echo $offer['offer_name'] ?> &nbsp;&nbsp; 
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
                    <?php
                    $puritysome = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'], 'category_id' => $product['Product']['category_id'], 'type' => 'Size')));
                    ?>
                    <div class="newproductsize" <?php
                    if (!empty($puritysome)) {
                        echo 'style="display:block";';
                    } else {
                        echo 'style="display:none";';
                    }
                    ?>>
                        <fieldset class="sizesdiv2"><legend>Product Size</legend>
                            <dl class="inline">
<?php $sizes = ClassRegistry::init('Size')->find('all', array('conditions' => array('category_id' => $product['Product']['category_id']), 'group' => 'size', 'order' => 'size_id ASC')); ?>
                                <div >        
                                    <dt><label for="name">Size</label></dt>
                                    <dd>  <div class="sizesdiv" >
                                                     <!-- <input type="checkbox" id="selecctall">&nbsp;Select all&nbsp;-->
                                            <?php
                                            $k = 0;
                                            foreach ($sizes as $sizes) {
                                                $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
                                                if ($category['Category']['category'] != 'Bangles') {
                                                    $sizeproduct = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'], 'category_id' => $product['Product']['category_id'], 'type' => 'Size', 'value' => $sizes['Size']['size'])));
                                                    $val = $sizes['Size']['size'];
                                                    if (!empty($sizeproduct)) {
                                                        if ($val == $sizeproduct['Productmetal']['value']) {
                                                            $sel = 'checked="checked"';
                                                        } else {
                                                            $sel = '';
                                                        }
                                                    } else {
                                                        $sel = '';
                                                    }
                                                } else {
                                                    $sizeproduct = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'], 'category_id' => $product['Product']['category_id'], 'type' => 'Size', 'value' => $sizes['Size']['size_value'])));
                                                    $val = $sizes['Size']['size_value'];

                                                    if (!empty($sizeproduct)) {
                                                        if ($val == $sizeproduct['Productmetal']['value']) {
                                                            $sel = 'checked="checked"';
                                                        } else {
                                                            $sel = '';
                                                        }
                                                    } else {
                                                        $sel = '';
                                                    }
                                                }
                                                ?>
                                                <input type="checkbox" name="data[Productmetal][size][]" class="checkbox1" value="<?php echo $val; ?>" <?php
                                                if (!empty($sizeproduct)) {
                                                    echo $sel;
                                                }
                                                ?>/><?php echo $sizes['Size']['size']; ?>
                                                       <?php
                                            }
                                            ?> </div>
                                    </dd>
                                </div>

                            </dl>
                        </fieldset>
                    </div>


                    <fieldset ><legend>Metal Details</legend>
                        <dl class="inline">

                            <dt><label for="name">Metals<span class="required">*</span></label></dt>
                            <dd><select name="data[Product][metal]" class="validate[required] metals" id="metalsdiv">
                                    <option value="">Select Metals</option>
                                    <?php
                                    foreach ($metal as $metals) {

                                        echo '<option value="' . $metals['Metal']['metal_name'] . '"  ' . ($product['Product']['metal'] == $metals['Metal']['metal_name'] ? 'selected="selected"' : '') . '>' . $metals['Metal']['metal_name'] . '</option>\n';
                                    }
                                    ?>
                                </select></dd>
                            <div class="colors">    


                                <dt><label for="name">Metal Color<span class="required">*</span></label></dt>
                                <dd><div class="metal_colordiv" >
                                        <?php
                                        $ids = explode(',', $product['Product']['metal_color']);
                                        foreach ($metalcolor as $metalcolor) {
                                            ?>
                                            <input type="checkbox" name="data[Product][metal_color][]" class="validate[required]" value="<?php echo $metalcolor['Metalcolor']['metalcolor']; ?>"
                                            <?php
                                            if (in_array($metalcolor['Metalcolor']['metalcolor'], $ids)) {
                                                echo 'checked="checked"';
                                            }
                                            ?>/><?php echo $metalcolor['Metalcolor']['metalcolor']; ?>


                                        <?php }
                                        ?>
                                    </div></dd>
                            </div>
                            <?php
                            $golds = ClassRegistry::init('Purity')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'purity_id ASC'));
                            $puritysome = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'], 'category_id' => $product['Product']['category_id'], 'type' => 'Purity')));
                            ?>
                            <div class="purity_div" <?php
                            if (!empty($puritysome)) {
                                echo 'style="display:block";';
                            } else {
                                echo 'style="display:none";';
                            }
                            ?> >
                                <dt><label for="name">Metal Purity<span class="required">*</span></label></dt>
                                <dd><div class="metalpurity_div">
                           <!-- <input type="checkbox" id="selecctall_purity">&nbsp;Select all&nbsp;-->
                                        <?php
                                        foreach ($golds as $golds) {
                                            $purity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'], 'category_id' => $product['Product']['category_id'], 'type' => 'Purity', 'value' => $golds['Purity']['purity'])));
                                            ?>
                                            <input type="checkbox" name="data[Productmetal][purity][]" value="<?php echo $golds['Purity']['purity']; ?>" <?php
                                            if (!empty($purity)) {
                                                if ($golds['Purity']['purity'] == $purity['Productmetal']['value']) {
                                                    echo 'checked="checked"';
                                                }
                                            }
                                            ?> class="validate[required] checkboxp"/><?php echo $golds['Purity']['purity']; ?>K&nbsp;

                                            <?php
                                        }
                                        ?></div></dd>
                            </div>
                            <dt><label for="name">Gold Weight<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][metal_weight]" id="weightg"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10  value="<?php
                                if (isset($product['Product']['metal_weight'])) {
                                    echo $product['Product']['metal_weight'];
                                }
                                ?>"/>&nbsp;gm</dd>  
                            <dt class="goldcoins_only"><label for="name">Metal Fineness<span class="required">*</span></label></dt>
                            <dd class="goldcoins_only">
                                <?php $fineness = explode(",", $product['Product']['metal_fineness']) ?>
                                <input type="radio" name="data[Product][metal_fineness][]" class="validate[required]" size="50" value="995"<?php
                                if (in_array("995", $fineness)) {
                                    echo 'Checked';
                                }
                                ?> />995 &nbsp;&nbsp; 
                                <input type="radio" name="data[Product][metal_fineness][]" class="validate[required]" size="50" value="999" <?php
                                if (in_array("999", $fineness)) {
                                    echo 'Checked';
                                }
                                ?> />999 &nbsp;&nbsp;  
                            </dd>


                        </dl>
                    </fieldset>


                    <fieldset><legend>Product Details</legend>
                        <dl class="inline">
                            <dt><label for="name">Making Charges Calculation<span class="required">*</span></label></dt>                                               
                            <dd>
                                <input type="hidden" name="data[Product][making_charge_calc]" value="PER" id="making_charge_calc" />
                                <input type="radio" name="making_charge_calc" class="making_charge_calc validate[required]" value="PER" <?php echo $product['Product']['making_charge_calc'] == 'PER' ? 'checked' : '' ?>/>&nbsp; % &nbsp; 
                                <input type="radio" name="making_charge_calc" class="making_charge_calc validate[required]" value="INR" <?php echo $product['Product']['making_charge_calc'] == 'INR' ? 'checked' : '' ?>/>&nbsp; INR
                            </dd>

                            <dt><label for="name">Making Charge<span class="required">*</span></label></dt>
                            <dd><input type="text" name="data[Product][making_charge]" id="making_charge"  class="validate[required,custom[number]]" size="50" onkeypress="return intnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['making_charge'])) {
                                    echo $product['Product']['making_charge'];
                                }
                                ?>"/>&nbsp; <span id="making_charge_indicator"></span></dd>  

                            <dt class="goldcoins"><label for="name">Height<span class="required">*</span></label></dt>
                            <dd class="goldcoins"><input type="text" name="data[Product][height]" id="height"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['height'])) {
                                    echo $product['Product']['height'];
                                }
                                ?>" />&nbsp; mm  </dd>  

                            <dt class="goldcoins"><label for="name">Width<span class="required">*</span></label></dt>
                            <dd class="goldcoins"><input type="text" name="data[Product][width]" id="width"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['width'])) {
                                    echo $product['Product']['width'];
                                }
                                ?>" />&nbsp; mm

                            <dt><label for="name">Stock<span class="required">*</span></label></dt>
                            <dd>
                                <input type="text" name="data[Product][stock_quantity]" id="width"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this, event)" maxlength=10 value="<?php
                                if (isset($product['Product']['stock_quantity'])) {
                                    echo $product['Product']['stock_quantity'];
                                }
                                ?>" />&nbsp;

                        </dl>



                    </fieldset>

                    <fieldset class="goldcoins"><legend>Diamond Details</legend>
                        <fieldset><legend>Is this Diamond?</legend>

                            <dl class="inline">
                                <dt></dt>
                                <dd> <input type="radio" id="checklist" class=" validate[required] yes" name="data[Product][stone]" value="Yes"  <?php
                                    if ($product['Product']['stone'] == 'Yes') {
                                        echo 'checked="checked"';
                                    }
                                    ?> />Yes&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="checklist" class="validate[required] no" name="data[Product][stone]" value="No"  <?php
                                    if ($product['Product']['stone'] == 'No') {
                                        echo 'checked="checked"';
                                    }
                                    ?>/>No&nbsp;&nbsp;&nbsp;</dd>
                            </dl>
                        </fieldset>        
                        <?php
                        if (!empty($new_size)) {
                            $vccount = count($new_size);
                            $i = 0;
                            foreach ($new_size as $new_size) {
                                ?>
                                <dl class="inline addstone" id="addstone" <?php
                                if ($product['Product']['stone'] == 'No') {
                                    echo 'style="display:none;"';
                                }
                                ?>>
                                    <fieldset class="stone_details" ><legend>Stone Details</legend>       


                                        <dt><label for="name">Diamond<span class="required">*</span></label></dt> 
                                        <dd><select name="data[Productdiamond][<?php echo $i; ?>][diamond]" class="validate[required]" id="stone<?php echo $i; ?>" >
                                                <option value="">Select Stone</option>

                                                <?php
                                                foreach ($stone as $stones) {
                                                    echo '<option value="' . $stones['Diamond']['name'] . '"' . ($new_size['Productdiamond']['diamond'] == $stones['Diamond']['name'] ? 'selected="selected"' : '') . '>' . $stones['Diamond']['name'] . '</option>\n';
                                                }
                                                ?>	                   


                                            </select></dd>
                                        <dt><label for="name">Stone Clarity<span class="required">*</span></label></dt> 
                                        <dd><select name="data[Productdiamond][<?php echo $i; ?>][clarity]" class="validate[required] stone_clarity" id="stone_clarity<?php echo $i; ?>" rel="<?php echo $i; ?>">
                                                <option value="">Select Stone Clarity</option>
                                                <?php
                                                foreach ($clarity as $clarities) {
                                                    echo '<option value="' . $clarities['Clarity']['clarity'] . '"' . ($new_size['Productdiamond']['clarity'] == $clarities['Clarity']['clarity'] ? 'selected="selected"' : '') . '>' . $clarities['Clarity']['clarity'] . '</option>\n';
                                                }
                                                ?>
                                            </select></dd>  
                                        <?php
                                        $colordiv = ClassRegistry::init('Color')->find('all', array('conditions' => array('clarity' => $new_size['Productdiamond']['clarity'])));
                                        ?>
                                        <div class="stonecolor_div">
                                            <dt><label for="name">Stone Color<span class="required">*</span></label></dt> 
                                            <dd><select name="data[Productdiamond][<?php echo $i; ?>][color]" class="validate[required]" id="stone_color<?php echo $i; ?>">
                                                    <option value="">Select Stone Color</option>
                                                    <?php
                                                    foreach ($colordiv as $colordiv) {
                                                        echo '<option value="' . $colordiv['Color']['color'] . '"' . ($new_size['Productdiamond']['color'] == $colordiv['Color']['color'] ? 'selected="selected"' : '') . '>' . $colordiv['Color']['color'] . '</option>\n';
                                                    }
                                                    ?>
                                                </select></dd>   

                                        </div>

                                        <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                                        <dd><select name="data[Productdiamond][<?php echo $i; ?>][shape]" class="validate[required]" id="stone_shape<?php echo $i; ?>">
                                                <option value="">Select Stone Shape  </option>
                                                <?php
                                                foreach ($shape as $new_shapes) {
                                                    echo '<option value="' . $new_shapes['Shape']['shape'] . '"' . ($new_size['Productdiamond']['shape'] == $new_shapes['Shape']['shape'] ? 'selected="selected"' : '') . '>' . $new_shapes['Shape']['shape'] . '</option>\n';
                                                }
                                                ?>
                                            </select></dd> 

                                        <dt><label for="name">Setting Type<span class="required">*</span></label></dt> 
                                        <dd><select name="data[Productdiamond][<?php echo $i; ?>][settingtype]" class="validate[required]" id="setting_type<?php echo $i; ?>">
                                                <option value="">Select Setting Type  </option>
                                                <?php
                                                foreach ($type as $new_type) {
                                                    echo '<option value="' . $new_type['Settingtype']['settingtype'] . '"' . ($new_size['Productdiamond']['settingtype'] == $new_type['Settingtype']['settingtype'] ? 'selected="selected"' : '') . '>' . $new_type['Settingtype']['settingtype'] . '</option>\n';
                                                }
                                                ?>
                                            </select></dd>
                                        <dt><label for="name">No. of Diamonds<span class="required">*</span></label></dt> 
                                        <dd><input type="text" name="data[Productdiamond][<?php echo $i; ?>][noofdiamonds]" id="diamonds<?php echo $i; ?>" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" value="<?php echo $new_size['Productdiamond']['noofdiamonds'] ?>"  /></dd> 
                                        <dt><label for="name">Stone Weight</label></dt>  
                                        <dd><input type="text" name="data[Productdiamond][<?php echo $i; ?>][stone_weight]"  id="stone_weight<?php echo $i; ?>"  onkeypress="return floatnumbers(this, event)" maxlength="6"  value="<?php
                                            if (!empty($new_size['Productdiamond']['stone_weight'])) {
                                                echo $new_size['Productdiamond']['stone_weight'];
                                            }
                                            ?>" class="validate[required]" />&nbsp;Carat&nbsp;&nbsp;
        <?php if ($i > 0) { ?>
                                                <a class="remove_field">Remove</a></dd> </fieldset>
                                    </dl>
                                <?php } else {
                                    ?>
                                    <button type="button" class="button add_stone" name="addcontacts"  value="">Add</button></dd> </fieldset>
                            </dl>
                        <?php } ?>

                        <?php
                        $i++;
                    }
                } else {
                    $vccount = 0;
                    ?> <dl class="inline goldcoins" id="addstone" style="display:none;">
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
                            <dd><select name="data[Productdiamond][0][clarity]" class="validate[required] stone_clarity " id="stone_clarity0" rel="0">
                                    <option value="">Select Stone Clarity</option>
                                    <?php
                                    foreach ($clarity as $clarities) {
                                        echo '<option value="' . $clarities['Clarity']['clarity'] . '">' . $clarities['Clarity']['clarity'] . '</option>\n';
                                    }
                                    ?>
                                </select></dd>  
    <?php ?>
                            <div class="stonecolor_div"></div> 

                            <dt><label for="name">Stone Carat<span class="required">*</span></label></dt> 
                            <dd><select name="data[Productdiamond][0][carat]" class="validate[required]" id="stone_carat0">
                                    <option value="">Select Stone Carat  </option>
                                    <?php
                                    foreach ($carats as $carat) {
                                        echo '<option value="' . $carat['Carat']['carat'] . '">' . $carat['Carat']['carat'] . '</option>\n';
                                    }
                                    ?>
                                </select></dd>

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
                            <dd><input type="text" name="data[Productdiamond][0][noofdiamonds]" id="diamonds0" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" />  </dd>
                            <dt><label for="name">Stone Weight</label></dt>  
                            <dd><input type="text" name="data[Productdiamond][0][stone_weight]"  id="stone_weight0"  onkeypress="return floatnumbers(this, event)" maxlength="6"  />&nbsp; Carat 


                                &nbsp;&nbsp;&nbsp;<button type="button"  class="button add_stone" name="addstone" value="">ADD STONE</button></dd> </fieldset></dl>   
                <?php }
                ?>
                <input type="hidden" name="offical_contacts" id="offical_contacts" value="<?php echo $vccount; ?>"/>
            </fieldset>
            <fieldset class="goldcoins"><legend>Gemstone Details</legend>
                <fieldset id="stone_details" ><legend>Is this Gemstone?</legend> 
                    <dl class="inline">
                        <dt></dt>
                        <dd> <input type="radio" id="checklist" class="validate[required] radio gemstone1" name="data[Product][gemstone]" value="Yes"   <?php
                            if ($product['Product']['gemstone'] == 'Yes') {
                                echo 'checked="checked"';
                            }
                            ?> />Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="checklist" class="validate[required] radio gemstone2" name="data[Product][gemstone]" value="No"  <?php
                            if ($product['Product']['gemstone'] == 'No') {
                                echo 'checked="checked"';
                            }
                            ?> />No&nbsp;&nbsp;&nbsp;</dd>
                    </dl>  
                </fieldset>

                <?php
                if (!empty($new_stone)) {
                    $vccount = count($new_stone);
                    $i = 0;
                    foreach ($new_stone as $new_stone) {
                        $gem = ClassRegistry::init('Gemstone')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
                        $shape = ClassRegistry::init('Shape')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
                        ?>

                        <dl class="inline addgemstone" <?php
                        if ($product['Product']['gemstone'] == 'No') {
                            echo 'style="display:none;"';
                        }
                        ?>>
                            <fieldset ><legend>Gemstone Details</legend>
                                <dt><label for="name">Gemstone<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][gemstone]" class="validate[required]" id="stone_clarity">
                                        <option value="">Select Gemstone</option>
                                        <?php
                                        foreach ($gem as $gem) {
                                            echo '<option value="' . $gem['Gemstone']['stone'] . '"' . ($gem['Gemstone']['stone'] == $new_stone['Productgemstone']['gemstone'] ? 'selected="selected"' : '') . '>' . $gem['Gemstone']['stone'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">Size<span class="required">*</span></label></dt> 
                                <dd><input type="text" name="data[Productgemstone][0][size]" class="validate[required]" size="50"  id="productsize"  value="<?php
                                    if (!empty($new_stone['Productgemstone']['size'])) {
                                        echo $new_stone['Productgemstone']['size'];
                                    }
                                    ?>"/></dd>   
                                <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][shape]" class="validate[required]" id="stone_clarity">
                                        <option value="">Select Shape</option>
                                        <?php
                                        foreach ($shape as $shape) {
                                            echo '<option value="' . $shape['Shape']['shape'] . '"' . ($shape['Shape']['shape'] == $new_stone['Productgemstone']['shape'] ? 'selected="selected"' : '') . '>' . $shape['Shape']['shape'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">Setting Type<span class="required">*</span></label></dt> 
                                <dd><select name="data[Productgemstone][0][settingtype]" class="validate[required]" id="setting_type">
                                        <option value="">Select Setting Type  </option>
                                        <?php
                                        foreach ($type as $new_type) {
                                            echo '<option value="' . $new_type['Settingtype']['settingtype'] . '"' . ($new_type['Settingtype']['settingtype'] == $new_stone['Productgemstone']['settingtype'] ? 'selected="selected"' : '') . '>' . $new_type['Settingtype']['settingtype'] . '</option>\n';
                                        }
                                        ?>
                                    </select></dd>
                                <dt><label for="name">No. of Gemstone<span class="required">*</span></label></dt> 
                                <dd><input type="text" name="data[Productgemstone][0][no_of_stone]" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)"   value="<?php
                                    if (!empty($new_stone['Productgemstone']['no_of_stone'])) {
                                        echo $new_stone['Productgemstone']['no_of_stone'];
                                    }
                                    ?>"/>  </dd>
                                <dt><label for="name">Stone Weight</label></dt>  
                                <dd><input type="text" name="data[Productgemstone][0][stone_weight]"  id="stone_weight" class="validate[required]"  onkeypress="return floatnumbers(this, event)" maxlength="6"   value="<?php
                                    if (!empty($new_stone['Productgemstone']['stone_weight'])) {
                                        echo $new_stone['Productgemstone']['stone_weight'];
                                    }
                                    ?>" />&nbsp; Carat 
                                    &nbsp;&nbsp;&nbsp;   

        <?php if ($i > 0) { ?>
                                        <a class="remove_gemstone">Remove</a></dd> </fieldset>
                            </dl>
                        <?php } else {
                            ?>
                            <button type="button" class="button addgem" name="addcontacts"  value="">Add</button></dd> </fieldset>
                        </dl>
                    <?php } ?>

                    <?php
                    $i++;
                }
            } else {
                $vccount = 0;
                ?>
                <dl class="inline addgemstone goldcoins" style="display:none;">
                    <fieldset ><legend>Gemstone Details</legend>
                        <dt><label for="name">Gemstone<span class="required">*</span></label></dt> 
                        <dd><select name="data[Productgemstone][0][gemstone]" class="validate[required]" id="stone_clarity">
                                <option value="">Select Gemstone</option>
                                <?php
                                foreach ($gem as $gem) {
                                    echo '<option value="' . $gem['Gemstone']['stone'] . '">' . $gem['Gemstone']['stone'] . '</option>\n';
                                }
                                ?>
                            </select></dd>
                        <dt><label for="name">Size<span class="required">*</span></label></dt> 
                        <dd><input type="text" name="data[Productgemstone][0][size]" class="validate[required]" size="50"  id="productsize"/></dd>   
                        <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                        <dd><select name="data[Productgemstone][0][shape]" class="validate[required]" id="stone_clarity">
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
                            &nbsp;&nbsp;&nbsp;<button type="button"  class="button addgem" name="addgem" value="">ADD</button></dd> </fieldset></dl>    <?php }
                            ?>
            <input type="hidden" name="offical_contacts" id="gemstone_details" value="<?php echo $vccount; ?>"/>
            </fieldset>

            <?php
            if ($product['Product']['special_work'] == 'Yes') {
                $yes = 'checked="checked"';
            }
            if ($product['Product']['special_work'] == 'No') {
                $no = 'checked="checked"';
            }
            ?>
            <fieldset><legend>Do you have any special vendor charges?</legend>
                <dl class="inline">
                    <dt></dt>
                    <dd> <input type="radio" id="checklist" class="charges_yes" name="data[Product][special_work]" value="Yes" <?php
                        if ($product['Product']['special_work'] == 'Yes') {
                            echo $yes;
                        }
                        ?> />Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="checklist" class="charges_no" name="data[Product][special_work]" value="No"  <?php
                        if ($product['Product']['special_work'] == 'No') {
                            echo $no;
                        }
                        ?> />No&nbsp;&nbsp;&nbsp;</dd>
                </dl>
            </fieldset>
            <fieldset class="charges"  <?php
            if ($product['Product']['special_work'] == 'No') {
                echo 'style="display:none;"';
            }
            ?>><legend>Vendor Charges</legend>
                <dl class="inline">
                    <dt><label for="name">Special Work Description&nbsp;<span class="required">*</span></label></dt>                  
                    <dd><input type="text" name="data[Product][special_work_description]"  id="special_work_description" size="50" class="validate[required]" value="<?php echo $product['Product']['special_work_description'] ?>"/></dd>

                    <dt><label for="name">Special Work Charges&nbsp;(Rs.)<span class="required">*</span></label></dt>                                               
                    <dd><input type="text" name="data[Product][special_work_charge]"   id="special_work_charge" size="50" class="validate[required]" value="<?php echo $product['Product']['special_work_charge'] ?>" /></dd>

                    <dt><label for="name">Vendor Making Charges Calculation<span class="required">*</span></label></dt>                                               
                    <dd>
                        <input type="hidden" name="data[Product][vendor_making_charge_calc]" value="PER" id="vendor_making_charge_calc" />
                        <input type="radio" name="vendor_making_charge_calc" class="vendor_making_charge_calc validate[required]" value="PER" <?php echo $product['Product']['vendor_making_charge_calc'] == 'PER' ? 'checked' : '' ?>/>&nbsp; % &nbsp; 
                        <input type="radio" name="vendor_making_charge_calc" class="vendor_making_charge_calc validate[required]" value="INR" <?php echo $product['Product']['vendor_making_charge_calc'] == 'INR' ? 'checked' : '' ?>/>&nbsp; INR
                    </dd>

                    <dt><label for="name">Making Charges<span class="required">*</span></label></dt>                                               
                    <dd><input type="text" name="data[Product][vendor_making_charge]" class="validate[required,custom[number]]" id="vendor_making_charge" size="50"  value="<?php echo $product['Product']['vendor_making_charge'] ?>" />&nbsp; <span id="vendor_making_charge_indicator"></span></dd>

                </dl>
            </fieldset>
            <fieldset><legend>VAT</legend>
                <dl class="inline">

                    <dt><label for="name">VAT/CST<span class="required">*</span></label></dt>                                               
                    <dd><input type="text" name="data[Product][vat_cst]" id="vat_cst" size="50" class="validate[required,custom[integer]]" value="<?php echo $product['Product']['vat_cst'] ?>" />&nbsp;&nbsp; %</dd>

            </fieldset>
            <fieldset><legend>Product Delivery</legend>
                <dl class="inline">

                    <dt><label for="name">Vendor delivery TAT<span class="required">*</span></label></dt>                  
                    <dd><input type="text" name="data[Product][vendor_delivery_tat]"  id="vendor_delivery_tat1" size="10" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" value="<?php echo $product['Product']['vendor_delivery_tat']; ?>"/>&nbsp;&nbsp;  Days

                    </dd>


                    <dt><label for="name">Product delivery TAT<span class="required">*</span></label></dt>                  
                    <dd><input type="text" name="data[Product][product_delivery_tat]"  id="product_delivery_tat1" size="10" class="validate[required,custom[integer]]" onkeypress="return intnumbers(this, event)" value="<?php
                        if (!empty($product['Product']['product_delivery_tat'])) {
                            echo $product['Product']['product_delivery_tat'];
                        }
                        ?>"/>&nbsp;&nbsp; Days

                    </dd>
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
                <dt>&nbsp;</dt>
                <dd><?php echo $this->Html->image('certificate/big/' . $product['Product']['certificate_image'], array('alt' => '')); ?></dd>
            </fieldset>
            <fieldset><legend>Images</legend>
                <dt>
                <label for="name">Upload image<span class="required">*</span></label>
                </dt>
                <dd>
                    <input name="data[Productimage][image][]"  id="image0" multiple type="file">
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


<?php echo $this->Form->create('', array('Controller' => 'products', 'action' => 'deleteimages/' . $this->params['pass']['0'], 'id' => 'myForm')); ?>
        <fieldset style="padding:20px 0;">
            <legend>Images</legend>
            <label style="margin-left:20px">
            <!--  <input type="checkbox" id="checkAllAuto" name="action[]" value="0"  class="validate[minCheckbox[1]] checkbox" rel="action" />
              Select All</label>-->
                <div style="float:left; width:100%;">
                    <ul id="gallery" style="padding:10px 0;">
                        <?php
                        if (!empty($images)) {
                            foreach ($images as $image) {
                                ?>
                                <li style="position:relative;margin:15px 8px;min-height:130px;width:175px; display: inline; float: left;">
                                    <div><?php echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('class' => 'img', 'width' => '170', 'height' => '120px')); ?></div>
                                    <div style="margin:10px 0">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                           <!--   <td align="center"><input type="checkbox" name="action[]" value="<?php echo $image['Productimage']['image_id']; ?>" rel="action" /></td>-->
                                                <td align="center"><?php echo $this->Html->image('icons/cross.png', array('url' => array('action' => 'deleteimages', $this->params['pass']['0'], $image['Productimage']['image_id']), 'border' => 0, 'class' => 'confirdel', 'alt' => __('Delete'))); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            ?>
                            <li style="width:100%;text-align:center;color:#F00;" > NO IMAGE FOUND</li>
<?php } ?>
                    </ul>
                </div>
                <div class="tablefooter clearfix">
                    <!-- <div class="actions">
                       <input type="submit" id="action_btn" class="button" value="Delete" />
                     </div>-->
                </div>
        </fieldset>
<?php echo $this->Form->end(); ?>
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
            $('#addstone').append('<div class="stone"> <fieldset><legend>Stone Details</legend> <dt> <dt><label for="name">Diamond<span class="required">*</span></label></dt> </dt><dd id="stone' + values + '"></dd>' + ' <dt><label for="name">Stone Clarity<span class="required">*</span></label></dt>' + ' <dd id="stone_clarity' + values + '"></dd>' + '<div class="stonecolor_div"></div>' + '<dt><label for="name">Stone Shape<span class="required">*</span></label></dt> ' + ' <dd id="stone_shape' + values + '">&nbsp;' + ' <dt><label for="name">Setting Type<span class="required">*</span></label></dt> ' + ' <dd id="setting_type' + values + '">&nbsp;</dd>' + '<dt><label for="name">No. of Diamonds<span class="required">*</span></label></dt><dd><input type="text" name="data[Productdiamond][' + values + '][noofdiamonds]" onkeypress="return intnumbers(this,event)" class="validate[required,custom[integer]]" id="diamonds' + values + '" size="21" value=""/></dd>' + '<dt><label for="name">Stone Weight</label></dt> <dd><input type="text" name="data[Productdiamond][' + values + '][stone_weight]"  id="stone_weight' + values + '" onkeypress="return floatnumbers(this,event)" maxlength="6"  class="validate[required]" />&nbsp;Carat<dt></dt><dd><a class="remove_field">Remove Stone Details</a></dd></fieldset></div>');
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
    $('.remove_field').live('click', function (e) {
        $(this).parents('.stone_details').remove();
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
            $('.code').hide();
            var name = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/vendor_code/",
                data: 'id=' + name,
                success: function (msg) {
                    $('.new_vendor_code').show();
                    $('.vendorcode').html(msg);

                }
            });

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#category').on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>products/category/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='data[Notification][branch_id]' class='input-md'><option value=''>Select SubCategory</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Subcategory.subcategory_id + "' '>" + v.Subcategory.subcategory + " </option>";
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
                        $('.newproductsize').css('display', 'block');
                        $('.sizediv2').css('display', 'block');
                        $('.sizesdiv').html(msg);
                        $('.metal_colordiv select').uniform();
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
                        $('.weight').html(msg);
                        $('.purity_div').css('display', 'block');
                        $('.weight select').uniform();
                        $('.weight input').uniform();

                    }

                }
            });


            $('.newproductsize').css('display', 'none');

        });
    });
</script>
<script>
    $(document).ready(function () {
        /***start****/
        $('.add_weight').live('click', function () {
            var values = parseInt($('#add_weight_cat').val()) + 1;
            $('.weight').append('<div class="weightdiv"><fieldset><legend>Details</legend><dt><label for="name">Gold Purity<span class="required">*</span></label></dt> </dt><dd id="goldpurity' + values + '"></dd>' + '<dt><label for="name">Weight<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Productmetal][' + values + '][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value=""/></dd>' + '<dt><label for="name">Gold Difference</label></dt>' + '<dd><input type="text" name="data[Productmetal][' + values + '][gold_diff]" id="gold_diff"  class="validate[custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value=""/><a class="remove_weight">Remove </a></dd></fieldset></div>');
            $('.weightdiv input').uniform();


            $('#add_weight_cat').val(values);

        });
    });
    /********end****/


    $('.remove_weight').live('click', function (e) {
        $(this).parents('.weightdiv').remove();
    });



</script>


<script>
    $(document).ready(function () {
        /***start****/
        $('.addgem').live('click', function () {
            var values = parseInt($('#gemstone_details').val()) + 1;
            $('.addgemstone').append('<div class="addgems"><fieldset><legend>Details</legend> <dt><label for="name">Gemstone<span class="required">*</span></label></dt> </dt><dd id="gem' + values + '"></dd>' + '<dt><label for="name">Size<span class="required">*</span></label></dt><input type="text" name="data[Productgemstone][' + values + '][size]" class="validate[required]" size="50"  id="productsize"/><br><br>' + '<dt><label for="name">Stone Shape<span class="required">*</span></label></dt>' + ' <dd id="clarity' + values + '"></dd>' + '<dt><label for="name">Setting Type<span class="required">*</span></label></dt> ' + ' <dd id="type' + values + '"></dd>' + '<dt><label for="name">No. of Gemstone<span class="required">*</span></label></dt>' + '<dd><input type="text" name="data[Productgemstone][' + values + '][no_of_stone]" onkeypress="return intnumbers(this,event)" class="validate[required,custom[integer]]" id="diamonds' + values + '" size="21" value=""/></dd>' + '<dt><label for="name">Stone Weight</label></dt> <dd><input type="text" name="data[Productgemstone][' + values + '][stone_weight]"  id="stone_weight' + values + '" onkeypress="return floatnumbers(this,event)" maxlength="6"  />&nbsp;Carat<dt></dt><dd><a class="remove_gemstone">Remove </a></dd></fieldset></div>');
            $('.addgems input').uniform();


            $('#gemstone_details').val(values);

        });
    });
    /********end****/


    $('.remove_gemstone').live('click', function (e) {
        $(this).parents('.addgems').remove();
    });
    $('.remove_gemstone').live('click', function (e) {
        $(this).parents('.addgemstone').remove();
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


    });
//});
</script>
<script type="text/javascript">
    $(document).ready(function () {
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

<script type="text/javascript">
    //added by prakash
    
    $(document).ready(function () {
        $('.offer_menu').hide();
        change_category();
        vendor_making_charge($("input[name='vendor_making_charge_calc']:checked").val());
        making_charge($("input[name='making_charge_calc']:checked").val());
        
        $('.vendor_making_charge_calc').click(function(){
            vendor_making_charge($(this).val());
        });
        $('.making_charge_calc').click(function(){
            making_charge($(this).val());
        });
        $('.submenu_ids').click(function(){
            if($(this).is(':checked')){
                show_offers($(this).data('offer'), 'show');
            }else{
                show_offers($(this).data('offer'), 'hide');
            }
        });
        $('.submenu_offer_ids').each(function(){
            if($(this).is(':checked')){
                show_offers($(this).data('offer'), 'show');
            }else{
                show_offers($(this).data('offer'), 'hide');
            }
        });
    });
    
    function vendor_making_charge(calc){
        if(calc == 'PER'){
            $('#vendor_making_charge_indicator').html('%');
        }else{
            $('#vendor_making_charge_indicator').html('INR');
        }
        $('#vendor_making_charge_calc').val(calc);
    }
    
    function making_charge(calc){
        if(calc == 'PER'){
            $('#making_charge_indicator').html('%');
        }else{
            $('#making_charge_indicator').html('INR');
        }
        $('#making_charge_calc').val(calc);
    }
    
    function change_category() {
        var category = $("#category :selected").text();
        if (category.indexOf('Gold Coins') > -1) {
            $(".goldcoins").hide();
            $(".goldcoins_only").show();
        } else {
            $(".goldcoins").show();
            $(".goldcoins_only").hide();
            if($('.yes').is(':checked')) { 
                $("#addstone").show(); 
            }else{
                $("#addstone").hide(); 
            }
            var gem_check = $("input[name='data[Product][gemstone]']:checked").val();
            if(gem_check == "Yes"){
                $('.addgemstone').show();
            }else{
                $('.addgemstone').hide();
            }
        }
    }
    
    function show_offers(id, mode){
        if(mode == 'show'){
            $('.offer_menu_'+id).show();
        }else if(mode == 'hide'){
            $('.offer_menu_'+id).hide();
            $('.offer_ids_'+id).prop('checked', false);
            $.uniform.update();
        }
    }

</script>
