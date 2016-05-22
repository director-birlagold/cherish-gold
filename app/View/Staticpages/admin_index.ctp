<div id="content" class="clearfix"> 
	<div class="container">
    <div class="mainheading">   
    <div class="btnlink"><?php // echo $this->Html->link(__('Add  Content page'), array('action' => 'add'),array('class'=>'button')); ?></div> 	
        <div class="titletag"><h1><?php echo __('Content Pages'); ?></h1></div>
    </div>
 <!-- <div class="tablefooter clearfix">
 <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">  
        <table cellpadding="0" cellspacing="2">
        <tr><td><strong><?php echo __('Title');?> : </strong>&nbsp;</td>
        <td><input id="searchname" name="searchname" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchname'])){echo $_REQUEST['searchname'];}?>" /></td><td>&nbsp;</td>        
        <td><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
		<?php if(isset($_REQUEST['search'])){			
			echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
		} ?></td>
        </tr></table></form>        
  </div>-->
 <?php echo $this->Form->create('Staticpage', array('action' => '','id'=>'myForm')); ?>
    <table class="gtable sortable">
        <thead>
        <tr>
            <th width="30" align="center"><?php echo $this->Html->image('arrow.jpg'); ?></th>
            <th width="30" align="center">#</th>
            <th align="left" class="title"><?php echo $this->Paginator->sort('pagename',__('Page Name')); ?></th> 
            <th width="50" align="center"><?php echo __('Edit');?></th>                   
        </tr>
        </thead>
        <tbody>  
		<?php if(empty($staticpages))
		echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
	else{
		$i=$this->Paginator->counter('{:start}');
		foreach($staticpages as $staticpage){			
			?>
      <tr >
      <td align="center"><?php echo $this->Html->image('arrow.jpg'); ?></td>
        <td align="center"><?php echo $i; ?></td>
        <td align="left"><?php echo h($staticpage['Staticpage']['pagename']);?></td>        
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $staticpage['Staticpage']['staticpage_id']),'border'=>0,'alt'=>__('Edit')) );?></td>      
      </tr>
      <?php $i++;
	  }
	  }?>
        </tbody>
    </table>
  <div class="tablefooter clearfix"> 
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