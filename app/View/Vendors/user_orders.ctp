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
            <?php if ($this->Session->read('User.user_type') == 2) { ?>
                <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">User Orders</a></li>
            <?php } ?>
        </ul>
        <div id="tabs-1" class="">
            <p></p>
            <div class="account_details">


                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="myOrder">
                    <tr>
                        <th><?php echo __('#'); ?></th>        
                        <th><?php echo 'Date' ?></th>         
<!--                        <th><?php echo 'User Name' ?></th> 
                        <th><?php echo 'User Type' ?></th> -->
                        <th><?php echo 'Order No' ?></th> 
<!--                        <th><?php echo 'Mode Type' ?></th>
                        <th><?php echo 'Order Status' ?></th> -->
                        <th><?php echo 'Vendor Status' ?></th> 
                        <th align="center">View</th>
                    </tr>
                    <tbody>
                        <?php
                        if (empty($orders))
                            echo '<tr><td colspan="8" align="center">' . __('No records found') . '</td></tr>';
                        else {
                            $i = 1;
                            foreach ($orders as $order):
                                $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $order['Order']['user_id'])));
                                $cart = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'fields' => array('SUM(total) AS totamount')));
                                $paymentdetails = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $order['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));
                                ?>
                                <tr>
                                    <td align="center"><?php echo h($i); ?></td>
                                    <td align="left"><?php
                                        $dt = $order['Order']['created_date'];

                                        echo $ndt = date('d - m - Y', strtotime($dt));
                                        ?>
                                    </td>
        <!--                                    <td align="left"><?php echo $user['User']['first_name']; ?>&nbsp;
                                    <?php echo $user['User']['last_name']; ?></td>-->
                                    <?php
                                    if ($user['User']['user_type'] == '0') {
                                        if ($order['Order']['cod_status'] == 'PayU') {
                                            $in = 'SGN-ON-';
                                            $paymentmode = 'Full Payment';
                                        } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {
                                            $in = 'SGN-CHQ/DD-';
                                            $paymentmode = 'CHQ/DD';
                                        } elseif ($order['Order']['cod_status'] == 'COD') {
                                            $in = 'SGN-CD-';
                                            $paymentmode = 'Partial Payment';
                                        }
                                    } else {
                                        if ($order['Order']['cod_status'] == 'PayU') {
                                            $in = 'SGN-FN-';
                                            $paymentmode = 'Full Payment';
                                        } elseif ($order['Order']['cod_status'] == 'COD') {
                                            $in = 'SGN-FNCD-';
                                            $paymentmode = 'Partial Payment ';
                                        } elseif ($order['Order']['cod_status'] == 'CHQ/DD') {
                                            $in = 'SGN-FNCHQ/DD-';
                                            $paymentmode = 'CHQ/DD';
                                        }
                                    }
                                    ?>
                                    <td align="left"><?php echo $in . $order['Order']['invoice']; ?></td>
                                    <!--<td align="left"><?php echo $paymentmode; ?></td>-->
        <!--                                    <td align="left">
                                    <?php
                                    $order_sts = ClassRegistry::init('Orderstatus')->find('first', array('conditions' => array('Orderstatus.order_sts_id' => $order['Order']['order_status_id'])));
                                    echo $order_sts['Orderstatus']['order_status'];
                                    ?>
                                    </td>-->
                                    <td align="left">
                                        <?php
                                        $admin_sts = ClassRegistry::init('Adminstatus')->find('first', array('conditions' => array('Adminstatus.admin_sts_id' => $order['Order']['admin_status_id'])));
                                        echo $admin_sts['Adminstatus']['admin_status'];
                                        ?>
                                    </td>
                                    <td align="center"><?php
                                        echo $this->Html->image('icons/view.png', array('url' => array('controller' => 'orders', 'action' => 'product_view', $order['Order']['order_id']), 'border' => 0,
                                            'alt' => __('View')));
                                        ?></td>
                                </tr>
                                <?php
                                $i++;
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div style="clear:both;">&nbsp;</div>



</body>
</html>
