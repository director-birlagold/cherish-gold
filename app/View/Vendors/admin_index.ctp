<?php //print_r($status);exit;?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Vendor'), array('action' => 'add'),array('class'=>'button')); ?></div> 
         <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'vendor_export'),array('class'=>'button')); ?></div> 

        <div class="titletag"><h1><?php echo __('Vendor Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
            
           <td><strong><?php echo __('Company Name');?> : </strong>&nbsp;</td>
            <td>
            <select name="searchvendorname" id="searchvendorname">
          <option value="">Name</option>
          <?php
		 
		  foreach($vendorstatus as $vendorstatus){
			  echo '<option value="'.$vendorstatus['Vendor']['vendor_id'].'" '.(isset($_REQUEST['searchvendorname']) && $_REQUEST['searchvendorname']==$vendorstatus['Vendor']['vendor_id']?'selected="selected"':'').'>'.$vendorstatus['Vendor']['Company_name'].'</option>';
		  }
		  ?>
          </select>
            
            <!--<input id="companyname" name="companyname" type="text"  autocomplete="off" value="<?php if(isset($_REQUEST['companyname'])){echo $_REQUEST['companyname'];}?>" />--></td><td>&nbsp;</td> 
            <td><strong><?php echo __('V. Code');?> : </strong>&nbsp;</td>
            <td><input id="vendorcode" name="vendorcode" type="text"  autocomplete="off" value="<?php if(isset($_REQUEST['vendorcode'])){echo $_REQUEST['vendorcode'];}?>" /></td><td>&nbsp;</td>
            <td><strong><?php echo __('V. Status');?> : </strong>&nbsp;</td>
            <td><select name="searchvendorstatus" id="searchvendorstatus">
          <option value="">Status</option>
          <?php
		 
		  foreach($status as $status){
			  echo '<option value="'.$status['Status']['vendor_status_id'].'" '.(isset($_REQUEST['searchvendorstatus']) && $_REQUEST['searchvendorstatus']==$status['Status']['vendor_status_id']?'selected="selected"':'').'>'.$status['Status']['vendor_status'].'</option>';
		  }
		  ?>
          </select></td><td>&nbsp;</td>
          <td><strong><?php echo __('V. Type');?> : </strong>&nbsp;</td>
            <td><select name="searchvendortype" id="searchvendortype">
          <option value="">Type</option>
          <?php
		 
		  foreach($type as $type){
			  echo '<option value="'.$type['Type']['vendor_type_id'].'" '.(isset($_REQUEST['searchvendortype']) && $_REQUEST['searchvendortype']==$type['Type']['vendor_type_id']?'selected="selected"':'').'>'.$type['Type']['vendor_type'].'</option>';
		  }
		  ?>
          </select></td><td>&nbsp;</td>
            <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>      
                   
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>     
        </div>
    	<?php echo $this->Form->create('Vendor', array('action' => 'delete','id'=>'myForm','Controller'=>'vendors')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('Company_name','Company Name');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('vendor_code','Vendor Code');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('vendor_status','Vendor Status');?></th> 
            <th align="left"><?php echo $this->Paginator->sort('vendor_type','Vendor Type');?></th> 
            <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
            <th align="center" width="100"><?php echo __('Action');?></th> 
       <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($vendor))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($vendor as $vendor): 
		$vendor_status=ClassRegistry::init('Status')->find('first',array('conditions'=>array('vendor_status_id'=>$vendor['Vendor']['vendor_status'])));
		$vendor_type=ClassRegistry::init('Type')->find('first',array('conditions'=>array('vendor_type_id'=>$vendor['Vendor']['vendor_type'])));
				
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($vendor['Vendor']['vendor_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $vendor['Vendor']['Company_name'];?></td>
        <td align="left"><?php  echo $vendor['Vendor']['vendor_code'];?></td>
         <td align="left"><?php  echo $vendor_status['Status']['vendor_status'];?></td>
          <td align="left"><?php  echo $vendor_type['Type']['vendor_type'];?></td>
          <td align="left"><?php  echo $vendor['Vendor']['status'];?></td>
       <td align="center"><?php echo h($vendor['Vendor']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$vendor['Vendor']['vendor_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$vendor['Vendor']['vendor_id'],'Active')); ?></td> 
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $vendor['Vendor']['vendor_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$vendor['Vendor']['vendor_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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