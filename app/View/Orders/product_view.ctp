<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>

    <!--- New HTML Start -->

    <div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
        <div id="" class="tabsDiv">
            <div class="middleContent">
                <h2>View Order</h2>
                <?php
                if ($user['User']['user_type'] == '0') {
                    if ($orderdetails['Order']['cod_status'] == 'PayU') {
                        $in = 'SGN-ON-';
                        $paymentmode = 'Full Payment';
                    } elseif ($orderdetails['Order']['cod_status'] == 'CHQ/DD') {
                        $in = 'SGN-CHQ/DD-';
                        $paymentmode = 'CHQ/DD';
                    } elseif ($orderdetails['Order']['cod_status'] == 'COD') {
                        $in = 'SGN-CD-';
                        $paymentmode = 'Partial Payment';
                    }
                } else {
                    if ($orderdetails['Order']['cod_status'] == 'PayU') {
                        $in = 'SGN-FN-';
                        $paymentmode = 'Full Payment';
                    } elseif ($orderdetails['Order']['cod_status'] == 'COD') {
                        $in = 'SGN-FNCD-';
                        $paymentmode = 'Partial Payment ';
                    } elseif ($orderdetails['Order']['cod_status'] == 'CHQ/DD') {
                        $in = 'SGN-FNCHQ/DD-';
                        $paymentmode = 'CHQ/DD';
                    }
                }
                ?>
                <p> Order No: <strong><?php echo $in . $orderdetails['Order']['invoice']; ?></strong></p>
            </div>
        </div>
        <?php echo $this->Element('vendor_order_header'); ?></td>

        <div id="tabs-1" class="">
            <p></p>
            <div class="account_details" id="account_details">
                <div align="right" style="padding:10px 0;"><?php echo $this->Html->link('Back to User Orders', array('controller' => 'vendors', 'action' => 'user_orders'), array('class' => 'button')); ?></div>   
                <?php $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id']))); ?>

                <h2>Product details</h2>
                <div style="float:left; width:100%;">
                    <table cellpadding="0" cellspacing="0" class="myOrder" width="100%">
                        <thead>
                            <tr>
                                <th width="30" align="center"><?php echo __('#'); ?></th>   

                                <th  width="600"align="left">Product Details</th>
                                <!--<th width="300" align="left">Vendor Details </th>
                                -->          <th width="50" align="left">Quantity </th>
                                <!--<th width="50" align="left">Price </th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $k = 1;
                            $ordercart = ClassRegistry::init('Shoppingcart')->find('all', array(
                                'conditions' => array(
                                    'order_id' => $orderdetails['Order']['order_id'],
                                    'product_id' => $product_ids
                            )));
                            $ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount')));
                            foreach ($ordercart as $ordercarts) {
                                $productdetails = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));
                                $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $productdetails['Product']['category_id'])));
                                $vendor = ClassRegistry::init('Vendor')->find('first', array('conditions' => array('vendor_id' => $productdetails['Product']['vendor_id'])));
                                ?>
                                <tr>
                                    <td align="center" valign="top"><?php echo ($k); ?></td>	
                                    <td  width="600" align="left">
                                        <table width="600px">
                                            <tr style="padding-bottom:10px;">
                                                <td width="150px" valign="top">
                                                    <?php $images = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $productdetails['Product']['product_id'], 'status' => 'Active'))); ?>
                                                    <?php //$link=BASE_URL.'img/product/home/'.$images['Productimage']['imagename']; ?>
                                                    <?php
                                                    $image = $images['Productimage']['imagename'];
                                                    echo $this->Html->image('product/small/' . $images['Productimage']['imagename'], array("alt" => "Image", 'width' => '120', 'height' => '90'));
                                                    ?>
                                                </td>

                                                <td  width="450px" > <dt><label for="name">Product Name </label></dt><dd> <p><?php echo $productdetails['Product']['product_name'] ?>  </p></dd> 
                                            <dt><label for="name">Product Code </label></dt><dd> <p><?php echo $category['Category']['category_code'] . ' ' . $productdetails['Product']['product_code'] . "-" . $ordercarts['Shoppingcart']['purity'] . "K" . $ordercarts['Shoppingcart']['clarity'] . $ordercarts['Shoppingcart']['color']; ?>  </p></dd>



                                    </td>
                                </tr>
                                <tr>
                                    <td width="600" colspan="2">
                                        <table width="600">
                                            <tr><th colspan="2"><strong>Metal Details</strong></th></tr>
                                            <tr><td width="300px">
                                                    <table width="300px">
                                                        <tr><td width="100"><strong>Metal</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['metal'] ?></strong></p></td></tr>
                                                        <tr><td ><strong>Metal Color</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['metalcolor'] ?></strong></p></td></tr>
                                                        <tr><td ><strong>Purity</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['purity'] ?>K</strong></p></td></tr>
                                                    </table>    
                                                </td>
                                                <td valign="top">
                                                    <table width="300px">
                                                        <tr><td width="100"><strong>Size</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['size'] ?></strong></p></td></tr>
                                                        <tr><td ><strong>Metal Weight</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['weight'] . ' gm'; ?></strong></p></td></tr>
                                                    </table>   
                                                </td></tr>
                                        </table>      
                                    </td>
                                </tr>

                                <?php
                                $stone_details = ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('clarity' => $ordercarts['Shoppingcart']['clarity'], 'color' => $ordercarts['Shoppingcart']['color'], 'product_id' => $productdetails['Product']['product_id'])));

                                if (!empty($stone_details)) {
                                    ?>
                                    <tr>
                                        <td width="600" colspan="4">

                                            <?php
                                            $sd_clarity = '<tr><td width="70">Clarity</td>';
                                            $sd_color = '<tr><td>Color</td>';
                                            $sd_nostones = '<tr><td>No.of Stones</td>';
                                            $sd_weight = '<tr><td>Weight</td>';
                                            $sd_shape = '<tr><td>Shape</td>';
                                            $sd_setting_type = '<tr><td>Setting Type</td>';
                                            //$i=1;
                                            foreach ($stone_details as $stone_detail) {
                                                $sd_clarity.='<td class="widthtd">' . $stone_detail['Productdiamond']['clarity'] . '</td>';
                                                $sd_color.='<td class="widthtd">' . $stone_detail['Productdiamond']['color'] . '</td>';
                                                $sd_nostones.='<td class="widthtd">' . $stone_detail['Productdiamond']['noofdiamonds'] . '</td>';
                                                $sd_weight.='<td class="widthtd">' . $stone_detail['Productdiamond']['stone_weight'] . '</td>';
                                                $sd_shape.='<td class="widthtd">' . $stone_detail['Productdiamond']['shape'] . '</td>';
                                                $sd_setting_type.='<td class="widthtd">' . $stone_detail['Productdiamond']['settingtype'] . '</td>';
                                                //$i++;
                                            }
                                            $sd_clarity.='</tr>';
                                            $sd_color.='</tr>';
                                            $sd_shape.='</tr>';
                                            $sd_setting_type.='</tr>';
                                            $sd_nostones.='</tr>';
                                            $sd_weight.='</tr>';
                                            $stonehtml = '<p><strong><b>Diamonds Details</b></strong></p>';
                                            //$stonehtml.=(($i>3)?('<div style="overflow-x:scroll;overflow:y:hidden; width:530px;">'):'');
                                            $stonehtml.='<table cellpadding="0" cellspacing="0" border="0" width="600">
     ' . $sd_clarity . $sd_color . $sd_nostones . $sd_weight . $sd_shape . $sd_setting_type . '	 
     </table>';
                                            //$stonehtml.=(($i>3)?('</div>'):'');colspan="'.$i.'"	
                                            $stonehtml.='<table >
	<tr><td >&nbsp;</td></tr></table>';
                                            echo $stonehtml;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    
                                }
                                ?>






                                <?php
                                $gemstone_details = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id'])));
                                if (!empty($gemstone_details)) {
                                    ?>
                                    <tr>
                                        <td width="600" colspan="2">
                                            <?php
                                            $sd_clarity1 = '<tr><td width="70">Gemstone</td>';
                                            $sd_color1 = '<tr><td>Size</td>';
                                            $sd_nostones1 = '<tr><td>No.of Stones</td>';
                                            $sd_weight1 = '<tr><td>Weight</td>';
                                            $sd_shape1 = '<tr><td>Shape</td>';
                                            $sd_setting_type1 = '<tr><td>Setting Type</td>';
                                            $i = 1;
                                            foreach ($gemstone_details as $gemstone_details) {
                                                $sd_clarity1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['gemstone'] . '</td>';
                                                $sd_color1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['size'] . '</td>';
                                                $sd_nostones1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['no_of_stone'] . '</td>';
                                                $sd_weight1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['stone_weight'] . '</td>';
                                                $sd_shape1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['shape'] . '</td>';
                                                $sd_setting_type1.='<td class="widthtd">' . $gemstone_details['Productgemstone']['settingtype'] . '</td>';
                                                $i++;
                                            }
                                            $sd_clarity1.='</tr>';
                                            $sd_color1.='</tr>';
                                            $sd_shape1.='</tr>';
                                            $sd_setting_type1.='</tr>';
                                            $sd_nostones1.='</tr>';
                                            $sd_weight1.='</tr>';
                                            $stonehtml1 = '<p><strong><b>Gemstone Details</b></strong></p>';
                                            $stonehtml1.=(($i > 3) ? ('<div style="overflow-x:scroll;overflow:y:hidden; width:600px;">') : '');
                                            $stonehtml1.='<table cellpadding="0" cellspacing="0" border="0" width="600">
     ' . $sd_clarity1 . $sd_color1 . $sd_nostones1 . $sd_weight1 . $sd_shape1 . $sd_setting_type1 . '	 
     </table>';
                                            $stonehtml1.=(($i > 3) ? ('</div>') : '');
                                            $stonehtml1.='<table >
	<tr><td colspan="' . $i . '">&nbsp;</td></tr></table>';
                                            echo $stonehtml1;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    
                                }
                                ?>


