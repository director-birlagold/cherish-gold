<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Brokerage status'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_brokeragestatus_export'),array('class'=>'button')); ?></div>
        <div class="titletag"><h1><?php echo __('Brokerage status'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
                 
        </div>
    	<?php //echo $this->Form->create('Brokeragestatus', array('action' => 'delete','id'=>'myForm','Controller'=>'brokeragestatuss')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php  echo $this->Html->image('icons/arrow.jpg');
		 //echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="validate[minCheckbox[1]] checkbox" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('brokeragestatus','Brokerage status');?></th> 
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($brokeragestatus))
        echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($brokeragestatus as $status):
		?>
        <tr>
        <td align="center"><?php echo $this->Html->image('icons/arrow.jpg');?></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php echo h($status['Brokeragestatus']['brokerage_status']); ?></td>
       
         
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $status['Brokeragestatus']['brokerage_sts_id']),'bbrokerage'=>0,'alt'=>__('Edit')) );?></td>
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$status['Brokeragestatus']['brokerage_sts_id']),'bbrokerage'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
        </tr>
        <?php $i++; endforeach;
        }
        ?>
        </tbody>
        </table>
        <div class="tablefooter clearfix">   
        <div class="actions">
<!--<input type="submit" id="action_btn"  class="button small" value="Delete"  />-->
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