<div id="content" class="clearfix"> 
	<div class="container">
    <div class="mainheading">   
    <div class="btnlink"><?php // echo $this->Html->link(__('Add  Content page'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
       <div class="btnlink">
           <a href="javascript:void(0)" class="button" onclick="export_file()">+Export</a>
           <?php // echo $this->Html->link(__('+Export'), array(/*'action' => 'admin_user_export'*/'javascript:void(0)'),array('class'=>'button', 'onclick' => 'javascript:export_file()')); ?>
       </div>
        <div class="titletag"><h1><?php echo __('User Pages'); ?></h1></div>
    </div>
 <div class="tablefooter clearfix">
 <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">  
        <table cellpadding="0" cellspacing="2">
        <tr><td><strong>Email : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchterm" type="text"class="validate[required,custom[email]]text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchterm'])){echo $_REQUEST['searchterm'];}?>" /></td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="searchfilter" value="1"/>
              <input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td><?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'admin_index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
        </tr></table></form>        
  </div>
 <?php //echo $this->Form->create('signin', array('action' => 'delete','id'=>'myForm','Controller'=>'signin'));

  ?>
 <form name="User"  ccept-charset="utf-8" method="post"  controller=" signin" id="myForm" action="<?php echo BASE_URL?>admin/signin/delete">
    <table class="gtable sortable" >
        <thead>
        <tr>
            <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th>
            <th width="30" align="center">#</th>
            <th align="left" class="title"><?php echo $this->Paginator->sort('email',__('Email')); ?></th> 
            <th align="left" class="title"><?php echo __('Activation Link'); ?></th> 
              <th align="left" class="title"><?php echo __('Status'); ?></th> 
            <th align="left" class="title"><?php echo __('Action'); ?></th> 
            <th width="50" align="center"><?php echo __('Edit');?></th>     
            <th width="50" align="center"><?php echo __('Delete');?></th>                   
        </tr>
        </thead>
        <tbody>  
		<?php if(empty($user))
		echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
	else{
		$i=$this->Paginator->counter('{:start}');
		foreach($user as $users){			
			?>
      <tr >
      <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($users['User']['user_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo $i; ?></td>
        <td align="left"><?php echo h($users['User']['email']);?></td> 
        <td align="left"><?php echo $this->Html->link(__('Send'),array('action'=>'activate',$users['User']['user_id'])); ?></td> 
         <td align="left"><?php  echo h($users['User']['status']);?></td> 
        <td align="left"><?php echo h($users['User']['status'])=="Active" ? $this->Html->link(__('Click to Pending'),array('controller'=>'signin','action'=>'changestatus',$users['User']['user_id'],'Pending')) : $this->Html->link(__('Click to Active'),array('controller'=>'signin','action'=>'changestatus',$users['User']['user_id'],'Active')); ?></td>  
         <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$users['User']['user_id']),'border'=>0,'alt'=>__('Edit')) );?></td>     
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$users['User']['user_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>     
      </tr>
      <?php $i++;
	  }
	  }?>
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
 <?php //echo $this->Form->end(); ?>
 </form>
  </div>
</div>

<script type="text/javascript">
    function export_file(){
        var _chk = $('input[name="action[]"]:checked');
        if(_chk.length > 0){
            var userid = '';
            $(_chk).each(function(){
                userid += $(this).val() != '0' ? $(this).val()+',' : '';
            });
            userid = userid.slice(0, -1);
            url = '<?php echo BASE_URL ?>/admin/signin/user_export/'+userid;
        }else{
            url = '<?php echo BASE_URL ?>/admin/signin/user_export';
        }
        location.href = url;
        return false;
    }
</script>