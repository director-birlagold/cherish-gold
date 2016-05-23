<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Order status'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_orderstatus_export'),array('class'=>'button')); ?></div>
        <div class="titletag"><h1><?php echo __('Order status'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
                 
        </div>
    	<?php //echo $this->Form->create('Orderstatus', array('action' => 'delete','id'=>'myForm','Controller'=>'orderstatuss')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('orderstatus','Order status');?></th> 
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($orderstatus))
        echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($orderstatus as $status):
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($status['Orderstatus']['order_sts_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php echo h($status['Orderstatus']['order_status']); ?></td>
       
         
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $status['Orderstatus']['order_sts_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$status['Orderstatus']['order_sts_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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