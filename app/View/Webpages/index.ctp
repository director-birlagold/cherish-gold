<!-- Banner start -->
<?php
	if(!empty($banner))
	{
?>
		<div class="header_slider">
			<article >
				<div class="tp-banner-container">
					<div class="tp-banner tp-banner0" >
						<ul>
<?php
							foreach($banner as $banners) 
							{ 
								if(!empty($banners))
								{
									if($banners['Banner']['image'] != NULL)
									{
?>
										<li  data-link="<?php echo $banners['Banner']['link'];?>" data-target="_self"  data-transition="curtain-2" data-slotamount="7" data-masterspeed="500"  data-saveperformance="on">
										<!-- MAIN IMAGE -->
											<?php echo $this->Html->image('banner/'.$banners['Banner']['image'],array("alt" => "Banner")); ?>
										</li>
<?php
									}
								}
							}
?>
						</ul>
					</div>
				</div>
			</article>
		</div>
<?php
	}
?>
<script type="text/javascript"><!--
jQuery(document).ready(function() {		
	jQuery('.tp-banner0').show().revolution({
		dottedOverlay:"none",
		delay:3000,
		startWithSlide:0,
		startwidth:1920,
		startheight:650,
		hideThumbs:0,
		hideTimerBar:"on",
		
		thumbWidth:0,
		thumbHeight:0,
		thumbAmount:0,
		
		navigationType:"bullet",
		navigationArrows:"nexttobullets",
		navigationStyle:"preview1", 
		
		touchenabled:"on",
		onHoverStop:"on",
		
		swipe_velocity: 0.7,
		swipe_min_touches: 1,
		swipe_max_touches: 1,
		drag_block_vertical: false,
								
		parallax:"mouse",
		parallaxBgFreeze:"on",
		parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
								
		keyboardNavigation:"off",
		
		navigationHAlign:"center",
		navigationVAlign:"bottom",
		navigationHOffset:0,
		navigationVOffset:0,

		soloArrowLeftHalign:"left",
		soloArrowLeftValign:"top",
		soloArrowLeftHOffset:0,
		soloArrowLeftVOffset:0,

		soloArrowRightHalign:"left",
		soloArrowRightValign:"top",
		soloArrowRightHOffset:0,
		soloArrowRightVOffset:0,
				
		shadow:0,
		fullWidth:"on",
		fullScreen:"off",

		spinner:"spinner4",
		
		stopLoop:"on",
		stopAfterLoops:-1,
		stopAtSlide:-1,

		shuffle:"off",
		
		autoHeight:"off",						
		forceFullWidth:"off",						
								
								
								
		hideThumbsOnMobile:"off",
		hideNavDelayOnMobile:1500,						
		hideBulletsOnMobile:"off",
		hideArrowsOnMobile:"off",
		hideThumbsUnderResolution:0,
		
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		videoJsPath:"rs-plugin/videojs/",
		fullScreenOffsetContainer: ""	
	});				
});	//ready

//--></script>

<!-- Banner End -->

<!-- Corousel satrt -->

