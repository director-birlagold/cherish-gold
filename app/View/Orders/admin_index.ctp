<div id="content" class="clearfix">
  <div class="container">
    <div class="mainheading">
      <div class="btnlink"><?php //echo $this->Html->link(__('+Add Price'), array('action' => 'add'),array('class'=>'button')); ?></div>
      <div class="titletag">
        <h1>Order Details</h1>
      </div>
    </div>
     <div class="tablefooter clearfix">
        <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">
          <table cellpadding="0" cellspacing="2">
            <tr>
          <td><strong><?php echo __('Type');?> : </strong>&nbsp;</td>
            <td><select name="type">
            <option value="">Select</option>
            <option value="0">User</option>
            <option value="1">Franchisee</option>
            </select>           
           </td> 
            <td><strong><?php echo __('Invoice No');?> : </strong>&nbsp;</td>
            <td><input id="searchemail" name="searchinvoice" type="text" class="text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchinvoice'])){echo $_REQUEST['searchinvoice'];}?>" /> </td>
             <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>        
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'admin_index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table>
             </form>
        </div>
    	<?php echo $this->Form->create('paymentdetails', array('action' => 'delete','id'=>'myForm','Controller'=>'orders')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
       <!--  <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> -->
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('code','User Name');?></th> 
         <th align="left"><?php echo $this->Paginator->sort('type','User Type');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('invoice','Invoice No');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('price','Amount');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('date','Date');?></th>         
           <th width="30" align="center">View</th>
        </tr>
        </thead>
        <tbody>
        <?php //pr($paymentdetails);exit?>
        <?php if(empty($paymentdetail))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($paymentdetail as $paymentdetails):
		$user=ClassRegistry::init('User')->find('first',array('conditions'=>array('user_id'=>$paymentdetails['Paymentdetails']['user_id']))); 
		$order=ClassRegistry::init('Order')->find('first',array('conditions'=>array('order_id'=>$paymentdetails['Paymentdetails']['order_id'])));
		//$Productdetails=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$cartdetails['Shoppingcart']['product_id'])));		
		?>
        <tr>
       <!-- <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($paymentdetails['Paymentdetails']['paymentdetails_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>-->
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $user['User']['first_name'];?>&nbsp;
		<?php  echo $user['User']['last_name'];?></td>
        <td align="left"><?php if($user['User']['user_type']=='0'){
			echo 'User';
			if($order['Order']['cod_status']=='PayU'){
			$in='SGN-ON-';
			}elseif($order['Order']['cod_status']=='CASH'){
				$in='SGN-CHQ/DD-';
			}
		}
		else
		{
			echo 'Franchisee';
			if($order['Order']['cod_status']=='PayU'){
				$in='SGN-FN-';
			}elseif($order['Order']['cod_status']=='COD'){
				$in='SGN-FNCD-';
			}elseif($order['Order']['cod_status']=='CASH'){
				$in='SGN-FNCHQ/DD-';
			}
			
			
		}?>&nbsp;</td>
        <td align="left"><?php  echo $in.$order['Order']['invoice'];?></td>
               
          <td align="left"><?php  echo $paymentdetails['Paymentdetails']['amount'];?></td>
          <td align="left"><?php  $dt=$paymentdetails['Paymentdetails']['created_date'];
		  
		  echo $ndt= date('d - m - Y',strtotime($dt));		
		  ?></td>
          
          <td align="center"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'user_view',$paymentdetails['Paymentdetails']['paymentdetails_id']),'border'=>0,
	'alt'=>__('View')) );?></td>
        </tr>
        <?php $i++; endforeach;
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
        'format' => __('Page').' {:page} '.__('of').' {:pages}, '.__('showing').' {:current} '.__('records out of').' {:count} '.__('total')
        ));
        ?>
        </div>
        <div class="paging">
        <?php
        echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') , array(), null, array('class' => 'next disabled'));
        ?>
        </div>
        </div>
        </div>
    	<?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
$(function() {
	$( "#cdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#edate" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>