<?php

if (!empty($product)) {


    $productdiv = '';
    foreach ($product as $products) {

        $images = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'], 'status' => 'Active')));
        $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $products['Product']['category_id'])));
        if (!empty($products['Product']['subcategory_id'])) {
            $subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $products['Product']['subcategory_id'])));
            $subcat = $subcategory['Subcategory']['subcategory'];
        } else {
            $subcat = 'all_items';
        }
        $Product_product_name = str_replace(" ", "_", $products['Product']['product_name']);
        if (isset($_REQUEST['goldpurity'])) {
            $urls = '?purity=' . $_REQUEST['goldpurity'];
        } else {
            $urls = '';
        }

        $hdn_st = $hdn_color = $hdn_diamond = $hdn_purity = '';

        $Productmetal = ClassRegistry::init('Productmetal')->find('all', array('conditions' => array('product_id' => $products['Product']['product_id'], 'type' => 'Size', 'status' => 'Active'), 'order' => 'productmetal_id ASC'));
        $ids = explode(',', $products['Product']['metal_color']);
        $diamonddiv = ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('product_id' => $products['Product']['product_id']), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
        $purity = ClassRegistry::init('Productmetal')->find('all', array('conditions' => array('product_id' => $products['Product']['product_id'], 'type' => 'Purity', 'status' => 'Active'), 'order' => 'value ASC'));

        if (!empty($Productmetal)) {
            if ($category['Category']['category'] != "Bangles") {
                $hdn_st = $Productmetal[0]['Productmetal']['value'];
            } else {
                $nt = number_format($Productmetal[0]['Productmetal']['value'], 3, '.', '');
                $size = ClassRegistry::init('Size')->find('first', array('conditions' => array('size_value' => $nt), 'group' => 'size', 'order' => 'size_id ASC'));
                $hdn_st = $size['Size']['size_value'];
            }
        }

        if (!empty($ids))
            $hdn_color = $ids[0];

        if (!empty($diamonddiv))
            $hdn_diamond = $diamonddiv[0]['Productdiamond']['clarity'] . '-' . $diamonddiv[0]['Productdiamond']['color'];

        if (!empty($purity))
            $hdn_purity = $purity[0]['Productmetal']['value'];

        $productdiv.= '<form method="post" action="' . BASE_URL . 'shoppingcarts/addcart" name="Shopping" class="shoppingdetails">';
        $productdiv.= "<div class='hidden_div' data-productid='{$products['Product']['product_id']}'>";
        $productdiv.= "<input type='hidden' value='{$products['Product']['product_id']}' name='product_id' id='hidden_product_id_{$products['Product']['product_id']}'/>";
        $productdiv.= "<input type='hidden' value='$hdn_st' name='size' id='hidden_size_{$products['Product']['product_id']}'/>";
        $productdiv.= "<input type='hidden' value='$hdn_color' name='color' id='hidden_color_{$products['Product']['product_id']}'/>";
        $productdiv.= "<input type='hidden' value='$hdn_diamond' name='data[Product][stone]' id='hidden_stone_{$products['Product']['product_id']}'/>";
        $productdiv.= "<input type='hidden' value='$hdn_purity' name='data[Product][goldpurity]' id='hidden_purity_{$products['Product']['product_id']}'/>";
        $productdiv.= "<input type='hidden' name='data[Shopping][shoppingsubmit]' value='1' />";
        $productdiv.= "</div>";
        $productdiv.= "<div id='cart_div_{$products['Product']['product_id']}' class='hide'></div>";

        $tag_image2 = $tag_image = '';
        if (in_array('1', explode(",", $products['Product']['product_view_type']))) {
            $tag_image2 = $this->Html->image('offer_img2.png', array("alt" => "Image"));
        }
        if (in_array('2', explode(",", $products['Product']['product_view_type']))) {
            $tag_image = $this->Html->image('offer_img.png', array("alt" => "Image"));
        }
        
        $productdiv.='   <div class="gridproduct"><div class="productDiv ">
            <div style="position:relative;">
            <div style="position:absolute; right:-9px;">'.$tag_image2.'</div>
            <div style="position:absolute; right:-9px;">'.$tag_image.'</div>
            </div>';
        if (!empty($images['Productimage']['imagename'])) {
            $image = '<a href="' . BASE_URL . $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name . $urls . '">' . $this->Html->image('product/small/' . $images['Productimage']['imagename'], array('border' => 0, 'class' => 'xyz')) . '</a>';
        } else {
            $image = 'No Image Found';
        }

        $productdiv.='<p style="height:133px;">' . $image . '</p> <p align="center">Rs. ' . number_format($products[0]['totprice'],0) . '</p>
          <div style="border-bottom:1px solid #ccc; float:left; width:100%; padding-bottom:5px;">
            <div style="float:left; color:#dba715; font-size:18px; font-weight:bold;">&nbsp;</div>
            <div style="float:right;">';
