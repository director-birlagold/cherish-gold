<style type="text/css">
    .emptyrect{
        background-color: #ebebeb;
        border: medium none;
        height: 100px;
        width: 100px;
        text-align: center;
    }

    .category_images ul li {
        margin: 15px 5px !important;
    }

    .cat_name{
        text-align: center; 
        font-weight: bold;
        margin: 5px 0;
    }

    #cboxTitle{
        bottom: 5px !important;
        line-height: 22px;
    }

    #cboxTitle a{
        font-weight: bold;
    }
    
    .emptyrect > div {
        padding: 40px 0;
    }
</style>

<script type="text/javascript">
    function view(id) {
        $("#" + id).trigger('click');
    }
</script>
<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>
        <div class="productInfoDiv"> 
            <h2><p align="center">My Catalogue</p></h2>
            <div style="clear:both;">&nbsp;</div>
            <div class="shadow"><?php echo $this->Html->image('shadow.png', array("alt" => "Image")); ?></div>
            <div style="float:left; width:100%;">
    
                <div class="category_images">
                    <ul>
    <?php
    $i = 0;
    $category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'category_id ASC'));
    $length = count($category);

    foreach ($category as $categories) {
        $product = ClassRegistry::init('Product')->find('all', array('conditions' => array('category_id' => $categories['Category']['category_id'], 'status' => 'Active')));
        $product_count = count($product);

        $product_ids = array();
        foreach ($product as $products) {
            $product_ids[$products['Product']['product_id']] = $products['Product']['product_id'];
        }
        $franchisee_products = ClassRegistry::init('Franchiseeproduct')->find('list', array('fields' => array('product_id', 'product_id'), 'conditions' => array('user_id' => $this->Session->read('User.user_id'), 'category_id' => $categories['Category']['category_id'])));
        $result = array_diff_assoc($product_ids, $franchisee_products);
        $remain_product_count = count($result);

        $franchisee_product_count = $product_count - $remain_product_count;
        $products = ClassRegistry::init('Franchiseeproduct')->findAllByUserIdAndCategoryId($this->Session->read('User.user_id'), $categories['Category']['category_id']);

        ?>
                                <li>
                                    <div>
        <?php
        if (isset($product[0]['Product']['product_id'])) {
            $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product[0]['Product']['product_id'], 'status' => 'Active')));
            echo $this->Html->link($this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '100px', 'height' => '100')), array('action' => 'product', 'controller' => 'webpages', $categories['Category']['link']), array('escape' => false, 'title' => $categories['Category']['category'], 'target' => '_blank'));
        } else {
            echo '<div class="emptyrect"><div>' . $categories['Category']['category'] . '</div></div>';
        }
        ?>
                                    </div>
                                    <div class="cat_name">
        <?php echo $categories['Category']['category'] . '(' . $franchisee_product_count . ')'; ?>
                                    </div>
                                    <div style="text-align: center">
        <?php
        if ($product_count <= 0) {
            echo 'No Prodcuts';
        } elseif ($franchisee_product_count > 0) {
            echo $this->Html->link('Edit', array('controller' => 'franchiseeproducts', 'action' => 'edit/' . $categories['Category']['category_id']));
            echo ' / ';
//                                    echo $this->Html->link('View', array('controller' => 'franchiseeproducts', 'action' => 'view/' . $categories['Category']['category_id']));
            echo $this->Html->link('View', 'javascript:view("group' . $categories['Category']['category_id'] . '")');
        } else {
            echo $this->Html->link('Create', array('controller' => 'franchiseeproducts', 'action' => 'edit/' . $categories['Category']['category_id']));
        }
        ?>
                                    </div>
                                </li>
        
        <ul class="<?php echo 'group' . $categories['Category']['category_id'] ?>" style="display: none;">
        
        <?php
        $j = 1;
        $logo_src = BASE_URL.'/img/icons/logo.png';
        foreach ($products as $product) {
            $subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $product['Product']['subcategory_id'])));
            $Product_product_name = str_replace(" ", "_", $product['Product']['product_name']);
            $link = BASE_URL . $categories['Category']['category'] . "/" . $subcategory['Subcategory']['subcategory'] . "/" . $product['Product']['product_id'] . "/" . $Product_product_name;

            $metals = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Purity')));
            $diamond = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id']), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));

            $purity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Purity', 'status' => 'Active'), 'order' => 'value ASC'));
            $Productmetal = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Size', 'status' => 'Active'), 'order' => 'productmetal_id ASC'));
            $size = 0;
            if (!empty($Productmetal)) {
                if ($categories['Category']['category'] != "Bangles") {
                    $size = $Productmetal['Productmetal']['value'];
                } else {
                    $nt = number_format($Productmetal['Productmetal']['value'], 3, '.', '');
                    $size = ClassRegistry::init('Size')->find('first', array('conditions' => array('size_value' => $nt), 'group' => 'size', 'order' => 'size_id ASC'));
                    $size = $size['Size']['size_value'];
                }
            }
            $ids = explode(',', $product['Product']['metal_color']);
            $color = $ids[0];
            $diamond_val = !empty($diamond) ? $diamond['Productdiamond']['clarity'] . '-' . $diamond['Productdiamond']['color'] : '';

            $product_code = $categories['Category']['category_code'] . $product['Product']['product_code'];
