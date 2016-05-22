<div style="position:fixed; width:100%; background-color:#fff; top:0px; z-index:9999;">
    <div class="main">
        <header>
            <div class="header_top">
                <a href="<?php echo BASE_URL; ?>"><div class="logo"></div></a>
                <div class="logo_div"></div>
                <div class="top_mid"><table cellpadding="0" cellspacing="0" border="0" width="75%" align="center" class="contentText">
                        <tr>
                            <td align="left"><a href="<?php echo BASE_URL; ?>certified-jewelers">CERTIFIED JEWELLERY</a></td>
                            <td align="left" class="bdrToprightNone"><a href="<?php echo BASE_URL; ?>delivery-details">DOOR STEP DELIVERY</a></td>
                        </tr>
                        <tr>
                            <td align="left" class="bdrTopbottomNone"><a href="<?php echo BASE_URL; ?>transparent-pricing">TRANSPARENT PRICING</a></td>
                            <td align="left" class="bdrToprightNone bdrTopbottomNone"><a href="<?php echo BASE_URL; ?>jewellery-experience">JEWELLERY EXPERIENCE CENTER</a></td>
                        </tr>
                    </table> </div>
                <div class="top_right">
                    <div class="shop_info_menu">
                        <ul>
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->Html->image("phone_icn.png", array("alt" => "index")); ?><span style="padding-top:3px; font-size:16px;"> 1800 1022 066</span></li>
                            <li style="color:#dba715;"><?php //echo  $this->Html->image("cart_icn.png",array("alt" => "index"));   ?> 
                                <a href="<?php echo BASE_URL; ?>shoppingcarts/shopping_cart"> <?php echo $this->Html->image("cart_icn.png", array("alt" => "index")); ?> Cart <?php
                                    if ($this->Session->read('cart_process') != '') {
                                        $cartcount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process')), 'fields' => array('SUM(quantity) AS tot_qty')));
                                        if (!empty($cartcount)) {
                                            echo '(' . $cartcount[0]['tot_qty'] . ')';
                                        }
                                    }
                                    ?> </a>

                            </li>
                            <?php if ($this->Session->read('User') == '') { ?>   <li id="login"> <?php echo $this->Html->Link('Register', array('controller' => 'signin', 'action' => 'index')); ?>&nbsp;
                                    <div class="Registered"></div>
                                </li>
                            <?php } ?>
                            <?php if ($this->Session->read('User')) { ?>
                                <li id="login"><?php echo $this->Html->link('My Account', array('action' => 'details', 'controller' => 'signin')); ?> <?php echo $this->Session->read('User.user_type') == 1 ? ' / ' . $this->Html->link('My Catalogue', array('action' => 'index', 'controller' => 'franchiseeproducts')) : ''; ?> /  <?php echo $this->Html->link('My Order', array('action' => 'my_order', 'controller' => 'orders')); ?> /  <?php echo $this->Html->link('Wish List', array('action' => 'wishlist', 'controller' => 'signin')); ?> / <?php echo $this->Html->link('Logout', array('controller' => 'signin', 'action' => 'logout'), array('escape' => false, 'id' => 'login')); ?>
                                <?php } else { ?>
                                <li id="login"><?php echo $this->Html->Link('Sign in', array('controller' => 'signin', 'action' => 'index')); ?> /
                                <?php } ?>
                                <div class="Sign in"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="shop_info_search">
                        <div class="shop_info_search_box">
                            <form method="get" name="auto_search_form" id="autoForm" action="<?php echo BASE_URL; ?>product">
                                <button type="submit"  value="" name="search_button" class="search_product"><?php echo $this->Html->image("icons/search.png", array("alt" => "index")); ?></button>
                                <input type="text" name="search" class="validate[required]" id="search"  placeholder="Search Here" >
                            </form>
                            <script>
                                $(document).ready(function () {
                                    $("#autoForm").validationEngine();
                                });
                            </script>
                        </div>
                    </div>
                    <h4>Birla Gold and Precious Metals Private Limited</h4>
                </div>
            </div>
            <div class="header_menu"> 
                <!--<ul>
                  <li class="home_icn"><a href="index.php"><img src="images/home_icn.png" alt="" /></a></li>
                  <li><a href="#">Jewellery</a></li>
                  <li><a href="#">Gold Coins</a></li>
                  <li><a href="#">Solitaires</a></li>
                  <li><a href="#">Bridal</a></li>
                  <li><a href="#">Men</a></li>
                  <li><a href="#">Collections</a></li>
                  <li><a href="#">Gifts</a></li>
                  <li><a href="#">Offers </a></li>
                </ul>-->
                <ul id="nav">
                    <li class="home_icn"><a href="<?php echo BASE_URL; ?>"><?php echo $this->Html->image("home_icn.png", array("alt" => "index")); ?></a></li>
                    <li class="baseitem"><?php echo $this->Html->link('Jewellery', array('action' => 'jewellery', 'controller' => 'webpages'), array('class' => 'primary_link')); ?>
                        <div class="dropdown shagun_megamenu">
                            <div id="tabs">
                                <ul>
                                    <?php
                                    $category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'category_id ASC'));
                                    foreach ($category as $cateogies) {
//                                        $product = ClassRegistry::init('Product')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active')));
                                        ?>
                                        <li><a href="#tabs-<?php echo $cateogies['Category']['category_id']; ?>"><?php echo $cateogies['Category']['category']; ?></a><i class="arrow-r"></i></li>
                                        <?php
                                    }
                                    ?> 
                                    <li class="divider"><a href="#tabs-9">Diamond Jewellery</a><i class="arrow-r"></i></li>
                                    <li><a href="#tabs-10">Plain Gold Jewellery</a><i class="arrow-r"></i></li>
                                    <li><a href="#tabs-11">Gemstone Jewellery</a><i class="arrow-r"></i></li>
                                </ul>
                                <?php
                                foreach ($category as $cateogies) {
                                    $subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active'), array('limit' => 8)));
                                    ?>

                                    <div id="tabs-<?php echo $cateogies['Category']['category_id']; ?>">
                                        <div style="float:left;">
                                            <?php
                                            $i = 0;
                                            if (!empty($subcategory)) {
                                                foreach ($subcategory as $subcategory) {

                                                    $prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('subcategory_id' => $subcategory['Subcategory']['subcategory_id'], 'status' => 'Active')));

                                                    if (!empty($prodcuts)) {
                                                        $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
                                                        ?>
                                                        <?php if (!empty($image['Productimage']['imagename'])) { ?>
                                                            <div class="menu_product">
                                                                <a href="<?php echo BASE_URL . $cateogies['Category']['link'] . '/' . $subcategory['Subcategory']['link']; ?>"> <?php echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120')); ?></a>
                                                                <?php echo $this->Html->link($subcategory['Subcategory']['subcategory'], array('action' => 'product', 'controller' => 'webpages', $subcategory['Subcategory']['link']), array('escape' => false)); ?></div>
                                                        <?php } elseif (empty($image['Productimage']['imagename'])) { ?>
                                                            <div class="menu_product"><div class="noimage"><?php echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120')); ?></div><a href="product.php"><?php echo $subcategory['Subcategory']['link']; ?></a></div>
                                                        <?php } ?>
                                                        <?php
                                                        $i++;
                                                        if ($i % 4 == 0) {
                                                            echo '<div class="clear">&nbsp;</div>';
                                                        }
                                                    } else {
                                                        
                                                    }
                                                }
                                            }
                                            ?>            
                                        </div>
                                        <!-- <a id="viewall_jewellery">View All</a>-->
                                        <a href="<?php echo BASE_URL . $cateogies['Category']['link']; ?>" id="viewall_jewellery">View All</a>
                                    </div>

                                    <?php
                                }
                                ?>    
                                <div id="tabs-9">
                                    <div style="float:left;">
                                        <?php
                                        $i = 0;
                                        foreach ($category as $cateogies) {
                                            /* $prodcuts=ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' =>$cateogies['Category']['category_id'],'stone'=>'Yes','status'=>'Active'),'group'=>'category_id')); */
                                            $prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active', 'FIND_IN_SET(2, Product.product_type)'), 'group' => 'category_id'));

                                            if (!empty($prodcuts)) {
                                                $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
                                                ?>
                                                <?php if (!empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product">
                                                        <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=diamond"><?php
                                                            echo $this->Html->image(
                                                                    'product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120'));
                                                            ?></a>
                                                        <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=diamond"><?php echo $cateogies['Category']['category']; ?></a></div>
                                                <?php } elseif (empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product"><div class="noimage"><a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=diamond"><?php echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120')); ?></a></div> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=diamond"><?php echo $cateogies['Category']['category']; ?></a></div>
                                                <?php } ?>
                                                <?php
                                                $i++;
                                                if ($i % 4 == 0) {
                                                    echo '<div class="clear">&nbsp;</div>';
                                                }
                                            }
                                        }
                                        ?>            
                                        <div class="clear">&nbsp;</div>
                                    </div>
                                    <a id="viewall_jewellery" href="<?php echo BASE_URL; ?>product?jewellery=diamond">View All</a>
                                </div>
                                <div id="tabs-10">
                                    <div style="float:left;">
                                        <?php
                                        $i = 0;
                                        foreach ($category as $cateogies) {
                                            /*  $prodcuts=ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' =>$cateogies['Category']['category_id'],'stone !='=>'Yes','gemstone !='=>'Yes','status'=>'Active'),'group'=>'category_id')); */
                                            $prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active', 'FIND_IN_SET(1,Product.product_type)'), 'group' => 'category_id'));
                                            if (!empty($prodcuts)) {
                                                $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
                                                ?>
                                                <?php if (!empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product">
                                                        <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=plain_gold"><?php
                                                            echo
                                                            $this->Html->image(
                                                                    'product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120')
                                                            );
                                                            ?></a>
                                                        <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=plain_gold"> <?php echo $cateogies['Category']['category']; ?></a></div>
                                                <?php } elseif (empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product"><div class="noimage"> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=plain_gold"><?php echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120')); ?></a></div> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=plain_gold"><?php echo $cateogies['Category']['category']; ?></a></div>
                                                <?php } ?>
                                                <?php
                                                $i++;
                                                if ($i % 4 == 0) {
                                                    echo '<div class="clear">&nbsp;</div>';
                                                }
                                            }
                                        }
                                        ?> 
                                        <div class="clear">&nbsp;</div> 
                                    </div>  
                                    <a id="viewall_jewellery" href="<?php echo BASE_URL; ?>product?jewellery=plain_gold">View All</a>       
                                </div>
                                <div id="tabs-11">
                                    <div style="float:left;">
                                        <?php
                                        foreach ($category as $cateogies) {
                                            /* $prodcuts=ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' =>$cateogies['Category']['category_id'],'gemstone'=>'Yes','status'=>'Active'),'group'=>'category_id')); */
                                            $prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active', 'FIND_IN_SET(3,Product.product_type)'), 'group' => 'category_id'));
                                            if (!empty($prodcuts)) {
                                                $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
                                                ?>
                                                <?php if (!empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product">
                                                        <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=gemstone"> <?php
                                                            echo
                                                            $this->Html->image(
                                                                    'product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120')
                                                            );
                                                            ?></a> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=gemstone">
                                                            <?php echo $cateogies['Category']['category']; ?>
                                                        </a></div>
                                                <?php } elseif (empty($image['Productimage']['imagename'])) { ?>
                                                    <div class="menu_product"><div class="noimage"> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=gemstone"><?php echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120')); ?></a></div> <a href="<?php echo BASE_URL; ?>product?category=<?php echo str_replace(' ', '_', strtolower($cateogies['Category']['category'])); ?>&jewellery=gemstone"><?php echo $cateogies['Category']['category']; ?></a></div>
                                                <?php } ?>
                                                <?php
                                                $i++;
                                                if ($i % 4 == 0) {
                                                    echo '<div class="clear">&nbsp;</div>';
                                                }
                                            }
                                        }
                                        ?>


                                        <div class="clear">&nbsp;</div>   </div>
                                    <a id="viewall_jewellery" href="<?php echo BASE_URL; ?>product?jewellery=gemstone">View All</a>
                                </div>
                            </div>
                            </div>
                    </li>
                    <li class="baseitem" style="width:70px;"> <a class="primary_link" href="#">Gold Coins</a> 
                        <!--<div class="dropdown gold_menu">
                            <h4>By Weight</h4>
                            <a href="#">0.5 gms</a>
                            <a href="#">1 gms</a>	
                            <a href="#">2 gms</a>	
                            <a href="#">5 gms</a>	
                            <a href="#">8 gms</a>
                            <a href="#">10 gms</a>
                            <a href="#">20 gms</a>				
                                    </div>-->
                    </li>
                    <li class="baseitem"><a class="primary_link" href="#">Solitaires</a></li>
                    <li class="baseitem"><a class="primary_link" href="#">Bridal</a></li>
                    <li class="baseitem"><a class="primary_link" href="#">Men</a></li>
                    <li class="baseitem"><a class="primary_link" href="#">Collections</a></li>
                    <li class="baseitem"><a class="primary_link" href="#">Gifts</a></li>
                    <li class="baseitem"> <a class="primary_link" href="#">Offers</a> 
                        <!--<div class="right dropdown hide">
                                    <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                            </div>--> 
                    </li>
                </ul>
            </div>
        </header>
    </div>
</div>
<!--<script>
 $(function () {
        $("#search").autocomplete({
            autoFocus: true,
            source: "<?php echo BASE_URL; ?>webpages/auto_search"

        });
});
</script>-->
<script>
    $(document).ready(function () {
        $("#autoForm").validationEngine();

    });
</script>