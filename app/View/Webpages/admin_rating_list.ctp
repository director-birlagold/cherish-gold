<?php // print_r($award); exit;?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php //echo $this->Html->link(__('+Add Member'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="titletag"><h1><?php echo __('Rating List'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="" id="myForm1" method="post"  style="width:1000px;float:left;padding: 10px 0px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
            <td><strong><?php echo __('Product Name');?> : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchterm" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchterm'])){echo $_REQUEST['searchterm'];}?>" /></td>
            <td>&nbsp;</td>
             <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
             <td>&nbsp;<strong>To Date:&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>        
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'rating_list'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>        
        </div>
    	<?php  echo $this->Form->create('webpages', array('action' => 'rating_delete','id'=>'myForm','Controller'=>'webpages')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php  echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="validate[minCheckbox[1]] checkbox" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo 'Product Name';?></th>
        <th align="left"><?php echo 'Name';?></th>
         <th align="left" ><?php echo 'Title';?></th>
        <th align="left" ><?php echo 'Rating';?></th>
         <th align="left" ><?php echo 'Action';?></th>
          <th align="left" ><?php echo 'Status';?></th>
        <th width="30" align="center">View</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php  if(empty($rating)) 
        echo '<tr><td colspan="14" align="center">'.__('No records found').'</td></tr>';
       else{
        $i=$this->Paginator->counter('{:start}');  
		
        foreach ($rating as $rating): 
	 	$product=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$rating['Rating']['product_id'])));
		
		
		
		?>
        <tr>
         <td align="center">
        <input type="checkbox" name="action[]" value="<?php echo h($rating['Rating']['rating_id']); ?>" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php echo h($product['Product']['product_name']);?></td>
       <td align="left"><?php echo h($rating['Rating']['name']);?></td>
       <td align="left"><?php echo $rating['Rating']['title'];;?></td>
       <td align="left"><?php echo $rating['Rating']['rate'];?> Star</td>
       
       <td align="left"><?php echo h($rating['Rating']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$rating['Rating']['rating_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$rating['Rating']['rating_id'],'Active')); ?></td> 
        <td align="left"><?php echo __($rating['Rating']['status']); ?></td>
       <td align="center"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'rating_view', $rating['Rating']['rating_id']),'border'=>0,'alt'=>__('View')) );?></td>
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'rating_delete',$rating['Rating']['rating_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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