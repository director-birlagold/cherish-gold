<div id="content" class="clearfix"> 
	<div class="container">
    <div class="mainheading">   
    <div class="btnlink"><?php echo $this->Html->link(__('+Export'), array('action' => 'admin_question_export'),array('class'=>'button')); ?></div>
        <div class="titletag"><h1><?php echo __('Have a Question page'); ?></h1></div>
    </div>
 <div class="tablefooter clearfix">
 
  <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr><td><strong><?php echo __('Product Name');?> : </strong>&nbsp;</td>
            <td>
            <input id="searchcontat" name="searchproduct" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchproduct'])){echo $_REQUEST['searchproduct'];}?>" />
            </td>
          <td>&nbsp;</td>
          <td><strong><?php echo __('Contact No');?> : </strong>&nbsp;</td>
            <td><input id="searchcontat" name="searchcontat" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchcontat'])){echo $_REQUEST['searchcontat'];}?>" /></td>
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'question'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>  
       
  </div>
 <?php echo $this->Form->create('webpages', array('action' => 'que_delete','id'=>'myForm')); ?>
    <table class="gtable sortable">
        <thead>
        <tr>
             <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
            <th width="30" align="center">#</th>
            <th align="left" class="title"><?php echo $this->Paginator->sort('name',__('Name')); ?></th> 
            <th align="left" class="title"><?php echo __('Product Name'); ?></th> 
              <th align="left" class="title"><?php echo __('Email'); ?></th> 
            <th align="left" class="title"><?php echo __('Contact No'); ?></th> 
            <th align="left"><?php echo __('View');?></th>     
            <th width="50" align="center"><?php echo __('Delete');?></th>                   
        </tr>
        </thead>
        <tbody>  
		<?php  if(empty($question))
		
		echo '<tr><td colspan="4" align="center">'.__('No records found').'</td></tr>';
	else{
		$i=$this->Paginator->counter('{:start}');
		foreach($question as $question){
			$product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id'=>$question['Question']['product_id'])));			
			?>
      <tr >
       <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($question['Question']['question_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo $i; ?></td>
        <td align="left"><?php echo h($question['Question']['name']);?></td> 
          <td align="left"><?php echo h($product['Product']['product_name']);?></td> 
         <td align="left"><?php  echo h($question['Question']['email']);?></td> 
          <td align="left"><?php echo h($question['Question']['contact_no']);?></td> 
          <td align="left"><?php echo $this->Html->image('icons/view.png',array('url'=>array('action'=>'view', $question['Question']['question_id']),'border'=>0,'alt'=>__('View')) );?></td>       
        <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'que_delete',$question['Question']['question_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>     
      </tr>
      <?php $i++;
	  }
	  }?>
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