<?php
	$collection_type_ech=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(1,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name1=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'1')));
   
    $collection_type_sap=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(2,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name2=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'2')));
	
    $collection_type_emr=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(3,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name3=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'3')));
	
    $collection_type_bel=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(4,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name4=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'4')));
	
    $collection_type_ship=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(5,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name5=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'5')));
    
    if(!empty($collection_type_bel) || !empty($collection_type_ech) || !empty($collection_type_emr) || !empty($collection_type_sap) || !empty($collection_type_ship))
	{
?>

		<style type="text/css">
			.carousel-content li{
				border: 0px;
                                background:#fff;
                                margin: 10px;
                                height: inherit
                               
			}
			#boss_carousel0 img{
				margin: 0 auto;
			}
			.our-catalogue{
				color: black;
				opacity: 1; text-align:right;
				text-indent: 40px;
				font-weight: 600; height:142px;border-right: 1px solid black;
				padding-right: 10px;
				font-size: 14px;
				width: 100px;
			}
			.our-catalogue div{
				padding-right: 10px;
				margin-top: 45px;
			}
		</style>

		<div class="" style=" margin: 0 auto; height: auto;">
			<!-- <div class="row"> -->
			<div style="margin: 0 auto; height: auto; overflow: auto; background-color: #F3F3F3; padding-bottom: 10px;    padding-top: 5px;">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-md-10" style="margin:auto; float:none;"></div>
					<div class="col-md-12">
						<div id="carousel0" class="boss-carousel not-animated" data-animate="fadeInUp" data-delay="300" style="">
							<section class="box-content">
								<ul id="boss_carousel0" class="carousel-content">
									<?php 
										if(!empty($collection_type_ech))
										{
											$collection_type_ech_img=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$collection_type_ech['Product']['product_id'])));
									?>
											<li>
												<a href="<?php echo BASE_URL;?>product?collection=<?php echo str_replace(' ','_',strtolower(trim($collectiontype_val_name1['Collectiontype']['collection_name'])));?>">
													<div style="padding: 10px; color: black; text-transform: capitalize;"><?php echo $collectiontype_val_name1['Collectiontype']['collection_name']?></div>
													<img class="img-responsive" src="<?php echo  BASE_URL; ?>img/product/small/<?php echo $collection_type_ech_img['Productimage']['imagename']?>" alt="<?php echo $collectiontype_val_name1['Collectiontype']['collection_name']?>" title="<?php echo $collectiontype_val_name1['Collectiontype']['collection_name']?>" />
												</a>

											</li>
									<?php
										}
									?>
									
									<?php 
										if(!empty($collection_type_sap))
										{
											$collection_type_sap_img=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$collection_type_sap['Product']['product_id']))); 
									?>
											<li>
												<a href="<?php echo BASE_URL;?>product?collection=<?php echo str_replace(' ','_',strtolower(trim($collectiontype_val_name2['Collectiontype']['collection_name'])));?>">
													<div style="padding: 10px; color: black; text-transform: capitalize;"><?php echo $collectiontype_val_name2['Collectiontype']['collection_name']?></div>
													<img class="img-responsive" src="<?php echo  BASE_URL; ?>img/product/small/<?php echo $collection_type_sap_img['Productimage']['imagename']?>" alt="<?php echo $collectiontype_val_name2['Collectiontype']['collection_name']?>" title="<?php echo $collectiontype_val_name2['Collectiontype']['collection_name']?>" />    
												</a>
											</li>
									<?php
										}
									?>
									
									<?php 
										if(!empty($collection_type_emr))
										{
											$collection_type_emr_img=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$collection_type_emr['Product']['product_id'])));
									?>
											<li>
												<a href="<?php echo BASE_URL;?>product?collection=<?php echo str_replace(' ','_',strtolower(trim($collectiontype_val_name3['Collectiontype']['collection_name'])));?>">
													<div style="padding: 10px; color: black; text-transform: capitalize;"><?php echo $collectiontype_val_name3['Collectiontype']['collection_name']?></div>
													<img class="img-responsive" src="<?php echo  BASE_URL; ?>img/product/small/<?php echo $collection_type_emr_img['Productimage']['imagename']?>" alt="<?php echo $collectiontype_val_name3['Collectiontype']['collection_name']?>" title="<?php echo $collectiontype_val_name3['Collectiontype']['collection_name']?>" />    
												</a>
											</li>
									<?php
										}
									?>
									
									<?php 
										if(!empty($collection_type_bel))
										{
											$collection_type_bel_img=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$collection_type_bel['Product']['product_id'])));
									?>
											<li>
												<a href="<?php echo BASE_URL;?>product?collection=<?php echo str_replace(' ','_',strtolower(trim($collectiontype_val_name4['Collectiontype']['collection_name'])));?>">
													<div style="padding: 10px; color: black; text-transform: capitalize;"><?php echo $collectiontype_val_name4['Collectiontype']['collection_name']?></div>
													<img class="img-responsive" src="<?php echo  BASE_URL; ?>img/product/small/<?php echo $collection_type_bel_img['Productimage']['imagename']?>" alt="<?php echo $collectiontype_val_name4['Collectiontype']['collection_name']?>" title="<?php echo $collectiontype_val_name4['Collectiontype']['collection_name']?>" />    
												</a>
											</li>
									<?php
										}
									?>
									
									<?php 
										if(!empty($collection_type_ship))
										{
											$collection_type_ship_img=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$collection_type_ship['Product']['product_id'])));
									?>
											<li>
												<a href="<?php echo BASE_URL;?>product?collection=<?php echo str_replace(' ','_',strtolower(trim($collectiontype_val_name5['Collectiontype']['collection_name'])));?>">
													<div style="padding: 10px; color: black; text-transform: capitalize;"><?php echo $collectiontype_val_name5['Collectiontype']['collection_name']?></div>
													<img class="img-responsive" src="<?php echo  BASE_URL; ?>img/product/small/<?php echo $collection_type_ship_img['Productimage']['imagename']?>" alt="<?php echo $collectiontype_val_name5['Collectiontype']['collection_name']?>" title="<?php echo $collectiontype_val_name5['Collectiontype']['collection_name']?>" />    
												</a>
											</li>
									<?php
										}
									?>
								</ul>

								<a id="carousel_next0" class="btn-nav-center prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
								<a id="carousel_prev0" class="btn-nav-center next nav_thumb" href="javascript:void(0)" title="next">Next</a>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript"><!--

		$(window).load(function(){

			$('#boss_carousel0').carouFredSel({

				auto: true,

				responsive: true,

				width: '100%',

				prev: '#carousel_next0',

				next: '#carousel_prev0',

				swipe: {

				onTouch : true

				},

				items: {

					width: 200,

					height: 'auto',

					visible: {

					min: 1,

					max: 4

					}

				},

				scroll: {

					direction : 'left',    //  The direction of the transition.

					duration  : 1000   //  The duration of the transition.

				}

			});

		});

		//--></script>
<?php
	}
?>

<!-- Corousel end -->

