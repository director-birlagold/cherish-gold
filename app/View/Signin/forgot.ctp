<?php
echo $this->Html->script(array('jquery.fancybox-1.3.4.pack'));
echo $this->Html->css(array('jquery.fancybox-1.3.4'));
?>
<script type="text/javascript">
$( "#tabs2" ).tabs({
		collapsible: true
	});
</script>
<div class="container">

<div id="tabs2"  class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor" href="#tabs-1">Forgot Password</a></li>
        </ul></div>
            <div id="tabs-1" >
                <p>
                <form name="login" id="loginpage" action="" method="post">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="login"> 
                        
						<tr>
                            <td></td>
                            <td style="color:red;"><?php echo $this->Session->flash() ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="logintwo">
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td width="400">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                                <tr>
                                                    <td colspan="2">User ID / Email ID</td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>
                                                <tr>
                                                    <td colspan="2"><input name="data[User][email]" type="text" class="validate[required,custom[email]]" /></td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>

                                                
                                                <tr>
                                                    <td colspan="2"><input type="hidden" name="data[User][login]" value="" />
                    <button type="submit" value="Submit" class="button" >Submit</button>
                    
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>


                                </table>
                            </td>
                        </tr>
                    </table>
                </form>

    </div>

<!--This feature added by Gaurav-->

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
<Payment Code Ended-->




    <script>
        $(document).ready(function () {
            $('#signup').click(function () {
                $('.loginin').show("slow");
                $('.logintwo').hide("slow");
            });
            $('#signin').click(function () {
                $('.loginin').hide("slow");
                $('.logintwo').show("slow");
            });
			 $('#forgot_button').click(function () {
               $('.loginin').hide("slow");
               $('.logintwo').hide("slow");
			   $('.login').hide("slow");
               $('#tabs_2').show("slow");
            });
			 $('#signin_button').click(function () {
               $('.logintwo').show("slow");
			   $('.login').show("slow");
               $('#tabs_2').hide("slow");
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#UserIndexForm").validationEngine();
            $("#formSubmit").validationEngine();
            $("#shipping_details").validationEngine();
            $("#loginpage").validationEngine();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.title').on("change", function () {
                if ($('.title').val() == 'Miss') {
                    $('.anniversary').hide();
                } else
                {
                    $('.anniversary').show();
                }
            });
        });
    </script>
    <script>
        $('a.fancybox').fancybox({
            type: "iframe"
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".fancybox").fancybox('click');
            $('.fancybox').click(function () {
                $(document).mousedown(function () {
                    $("body").css("overflow", "auto");
                });
                $(document).keyup(function (e) {
                    if (e.keyCode == 27) {
                        $("body").css("overflow", "auto");
                    }
                });

                $("body").css("overflow", "hidden");

            });
        });
    </script>
