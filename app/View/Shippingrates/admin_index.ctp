<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Shipping Rates'), array('action' => 'add'),array('class'=>'button')); ?></div>
         <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_shippingrates_export'),array('class'=>'button')); ?></div>
          <div class="btnlink"><?php echo $this->Html->link(__('+Import'), array('action' => 'admin_shippingrates_import'),array('class'=>'button')); ?></div>  	
        <div class="titletag"><h1><?php echo __('Shipping Rates Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
             <form name="searchfilters" action="" id="myForm1" method="post"  style="width:1000px;float:left;padding: 10px 0px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
                       <td><strong>City : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchterm" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchterm'])){echo $_REQUEST['searchterm'];}?>" /></td>
            <td>&nbsp;</td>
             <td>&nbsp;<strong>Pincode:&nbsp;</strong></td><td><input id="searchpincode" name="searchpincode"     type="text" value="<?php if(isset($_REQUEST['searchpincode'])){echo $_REQUEST['searchpincode'];}?>" /></td>  
             <td>&nbsp;<strong>Deliver Days:&nbsp;</strong></td><td><input id="searchdeliveryday" name="searchdeliveryday"    type="text" value="<?php if(isset($_REQUEST['searchdeliveryday'])){echo $_REQUEST['searchdeliveryday'];}?>" /></td>        
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'admin_index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>  
        </div>
    	<?php echo $this->Form->create('Shippingrate', array('action' => 'delete','id'=>'myForm','Controller'=>'shippingrates')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('state','State');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('city','City');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('pincode','Pincode');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('delivery_date','Deliver Days');?></th> 
             <th align="left"><?php echo $this->Paginator->sort('taxcode','Tax Code');?></th> 
              <th align="left"><?php echo $this->Paginator->sort('taxrate','Tax Rate');?></th> 
             
               <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
         <th align="left"><?php echo $this->Paginator->sort('','Action');?></th>
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($shippingrates))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($shippingrates as $shippingrates): 
				
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($shippingrates['Shippingrate']['sid']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
         <td align="left"><?php  echo $shippingrates['Shippingrate']['state'];?></td>
        <td align="left"><?php  echo $shippingrates['Shippingrate']['city'];?></td>
         <td align="left"><?php  echo $shippingrates['Shippingrate']['pincode'];?></td>
          <td align="left"><?php  echo $shippingrates['Shippingrate']['delivery_date'];?></td>
          <td align="left"><?php  echo $shippingrates['Shippingrate']['taxcode'];?></td>
           <td align="left"><?php  echo $shippingrates['Shippingrate']['taxrate'];?></td>
          <td align="left"><?php  echo $shippingrates['Shippingrate']['status'];?></td>
          
          <td align="left"><?php echo h($shippingrates['Shippingrate']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$shippingrates['Shippingrate']['sid'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$shippingrates['Shippingrate']['sid'],'Active')); ?></td> 
       
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$shippingrates['Shippingrate']['sid']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$shippingrates['Shippingrate']['sid']),'border'=>0,
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
