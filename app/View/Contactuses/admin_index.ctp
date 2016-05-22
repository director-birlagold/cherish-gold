<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_contactus_export'),array('class'=>'button')); ?></div> 	
        <div class="titletag"><h1><?php echo __('Contact List'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
            <form name="searchfilters" action="" id="myForm1" method="post" style="width:1170px;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
            <td>&nbsp;<strong>From Date:&nbsp;</strong></td><td><input id="cdate" name="cdate"     type="text" value="<?php if(isset($_REQUEST['cdate'])){echo $_REQUEST['cdate'];}?>" /></td>  
            <td>&nbsp;<strong>To Date :&nbsp;</strong></td><td><input id="edate" name="edate"    type="text" value="<?php if(isset($_REQUEST['edate'])){echo $_REQUEST['edate'];}?>" /></td>  
            <td ><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
           <td>
		   <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'admin_index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr>
          
             
            
            </table></form>        
        </div>
    	<?php echo $this->Form->create('Contactuses', array('action' => 'delete','id'=>'myForm','Controller'=>'contactuses')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="validate[minCheckbox[1]] checkbox" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th> 
            
           <th align="left"><?php echo "Type";?></th>
           <th align="left"><?php echo "Name";?></th>    
           <th align="left"><?php echo "Email";?></th>
           <th align="left"><?php echo "Phone";?></th>
		 <th align="left"><?php echo "City";?></th>
           <th align="left"><?php echo "Created date";?></th>
          
          <th width="30" align="center">view</th>
   
              <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($contact))
        echo '<tr><td colspan="10" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
		//print_r($member);exit;
        foreach ($contact as $contact): 
	
		//$contacts=ClassRegistry::init('Contact')->find('all',array('conditions'=>array('contacts_id')));	
		//$country=ClassRegistry::init('Country')->find('first',array('conditions'=>array('cid'=>$member['Member']['country'])));	
		?>
        <tr>
        <td align="center">
        <?php //echo $this->Html->image('icons/arrow.jpg');?>
        <input type="checkbox" name="action[]"  class="validate[minCheckbox[1]] checkbox" value="<?php echo h($contact['Contactus']['contact_id']); ?>" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
         <td align="left"><?php echo($contact['Contactus']['type'])?> </td>
        <td align="left"><?php echo(!empty($contact)?$contact['Contactus']['name']:'-');?> </td>
        <td align="left"><?php echo($contact['Contactus']['email']); ?></td>
        <td align="left"><?php echo $contact['Contactus']['mobile'];?></td>
        <td align="left"><?php echo ($contact['Contactus']['city']); ?></td>
       <td align="left"><?php echo ($contact['Contactus']['created_date']); ?></td>
        <td align="center"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'view', $contact['Contactus']['contact_id']),'border'=>0,'alt'=>__('View')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$contact['Contactus']['contact_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
     
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