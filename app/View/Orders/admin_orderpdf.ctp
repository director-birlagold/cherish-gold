<?php
$orderinvoice = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
$ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount', 'sum(detected_amount) as discountamount', 'sum(total_amount) as originalamount', 'is_coupon_used', 'quantity', 'cart_id')));
$paymentdetail = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
$user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
$dtt = h($orderdetails['Order']['created_date']);
$ndtt = date("d-M-Y", strtotime($dtt));
if (empty($ndtt))
    $ndtt = '-';
$shippingdetails = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
$alphas = range('A', 'Z');
$paymentmode = '';
if ($orderdetails['Order']['cod_status'] == 'PayU') {
    $paymentmode = 'Full Payment';
} elseif ($orderdetails['Order']['cod_status'] == 'COD') {
    $paymentmode = 'CHQ/DD';
} elseif ($orderdetails['Order']['cod_status'] == 'CHQ/DD') {
    $paymentmode = 'Partial Payment';
}
$cart_amount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
?>
<style>
    /**** Common Style *****/

    div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
        margin: 0;
        padding: 0;
    }
    html, body {
        font-size: 15px;
        text-align: left;
        color: #373435;
        font-family: Arial, Helvetica, sans-serif;
        direction: ltr;
        font-weight: normal;
        margin: 0;
        padding: 0px 0 0 0;
        background: #fff;
    }

/*    table {
        border-collapse: collapse;
    }*/

    td {
        padding-top: .15em;
        padding-bottom: .15em;
    }
