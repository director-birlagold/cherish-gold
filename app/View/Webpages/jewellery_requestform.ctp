<header>&nbsp;</header> 
<div class="main"> <div style="clear:both;">&nbsp;</div>
    <div class="middleContent">
        <h2>Customized Jewellery Request</h2>        

    </div>
    <form method="post" action="" id="myForm123" enctype="multipart/form-data">
        <input type="hidden" name="stone_count" value="1" id="stone_count">
        <input type="hidden" name="diamond_count" value="1" id="diamond_count">
        <div id="tabs2" class="tabsDiv">
            <div style="float:left; width:100%;">
                <table cellpadding="0" cellspacing="0" border="0" width="80%">
                    <tr>
                        <td width="120">Name</td>
                        <td width="30">:</td>
                        <td><input type="text" name="name" class="validate[required]" style="width:330px;"></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td valign="top">Address</td>
                        <td valign="top">:</td>
                        <td><textarea rows="" class="validate[required]"  cols="" name="address"></textarea></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td>Mobile Number</td>
                        <td>:</td>
                        <td><input type="text" name="mobile"  class="validate[required]"  style="width:330px;"></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td>Email ID</td>
                        <td>:</td>
                        <td><input type="text" class="validate[required,custom[email]]"  name="email" style="width:330px;"></td>
                    </tr>
                    <tr><td colspan="3">&nbsp;</td></tr>

                <!--<tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><button>Save Changes</button></td>
                </tr>-->
                    <tr><td colspan="3" height="10"></td></tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>Product Category</strong> &nbsp; 
                            <select style="width:120px;" name="category" onchange="get_size(this.value)">
                                <option value="">Select</option>
                                <?php foreach ($categories as $categorie) { ?>
                                    <option value="<?php echo $categorie['Category']['category']; ?>" ><?php echo $categorie['Category']['category']; ?></option>
                                <?php } ?>
                            </select>&nbsp; (options available)</td>
                    </tr>

                    <tr><td colspan="3">&nbsp;</td></tr>

                    <tr>
                        <td colspan="3">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"> 
                                <tr>
                                    <td colspan="15" align="center"><h3>Product Details</h3></td>
                                </tr>
                                <tr>
                                    <td><table>
                                            <tr>                                <td width="110">Size</td>
                                                <td width="10">:</td>
                                                <td width="90">
                                                    <select style="width:130px;" name="size" id="size">
                                                        <option value="">Select</option>
                                                        <?php // for($i=6;$i<=30;$i++) { ?>

                                                        <?php //  } ?>

                                                    </select>
                                                </td>
                                                <td width="90">Height</td>
                                                <td width="10">:</td>
                                                <td width="90"><input type="text" name="height" style="width:60px;"></td>
                                                <td width="100">Width</td>
                                                <td width="10">:</td>
                                                <td width="90"><input type="text" name="width" style="width:60px;"></td>
                                                <td width="50">Length</td>
                                                <td width="10">:</td>
                                                <td width="90"><input type="text" name="length" style="width:60px;"></td>
                                                <td width="90">Total Weight</td>
                                                <td width="10">:</td>
                                                <td><input type="text" name="tweight" style="width:60px;"></td>
                                            </tr> 

                                        </table></td></tr>


                                <tr>
                                    <td colspan="15">&nbsp;</td>
                                </tr>


                                <tr>
                                    <td colspan="15" align="center"><h3>Metals Details</h3></td>
                                </tr>


                                <tr><td><table>
                                            <tr>                            	
                                                <td>Metals Weight</td>
                                                <td>:</td>
                                                <td><input type="text" name="mweight" style="width:60px;"></td>
                                                <td>Purity</td>
                                                <td>:</td>
                                                <td id="puritytd">
                                                    <select style="width:80px;" name="mpurity">
                                                        <option value="">Select</option>
                                                    </select>
                                                </td>
                                                <?php
                                                $metals = ClassRegistry::init('Metal')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
                                                ?>
                                                <td>Metals</td>
                                                <td>:</td>
                                                <td>
                                                    <select style="width:100px;" name="mmetal" id="metalsdiv">
                                                        <option value="">Select</option>
                                                        <?php
                                                        foreach ($metals as $metal) {
                                                            echo "<option value='{$metal['Metal']['metal_name']}'>{$metal['Metal']['metal_name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>Color</td>
                                                <td>:</td>
                                                <td id="colorstd">
                                                    <select style="width:100px;" name="mcolor">
                                                        <option value="">Select</option>
                                                    </select>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table></td></tr>

                                <tr><td colspan="15">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="15" align="center"><h3>Diamond Details</h3></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div id="diamond_details">
                                            <table id="diamond_table0">
                                                <tr>                                
                                                    <td>SI-IJ</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dsiij[]" style="width:60px;"></td>
                                                    <td>SI-GH</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dsigh[]" style="width:60px;"></td>
                                                    <td>VS-GH</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dvsgh[]" style="width:60px;"></td>
                                                    <td>VVS-EF</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dvvsef[]" style="width:60px;"></td>
                                                    <td>Setting</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        $type = ClassRegistry::init('Settingtype')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'settingtype_id ASC'));
                                                        ?>
                                                        <select style="width:100px;" name="dsettings[]" style="width:60px;">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($type as $new_type) {
                                                                echo "<option value='{$new_type['Settingtype']['settingtype']}'>{$new_type['Settingtype']['settingtype']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>                            
                                                <tr><td colspan="15" height="10"></td></tr>

                                                <tr>
                                                    <td>Shape</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        $shapes = ClassRegistry::init('Shape')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
                                                        ?>
                                                        <select style="width:100px;" name="dshape[]" style="width:60px;">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($shapes as $shape) {
                                                                echo "<option value='{$shape['Shape']['shape']}'>{$shape['Shape']['shape']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>

                                                    <td>No.of Stone</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dstonecount[]" style="width:60px;"></td>

                                                    <td>Weight/Carat</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="dweight[]" style="width:60px;"></td>
                                                    <td align="left" colspan="15"><button type="button" style="padding:3px 10px; font-size:11px;" id="add_diamond">Add more</button></td><!--<td><button type="button" style="padding:3px 10px; font-size:12px;display:none;" id="remove_diamond">remove</button></td>-->
                                                </tr>       
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <tr><td colspan="15">&nbsp;</td></tr>




                                <tr><td colspan="15">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="15" align="center"><h3>Stone Details </h3></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div  id="stone_details">
                                            <table id="stone_table0">
                                                <tr>
                                                    <td>Stone Name</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        $gems = ClassRegistry::init('Gemstone')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
                                                        ?>
                                                        <select style="width:100px;" name="sname[]" style="width:60px;">
                                                            <option value="">Select</option>
                                                            <?php
                                                                foreach ($gems as $gem) {
                                                                    echo '<option value="' . $gem['Gemstone']['stone'] . '">' . $gem['Gemstone']['stone'] . '</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>Shape</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        $shapes = ClassRegistry::init('Shape')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
                                                        ?>
                                                        <select style="width:100px;" name="sshape[]" style="width:60px;">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($shapes as $shape) {
                                                                echo "<option value='{$shape['Shape']['shape']}'>{$shape['Shape']['shape']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>Weight/Carat</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="sweight[]" style="width:60px;"></td>
                                                    <td>Setting</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
//                                                        $type = ClassRegistry::init('Settingtype')->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'settingtype_id ASC'));
                                                        ?>
                                                        <select style="width:100px;" name="ssetting[]" style="width:60px;">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($type as $new_type) {
                                                                echo "<option value='{$new_type['Settingtype']['settingtype']}'>{$new_type['Settingtype']['settingtype']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>No.of Stone</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="sstonecount[]" style="width:60px;"></td>
                                                        <td align="right" colspan="15"><button type="button" style="padding:3px 10px; font-size:11px;" id="add_stone">Add more</button></td><!--<td><button type="button" style="padding:3px 10px; font-size:12px;display:none" id="remove_stone">remove</button></td>-->
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <tr><td colspan="15">&nbsp;</td></tr>



                                <tr><td colspan="15">&nbsp;</td></tr>




                                <tr><td colspan="15">&nbsp;</td></tr>
                                <tr>

                                    <td colspan="15">
                                        <input type="file" id="browse" style=" background-color: #dba715;border: 0 none;display:none;color: #fff;cursor: pointer;padding: 7px 20px;text-transform: uppercase;" size="40" name="image">
                                        <label for="browse" style="background: none repeat scroll 0 0 #dba715;     color: #fff;     display: inline-block;     padding: 8px 20px;     text-align: center;     width: 200px; height:17px">Upload File</label>
                                        &nbsp; <button>Submit</button> </td>

<!--<td colspan="15">
<input  type="file" name="image" size="40"
style=" background-color: #dba715;border: 0 none;color: #fff;cursor: pointer;padding: 7px 20px;text-transform: uppercase;" >
&nbsp; <button>Submit</button> </td>-->
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </form>
    <?php echo $this->Element('newsletter'); ?>

    <div style='display:none'>
        <div id='inline_content2' style='padding:10px; background:#fff;'>


            <div id="tabs2" class="tabsDiv">


                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr>
                        <td valign="top" width="160">Order Number</td>
                        <td valign="top" width="20">:</td>
                        <td><input type="text" name=""></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td valign="top">Cancelled Reason</td>
                        <td valign="top">:</td>
                        <td><input type="text" name=""></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td valign="top">Remark</td>
                        <td valign="top">:</td>
                        <td><textarea rows="" cols="" name=""></textarea></td>
                    </tr>
                    <tr><td colspan="3" height="10"></td></tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><button>submit</button></td>
                    </tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function get_size(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL; ?>webpages/productsize/",
            data: 'id=' + id,
            dataType: 'html',
            success: function (msg) {
                $('#size').html(msg);
            }
        });
        get_purity(id);
    }

    $(document).ready(function () {
        $("#add_diamond").click(function () {
            var diamond_count = $('#diamond_count').val();
            var diamond_count_new = parseInt(diamond_count) + 1;
            var append_data = '<table id="diamond_table' + diamond_count + '"><tr>';
            append_data += '<td>SI-IJ</td><td>:</td><td><input type="text" name="dsiij[]" style="width:60px;"></td><td>SI-GH</td><td>:</td><td><input type="text" name="dsigh[]" style="width:60px;"></td><td>VS-GH</td><td>:</td><td><input type="text" name="dvsgh[]" style="width:60px;"></td><td>VVS-EF</td><td>:</td><td><input type="text" name="dvvsef[]" style="width:60px;"></td>';
            append_data += '<td>Setting</td><td>:</td><td>';
            append_data += '<select style="width:100px;" name="dsettings[]" style="width:60px;"><option value="">Select</option>';
            <?php 
            foreach ($type as $new_type) {?>
                 append_data += "<option value='<?php echo $new_type['Settingtype']['settingtype'] ?>'><?php echo $new_type['Settingtype']['settingtype'] ?></option>";
            <?php }?>
            append_data += '</td></tr>';            
            append_data += '<tr><td colspan="15" height="10"></td></tr><tr><td>Shape</td><td>:</td><td>';
            append_data += '<select style="width:100px;" name="dshape[]" style="width:60px;"><option value="">Select</option>';
            <?php 
            foreach ($shapes as $shape) {?>
                 append_data += "<option value='<?php echo $shape['Shape']['shape'] ?>'><?php echo $shape['Shape']['shape'] ?></option>";
            <?php }?>
            append_data += '</td><td>No.of Stone</td><td>:</td><td><input type="text" name="dstonecount[]" style="width:60px;"></td><td>Weight/Carat</td><td>:</td><td><input type="text" name="dweight[]" style="width:60px;"></td><td><button type="button" style="padding:3px 10px; font-size:11px;display:block;" id="remove_diamond" rel="diamond_table' + diamond_count + '">remove</button></td></tr></table>';
            $('#diamond_details').append(append_data);
            $('#diamond_count').val(diamond_count_new);



            return false;
        });
        $("#add_stone").click(function () {
            var stone_count = $('#stone_count').val();
            var stone_count_new = parseInt(stone_count) + 1;
            var append_data = ' <table id="stone_table' + stone_count + '"><tr><td>Stone Name</td><td>:</td>';
            append_data += '<td><select style="width:100px;" name="sname[]" style="width:60px;"><option value="">Select</option>';
            <?php 
            foreach ($gems as $gem) {?>
                 append_data += "<option value='<?php echo $gem['Gemstone']['stone'] ?>'><?php echo $gem['Gemstone']['stone'] ?></option>";
            <?php }?>
            append_data += '</td><td>Shape</td><td>:</td>';
            append_data += '<td><select style="width:100px;" name="sshape[]" style="width:60px;"><option value="">Select</option>';
            <?php 
            foreach ($shapes as $shape) {?>
                 append_data += "<option value='<?php echo $shape['Shape']['shape'] ?>'><?php echo $shape['Shape']['shape'] ?></option>";
            <?php }?>
            append_data += '</td><td>Weight/Carat</td><td>:</td> <td><input type="text" name="sweight[]" style="width:60px;"></td><td>Setting</td><td>:</td>';
            append_data += '<td><select style="width:100px;" name="ssetting[]" style="width:60px;"><option value="">Select</option>';
            <?php 
            foreach ($type as $new_type) {?>
                 append_data += "<option value='<?php echo $new_type['Settingtype']['settingtype'] ?>'><?php echo $new_type['Settingtype']['settingtype'] ?></option>";
            <?php }?>
            append_data += '</td><td>No.of Stone</td><td>:</td><td><input type="text" name="sstonecount[]" style="width:60px;"></td><td><button type="button" style="padding:3px 10px; font-size:11px;display:block" id="remove_stone" rel="stone_table' + stone_count + '">remove</button></td></tr></table>';
            $('#stone_details').append(append_data);
            $('#stone_count').val(stone_count_new);

            return false;
        });
        $('#remove_stone').live('click', function () {
            var id = $(this).attr('rel');
            $("#" + id).remove();
        });
        $('#remove_diamond').live('click', function () {
//alert("saran")		;
            var id = $(this).attr('rel');
            $("#" + id).remove();
        });


        metalid = $("#metalsdiv").val();
        get_color(metalid);
        
        //added by prakash
        $('#metalsdiv').on("change", function () {
            var id = $(this).val();
            get_color(id);
        });

    });

    //added by prakash
    function get_purity(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL; ?>products/metal_weight_dd",
            data: 'id=' + id,
            dataType: 'html',
            success: function (msg) {
                $("#puritytd").html(msg);
            }
        });
    }

    function get_color(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL; ?>products/metalcolor_dd",
            data: 'id=' + id,
            dataType: 'html',
            success: function (data) {
                $("#colorstd").html(data);
            }
        });
    }
    //

    $(document).ready(function () {
        $("#myForm123").validationEngine();
    });

</script>
