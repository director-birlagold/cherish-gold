<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>

    <!--- New HTML Start -->

    <div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
        <div id="" class="tabsDiv">
            <div class="middleContent">
                <h2>Account Dashboard</h2>
                <p> Manage your personal information and track your orders by clicking the sections below. Your Order items are not the same as your cart items(link at the top of this page).
                    The cart is the set of items that have been readied for purchase but have not been paid for. </p>
            </div>
        </div>
        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a  href="<?php echo BASE_URL ?>signin/details"  class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/address_book"  class="ui-tabs-anchor">Address Book</a></li>
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">My Order</a></li>
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/wishlist"  class="ui-tabs-anchor">Wishlist</a></li>
        </ul>
        <div id="tabs-1" class="">
            <p></p>
            <div class="account_details">


                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="myOrder">
                    <tr>
                        <th>Date</th>
                        <th>Product code </th>
                        <th>Order Number</th>
                        <th>Delivery Address</th>
                        <th>Amount</th>
                        <th class="bdrRColor">Order Status</th>
                        <th class="bdrRColor">Track Order</th>
                        <th class="bdrRColor">Download Invoice</th>
                    </tr>
                    <?php
                    if (!empty($order)) {
                        foreach ($order as $order) {
                            $paymentdetails = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));

                            $carts = ClassRegistry::init('Shoppingcart')->find('all', array('conditions' => array('order_id' => $order['Order']['order_id'])));
                            $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $order['Order']['user_id'])));
                            $ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'fields' => array('SUM(total) AS totamount')));
                            ?>
                            <?php
                            if ($user['User']['user_type'] == '0') {
                                if ($order['Order']['cod_status'] == 'PayU') {
                                    $in = 'SGN-ON-';
                                } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {
                                    $in = 'SGN-CHQ/DD-';
                                } elseif ($order['Order']['cod_status'] == 'COD') {
                                    $in = 'SGN-CD-';
                                }
                            } else {
                                if ($order['Order']['cod_status'] == 'PayU') {
                                    $in = 'SGN-FN-';
                                } elseif ($order['Order']['cod_status'] == 'COD') {
                                    $in = 'SGN-FNCD-';
                                } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {
                                    $in = 'SGN-FNCHQ/DD-';
                                }
                            }
                            ?>
                            <tr>
                                <td valign="top"><?php
                                    $date = $order['Order']['created_date'];
                                    echo $dob = date("d/m/Y", strtotime($date));
                                    ?></td>
                                <td valign="top" class="bdrRNone">
                                    <?php
                                    $k = 1;
                                    $ordercart = ClassRegistry::init('Shoppingcart')->find('all', array('conditions' => array('order_id' => $order['Order']['order_id'])));
                                    foreach ($ordercart as $ordercarts) {
                                        $productdetails = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));
                                        $subcat = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $productdetails['Product']['subcategory_id'])));
                                        $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $productdetails['Product']['category_id'])));
                                        $link = BASE_URL.str_replace(' ','_',trim($category['Category']['category']))."/".str_replace(' ','_',trim($subcat['Subcategory']['subcategory']))."/".$productdetails['Product']['product_id']."/".str_replace(' ','_',trim($productdetails['Product']['product_name']));
                                        echo $this->Html->link($category['Category']['category_code'] . ' ' . $productdetails['Product']['product_code'] . "-" . $ordercarts['Shoppingcart']['purity'] . "K" . $ordercarts['Shoppingcart']['clarity'] . $ordercarts['Shoppingcart']['color'], $link).'<br />';
                                    }
//                                    $i = 0;
//                                    foreach ($carts as $carts) {
//                                        if (!empty($carts)) {
//                                            $product = ClassRegistry::init('Product')->find('all', array('conditions' => array('product_id' => $carts['Shoppingcart']['product_id'])));
//                                            foreach ($product as $products) {
//
//                                                $metals = ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'],
//                                                        'type' => 'Purity')));
//                                                $diamond = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'])));
//
//                                                if (!empty($diamond)) {
//                                                    $dc = $diamond['Productdiamond']['clarity'];
//                                                    $dcol = $diamond['Productdiamond']['color'];
//                                                } else {
//                                                    $dc = '';
//                                                    $dcol = '';
//                                                }
//
//                                                $cat = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $products['Product']['category_id'])));
//                                                $subcat = ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' => $products['Product']['subcategory_id'])));
//                                                ?>
<!--                           <a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',trim($cat['Category']['category']))."/".str_replace(' ','_',trim($subcat['Subcategory']['subcategory']))."/".$products['Product']['product_id']."/".str_replace(' ','_',trim($products['Product']['product_name']))?>"> <?php
//                                                    echo $cat['Category']['category_code'] . $products['Product']['product_code'] . ' - ' . $metals['Productmetal']['value'] . 'K' .
//                                                    $dc . $dcol . '<br>';
//                                                    ?></a>-->
                                                <?php
