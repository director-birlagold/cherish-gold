<?php
if (isset($this->params['pass']['0'])) {
    $label = 'Edit';
} else {
    $label = 'Add';
}
?>
<div id="content"  class="clearfix">
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Price List'), array('action' => 'index'), array('class' => 'button')); ?></div>

        <form name="Price" id="myForm" method="post" enctype="multipart/form-data" action="">
            <fieldset>
                <legend><?php echo $label; ?> Price</legend>
                <dl class="inline">
                    <dt><label for="name">Type<?php if (!isset($this->params['pass']['0'])) { ?><span class="required">*</span><?php } ?></label></dt>
                    <dd><?php if (!isset($this->params['pass']['0'])) { ?><input type="radio" id="checklist"  class="validate[required] radio metal" name="data[Price][type]" value="Metals"  />Metal&nbsp;&nbsp;&nbsp;<?php
                        } else {
                            if ($price['Price']['type'] == 'Metals') {
                                echo $price['Price']['type'];
                            } elseif ($price['Price']['type'] == 'Stone') {
                                echo 'Diamond';
                            } elseif ($price['Price']['type'] == 'Gemstone') {
                                echo $price['Price']['type'];
                            }
                        }
                        ?>

                        <?php if (!isset($this->params['pass']['0'])) { ?>
                            <input type="radio" id="checklist" class="validate[required] radio metal" name="data[Price][type]" value="Stone"  <?php
                            if (isset($this->params['pass']['0'])) {
                                if ($price['Price']['type'] == 'Stone') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                            }
                            ?>/>Diamond&nbsp;&nbsp;&nbsp;<?php } ?>
                               <?php if (!isset($this->params['pass']['0'])) { ?>
                            <input type="radio" id="checklist" class="validate[required] radio metal" name="data[Price][type]" value="Gemstone"  <?php
                            if (isset($this->params['pass']['0'])) {
                                if ($price['Price']['type'] == 'Gemstone') {
                                    echo 'checked="checked"';
                                } else {
                                    
                                }
                            }
                            ?>/>Gemstone&nbsp;&nbsp;&nbsp;</dd><?php } ?>


                    <div class="metaldetails" style="dispaly:block;">
                        <dt ><label for="name">Metal <?php if (!isset($this->params['pass']['0'])) { ?><span class="required">*</span><?php } ?></label></dt>


                        <?php if (isset($this->params['pass']['0'])) { ?>
                            <input type="hidden" name="data[Price][type]" value="<?php echo $price['Price']['type']; ?>"/>
                            <input type="hidden" name="data[Price][metal_id]" value="<?php echo $price['Price']['metal_id']; ?>"/> 
                            <input type="hidden" name="data[Price][diamond_id]" value="<?php echo $price['Price']['diamond_id']; ?>"/> 
                            <input type="hidden" name="data[Price][gemstone_id]" value="<?php echo $price['Price']['gemstone_id']; ?>"/> 

                            <?php
                        }
                        ?>
                        <dd><?php if (!isset($this->params['pass']['0'])) { ?>
                                <select name="data[Price][metal_id]" class="validate[required] metalid" id="metalid">
                                    <option value="">Select </option>
                                    <?php
                                    foreach ($metal as $metal) {
                                        if (!isset($this->params['pass']['0'])) {

                                            echo '<option value="' . $metal['Metal']['metal_id'] . '">' . $metal['Metal']['metal_name'] . '</option>\n';
                                        }
                                    }
                                    ?>                       
                                </select>

                                <?php ?><?php
                            } if (isset($this->params['pass']['0'])) {
                                if ($price['Price']['type'] == 'Stone') {

                                    $diamond = ClassRegistry::init('Diamond')->find('first', array('conditions' => array('diamond_id' => $price['Price']['diamond_id'])));
                                    echo $diamond['Diamond']['name'];
                                }
                                if ($price['Price']['type'] == 'Metals') {
                                    $metals = ClassRegistry::init('Metal')->find('first', array('conditions' => array('metal_id' => $price['Price']['metal_id'])));
                                    echo $metals['Metal']['metal_name'];
                                }
                                if ($price['Price']['type'] == 'Gemstone') {
                                    $gemstone = ClassRegistry::init('Gemstone')->find('first', array('conditions' => array('gemstone_id' => $price['Price']['gemstoneshape'])));
                                    echo $gemstone['Gemstone']['stone'];
                                }
                            }
                            ?>

                        </dd>



                        <?php
                        if (isset($this->params['pass']['0'])) {
                            if ($price['Price']['type'] == 'Metals') {
                                $metalcolor = ClassRegistry::init('Metalcolor')->find('all', array('conditions' => array('metalcolor_id' => $price['Price']['metalcolor_id'])));
                            }
                        }
                        ?>
                        <div class="color" <?php
                        if (isset($this->params['pass']['0'])) {
                            if ($price['Price']['metalcolor_id']) {
                                echo 'style="display:block;"';
                            } else {
                                echo 'style="display:none";';
                            }
                        } else {
                            echo 'style="display:none;"';
                        }
                        ?>>
                            <dt><label for="name">Metal Color<span class="required">*</span></label></dt>
                            <dd><div class="metal_colordiv" > 
                                    <select name="data[Price][metalcolor_id]">
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($this->params['pass']['0'])) {
                                            foreach ($metalcolor as $metalcolor) {

                                                echo '<option value="' . $metalcolor['Metalcolor']['metalcolor_id'] . '"' . ($metalcolor['Metalcolor']['metalcolor_id'] == $price['Price']['metalcolor_id'] ? 'selected="selected"' : '') . '>' . $metalcolor['Metalcolor']['metalcolor'] . '</option>\n';
                                            }
                                        }
                                        ?>  
                                    </select>

                                </div>

                            </dd>
                            <dt><label for="name">Metal Fineness</label></dt>
                            <dd><div> 
                                    <select name="data[Price][metal_fineness]">
                                        <option value="0">Select</option>
                                        <option value="999" <?php echo isset($price['Price']['metal_fineness']) && $price['Price']['metal_fineness'] == '999' ? 'selected' : ''?>>999</option>
                                        <option value="995" <?php echo isset($price['Price']['metal_fineness']) && $price['Price']['metal_fineness'] == '995' ? 'selected' : ''?>>995</option>
                                    </select>

                                </div>

                            </dd>
                        </div>
                        <?php if (!isset($this->params['pass']['0'])) { ?>
                        </div>
                    <?php } ?>
                    <div class="stonedetails" style="display:none;">
                        <dt ><label for="name">Diamond <?php if (!isset($this->params['pass']['0'])) { ?><span class="required">*</span><?php } ?></label></dt>

                        <dd><?php if (!isset($this->params['pass']['0'])) { ?>
                                <select name="data[Price][diamond_id]" class="validate[required] stoneid" id="stoneid">
                                    <option value="">Select </option>
                                    <?php
                                    foreach ($diamond as $diamond) {
                                        if (!isset($this->params['pass']['0'])) {

                                            echo '<option value="' . $diamond['Diamond']['diamond_id'] . '">' . $diamond['Diamond']['name'] . '</option>\n';
                                        }
                                    }
                                    ?>                       
                                </select>
                                <?php ?><?php
                            } if (isset($this->params['pass']['0'])) {
                                echo $diamond['Diamond']['name'];
                            }
                            ?></dd>
                    </div>
                    <div class="gemstone" style="display:none;">
                        <dt ><label for="name">Gemstone <?php if (!isset($this->params['pass']['0'])) { ?><span class="required">*</span><?php } ?></label></dt>
                        <dd><?php if (!isset($this->params['pass']['0'])) { ?>
                                <select name="data[Price][gemstone_id]" class="validate[required] stoneid" id="stoneid">
                                    <option value="">Select </option>
                                    <?php
                                    foreach ($gemstone as $gemstone) {
                                        if (!isset($this->params['pass']['0'])) {

                                            echo '<option value="' . $gemstone['Gemstone']['gemstone_id'] . '">' . $gemstone['Gemstone']['stone'] . '</option>\n';
                                        }
                                    }
                                    ?>                       
                                </select>
                                <?php ?><?php
                            } if (isset($this->params['pass']['0'])) {
                                echo $diamond['Diamond']['name'];
                            }
                            ?></dd>

                    </div>
                    <?php
                    if (isset($this->params['pass']['0'])) {
                        if ($price['Price']['type'] == 'Gemstone') {
                            $shapes = ClassRegistry::init('Shape')->find('all', array('conditions' => array('shape_id' => $price['Price']['gemstoneshape'])));
                        }
                    }
                    ?>
                    <div class="gem" <?php
                    if (isset($this->params['pass']['0'])) {
                        if ($price['Price']['type'] == 'Gemstone') {
                            echo 'style="display:block;"';
                        } else {
                            echo 'style="display:none";';
                        }
                    } else {
                        echo 'style="display:none";';
                    }
                    ?>>
                        <dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                        <dd><select name="data[Price][gemstoneshape]" class="validate[required]" id="stone_shape">
                                <option value="">Select Stone Shape  </option>
                                <?php
                                foreach ($shape as $new_shapes) {
                                    if (!isset($this->params['pass']['0'])) {
                                        echo '<option value="' . $new_shapes['Shape']['shape_id'] . '">' . $new_shapes['Shape']['shape'] . '</option>\n';
                                    } else {
                                        echo '<option value="' . $new_shapes['Shape']['shape_id'] . '" ' . ($new_shapes['Shape']['shape_id'] == $price['Price']['gemstoneshape'] ? 'selected="selected"' : '') . '>' . $new_shapes['Shape']['shape'] . '</option>';
                                    }
                                }
                                ?>
                            </select></dd> 
                    </div>


                    <div class="stonedetails" <?php
                    if (isset($this->params['pass']['0'])) {
                        if ($price['Price']['type'] == 'Metals') {
                            echo 'style="display:none";';
                        }if ($price['Price']['type'] == 'Gemstone') {
                            echo 'style="display:none";';
                        } else {
                            echo 'style="display:block";';
                        }
                    } else {
                        echo 'style="display:none";';
                    }
                    ?> >
                        <dt><label for="name">Stone Clarity<span class="required">*</span></label></dt> 
                        <dd><select name="data[Price][clarity_id]" class="validate[required] stone_clarity" id="stone_clarity">
                                <option value="">Select Stone Clarity</option>
                                <?php
                                foreach ($clarity as $clarities) {
                                    if (!isset($this->params['pass']['0'])) {

                                        echo '<option value="' . $clarities['Clarity']['clarity_id'] . '">' . $clarities['Clarity']['clarity'] . '</option>\n';
                                    } else {
                                        echo '<option value="' . $clarities['Clarity']['clarity_id'] . '" ' . ($clarities['Clarity']['clarity_id'] == $price['Price']['clarity_id'] ? 'selected="selected"' : '') . '>' . $clarities['Clarity']['clarity'] . '</option>';
                                    }
                                }
                                ?>
                            </select></dd>  
                        <div class="stone_color">
                            <?php
                            if (isset($this->params['pass']['0'])) {
                                $clarity = ClassRegistry::init('Clarity')->find('first', array('conditions' => array('clarity_id' => $price['Price']['clarity_id'])));
                                $colors = ClassRegistry::init('Color')->find('all', array('conditions' => array('clarity' => $clarity['Clarity']['clarity'])));
                                ?>
                                <dt><label for="name">Stone Color<span class="required">*</span></label></dt> 
                                <dd><select name="data[Price][color_id]" class="validate[required]" id="stone_color">
                                        <option value="">Select Stone Color</option>
                                        <?php
                                        foreach ($colors as $new_color) {

                                            echo '<option value="' . $new_color['Color']['color_id'] . '" ' . ($new_color['Color']['color_id'] == $price['Price']['color_id'] ? 'selected="selected"' : '') . '>' . $new_color['Color']['color'] . '</option>';
                                        }
                                        ?>
                                    </select></dd>   
                            <?php } ?>
                        </div>
                        <!--<dt><label for="name">Stone Shape<span class="required">*</span></label></dt> 
                        <dd><select name="data[Price][shape_id]" class="validate[required]" id="stone_shape">
                       <option value="">Select Stone Shape  </option>
                        <?php
                        /* foreach($shape as $new_shapes){ 
                          if(!isset($this->params['pass']['0'])){
                          echo '<option value="'.$new_shapes['Shape']['shape_id'].'">'.$new_shapes['Shape']['shape'].'</option>\n';
                          }else{
                          echo '<option value="'.$new_shapes['Shape']['shape_id'].'" '.($new_shapes['Shape']['shape_id']==$price['Price']['shape_id']?'selected="selected"':'').'>'.$new_shapes['Shape']['shape'].'</option>';
                          }
                          } */
                        ?>
                       </select></dd> -->


                    </div>
                    <dt><label for="name">Price<span class="required">*</span></label></dt>
                    <dd><input type="text" name="data[Price][price]" id="regpincode" onkeypress="return floatnumbers(this, event)"  class="validate[required,custom[number]]"   size="50" value="<?php
                        if (isset($this->params['pass']['0'])) {
                            echo $price['Price']['price'];
                        } else {
                            
                        }
                        ?>" />
                        <div class="kt" <?php
                        if (isset($this->params['pass']['0'])) {
                            if ($price['Price']['type'] == 'Metals') {
                                echo 'style="display:block";';
                            } else {
                                echo 'style="display:none";';
                            }
                        }
                        ?> style="display:block;" ><p><strong>(24 Kt price/gm)</strong></p></div>
                        <div class="ct"<?php
                        if (isset($this->params['pass']['0'])) {
                            if ($price['Price']['type'] == 'Stone') {
                                echo 'style="display:block";';
                            } if ($price['Price']['type'] == 'Gemstone') {
                                echo 'style="display:block";';
                            } else {
                                echo 'style="display:none";';
                            }
                        }
                        ?> style="display:none;"><p><strong>(carat price)</strong></p></div>
                    </dd>  
                    <div class="buttons" >
                        <input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
                </dl>
            </fieldset>
        </form>

    </div>
