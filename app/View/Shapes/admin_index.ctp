<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php echo $this->Html->link(__('+Add Shape'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="titletag"><h1><?php echo __('Shape Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
      <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">
        <table cellpadding="0" cellspacing="2">
          <tr>
         
            <td><strong>Shape : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchshape" type="text" class="validate[groupRequired[]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchshape'])){echo $_REQUEST['searchshape'];}?>" /></td>
            <td>&nbsp;</td>
            
            <td><input type="hidden" name="searchfilter" value="1"/>
              <input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td><?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
          </tr>
        </table>
      </form>
    </div>
    	<?php echo $this->Form->create('Shape', array('action' => 'delete','id'=>'myForm','Controller'=>'shapes')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('stone','Shape');?></th>
          
        <!--  <th align="center" width="100"><?php echo __('Action');?></th> -->
         <th width="30" align="center">Edit</th>
         <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($shape))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($shape as $shape): 
				
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($shape['Shape']['shape_id']); ?>" class="validate[minCheckbox[1]] checkbox"  rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php 
        echo $shape['Shape']['shape'];
		
		
        ?>
        </td>
      
        <!-- <td align="center"><?php echo h($shape['Shape']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$shape['Shape']['shape_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$shape['Shape']['shape_id'],'Active')); ?></td> -->
        
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $shape['Shape']['shape_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$shape['Shape']['shape_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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