<!-- Advertizement Start -->
	<div class="container">
		<div class="row" style="margin-top:20px;">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<?php
					$image1=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>1,'status'=>'Active')));
					$imagedel1=ClassRegistry::init('Advertisementdetails')->find('first',array('conditions'=>array('ads_id'=>1,'status'=>'Active')));
					$images=$imagedel1['Advertisementdetails']['values'];
					$imagedel2=ClassRegistry::init('Advertisementdetails')->find('all',array('conditions'=>array('ads_id'=>1,'status'=>'Active')));
					$img=array();	
				?>
				
				<?php 
					if(!empty($image1)) 
					{ 
				?>
						<div class="col-lg-6 col-sm-6 col-md-6" style="padding:4px">
							<a href="#">
								<img src="<?php echo BASE_URL; ?>img/advertisement/big/<?php echo $images;?>" style="" class="img-responsive">
							</a>
						</div>
				<?php 
					} 
				?>
				
				<?php
					$image2=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>2,'status'=>'Active')));
					$imagedel1=ClassRegistry::init('Advertisementdetails')->find('first',array('conditions'=>array('ads_id'=>2,'status'=>'Active')));
					$images=$image2['Advertisement']['images'];
				?>
				
				<?php 
					if(!empty($image2)) 
					{ 
				?>
						<div class="col-lg-6 col-sm-6 col-md-6" style="padding:4px">
							<a href="<?php echo $imagedel1['Advertisementdetails']['values'];?>" target="_blank"><img src="<?php echo $this->webroot; ?>img/advertisement/<?php echo $images;?>" style="" class="img-responsive">
							</a>
						</div>
				<?php 
					} 
				?>
				
				<?php
					$image3=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>3,'status'=>'Active')));
					$imgsome=$image3['Advertisement']['images'];
					$imagedel1=ClassRegistry::init('Advertisementdetails')->find('all',array('conditions'=>array('ads_id'=>3,'status'=>'Active'),'order'=>'advertisement_id ASC'));
				?>
				
				<?php 
					if(!empty($image3)) 
					{ 
				?>
						<div class="col-lg-6 col-sm-6 col-md-6" style="padding:4px">
							<a href="#">
								<img src="<?php echo $this->webroot; ?>img/advertisement/<?php echo $imgsome;?>" style="" class="img-responsive">
							</a>
						</div>
				<?php
					}
				?>
				
				<?php
					$image4=ClassRegistry::init('Advertisement')->find('first',array('conditions'=>array('ads_id'=>4,'status'=>'Active')));
					$imdg=$image4['Advertisement']['images'];
				?>
				
				<?php 
					if($image4) 
					{ 
				?>
						<div class="col-lg-6 col-sm-6 col-md-6" style="padding:4px">
							<a href="<?php echo BASE_URL?>webpages/jewellery_requestform">
								<img src="<?php echo $this->webroot; ?>img/advertisement/<?php echo $imdg;?>" class="img-responsive" style="">
							</a>
						</div>
				<?php
					}
				?>

			</div>

		</div>

	</div>
<!-- Advertizement End -->

