<div id="content" class="clearfix"> 
	<div class="container">
    <div class="mainheading">   
    <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_homeenquries_export'),array('class'=>'button')); ?></div>
        <div class="titletag"><h1><?php echo __('Home Page Enquiries'); ?></h1></div>
    </div>
 <div class="tablefooter clearfix">
 
 <form name="searchfilters" action="" id="myForm1" method="post" style="width:100%;float:left;padding: 5px 10px;">
        <table cellpadding="0" cellspacing="2">
          <tr>
            <td><strong>City : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchterm" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchterm'])){echo $_REQUEST['searchterm'];}?>" /></td>
            <td>&nbsp;</td>
            <td><strong>Phone : </strong>&nbsp;</td>
              <td><input id="searchphone" name="searchphone" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchphone'])){echo $_REQUEST['searchphone'];}?>" /></td>
              <td><strong>Pincode : </strong>&nbsp;</td>
              <td><input id="searchpincode" name="searchpincode" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchpincode'])){echo $_REQUEST['searchpincode'];}?>" /></td>
            <td>&nbsp;</td>
             <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>   
              <td><input type="hidden" name="searchfilter" value="1"/>
              <input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td><?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'home_enquiries'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
          </tr>
        </table>
      </form>
     
  </div>
 <?php echo $this->Form->create('webpages', array('action' => 'delete','id'=>'myForm')); ?>
    <table class="gtable sortable">
        <thead>
        <tr>
             <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
            <th width="30" align="center">#</th>
            <th align="left" class="title"><?php echo $this->Paginator->sort('name',__('Name')); ?></th> 
            <th align="left" class="title"><?php echo __('Phone No'); ?></th> 
              <th align="left" class="title"><?php echo __('City'); ?></th> 
            <th align="left" class="title"><?php echo __('Pincode'); ?></th> 
            <th align="left"><?php echo __('Created date');?></th>     
            <th width="50" align="center"><?php echo __('Delete');?></th>                   
        </tr>
        </thead>
        <tbody>  
		<?php if(empty($enquiry))
		echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
	else{
		$i=$this->Paginator->counter('{:start}');
		foreach($enquiry as $enquiry){			
			?>
      <tr >
       <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($enquiry['Enquries']['try_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo $i; ?></td>
        <td align="left"><?php echo h($enquiry['Enquries']['name']);?></td> 
         <td align="left"><?php  echo h($enquiry['Enquries']['phone']);?></td> 
          <td align="left"><?php echo h($enquiry['Enquries']['city']);?></td> 
         <td align="left"><?php  echo h($enquiry['Enquries']['pincode']);?></td> 
          <td align="left"><?php echo h($enquiry['Enquries']['created_date']);?></td> 
       
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$enquiry['Enquries']['try_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>     
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
 <?php echo $this->Form->end(); ?>
  </div>
</div>
<script type="text/javascript">
$(function() {
	$( "#cdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#edate" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>