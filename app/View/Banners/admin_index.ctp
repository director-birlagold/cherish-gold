<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
            <div class="btnlink"><?php echo $this->Html->link(__('+Add Banner'), array('action' => 'add'),array('class'=>'button')); ?></div>         
            <div class="titletag"><h1><?php echo __('Banner'); ?></h1></div>
        </div>
       
    	<?php echo $this->Form->create('Banner', array('action' => 'delete','id'=>'myForm','Controller'=>'banner')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo $this->Html->image('arrow.jpg'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th> 
         <th align="left">Title</th>       
        <!-- <th align="left">Banner</th> -->
         <th align="center" width="100"><?php echo $this->Paginator->sort('status','Status');?></th> 
         <th align="center"><?php echo __('Action');?></th> 
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($banners))
        echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($banners as $banners): 				
		?>
        <tr>
        <td align="center"><?php echo $this->Html->image('arrow.jpg'); ?></td>
        <td align="center"><?php echo h($i); ?></td>  
         <td align="left"><?php  echo $banners['Banner']['title'];?></td>      
        <!--<td align="left"><?php  //echo $this->Html->image('banner/'.$banners['Banner']['image'],array('width'=>'80','style'=>'padding:5px;'));?></td>-->
        <td align="center"><?php echo h($banners['Banner']['status']); ?></td>      
        <td align="center"><?php echo h($banners['Banner']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$banners['Banner']['bid'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$banners['Banner']['bid'],'Active')); ?></td> 
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $banners['Banner']['bid']),'border'=>0,'alt'=>__('Edit')) );?></td>
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$banners['Banner']['bid']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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