<!-- Popular Selling Start -->
	<style type="text/css">

		.box-content-category{
				padding: 20px;
				border: 1px solid #D2CECE;
				border-right: 0px;
				height: 310px;
				margin: 20px 0;
		}
		.box-content-category:last-child{
				border-right: 1px;
				border: 1px solid #D2CECE;
				padding-bottom: 1px;
		}

	</style>
	
	<?php
		$earing_prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => '2', 'status' => 'Active')));
		if (!empty($earing_prodcuts)) 
		{
			$earing_image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $earing_prodcuts['Product']['product_id'], 'status' => 'Active')));
			$earing_category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $earing_prodcuts['Product']['category_id'], 'status' => 'Active')));
			$earing_subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $earing_prodcuts['Product']['subcategory_id'], 'status' => 'Active')));
			
		}
	?>	
	
	<div class="container">
		<div class="row" style="margin-left:0px; margin-right:0px">
			<div class="col-xs-12 col-sm-12 col-md-12 not-animated" data-animate="fadeInUp" data-delay="300">
				<div class="popular-cate">																																																														
					<div class="row">
						<div class="box-content box-content-category col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="cate-image">
								<a title="Earrings" href="<?php echo BASE_URL . $earing_category['Category']['link'] . '/' . $earing_subcategory['Subcategory']['link'] . '/' . $earing_prodcuts['Product']['product_id'] . '/' . $earing_prodcuts['Product']['product_name']; ?>">
								<?php 
									if (!empty($earing_image['Productimage']['imagename'])) 
									{ 
										echo $this->Html->image('product/home/' . $earing_image['Productimage']['imagename'], array('border' => 0,'style'=>'width:87%'));
									}
									else
									{
										echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
									}
								?>
								</a>
							</div>
							<div class="cate-name">
								<h3>Earrings</h3>
							</div>
							<!-- <div class="sub_cat"><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_85">Bridal</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_153">Casual Earrings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_84">Fancy</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_80">Hoops and Huggies</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_83">Jhumka</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_82">Office Wear</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_113">Studs</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_79">Studs Plain</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=20_81">Studs with stone</a></div></div> -->
						</div>
						<?php
							$necklace_prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => '6', 'status' => 'Active'),'order'=>'product_id desc'));
							if (!empty($necklace_prodcuts)) 
							{
								$necklace_image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $necklace_prodcuts['Product']['product_id'], 'imagename != ' => '','status' => 'Active')));
								$necklace_category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $necklace_prodcuts['Product']['category_id'], 'status' => 'Active')));
								$necklace_subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $necklace_prodcuts['Product']['subcategory_id'], 'status' => 'Active')));
							}
						?>
						<div class="box-content box-content-category col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="cate-image">
								<a title="Earrings" href="<?php echo BASE_URL . $necklace_category['Category']['link'] . '/' . $necklace_subcategory['Subcategory']['link'] . '/' . $necklace_prodcuts['Product']['product_id'] . '/' . $necklace_prodcuts['Product']['product_name']; ?>">
								<?php 
									if (!empty($necklace_image['Productimage']['imagename'])) 
									{ 
										echo "<img src='".BASE_URL."img/product/home/".$necklace_image['Productimage']['imagename']."' style='width:87%'/>";
									}
									else
									{
										echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
									}
								?>
							</a></div>
							<div class="cate-name">
								<h3>Necklace Set</h3>
							</div>
							<!-- <div class="sub_cat"><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=24_165">Casting Set</a></div></div> -->
						</div>
						<?php
							$rings_prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => '1', 'status' => 'Active')));
							
							if (!empty($rings_prodcuts)) 
							{
								$rings_image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $rings_prodcuts['Product']['product_id'], 'imagename != ' => '','status' => 'Active')));
								$rings_category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $rings_prodcuts['Product']['category_id'], 'status' => 'Active')));
								$rings_subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => '1', 'status' => 'Active')));
								
							}
						?>
						<div class="box-content box-content-category col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="cate-image">
								<a title="Earrings" href="<?php echo BASE_URL . $rings_category['Category']['link'] . '/' . $rings_subcategory['Subcategory']['link'] . '/' . $rings_prodcuts['Product']['product_id'] . '/' . $rings_prodcuts['Product']['product_name']; ?>">
								<?php 
									if (!empty($rings_image['Productimage']['imagename'])) 
									{ 
										echo $this->Html->image('product/home/' . $rings_image['Productimage']['imagename'], array('border' => 0,'style'=>'width:87%'));
									}
									else
									{
										echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
									}
								?>
							</a></div>
							<div class="cate-name">
								<h3>Rings</h3>
							</div>
							<!-- <div class="sub_cat"><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_73">Alphabet</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_77">Bridal</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_71">Casual</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_70">Casual Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_72">Cocktail</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_111">Cocktail Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_149">Couple Ring</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_139">Designer Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_124">Engagement Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_74">Gemstone Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_150">Kids Ring</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_78">Men</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_112">Office Wear Rings</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_75">Religious</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_128">Rings for Her</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=33_76">Solitaires Ring</a></div></div> -->
						</div>
						<?php
							$pendant_prodcuts = ClassRegistry::init('Product')->find('first', array('conditions' => array('category_id' => '8', 'status' => 'Active')));
							
							if (!empty($pendant_prodcuts)) 
							{
								$pendant_image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $pendant_prodcuts['Product']['product_id'], 'imagename != ' => '','status' => 'Active')));
								$pendant_category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $pendant_prodcuts['Product']['category_id'], 'status' => 'Active')));
								$pendant_subcategory = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $pendant_prodcuts['Product']['subcategory_id'], 'status' => 'Active')));
							}
						?>
						<div class="box-content box-content-category col-lg-3 col-md-3 col-sm-3 col-xs-12" style="border-right: 1px;border: 1px solid #D2CECE;padding-bottom: 1px;">
							<div class="cate-image">
								<a title="Earrings" href="<?php echo BASE_URL . $pendant_category['Category']['link'] . '/' . $pendant_subcategory['Subcategory']['link'] . '/' . $pendant_prodcuts['Product']['product_id'] . '/' . $pendant_prodcuts['Product']['product_name']; ?>">
								<?php 
									if (!empty($pendant_image['Productimage']['imagename'])) 
									{ 
										echo $this->Html->image('product/home/' . $pendant_image['Productimage']['imagename'], array('border' => 0,'style'=>'width:87%'));
									}
									else
									{
										echo $this->Html->image('no-image.jpg', array('border' => 0, 'width' => '170px', 'height' => '120'));
									}
								?>
							</a></div>
							<div class="cate-name">
								<h3>Pendant</h3>
							</div>
							<!-- <div class="sub_cat"><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_126">A Touch of Tradition</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_106">Bridal</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_105">Casual</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_104">Daily Wear</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_108">Ethnic</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_107">Fancy</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_129">Fancy Set</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_151">Kids Pendant</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_103">Light for your life</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_110">Men</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_102">Office wear</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_109">Party Wear</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_101">Religious</a></div><div class="sub_item"><a title="" href="http://demo.cherishgold.com/cherishgold_bkp/index.php?route=product/category&amp;path=34_127">Twist and Spiral</a></div></div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Popular Selling End -->

