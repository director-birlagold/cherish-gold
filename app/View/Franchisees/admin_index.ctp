<?php //print_r($vendor);exit;?>
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
		if(isset($_REQUEST['searchname'])){
			$u_name =$_REQUEST['searchname'];
		}else{
			$u_name ='0';
		}
		if(isset($_REQUEST['searchemail'])){
			$u_email =$_REQUEST['searchemail'];
		}else{
			$u_email ='0';
		}
		if(isset($_REQUEST['searchfranchise'])){
			$u_fra =$_REQUEST['searchfranchise'];
		}else{
			$u_fra ='0';
		}
	?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Franchisee'), array('action' => 'add'),array('class'=>'button')); ?></div> 
         <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_fexport',$cdate,$edate,$u_name,$u_email,$u_fra),array('class'=>'button')); ?></div> 

        <div class="titletag"><h1><?php echo __('Franchisee Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
		
        <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">
          <table cellpadding="0" cellspacing="2">
            <tr>
            <td><strong><?php echo __('Name');?> : </strong>&nbsp;</td>
            <td><input id="searchname" name="searchname" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchname'])){echo $_REQUEST['searchname'];}?>" /> </td>
            <td><strong><?php echo __('Email');?> : </strong>&nbsp;</td>
            <td><input id="searchemail" name="searchemail" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchemail'])){echo $_REQUEST['searchemail'];}?>" /> </td>
            
            <td><strong><?php echo __('Franchisee Code');?> : </strong>&nbsp;</td>
            <td><input id="searchfranchise" name="searchfranchise" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchfranchise'])){echo $_REQUEST['searchfranchise'];}?>" /> </td>
            
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
    	<?php echo $this->Form->create('franchisees', array('action' => 'delete','id'=>'myForm','Controller'=>'franchisees')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('name',' Name');?></th> 
         <th align="left"><?php echo $this->Paginator->sort('email',' Email');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('franchisee_code','Franchisee Code');?></th>  
            <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
            <th align="center" width="100"><?php echo __('Action');?></th> 
             <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($user))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($user as $user): 
		
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($user['User']['user_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo $user['User']['first_name'];?>&nbsp;&nbsp;
		<?php  echo $user['User']['last_name'];?></td>
        <td align="left"><?php  echo $user['User']['email'];?></td>
         <td align="left"><?php  echo $user['User']['franchisee_code'];?></td>
          <td align="left"><?php  echo $user['User']['status'];?></td>
       <td align="center"><?php echo h($user['User']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$user['User']['user_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$user['User']['user_id'],'Active')); ?></td> 
       <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $user['User']['user_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$user['User']['user_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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
	$( "#cdate" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#edate" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>