<div id="content" class="clearfix">
    <div class="container">
        <div class="mainheading">
            <div class="btnlink"><?php echo $this->Html->link(__('+Add Price'), array('action' => 'add'), array('class' => 'button')); ?></div>
            <div class="titletag">
                <h1>Price Details</h1>
            </div>
        </div>
        <div class="tablefooter clearfix">
            <?php echo $this->Form->create(null, array(
                'type'=>'get',
                'url' => array('page'=>'1'), 
                'name' => 'searchfilters', 
                'id'=> 'myForm1',
                'style' => 'width:800px;float:left;padding: 5px 10px;'
                ));?>
                <table cellpadding="0" cellspacing="2">
                    <tr>
                        <td><strong><?php echo __('Type'); ?> : </strong>&nbsp;</td>
                        <td><input type="radio" id="checklist" class="validate[required] radio metal" name="searchtype" value="Metals" <?php
                            if (isset($_REQUEST['searchtype']) && $_REQUEST['searchtype'] == 'Metals') {
                                echo 'checked';
                            }
                            ?> />Metal&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="checklist" class="validate[required] radio stone" name="searchtype" value="Stone" <?php
                            if (isset($_REQUEST['searchtype']) && $_REQUEST['searchtype'] == 'Stone') {
                                echo 'checked';
                            }
                            ?> />Diamond&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="checklist" class="validate[required] radio gemstone" name="searchtype" value="Gemstone" <?php
                            if (isset($_REQUEST['searchtype']) && $_REQUEST['searchtype'] == 'Gemstone') {
                                echo 'checked';
                            }
                            ?> />Gemstone&nbsp;&nbsp;&nbsp;

                        </td> 

                        <td><strong><?php echo __('Name'); ?> : </strong>&nbsp;</td>
                        <td><select name="searchname" id="searchname">
                                <option value="">Select</option>

                            </select></td><td>&nbsp;</td>

                        <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search'); ?>" /></td>
                        <td>&nbsp;</td><td>
                            <?php
                            if (isset($_REQUEST['searchfilter'])) {
                                echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'button small', 'style' => 'padding:3px 5px;', 'title' => 'Cancel Search'));
                            }
                            ?></td>
                    </tr></table><?php echo $this->Form->end()?>
        </div>
        <?php echo $this->Form->create('', array('Controller' => 'prices', 'action' => 'delete', 'id' => 'myForm')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
            <thead>
                <tr>
                    <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]"  class="validate[minCheckbox[1]] checkbox"  value="0"  />'); ?></th>
                    <th width="30" align="center"><?php echo __('#'); ?></th>
                    <th align="left"><?php echo __('Type', 'Type'); ?></th>
                    <th align="left"><?php echo __('Metal', 'Metal'); ?></th>
                    <th align="left" ><?php echo __('Karat/Clarity/Shape/Fineness'); ?></th>
                    <th align="left"><?php echo __('Color', 'Color') ?></th>
                    <!--<th align="left"><?php echo __('Metal Fineness', 'Metal Fineness') ?></th>-->
                    <th align="left" width="100"><?php echo __('Price'); ?></th>
                    <th align="left" width="100"><?php echo __('Status'); ?></th>
                   <!-- <th align="center" width="100"><?php //echo __('Action');  ?></th>-->
                    <th width="30" align="center">Edit</th>
                    <th width="30" align="center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($price))
                    echo '<tr><td colspan="7" align="center">' . __('No records found') . '</td></tr>';
                else {
                    $i = $this->Paginator->counter('{:start}');
                    foreach ($price as $price):

                        $metals = ClassRegistry::init('Metal')->find('first', array('conditions' => array('metal_id' => $price['Price']['metal_id'])));
                        $diamond = ClassRegistry::init('Diamond')->find('first', array('conditions' => array('diamond_id' => $price['Price']['diamond_id'])));
                        $clarity = ClassRegistry::init('Clarity')->find('first', array('conditions' => array('clarity_id' => $price['Price']['clarity_id'])));
                        $gemstone = ClassRegistry::init('Gemstone')->find('first', array('conditions' => array('gemstone_id' => $price['Price']['gemstone_id'])));
                        $shape = ClassRegistry::init('Shape')->find('first', array('conditions' => array('shape_id' => $price['Price']['gemstoneshape'])));
                        //print_r($diamond);exit;
                        ?>
                        <tr>
                            <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($price['Price']['price_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
                            <td align="center"><?php echo h($i); ?></td>

                            <td align="left"><?php
                                if ($price['Price']['type'] == 'Metals') {
                                    echo $price['Price']['type'];
                                } elseif ($price['Price']['type'] == 'Stone') {
                                    echo 'Diamond';
                                } elseif ($price['Price']['type'] == 'Gemstone') {
                                    echo $price['Price']['type'];
                                }
                                ?> &nbsp;</td>

                            <td align="left"><?php
                                if ($price['Price']['type'] == 'Metals') {
                                    echo $metals['Metal']['metal_name'];
                                } elseif ($price['Price']['type'] == 'Stone') {
                                    echo $diamond['Diamond']['name'];
                                } elseif ($price['Price']['type'] == 'Gemstone') {
                                    echo $gemstone['Gemstone']['stone'];
                                }
                                ?></td>
                            <td align="left">
                                <?php
                                if ($price['Price']['type'] == 'Metals') {
                                    echo '24 K';
                                    echo $price['Price']['metal_fineness'] != 0 ? " ({$price['Price']['metal_fineness']})" : '';
                                } elseif ($price['Price']['type'] == 'Stone') {

                                    echo $clarity['Clarity']['clarity'];
                                } elseif ($price['Price']['type'] == 'Gemstone') {

                                    echo $shape['Shape']['shape'];
                                }
                                ?>

                            </td>
                            <td align="left"><?php
                                if ($price['Price']['type'] == 'Metals') {
                                    $color = ClassRegistry::init('Metalcolor')->find('first', array('conditions' => array('metalcolor_id' => $price['Price']['metalcolor_id'])));
                                    echo $color['Metalcolor']['metalcolor'];
                                } elseif ($price['Price']['type'] == 'Stone') {
                                    $diamondcolor = ClassRegistry::init('Color')->find('first', array('conditions' => array('color_id' => $price['Price']['color_id'])));
                                    echo $diamondcolor['Color']['color'];
                                } elseif ($price['Price']['type'] == 'Gemstone') {
                                    echo '-';
                                }
                                ?></td>

                            <td align="left"><?php echo $price['Price']['price']; ?></td>

                            <td align="left"><?php echo $price['Price']['status']; ?></td>

                                <!--  <td align="center"><?php /* echo h($price['Price']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$price['Price']['price_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$price['Price']['price_id'],'Active')); */ ?></td>-->

                            <td align="center"><?php echo $this->Html->image('icons/edit.png', array('url' => array('action' => 'add', $price['Price']['price_id']), 'border' => 0, 'alt' => __('Edit'))); ?></td>
                            <td align="center"><?php echo $this->Html->image('icons/cross.png', array('url' => array('action' => 'delete', $price['Price']['price_id']), 'border' => 0, 'class' => 'confirdel', 'alt' => __('Delete'))); ?></td>

                        </tr>

                        <?php
                        $i++;
                    endforeach;
                }
                ?>
            </tbody>
        </table>
        <div class="tablefooter clearfix">
            <div class="actions">
                <input type="submit" id="action_btn"  class="button small" value="Delete"  />
            </div>
            <div class="pagination">
                <div class="pagenumber">
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page') . ' {:page} ' . __('of') . ' {:pages}, ' . __('showing') . ' {:current} ' . __('records out of') . ' {:count} ' . __('total')
                    ));
                    ?>
                </div>
                <div class="paging">
                    <?php
                    echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next'), array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?> </div>
