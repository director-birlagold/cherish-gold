<?php
echo $this->Html->script(array('jquery.fancybox-1.3.4.pack'));
echo $this->Html->css(array('jquery.fancybox-1.3.4'));
?>
<script type="text/javascript">
$( "#tabs2" ).tabs({
		collapsible: true
	});
</script>
<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>

    <!--- New HTML Start -->

<div id="tabs2"  class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >

  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor" href="#tabs-1">SIGN IN</a></li>
            

        </ul>
            <div id="tabs-1">
                <p>
                <form name="login" id="loginpage" action="" method="post">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="30"><input type="radio" value="" name="data[signin][id]" id="signup" class="validate[required] radio"></td>
                            <td>No, I am a new user?</td>
                        </tr>
                        <tr><td colspan="2" height="10"></td></tr>
                        <tr>
                            <td><input name="data[signin][id]" type="radio" value="" id="signin" class="validate[required] radio" checked="checked"></td>
                            <td>Yes, I have a User ID and password? </td>
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
                                                    <td colspan="2"><input name="data[User][email]" type="text" class="validate[required,custom[email]]" ></td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>

                                                <tr>
                                                    <td colspan="2">Enter Password </td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>
                                                <tr>
                                                    <td colspan="2"><input name="data[User][password]" type="password" class="validate[required,minSize[6]]" ></td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>

                                                <tr><td colspan="2">&nbsp;</td></tr>
                                                <tr>
                                                    <td colspan="2"><input type="hidden" name="data[User][login]" value="" />
                    <button type="submit" value="Submit" class="button" />Submit</button> &nbsp<?php echo $this->Html->link('Forgot Password?', array('controller' => 'signin', 'action' => 'forgot'), array('class' => 'fancybox')); ?> </td>
                                                </tr>                            	
                                            </table>
                                        </td>

                                       <td width="100"><?php echo $this->Html->image('or_img.png',array('alt'=>''));  ?></td>
                    	               <td><a href="<?php echo BASE_URL;?>signin/facebook"><?php echo $this->Html->image('login_fb.png',array('alt'=>''));  ?></a></td>
                                    </tr>	


                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
                <?php echo $this->Form->create('User'); ?>
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none;" class="loginin">
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td colspan="2">User ID / Email ID</td>
                    </tr>
                    <tr><td colspan="2" height="10"></td></tr>
                    <tr>
                        <td colspan="2"><input name="data[User][email]" type="text" class="validate[required,custom[email]]" id="email"></td>
                    </tr>
                    <tr><td colspan="2" height="10"></td></tr>

                    <tr>
                        <td colspan="2">Enter Password </td>
                    </tr>
                    <tr><td colspan="2" height="10"></td></tr>
                    <tr>
                        <td colspan="2"><?php echo $this->Form->input('', array('div' => false, 'error' => false, 'name' => "data[User][password]", 'class' => 'validate[required,minSize[6]]', 'type' => 'password', 'size' => '50', 'id' => 'Userpassword')); ?></td>
                    </tr>
                    <tr><td colspan="2" height="10"></td></tr>

                    <tr>
                        <td colspan="2">Re-enter Password</td>
                    </tr>
                    <input type="hidden" name="data[User][user_type]" value="0" />
                    <tr><td colspan="2" height="10"></td></tr>
                    <tr>
                        <td colspan="2"><?php echo $this->Form->input('', array('div' => false, 'error' => false, 'name' => "data[User][cpassword]", 'class' => 'validate[required,minSize[6],equals[Userpassword]]', 'type' => 'password', 'size' => '50', 'id' => 'cpassword')); ?></td>
                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td colspan="2"><input type="hidden" name="data[User][register]" value="" />
                    <button type="submit" value="Submit" class="button" />Submit</button> &nbsp</td>
                    </tr>

                </table>
                <?php echo $this->Form->end(); ?>
                </p>

            </div>
       
    </div>
    <script>
        $(document).ready(function () {
            $('#signup').click(function () {
                $('.loginin').show();
                $('.logintwo').hide();

            });
            $('#signin').click(function () {
                $('.loginin').hide();
                $('.logintwo').show();

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