//                                            }
//                                        }
//                                    }
                                    ?>
        <!-- <p align="center"><a href="#"></a></p>
        <a class='inline cancel_order_btn' href="#<?php echo $pays['Paymentdetails']['paymentdetails_id']; ?>">Cancel Order</a>	-->
                                </td>
                                <td valign="top"><?php echo $in . $order['Order']['invoice']; ?>&nbsp;&nbsp;</td>
                                <td valign="top" class="bdrRNone" style="width:30px;">
                                    <?php echo $user['User']['first_name']; ?><?php echo $user['User']['last_name']; ?><br />
                                    <?php echo $order['Order']['shipping_add']; ?><br />
                                    <?php echo $order['Order']['slandmark']; ?>,<?php echo $order['Order']['spincode']; ?><br />
                                    <?php echo $order['Order']['scity']; ?>,<?php echo $order['Order']['sstate']; ?><br />

                                </td>
                                <td valign="top" class="bdrRNone">Rs. <?php
                                    if ($order['Order']['cod_status'] == 'PayU') {
                                        $totamt = $order['Order']['netpayamt'];
                                    } elseif ($order['Order']['cod_status'] == 'COD') {
                                        $totamt = $order['Order']['cod_amount'];
                                    } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {
                                        $totamt = $ordercartamount['0']['totamount'];
                                    }
                                    $totamt-=$order['Order']['discount_amount'];
                                    $totamt+=$order['Order']['shipping_amt'];

                                    echo $totamt;
                                    ?>/-</td>
                                <td valign="top" class="bdrRNone">
                                    <?php
                                    if (!empty($order['Order']['order_status'])) {
                                        $order_sts = $order['Order']['order_status'];
                                    }
                                    if ($order['Order']['cod_status'] == 'PayU') {
                                        if ($order['Order']['order_status'] == 'Pending') {
                                            $order_status = $order_sts;
                                        } else {
                                            $order_status = $order_sts;
                                        }
                                    } elseif ($order['Order']['cod_status'] == 'COD') {
                                        if ($order['Order']['order_status'] == 'Pending') {
                                            $order_status = $order_sts;
                                        } else {
                                            $order_status = $order_sts;
                                        }
                                    } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {


                                        $order_status = $order_sts;
                                    }

//                                    echo $order_status;
                                    //added by prakash - updatable order status
                                    echo $order['Orderstatus']['order_status']
                                    ?>
                                </td>
                                <td style="display:none;">
                                    <div style='display:none'>
                                        <form method="post" name="cancel_order" id="formSubmit">
                                            <div id='<?php echo $order['Order']['order_id']; ?>' style='padding:10px; background:#fff;'>


                                                <div id="tabs2" class="tabsDiv">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                        <tr><td colspan="3">&nbsp;</td></tr>
                                                        <tr>
                                                            <td valign="top" width="160">Order Number</td>
                                                            <td valign="top" width="20">:</td>
                                                            <td><input type="text" name="order" />/td>
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
                                        </form>
                                    </div>
                                </td>
                                <td valign="top">
                                    <?php if(isset($order['Order']['way_bill_no']) && !empty($order['Order']['way_bill_no'])){
										echo $this->Html->link('Track Order', 'javascript:;', array('onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'orders','action'=>'track','?' => array('id' => $order['Order']['way_bill_no'])))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500');  return false;"));
									} ?>
                                </td>
                                <td style="text-align:center">
                                    <?php
                                    if(isset($order['Orderstatus']['order_status']) && in_array($order['Orderstatus']['order_status'], array('Completed', 'Complete', 'Finish', 'Finished'))){
                                        echo $this->Html->link($this->Html->image('pdf.png'), array('controller' => 'orders', 'action' => 'pdf', $order['Order']['order_id']), array('escape' => false, 'title' => 'Download')); 
                                    }else{
                                        echo @$order['Orderstatus']['order_status'];
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' align='center'>NO PRODUCT FOUND</td></tr>";
                    }
                    ?>

                </table>

            </div>
        </div>
    </div>
    <div style="clear:both;">&nbsp;</div>



</body>
</html>