//            $product_code = $categories['Category']['category_code'] . $product['Product']['product_code'] . '-' . $purity['Productmetal']['value'] . 'K';
//            if (!empty($diamond)) {
//                $product_code .= $diamond['Productdiamond']['clarity'] . $diamond['Productdiamond']['color'];
//            }

//            echo 'diamond : '.$purity['Productmetal']['value'] . 'K' . $diamond_val.'<br />';
//            echo 'size : '.$size.'<br />';
//            echo 'product id : '.$product['Product']['product_id'].'<br />';
//            echo 'color : '.$color.'<br />';
            $price = $this->requestAction('webpages/calc_price_ret/' . $purity['Productmetal']['value'] . 'K' . $diamond_val . '/' . $size . '/' . $product['Product']['product_id'] . '/' . $color);
//            echo '<pre>';
//            print_r($price['stonedetails']);



            $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'status' => 'Active')));
            if (!empty($image)) {
                if ($image['Productimage']['imagename'] != '') {
                    $title = "<div class='customHtml'>"
                            ."<img class='innerlogo' src='{$logo_src}' />"
                            . "<ul>"
//                            . "<div class='innerHtml'></div>"
//                            . "<div class='innerHtml'>"
                            . "<li><h2>{$categories['Category']['category']}</h2></li>"
                            . "<li>Product Name : <a href='{$link}' target='_blank'>{$product['Product']['product_name']}</a></li>"
                            . "<li>Product Code : <b><a href='{$link}' target='_blank'>{$product_code}</a></b></li>"
                            . "<li>Gold Gram : <span>{$price['weight']} gm</span></li>";
//                            . "</div>"
//                            . "<div class='innerHtml'>";
//                            . "<span class='pricetag'>Rs.{$price['total']}/-</span></div>"
                            
                    
                    $title .= $price['diamond_count'] != '' ? "<li>Diamond Count : <span>{$price['diamond_count']}</span><br /></li>" : '';
                    $title .= $price['diamond_weight'] != '' ? "<li>Diamond Weight : <span>{$price['diamond_weight']}</span></li>" : '';
                    $title .= $price['gemstone_count'] != '' ? "<li>Gemstone Count : <span>{$price['gemstone_count']}</span></li>" : '';
                    $title .= $price['gemstone_weight'] != '' ? "<li>Gemstone Weight : <span>{$price['gemstone_weight']} Carat</span></li>" : '';
                    $title .= "</ul>";
                    $title .= "<div class='innercompany'>Birla Gold <br />&<br /> Precious Metals Limited</div>";
                    $title .= "</div>";
//                    $title .= "<div class='innerHtml'></div>"
;
                ?>
            <li  data-link-url="<?php echo $link?>" data-src="<?php echo BASE_URL . 'img/product/home/' . $image['Productimage']['imagename']; ?>" 
                 data-sub-html="<?php echo $title ?>"> 
                        <a>
                            <img id="<?php echo $j == 1 ? 'group' . $categories['Category']['category_id'] : '' ?>" src="<?php echo BASE_URL . 'img/product/small/' . $image['Productimage']['imagename']; ?>" width="100" height="100"  />
                        </a> 
                    </li>
                    <?php
                }
            }
            $j++;
        }
        echo '</ul>';
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('<?php echo '.group' . $categories['Category']['category_id'] ?>').lightGallery({
                    auto: false,
                    animateThumb: true,
//                    easing: '',
                    loop: true
    //                thumbnail: false,
    //                addClass: 'localVideo'
                });
            });
        </script>
        <?php
        $i++;
    }
    ?>
                    </ul>
                </div> 
    
    
            </div>
            <!--<div class="shadow"><?php echo $this->Html->image('shadow.png', array("alt" => "Image")); ?></div>-->
    
        </div>
