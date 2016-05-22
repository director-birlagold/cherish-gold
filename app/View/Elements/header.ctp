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
                            <li style="color:#dba715;"><?php //echo  $this->Html->image("cart_icn.png",array("alt" => "index"));                    ?>
                                <!--                                <div id="loginContainer">
                                <?php echo $this->Html->image("cart_icn.png", array("alt" => "index", 'style' => 'margin-top: 10px;')); ?>
                                                                    <a href="#" id="loginButton" class="shopping-cart"><span id="top_qty"> Cart <?php
                                if ($this->Session->read('cart_process') != '') {
                                    $cartcount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process')), 'fields' => array('SUM(quantity) AS tot_qty')));
                                    if (!empty($cartcount)) {
                                        echo '(' . $cartcount[0]['tot_qty'] . ')';
                                    }
                                }
                                ?></span></a>
                                                                    <div style="clear:both"></div>
                                                                    <div id="loginBox">                
                                                                        <form id="loginForm">
                                                                        </form>
                                                                    </div>
                                                                </div>-->
                                <a class="shopping-cart" href="<?php echo BASE_URL; ?>shoppingcarts/shopping_cart"> <?php echo $this->Html->image("cart_icn.png", array("alt" => "index")); ?> Cart <?php
                                    if ($this->Session->read('cart_process') != '') {
                                        $cartcount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process')), 'fields' => array('SUM(quantity) AS tot_qty')));
                                        if (!empty($cartcount)) {
                                            echo $cartcount[0]['tot_qty'] != '' ? '(' . $cartcount[0]['tot_qty'] . ')' : '';
                                        }
                                    }
                                    ?> 
                                </a>

                            </li>
                            <?php if ($this->Session->read('User') == '') { ?>   <li id="login"> <?php echo $this->Html->Link('Register', array('controller' => 'signin', 'action' => 'index')); ?>&nbsp;
                                    <div class="Registered"></div>
                                </li>
                            <?php } ?>
                            <?php if ($this->Session->read('User')) { ?>
                                <li id="login">
                                    <?php echo $this->Session->read('User.user_type') == 2 ? $this->Html->link('User Orders', array('action' => 'user_orders', 'controller' => 'vendors')) . ' / ' : ''; ?>   
                                    <?php echo $this->Html->link('My Account', array('action' => 'details', 'controller' => 'signin')); ?> 
                                    <?php echo $this->Session->read('User.user_type') == 1 ? $this->Html->link('My Catalogue', array('action' => 'index', 'controller' => 'franchiseeproducts')) : ''; ?> /  
                                    <?php echo $this->Html->link('My Order', array('action' => 'my_order', 'controller' => 'orders')); ?> /  
                                    <?php echo $this->Html->link('Wish List', array('action' => 'wishlist', 'controller' => 'signin')); ?> / 
                                    <?php echo $this->Html->link('Logout', array('controller' => 'signin', 'action' => 'logout'), array('escape' => false, 'id' => 'login')); ?>
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
                    <h4>Birla Gold and Precious Metals Limited</h4>
                </div>
            </div>

            <div class="header_menu" style="display: none"> 
                <ul id="nav">
                    <li class="home_icn"><a href="<?php echo BASE_URL; ?>"><?php echo $this->Html->image("home_icn.png", array("alt" => "index")); ?></a></li>
                    <?php
                    ClassRegistry::init('Menu')->Behaviors->attach('Containable');
                    $menus = ClassRegistry::init('Menu')->find('all', array(
                        'contain' => array(
                            'Submenu' => array(
                                'Offer' => array(
                                    'conditions' => array('Offer.is_active' => '1')
                                ),
                                'conditions' => array('Submenu.is_active' => '1'),
                            ),
                        ),
                        'conditions' => array('Menu.is_active' => '1'),
                        'order' => 'Menu.menu_order'
                    ));

//                    $menus = ClassRegistry::init('Menu')->find('all', array('recursive' => 2, 'conditions' => array('is_active' => '1'), 'order' => array('menu_order asc')));
                    $left = 133;
                    foreach ($menus as $key => $menu) {
                        $left -= 134;
                        //Jewellery Meun
                        if ($menu['Menu']['menu_id'] == 1) {
                            ?>
                            <!--Jewelery Menu-->
                            <li class="baseitem" data-left="<?php echo $left ?>"><?php echo $this->Html->link($menu['Menu']['menu_name'], array('action' => 'jewellery', 'controller' => 'webpages'), array('class' => 'primary_link')); ?>
                                <?php
                                if ($menu['Menu']['category_ids'] != '') {
                                    ?>
                                    <div class="dropdown shagun_megamenu">
                                        <div class="menutabs" id="tabs<?php echo $menu['Menu']['menu_id'] ?>">
                                            <ul>
                                                <?php
                                                $ids = explode(',', $menu['Menu']['category_ids']);
                                                $category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active', 'category_id' => $ids), 'order' => 'category_id ASC'));

                                                foreach ($category as $cateogies) {
                                                    ?>
                                                    <li><a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $cateogies['Category']['category_id']; ?>"><?php echo $cateogies['Category']['category']; ?></a><i class="arrow-r"></i></li>
                                                    <?php
                                                }
                                                ?> 
                                                <li class="divider"><a href="#tabs-999">Diamond Jewellery</a><i class="arrow-r"></i></li>
                                                <li><a href="#tabs-910">Plain Gold Jewellery</a><i class="arrow-r"></i></li>
                                                <li><a href="#tabs-911">Gemstone Jewellery</a><i class="arrow-r"></i></li>
                                            </ul>
                                            <?php
                                            foreach ($category as $cateogies) {
                                                $subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active'), array('limit' => 8)));
                                                ?>

                                                <div id="tabs-<?php echo $menu['Menu']['menu_id'] . $cateogies['Category']['category_id']; ?>">
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
                                                    <a href="<?php echo BASE_URL . $cateogies['Category']['link']; ?>" id="viewall_jewellery">View All</a>
                                                </div>
                                            <?php } ?>    
                                            <div id="tabs-999">
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
                                                    
                                                </div>
                                                <a id="viewall_jewellery" href="<?php echo BASE_URL; ?>product?jewellery=diamond">View All</a>
                                            </div>
                                            <div id="tabs-910">
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
                                            <div id="tabs-911">
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
                                <?php } ?>
                            </li>
                            <!--Gold Coin Menu-->
                        <?php } elseif ($menu['Menu']['menu_id'] == 2) { ?>
                            <li class="baseitem" data-left="<?php echo $left ?>">
                                <?php
                                $gold_category = ClassRegistry::init('Category')->find('first', array(
                                    'conditions' => array(
                                        'Category.category' => array('Gold Coins', 'Gold Coin')
                                )));
                                ?>
                                <?php $gold_url = !empty($gold_category) ? BASE_URL . "details/" . $gold_category['Category']['link'] : ''; ?>
                                <a class="primary_link" href="<?php echo $gold_url ?>"><?php echo $menu['Menu']['menu_name'] ?></a>
                                <div class="dropdown gold_navmenu vertical_menu">
                                    <div class="menutabs" id="tabs<?php echo $menu['Menu']['menu_id'] ?>">
                                        <ul>
                                            <li><a class="titlesubmenu" style="cursor: text !important;"><strong>By Weight</strong></a></li>
                                            <?php
                                            if (!empty($gold_category)) {
                                                $subcategories = ClassRegistry::init('Subcategory')->findAllByCategoryId($gold_category['Category']['category_id']);
                                                foreach ($subcategories as $key => $subcategory) {
                                                    $subcat = $subcategory['Subcategory']['subcategory'];
                                                    $product_url = BASE_URL . $gold_category['Category']['link'] . '/' . $subcategory['Subcategory']['link'];
                                                    ?>
                                                    <li>
                                                        <a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $cateogies['Category']['category_id']; ?>" onclick="location.href = '<?php echo $product_url ?>'"><?php echo $subcategory['Subcategory']['subcategory']; ?></a>
                                                    </li>
                                                    <!--<li><a href="<?php echo BASE_URL . $gold_category['Category']['category'] . "/" . $subcat . "/" . $product['Product']['product_id'] . "/" . $Product_product_name; ?>"><?php echo $product['Product']['product_name']; ?></a></li>-->
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <li><a class="titlesubmenu" style="cursor: text !important;"><strong>By Purity</strong></a></li>
                                            <li><a href="#tabs-801" onclick="location.href = '<?php echo BASE_URL . 'product?goldfineness=999' ?>'">24K 999</a></li>
                                            <li><a href="#tabs-802" onclick="location.href = '<?php echo BASE_URL . 'product?goldfineness=995' ?>'">24K 995</a></li>
                                        </ul>
                                        <?php if (isset($products)) { ?>
                                            <div id="tabs-<?php echo $menu['Menu']['menu_id'] . $cateogies['Category']['category_id']; ?>">
                                                <div style="float:left;">
                                                    <div class="clear">&nbsp;</div>
                                                </div>
                                            </div>

                                        <?php } ?>
                                        <div id="tabs-801">
                                            <div style="float:left;">
                                                <div class="clear">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div id="tabs-802">
                                            <div style="float:left;">
                                                <div class="clear">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--Solitaires-->
                        <?php } /* elseif ($menu['Menu']['menu_id'] == 3) { ?>
                          <li class="baseitem" data-left="<?php echo $left ?>">
                          <a class="primary_link" href="#"><?php echo $menu['Menu']['menu_name'] ?></a>
                          </li>
                          <!--Bridal & Men & Collection & Gifts-->
                          <?php
                          } */ elseif ($menu['Menu']['menu_id'] == 3 || $menu['Menu']['menu_id'] == 4 || $menu['Menu']['menu_id'] == 5 || $menu['Menu']['menu_id'] == 6 || $menu['Menu']['menu_id'] == 7) {
                            ?>
                            <li class="baseitem" data-left="<?php echo $left ?>">
                                <a class="primary_link" href="#"><?php echo $menu['Menu']['menu_name'] ?></a>
                                <div class="dropdown vertical_menu" id="<?php echo strtolower($menu['Menu']['menu_name']) ?>_navmenu">
                                    <div class="menutabs" id="tabs<?php echo $menu['Menu']['menu_id'] ?>">
                                        <ul>
                                            <?php if ($menu['Menu']['menu_id'] == 7) { ?>
                                                <li><a class="titlesubmenu" style="cursor: text !important;"><strong>Gift Forever</strong></a></li>
                                            <?php } ?>

                                            <?php
                                            $gift_sub_count = 0;
                                            foreach ($menu['Submenu'] as $submenu) {
                                                if ($gift_sub_count < 5 && $menu['Menu']['menu_id'] == 7) {
                                                    ?>
                                                    <li><a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id']; ?>" onclick="location.href = '<?php echo BASE_URL . 'product?submenu=' . $submenu['submenu_id'] ?>'"><?php echo $submenu['submenu_name']; ?></a></li>
                                                    <?php
                                                } elseif (in_array($menu['Menu']['menu_id'], array(3, 4, 5, 6))) {
                                                    ?>
                                                    <li><a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id']; ?>" onclick="location.href = '<?php echo BASE_URL . 'product?submenu=' . $submenu['submenu_id'] ?>'"><?php echo $submenu['submenu_name']; ?></a></li>
                                                    <?php
                                                } else {
                                                    $gift_sub_count = 0;
                                                    break;
                                                }
                                                $gift_sub_count++;
                                            }
                                            ?> 
                                            <?php if ($menu['Menu']['menu_id'] == 7) { ?>
                                                <li><a class="titlesubmenu" style="cursor: text !important;"><strong>Gift Suits you</strong></a></li>
                                                <li><a href="#tabs-1001" onclick="location.href = '<?php echo BASE_URL . 'product?price=1' ?>'">Under Rs. 10,000 /-</a></li>
                                                <li><a href="#tabs-1002" onclick="location.href = '<?php echo BASE_URL . 'product?pricefilter=2' ?>'">Rs. 10,001 /- to Rs. 25,000/-</a></li>
                                                <li><a href="#tabs-1003" onclick="location.href = '<?php echo BASE_URL . 'product?pricefilter=3' ?>'">Rs. 25,001 /- to Rs. 50,000/-</a></li>
                                                <li><a href="#tabs-1004" onclick="location.href = '<?php echo BASE_URL . 'product?pricefilter=4' ?>'">Rs. 50,001 /- to Rs. 75,000/-</a></li>
                                                <li><a href="#tabs-1005" onclick="location.href = '<?php echo BASE_URL . 'product?pricefilter=5' ?>'">Rs. 75,001 /- and above</a></li>
                                            <?php } ?>
                                            <?php
                                            foreach ($menu['Submenu'] as $submenu) {
                                                if ($gift_sub_count >= 5 && $menu['Menu']['menu_id'] == 7) {
                                                    ?>
                                                    <li><a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id']; ?>" onclick="location.href = '<?php echo BASE_URL . 'product?submenu=' . $submenu['submenu_id'] ?>'"><?php echo $submenu['submenu_name']; ?></a></li>
                                                    <?php
                                                }
                                                $gift_sub_count++;
                                            }
                                            ?> 
                                        </ul>
                                        <?php
                                        if (!empty($menu['Submenu'])) {
                                            foreach ($menu['Submenu'] as $submenu) {
                                                ?>
                                                <div id="tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id']; ?>">
                                                    <div style="float:left;">
                                                        <div class="clear">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php for ($k = 1001; $k <= 1005; $k++) { ?>
                                            <div id="tabs-<?php echo $k ?>">
                                                <div style="float:left;">
                                                    <div class="clear">&nbsp;</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                            <!--Offers-->
                        <?php } elseif ($menu['Menu']['menu_id'] == 8) { ?>
                            <li class="baseitem" id="offer_header" data-left="<?php echo $left ?>">
                                <a class="primary_link" href="#"><?php echo $menu['Menu']['menu_name'] ?></a>
                                <div class="dropdown vertical_menu" id="<?php echo strtolower($menu['Menu']['menu_name']) ?>_navmenu">
                                    <div class="menutabs" id="tabs<?php echo $menu['Menu']['menu_id'] ?>">
                                        <ul>
                                            <?php
                                            foreach ($menu['Submenu'] as $submenu) {
                                                ?>
                                                <li><a class="titlesubmenu" style="cursor: text !important;"><strong><?php echo $submenu['submenu_name']; ?></strong></a></li>
                                                <?php foreach ($submenu['Offer'] as $key => $offer) { ?>
                                                    <li><a href="#tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id'] . $offer['offer_id']; ?>" onclick="location.href = '<?php echo BASE_URL . 'product?offers=' . $offer['offer_id'] ?>'"><?php echo $offer['offer_name']; ?></a></li>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </ul>
                                        <?php
                                        if (!empty($menu['Submenu'])) {
                                            foreach ($menu['Submenu'] as $submenu) {
                                                foreach ($submenu['Offer'] as $key => $offer) {
                                                    ?>
                                                    <div id="tabs-<?php echo $menu['Menu']['menu_id'] . $submenu['submenu_id'] . $offer['offer_id']; ?>">
                                                        <div style="float:left;">
                                                            <div class="clear">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>

					<li class="baseitem">
						<a class="primary_link" href="http://www.cherishgold.com/staging/birla/"><?php echo 'BGP Plan'; ?></a>
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

//        $.ajax({
//            type: "POST",
//            url: "<?php echo BASE_URL; ?>shoppingcarts/minicart",
//            dataType: 'html',
//            success: function (data) {
//                $('#loginForm').html(data);
////                    $('#product_div_'+product_id).html(data.product_details);
////                    $('#diamond_div_'+product_id).html(data.stonedetails);
////                    $('#price_div_'+product_id).html(data.pricediv);
////                    $('#gemstoneprice_'+product_id).html(data.gemstone);
////                    $('#gemstone_'+product_id).html(data.gemstonediv);
//            }
//        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {


        /*Header Animation*/
        function fixDiv() {
            var $cache = $('.header_menu');
            if ($(window).scrollTop() > 130) {
                $cache.css({'position': 'fixed', 'top': '0px'});
//$('#nav li.baseitem').css({'width':'60px'});
//$('#nav li.goldcoin').css({'width':'70px'});
//$('#nav > li a').css({'font-size':'12px'});	
//$('#menu_cart').css({'display':'block'});	
            }
            else {
                $cache.css({'position': 'absolute', 'top': 'auto'});
//$('#nav li.baseitem').css({'width':'75px'});
//$('#nav > li a').css({'font-size':'14px'});	
//$('#menu_cart').css({'display':'none'});	
            }
        }
        $(window).scroll(fixDiv);
        fixDiv();
        /*Header Animation*/



    });


</script>