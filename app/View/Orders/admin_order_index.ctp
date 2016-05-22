<?php
		if(isset($_REQUEST['cdate'])){
			$cdate =$_REQUEST['cdate'];
		}else{
			$cdate =0;
		}
		if(isset($_REQUEST['edate'])){
			$edate =$_REQUEST['edate'];
		}else{
			$edate =0;
		}
		if(isset($_REQUEST['type'])){
			$type =$_REQUEST['type'];
		}else{
			$type =-1;
		}
		if(isset($_REQUEST['searchinvoice'])){
			$invoice =$_REQUEST['searchinvoice'];
		}else{
			$invoice =0;
		}
	?>
<div id="content" class="clearfix">
    <div class="container">
        <div class="mainheading">
        <?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('OrderExport'))) ){?>    
			<div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_order_export',$cdate,$edate,$type,$invoice),array('class'=>'button')); ?><?php //echo $this->Html->link(__('+Add Price'), array('action' => 'add'),array('class'=>'button'));   ?></div>
		<?php }?>
			
            <div class="titletag">
                <h1>Order Details</h1>
            </div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">
                <table cellpadding="0" cellspacing="2">
                    <tr>
                        <td><strong><?php echo __('Type'); ?> : </strong>&nbsp;</td>
                        <td><select name="type">
                                <option value="" <?php if($type==-1){ echo "selected=selected"; } ?>>Select</option>
                                <option value="0" <?php if($type==0){ echo "selected=selected"; } ?>>User</option>
                                <option value="1" <?php if($type==1){ echo "selected=selected"; } ?>>Franchisee</option>
                            </select>           
                        </td> 
                        <td><strong><?php echo __('Order No'); ?> : </strong>&nbsp;</td>
                        <td><input id="searchemail" name="searchinvoice" type="text" class="text-input" autocomplete="off" value="<?php
                            if (isset($_REQUEST['searchinvoice'])) {
                                echo $_REQUEST['searchinvoice'];
                            }
                            ?>" /> </td>
                        <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php
                            if (isset($_REQUEST['cdate'])) {
                                echo $_REQUEST['cdate'];
                            }
                            ?>" /></td>  
                        <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php
                            if (isset($_REQUEST['edate'])) {
                                echo $_REQUEST['edate'];
                            }
                            ?>" /></td>        
                        <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search'); ?>" /></td>
                        <td>&nbsp;</td><td>
<?php
if (isset($_REQUEST['search'])) {
    echo $this->Html->link(__('Cancel'), array('action' => 'admin_order_index'), array('class' => 'button small', 'style' => 'padding:3px 5px;', 'title' => 'Cancel Search'));
}
?></td>
                    </tr></table>
            </form>
        </div>
