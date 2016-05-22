<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php
            if (!empty($title)) {
                echo $title;
            } else {
                echo 'Cherishgold';
            }
            ?> </title>

        <meta name="Description" content="
        <?php
        if (!empty($metadescription)) {
            echo $metadescription;
        } else {
            echo "Birla Gold & Precious Metal Ltd. has launched a new venture under Birla Gold Brand \"Cherishgold\" as – A online Jewellery Stores. It\'s a newly launched e-commerce venture which BGP has launched for the Customers.  With \"Cherishgold\" Birla Gold & Precious Metal Ltd. wants to reach every house in the Country.";
        }
        ?>
              " />

        <meta name="Keywords" content="
        <?php
        if (!empty($metakeyword)) {
            echo $metakeyword;
        } else {
            echo "Cherishgold, Cherishgold, Cherishgold.in, Cherishgold Jewels, Cherishgold Jewels, Cherishgold Jewelery, Cherishgold Jewelery, Cherishgold Jewellery, Cherishgold Jewellery, Cherishgold Online Jewellery Store, Online Shopping,  birla gold's Cherishgold, Birla Gold's Cherishgold Franchise, gold savings plan, jewellery, birla gold jewellery, gold jewellery, gold saving plan, birla, birla gold and precious metals private limited, BGPM, birlagold, birlagoldsp, birla gold, birla gold savings plan, birla gold and precious metals, gold and precious metals";
        }
        ?>">
        </meta>
        <title>Home | <?php echo SITE_NAME; ?></title>
        <!--<link href='http://fonts.googleapis.com/css?family=Merriweather:900|Cinzel:700' rel='stylesheet' type='text/css'>-->
        <?php
		echo $this->Html->css(array('frontendTheme/javascript/bossthemes/bootstrap/css/bootstrap.min', 'frontendTheme/javascript/bossthemes/font-awesome/css/font-awesome.min', 'frontendTheme/css/bt_parallax/stylesheet/stylesheet1', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/bt_stylesheet', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/responsive', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/bootstrap-select', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/jquery.jgrowl', 'frontendTheme/javascript/bossthemes/jquery-ui-1.11.2/jquery-ui', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/boss_revolutionslider/css/settings', 'frontendTheme/css/bt_parallax/stylesheet/bossthemes/boss_filterproduct', 'lightgallery/lightGallery','webcss/main', 'webcss/jquery-ui','webindex'));
        echo $this->Html->css(array('webindex', 'webcss/main', 'webcss/jquery-ui', 'src/skdslider', 'webcss/jquery.jqzoom', 'webcss/jquery.bxslider', 'webcss/colorbox', 'jQuery.validation/validationEngine.jquery', 'message', 'jquery.fancybox-1.3.4', 'lightgallery/lightGallery'));
        echo $this->Html->script(array('jquery-1.11.1.min', 'webjs/jquery.1.8.2.min', 'webjs/jquery-ui', 'src/skdslider.min', 'webjs/fadeSlideShow', 'src/jquery.jqzoom-core', 'webjs/fadeSlideShow', 'webjs/jquery.bxslider.min', 'webjs/jquery.colorbox', 'jQuery.validation/jquery.validationEngine', 'jQuery.validation/languages/jquery.validationEngine-en', 'integer', 'jquery.fancybox-1.3.4.pack', 'lightgallery/lightGallery'));
        ?>
        <link rel="icon" href="/img/icons/fav.png" />


        <script type="text/javascript">
            jQuery(document).ready(function () {
                $('.header_menu').show();
                jQuery('#demo1').skdslider({'delay': 5000, 'animationSpeed': 2000, 'showNextPrev': true, 'showPlayButton': true, 'autoSlide': true, 'animationType': 'fading'});
                jQuery('#demo2').skdslider({'delay': 5000, 'animationSpeed': 1000, 'showNextPrev': true, 'showPlayButton': false, 'autoSlide': true, 'animationType': 'sliding'});
                jQuery('#demo3').skdslider({'delay': 5000, 'animationSpeed': 2000, 'showNextPrev': true, 'showPlayButton': true, 'autoSlide': true, 'animationType': 'fading'});

                jQuery('#responsive').change(function () {
                    $('#responsive_wrapper').width(jQuery(this).val());
                });

                $('.filter_option').click(function () {
                    var current_id = this.id;
                    $('#' + current_id + ' .filter_option_menu').slideToggle();
                });

                $('a').click(function () {
                    $('.coming_soon').fadeIn();
                });
                $('.close').click(function () {
                    $('.coming_soon').fadeOut();
                });


                $('.top_mid a').mouseover(function () {
                    $('.my_account_dropdown').slideDown(700);
                });
                $('.top_mid').mouseout(function () {
                    $('.my_account_dropdown').slideUp(700);
                });

                jQuery('.slideshow2').fadeSlideShow();
                $('.slider1').bxSlider({
                    responsive: false,
                    pager: false,
                    slideWidth: 320,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 4
                });
                $('.slider2').bxSlider({
                    responsive: false,
                    pager: false,
                    slideWidth: 320,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 4

                });
                $('.slider3').bxSlider({
                    responsive: false,
                    pager: false,
                    slideWidth: 116,
                    slideMargin: 0,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 4
                });
                $(".group2").colorbox({rel: 'group2', transition: "fade"});
                $(".youtube").colorbox({iframe: true, innerWidth: 640, innerHeight: 390});

                $("#tabs").tabs({event: "mouseover"}).addClass("ui-tabs-vertical ui-helper-clearfix");
                $("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");


                $('#nav > li').hover(function () {
                    _jewel = $(this).find('.shagun_megamenu');
                    if (_jewel.length > 0) {
//                        $(_jewel).css('border-top', '3px solid #e2ba35');
                    } else {
                    }
                    $('#nav > li, #nav > li.home_icn').not(this).css('border-bottom', '3px solid #e2ba35');
                    $(this).css('border-right', '1px solid #e2ba35');
                    $(this).prev().css('border-right', '1px solid #e2ba35');
                }, function () {
                    $('#nav > li, #nav > li.home_icn').css('border-bottom', 'none');
                    $(this).css('border-right', '1px dashed #e2ba35');
                    $(this).prev().css('border-right', '1px dashed #e2ba35')
                });
                $(".inline").colorbox({inline: true, width: "40%"});
                $(".accordion").accordion({
                    autoHeight: true,
                    heightStyle: "content"
                });

                $(".menutabs").tabs({event: "mouseover"}).addClass("ui-tabs-vertical ui-helper-clearfix");
                $(".menutabs li").removeClass("ui-corner-top").addClass("ui-corner-left");
            });


        </script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('.jqzoom').jqzoom({
                    zoomType: 'standard',
                    lens: true,
                    preloadImages: false,
                    alwaysOn: false,
                    title: false
                });

                /*$( "#tabs2" ).tabs({
                 collapsible: true
                 });*/



            });


        </script>
		
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
				text-align: right;
				color: #202020;
				font-size: 15px;
				text-shadow:0px 1px 0px #aaa;
				padding-top: 5px;
                                
			}
		</style>

    </head>
    <body>
        <div class="helpfade"></div>
        <div class="helptips"><div class="loader_block"><div class="loader_block_inner"></div><div class="loader_text">Please wait...</div></div></div>
        <div class="dismsg" id="msginfo"><?php
            $msg = $this->Session->flash();
            if (!empty($msg))
                echo $msg . '<div class="close">Click to close.</div>';
            ?></div>
        <?php echo $this->Element('header_new'); ?>
        <?php echo $content_for_layout; ?>
        <?php echo $this->Element('footer_new'); ?>
    </div>
    <script>
        $("#msginfo").click(function () {
            $("#msginfo").fadeOut(1000);
        });
        setTimeout(function () {
            $('#msginfo').fadeOut(1000);
        }, 5000);
    </script>

</body>
</html>


