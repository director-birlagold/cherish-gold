<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td align="right" valign="top" width="230" class="sidepromenu">
            <?php echo $this->Element('admin_order_leftsidebar'); ?></td>
        <td align="left" valign="top">

            <div id="content"  class="clearfix">			
                <div class="container">

                    <div align="right" style="padding-right:50px;">
                        <?php 
                        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
                        if ($user['User']['user_type'] == '0') {
                            echo $this->Html->link('Back to Vendor Brokerage', array('action' => 'vendors_brokerage'), array('class' => 'button'));
                        } elseif ($user['User']['user_type'] == '1') {
                            echo $this->Html->link('Back to Franchisee Brokerage', array('action' => 'franchisee_brokerage'), array('class' => 'button'));
                        }
                        ?>
                        <?php echo $this->Html->link('Back to Order Details', array('action' => 'order_index'), array('class' => 'button')); ?>
                    </div>   
                    <div class="texttabBox"> 
                        <?php echo $this->Form->create('Order', array('method' => 'post')) ?> 
                        <fieldset><legend>Order   Details</legend>

                            <table width="600" align="left">
                                <?php
                                $orderinvoice = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
                                $ordercartamount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount', 'sum(detected_amount) as discountamount', 'sum(total_amount) as originalamount', 'is_coupon_used', 'quantity', 'cart_id')));



                                $paymentdetail = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));
                                ?>
                                <tr><td width="250"><strong>Order Number</strong></td>
                                    <td><p>
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
                                                    $paymentmode = 'CHQ/DD';
                                                } elseif ($orderdetails['Order']['cod_status'] == 'CHQ/DD') {
                                                    $in = 'SGN-FNCHQ/DD-';
                                                    $paymentmode = 'Partial Payment';
                                                }
                                            }
                                            ?>

                                            <?php echo $in . $orderinvoice['Order']['invoice']; ?></p></td></tr>
                                <tr><td width="150"><strong >Payment Mode</strong></td><td><?php echo $paymentmode; ?></td></tr>


                                <?php if (($orderdetails['Order']['cod_status'] != 'CHQ/DD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) { ?>
                                    <tr><td width="150"><strong>Transaction Id </strong></td>
                                        <td><p><?php $txid = isset($paymentdetail['Paymentdetails']) ? h($paymentdetail['Paymentdetails']['txnid']) : '';
                                                if (!empty($txid))
                                                    echo $txid;
                                                else
                                                    '-';
                                                ?></p></td></tr>
                                <?php } ?>


                                <?php
                                $cart_amount = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => 'SUM(quantity*total) AS subtotal'));
                                $Discounthistory = ClassRegistry::init('Discounthistory')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id'])));
                                if (!empty($Discounthistory)) {
                                    $Discount = ClassRegistry::init('Discount')->find('first', array('conditions' => array('discount_id' => $Discounthistory['Discounthistory']['coupon_id'])));
                                }
                                $netamount = $cart_amount[0]['subtotal'];
                                ?>
                                <tr><td width="150"><strong >Sub Total Amount</strong></td><td>Rs.<?php echo indian_number_format($netamount = $cart_amount[0]['subtotal']); ?></td></tr>
                                <?php if ($orderdetails['Order']['discount_amount'] > 0) { ?>
 <tr><td width="150"><strong >Discount Type</strong></td><td><?php if(!empty($Discounthistory['Discounthistory']['type'])){echo $Discounthistory['Discounthistory']['type'];}else{echo '-';}?></td></tr>
   <tr><td width="150"><strong >Discount Code</strong></td><td><?php
		if(isset($Discounthistory['Discounthistory']['coupon_code']) && !empty($Discounthistory['Discounthistory']['coupon_code'])){echo $Discounthistory['Discounthistory']['coupon_code'];}else{echo '-';}
		 ?></td></tr>

                                      <!--<tr><td width="150"><strong >Discount Code</strong></td><td><?php echo @$Discount['Discount']['voucher_code']; ?></td></tr>-->
                                     <!--<tr><td width="150"><strong ><?php //if($Discount['Discount']['per_amou']=="1") { echo "Percentage" ;} else { echo "Amount"; }    ?></strong></td>
                                     <td><?php
                                    //if($Discount['Discount']['per_amou']=="1") { echo $Discount['Discount']['percentage']."  %  "; 	 } else {
                                    //echo " Rs. ".$Discount['Discount']['percentage'];  }
                                    ?>
                                     </td></tr>-->
                                    <tr><td width="150"><strong >Discount Amount</strong></td><td>Rs. <?php echo $orderdetails['Order']['discount_amount']; ?></td></tr>   

                                    <?php
                                    $netamount-=$orderdetails['Order']['discount_amount'];
                                }
                                ?>
                                <?php if ($orderdetails['Order']['shipping_amt'] > 0) { ?>
                                    <tr><td width="150"><strong >Shipping Percentage</strong></td><td><?php echo $orderdetails['Order']['shipping_per']; ?>%</td></tr>
                                    <tr><td width="150"><strong >Shipping Charges</strong></td><td>Rs. <?php echo indian_number_format($orderdetails['Order']['shipping_amt']); ?></td></tr>

                                <?php } ?>
                                <?php $netamount+=$orderdetails['Order']['shipping_amt']; ?>

                                <tr><td width="150"><strong >Total Amount</strong></td><td>Rs. <?php echo indian_number_format($netamount); ?></td></tr>

                                <?php
                                if (($orderdetails['Order']['cod_status'] == 'PayU') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                                    $paid = isset($paymentdetail['Paymentdetails']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
                                } elseif (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                                    $paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
                                    $balance = $netamount - $orderdetails['Order']['cod_amount'];
                                } elseif (($orderdetails['Order']['cod_status'] == 'CHQ/DD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) {
                                    $paid = isset($paymentdetail['Paymentdetails']['amount']) ? $paymentdetail['Paymentdetails']['amount'] : 0;
                                }
                                ?>
                                <?php if (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending') && ($orderdetails['Order']['status'] == 'PartialPaid')) { ?>
                                    <tr><td width="150"><strong >Partial Payment Percentage</strong></td><td><?php echo $orderdetails['Order']['cod_percentage']; ?>%</td></tr>
                                <?php } ?>
                                <tr><td width="150"><strong >Amount Paid</strong></td><td><?php
                                        if (!empty($paid)) {
                                            echo 'Rs.';
                                            echo $paid;
                                        } else
                                            echo 'Nill';
                                        ?></td></tr>
                                <?php if (($orderdetails['Order']['cod_status'] == 'COD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending') && ($orderdetails['Order']['status'] == 'PartialPaid')) { ?>

                                    <tr><td width="150"><strong >Balance Amount</strong></td><td>Rs. <?php echo $balance; ?></td></tr>
                                <?php } ?>

                                <tr><td width="150"><strong >Order Created Date</strong></td>
                                    <td><p><?php
                                            $dtt = h($orderdetails['Order']['created_date']);
                                            $ndtt = date("d-m-Y", strtotime($dtt));
                                            if (!empty($ndtt))
                                                echo $ndtt;
                                            else
                                                '-';
                                            ?></p></td></tr>

                                <?php echo $this->Form->hidden('order_id', array('value' => $orderdetails['Order']['order_id'])) ?>
                                <tr>
                                    <td width="150"><strong>Order Status </strong></td>
                                    <?php
                                    $order_status_options = ClassRegistry::init('Orderstatus')->find('list', array('fields' => array('order_sts_id', 'order_status'),
                                        'condition' => array('is_active' => '1'),
//                                        'order' => array('Orderstatus.order_status' => 'asc')
                                        ));
                                    ?>
                                    <td><p>
                                            <?php
                                            echo $this->Form->input('order_status_id', array(
                                                'type' => 'select',
                                                'id' => 'orderstatusid',
                                                'options' => $order_status_options,
                                                'label' => false,
                                                'div' => false,
                                                'value' => $orderdetails['Order']['order_status_id'],
//                                                'empty' => ''
                                            ));

                                            echo $this->Form->input('old_order_status_id', array('type' => 'hidden', 'value' => $orderdetails['Order']['order_status_id']));
                                            ?>
                                            <?php // $st=h($orderdetails['Order']['order_status']); if(!empty($st))echo $st; else '-';  ?>
                                        </p></td>
                                </tr>
                                <tr id="remarks_tr" style="display: none">
                                    <td width="150"><strong>Remarks</strong></td>
                                <td><?php echo $this->Form->input('orderstatus_remarks', array('type' => 'textarea', 'div' => false, 'label' => false)); ?></td>
                                </tr>

<!--                <tr><td width="150"><strong>Order Status </strong></td>
<td><p><?php
                                $st = h($orderdetails['Order']['order_status']);
                                if (!empty($st))
                                    echo $st;
                                else
                                    '-';
                                ?></p></td></tr>-->
                                <tr>
                                    <td width="150"><strong>Admin Status </strong></td>
                                    <?php
                                    $admin_status_options = ClassRegistry::init('Adminstatus')->find('list', array('fields' => array('admin_sts_id', 'admin_status'),
                                        'condition' => array('is_active' => '1'),
//                                        'order' => array('Adminstatus.order_status' => 'asc')
                                        ));
//                                    $admin_status_options = array(
//                                        'Pending' => 'Pending',
//                                        'Vendor' => 'Vendor',
//                                        'QC' => 'QC',
//                                        'Completed' => 'Completed');
                                    ?>
                                    <td><p>
                                            <?php
                                            echo $this->Form->input('admin_status_id', array(
                                                'type' => 'select',
                                                'id' => 'adminstatusid',
                                                'options' => $admin_status_options,
                                                'label' => false,
                                                'div' => false,
                                                'value' => $orderdetails['Order']['admin_status_id'],
//                         'empty' => ''
                                            ));
                                            echo $this->Form->input('old_admin_status_id', array('type' => 'hidden', 'value' => $orderdetails['Order']['admin_status_id']));
                                            ?>
                                            <?php // $st=h($orderdetails['Order']['order_status']); if(!empty($st))echo $st; else '-';  ?>
                                        </p></td>
                                </tr>
                                <tr id="admin_status_remarks_tr" style="display: none">
                                    <td width="150"><strong>Remarks</strong></td>
                                <td><?php echo $this->Form->input('adminstatus_remarks', array('type' => 'textarea', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td width="150"><strong>Brokerage Status </strong></td>
                                    <?php
                                    $brokerage_status_options = ClassRegistry::init('Brokeragestatus')->find('list', array('fields' => array('brokerage_sts_id', 'brokerage_status'),
                                        'condition' => array('is_active' => '1'),
                                        ));
                                    ?>
                                    <td><p>
                                            <?php
                                            echo $this->Form->input('brokerage_status_id', array(
                                                'type' => 'select',
                                                'id' => 'brokeragestatusid',
                                                'options' => $brokerage_status_options,
                                                'label' => false,
                                                'div' => false,
                                                'value' => $orderdetails['Order']['brokerage_status_id'],
                                            ));
                                            echo $this->Form->input('old_brokerage_status_id', array('type' => 'hidden', 'value' => $orderdetails['Order']['brokerage_status_id']));
                                            ?>
                                        </p></td>
                                </tr>
                                <tr id="brokerage_status_remarks_tr" style="display: none">
                                    <td width="150"><strong>Remarks</strong></td>
                                <td><?php echo $this->Form->input('brokeragestatus_remarks', array('type' => 'textarea', 'div' => false, 'label' => false)); ?></td>
                                </tr>

                                <tr>
                                    <td width="150"><strong>Pending Amount </strong></td>
                                    <td><p>
                                            <?php
                                            $total_paid_amount = isset($paymentdetail['Paymentdetails']['amount']) ? h($paymentdetail['Paymentdetails']['amount']) : 0;
                                            $pending_amount = $netamount - $total_paid_amount;
                                            if (!empty($pending_amount)) {
                                                echo 'Rs.';
                                                echo indian_number_format($pending_amount);
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </p></td>
                                </tr>

                                <?php if (($orderdetails['Order']['cod_status'] != 'CHQ/DD') && ($orderdetails['Order']['order_status'] != 'Pending')) { ?>
                                    <tr><td width="150"><strong >Payment Created Date</strong></td>
                                        <td><p><?php
                                                $dt = h($paymentdetail['Paymentdetails']['created_date']);
                                                $ndt = date("d-m-Y", strtotime($dt));
                                                if (!empty($ndt))
                                                    echo $ndt;
                                                else
                                                    '-';
                                                ?></p></td></tr>
                                <?php } ?>   


                                <tr><td width="150"><strong>Payment Status </strong></td>
                                    <td><p><?php
                                            $st = h($orderdetails['Order']['status']);
                                            if (!empty($st))
                                                echo $st;
                                            else
                                                '-';
                                            ?></p></td></tr>


                                <?php if (($orderdetails['Order']['cod_status'] != 'CHQ/DD') && ($orderdetails['Orderstatus']['order_status'] != 'Pending')) { ?>         
                                    <tr><td width="150"><strong>Ip No </strong></td>
                                        <td><p><?php
                                                $ip = isset($paymentdetail['Paymentdetails']) ? h($paymentdetail['Paymentdetails']['ip']): '';
                                                if (!empty($ip))
                                                    echo $ip;
                                                else
                                                    '-';
                                                ?></p></td></tr>
                                <?php } ?>
                                <tr>
                                    <td width="150"><?php echo $this->Form->submit('Save', array('class' => 'button')); ?></td>
                                </tr>
                            </table>         

                        </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div> 
            </div>
            </div>
        </td>
    </tr>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        var orderstatusid = <?php echo $orderdetails['Order']['order_status_id'] ?>;
        var adminstatusid = <?php echo $orderdetails['Order']['admin_status_id'] ?>;
        var brokeragestatusid = <?php echo $orderdetails['Order']['brokerage_status_id'] ?>;
        
        $("#orderstatusid").on('change', function(){
            if(orderstatusid != $(this).val()){
                $("#remarks_tr").show();
            }else{
                $("#remarks_tr").hide();
            }
        });
        $("#adminstatusid").on('change', function(){
            if(adminstatusid != $(this).val()){
                $("#admin_status_remarks_tr").show();
            }else{
                $("#admin_status_remarks_tr").hide();
            }
        });
        $("#brokeragestatusid").on('change', function(){
            if(brokeragestatusid != $(this).val()){
                $("#brokerage_status_remarks_tr").show();
            }else{
                $("#brokerage_status_remarks_tr").hide();
            }
        });
    });
</script>