</div>

<script>
    $(document).ready(function () {

        $('.metal').click(function () {
            var type = $(this).val();
            if (type == 'Metals') {
                $('.stonedetails').hide();
                $('.metaldetails').show();
                $('.gemstone').hide();

                $('.stonedetails').hide();
                $('.kt').show();
                $('.ct').hide();

            } else if (type == 'Stone')
            {
                $('.stonedetails').show();
                $('.metaldetails').hide();
                $('.stone').hide();
                $('.stonedetails').show();
                $('.gemstone').hide();
                $('.gem').hide();
                $('.kt').hide();
                $('.ct').show();

            }
            else if (type == 'Gemstone')
            {
                $('.gemstone').show();
                $('.stonedetails').hide();
                $('.metaldetails').hide();
                $('.gem').show();
                $('.kt').hide();
                $('.ct').show();
            }

        });

    });
</script>

<script>

    $(document).ready(function () {

        $('.metalid').on("change", function () {

            var id = $(this).val();

            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>prices/metalcolor/",
                data: 'id=' + id,
                dataType: 'html',
                success: function (data) {
                    $('.color').css('display', 'block');
                    $('.metaldetails').css('display', 'block');
                    $('.metal_colordiv').html(data);
                    $('.metal_colordiv select').uniform();
                }
            });

        });


    });
</script>
<script>
    $(document).ready(function () {
        $('.stone_clarity').live("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>prices/stone_color/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<dt><label for='color'>Stone Color<span class='required'>*</span></label><dd><select name='data[Price][color_id]'  class='validate[required]input-md stone_color'><option value=''>Select Color</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Color.color_id + "'>" + v.Color.color + " </option>";
                    });
                    appenddata += "</select></dd>";
                    $('.stone_color').html(appenddata);
                    $('.stone_color select').uniform();

                }
            });

            $('.stone_color').html('');
        });
    });
</script>