<?php echo $this->Form->create('orders', array('action' => 'delete', 'id' => 'myForm', 'Controller' => 'orders')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
            <thead>
                <tr>
               <!--  <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> -->
                    <th width="30" align="center"><?php echo __('#'); ?></th>        
                    <th align="left"><?php echo $this->Paginator->sort('code', 'User Name'); ?></th> 
                    <th align="left"><?php echo $this->Paginator->sort('type', 'User Type'); ?></th> 
                    <th align="left"><?php echo $this->Paginator->sort('invoice', 'Order No'); ?></th> 
                    <th align="left"><?php echo $this->Paginator->sort('cod_status', 'Mode Type'); ?></th>
                    <!-- <th align="left"><?php //echo $this->Paginator->sort('','Order Amount');  ?></th>-->
                    <th align="left"><?php echo $this->Paginator->sort('status', 'Order Status'); ?></th> 
                  <!-- <th align="left"><?php //echo $this->Paginator->sort('','Payment Amount'); ?></th>  -->
                    <th align="left"><?php echo $this->Paginator->sort('status', 'Payment status'); ?></th> 
					<th align="left"><?php echo $this->Paginator->sort('status','Way Bill No');?></th>			
                    <th align="left"><?php echo $this->Paginator->sort('date', 'Date'); ?></th>         
                    <th width="15" align="center">View</th>
                    <th width="15" align="center">Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php //pr($paymentdetails);exit?>
                <?php
                if (empty($orderdetails))
                    echo '<tr><td colspan="5" align="center">' . __('No records found') . '</td></tr>';
                else {
                    $i = $this->Paginator->counter('{:start}');
                    foreach ($orderdetails as $orderdetails):
                        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id'])));
                        $cart = ClassRegistry::init('Shoppingcart')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'fields' => array('SUM(total) AS totamount')));
                        $paymentdetails = ClassRegistry::init('Paymentdetails')->find('first', array('conditions' => array('order_id' => $orderdetails['Order']['order_id']), 'order' => 'paymentdetails_id DESC'));

                        //$Productdetails=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$cartdetails['Shoppingcart']['product_id'])));		
                        ?>
                        <tr>
                       <!-- <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($orderdetails['Order']['order_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>-->
                            <td align="center"><?php echo h($i); ?></td>
                            <td align="left"><?php echo $user['User']['first_name']; ?>&nbsp;
                                <?php echo $user['User']['last_name']; ?></td>
                            <td align="left"><?php
                                if ($user['User']['user_type'] == '0') {
                                    echo 'User';
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
                                    echo 'Franchisee';
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
                                ?>&nbsp;</td>
                            <td align="left"><?php echo $in . $orderdetails['Order']['invoice']; ?></td>
                            <td align="left"><?php echo $paymentmode; ?></td>
                           <!--    <td align="left"><?php //echo $cart['0']['totamount'];  ?></td>-->
                            <td align="left">
                                <?php
                                $order_sts = ClassRegistry::init('Orderstatus')->find('first', array('conditions' => array('Orderstatus.order_sts_id' => $orderdetails['Order']['order_status_id'])));
                                echo $order_sts['Orderstatus']['order_status']; 
                                ?>
                            </td>




                             <!-- <td align="left"><?php //if(!empty($paymentdetails['Paymentdetails']['amount'])){echo $paymentdetails['Paymentdetails']['amount'];}else{echo '-';}?></td>-->

                            <td align="left"><?php echo $orderdetails['Order']['status']; ?></td>
                            <td align="left"><?php  echo $orderdetails['Order']['way_bill_no'];?></td>
							<td align="left"><?php
                                //$dt = $orderdetails['Order']['created_date'];
                                //echo $dt."-";
                                //echo $ndt = date('d - m - Y', strtotime($dt));
								$dt = date('d-m-Y H:i:s',strtotime($orderdetails['Order']['created_date']));
								echo $dt;
                                ?></td>
                                <?php if ($user['User']['user_type'] == 0) { ?>
                                <td align="center">
								<?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('OrderView'))) ){?>
									<?php
									echo $this->Html->image('icons/view.png', array('url' => array('action' => 'user_view', $orderdetails['Order']['order_id']), 'border' => 0,
										'alt' => __('View')));
									?>
								<?php }?>
								</td>
							<?php } else { ?>
                                <td align="center">
								<?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('OrderView'))) ){?>
									<?php
									echo $this->Html->image('icons/view.png', array('url' => array('action' => 'franchisee_view', $orderdetails['Order']['order_id']), 'border' => 0,
										'alt' => __('View')));
									?>
								<?php }?>
							</td>
        <?php } ?>
          <td align="center">
		<?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('OrderInvoice'))) ){?>  
			<?php echo $this->Html->image('small_pdf.png',array('url'=>array('action'=>'orderpdf',$orderdetails['Order']['order_id']),'border'=>0,
	'alt'=>__('Download')) );?>
	<?php }?>
	</td>
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
    <!--<input type="submit" id="action_btn"  class="button small" value="Delete"  />-->
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
        $("#cdate").datepicker({dateFormat: 'yy-mm-dd'});
        $("#edate").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
