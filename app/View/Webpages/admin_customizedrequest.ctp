<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php //echo $this->Html->link(__('+Add E-mail Content'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="titletag"><h1>Customized Jewellery Request</h1></div>
<div class="btnlink"><a class="button" href="<?php echo BASE_URL; ?>admin/webpages/product_custom_request">+Export</a></div>
        </div>
        <div class="tablefooter clearfix">
                 
        </div>
<?php //echo $this->Form->create('', array('action' => 'delete_custom_request','id'=>'myForm','Controller'=>'webpages')); ?>       
        <form accept-charset="utf-8" method="post" controller="webpages" id="myForm" action="<?php echo BASE_URL; ?>admin/webpages/delete_custom_request">
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
            <th align="center" width="30"><div class="checker" id="uniform-checkAllAuto"><span><input type="checkbox" class="" value="0" name="action[]" id="checkAllAuto" style="opacity: 0;"></span></div></th>
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left">Name</th> 
         <th align="left">Email</th> 
         <th width="30" align="center">Mobile</th>
         <th width="30" align="center">Delete</th>
        <th width="30" align="center">View</th>       
        </tr>
        </thead>
        <tbody>
        <?php if(empty($Jewellrequest))
        echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($Jewellrequest as $Jewellreques): 		
		?>
        <tr>
               <td align="center"><input type="checkbox" name="action[]" value="<?php echo $Jewellreques['Jewellrequest']['req_id'];?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
       
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php echo $Jewellreques['Jewellrequest']['name'];?></td>
        <td align="left"><?php echo $Jewellreques['Jewellrequest']['email'];?></td>
        <td align="left"><?php echo $Jewellreques['Jewellrequest']['mobile'];?></td>
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'deletecrequest',"?id=". $Jewellreques['Jewellrequest']['req_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
         <td align="center"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'viewrequest',"?id=".$Jewellreques['Jewellrequest']['req_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
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
