<?php
$orderinvoice = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
$ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount', 'sum(detected_amount) as discountamount', 'sum(total_amount) as originalamount', 'is_coupon_used', 'quantity', 'cart_id')));
$paymentdetail = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
$user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
?>
<table width="100%" cellpadding="0" style="font-size:12px;font-family:Arial,Helvetica,sans-serif">
    <tbody>
        <tr align="left" style="float: left">
            <td colspan="2">
                <?php echo $this->Html->image("icons/logo.png", array('style' => 'float: left; height: 100px; background-repeat: no-repeat'))?>
</td>
</tr>
        <tr align="center">
            <th colspan="2">
    <h2 style="text-decoration:underline">ACKNOWLEDGMENT</h2>
    <br />
    <br />
</th>
</tr>
<tr bgcolor="#016887">
    <th style="text-align:left;padding:10px; color: #D86957">
        <b>Your Order Number: </b><?php echo $in . $orderinvoice['Order']['invoice']; ?></th>
    <th style="padding:10px;text-align:right; color: #D86957">
        Order Placed on:<?php
        $dtt = h($orderdetails['Order']['created_date']);
        $ndtt = date("d-m-Y", strtotime($dtt));
        if (!empty($ndtt))
            echo $ndtt;
        else
            '-';
        ?>
    </th>
</tr>
<tr>
    <td colspan="2">
        <br />
        <p><b>Dear <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?>,</b></p>
        <p>Thank You for placing your order with Shagunn</p>
        <p>Your order has been confirmed and is being processed. Here is the summary of product details:</p>
        <br />
        <br />
    </td>
</tr>
<tr>
    <td colspan="2">
        <b>Order Details:</b></td>