//		 $productdiv.='<p style="height:133px;">'.$image.'</p> <p align="center">'.substr($products['Product']['product_name'],0,25).(strlen($products['Product']['product_name'])>25?'...':'').'</p>
//          <div style="border-bottom:1px solid #ccc; float:left; width:100%; padding-bottom:5px;">
//            <div style="float:left; color:#dba715; font-size:18px; font-weight:bold;">&nbsp;</div>
//            <div style="float:right;">';

        $reviewcount = ClassRegistry::init('Rating')->find('count', array('conditions' => array('product_id' => $products['Product']['product_id'])));

        $rating = ClassRegistry::init('Rating')->find('all', array('fields' => array('SUM(Rating.rate) as total'), 'conditions' => array('product_id' => $products['Product']['product_id']), 'group' => array('Rating.product_id')));

        foreach ($rating as $rating) {
            foreach ($rating as $rating) {
                $count = $rating['total'] / $reviewcount;
                $count = round($count, 2);
            }
        }

        $productdiv.='<span class="b-star"><span style="width:' . (!empty($rating) ? $count * 20 : '0') . '%" class="rstar"></span></span>
            </div>
          </div>
          <div style="clear:both;"></div>
          <div style="border-bottom:1px solid #ccc; float:left; width:100%;">
            <p align="center">			
             <a href="' . BASE_URL . $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name . $urls . '"><input name="" type="submit" value="" class="addBtn" ></a>
<a href="' . BASE_URL . 'webpages/whislist/' . $category['Category']['link'] . '/' . $products['Product']['product_id'] . '/' . (!empty($images) ? $images['Productimage']['image_id'] : '') . '">			 <input name="" type="button" value="" class="wish_list_btn"></a>
            </p>
          </div> </div></div>';
        $productdiv.='<div class="listproduct">
         <div class="productDiv" style="width:100%;">
          <div style="position:relative;">
            <div style="position:absolute; right:-9px;">'.$tag_image2.'</div>
            <div style="position:absolute; right:-9px;">'.$tag_image.'</div>
          </div>
          <div style="float:left; width:270px;">';
        if (!empty($images['Productimage']['imagename'])) {
            $image = '<a href="' . BASE_URL . $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name . $urls . '">' . $this->Html->image('product/small/' . $images['Productimage']['imagename'], array('border' => 0, 'class' => 'xyz')) . '</a>';
        } else {
            $image = 'No Image Found';
        }

        $productdiv.='<p style="height:133px;">' . $image . '</p>
			</div><div style="float:left; width:570px; height:40px;">
          	<h3>' . $products['Product']['product_name'] . '</h3>
          </div>

          <div style="float:left; width:570px; height:50px;">
          	<h1>Rs. ' . indian_number_format($products[0]['totprice']) . ' </h1>
          </div>';
        if (isset($_REQUEST['goldpurity'])) {
            $goldpurity = $_REQUEST['goldpurity'];
        } else {
            $purity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'], 'type' => 'purity'), 'order' => 'value ASC'));
            $goldpurity = $purity['Productmetal']['value'];
        }

        $productdiv.='<div style="float:left; width:570px; height:50px;">
          	  <strong>Metal :</strong> ' . $goldpurity . 'K ' . $products['Product']['metal_color'] . ' Gold ';
        if ($products['Product']['stone'] == "Yes") {
            $stone_details = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id']), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
            if (!empty($stone_details)) {
                $productdiv.='| Stone:' . $stone_details['Productdiamond']['clarity'] . '-' . $stone_details['Productdiamond']['color'];
            }
        }
        $productdiv.='</div><div style="float:left; width:270px;">
               <a href="' . BASE_URL . $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name . $urls . '"><input name="" type="submit" value="" class="addBtn" ></a>
 <a href="' . BASE_URL . 'webpages/whislist/' . $category['Category']['link'] . '/' . $products['Product']['product_id'] . '/' . (!empty($images) ? $images['Productimage']['image_id'] : '') . '">
          </div> 
          <div style="clear:both;"></div>
         </div>
        </div>
        </form>';
    }
    $flag = 'Yes';
    $array = array_merge(array('productdiv' => $productdiv, 'flag' => $flag, 'count' => count($product)));
} else {
    $flag = 'No';
    $array = array_merge(array('flag' => $flag));
}
echo json_encode($array);
?>