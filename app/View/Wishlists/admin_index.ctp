
<div id="content" class="clearfix">
  <div class="container">
    <div class="mainheading">
      <div class="btnlink"><?php // echo $this->Html->link(__('+Add Price'), array('action' => 'add'),array('class'=>'button')); ?></div>
      <div class="titletag">
        <h1>Wish List Details</h1>
      </div>
    </div>
    <div class="tablefooter clearfix">
     <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">  
            <table cellpadding="0" cellspacing="2">
            <tr>
             <td><strong><?php echo __('User Name');?> : </strong>&nbsp;</td>
            <td><input id="username" name="username" type="text" class="validate[[username]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['username'])){echo $_REQUEST['username'];}?>" /></td> 
               
            <td><strong><?php echo __('Product Name');?> : </strong>&nbsp;</td>
            <td><input id="productname" name="productname" type="text" class="validate[[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['productname'])){echo $_REQUEST['productname'];}?>" />&nbsp;</td>
                
            <td><input type="hidden" name="searchfilter" value="1"/><input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td><td>
            <?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index'),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
            </tr></table></form>
    </div>
    <?php echo $this->Form->create('wishlists', array('Controller'=>'wishlists','action' => 'delete','id'=>'myForm')); ?>
    <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
      <thead>
        <tr>
          <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]"  class="validate[minCheckbox[1]] checkbox"  value="0"  />'); ?></th>
          <th width="30" align="center"><?php echo __('#');?></th>
          <th align="left"><?php echo __('User Name');?></th>
          <th align="left"><?php echo __('Product Name');?></th>
          <th align="left" width="100"><?php echo __('Status');?></th>
          <th align="center" width="100"><?php echo __('Action');?></th>
          <th width="30" align="center">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($wishlist))
        echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($wishlist as $wishlist): 	
		
		$product=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$wishlist['Whislist']['product_id'])));
		$user=ClassRegistry::init('User')->find('first',array('conditions'=>array('user_id'=>$wishlist['Whislist']['user_id'])));
			
		?>
        <tr>
          <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($wishlist['Whislist']['whislist_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
          <td align="center"><?php echo h($i); ?></td>
           <td align="left"><?php  echo $user['User']['first_name'];?> &nbsp;<?php echo $user['User']['last_name'];?></td>
           <td align="left"><?php  echo $product['Product']['product_name'];?></td>           
           <td align="left"><?php  echo $wishlist['Whislist']['status'];?></td>
          <td align="center"><?php echo h($wishlist['Whislist']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$wishlist['Whislist']['whislist_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$wishlist['Whislist']['whislist_id'],'Active')); ?></td>
          <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$wishlist['Whislist']['whislist_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
        
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
    <?php echo $this->Form->end(); ?> </div>
</div>
<script>
$(document).ready(function(){
	$('.metal').click(function(){
		var id=$(this).val();
		$.ajax({
		type: "POST",
		url: "<?php echo BASE_URL; ?>prices/metal_type/",
		data: 'id='+id,
	    dataType: 'json',
		success: function (data) {
			 appenddata = "<select name='searchname' class='searchname' id='searchname'><option value=''>Select</option>";
                        $.each(data, function (k, v) {
                            appenddata += "<option value = '" +v.Jeweltype.type_id + "' '>" +v.Jeweltype.name + " </option>";
                        });
                        appenddata += "</select>";
                        $('#searchname').html(appenddata);
					    $('#searchname').parents('.selector').find('span').html('select');
                      
          }
		});
		
    });
	
		
	});
	

</script>