</tr>
<tr>
    <td colspan="2">
        <table border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse">

            <tr>
                <th height="27">S.No</th>
                <th>Product Code</th>
                <th>Product Description</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php
            $k = 1;
            $ordercart = ClassRegistry::init('Shoppingcart')->find('all', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
            $ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount')));
            foreach ($ordercart as $ordercarts) {
                $productdetails = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));
                $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $productdetails['Product']['category_id'])));
                $vendor = ClassRegistry::init('Vendor')->find('first', array('conditions' => array('vendor_id' => $productdetails['Product']['vendor_id'])));
                ?>
                <tr align="center">
                    <td valign="top" style="border:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0);border-left:1px solid rgb(0,0,0)"><?php echo $k++ ?></td>
                    <td valign="top" style="border-bottom:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0)"><?php echo $category['Category']['category_code'] . ' ' . $productdetails['Product']['product_code'] . "-" . $ordercarts['Shoppingcart']['purity'] . "K" . $ordercarts['Shoppingcart']['clarity'] . $ordercarts['Shoppingcart']['color']; ?></td>
                    <td valign="middle" style="border-bottom:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0)">
                        <table width="600" cellspacing="0" cellpadding="4" align="center" style="font-size:13px;border:1px solid rgb(0,0,0)">
                            <tbody>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid rgb(0,0,0)"><?php echo $productdetails['Product']['product_name'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid rgb(0,0,0)">
                                        <table  border="0" style="font-size:13px;border-style:solid solid none;border-color:rgb(0,0,0) rgb(0,0,0) -moz-use-text-color">
                                            <tr>
                                                <td><strong>Size:</strong></td>
                                                <td><?php echo $ordercarts['Shoppingcart']['size'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metals:</strong></td>
                                                <td><?php echo $ordercarts['Shoppingcart']['purity'] ?>K <?php echo $ordercarts['Shoppingcart']['metalcolor'] ?> <?php echo $ordercarts['Shoppingcart']['metal'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metal Weight:</strong></td>
                                                <td><?php echo $ordercarts['Shoppingcart']['weight'] . ' gm'; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                $msg = '';
                                $productdiamond = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'], 'clarity' => $ordercarts['Shoppingcart']['clarity'], 'color' => $ordercarts['Shoppingcart']['color']), 'fields' => array('SUM(noofdiamonds) AS no_diamond', 'SUM(stone_weight) AS sweight')));
                                $productgemstone = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));

                                if ($ordercarts['Shoppingcart']['stoneamount'] > 0) {
                                    ?>
                                    <tr>
                                        <td colspan="4" style="border-bottom:1px solid rgb(0,0,0)">
                                            <table  border="0" style="font-size:13px;border-style:solid solid none;border-color:rgb(0,0,0) rgb(0,0,0) -moz-use-text-color">
                                                <tr>
                                                    <td><strong>Stone:</strong></td>
                                                    <td>Diamond</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Stone Wt:</strong></td>
                                                    <td><?php echo $productdiamond[0]['sweight'] . ' carat'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Quality:</strong></td>
                                                    <td><?php echo $ordercarts['Shoppingcart']['clarity'] . '-' . $ordercarts['Shoppingcart']['color']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Number of Stone:</strong></td>
                                                    <td><?php echo $productdiamond[0]['no_diamond']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php
                                if ($ordercarts['Shoppingcart']['gemstoneamount'] > 0) {
                                    foreach ($productgemstone as $productgemstone) {
                                        ?>
                                        <tr>
                                            <td colspan="4" style="border-bottom:1px solid rgb(0,0,0)">
                                                <table  border="0" style="font-size:13px;border-style:solid solid none;border-color:rgb(0,0,0) rgb(0,0,0) -moz-use-text-color">
                                                    <tr>
                                                        <td><strong>Stone:</strong></td>
                                                        <td><?php echo $productgemstone['Productgemstone']['gemstone'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Stone Wt:</strong></td>
                                                        <td><?php echo $productgemstone['Productgemstone']['stone_weight'] . ' carat'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Number of Stone:</strong></td>
                                                        <td><?php echo $productgemstone['Productgemstone']['no_of_stone']; ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                    <td valign="top" style="border-bottom:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0)"><?php echo $ordercarts['Shoppingcart']['quantity'] ?></td>
                    <td valign="top" style="border-bottom:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0)"><?php echo indian_number_format($ordercarts['Shoppingcart']['total'] * $ordercarts['Shoppingcart']['quantity']) ?></td>
                </tr>
<?php } ?>

        </table>
    </td>
</tr>
<tr>
    <td style="padding:10px;border-left:1px solid rgb(0,0,0);border-right:1px solid rgb(0,0,0);border-bottom:1px solid rgb(0,0,0)"><span>
            <?php
            $shippingdetails = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
            ?>            
            <p>
                <b>Shipping Address :</b></p>
            <p><b><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></b></p>
            <p><?php
                $sbill = h($shippingdetails['Order']['shipping_add']);
                if (!empty($sbill))
                    echo $sbill;
                else
                    '-';
                ?><br />
                <?php
                $sbillland = h($shippingdetails['Order']['slandmark']);
                if (!empty($sbillland))
                    echo $sbillland;
                else
                    '-';
                ?><br />
                <?php
                $sbillcity = h($shippingdetails['Order']['scity']);
                if (!empty($sbillcity))
                    echo $sbillcity;
                else
                    '-';
                ?>
                <?php
                $sbillpin = h($shippingdetails['Order']['spincode']);
                if (!empty($sbillpin))
                    echo '-' . $sbillpin;
                ?><br />
                <?php
                $sbillstate = h($shippingdetails['Order']['sstate']);
                if (!empty($sbillstate))
                    echo $sbillstate;
                else
                    '-';
                ?><br />
            </p>
    </td>
    <td style="padding:10px;border-right:1px solid rgb(0,0,0);border-bottom:1px solid rgb(0,0,0)">
        <table cellpadding="5" border="1" align="center" style="font-size:13px;">
            <tbody>
                <?php
                $cart_amount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
                $Discounthistory = ClassRegistry::init('Discounthistory')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
                if (!empty($Discounthistory)) {
                    $Discount = ClassRegistry::init('Discount')->find('first', array('conditions' => array('discount_id' => $Discounthistory['Discounthistory']['coupon_id'])));
                }
                $netamount = $cart_amount[0]['subtotal'];
                ?>
                <tr>
                    <th>Sub Total Amount</th>
                    <th>Rs. <?php echo indian_number_format($netamount = $cart_amount[0]['subtotal']); ?></th>
                </tr> 
<?php if ($orderdetails['Order']['discount_amount'] > 0) { ?>
                    <tr>
                        <th>Discount Amount</th>
                        <th><?php echo $orderdetails['Order']['discount_amount']; ?></th>
                    </tr> 
                    <?php
                    $netamount-=$orderdetails['Order']['discount_amount'];
                }
                ?>
                <tr>
                    <th>Shipping Charges</th>
                    <th>Rs. <?php echo indian_number_format($orderdetails['Order']['shipping_amt']); ?></th>
                </tr>
<?php $netamount+=$orderdetails['Order']['shipping_amt']; ?>
                <tr>
                    <th>Total Amount</th>
                    <th>Rs. <?php echo indian_number_format($netamount); ?></th>
                </tr>
                <?php
                if (($orderdetails['Order']['cod_status'] == 'PayU') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                    $paid = isset($paymentdetail['Paymentdetails']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
                } elseif (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                    $paid = $paymentdetail['Paymentdetails']['amount'];
                    $balance = $netamount - $orderdetails['Order']['cod_amount'];
                } elseif (($orderdetails['Order']['cod_status'] == 'CHQ/DD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                    $paid = $paymentdetail['Paymentdetails']['amount'];
                }
                ?>
                <tr>
                    <th>Amount Paid</th>
                    <td>
                        <?php
                        if (!empty($paid)) {
                            echo 'Rs. ' . $paid;
                        } else
                            echo 'Nil';
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Balance Payable Amount</th>
                    <th><?php
                        $total_paid_amount = isset($paymentdetail['Paymentdetails']['amount']) ? h($paymentdetail['Paymentdetails']['amount']) : 0;
                        $pending_amount = $netamount - $total_paid_amount;
                        if (!empty($pending_amount)) {
                            echo 'Rs. ' . indian_number_format($pending_amount);
                        } else {
                            echo '-';
                        }
                        ?></th>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2">
        <br />
        <p>
            <b>We will send you an Email and SMS the moment your order items are dispatched to your address.</b></p>
        <p>
            You can visit <a target="_blank" href="http://cherishgold.com/">share order status link</a> to view your order status and to contact us regarding this order.</p>
        <p>
            Should you find the details of the order incorrect, please feel free to call us at 1800 102 2066 or email us at <a target="_blank" href="http://cherishgold.com/">customer.service@shagunn.in</a></p>
        <p style="color:rgb(1,104,135)">
            <b>Note: Post shipment, the delivery of your item(s) will take anywhere between 4 to 7 days depending on the location being served.</b></p>
    </td>
</tr>
<tr>
    <td style="line-height:0.5" colspan="2">
        <br />
        <p>Regarts</p>
        <p>Team Shagunn</p>
    </td>
</tr>
</tbody>
</table>