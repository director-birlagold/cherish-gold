<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
            <div class="btnlink"><?php echo $this->Html->link(__('+Add Gold Price'), array('action' => 'add'),array('class'=>'button')); ?></div>         
            <div class="titletag"><h1><?php echo __('Gold Price'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix">
          <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr><td><strong><?php echo __('Gold Price');?> : </strong>&nbsp;</td>
            <td><input id="searchdate" name="searchdate" type="date" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchdate'])){echo $_REQUEST['searchdate'];}?>" /></td><td>&nbsp;</td>        
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>   
        </div>
    	<?php echo $this->Form->create('Gold Price', array('action' => 'delete','id'=>'myForm','Controller'=>'categories')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
        <!-- <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="" class="" />'); ?></th>  
         <th width="30" align="center"><?php echo __('#');?></th>        -->
         <th align="left"><?php echo $this->Paginator->sort('id','Id');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('gold_price','Gold Price');?></th> 
        <th align="left"><?php echo $this->Paginator->sort('gold_date','Gold Date');?></th> 
		<th width="30" align="center">Edit</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($gold))
        echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($gold as $gold): 				
		?>
        <tr>
        <!-- <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($gold['GoldPrice']['category_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td> -->
        <td align="left"><?php  echo $gold['GoldPrice']['id'];?></td>
         <td align="left"><?php  echo $gold['GoldPrice']['gold_price'];?></td>
          <td align="left"><?php  echo date("d-m-Y",strtotime($gold['GoldPrice']['gold_date']));?></td>
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $gold['GoldPrice']['id']),'border'=>0,'alt'=>__('Edit')) );?></td>
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