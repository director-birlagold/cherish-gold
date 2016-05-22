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
	?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Locateus'), array('action' => 'add'),array('class'=>'button')); ?>
		<?php echo $this->Html->link(__('+Export'), array('action' => 'admin_locate_export',$cdate,$edate),array('class'=>'button')); ?></div>
          <div class="titletag"><h1><?php echo __('Locateus  Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilter_loc" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
             <td><strong>Name </strong>&nbsp;</td>
            <td><input id="searchname" name="searchname" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchname'])){echo $_REQUEST['searchname'];}?>" />
           </td> 
            
           <td><strong>Email </strong>&nbsp;</td>
            <td><input id="searchemail" name="searchemail" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchemail'])){echo $_REQUEST['searchemail'];}?>" />
           </td>
          <!-- <td><strong>Phone </strong>&nbsp;</td>
            <td><input id="searchphone" name="searchphone" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchphone'])){echo $_REQUEST['searchphone'];}?>" />
           </td>-->
             <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td> 
             
            <td><input type="hidden" name="searchfilter_loc" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search_loc'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form> 
        </div>
    	<?php //echo $this->Form->create('locateus', array('action' => 'locateus/delete','id'=>'myForm')); ?>
        <form id="myForm" name="locatus" action="<?php echo BASE_URL;?>admin/locateus/delete" method="post">
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('name','Name');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('state','State');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('city','City');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('email','Email');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
         <th align="left"><?php echo $this->Paginator->sort('','Action');?></th>
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($locateus))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($locateus as $locateus): 
			$city=ClassRegistry::init('Cities')->find('first',array('conditions'=>array('city_id'=>$locateus['Locateus']['city'])));
			$state=ClassRegistry::init('States')->find('first',array('conditions'=>array('state_id'=>$locateus['Locateus']['state'])));	
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($locateus['Locateus']['locateus_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $locateus['Locateus']['name'];?></td>
          <td align="left"><?php  echo $state['States']['state'];?></td>
            <td align="left"><?php  echo $city['Cities']['city'];?></td>
              <td align="left"><?php  echo $locateus['Locateus']['email'];?></td>
               <td align="left"><?php  echo $locateus['Locateus']['status'];?></td>  
               
          <td align="left"><?php echo h($locateus['Locateus']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$locateus['Locateus']['locateus_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$locateus['Locateus']['locateus_id'],'Active')); ?></td> 
       
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$locateus['Locateus']['locateus_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$locateus['Locateus']['locateus_id']),'border'=>0,
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