<!-- Shop By Shape Start -->
	<?php
		if(!empty($shopping_assistance))
		{
	?>
			<div id="shopping-assist"  class="main-bg" style="height:500px;padding-top:50px;background-image: url(<?php echo $this->webroot; ?>img/Banner--1.1.png);background-size: 1600px 432px;"><div class="container"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200">
						<div style="text-align:center;">
<div class="uppercaseheading" style=" color: rgb(255, 255, 255)">SHOPPING ASSISTANT</div>
							<!-- <p class="title font_global" style="font-size: 24px; color: rgb(255, 255, 255)" >SHOPPING ASSISTANT</p> -->

							<p style="color: rgb(255, 255, 255); font-size: 14px">Jewellery design for every face by Cherishgold</p>
							<div class="block-feature-detail not-animated" data-animate="fadeInUp" data-delay="400">
								<?php
									foreach($shopping_assistance as $assistance)
									{
								?>
										<div class="feature feature-1 col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding-bottom: 10px;">
											<a class="image" href="<?php echo BASE_URL.'details/'.str_replace(' ','_',strtolower($assistance['ShoppingAssistance']['title'])); ?>" title="" style="font-size:14px;line-height:1.5;text-align:justify; color: rgb(255, 255, 255)">
												<img src="<?php echo BASE_URL; ?>img/shoppingAssistance/<?php echo $assistance['ShoppingAssistance']['image']; ?>"><br/><br/>
												<div class="uppercaseheadin"><span><?php echo $assistance['ShoppingAssistance']['title']; ?></span></div>
											</a>
											<br/><br/>
											<p class="box_tex_div_shopping" style="font-size:14px;line-height:1.5;text-align:justify; color: rgb(255, 255, 255)">
												<?php echo substr($assistance['ShoppingAssistance']['description'],0,117). '...'; ?>
												<br>
											</p>
											<a href="<?php echo BASE_URL.'details/'.str_replace(' ','_',strtolower($assistance['ShoppingAssistance']['title'])); ?>" target="" class="explore_buuton btn">Explore</a>
										</div>
								<?php
									}
								?>
								<br>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php
		}
	?>
		
	</div>
</div>
</div>
<!-- Shop By Shape End -->
	
