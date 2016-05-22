<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
            <!-- <div class="btnlink"><?php echo $this->Html->link(__('+Add Category'), array('action' => 'add'),array('class'=>'button')); ?></div>          -->
            <div class="titletag"><h1><?php echo __('Referral-'); ?></h1></div>
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
			
			<td><strong><?php echo __('Mobile');?> : </strong>&nbsp;</td>
            <td><input id="searchmobile" name="searchphone" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchphone'])){echo $_REQUEST['searchphone'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<tr style="padding:10px">
			<td><strong><?php echo __('Name');?> : </strong>&nbsp;</td>
            <td><input id="searchname" name="searchname" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchname'])){echo $_REQUEST['searchname'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><strong><?php echo __('Status');?> : </strong>&nbsp;</td>
            <td><input id="searchstatus" name="searchstatus" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchstatus'])){echo $_REQUEST['searchstatus'];}?>" /></td><td>&nbsp;</td>        
            <td style="padding-right:10px;">&nbsp;</td>
			
			<td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>

			<td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>   
        </div>
    	<!--<?php echo $this->Form->create('Referral', array('action' => 'delete','id'=>'myForm','Controller'=>'relationshipmanager')); ?> -->
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
        <!--  <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="" class="" />'); ?></th>  -->
         <th width="30" align="center"><?php echo __('#');?></th>        
         
		<th align="left"><?php echo $this->Paginator->sort('referral_name','Referral Name');?></th>
		<th align="left"><?php echo $this->Paginator->sort('contact_mobile','Mobile');?></th>
		<th align="left"><?php echo $this->Paginator->sort('contact_phone','Phone');?></th>
		<th align="left"><?php echo $this->Paginator->sort('contact_email','EMail');?></th>	
		<th align="left"><?php echo $this->Paginator->sort('status','Status');?></th>	
		<th align="left"></th>
        <!-- <th width="30" align="center">View</th>
        <th width="30" align="center">Delete</th> -->
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
        <!-- td align="center"><input type="checkbox" name="action[]" value="<?php echo h($customer['Referral']['referral_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td> -->
        <td align="center"><?php echo h($i); ?></td>
		 <td align="left"><?php  echo $customer['Referral']['referral_name'];?></td>
		 <td align="left"><?php  echo $customer['Referral']['contact_mobile'];?></td>
		 <td align="left"><?php  echo $customer['Referral']['contact_phone'];?></td>
		 <td align="left"><?php  echo $customer['Referral']['contact_email'];?></td>
		 <td align="left"><?php  echo $customer['Referral']['status'];?></td>
		 
        <td align="center">
			<?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'referraldetail', $customer['Referral']['referral_id']),'border'=>0,'alt'=>__('Edit')) );?>			
			</td>
       <!-- <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$customer['Referral']['customer_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td> -->
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