</div>
<script>
    $(document).ready(function () {
        $('.metal').click(function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>prices/metal_type/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='searchname' class='searchname' id='searchname'><option value=''>Select</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Metal.metal_id + "' '>" + v.Metal.metal_name + " </option>";
                    });
                    appenddata += "</select>";
                    $('#searchname').html(appenddata);
                    $('#searchname').parents('.selector').find('span').html('select');

                }
            });

        });


    });


</script>
<script>
    $(document).ready(function () {
        $('.stone').click(function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>prices/stone_types/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='searchname' class='searchname' id='searchname'><option value=''>Select</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Diamond.diamond_id + "' '>" + v.Diamond.name + " </option>";
                    });
                    appenddata += "</select>";
                    $('#searchname').html(appenddata);
                    $('#searchname').parents('.selector').find('span').html('select');

                }
            });

        });


    });


</script>

<script>
    $(document).ready(function () {
        $('.gemstone').click(function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>prices/gemstone_types/",
                data: 'id=' + id,
                dataType: 'json',
                success: function (data) {
                    appenddata = "<select name='searchname' class='searchname' id='searchname'><option value=''>Select</option>";
                    $.each(data, function (k, v) {
                        appenddata += "<option value = '" + v.Gemstone.gemstone_id + "' '>" + v.Gemstone.stone + " </option>";
                    });
                    appenddata += "</select>";
                    $('#searchname').html(appenddata);
                    $('#searchname').parents('.selector').find('span').html('select');

                }
            });

        });


    });


</script>