</style>
<div style="width:900px; padding:10px; margin:0 auto;">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td width="200"><?php echo $this->Html->image("icons/logo_small.png", array('style' => 'float: left; width: 35mm; height: 35mm; background-repeat: no-repeat')) ?></td>
            <td width="200">&nbsp;</td>
            <td valign="middle"> Birla Gold and Precious Metals Ltd<br />
                Morya Landmark II, 2nd Floor 202,<br />
                New Link Road, Andheri (West)<br />
                Mumbai 400 053 </td>
        </tr>
        <tr>
            <td align="center" colspan="3"><span style="font-size:18px; font-weight:bold;">TAX INVOICE</span> <br />
                Inoive No: #<?php echo $orderinvoice['Order']['org_invoice']; ?></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="border-top:1px solid #000;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" width="270">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="90">Order No.</td>
                        <td width="20">:</td>
                        <td><?php echo $in . $orderinvoice['Order']['invoice']; ?></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td>:</td>
                        <td><?php echo $ndtt; ?></td>
                    </tr>
                    <tr>
                        <td>Invoice Date</td>
                        <td>:</td>
                        <td><?php echo $ndtt; ?></td>
                    </tr>
                    <tr>
                        <td>VAT/TIN</td>
                        <td>:</td>
                        <td>27515278165V</td>
                    </tr>
                    <tr>
                        <td>CST No.</td>
                        <td>:</td>
                        <td>27515278165C</td>
                    </tr>
                    <tr>
                        <td>Service Tax</td>
                        <td>:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>CIN</td>
                        <td>:</td>
                        <td>U51900MH2001PLC133454</td>
                    </tr>
                </table>
            </td>
            <td valign="top" width="250"><strong>Billing Address</strong> <br />
                <?php
                $firstname = h($user['User']['first_name']);
                if (!empty($firstname))
                    echo $firstname;
                else
                    '-';
                $lastname = h($user['User']['last_name']);
                if (!empty($lastname))
                    echo $lastname;
                else
                    '-';
                ?> <br />
                <?php
                $sbill = h($shippingdetails['Order']['billing_add']);
                if (!empty($sbill))
                    echo "$sbill";
                else
                    '-';
                ?> <br />
                <?php
                $sbillland = h($shippingdetails['Order']['blandmark']);
                if (!empty($sbillland))
                    echo $sbillland;
                else
                    '-';
                ?> <br />
                <?php
                $sbillcity = h($shippingdetails['Order']['city']);
                if (!empty($sbillcity))
                    echo $sbillcity . ' - ';
                else
                    '-';
                $sbillpin = h($shippingdetails['Order']['pincode']);
                if (!empty($sbillpin))
                    echo $sbillpin;
                ?>, <br />
                <?php
                $sbillstate = h($shippingdetails['Order']['state']);
                if (!empty($sbillstate))
                    echo $sbillstate;
                else
                    '-';
                ?> <br />
            </td>
            <td valign="top" width="240"><strong>Shipping Address</strong> <br />
                <?php
                $firstname = h($user['User']['first_name']);
                if (!empty($firstname))
                    echo $firstname;
                else
                    '-';
                $lastname = h($user['User']['last_name']);
                if (!empty($lastname))
                    echo $lastname;
                else
                    '-';
                ?> <br />
                <?php
                $sbill = h($shippingdetails['Order']['shipping_add']);
                if (!empty($sbill))
                    echo "$sbill";
                else
                    '-';
                ?><br />
                <?php
                $sbillland = h($shippingdetails['Order']['slandmark']);
                if (!empty($sbillland))
                    echo $sbillland;
                else
                    '-';
                ?>,<br />
                <?php
                $sbillcity = h($shippingdetails['Order']['scity']);
                if (!empty($sbillcity))
                    echo $sbillcity . ' - ';
                else
                    '-';
                $sbillpin = h($shippingdetails['Order']['spincode']);
                if (!empty($sbillpin))
                    echo $sbillpin;
                ?>,<br />
                <?php
                $sbillstate = h($shippingdetails['Order']['sstate']);
                if (!empty($sbillstate))
                    echo $sbillstate;
                else
                    '-';
                ?><br />
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="border-top:1px solid #000;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="10" border="0" width="100%">
        <tr>
            <td align="center" width="200" style="border:1px solid #000; border-right:0px; padding:6px; background-color: #EFEFEF"><strong>Product Description</strong></td>
            <td style="border:1px solid #000; border-right:0px; padding:6px; background-color: #EFEFEF" colspan="2" align="center"><strong>Metals Details</strong></td>
            <td style="border:1px solid #000; border-right:0px; padding:6px; background-color: #EFEFEF" colspan="2" align="center"><strong>Diamond Details</strong></td>
            <td style="border:1px solid #000; border-right:0px; padding:6px; background-color: #EFEFEF" colspan="2" align="center"><strong>Stone Details</strong></td>
            <td style="border:1px solid #000; border-right:0px; padding:6px; background-color: #EFEFEF" align="center"><strong>Quantity</strong></td>
            <td style="border:1px solid #000; padding:6px; background-color: #EFEFEF" colspan="3" align="center"><strong>Product Price</strong></td>
        </tr>
        <?php
        $k = 1;
        $ordercart = ClassRegistry::init('Shoppingcart')->find('all', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));

        $net_product_amount = 0;
        $order_count = count($ordercart);
        foreach ($ordercart as $o_key => $ordercarts) {
            $productdetails = ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' => $ordercarts['Shoppingcart']['product_id'])));
            $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $productdetails['Product']['category_id'])));
            $vendor = ClassRegistry::init('Vendor')->find('first', array('conditions' => array('vendor_id' => $productdetails['Product']['vendor_id'])));

            $stone_wght = $gem_wght = 0;
            $gem_names = '';
            $stone_details = ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('clarity' => $ordercarts['Shoppingcart']['clarity'], 'color' => $ordercarts['Shoppingcart']['color'], 'product_id' => $productdetails['Product']['product_id'])));
            $gemstone_details = ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array('product_id' => $productdetails['Product']['product_id'])));

            foreach ($stone_details as $stone_detail) {
                $stone_wght += $stone_detail['Productdiamond']['stone_weight'];
            }

            foreach ($gemstone_details as $key => $gemstone_details) {
                $gem_wght += $gemstone_details['Productgemstone']['stone_weight'];
                $gem_names = $key == 0 ? "{$gemstone_details['Productgemstone']['gemstone']}" : ", {$gemstone_details['Productgemstone']['gemstone']}";
            }

            $product_name = $productdetails['Product']['product_name'];
            $product_name .= " {$ordercarts['Shoppingcart']['purity']}K Gold";
            $product_name .= $stone_wght > 0 ? " With Diamond" : "";
            $product_name .= ($ordercarts['Shoppingcart']['clarity'] != '' || $ordercarts['Shoppingcart']['color'] != '') ? " {$ordercarts['Shoppingcart']['clarity']}-{$ordercarts['Shoppingcart']['color']}" : "";
            $product_name .= $gem_names != '' ? " & {$gem_names}" : "";
            ?>
            <tr>
                <?php if ($o_key == 0) { ?>
                    <td style="border:1px solid #000; border-right:0px; border-bottom:0px; border-top:0px; padding:6px;" align="center"><?php echo $product_name ?></td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Weight</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Amount</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Weight</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Amount</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Weight</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">Amount</td>
                    <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;">&nbsp;</td>
                    <td style="border:1px solid #000; border-top:0px; padding:6px;">&nbsp;</td>
                <?php } ?>
            </tr>
            <tr>
                <?php if ($o_key == 0) { ?>
                    <td style="border:1px solid #000; border-right:0px; border-bottom:0px; border-top:0px; padding:6px;" align="center"></td>
                <?php } else { ?>
                    <td style="border:1px solid #000; border-right:0px; border-bottom:0px; border-top:0px; padding:6px;" align="center"><?php echo $product_name ?></td>
                <?php } ?>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $ordercarts['Shoppingcart']['weight']; ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $ordercarts['Shoppingcart']['goldamount'] != 0 ? indian_number_format($ordercarts['Shoppingcart']['goldamount']) : '-' ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $stone_wght != 0 ? $stone_wght : '-' ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $ordercarts['Shoppingcart']['stoneamount'] != 0 ? indian_number_format($ordercarts['Shoppingcart']['stoneamount']) : '-'; ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $gem_wght != 0 ? $gem_wght : '-'; ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $ordercarts['Shoppingcart']['gemstoneamount'] != 0 ? indian_number_format($ordercarts['Shoppingcart']['gemstoneamount']) : '-'; ?></td>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"><?php echo $ordercarts['Shoppingcart']['quantity'] ?></td>
                <?php $gold_amt = $ordercarts['Shoppingcart']['goldamount'] + $ordercarts['Shoppingcart']['stoneamount'] + $ordercarts['Shoppingcart']['gemstoneamount'] ?>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><?php echo $gold_amt != 0 ? indian_number_format($gold_amt) : '-' ?></td>
            </tr>
    <!--            <tr>
                <td style="border:1px solid #000; border-right:0px; border-bottom:0px; border-top:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" colspan="7"></td>
                <td style="border:1px solid #000; border-top:0px; padding:6px;"></td>
            </tr>-->
            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; border-bottom:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7">Discount Amount</td>
                <?php $discount_amount = $ordercarts['Shoppingcart']['detected_amount'] == '' ? 0 : $ordercarts['Shoppingcart']['detected_amount']; ?>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><?php echo $discount_amount != 0 ? indian_number_format($discount_amount) : '-' ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; border-bottom:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7">Making Charge</td>
                <?php $making_charge = $ordercarts['Shoppingcart']['making_charge']; ?>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><?php echo $making_charge != 0 ? indian_number_format($making_charge) : '-' ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px; border-bottom:0px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7">VAT</td>
                <?php $vat = $ordercarts['Shoppingcart']['vat']; ?>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><?php echo $vat != 0 ? indian_number_format($vat) : '-' ?></td>
            </tr>
    <!--            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" colspan="7"></td>
                <td style="border:1px solid #000; border-top:0px; padding:6px;"></td>
            </tr>-->
            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"></td>
                <?php $suffix = $order_count > 1 ? "($alphas[$o_key])" : ''; ?>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7"><strong>Total Price <?php echo $suffix ?></strong></td>
                <?php $net_amount = ($gold_amt + $making_charge + $vat) - $discount_amount ?>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><strong><?php echo $net_amount != 0 ? indian_number_format($net_amount) : '-' ?></strong></td>
            </tr>
            <?php
            $net_product_amount += $net_amount;
        }
        ?>
        <!--  -->


        <tr>
            <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"></td>
            <?php
            $suffix_all = '';
            if ($order_count > 1) {
                $imp_range = implode("+", array_slice($alphas, 0, $order_count));
                $suffix_all = "({$imp_range})";
            }
            ?>
            <td style="border:1px solid #000; border-top:0px; border-right:0px; font-size:18px; padding:6px;" align="right" colspan="7"><strong>Total Price (Rs.)<?php echo $suffix_all ?></strong></td>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:18px;" align="center"><strong><?php echo $net_product_amount != 0 ? indian_number_format($net_product_amount) : '-'; ?></strong></td>
        </tr>

        <?php
        if (($orderdetails['Order']['cod_status'] == 'PayU') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
            $paid = isset($paymentdetail['Paymentdetails']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
        } elseif (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
            $paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
            $balance = $cart_amount[0]['subtotal'] - $orderdetails['Order']['cod_amount'];
        } elseif (($orderdetails['Order']['cod_status'] == 'CHQ/DD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
            $paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
        }
        if (!empty($paid)) {
            ?>        <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7"><strong>Amount Paid by Customer (Rs.)</strong></td>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><strong><?php echo $paid != 0 ? indian_number_format(intval(round($paid))) : '-'; ?></strong></td>
            </tr>
            <?php
        }
        if (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending') && ($orderdetails['Order']['status'] == 'PartialPaid')) {
            ?>
            <tr>
                <td style="border:1px solid #000; border-right:0px; border-top:0px; padding:6px;" align="center"></td>
                <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px;" align="right" colspan="7"><strong>Balance Amount to be collected</strong></td>
                <td style="border:1px solid #000; border-top:0px; padding:6px;" align="center"><strong><?php echo $balance != 0 ? indian_number_format($balance) : '-'; ?></strong></td>
            </tr>
        <?php } ?>

        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:13px; font-style:italic;" align="center" colspan="9">This is computer generated invoice.No Signature required.</td>
        </tr>
        <?php for ($i = 1; $i <= 6; $i++) { ?>
        <!--            <tr>
                        <td style="border:1px solid #000; border-top:0px; border-bottom:0px; padding:6px; font-size:13px; font-style:italic;" align="center" colspan="9">&nbsp;</td>
                    </tr>-->
        <?php } ?>
        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:15px; font-style:italic;" align="left" colspan="9">
                Mode of payment: 
                <?php
                if (($orderdetails['Order']['cod_status'] == 'PayU')) {
                    echo '( Online Transfer : ' . indian_number_format($net_product_amount) . ')';
                } elseif (($orderdetails['Order']['cod_status'] == 'COD')) {
                    $paid = $paid != 0 ? indian_number_format(intval(round($paid))) : ' - ';
                    $balance = $balance != 0 ? indian_number_format($balance) : ' - ';
                    echo "(30% of total cost paid online : {$paid}. 70% of total cost will be COD : {$balance})";
//                    echo "( Online Transfer : {$paid}, COD: {$balance})";
                } elseif (($orderdetails['Order']['cod_status'] == 'CHQ/DD')) {
                    echo '( Cheque : ' . indian_number_format($net_product_amount) . ')';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="border:1px solid #000; border-top:0px; border-right:0px; padding:6px; font-size:13px; font-style:italic;" colspan="8"><strong>Contact us : 1800  102 2066</strong></td>
            <td style="border:1px solid #000; border-top:0px; border-left:0px; padding:6px; font-size:13px; font-style:italic;">customer.service@shagunn.in</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:13px;" colspan="9"><p style="line-height: 200%; display: block;"><strong>Returns Policy :</strong> At Shagunn it is our endeavour to deliver perfectly against customers orders. In case you need to return/exchange the product, we shall require the original jewellery box along with untampered price tag on the jewellery and original invoice.Please help us to help you better. Terms and condition apply.</p></td>
        </tr>
        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:13px;" align="center" colspan="9">The goods sold as part of this shipment are intended for end user consumption/retail sale and not for re-sale.</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:13px; text-align: justify;" colspan="9"><p style="line-height: 200%; display: block;"><strong>Declaration :</strong> I / We hereby certify that my/our registration certificate under the Maharashtra Value Added Tax Act, 2002 is in force on the date on which the sale of the goods specified in this tax invoice is made by me / us and that the transaction of sale covered by this tax invoice has been effected by me / us and it shall be accounted for in the turnover of sales while filing of return and the due tax, if any, payable on the sale has been paid or shall be paid.</p></td>
        </tr>
        <tr>
            <td style="border:1px solid #000; border-top:0px; padding:6px; font-size:13px;" colspan="9"><strong>Regd. Office :</strong> Birla Gold and Precious Metals Pvt. Ltd. Morya Landmark II, 2nd Floor,202, New Link Road, Andheri (W), Mumbai - 400053,Maharashtra,India</td>
        </tr>
    </table>
</div>

<pagebreak />

<div style="width:900px; padding:20px; margin:0 auto;">
    <table cellpadding="0" cellspacing="0" width="100%" border="0" style="font-size:12px;">
        <tr>
            <td colspan="2"><strong>Terms &amp; Conditions of sales of products by Birla Gold and Precious Metals Private Limited.</strong></td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td width="15">1)</td>
            <td>Any matter/claim/dispute arising out of the transaction will be subject to the Jurisdiction of Mumbai Courts only. </td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td valign="top">2)</td>
            <td>All request for further services or exchange of the products or complaints pertaining to the product should be accompanied with the Tax Invoice and valid photo identity of the person making such request/complaint. </td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td>3)</td>
            <td>Jewellery Sold by Birla Gold can be exchange at the same showroom for the product of the same value, provided :</td>
        </tr>
        <tr>
            <td colspan="2" height="10"></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:30px;"> a) Product is unused. <br />
                b) Product is in the same condition in which it was sold. <br />
                c) Product is returned within 30 days from the date of tax invoice. <br />
                d) Tax Invoice to be produced. <br />
                e) A photo identity of a person is produced. <br />
                f) The product is not tampered with or altered. <br />
                g) No request for cash back shall be entertained. <br /></td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td>4)</td>
            <td> No Complaint will be entertrained if :</td>
        </tr>
        <tr>
            <td colspan="2" height="10"></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:30px;"> a) The Jewellery is damaged by mishandling. <br />
                b) The Jewellery is altered or repaired by a person not authorized by Birla Gold. <br /></td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td>5)</td>
            <td>Birla Gold not be liable or responsible for any indirect or consequential loss or damages.</td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
        <tr>
            <td valign="top">6)</td>
            <td>If the payment made by cheque or Demand Draft, the delivery of the item purchases against the bill, will be made only after realization of the amount.</td>
        </tr>
    </table>
</div>
