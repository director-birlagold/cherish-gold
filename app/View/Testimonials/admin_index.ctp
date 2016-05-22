<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add '.$cms), array('action' => 'add',$this->params['pass']['0']),array('class'=>'button')); ?></div> 	
         <div class="btnlink"><?php // echo $this->Html->link(__('+Export'), array('action' => 'newsletter_export'),array('class'=>'button')); ?></div> 

        <div class="titletag"><h1><?php echo __($cms.' Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
             
        </div>
    	<?php echo $this->Form->create('testimonials', array('action' => 'delete/'.$this->params['pass']['0'],'id'=>'myForm','Controller'=>'testimonials')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('name','Name');?></th> 
        <th align="center" width="100"><?php echo $this->Paginator->sort('status','Status');?></th> 
        <th align="center"><?php echo __('Action');?></th> 
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($testimonial))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($testimonial as $testimonial): 
				
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($testimonial['Testimonial']['test_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php   echo $testimonial['Testimonial']['name'];  ?></td>
        <td align="center"><?php echo h($testimonial['Testimonial']['status']); ?></td>      
       <td align="center"><?php echo h($testimonial['Testimonial']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$this->params['pass']['0'],$testimonial['Testimonial']['test_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$this->params['pass']['0'],$testimonial['Testimonial']['test_id'],'Active')); ?></td> 
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$this->params['pass']['0'], $testimonial['Testimonial']['test_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$this->params['pass']['0'],$testimonial['Testimonial']['test_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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