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
</style>

<script type="text/javascript">
    function view(id) {
        $("#" + id).trigger('click');
    }

//    $(document).ready(function () {
//        calprice();
//    });
//
//    function calprice() {
//        $(".description_div .description").each(function () {
//            var product_id = $(this).data('productid');
//            var size = $(this).data('size');
//            var color = $(this).data('color');
//            var diamond = $(this).data('diamond');
//            var purity = $(this).data('purity');
//            var title = $(this).data('title');
//
////                console.log('product_id'+product_id);
////                console.log('size'+size);
////                console.log('color'+color);
////                console.log('diamond'+diamond);
////                console.log('purity'+purity);
//
//            $.ajax({
//                type: "POST",
//                url: "<?php echo BASE_URL; ?>webpages/calculate_price/",
//                data: 'customid=' + purity + 'K' + diamond + "&size=" + size + "&gcolor=" + color + "&product_id=" + product_id,
//                dataType: 'json',
//                success: function (data) {
//                    console.log(data.total);
//                    $('#prod' + product_id).attr('title', data.total);
//                }
//            });
//        });
//    }

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
                                    echo '<div class="emptyrect">' . $categories['Category']['category'] . '</div>';
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

                        <?php
                        $j = 1;
                        foreach ($products as $product) {
                            $subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$product['Product']['subcategory_id'])));
                            $Product_product_name=str_replace(" ","_",$product['Product']['product_name']);
                            $link = BASE_URL.$categories['Category']['category']."/".$subcategory['Subcategory']['subcategory']."/".$product['Product']['product_id']."/".$Product_product_name;
                                    
                            $metals = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Purity')));
							$diamond=ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id']),'group'=>array('clarity','color'),'order'=>"FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
							
                            $purity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Purity', 'status' => 'Active'), 'order' => 'value ASC'));
                            $Productmetal = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'type' => 'Size', 'status' => 'Active'), 'order' => 'productmetal_id ASC'));
                            $size = 0;
                            if(!empty($Productmetal)){
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

                            $diamond_val = $diamond['Productdiamond']['clarity'] . '-' . $diamond['Productdiamond']['color'];

                            $product_code = $categories['Category']['category_code'] . $product['Product']['product_code'] . '-' . $purity['Productmetal']['value'] . 'K';
                            if (!empty($diamond)) {
                                $product_code .= $diamond['Productdiamond']['clarity'] . $diamond['Productdiamond']['color'];
                            }
                            
                            $price = $this->requestAction('webpages/calc_price_ret/'.$purity['Productmetal']['value'] . 'K' . $diamond_val.'/'.$size.'/'.$product['Product']['product_id'].'/'.$color);

                            $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'status' => 'Active')));
                            if (!empty($image)) {
                                if ($image['Productimage']['imagename'] != NULL) {
                                    $title = "<h2>". $categories['Category']['category']."</h2>"
                                            ."<a href='{$link}' target='_blank'>".$product['Product']['product_name'] . " </a><br />"
                                            . "<b>" . "<a href='{$link}' target='_blank'>".$product_code . "</a></b><br />"
                                            . "Rs.<span id='total_amount".$product['Product']['product_id']."'>".$price['total'].'</span>/-';
                                    ?>
                                    <div style="display: none" class="description_div">
                                        <p class="description" 
                                           id="description_<?php echo $product['Product']['product_id'] ?>" 
                                           data-productid="<?php echo $product['Product']['product_id'] ?>"
                                           data-size="<?php echo $size ?>"
                                           data-color="<?php echo $color ?>"
                                           data-purity="<?php echo $purity['Productmetal']['value'] ?>"
                                           data-diamond="<?php echo $diamond_val ?>"
                                           data-title="<?php echo $title ?>">
                                            <a id="<?php echo $j == 1 ? 'group' . $categories['Category']['category_id'] : '' ?>" 
                                               class="<?php echo 'group' . $categories['Category']['category_id'] . ' ' . 'prod' . $product['Product']['product_id'] ?>" 
                                               data-link="<?php echo $link; ?>" 
                                               href="<?php echo BASE_URL . 'img/product/home/' . $image['Productimage']['imagename']; ?>" title="<?php echo $title  ?>">
                                                <?php echo $product['Product']['product_name'] ?>
                                            </a>
                                        </p>

                                    </div>
                                    <?php
                                }
                            }
                            $j++;
                        }
                        ?>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $("<?php echo '.group' . $categories['Category']['category_id'] ?>").colorbox({
                                    rel: '<?php echo 'group' . $categories['Category']['category_id'] ?>',
                                    slideshow: true,
                                    width: '1000px',
                                    height: '600px',
                                    innerWidth: '900px',
                                    innerHeight: '500px',
                                    slideshowSpeed: '5000',
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
        <div class="shadow"><?php echo $this->Html->image('shadow.png', array("alt" => "Image")); ?></div>

    </div>