<!-- New Arrival start -->
	<?php
		$new_arrival=ClassRegistry::init('Product')->find('all', array('conditions' => array('status' =>'Active'),'order'=>'product_id DESC','limit'=>12));
		$bestsells=ClassRegistry::init('Product')->find('all',array('conditions'=>array('status'=>'Active','best_seller'=>'1'),'order'=>'product_id DESC','limit'=>12));
		$popular = ClassRegistry::init('Product')->find('all',array('conditions'=>array('status'=>'Active','popular'=>'1'),'order'=>'product_id DESC','limit'=>12));
	?>
		
	<div class="container">
		<script type="text/javascript">
			$(window).load(function() 
			{
				initCarousel(1, 0, 1, 4, 250);
			});

			jQuery(document).ready(function($) 
			{
				$("a.head_tabs0").click(function() 
				{
					if (!$(this).parent().hasClass('active')) 
					{
						$(".head_tabs0").parent().removeClass("active");
						var $src_tab = $(this).attr("data-src");
						$($src_tab).parent().addClass("active");
						$(".content_tabs0").hide();
						var $selected_tab = $(this).attr("href");
						$($selected_tab).fadeIn();
						var $selected_carousel = $(this).attr("data-crs");

						if ($selected_carousel != "") 
						{
							execCarousel($selected_carousel, 4, 250);
						}
					}

					return false;
				});

				$(window).resize(function() 
				{

				});
			});
		</script>

		<div id="boss_homefilter_tabs0" class="boss_homefilter_tabs" style="">
			<div id="tabs_container0" class="hide-on-mobile tabs_container not-animated" data-animate="fadeInUp" data-delay="300">
				<ul id="tabs0" class="tabs-headings tabs" style="margin-bottom: 0">
					<li class="active">
						<a class="head_tab00 head_tabs0" href="#content_tab00" data-src=".head_tab00" data-crs="#carousel_tab00">New Arrival</a>
					</li>
					<li>
						<a class="head_tab10 head_tabs0" href="#content_tab10" data-src=".head_tab10" data-crs="#carousel_tab10">Best Sellers</a>
					</li>
					<li>
						<a class="head_tab11 head_tabs0" href="#content_tab11" data-src=".head_tab11" data-crs="#carousel_tab11">Popular</a>
					</li>
				</ul>
			</div>
			<div id="tabs_content_container0" class="home_filter_content tabs_content_container">
				<div class="box-content not-animated" data-animate="fadeInUp" data-delay="300">
					<h3 class="active hide-on-desktop">
						<a class="head_tab00 head_tabs0" href="#content_tab00" data-src=".head_tab00" data-crs="#carousel_tab00">New Arrival</a>
					</h3>
					<div id="content_tab00" class="content_tabs0 list_carousel responsive" style="display:block">
						<ul id="carousel_tab_product_8" class="box-product">
							<?php 
								foreach($new_arrival as $images) 
								{	 
									$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id'=>$images['Product']['category_id'])));
									
									if(!empty($images['Product']['subcategory_id']))
									{	 
										$subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$images['Product']['subcategory_id'])));
										$subcat=str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']));
									}
									else
									{
										$subcat='all_items';
									}
									
									$productimage=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$images['Product']['product_id'])));
									$Product_product_name=str_replace(" ","_",trim($images['Product']['product_name']));
									
									$product = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $images['Product']['product_id'])));
																															
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
										$customid = $product['Product']['metal_purity']."K";
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

									if ($product['Product']['gemstone'] == 'Yes') 
									{
										$gemstone = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productid)));
										$this->set('sgemstone', $gemstone);
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
										$goldprice = ClassRegistry::init('Price')->find('first', array('conditions' => array('metalcolor_id' => '2', 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
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
									if (!empty($gemstone)) {
										$gemprice = 0;
										$gemstone_wt = 0;
										foreach ($gemstone as $gemstones) {
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
									
									
									if(isset($productimage['Productimage']['imagename']))
									{ 
							?>
										<li>
											<div class="product-thumb product-border">
												<div class="image">
													<a data-id="2444" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$images['Product']['product_id']."/".$Product_product_name;?>">
														<img src="<?php echo BASE_URL.'img/product/small/'.$productimage['Productimage']['imagename']; ?>" alt="<?php echo $images['Product']['product_name']; ?>" title="<?php echo $images['Product']['product_name']; ?>"/>
													</a>
												</div>
												<div>
													<div class="caption">
														<div class="name">
															<a class="boss-name" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$images['Product']['product_id']."/".$Product_product_name;?>"><?php echo $images['Product']['product_name']; ?></a>
														</div>
														<div class="price">
															Rs. <?php echo indian_number_format($total); ?>
														</div>
													</div>
													<!--<div class="cart">
														<a class="btn btn-primary" title="Add to Cart" onclick="btadd.cart('2444','1');"><span>Add to Cart</span></a>
													</div>
													<div class="btn-action-group">
														<a class="btn-action btn-wishlist" title="Add to Wish List" onclick="boss_addToWishList('2444');"><span>Add to Wish List</span></a>
													</div>-->
												</div>
											</div>
										</li>
							<?php
									}
								}
							?>
						</ul>
						<div class="clearfix"></div>
						<!-- <a id="prev_tab00" class="btn-nav-center prev nav_thumb" href="javascript:void(0)"><i class="fa fa-angle-left"></i></a> -->
						<!-- <a id="next_tab00" class="btn-nav-center next nav_thumb" href="javascript:void(0)"><i class="fa fa-angle-right"></i></a> -->
					</div>
					<h3 class=" hide-on-desktop"><a class="head_tab10 head_tabs0" href="#content_tab10" data-src=".head_tab10" data-crs="#carousel_tab10">Best Sellers</a></h3>
					<div id="content_tab10" class="content_tabs0 list_carousel responsive" style="display:none">
						<!-- <ul id="carousel_tab10" data-prev="#prev_tab10" data-next="#next_tab10" class="box-product"> -->
						<ul id="carousel_tab_product_8" class="box-product">
							<?php  
								foreach($bestsells as $bestsellproduct) 
								{
									$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id'=>$bestsellproduct['Product']['category_id'])));
									if(!empty($bestsellproduct['Product']['subcategory_id']))
									{	 
										$subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$bestsellproduct['Product']['subcategory_id'])));
										$subcat=str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']));
									}
									else
									{
										$subcat='all_items';
									}
									
									$Product_product_name=str_replace(" ","_",trim($bestsellproduct['Product']['product_name'])); 
									$productimage=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$bestsellproduct['Product']['product_id'])));
									
									
									$product = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $bestsellproduct['Product']['product_id'])));
																															
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
										$customid = $product['Product']['metal_purity']."K";
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

									if ($product['Product']['gemstone'] == 'Yes') 
									{
										$gemstone = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productid)));
										$this->set('sgemstone', $gemstone);
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
										$goldprice = ClassRegistry::init('Price')->find('first', array('conditions' => array('metalcolor_id' => '2', 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
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
									if (!empty($gemstone)) {
										$gemprice = 0;
										$gemstone_wt = 0;
										foreach ($gemstone as $gemstones) {
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
									
									if(isset($productimage['Productimage']['imagename']))
									{
							?>
										<li>
											<div class="product-thumb product-border">
												<div class="image">
													<a data-id="2416" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$bestsellproduct['Product']['product_id']."/".$Product_product_name;?>">
														<?php echo  $this->Html->image('product/small/'.$productimage['Productimage']['imagename'],array("alt" => $Product_product_name,'title'=>$Product_product_name)); ?>
													</a>
												</div>
												<div>
													<div class="caption">
														<div class="name">
															<a class="boss-name" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$bestsellproduct['Product']['product_id']."/".$Product_product_name;?>"><?php echo $bestsellproduct['Product']['product_name']; ?></a>
														</div>
														<div class="price">
															₹ <?php echo indian_number_format($total); ?>
														</div>
													</div>
													<!--<div class="cart">
														<a class="btn btn-primary" title="Add to Cart" onclick="btadd.cart('2416','1');"><span>Add to Cart</span></a>
													</div>
													<div class="btn-action-group">
														<a class="btn-action btn-wishlist" title="Add to Wish List" onclick="boss_addToWishList('2416');"><span>Add to Wish List</span></a>
													</div>-->
												</div>
											</div>
										</li>
							<?php 
									} 	
								} 
							?>
						</ul>
						<div class="clearfix"></div>
					</div>
					<h3 class=" hide-on-desktop"><a class="head_tab11 head_tabs0" href="#content_tab11" data-src=".head_tab11" data-crs="#carousel_tab11">Popular</a></h3>
					<div id="content_tab11" class="content_tabs0 list_carousel responsive" style="display:none">
						<ul id="carousel_tab_product_9" class="box-product">
							<?php  
								foreach($popular as $popularproduct) 
								{
									$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id'=>$popularproduct['Product']['category_id'])));
									if(!empty($popularproduct['Product']['subcategory_id']))
									{	 
										$subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$popularproduct['Product']['subcategory_id'])));
										$subcat=str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']));
									}
									else
									{
										$subcat='all_items';
									}
									
									$Product_product_name=str_replace(" ","_",trim($popularproduct['Product']['product_name'])); 
									$productimage=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$popularproduct['Product']['product_id'])));
									
									$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id'=>$popularproduct['Product']['category_id'])));
									if(!empty($popularproduct['Product']['subcategory_id']))
									{	 
										$subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$popularproduct['Product']['subcategory_id'])));
										$subcat=str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']));
									}
									else
									{
										$subcat='all_items';
									}
									
									$Product_product_name=str_replace(" ","_",trim($popularproduct['Product']['product_name'])); 
									$productimage=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$popularproduct['Product']['product_id'])));
									
									
									$product = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $popularproduct['Product']['product_id'])));
																															
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
										$customid = $product['Product']['metal_purity']."K";
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

									if ($product['Product']['gemstone'] == 'Yes') 
									{
										$gemstone = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productid)));
										$this->set('sgemstone', $gemstone);
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
										$goldprice = ClassRegistry::init('Price')->find('first', array('conditions' => array('metalcolor_id' => '2', 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
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
									if (!empty($gemstone)) {
										$gemprice = 0;
										$gemstone_wt = 0;
										foreach ($gemstone as $gemstones) {
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
									
									if(isset($productimage['Productimage']['imagename']))
									{
							?>
										<li>
											<div class="product-thumb product-border">
												<div class="image">
													<a data-id="2416" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$popularproduct['Product']['product_id']."/".$Product_product_name;?>">
														<?php echo  $this->Html->image('product/small/'.$productimage['Productimage']['imagename'],array("alt" => $Product_product_name,'title'=>$Product_product_name)); ?>
													</a>
												</div>
												<div>
													<div class="caption">
														<div class="name">
															<a class="boss-name" href="<?php echo BASE_URL;?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".$subcat."/".$popularproduct['Product']['product_id']."/".$Product_product_name;?>"><?php echo $popularproduct['Product']['product_name']; ?></a>
														</div>
														<div class="price">
															₹ <?php echo indian_number_format($total); ?>
														</div>
													</div>
													<!--<div class="cart">
														<a class="btn btn-primary" title="Add to Cart" onclick="btadd.cart('2416','1');"><span>Add to Cart</span></a>
													</div>
													<div class="btn-action-group">
														<a class="btn-action btn-wishlist" title="Add to Wish List" onclick="boss_addToWishList('2416');"><span>Add to Wish List</span></a>
													</div>-->
												</div>
											</div>
										</li>
							<?php 
									} 	
								} 
							?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- New Arrival end -->
<!-- Customer Speaks Start-->

	
  <!--  <div  style=" margin: 0 auto; height: auto;" class="customer_speak">-->
			<!-- <div class="row"> -->
			<div class="carousel_speak_margin_div" style="margin: 0 auto; height: auto; overflow: auto; background-color: #F3F3F3; padding-bottom: 10px;    padding-top: 40px;">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-md-10" style="margin:auto; float:none;"></div>
					<div class="col-md-12">
<div class="uppercaseheading">CUSTOMERS SPEAK</div>

						

<!-- Corousel satrt -->

<?php
	$collection_type_ech=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(1,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name1=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'1')));
   
    $collection_type_sap=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(2,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name2=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'2')));
	
    $collection_type_emr=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(3,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name3=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'3')));
	
    $collection_type_bel=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(4,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name4=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'4')));
	
    $collection_type_ship=ClassRegistry::init('Product')->find('first',array('conditions'=>array('FIND_IN_SET(5,Product.collection_type)','status'=>'Active')));
	$collectiontype_val_name5=ClassRegistry::init('Collectiontype')->find('first',array('conditions'=>array('collectiontype_id'=>'5')));
    
    if(!empty($collection_type_bel) || !empty($collection_type_ech) || !empty($collection_type_emr) || !empty($collection_type_sap) || !empty($collection_type_ship))
	{
?>

		<style type="text/css">
			.carousel-content li{
				border: 0px;
                               
			}
			#boss_carousel1 img{
				margin: 0 auto;
			}
			.our-catalogue{
				color: black;
				opacity: 1; text-align:right;
				text-indent: 40px;
				font-weight: 600; height:142px;border-right: 1px solid black;
				padding-right: 10px;
				font-size: 14px;
				width: 100px;
			}
			.our-catalogue div{
				padding-right: 10px;
				margin-top: 45px;
			}

