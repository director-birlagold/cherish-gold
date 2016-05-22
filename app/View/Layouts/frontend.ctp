<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
			<?php
				if (!empty($title)) 
				{
					echo $title;
				} else 
				{
					echo 'Cherishgold';
				}
            ?> 
		</title>
		<?php
			if (!isset($metadescription) || empty($metadescription)) {
				$metadescription = "Birla Gold & Precious Metal Ltd. has launched a new venture under Birla Gold Brand \"Cherishgold\" as – A online Jewellery Stores. It\'s a newly launched e-commerce venture which BGP has launched for the Customers.  With \"Cherishgold\" Birla Gold & Precious Metal Ltd. wants to reach every house in the Country.";
			}

			if (!isset($metakeyword) || empty($metakeyword)) {
	            $metakeyword ="Cherishgold, Cherishgold, Cherishgold.in, Cherishgold Jewels, Cherishgold Jewels, Cherishgold Jewelery, Cherishgold Jewelery, Cherishgold Jewellery, Cherishgold Jewellery, Cherishgold Online Jewellery Store, Online Shopping,  birla gold\'s Cherishgold, Birla Gold\'s Cherishgold Franchise, gold savings plan, jewellery, birla gold jewellery, gold jewellery, gold saving plan, birla, birla gold and precious metals private limited, BGPM, birlagold, birlagoldsp, birla gold, birla gold savings plan, birla gold and precious metals, gold and precious metals";
	        }
			?>
        <meta name="Description" content="<?php echo $metadescription; ?>" />

        <meta name="Keywords" content="<?php echo $metakeyword; ?>" />
        
		<link href="/img/icons/fav.png" rel="icon" />
		<?php 
			echo $this->Html->css(array('frontendTheme/javascript/bossthemes/bootstrap/css/bootstrap.min', 'frontendTheme/javascript/bossthemes/font-awesome/css/font-awesome.min', 'frontendTheme/css/bt_parallax/stylesheet/stylesheet1', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/bt_stylesheet', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/responsive', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/bootstrap-select', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/jquery.jgrowl', 'frontendTheme/javascript/bossthemes/jquery-ui-1.11.2/jquery-ui', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/boss_revolutionslider/css/settings', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/boss_filterproduct', 'lightgallery/lightGallery','webcss/main', 'webcss/jquery-ui','webindex','jQuery.validation/validationEngine.jquery'));
			// echo $this->Html->script(array('frontendTheme/javascript/jquery/jquery-2.1.1.min', 'webjs/jquery-ui', 'frontendTheme/javascript/bossthemes/bootstrap/js/bootstrap.min', 'frontendTheme/javascript/bossthemes/getwidthbrowser', 'frontendTheme/javascript/bossthemes/jquery.appear', 'frontendTheme/javascript/bossthemes/cs.bossthemes', 'frontendTheme/javascript/bossthemes/jquery.jgrowl', 'frontendTheme/javascript/bossthemes/jquery.smoothscroll', 'frontendTheme/javascript/bossthemes/bootstrap-select', 'frontendTheme/javascript/bossthemes/jquery.tools.min', 'frontendTheme/javascript/bossthemes/jquery.revolution.min', 'frontendTheme/javascript/bossthemes/touchSwipe.min', 'frontendTheme/javascript/bossthemes/carouFredSel-6.2.0', 'frontendTheme/javascript/bossthemes/boss_filterproduct/boss_filterproduct', 'jQuery.validation/jquery.validationEngine', 'jQuery.validation/languages/jquery.validationEngine-en')); 
			// echo $this->Html->script(array('frontendTheme/javascript/jquery/jquery-2.1.1.min', 'webjs/jquery-ui', 'src/skdslider.min', 'webjs/fadeSlideShow', 'src/jquery.jqzoom-core', 'webjs/jquery.bxslider.min', 'webjs/jquery.colorbox', 'integer', 'jquery.fancybox-1.3.4.pack', 'lightgallery/lightGallery''frontendTheme/javascript/bossthemes/bootstrap/js/bootstrap.min', 'frontendTheme/javascript/bossthemes/getwidthbrowser', 'frontendTheme/javascript/bossthemes/jquery.appear', 'frontendTheme/javascript/bossthemes/cs.bossthemes', 'frontendTheme/javascript/bossthemes/jquery.jgrowl', 'frontendTheme/javascript/bossthemes/jquery.smoothscroll', 'frontendTheme/javascript/bossthemes/bootstrap-select', 'frontendTheme/javascript/bossthemes/jquery.tools.min', 'frontendTheme/javascript/bossthemes/jquery.revolution.min', 'frontendTheme/javascript/bossthemes/touchSwipe.min', 'frontendTheme/javascript/bossthemes/carouFredSel-6.2.0', 'frontendTheme/javascript/bossthemes/boss_filterproduct/boss_filterproduct', 'jQuery.validation/jquery.validationEngine', 'jQuery.validation/languages/jquery.validationEngine-en'));
			echo $this->Html->script(array('jquery-1.11.1.min', 'webjs/jquery.1.8.2.min', 'webjs/jquery-ui', 'src/skdslider.min', 'webjs/fadeSlideShow', 'src/jquery.jqzoom-core', 'webjs/fadeSlideShow', 'webjs/jquery.bxslider.min', 'webjs/jquery.colorbox', 'jQuery.validation/jquery.validationEngine', 'jQuery.validation/languages/jquery.validationEngine-en', 'integer', 'jquery.fancybox-1.3.4.pack', 'lightgallery/lightGallery', 'frontendTheme/javascript/bossthemes/bootstrap/js/bootstrap.min', 'frontendTheme/javascript/bossthemes/getwidthbrowser', 'frontendTheme/javascript/bossthemes/jquery.appear', 'frontendTheme/javascript/bossthemes/cs.bossthemes', 'frontendTheme/javascript/bossthemes/jquery.jgrowl', 'frontendTheme/javascript/bossthemes/jquery.smoothscroll', 'frontendTheme/javascript/bossthemes/bootstrap-select', 'frontendTheme/javascript/bossthemes/jquery.tools.min', 'frontendTheme/javascript/bossthemes/jquery.revolution.min', 'frontendTheme/javascript/bossthemes/touchSwipe.min', 'frontendTheme/javascript/bossthemes/carouFredSel-6.2.0', 'frontendTheme/javascript/bossthemes/boss_filterproduct/boss_filterproduct'));
		?>
		<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" /> -->
		
		<script type="text/javascript"><!--
			$(window).scroll(function() {
				var height_header = $('#bt_header').height();  			
				if($(window).scrollTop() > height_header) {
					
					$('.header-bottom').addClass('boss_scroll');
				} else {
					$('.header-bottom').removeClass('boss_scroll');
				}
			});
		//--></script>
		<!--[if IE 8]> 
		<script type="text/javascript">
			$(window).scroll(function() {
				var height_header = $('#bt_header').height();  			
				if($('html').scrollTop() > height_header) {				
					$('.header-bottom').addClass('boss_scroll');
				} else {
					$('.header-bottom').removeClass('boss_scroll');
				}
			});
		</script>
		<![endif]-->
		<script type="text/javascript"><!--
			window.onload = function() {
				$(".bt-loading").fadeOut("1500", function () {
					$('#bt_loading').css("display", "none");
				});
				
			};
		//--></script>
		<style>
			#bt_loading{position:fixed; width:100%; height:100%; z-index:99999; background:none repeat scroll 0 0 #fff;}
			.bt-loading{
				height: 300px;
				left: 50%;
				margin-left: -200px;
				margin-top: -150px;
				position: absolute;
				top: 50%;
				width: 400px;
				z-index: 9999;
				text-align: center;
			}
			.black-header{
				background-color: #333;
			}
			.list-inline a span{
				color: #fff;
			}
			.offer{
				color: #fff;
			}
			.offer-txt{
				padding: 8px;
				line-height:2;
			}
			.offer-txt span{
				color: gold;
			}
			.offer .shop-now{
				border: 1px solid #fff;
			        padding: 4px;
				margin: 3px;
				color:#fff;
                                 
			}
            .shop-now:hover{
                background:#e7c765;
            }   
			.offers{
				background-color: gold;
				padding: 5px;
				margin: 2px;
			}
			#search{
				width: 100%;
				border: 1px solid;
			
				float: left;
			}
			.phone-no{
				 <!--margin: 21px; -->
				display: block;
				float: right;
				font-size: 22px;
				margin-right: 0px;
			}
			.birlaheaderText{
             	font-family:'Yu Mincho';を指定
             	text-transform: uppercase;
				float: left;
				width: 100%;
				height: auto;
				text-align: left;
				color: #202020;
				font-size: 14px;
				text-shadow:0px 1px 0px #aaa;
				padding-top: 5px;
			}
		</style>
		
		<!--Start of Zopim Live Chat Script-->
			<script type="text/javascript">
			// window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
			// d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
			// _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
			// $.src="//v2.zopim.com/?3hQUB5NaiDhYSyzDXRwM8plv8DleCuO3";z.t=+new Date;$.
			// type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
			</script>
		<!--End of Zopim Live Chat Script-->
	</head>
	<body class="common-home ">
		
		<div class="fixTab">
			<div class="text">
				<a href="http://cherishgold.com/index.php?route=common/home#shopping-assist">Shopping Assistant</a>
			</div>
		</div>
		
		
			<div class="fixTab2">
				<div class="text">
					<a href="http://cherishgold.com/index.php?route=information/become-partner">Become a Partner</a></div></div>
		
		<div id="bt_loading">
			<div class="bt-loading">
				<?php echo $this->Html->image('/img/frontendTheme/catalog/cheshgold_logo_new.png',array("alt" =>"Loading...")); ?><br>
				<?php echo $this->Html->image('/img/frontendTheme/catalog/bt_parallax/loading.gif',array("alt" =>"Loading...")); ?><br>
			</div>
		</div>
		<div id="bt_container" class="bt-wide" >
			<div class="home_default">
				<?php echo $this->Element('header_new'); ?>
				<?php echo $content_for_layout; ?>
			</div>
		</div>
		<?php echo $this->Element('footer_new'); ?>
	</body>
</html>