<!--                                <tr>
                                    <td width="600" colspan="2">
                                        <table width="600">
                                            <tr><th colspan="2"><strong>Price Details</strong></th></tr>
                                            <tr><td  width="300px" valign="top">
                                                    <table width="300px">
                                                        <tr><td width="150"><strong>Metal Rate</strong></td><td><p>Rs.<?php
                                                                    echo round($ordercarts['Shoppingcart']['goldprice'] * ($ordercarts['Shoppingcart']['purity'] / 24)) . '/gm';
                                                                    ?></strong></p></td></tr>
                                                        <?php if (!empty($ordercarts['Shoppingcart']['stoneprice'])) { ?>
                                                            <tr><td ><strong>Diamond  Rate</strong></td><td><pRs.><?php echo $ordercarts['Shoppingcart']['stoneprice'] ?></strong></p></td></tr>
                                                            <?php } ?>
                                                            <?php if (!empty($ordercarts['Shoppingcart']['gemprice'])) { ?>
                                                                <tr><td ><strong>Gemstone Rate</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['gemprice'] ?></strong></p></td></tr>
                                                            <?php } ?>
                                                            <tr><td ><strong>Making Charge (%)</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['making_per'] ?></strong></p></td></tr>
                                                            <tr><td ><strong>Vat (%)</strong></td><td><p><?php echo $ordercarts['Shoppingcart']['vat_per'] ?></strong></p></td></tr>
                                                    </table>   
                                                </td>
                                                <td  width="300px" valign="top">
                                                    <table width="300px">
                                                        <tr><td width="150"><strong>Metal Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['goldamount'] ?></p></td></tr>
                                                        <?php if (!empty($ordercarts['Shoppingcart']['stoneamount'])) { ?>
                                                            <tr><td ><strong>Diamond Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['stoneamount']; ?></strong></p></td></tr>
                                                        <?php } ?>
                                                        <?php if (!empty($ordercarts['Shoppingcart']['gemstoneamount'])) { ?>
                                                            <tr><td ><strong>Gemstone Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['gemstoneamount']; ?></strong></p></td></tr>
                                                        <?php } ?>
                                                        <tr><td ><strong>Making Charge Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['making_charge']; ?></strong></p></td></tr>
                                                        <tr><td ><strong>Vat  Value</strong></td><td><p>Rs.<?php echo $ordercarts['Shoppingcart']['vat']; ?></strong></p></td></tr>
                                                        <tr><td ><strong>Total Amount</strong></td><td><p>Rs.<?php echo indian_number_format($ordercarts['Shoppingcart']['total']); ?></strong></p></td></tr>
                                                    </table>   
                                                </td>


                                            </tr>
                                        </table>
                                    </td></tr>-->

                        </table>
                        </td>
                       <!--<td  width="300"align="left " valign="top">
                       <table width="300" >
                        <?php $vendoroff = classRegistry::init('Vendorcontact')->find('first', array('conditions' => array('vendor_id' => $vendor['Vendor']['vendor_id']))); ?>
                       <tr><td width="100" valign="top"><strong>Vendor Code</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['vendor_code']; ?></p></td></tr>
                        <tr><td width="100" valign="top"><strong>Company</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['Company_name']; ?> </p></td></tr>
                         <tr><td width="100" valign="top"><strong>Phone No(1)</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['reg_phone']; ?> </p></td></tr>
                          <tr><td width="100" valign="top"><strong>Mobile</strong></td><td width="200" valign="top"><p><?php echo $vendor['Vendor']['reg_mobile']; ?> </p></td></tr>
                           <tr><td width="100" valign="top"><strong>Email</strong></td><td width="200" valign="top"><p><?php echo $vendoroff['Vendorcontact']['email']; ?></p></td></tr>
                                  
                       </table>
                              
                        </td>-->
                        <td   width="50"align="left " valign="top"><?php echo $ordercarts['Shoppingcart']['quantity'] ?>  </td>
                        <!--<td   width="50"align="left "valign="top"><span>Rs.</span><?php echo indian_number_format($ordercarts['Shoppingcart']['total'] * $ordercarts['Shoppingcart']['quantity']) ?> </td>-->
                        </tr>
                        <?php
                        $k++;
                    }
                    ?>
                    </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div style="clear:both;">&nbsp;</div>


    <style type="text/css">
        .myOrder table {
            border-top: 1px solid #e0e0e0;
        }
    </style>
</body>
</html>