#boss_carousel1 li p
{
text-align:center;
padding-top: 20px;
}
		</style>

		<div class="" style=" margin: 0 auto; height: auto;">
			<!-- <div class="row"> -->
			<div style="margin: 0 auto; height: auto; overflow: auto; background-color: #F3F3F3; padding-bottom: 10px;    padding-top: 5px;">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-md-10" style="margin:auto; float:none;"></div>
					<div class="col-md-12">
						<div id="carousel1" class="boss-carousel not-animated" data-animate="fadeInUp" data-delay="300" style="">
							<section class="box-content">
								<ul id="boss_carousel1" class="carousel-content">
										<?php
											foreach($test as $test) 
											{
										?>
												
														<li style="color: #202020; font-weight: 400;">
															<div class="">
															    <a href="<?php echo BASE_URL;?>product?">														
																<img src="<?php echo $this->webroot; ?>img/testimonial/<?php echo $test['Testimonial']['image']; ?>" style="width:100px">
																</a>
															</div>
															<p><?php echo $test['Testimonial']['content'];?></p>
														</li>
													
									<?php 
											} 
										?>		
								</ul>

								<a id="carousel_next1" class="btn-nav-center prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
								<a id="carousel_prev1" class="btn-nav-center next nav_thumb" href="javascript:void(0)" title="next">Next</a>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript"><!--

		$(window).load(function(){

			$('#boss_carousel1').carouFredSel({

				auto: true,

				responsive: true,

				width: '100%',

				prev: '#carousel_next1',

				next: '#carousel_prev1',

				swipe: {

				onTouch : true

				},

				items: {

					width: 100,

					height: 'auto',

					visible: {

					min: 1,

					max: 2

					}

				},

				scroll: {

					direction : 'left',    //  The direction of the transition.

					duration  : 1000   //  The duration of the transition.

				}

			});

		});

		</script>
