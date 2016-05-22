<div id="content" class="clearfix">
    <div class="container">
        <div class="mainheading">
            <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_brokerage_export'.$search_string_url),array('class'=>'button')); ?></div>
            <div class="titletag">
                <h1>Vendor Brokerage</h1>
            </div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="<?php echo BASE_URL?>admin/orders/vendors_brokerage" id="myForm1" method="get" style="width:100%;float:left;padding: 5px 10px;">
                <table cellpadding="0" cellspacing="2">
                    <tr>
                        <td><strong><?php echo __('Product Name'); ?> : </strong>&nbsp;</td>
                        <td><input id="pname" name="pname" type="text" class="text-input" autocomplete="off" value="<?php
                            if (isset($_REQUEST['pname'])) {
                                echo $_REQUEST['pname'];
                            }
                            ?>" /> </td>
                        <td>&nbsp;&nbsp;</td>
                        <td><strong><?php echo __('Vendor Code'); ?> : </strong>&nbsp;</td>
                        <td><input id="vendor" name="vendor" type="text" class="text-input" autocomplete="off" value="<?php
                            if (isset($_REQUEST['vendor'])) {
                                echo $_REQUEST['vendor'];
                            }
                            ?>" /> </td>
                        <td>&nbsp;&nbsp;</td>
                        <td><strong><?php echo __('From Date'); ?> : </strong>&nbsp;</td>
                        <td><input name="from_date" type="text" class="text-input date" autocomplete="off" value="<?php
                            if (isset($_REQUEST['from_date'])) {
                                echo $_REQUEST['from_date'];
                            }
                            ?>" /> </td>
                        <td>&nbsp;&nbsp;</td>
                        <td><strong><?php echo __('To Date'); ?> : </strong>&nbsp;</td>
                        <td><input name="to_date" type="text" class="text-input date" autocomplete="off" value="<?php
                            if (isset($_REQUEST['to_date'])) {
                                echo $_REQUEST['to_date'];
                            }
                            ?>" /> </td>
                        <td>&nbsp;&nbsp;</td>
                        <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search'); ?>" /></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>
                            <?php
                            if ($is_search) {
                                echo $this->Html->link(__('Cancel'), array('action' => 'admin_vendors_brokerage'), array('class' => 'button small', 'style' => 'padding:3px 5px;', 'title' => 'Cancel Search'));
                            }
                            ?></td>
                    </tr></table>
            </form>
        </div>
        <?php echo $this->Form->create('orders', array('action' => 'delete', 'id' => 'myForm', 'Controller' => 'orders')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
            <thead>
                <tr>
                    <th align="center" width="5%"><?php echo __('#'); ?></th>        
                    <th align="left" width="10%"><?php echo $this->Paginator->sort('Order.invoice', 'Order Id'); ?></th> 
                    <th align="left" width="5%"><?php echo $this->Paginator->sort('Order.created_date', 'Date'); ?></th> 
                    <th align="left" width="10%"><?php echo $this->Paginator->sort('User.first_name', 'Customer Name'); ?></th> 
                    <th align="left" width="8%"><?php echo $this->Paginator->sort('Vendor.vendor_code', 'Vendor Code'); ?></th> 
                    <th align="left" width="8%"><?php echo $this->Paginator->sort('Vendor.Company_name', 'Vendor  Name'); ?></th> 
                    <th align="left" width="10%"><?php echo $this->Paginator->sort('Product.product_code', 'Product Code'); ?></th>
                    <th align="left" width="10%"><?php echo $this->Paginator->sort('Product.product_name', 'Product Name'); ?></th> 
                    <th align="left" width="5%">Price</th> 
                    <th align="left" width="7%"><?php echo $this->Paginator->sort('Orderstatus.order_status', 'Order Status'); ?></th>         
                    <th align="left" width="7%"><?php echo $this->Paginator->sort('Orderstatus.brokerage_status', 'Brokerage Status'); ?></th>         
                    <th align="center" width="7%">Brokerage Amount</th>
                    <th align="center" width="7%"><?php echo $this->Paginator->sort('Order.netpayamt', 'Order Value'); ?></th>
                    <th align="center" width="3%"><?php echo __('View');?></th> 
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($orderdetails))
                    echo '<tr><td colspan="5" align="center">' . __('No records found') . '</td></tr>';
                else {
                    $i = $this->Paginator->counter('{:start}');
                    foreach ($orderdetails as $orderdetail):
                        $in = $this->requestAction(array('controller' => 'orders', 'action' => 'admin_get_invoice_prefix', $orderdetail['User']['user_type'], $orderdetail['Order']['cod_status']));
                        $brokerage_amount = $this->requestAction(array('controller' => 'products', 'action' => 'admin_get_brokerage_amount', $orderdetail['Product']['product_id'], $orderdetail['Shoppingcart']['cart_id']));
                        $netamount = $this->requestAction(array('controller' => 'orders', 'action' => 'admin_get_net_amount', $orderdetail['Order']['order_id']));
                        ?>
                    <tr>
                        <td align="center"><?php echo h($i); ?></td>
                        <td align="left"><?php echo $in . $orderdetail['Order']['invoice']; ?></td>
                        <td align="left"><?php echo date("Y-m-d", strtotime($orderdetail['Order']['created_date'])); ?></td>
                        <td align="left"><?php echo $orderdetail['User']['first_name'].' '.$orderdetail['User']['last_name']; ?></td>
                        <td align="left"><?php echo $orderdetail['Vendor']['vendor_code']; ?></td>
                        <td align="left"><?php echo $orderdetail['Vendor']['Company_name']; ?></td>
                        <td align="left"><?php echo $orderdetail['Category']['category_code'] . ' ' . $orderdetail['Product']['product_code'] . "-" . $orderdetail['Shoppingcart']['purity'] . "K" . $orderdetail['Shoppingcart']['clarity'] . $orderdetail['Shoppingcart']['color']; ?></td>
                        <td align="left"><?php echo $orderdetail['Product']['product_name']; ?></td>
                        <td align="left"><?php echo indian_number_format($orderdetail['Shoppingcart']['total'] * $orderdetail['Shoppingcart']['quantity']) ?> </td>
                        <td align="left"><?php echo $orderdetail['Orderstatus']['order_status']; ?></td>
                        <td align="left"><?php echo $orderdetail['Brokeragestatus']['brokerage_status']; ?></td>
                        <td align="left"><?php echo indian_number_format($brokerage_amount)?></td>
                        <td align="left"><?php echo indian_number_format($netamount); ?></td>
                        <td align="center"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'admin_user_view', $orderdetail['Order']['order_id']),'border'=>0,'alt'=>__('View')) );?></td>
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
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".date").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>