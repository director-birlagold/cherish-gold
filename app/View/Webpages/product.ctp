<?php
//echo $this->Html->css(array('page'));
// echo $this->Html->script(array('script'));
?>
<script type="text/javascript" src="http://www.jquery4u.com/demos/jquery-quick-pagination/js/jquery.quick.pagination.min.js"></script>
<div class="container">

    <!--- New HTML Start -->

    <div class="productInfoDiv">
        <div class="productMiddleDeatil">
            <div class="topsubmenudiv">
                <div class="topsubmenu" style="text-align:center">
                    <ul>         
                        <li><?php echo $this->Html->link('Home', array('controller' => 'webpages', 'action' => 'index'), array('escape' => false)); ?></li>
                        <li class="line_img"><?php echo $this->Html->image('line-img.png', array("alt" => "Image")); ?></li>
                        <li><?php echo $this->Html->link('Jewllery', array('controller' => 'webpages', 'action' => 'jewellery'), array('escape' => false)); ?></li>            
                        <?php
                        if (!empty($this->params['pass']['0'])) {
                            $cats = ClassRegistry::init('Category')->find('first', array('conditions' => array('LOWER(category)' => str_replace('_', ' ', $this->params['pass']['0']))));
                            if (!empty($cats)) {
                                ?> 
                                <li class="line_img"><?php echo $this->Html->image('line-img.png', array("alt" => "Image")); ?></li>
                                <li class="category"><a href="<?php echo BASE_URL.'details/'; ?><?php echo str_replace(' ', '_', strtolower($cats['Category']['category'])); ?>"><?php echo $cats['Category']['category']; ?></a></li>
                                <?php
                                ?>
                                <?php
                                if (!empty($this->params['pass']['1'])) {
                                    $sub_cats = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('LOWER(subcategory)' => str_replace(array('0_5', '_',), array('0.5', ' '), $this->params['pass']['1']), 'category_id' => $cats['Category']['category_id'])));
                                    ?>
                                    <li class="line_img"><?php echo $this->Html->image('line-img.png', array("alt" => "Image")); ?></li>
                                    <li class="category">
                                        <a class="product">
                                            <?php echo $sub_cats['Subcategory']['subcategory']; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                        }if (isset($n_filter)) {
                            ?> 
                            <li class="line_img"><?php echo $this->Html->image('line-img.png', array("alt" => "Image")); ?></li>
                            <li class="category"><a href="#"><?php echo $n_filter; ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--<div class="shadow"><?php echo $this->Html->image('shadow.png', array("alt" => "Image")); ?></div>-->   
        <p><h2><?php
            if (!empty($cats)) {
                echo $cats['Category']['category'];
                if (!empty($sub_cats)) {
                    echo ' - ' . $sub_cats['Subcategory']['subcategory'];
                }
            } else {
                echo 'All Jewellery';
            }
            ?></h2></p>
        <div style="border-bottom:2px solid #e5e5e5; border-top:2px solid #e5e5e5; width:100%; float:left; margin-bottom:10px;">
            <div style="float:left; margin:10px 0px 0px 20px;">Search Criteria</div>
            <div class="productMiddleWhatNew">
                <ul>    
                    <li><a href="<?php echo BASE_URL; ?><?php echo $this->request->url; ?>?filter=whats_new" <?php
                        if (isset($_REQUEST['filter'])) {
                            if ($_REQUEST['filter'] == "whats_new") {
                                echo 'class="active"';
                            }
                        }
                        ?>>WHAT'S NEW</a></li> 
                    <li><a href="<?php echo BASE_URL; ?><?php echo $this->request->url; ?>?filter=popular" <?php
                        if (isset($_REQUEST['filter'])) {
                            if ($_REQUEST['filter'] == "popular") {
                                echo 'class="active"';
                            }
                        }
                        ?>>POPULAR</a></li>
                    <li><a href="<?php echo BASE_URL; ?><?php echo $this->request->url; ?>?filter=price&order=<?php
                        if (isset($_REQUEST['order'])) {
                            if ($_REQUEST['order'] == "asc") {
                                echo "desc";
                            } else {
                                echo "asc";
                            }
                        } else {
                            echo "asc";
                        }
                        ?>" <?php
                           if (isset($_REQUEST['filter'])) {
                               if ($_REQUEST['filter'] == "price") {
                                   echo 'class="active"';
                               }
                           }
                           ?>>PRICE</a></li>
                </ul>
                <div style="float:left; margin-right:15px;"> <a href="#"><?php echo $this->Html->image('result_divider.jpg', array("alt" => "Image")); ?></a> </div>
                <div style="float:left; margin-top:8px;">

                    <a class="grid" style="cursor:pointer;" rel="grid"><?php echo $this->Html->image('result_icn1.jpg', array("alt" => "Image")); ?></a>&nbsp;&nbsp; 

                    <a class="list hide" style="cursor:pointer;" rel="list"><?php echo $this->Html->image('result_icn2.jpg', array("alt" => "Image")); ?></a> 
                </div> 
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="float:right; font-size:12px;">   
            Showing 1-<span class="countpage"><?php echo count($product); ?></span> Of <?php echo $productcount; ?> Results </div>
        <div style="clear:both;"></div>
        <div class="productMiddleDeatil">
            <div class="productMiddleLeft">
                <form method="get" id="left_side" name="left_side">       
                    <ul>       
                        <p class="price" rel="price" value="price">PRICE</p>
                        <li class="bg_none">
                            <input name="price" type="radio" value="1" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 1 ? 'checked="checked"' : '';
                            }
                            ?>>
                            BELOW &gt; Rs. 10,000/-</li>
                        <li>
                            <input name="price" type="radio" value="2" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 2 ? 'checked="checked"' : '';
                            }
                            ?>>
                            Rs. 10,000/- &gt;  Rs. 20,000/-</li>
                        <li>
                            <input name="price" type="radio" value="3" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 3 ? 'checked="checked"' : '';
                            }
                            ?>>
                            Rs. 20,000/- &gt;  Rs. 30,000/-</li>
                        <li>
                            <input name="price" type="radio" value="4" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 4 ? 'checked="checked"' : '';
                            }
                            ?>>
                            Rs. 30,000/- &gt;  Rs. 40,000/-</li>             
                        <li>
                            <input name="price" type="radio" value="5" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 5 ? 'checked="checked"' : '';
                            }
                            ?>>
                            Rs. 40,000/- &gt;  Rs. 50,000/-</li>
                        <li>
                            <input name="price" type="radio" value="6" <?php
                            if (isset($_REQUEST['price'])) {
                                echo $_REQUEST['price'] == 6 ? 'checked="checked"' : '';
                            }
                            ?>>
                            Rs. 50,000/-  &lt; above</li>           
                    </ul>
                    <?php if (!empty($type_cat)) { ?>
                        <ul>
                            <p rel="link" value="rings">TYPE</p>  
                            <?php
                            foreach ($type_cat as $type_cats) {
                                $tcat = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $type_cats['Product']['category_id'])));
                                if (!empty($tcat)) {
                                    ?>
                                    <li class="bg_none">
                                        <input name="category" type="radio" value="<?php echo str_replace(' ', '_', strtolower($tcat['Category']['category'])); ?>" class="links" <?php
                                        if (isset($this->params['pass']['0'])) {
                                            echo (str_replace(' ', '_', strtolower($tcat['Category']['category'])) == $this->params['pass']['0'] ? 'checked="checked"' : '');
                                        } if (isset($_REQUEST['category'])) {
                                            echo (str_replace(' ', '_', strtolower($tcat['Category']['category'])) == $_REQUEST['category'] ? 'checked="checked"' : '');
                                        }
                                        ?>/><?php echo $tcat['Category']['category']; ?> (<?php echo $type_cats['0']['catcount']; ?>)</li>
                                        <?php
                                    }
                                }
                                ?>
                        </ul>
                    <?php } ?>
                    <ul>        
                        <p class="gold" rel="metal" value="purity">METAL</p>
                        <?php
                        $m = '0';
                        foreach ($metal as $metals) { ?>
                            <li class="bg_none">
                                <input name="metal" type="radio" value="<?php echo trim($metals['Metal']['metal_name']); ?>" class="metals" <?php
                                if (isset($_REQUEST['metal'])) {
                                    echo $_REQUEST['metal'] == trim($metals['Metal']['metal_name']) ? 'checked="checked"' : '';
                                }
                                ?> >
                                <?php echo $metals['Metal']['metal_name']; ?></li>
                            <?php
                            $m++;
                        }
                        ?>        
                        <?php if ($m > 3) { ?>
                            <a class="more" rel="noreal" <?php
                            if (isset($_REQUEST['metal'])) {
                                echo 'style="display:none"';
                            }
                            ?>>
                                More
                                <i>+</i>
                            </a><?php } ?>
                        <a class="less" rel="noreal" <?php
                        if (!isset($_REQUEST['metal'])) {
                            echo 'style="display:none"';
                        }
                        ?>>
                            Less
                            <i>-</i>
                        </a>

                    </ul>
                    <ul>    <div class="shape" <?php
                        if (isset($_REQUEST['goldpurity'])) {
                            echo 'style="height:100%"';
                        }
                        ?>>
                            <p class="gold" rel="goldpurity" value="purity">GOLD PURITY</p>
                            <?php
                            $p = '0';
                            $purity = ClassRegistry::init('Purity')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'purity_id ASC'));
                            foreach ($purity as $purity) {
                                ?>
                                <li class="bg_none">
                                    <input name="goldpurity" type="radio" value="<?php echo trim($purity['Purity']['purity']); ?>" <?php
                                    if (isset($_REQUEST['goldpurity'])) {
                                        echo $_REQUEST['goldpurity'] == trim($purity['Purity']['purity']) ? 'checked="checked"' : '';
                                    }
                                    ?>>
                                    <?php echo $purity['Purity']['purity']; ?>K</li>
                                <?php
                                $p++;
                            }
                            ?></div><?php if ($p > 3) { ?>
                            <a class="more" rel="noreal" <?php
                            if (isset($_REQUEST['goldpurity'])) {
                                echo 'style="display:none"';
                            }
                            ?>>
                                More
                                <i>+</i>
                            </a><?php } ?>
                        <a class="less" rel="noreal" <?php
                        if (!isset($_REQUEST['goldpurity'])) {
                            echo 'style="display:none"';
                        }
                        ?>>
                            Less
                            <i>-</i>
                        </a>
                    </ul>
                    <ul>        
                        <p class="gold" rel="gemstone" value="stone" id="dia">Diamond</p>
                        <li class="bg_none" >
                            <input name="diamond" type="radio" value="<?php echo $diamond['Diamond']['name'] ?>" <?php
                            if (isset($_REQUEST['diamond'])) {
                                echo $_REQUEST['diamond'] == trim($diamond['Diamond']['name']) ? 'checked="checked"' : '';
                            }
                            ?> />
                                   <?php echo $diamond['Diamond']['name']; ?>
                        </li>                   
                    </ul>
                    <ul>
                        <div class="shape" <?php
                        if (isset($_REQUEST['gemstone'])) {
                            echo 'style="height:100%"';
                        }
                        ?>>
                            <p class="gold" rel="gemstone" value="stone" id="dia">STONES</p>             
                            <?php
                            $s = 0;
                            foreach ($stone as $stone) {
                                ?>
                                <li class="bg_none">
                                    <input name="gemstone" type="radio" value="<?php echo trim($stone['Gemstone']['stone']); ?>" <?php
                                    if (isset($_REQUEST['gemstone'])) {
                                        echo trim(urldecode($_REQUEST['gemstone'])) == trim($stone['Gemstone']['stone']) ? 'checked="checked"' : '';
                                    }
                                    ?>>
                                    <?php echo $stone['Gemstone']['stone']; ?></li>
                                <?php
                                $s++;
                            }
                            ?> </div>
                            <?php if ($s > 3) { ?>
                            <a class="more" rel="noreal"  <?php
                            if (isset($_REQUEST['gemstone'])) {
                                echo 'style="display:none"';
                            }
                            ?>>
                                More
                                <i>+</i>
                            </a><?php } ?>
                        <a class="less" rel="noreal"  <?php
                        if (!isset($_REQUEST['gemstone'])) {
                            echo 'style="display:none"';
                        }
                        ?>>
                            Less
                            <i>-</i>
                        </a>

                    </ul> 
                    <ul>
                        <div class="shape" <?php
                        if (isset($_REQUEST['shape'])) {
                            echo 'style="height:100%"';
                        }
                        ?>>
                            <p class="gold" rel="shape" value="stone_shape">STONE SHAPE</p>
                            <?php
                            $ss = '0';
                            foreach ($shape as $shape) {
                                ?>
                                <li class="bg_none">
                                    <input name="shape" type="radio" value="<?php echo trim($shape['Shape']['shape']); ?>" <?php
                                    if (isset($_REQUEST['shape'])) {
                                        echo $_REQUEST['shape'] == trim($shape['Shape']['shape']) ? 'checked="checked"' : '';
                                    }
                                    ?>>
                                    <?php echo $shape['Shape']['shape']; ?></li>
                                <?php
                                $ss++;
                            }
                            ?>
                        </div>
                        <?php if ($ss > 3) { ?>
                            <a class="more" rel="noreal" <?php
                            if (isset($_REQUEST['shape'])) {
                                echo 'style="display:none"';
                            }
                            ?>>
                                More
                                <i>+</i>
                            </a><?php } ?>
                        <a class="less" rel="noreal" <?php
                        if (!isset($_REQUEST['shape'])) {
                            echo 'style="display:none"';
                        }
                        ?>>
                            Less
                            <i>-</i>
                        </a>

                    </ul>
                    <?php if (isset($_REQUEST['collection'])) { ?>
                        <ul>
                            <div class="shape" <?php
                            if (isset($_REQUEST['collection'])) {
                                echo 'style="height:100%"';
                            }
                            ?>>
                                <p class="gold" rel="shape" value="stone_shape">Collections</p>
                                <?php
                                $ss = '0';
                                foreach ($collections as $collections) {
                                    ?>
                                    <li class="bg_none">
                                        <input name="collection" type="radio" value="<?php echo str_replace(' ', '_', strtolower(trim($collections['Collectiontype']['collection_name']))); ?>" <?php
                                        if (isset($_REQUEST['collection'])) {
                                            echo $_REQUEST['collection'] == str_replace(' ', '_', strtolower(trim($collections['Collectiontype']['collection_name']))) ? 'checked="checked"' : '';
                                        }
                                        ?>>
                                        <?php echo trim($collections['Collectiontype']['collection_name']); ?></li>
                                    <?php
                                    $ss++;
                                }
                                ?>
                            </div>
                            <?php if ($ss > 3) { ?>
                                <a class="more" rel="noreal" <?php
                                if (isset($_REQUEST['collection'])) {
                                    echo 'style="display:none"';
                                }
                                ?>>
                                    More
                                    <i>+</i>
                                </a><?php } ?>
                            <a class="less" rel="noreal" <?php
                            if (!isset($_REQUEST['collection'])) {
                                echo 'style="display:none"';
                            }
                            ?>>
                                Less
                                <i>-</i>
                            </a>

                        </ul>
                    <?php } ?>
                </form>
            </div>
            <div class="productMiddleRight">  

                <?php
                if (!empty($product)) {
                    foreach ($product as $products) {
                        /* $mc=round($products['0']['metalprice']*$products['Product']['mc']/100);
                          $vat=round(($products['0']['metalprice']+$products['0']['stoneprice']+$products['0']['gemstoneprice']+round($products['0']['metalprice']*$products['Product']['mc']/100))*$products['Product']['vat']/100);
                          $price=$products['0']['metalprice']+$products['0']['stoneprice']+$products['0']['gemstoneprice']+$mc+$vat; */

                        $images = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'], 'status' => 'Active'), 'limit' => 6));

                        $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $products['Product']['category_id'])));
                        if (!empty($products['Product']['subcategory_id'])) {
                            $subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $products['Product']['subcategory_id'])));
                            $subcat = str_replace(' ', '_', trim(strtolower($subcategory['Subcategory']['subcategory'])));
                        } else {
                            $subcat = 'all_items';
                        }

                        $Product_product_name = str_replace(" ", "_", trim($products['Product']['product_name']));
                        ?>
                        <form method="post" action="<?php echo BASE_URL; ?>shoppingcarts/addcart" name="Shopping" class="shoppingdetails">
                        <!--<div class="hide">-->
                        <?php
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

                        echo "<div class='hidden_div' data-productid='{$products['Product']['product_id']}'>";
                        echo "<input type='hidden' value='{$products['Product']['product_id']}' id='hidden_product_id_{$products['Product']['product_id']}'/>";
                        echo "<input type='hidden' value='$hdn_st' id='hidden_size_{$products['Product']['product_id']}'/>";
                        echo "<input type='hidden' value='$hdn_color' id='hidden_color_{$products['Product']['product_id']}'/>";
                        echo "<input type='hidden' value='$hdn_diamond' id='hidden_stone_{$products['Product']['product_id']}'/>";
                        echo "<input type='hidden' value='$hdn_purity' id='hidden_purity_{$products['Product']['product_id']}'/>";
                        echo "<input type='hidden' name='data[Shopping][shoppingsubmit]' value='1' />";
                        echo "</div>";
                        echo "<div id='cart_div_{$products['Product']['product_id']}' class='hide'></div>";
                        ?>
                        <!--</div>-->
                        <div class="gridproduct">
                            <div class="productDiv" style="position:relative;">
                                <div style="position:absolute; right:-9px;">
                                    <div style="position:relative;"><?php
                                        if (in_array('1', explode(",", $products['Product']['product_view_type']))) {
                                            echo $this->Html->image('offer_img2.png', array("alt" => "Image"));
                                        }
                                        ?></div>
                                    <div style="position:relative;"><?php
                                        if (in_array('2', explode(",", $products['Product']['product_view_type']))) {
                                            echo $this->Html->image('offer_img.png', array("alt" => "Image"));
                                        }
                                        ?></div>
                                </div>
                                <p style="height:133px;">
                                    <?php if (!empty($images['Productimage']['imagename'])) { ?>
                                        <a href="<?php echo BASE_URL; ?><?php echo str_replace(' ', '_', strtolower(trim($category['Category']['category']))) . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name; ?>"><img src="<?php echo "http://cherishgold.com/" . 'img/product/small/' . $images['Productimage']['imagename']; ?>"/></a>
                                    <?php } else { ?><?php echo 'No Image Found'; ?><?php } ?> 
                                </p>

                                <p align="center" class="total_amount_<?php echo $products['Product']['product_id']?>"></p>
                                <!--<p align="center"><?php echo substr($products['Product']['product_name'], 0, 25) . (strlen($products['Product']['product_name']) > 25 ? '...' : ''); ?></p>-->
                                <div style="border-bottom:1px solid #ccc; float:left; width:100%; padding-bottom:5px;">
                                    <div style="float:left; color:#dba715; font-size:18px; font-weight:bold;">&nbsp;</div>
                                    <div style="float:right;">
                                        <?php
                                        $reviewcount = ClassRegistry::init('Rating')->find('count', array('conditions' => array('product_id' => $products['Product']['product_id'])));

                                        $rating = ClassRegistry::init('Rating')->find('all', array('fields' => array('SUM(Rating.rate) as total'), 'conditions' => array('product_id' => $products['Product']['product_id']), 'group' => array('Rating.product_id')));

                                        foreach ($rating as $rating) {
                                            foreach ($rating as $rating) {
                                                $count = $rating['total'] / $reviewcount;
                                                $count = round($count, 2);
                                            }
                                        }
                                        ?>

                                        <span class="b-star"><span style="width:<?php
                                            if (!empty($rating)) {
                                                echo $count * 20;
                                            } else {
                                                echo '0';
                                            }
                                            ?>%" class="rstar"></span></span>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>

                                <div style="border-bottom:1px solid #ccc; float:left; width:100%;">
                                    <p align="center">


                                        <a href="<?php echo BASE_URL; ?><?php echo str_replace(' ', '_', strtolower(trim($category['Category']['category']))) . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name; ?><?php
                                        if (isset($_REQUEST['goldpurity'])) {
                                            echo '?purity=' . $_REQUEST['goldpurity'];
                                        }
                                        ?>">
                                            <input name="" type="submit" value="" class="addBtn" ></a>
                                        <a href="<?php echo BASE_URL; ?>webpages/whislist/<?php
                                        if (!empty($this->params['pass']['0'])) {
                                            echo $this->params['pass']['0'];
                                        } else {
                                            
                                        }
                                        ?>/<?php echo $products['Product']['product_id']; ?>/<?php
                                           if (!empty($images)) {
                                               echo $images['Productimage']['image_id'];
                                           }
                                           ?>">  <input name="" type="button" value="" class="wish_list_btn"></a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="listproduct" style="display:none;">
                            <div class="productDiv" style="width:100%; position:relative;">
                                <div style="position:absolute; right:-9px;">
                                    <div style="position:relative;"><?php
                                        if (in_array('1', explode(",", $products['Product']['product_view_type']))) {
                                            echo $this->Html->image('offer_img2.png', array("alt" => "Image"));
                                        }
                                        ?></div>
                                    <div style="position:relative;"><?php
                                        if (in_array('2', explode(",", $products['Product']['product_view_type']))) {
                                            echo $this->Html->image('offer_img.png', array("alt" => "Image"));
                                        }
                                        ?></div>
                                </div>
                                <div style="float:left; width:270px;">
                                    <p  style="height:133px;">
                                        <?php if (!empty($images['Productimage']['imagename'])) {
                                            ?>
                                            <a href="<?php echo BASE_URL; ?><?php echo $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name; ?><?php
                                            if (isset($_REQUEST['goldpurity'])) {
                                                echo '?purity=' . $_REQUEST['goldpurity'];
                                            }
                                            ?>"><img src="<?php echo BASE_URL . 'img/product/small/' . $images['Productimage']['imagename']; ?>"/></a>
                                               <?php
                                           } else {
                                               echo 'No Image Found';
                                           }
                                           ?> 	
                                    </p>
                                </div>

                                <div style="float:left; width:570px; height:40px;">
                                    <h3><?php echo $products['Product']['product_name']; ?></h3>
                                </div>

                                <div style="float:left; width:570px; height:50px;">
                                    <h1 class="total_amount_<?php echo $products['Product']['product_id']?>"></h1>
                                </div>

                                <div style="float:left; width:570px; height:50px;">
                                    <?php
                                    if (isset($_REQUEST['goldpurity'])) {
                                        $goldpurity = $_REQUEST['goldpurity'];
                                    } else {
                                        $purity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'], 'type' => 'purity'), 'order' => 'value ASC'));
                                        $goldpurity = $purity['Productmetal']['value'];
                                    }
                                    ?>
                                    <strong>Metal :</strong> <?php echo $goldpurity; ?>K <?php echo $products['Product']['metal_color']; ?> Gold <?php
                                    if ($products['Product']['stone'] == "Yes") {
                                        $stone_details = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id']), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
                                        echo '| Stone:' . $stone_details['Productdiamond']['clarity'] . '-' . $stone_details['Productdiamond']['color'];
                                    }
                                    ?> 
                                </div>

                                <div style="float:left; width:270px;">
                                    <a href="<?php echo BASE_URL; ?><?php echo $category['Category']['category'] . "/" . $subcat . "/" . $products['Product']['product_id'] . "/" . $Product_product_name; ?><?php
                                    if (isset($_REQUEST['goldpurity'])) {
                                        echo '?purity=' . $_REQUEST['goldpurity'];
                                    }
                                    ?>"><input name="" type="submit" value="" class="addBtn" ></a>             
                                    <a href="<?php echo BASE_URL; ?>/whislist/<?php
                                    if (!empty($this->params['pass']['0'])) {
                                        echo $this->params['pass']['0'];
                                    }
                                    ?>/<?php echo $products['Product']['product_id']; ?>/<?php
                                       if (!empty($images)) {
                                           echo $images['Productimage']['image_id'];
                                       }
                                       ?>">  <input name="" type="button" value="" class="wish_list_btn"></a>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                        </form>

                    <?php } ?>

                <?php } else {
                    ?>
                    <div class="no_more_image"> <div style="float:left; width:100%; padding:8px 0px 8px 0px; color:#ad8000; text-align:center; margin-top:30px; border-bottom:2px solid #dba715; background-color:#e7cb5d;" id="loadingimgae">No More Jewellery Available to view</div></div>

                <?php }
                ?>
            </div>
            <?php if (!empty($product)) { ?>
                <div class="no_more_image" style="display:none;">
                    <div style="float:left; width:100%; padding:8px 0px 8px 0px; color:#ad8000; text-align:center; margin-top:30px; border-bottom:2px solid #dba715; background-color:#e7cb5d;" id="loadingimgae">No More Jewellery Available to view</div>
                </div>        
            <?php } ?>
        </div>
    </div>
    <input type="hidden" name="flag" id="flag" value="0"/>
    <input type="hidden" name="total_page" id="total_page" value="<?php echo ceil($productcount / 6); ?>"/>
    <input type="hidden" name="current_page" id="current_page" value="1"/>
    <input type="hidden" name="checker" class="checker" value="grid"/>

    <script>
        $(document).ready(function () {
            $('.more').click(function () {
                thisvar = $(this);
                thisvar.parents('ul').find('.shape').css({height: '100%'});
                thisvar.parents('ul').find('.shape').show(100);
                thisvar.parents('ul').find('.more').hide();
                thisvar.parents('ul').find('.less').show();

            });
            $('.less').click(function () {
                thisvar = $(this);
                thisvar.parents('ul').find('.shape').css({height: '127px'});
                thisvar.parents('ul').find('.shape').show(100);
                thisvar.parents('ul').find('.less').hide();
                thisvar.parents('ul').find('.more').show();

            });

        });

    </script>
    <script type="text/javascript">
        $(function () {
            var allRadios = $('input[type=radio]')
            var radioChecked;

            var setCurrent =
                    function (e) {
                        var obj = e.target;

                        radioChecked = $(obj).attr('checked');
                        search_redirect()
                    }

            var setCheck =
                    function (e) {

                        /*if (e.type == 'keypress' && e.charCode != 32) {
                         return false;
                         }*/

                        var obj = e.target;

                        if (radioChecked) {
                            $(obj).attr('checked', false);
                        } else {
                            $(obj).attr('checked', true);
                        }
                        search_redirect()
                    }

            $.each(allRadios, function (i, val) {
                var label = $('label[for=' + $(this).attr("id") + ']');

                $(this).bind('mousedown keydown', function (e) {
                    setCurrent(e);
                });

                label.bind('mousedown keydown', function (e) {
                    e.target = $('#' + $(this).attr("for"));
                    setCurrent(e);
                });

                $(this).bind('click', function (e) {
                    setCheck(e);
                });

            });
        });
    </script>
    <script>
        function search_redirect() {
            var arg = [];
            $('#left_side input[type=radio]:checked').each(function () {
                arg.push($(this).attr('name') + '=' + $(this).val());
            });
            request = arg.join('&');
            window.location = "<?php echo BASE_URL . $this->request->url; ?>?" + request + '<?php
            if (isset($_REQUEST['filter'])) {
                echo '&filter=' . $_REQUEST['filter'];
                if (isset($_REQUEST['order'])) {
                    echo '&order=' . $_REQUEST['order'];
                }
            }
            ?>';
        }


    </script>

    <script>
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() + 400 > ($(document).height() - $(window).height())) {
                    load_images();

                }
            });
        });
		
        function load_images() {
            value = $('#flag').val();
            if (value == 0) {
                $('#flag').val('1');
                if (parseInt($('#total_page').val()) > parseInt($('#current_page').val())) {
//                    $('.helpfade').show();
//                    $('.helptips').show();
                    display_page = parseInt($('#current_page').val()) + 1;
                    checker = $('.checker').val();
                    $.ajax({
                        url: "<?php echo BASE_URL; ?>webpages/load_more",
                        type: 'GET',
                        timeout: 4000,
                        data: 'page=' + display_page + '<?php
            if (!empty($this->params['pass']['0'])) {
                echo '&category=' . $this->params['pass']['0'];
                if (!empty($this->params['pass'][1])) {
                    echo '&subcategory=' . $this->params['pass']['1'];
                }
				
				if(strpos($this->params['pass'][count($this->params['pass'])-1],'type')!==false)
				{
					echo '&product_type=' . $this->params['pass'][count($this->params['pass'])-1];
				}
            } if (!empty($_GET)) {
                $arr = $_GET;
                array_walk($arr, create_function('&$i,$k', '$i="$k=$i";'));
                echo '&' . implode($arr, "&");
            }
            ?>',
                        dataType: 'json',
                        success: function (data) {
                            if (data != '') {
                                $('.productMiddleRight').append(data.productdiv);
                                if (checker == "grid") {
                                    $('.gridproduct').show();
                                    $('.listproduct').hide();
                                } else {
                                    $('.gridproduct').hide();
                                    $('.listproduct').show();
                                }
                                values = parseInt($('#current_page').val()) + 1;
                                $('#current_page').val(values);
                                $('.countpage').html(parseInt($('.countpage').html()) + parseInt(data.count));
//                                $('.helpfade').hide();
//                                $('.helptips').hide();
                                $('#flag').val('0');
                            } else {
                                $('#flag').val('1');
                            }
                            
                            //added by prakash
                            /*$('.hidden_div').each(function(){
                                calprice($(this).data('productid'));
                            }); */


                        }

                    });

                } else {
                    $('.no_more_image').show();
                }
            }
        }

    </script>
    <script>
        $(document).ready(function () {
            $('.grid').click(function () {
                $('.gridproduct').show();
                $('.listproduct').hide();
                $('.grid').removeClass('hide');
                $('.list').addClass('hide');
                $('.checker').val('grid');
                $('#flag').val('0');
                $('.no_more_image').hide();

            });
            $('.list').click(function () {
                $('.listproduct').show();
                $('.gridproduct').hide();
                $('.grid').addClass('hide');
                $('.list').removeClass('hide');
                $('.checker').val('list');
                $('#flag').val('0');
                $('.no_more_image').hide();
            });
        });
    </script>

    <!--added by prakas -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.hidden_div').each(function(){
                calprice($(this).data('productid'));
            });
        });

        function calprice(product_id) {
            var size = $('#hidden_size_'+product_id).val();
            var color = $('#hidden_color_'+product_id).val();
            var diamond = $('#hidden_stone_'+product_id).val();
            var purity = $('#hidden_purity_'+product_id).val();
            
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>webpages/calculate_price/",
                data: 'customid=' + purity + 'K' + diamond + "&size=" + size + "&gcolor=" + color + "&product_id=" + product_id,
                dataType: 'json',
                success: function (data) {
                    $('.total_amount_'+product_id).html('Rs. '+ data.total);
                    $('#cart_div_'+product_id).html(data.cartdiv);
                    
//                    $('#product_div_'+product_id).html(data.product_details);
//                    $('#diamond_div_'+product_id).html(data.stonedetails);
//                    $('#price_div_'+product_id).html(data.pricediv);
//                    $('#gemstoneprice_'+product_id).html(data.gemstone);
//                    $('#gemstone_'+product_id).html(data.gemstonediv);
                }
            });
        }
    </script>