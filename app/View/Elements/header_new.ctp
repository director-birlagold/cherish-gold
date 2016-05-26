<div id="bt_header" class="" >
	<div class="header-top">
		<div class="row">
			<div class="header-top-first col-lg-12 col-md-12 col-sm-12 col-xs-12 black-header">
				<div class="container">
					<div class="margin-5">
						<div class="pull-left offer">
							<!-- <a href="#">
								<span class=" offer-txt offers">OFFERS </span>
							</a>
							<span class="offer-txt">SAVE UPTO 
								<span>30%</span> ON ALL GOLD JEWELLERY 
							</span>
							<a href="#">
								<span class=" offer-txt shop-now">SHOP NOW</span>
							</a> -->
							<span class="offer-txt"> SUBSCRIBE OUR NEW</span>
							<a href="<?php echo BASE_URL; ?>">
								<span class=" offer-txt offers">BGP PLAN</span>
							</a>
						</div>
					</div>
					<div id="pull-right top-links" class="nav pull-right">
						<ul class="list-inline">
							<li class="dropdown">
								<a href="javascript:void(0)" title="My Account" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-user"></i>
									<?php if($this->Session->check('User.first_name')) { ?>
										<span class=""><?php echo $this->Session->read('User.first_name') ." ".$this->Session->read('User.last_name'); ?></span>
									<?php } else { ?>
										<span class="">My Account</span>
									<?php } ?>	
									<span class="caret"></span>
								</a>
								
								<ul class="dropdown-menu dropdown-menu-right">
									<?php if (!$this->Session->check('User.first_name')) { ?>
										<li>
											<a href="<?php echo BASE_URL."signin?rel=register"; ?>">Register</a>
										</li>
										<li>
											<a href="<?php echo BASE_URL."signin"; ?>">Login</a>
										</li>
									<?php }else{ ?>
										<li><?php echo $this->Session->read('User.user_type') == 2 ? $this->Html->link('User Orders', array('action' => 'user_orders', 'controller' => 'vendors')) . ' / ' : ''; ?></li>   
										<li><?php echo $this->Html->link('My Account', array('action' => 'details', 'controller' => 'signin')); ?> </li>
										<li><?php echo $this->Session->read('User.user_type') == 1 ? ' / ' . $this->Html->link('My Catalogue', array('action' => 'index', 'controller' => 'franchiseeproducts')) : ''; ?> </li> 
										<li><?php echo $this->Html->link('My Order', array('action' => 'my_order', 'controller' => 'orders')); ?> </li> 
										<li><?php echo $this->Html->link('Wish List', array('action' => 'wishlist', 'controller' => 'signin')); ?> </li>
										<li><?php echo $this->Html->link('Logout', array('controller' => 'signin', 'action' => 'logout'), array('escape' => false, 'id' => 'login')); ?></li>
									<?php } ?>
								</ul>
							</li>
							<li>
								<a href="<?php echo BASE_URL.'signin/wishlist'; ?>" id="wishlist-total" title="Wish List (0)">
									<i class="fa fa-heart"></i>
									<span class="">Wish List (<?php echo $this->Session->check('User.wishlist_count')?$this->Session->read('User.wishlist_count'):0; ?>)</span>
								</a>
							</li>
							<li>
								<a href="#" id="wishlist-total" title="Gold Price">
									<i class="fa fa-money"></i>
									<span class="">Gold: <?php echo $this->Session->read("gold"); ?>(22 K)</span>
								</a>
							</li>
							<li>
								<a href="<?php echo BASE_URL."shoppingcarts/shopping_cart"; ?>" title="Checkout">
									<i class="fa fa-share"></i>
									<span class="">Checkout</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="container">
		<div class="row header-middle">
			<div class="left col-lg-4 col-md-4 col-sm-4 vertical-align">
				<div id="logo">
					<a href="<?php echo BASE_URL; ?>">
						<?php echo $this->Html->image('/img/frontendTheme/catalog/cheshgold_logo_new.png',array('title'=>'Cherish Gold','alt'=>'Cherish Gold','class'=>'img-responsive')); ?>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-8 vertical-align">
				<!--<div id="search" class="input-group">
					<button type="button" class="button-search"></button>
					<input type="text" name="search" value="" placeholder="Search" class="form-control" />
				</div>-->
			</div>
			<div class="right-side col-lg-4 col-md-4 col-sm-4 vertical-align">
				<div class="phone-no">
					<i class="fa fa-phone"></i>
					<span>1800 1022 066</span>
					<div></div>
				</div>
				<div class="birlaheaderText" style="text-align: right;">BIRLA GOLD AND PRECIOUS METALS LIMITED</div>
			</div>
		</div>
		<div class="container"></div>
	</div>
	
	<div class="header-bottom">
			<div class="container">
				<div id="bt_mainmenu">
					<div class="row">
						<div class="right-side col-lg-2 col-md-2 col-sm-3 col-xs-12 boss-right" >
							<div>
								<a href="<?php echo BASE_URL."shoppingcarts/shopping_cart"; ?>">
								<!-- <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn-dropdown-cart dropdown-toggle"> -->
								<?php echo $this->Html->image('/img/frontendTheme/catalog/shopping-cart-icon.png'); ?>
								<?php
									if ($this->Session->read('cart_process') != '') 
									{
										$cartcount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('cart_session' => $this->Session->read('cart_process')), 'fields' => array('SUM(quantity) AS tot_qty,SUM(total*quantity) AS tot_price')));
										
										if (!empty($cartcount)) 
										{
								?>
											<span id="cart-total"><?php echo $cartcount[0]['tot_qty']; ?> item(s) - Rs. <?php echo $cartcount[0]['tot_price']; ?></span>
								<?php
										}
										else
										{
								?>
											<span id="cart-total">0 item(s) - Rs. 0</span>
								<?php
										}
									}
									else
									{
								?>
										<span id="cart-total">0 item(s) - Rs. 0</span>
								<?php
									}
								?>
								
								<!-- </button> -->
								</a>
								<ul class="dropdown-menu pull-right">
									<li>
										<!--<p class="text-center">Your shopping cart is empty!</p>-->
									</li>
								</ul>
							</div>
						</div>
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
							
							// echo "<pre>";
							// print_r($menus);
						?>
			<div class="left small_logo col-sm-1 col-xs-2 boss-left">
				<div id="logo">
					<a href="<?php echo BASE_URL ?>">
						<img src="<?php echo BASE_URL ?>img/logo_small.png" title="Cherish Gold" alt="Cherish Gold" class="img-responsive" />
					</a>
				</div>
			</div>

						<div class="left col-lg-9 col-md-9 col-sm-9 col-xs-12 boss-left">
							<nav id="menu" class="navbar open-panel">
								<div class="navbar-header">
									<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
									<span id="category" class="visible-xs">Menu</span>
								</div>
							</nav>
							<nav class="mega-menu navbar-collapse navbar-ex1-collapse collapse">
								<a class="close-panel"><i class="fa fa-times-circle"></i></a>
								<ul class="nav nav-pills">
									<?php
										foreach ($menus as $key => $menu) 
										{
											// Exclusive Designs
											
											if ($menu['Menu']['menu_id'] == 10) 
											{
									?>
												<!-- Exclusive Designs -->
												<li class="parent">
													<p class="plus visible-xs">+</p>			
													<?php echo $this->Html->link($menu['Menu']['menu_name'], array('action' => 'jewellery', 'controller' => 'webpages')); ?>
													<div class="dropdown dropdown-menu drop-grid-6-6">
														<div class="menu-row row-col-6" >
															<div class="menu-column row-grid-6">
																<?php
																	if ($menu['Menu']['category_ids'] != '') 
																	{
																?>
																		<!-- html-->
																		<div class="staticblock">
																			<ul class="menuexclusive">
																				<?php
																					$ids = explode(',', $menu['Menu']['category_ids']);
																					$category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active', 'category_id' => $ids), 'order' => 'category_id ASC'));
																					
																					foreach ($category as $cateogies) 
																					{
																						$subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active'), array('limit' => 8)));
																						if (!empty($subcategory)) 
																						{
																				?>
																				<li>
																					<a href="#">
																						<div class="title_jew" id="<?php echo $cateogies['Category']['category']; ?>-title-jew"><?php echo $cateogies['Category']['category']; ?></div>
																					</a>
																					<ul id="<?php echo $cateogies['Category']['category']; ?>-text" class="<?php echo $cateogies['Category']['category']; ?>-text">
																						<li>
																							<div class="container">
																								<div class="row">
																									<div class="width-auto">
																							<?php
																								$i = 0;
																								foreach ($subcategory as $subcategory) 
																								{
																									$prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('subcategory_id' => $subcategory['Subcategory']['subcategory_id'], 'status' => 'Active', 'product_type' => 2)));
																									
																									if (!empty($prodcuts)) 
																									{
																										$image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
																										$product = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'])));
																										
																										$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
																										$product_code = $category['Category']['category_code'].$product['Product']['product_code'];
																										$productid = $product['Product']['product_id'];
																										
																										if(!empty($color))
																										{
																											$gcolor = $color;
																										}
																										else if(!empty($product['Product']['stone_color_id']))
																										{
																											
																											$colors = ClassRegistry::init('Color')->find('first', array('conditions' => array('color_id' => $product['Product']['stone_color_id'])));
																											$customid = $product['Product']['metal_purity']."K".$colors['Color']['clarity']."-".$colors['Color']['color'];
																											$gcolor = $product['Product']['metal_color'];
																											$product_code .= " - ".str_replace("-","",$customid);
																										}
																										else
																										{
																											$customid = '';
																											$gcolor = $product['Product']['metal_color'];
																										}
																										
																										//gold
																										$propurity = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
																										$material = explode("K", $customid);

																										$size_data = ClassRegistry::init('Size')->find('first', array('conditions' => array('goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active')));

																										if(!empty($size_data))
																										{
																											$size = 9;
																										}

																										if ($product['Product']['stone'] == 'Yes') 
																										{
																											$diamond = ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('product_id' => $productid)));
																											$this->set('diamonddetails', $diamond);
																										}
																										$gemstone_hdr = "";
																										if ($product['Product']['gemstone'] == 'Yes') 
																										{
																											$gemstone_hdr = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productid)));
																											$this->set('sgemstone', $gemstone_hdr);
																										}

																										if (!empty($size)) 
																										{
																											$product_wt = $product['Product']['metal_weight'];
																											if ($category['Category']['category'] != "Bangles") {
																												$t = '1';
																											} else {
																												$t = '0.125';
																											}

																											$minsize = ClassRegistry::init('Productmetal')->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
																											$minsizenew = $minsize[0]['minsizes'];
																											if ($size == $minsizenew) {
																												$add_wt = 0;
																											} else {
																												$nsize = ClassRegistry::init('Size')->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

																												$add_wt = $nsize[0]['tot_wt'];
																											}
																											$tot_weight = $product_wt + $add_wt;
																										} 
																										else 
																										{
																											$tot_weight = $product['Product']['metal_weight'];
																										}

																										if (!empty($gcolor)) {
																											$mcolor = ClassRegistry::init('Metalcolor')->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
																											//modified by prakash
																											$goldprice = ClassRegistry::init('Price')->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
																											// echo $goldprice['Price']['price'];
																											// exit;
																											$gprice = !empty($goldprice['Price']['price']) ? $goldprice['Price']['price'] : 0;

																											$gold_price = round(round($gprice * ($material[0] / 24)) * $tot_weight);
																										//            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
																											$purity = $material[0];
																											$making_charge = $product['Product']['making_charge'];
																										} else {
																											$gold_price = '0';
																											$making_charge = '0';
																											$purity = '';
																										}

																										//diamond
																										if (!empty($material[1])) {
																											list($clarity, $color) = explode("-", $material[1]);
																											$stone_price = '0';
																											$diamond_wt = '0';
																											$stone_details = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
																											$clarities = ClassRegistry::init('Clarity')->find('first', array('conditions' => array('clarity' => $clarity)));
																											$colors = ClassRegistry::init('Color')->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
																											$stoneprice = ClassRegistry::init('Price')->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
																											$stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight'], 0, PHP_ROUND_HALF_DOWN);
																											$diamond_wt = $stone_details['0']['sweight'] / 5;
																											$all_stone_details = ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

																										} else {
																											$clarity = $color = '';
																											$stone_price = '0';
																											$diamond_wt = '0';
																										}

																										//gemstone
																										if (!empty($gemstone_hdr)) {
																											$gemprice = 0;
																											$gemstone_wt = 0;
																											foreach ($gemstone_hdr as $gemstones) {
																												$stone = ClassRegistry::init('Gemstone')->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
																												$stone_shape = ClassRegistry::init('Shape')->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
																												$prices = ClassRegistry::init('Price')->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
																												$gemprice+=round($prices['Price']['price'] * $gemstones['Productgemstone']['stone_weight']);
																												$gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
																											}
																										} else {
																											$gemprice = '0';
																											$gemstone_wt = '';
																										}

																										$sub_total = $gold_price + $stone_price + $gemprice;
																										$making = 0;
																										//addded by prakash
																										if ($product['Product']['making_charge_calc'] == 'PER') {
																											$making = round($gold_price * ($making_charge / 100), 0, PHP_ROUND_HALF_DOWN);
																										} elseif ($product['Product']['making_charge_calc'] == 'INR') {
																											$making = $making_charge;
																										}
																										$making = floatval($making);
																										$vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100), 0, PHP_ROUND_HALF_DOWN);
																										$total = $sub_total + $making + $vat;
																							?>
																							
																									
																								<a href="<?php echo BASE_URL . $cateogies['Category']['link'] . '/' . $subcategory['Subcategory']['link'] . '/' . $prodcuts['Product']['product_id'] . '/' . $prodcuts['Product']['product_name']; ?>">
																									<div class="col-md-3">
																									<?php 
																										if (!empty($image['Productimage']['imagename'])) 
																										{ 
																											echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120'));
																										}
																										else
																										{
																											echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
																										}
																									?>
																									<?php echo strtoupper($prodcuts['Product']['product_name'])."<br/>Rs. ".$total; ?> 
																									
																									</div>
																								</a>
																							<?php
																									$i++;
																									if($i%4==0)
																									{
																							?>
																									<div class="dotted-spaced"></div>
																							<?php
																										}
																									}
																								}
																							?>
																								</div>
																								<div style="clear:both;">
																									<a href="<?php echo BASE_URL . 'details/'.$cateogies['Category']['link']; ?>">
																										<div class="col-md-10 view_all">VIEW ALL</div>
																									</a>
																								</div>
																							</div>
																						</div>
																						</li>
																					</ul>
																				</li>
																				<?php
																					}
																				}
																				?>
																			</ul>
																		</div>
																<?php
																	}
																?>
															</div>
														</div>
													</div>
												</li>
									<?php
											}
										
											// Jwellery
											
											if ($menu['Menu']['menu_id'] == 1) 
											{
									?>
												<!-- Jwellery Menu -->
												<li class="parent">
													<p class="plus visible-xs">+</p>			
													<?php echo $this->Html->link($menu['Menu']['menu_name'], array('action' => 'jewellery', 'controller' => 'webpages')); ?>
													<div class="dropdown dropdown-menu drop-grid-6-6">
														<div class="menu-row row-col-6" >
															<div class="menu-column row-grid-6">
																<?php
																	if ($menu['Menu']['category_ids'] != '') 
																	{
																?>
																		<!-- html-->
																		<div class="staticblock">
																			<ul class="menuexclusive">
																				<?php
																					$ids = explode(',', $menu['Menu']['category_ids']);
																					$category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active', 'category_id' => $ids), 'order' => 'category_id ASC'));
																					
																					foreach ($category as $cateogies) 
																					{
																				?>
																						<li>
																							<a href="#"><div class="title_jew" id="<?php echo $cateogies['Category']['category']; ?>-title-jew"><?php echo $cateogies['Category']['category']; ?></div></a>
																							<ul id="<?php echo $cateogies['Category']['category']; ?>-text" class="<?php echo $cateogies['Category']['category']; ?>-text">
																								<li>
																									<?php
																										$subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active'), array('limit' => 8)));
																										
																										if (!empty($subcategory)) 
																										{
																									?>
																											<div class="container">
																												<div class="row">
																													<div class="width-auto">
																									<?php
																													$i = 0;
																													foreach ($subcategory as $subcategory) 
																													{
																														$prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('subcategory_id' => $subcategory['Subcategory']['subcategory_id'], 'status' => 'Active', 'product_type' => 2)));
																														
																														if (!empty($prodcuts)) 
																														{
																															$image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
																									?>
																									
																											
																															<a href="<?php echo BASE_URL . $cateogies['Category']['link'] . '/' . $subcategory['Subcategory']['link']. '/type-diamond' ; ?>">
																																<div class="col-md-3">
																																<?php 
																																	if (!empty($image['Productimage']['imagename'])) 
																																	{ 
																																		echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120'));
																																	}
																																	else
																																	{
																																		echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
																																	}
																																?>
																																<?php echo strtoupper(str_replace("_"," ",$subcategory['Subcategory']['link'])); ?> </div>
																															</a>
																									<?php
																															$i++;
																															if($i%4==0)
																															{
																									?>
																																<div class="dotted-spaced"></div>
																									<?php
																															}
																														}
																													}
																									?>
																													</div>
																													<div style="clear:both;">
																														<a href="<?php echo BASE_URL . 'details/'.$cateogies['Category']['link']. '/type-diamond'; ?>">
																															<div class="col-md-10 view_all">VIEW ALL</div>

																														</a>
																													</div>
																												</div>
																											</div>
																									<?php
																										}
																									?>
																								</li>
																							</ul>
																						</li>
																				<?php
																					}
																				?>
																			</ul>
																		</div>
																<?php
																	}
																?>
															</div>
														</div>
													</div>
												</li>
									<?php		
											}
											
											// Solitaires
											
											if($menu['Menu']['menu_id'] == 3)
											{
									?>
												<li class="parent">
													<p class="plus visible-xs">+</p>			
													<a href="index98dc.html?route=product/category&amp;path=20"><?php echo $menu['Menu']['menu_name'] ?></a>
													<div class="dropdown dropdown-menu drop-grid-6-3">
														<div class="menu-row row-col-3" >
															<?php
																$submenu = $menu['Submenu'];
																$i = 0;
																foreach ($submenu as $subcategory) 
																{
															?>
																	<div class="menu-column row-grid-1">
																		<!-- category -->
																		<a href="#" class="parent">&nbsp;&nbsp;&nbsp;<?php echo  $subcategory['submenu_name']; ?>&nbsp;&nbsp;&nbsp;</a>
																		<ul class="column category menuexclusive">
																			<?php
																				$category = array(0=>1,1=>2,2=>8);
																				
																				if (!empty($category)) 
																				{
																					$subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $category[$i], 'status' => 'Active'), array('limit' => 8,'order'=>array('subcategory'=>'asc'))));
																					
																					foreach ($subcategory as $subcategory) 
																					{
																			?>
																						<li class="col-grid-1 ">
																							<a href=""> 
	    <div id="<?php echo $subcategory['Subcategory']['subcategory']."-title-jew"; ?>" class="title_jew">
																								<?php echo strtoupper(str_replace("_"," ",$subcategory['Subcategory']['subcategory'])); ?>
																							</div>					
        </a>
																						</li>
																			<?php
																					}
																				}
																			?>
																			<li>
																				<a href="index68ea.html?route=product/category&amp;path=33">
																					<div class="view_all_category">
																						VIEW ALL
																					</div>
																				</a>
																			</li> 
																		</ul>
																	</div>
																<?php
																		$i++;
																	}
																?>
														</div>
													</div>
												</li>
									<?php
											}
											
											// Gold Jwellery
											
											if ($menu['Menu']['menu_id'] == 9) 
											{
									?>
												<!-- Gold Jwellery Menu -->
												<li class="parent">
													<p class="plus visible-xs">+</p>			
													<?php echo $this->Html->link($menu['Menu']['menu_name'], array('action' => 'jewellery', 'controller' => 'webpages')); ?>
													<div class="dropdown dropdown-menu drop-grid-6-6">
														<div class="menu-row row-col-6" >
															<div class="menu-column row-grid-6">
																<?php
																	if ($menu['Menu']['category_ids'] != '') 
																	{
																?>
																		<!-- html-->
																		<div class="staticblock">
																			<ul class="menuexclusive">
																				<?php
																					$ids = explode(',', $menu['Menu']['category_ids']);
																					$category = ClassRegistry::init('Category')->find('all', array('conditions' => array('status' => 'Active', 'category_id' => $ids), 'order' => 'category_id ASC'));
																					
																					foreach ($category as $cateogies) 
																					{
																				?>
																						<li>
																							<a href="#"><div class="title_jew" id="<?php echo $cateogies['Category']['category']; ?>-title-jew"><?php echo $cateogies['Category']['category']; ?></div></a>
																							<ul id="<?php echo $cateogies['Category']['category']; ?>-text" class="<?php echo $cateogies['Category']['category']; ?>-text">
																								<li>
																									<?php
																										$subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $cateogies['Category']['category_id'], 'status' => 'Active'), array('limit' => 8)));
																										
																										if (!empty($subcategory)) 
																										{
																									?>
																											<div class="container">
																												<div class="row">
																													<div class="width_auto">
																									<?php
																													$i = 0;
																													foreach ($subcategory as $subcategory) 
																													{
																														$prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('subcategory_id' => $subcategory['Subcategory']['subcategory_id'], 'status' => 'Active', 'product_type' => 1)));
																														
																														
																														if (!empty($prodcuts)) 
																														{
																															$image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $prodcuts['Product']['product_id'], 'status' => 'Active')));
																									?>						
																											
																															<a href="<?php echo BASE_URL . $cateogies['Category']['link'] . '/' . $subcategory['Subcategory']['link']. '/type-gold'; ?>">
																																<div class="col-md-3">
																																<?php 
																																	if (!empty($image['Productimage']['imagename'])) 
																																	{ 
																																		echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '170px', 'height' => '120'));
																																	}
																																	else
																																	{
																																		echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
																																	}
																																?>
																																<?php echo strtoupper(str_replace("_"," ",$subcategory['Subcategory']['link'])); ?> </div>
																															</a>
																									<?php
																															$i++;
																															if($i%4==0)
																															{
																									?>
																																<div class="dotted-spaced"></div>
																									<?php
																															}
																														}
																													}
																									?>
																													</div>
																						<div style="clear:both;">
																														<a href="<?php echo BASE_URL.'details/'.$cateogies['Category']['link']. '/type-gold'; ?>">
																															<div class="col-md-10 view_all">VIEW ALL</div>
																														</a>
																													</div>
																												</div>
																											</div>
																									<?php
																										}
																									?>
																								</li>
																							</ul>
																						</li>
																				<?php
																					}
																				?>
																			</ul>
																		</div>
																<?php
																	}
																?>
															</div>
														</div>
													</div>
												</li>
									<?php
											}
											
											if ($menu['Menu']['menu_id'] == 2) 
											{
												$gold_category = ClassRegistry::init('Category')->find('first', array(
													'conditions' => array(
														'Category.category' => array('Gold Coins', 'Gold Coin')
												)));
												$gold_url = !empty($gold_category) ? BASE_URL . "details/" . $gold_category['Category']['link'] : '';
									?>
												<li class="parent">
													<p class="plus visible-xs">+</p>			
													<a href="<?php echo $gold_url ?>"><?php echo $menu['Menu']['menu_name'] ?></a>
													<div class="dropdown dropdown-menu drop-grid-6-4">
														<div class="menu-row row-col-4" >
															<div class="menu-column row-grid-1">
																<!-- category -->
																<a href="#" class="parent">
																	Gold By Purity								
																</a>
																<ul class="column category">
																	<li class="col-grid-1 ">
																		<a href="<?php echo BASE_URL . 'product?goldfineness=995' ?>">24K 995									
																		</a>
																	</li>
																	<li class="col-grid-1 ">
																		<a href="<?php echo BASE_URL . 'product?goldfineness=999' ?>">
																			24K 999										
																		</a>
																	</li> 
																</ul>
															</div>
															<div class="menu-column row-grid-1">
																<!-- category -->
																<a href="index4eb1.html?route=product/category&amp;path=65" class="parent">
																	Gold By Weight								
																</a>
																<ul class="column category">
																	<li class="col-grid-1 ">
																		<a href="<?php echo BASE_URL . 'product?weight=0.5' ?>">
																			0.5 gram										
																		</a>
																	</li>
																	<li class="col-grid-1 ">
																		<a href="<?php echo BASE_URL . 'product?weight=10' ?>">
																			10 gram										
																		</a>
																	</li>
																	<li class="col-grid-1 ">
																		<a href="<?php echo BASE_URL . 'product?weight=1' ?>">
																			1 gram									
																		</a>
																	</li>
																<li class="col-grid-1 ">
																	<a href="<?php echo BASE_URL . 'product?weight=20' ?>">
																		20 gram										
																		</a>
																</li>
																<li class="col-grid-1 ">
																<a href="<?php echo BASE_URL . 'product?weight=2' ?>">
																		2 gram	
																		</a>
																</li>
																<li class="col-grid-1 ">
																<a href="<?php echo BASE_URL . 'product?weight=5' ?>">
																5 gram										
																</a>
																</li>
																<li>
																<a href="index4eb1.html?route=product/category&amp;path=65">
																<div class="view_all_category">
																VIEW ALL											</div>
																</a>
																</li> 
																</ul>
																</div>	</div>
							</div>
						</li>
									<?php
											}
										}
									?>
	
									<!-- <li class="parent">
										<p class="plus visible-xs">+</p>
										<a href="#">OFFERS</a>
										<div class="dropdown dropdown-menu drop-grid-6-1">
											<div class="menu-row row-col-1" >
												<div class="menu-column row-grid-1">
													<a href="index3dd5.html?route=product/category&amp;path=175" class="parent">Offers &amp; Discounts
													</a>
													<ul class="column category">
														<li class="col-grid-1 ">
															<a href="indexd03e.html?route=product/category&amp;path=176">27% Discount									</a>
														</li>
														<li class="col-grid-1 ">
															<a href="indexba55.html?route=product/category&amp;path=178">Diamond Offer									</a>
														</li>
														<li class="col-grid-1 ">
															<a href="indexe930.html?route=product/category&amp;path=177">Flat 10% off									</a>
														</li>
														<li>
															<a href="index3dd5.html?route=product/category&amp;path=175">
																<div class="view_all_category">VIEW ALL</div>
															</a>
														</li> 
													</ul>
												</div>
											</div>
										</div>
									</li> -->
									<li class="parent">
									<p class="plus visible-xs">+</p>			
									<a href="#">PLAN</a>
									<div class="dropdown dropdown-menu drop-grid-6-2" style="margin-left: 0px; width: 204px;height:100px;">
									<div class="menu-row row-col-2">
									<div class="menu-column row-grid-2">
									<div class="staticblock">
										<ul class="menuexclusive" style="padding:0 ">
											<?php if($this->Session->read('User.bgp_plan') == "yes") { ?>
											<li><a href="<?php echo BASE_URL; ?>customer/dashboard"><div class="title_jew" style="width: 190px;">Dashboard</div></a></li>
											<?php } 
											else 
											{ ?>
											<li><a href="<?php echo BASE_URL; ?>bgp-plan/registration"><div class="title_jew" style="width: 190px;">Buy Plan</div></a></li>
											<?php } ?>
										</ul>
									</div>
									</div>
									</div>
									</div>
									<!--
									<div class="dropdown dropdown-menu drop-grid-6-2" style="margin-left: 0px; width: 204px;">
									<div class="menu-row row-col-2">
									<div class="menu-column row-grid-2">
									<div class="staticblock">
									<ul class="menuexclusive" style="padding:0 ">
									<li><a href="">
									<div class="title_jew" style="width: 190px;">LOGIN</div></a>
									<ul style="top: 12px; padding: 10P; left: 204px;">
									<a href="<?php echo BASE_URL; ?>/staging/birla/customer/login"><li style="padding: 10px; text-align: left;">Customer</li></a>
									<a href="<?php echo BASE_URL; ?>/staging/birla/distributor/login"><li style="padding: 10px; text-align: left;">Distributor</li></a>
									</ul>

									</li>
									<li><a href="http://cherishgold.com/cherishgold_new/staging/birla/customer/registration"><div class="title_jew">BUY PLAN</div></a> </li>
									<li><a href="<?php echo BASE_URL; ?>bgp-plan/registration"><div class="title_jew">BUY PLAN</div></a> </li>
									<li><a href="<?php echo BASE_URL; ?>bgp-plan/dashboard"><div class="title_jew">Dashboard</div></a> </li>
									<li><a href="#" target=""><div class="title_jew">ABOUT BGP</div></a></li>
									<li><a href="<?php echo BASE_URL; ?>staging/birla/distributor/login"><div class="title_jew">DISTRIBUTOR SERVICE AREA</div></a> </li>
									<li><a href="<?php echo BASE_URL; ?>staging/birla/downloadforms" target=""><div class="title_jew">FORM DOWNLOADS</div></a></li>
									<li><a href="#"><div class="title_jew">GOT A QUERY</div></a></li>		
									<li><a href="#"><div class="title_jew">ADDITIONAL PURCHASE</div></a></li> 
									</ul>	
									</div>			
									<p><a href="http://cherishgold.com/birla/page?id=c3ViX21lbnUxX2lkPTE4Jm1haW5fbWVudV9pZD01JnN1Yl9tZW51Ml9pZD0" target="">Gold Coin Sample Image </a></p>
									<p><a href="http://cherishgold.com/birla/page?id=c3ViX21lbnUxX2lkPTE5Jm1haW5fbWVudV9pZD01JnN1Yl9tZW51Ml9pZD0" target="">Terms And C</a>ondiotions</p> 
									<p><a href="http://cherishgold.com/birla/faq" target="">Faq\'s </a></p> 
									<p style="font-size: 13.2px; line-height: 18.8571px;"><a href="http://cherishgold.com/birla/customer/login">My Account</a></p> 
									<p style="font-size: 13.2px; line-height: 18.8571px;">Jewellery Range</p> 
									<p style="font-size: 13.2px; line-height: 18.8571px;"><a href="http://cherishgold.com/birla/customer/addpurches" target="">Additional Purchase Option</a></p>
									<p style="font-size: 13.2px; line-height: 18.8571px;"><a href="http://cherishgold.com/birla/customer/maturityadvice" target="">Maturity Advice</a></p> 
									<p style="font-size: 13.2px; line-height: 18.8571px;"><a href="http://cherishgold.com/birla/customer/taxinvoice" target="">Tax Invoice</a></p> 
									<p style="font-size: 13.2px; line-height: 18.8571px;"><a href="http://cherishgold.com/birla/trackshipment" target="">Track Your Shipment</a></p></div> 
									</div></div>
									</div>
									-->
									</li>
								</ul>
							</nav>
							<style>
							.bt-menu-bg img{
							position: absolute;
							bottom: 0;
							left: 0;
							z-index: -1;
							max-width: none;
							}
							.menuexclusive-active{
							display: block!important;
							}
							</style>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#Rings').addClass('menuexclusive-active');
									$('.menuexclusive').hover(function(){
										$('.Rings-text').removeClass('menuexclusive-active');
									}, function(){ 
										$('.Rings-text').addClass('menuexclusive-active');
										$('#Rings-title').css('color','#505050');
								
									});
								
									 $('.Rings-text').addClass('menuexclusive-active');
									
								});
							</script>
							</div>
							</div>
						</div>
						<!-- End bt_mainmenu -->
					</div>
				</div>

</div> <!-- End #bt_header -->

