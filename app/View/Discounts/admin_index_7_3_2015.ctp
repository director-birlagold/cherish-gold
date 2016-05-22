<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Discount'), array('action' => 'add'),array('class'=>'button')); ?></div>
        <!-- <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_shippingrates_export'),array('class'=>'button')); ?></div>
          <div class="btnlink"><?php echo $this->Html->link(__('+Import'), array('action' => 'admin_shippingrates_import'),array('class'=>'button')); ?></div>  -->	
        <div class="titletag"><h1><?php echo __('Discount Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="" id="myForm1" method="post" style="width:850px;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
             <td><strong><?php echo __('Type');?> : </strong>&nbsp;</td>
            <td><input type="radio" id="checklist" class="validate[required] radio metal" name="searchtype" value="Vouchercode" <?php if(isset($_REQUEST['searchtype'])){echo $_REQUEST['searchtype'];}?> />Voucher Code&nbsp;&nbsp;&nbsp;
           <input type="radio" id="checklist" class="validate[required] radio metal" name="searchtype" value="Product" <?php if(isset($_REQUEST['searchtype'])){echo $_REQUEST['searchtype'];}?> />Product&nbsp;&nbsp;&nbsp;
            <input type="radio" id="checklist" class="validate[required] radio metal" name="searchtype" value="User" <?php if(isset($_REQUEST['searchtype'])){echo $_REQUEST['searchtype'];}?> />User&nbsp;&nbsp;&nbsp;
            <input type="radio" id="checklist" class="validate[required] radio metal" name="searchtype" value="Category" <?php if(isset($_REQUEST['searchtype'])){echo $_REQUEST['searchtype'];}?> />Category&nbsp;&nbsp;&nbsp;
           </td> 
             <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>          
           
                
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form> 
        </div>
    	<?php echo $this->Form->create('Discount', array('action' => 'delete','id'=>'myForm','Controller'=>'discounts')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('type','Type');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('percentage','Percentage');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
         <th align="left"><?php echo $this->Paginator->sort('','Action');?></th>
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($discounts))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($discounts as $discounts): 
				
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($discounts['Discount']['discount_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $discounts['Discount']['type'];?></td>
        <td align="left"><?php  echo $discounts['Discount']['percentage'];?></td>
               
          <td align="left"><?php  echo $discounts['Discount']['status'];?></td>
        
          <td align="left"><?php echo h($discounts['Discount']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$discounts['Discount']['discount_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$discounts['Discount']['discount_id'],'Active')); ?></td> 
       
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$discounts['Discount']['discount_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$discounts['Discount']['discount_id']),'border'=>0,
	   'class'=>'confirdel','alt'=>__('Delete')) );?></td>
        </tr>
        <?php $i++; endforeach;
        }
        ?>
        </tbody>
        </table>
        <div class="tablefooter clearfix">   
        <div class="actions">
<input type="submit" id="action_btn"  class="button small" value="Delete"  />
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