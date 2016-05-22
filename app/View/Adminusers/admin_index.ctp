<?php //print_r($adminusers);exit;?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('AdminUserAdd'))) ){?>
			<div class="btnlink"><?php echo $this->Html->link(__('+Add Admin User'), array('action' => 'add'),array('class'=>'button')); ?></div>
		<?php }?>
        
        <div class="titletag"><h1><?php echo __('Admin Users'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
           <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
            
             <td><strong><?php echo __('Username');?> : </strong>&nbsp;</td>
            <td><input id="username" name="username" type="text"  autocomplete="off" value="" /></td><td>&nbsp;</td>
             
            
            
              
                   
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>     
        </div>
    	<?php echo $this->Form->create('adminuser', array('action' => 'delete','id'=>'myForm','Controller'=>'Adminusers')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
               
         
           <th align="left"><?php echo $this->Paginator->sort('username','Username');?></th> 
            
            
           <th width="30" align="center">Edit</th>
            <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($adminusers))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($adminusers as $adminuser): 
		
		//$pattern = "/(\d+)/";
		//$array = preg_split($pattern, $code, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($adminuser['Adminuser']['admin_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        
        <td align="left"><?php  echo $adminuser['Adminuser']['username'];?></td>
        
       
        <td align="center">
		<?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('AdminUserEdit'))) ){?>	
			<?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $adminuser['Adminuser']['admin_id']),'border'=>0,'alt'=>__('Edit')) );?>
		<?php }?>	
		</td>
		<td align="center">
		<?php if( $this->requestAction('/App/hasPrivilege', array('pass' => array('AdminUserDelete'))) ){?>		
			<?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$adminuser['Adminuser']['admin_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?>
		<?php }?>	
		</td>
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