<?php
	}
?>

<!-- Corousel end -->


				</div>
			</div>
		</div>
     <!--  </div>-->
          

<!-- customers speak start -->
	<style>
		#tips,
		#tips li {
			margin: 0;
			padding: 0;
			list-style: none;
		}
		#tips {
                        font-family: Tahoma,Geneva,sans-serif;
			font-size: 14px;
			line-height: 115%;
			text-align: justify;
                        
		}
		#tips li {
			padding: 20px;
			/*display: none;*/
		}
	</style>
<!-- Customer speak end -->

<div class="container customer_speak">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 not-animated" data-animate="fadeInUp" data-delay="300">
				

                                     <?php echo $this->Element('newsletter');?>
  
  <?php
  $storeId=array('24','25','26','27','28','29'); 
  $staticpagesfeature=ClassRegistry::init('Staticpage')->find('all',array('conditions'=>array('staticpage_id'=>$storeId)));
  if(!empty($staticpagesfeature)){
 ?>   
      
  </div>
  
  <?php }?></div>
<!-- Payment Icons Start -->
	<div class="boss_footer">
		<div class="container">
			<div class="footer-block-shipping not-animated" data-animate="fadeInUp" data-delay="300">
				<div class="row">
					<div class="block block-1 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="icon"><i class="fa fa-truck"><b>test</b></i></div>
						<div class="text font_global">
							<h4>FREE SHIPPING</h4>
							<span>Free shipping on order over $1000</span>
						</div>
					</div>
					<div class="block block-2 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="icon"><i class="fa fa-repeat"><b>test</b></i></div>
						<div class="text font_global">
							<h4>FREE RETURN</h4>
							<span>free return in 24 hour after purchasing</span>
						</div>
					</div>
					<div class="block block-2 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="icon"><i class="fa fa-phone"><b>test</b></i></div>
						<div class="text font_global">
							<h4>CALL TOLL FREE</h4>
							<span>call 1800 1022 066 for free ordering</span>
						</div>
					</div>
					<div class="block block-4 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="icon"><i class="fa fa-truck"><b>test</b></i></div>
						<div class="text font_global">
							<h4>DOOR STEP DELIVERY</h4>
							<span>Cherishgold provides door step delivery</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Payment Icons End -->