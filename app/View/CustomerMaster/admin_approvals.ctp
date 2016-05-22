<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
            <!-- <div class="btnlink"><?php echo $this->Html->link(__('+Add Category'), array('action' => 'add'),array('class'=>'button')); ?></div>          -->
            <div class="titletag"><h1><?php echo __('Customer Approvals'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
          <form name="searchfilters" action="" id="myForm1" method="post" style="float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr style="padding:10px"><td><strong><?php echo __('Email');?> : </strong>&nbsp;</td>
            <td><input id="searchemail" name="searchemail" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchemail'])){echo $_REQUEST['searchemail'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Phone');?> : </strong>&nbsp;</td>
            <td><input id="searchephone" name="searchphone" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchphone'])){echo $_REQUEST['searchphone'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Application No.');?> : </strong>&nbsp;</td>
            <td><input id="searchapplication" name="searchapplication" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchapplication'])){echo $_REQUEST['searchapplication'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Partner Code');?> : </strong>&nbsp;</td>
            <td><input id="searchpartner" name="searchpartner" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchpartner'])){echo $_REQUEST['searchpartner'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			</tr>
			<tr style="padding:10px">
			<td><strong><?php echo __('Applicant');?> : </strong>&nbsp;</td>
            <td><input id="searchname" name="searchname" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchname'])){echo $_REQUEST['searchname'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Payment By');?> : </strong>&nbsp;</td>
            <td><input id="searchpayby" name="searchpayby" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchpayby'])){echo $_REQUEST['searchpayby'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Application Status');?> : </strong>&nbsp;</td>
            <td><input id="searchstatus" name="searchstatus" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchstatus'])){echo $_REQUEST['searchstatus'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			
			
			<td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>

			<td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>   
        </div>
    	<!--<?php echo $this->Form->create('CustomerMaster', array('action' => 'delete','id'=>'myForm','Controller'=>'customermaster')); ?> -->
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
        <!--  <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="" class="" />'); ?></th>  -->
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('application_no','Application No');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('partner_code','Partner Code');?></th>
		<th align="left"><?php echo $this->Paginator->sort('applicant_name','Applicant Name');?></th>
		<th align="left"><?php echo $this->Paginator->sort('contact_mobile','Mobile');?></th>
		<th align="left"><?php echo $this->Paginator->sort('contact_email','EMail');?></th>	
		<th align="left"><?php echo $this->Paginator->sort('initial_pay_by','Pay By');?></th>	
		<th align="left">Payment Status</th>	
		<th align="left"><?php echo $this->Paginator->sort('approve_status','ApplicationStatus');?></th>			
       <th width="30" align="center">View</th>
         <!-- <th width="30" align="center">Delete</th> -->
        </tr>
        </thead>
        <tbody>
        <?php if(empty($customer))
        echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($customer as $customer): 				
		?>
        <tr>
        <!-- td align="center"><input type="checkbox" name="action[]" value="<?php echo h($customer['CustomerBGPCopy']['customer_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td> -->
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $customer['CustomerBGPCopy']['application_no'];?></td>
         <td align="left"><?php  echo $customer['CustomerBGPCopy']['partner_code'];?></td>
		 <td align="left"><?php  echo $customer['CustomerBGPCopy']['applicant_name'];?></td>
		 <td align="left"><?php  echo $customer['CustomerBGPCopy']['contact_mobile'];?></td>
		 <td align="left"><?php  echo $customer['CustomerBGPCopy']['contact_email'];?></td>
		 <td align="left"><?php  echo $customer['CustomerBGPCopy']['initial_pay_by'];?></td>
		 
		 <td align="left"><?php  
		 if($customer['CustomerBGPCopy']['initial_pay_by'] != "Cheque") 
		 { 
			if(isset($customer['CustomerBGPCopy']['f_code'])) 
			{ 
				if($customer['CustomerBGPCopy']['f_code'] == "Ok") 
					{ 
						echo "Success"; 
					}
				else 
					{ 
						echo "Fail"; 
					} 
			} 
			else  
			{ 
				echo "Not received"; 
			} 
		}
		else 
		{ 
			echo "-"; 
		} 
		 ?></td>
		 <td align="left"><?php  if($customer['CustomerBGPCopy']['approve_status'] == "Rejected") { ?> <span title="<?php echo $customer['CustomerBGPCopy']['reason']; ?>"> <?php echo $customer['CustomerBGPCopy']['approve_status']; ?> </span><?php } else { echo $customer['CustomerBGPCopy']['approve_status']; }?></td>
		 
        <td align="center">
			<?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'approval_view', $customer['CustomerBGPCopy']['customer_id']),'border'=>0,'alt'=>__('Edit')) );?>
			</td>
      <!--  <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$customer['CustomerBGPCopy']['customer_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td> -->
        </tr>
        <?php $i++; endforeach;
        }
        ?>
        </tbody>
        </table>
        <div class="tablefooter clearfix">   
        <div class="actions">
<!-- <input type="submit" id="action_btn"  class="button small" value="Delete"  /> -->
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
function downloadform(id)
{
	//alert(id);
	window.location.href="<?php echo BASE_URL; ?>admin/customermaster/generateForm?id="+id;
}

function downloadAC(id)
{
	window.location.href="<?php echo BASE_URL; ?>admin/customermaster/generateAC?id="+id;
}
    		
</script>