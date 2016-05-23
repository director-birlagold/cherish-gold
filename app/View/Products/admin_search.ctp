<?php //print_r($vendor);exit;?>
<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
        <div class="btnlink"><?php // echo $this->Html->link(__('+Add product'), array('action' => 'add'),array('class'=>'button')); ?></div> 
        <div class="btnlink"><?php // echo $this->Html->link(__('+Export'), array('action' => 'admin_product_export'),array('class'=>'button')); ?></div>
        <div class="titletag"><h1><?php echo __('Product Details'); ?></h1></div>
        </div>
        <div class="tablefooter clearfix"></div>
    	<?php echo $this->Form->create('product', array('action' => 'delete','id'=>'myForm','Controller'=>'products')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
        <thead>
        <tr>
         <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="" />'); ?></th> 
         <th width="30" align="center"><?php echo __('#');?></th>        
         <th align="left"><?php echo $this->Paginator->sort('vendor name','Vendor Name');?></th> 
          <th align="left"><?php echo $this->Paginator->sort('vendor_code','Vendor Code');?></th>
            <th align="left"><?php echo $this->Paginator->sort('category_id','Category');?></th> 
           <th align="left"><?php echo $this->Paginator->sort('product_name','Product Name');?></th> 
            <th align="left"><?php echo $this->Paginator->sort('product_code','Product Code');?></th> 
            <th align="left"><?php echo $this->Paginator->sort('stock_quantity','Stock Quantity');?></th> 
            <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th> 
           <!-- <th align="center"><?php echo $this->Paginator->sort('images','Add Images');?></th> -->
            <th align="center" width="100"><?php echo __('Action');?></th> 
           <th width="30" align="center">Edit</th>
            <th width="30" align="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($product))
        echo '<tr><td colspan="5" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($product as $product): 
		$vendor_name=ClassRegistry::init('Vendorcontact')->find('first',array('conditions'=>array('vendor_id'=>$product['Product']['vendor_id'])));
		$vendor=ClassRegistry::init('Vendor')->find('first',array('conditions'=>array('vendor_id'=>$product['Product']['vendor_id'])));
		$vendor_type=ClassRegistry::init('Type')->find('first',array('conditions'=>array('vendor_type_id'=>@$vendor['Vendor']['vendor_type'])));
		$category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
		$code=$category['Category']['category_code'];
		$pattern = "/(\d+)/";
		$array = preg_split($pattern, $code, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					
		?>
        <tr>
        <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($product['Product']['product_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
        <td align="center"><?php echo h($i); ?></td>
        <td align="left"><?php  echo @$vendor['Vendor']['Company_name'];?></td>
        <td align="left"><?php  echo @$vendor['Vendor']['vendor_code'];?></td>
        <td align="left"><?php echo $category['Category']['category']?></td>
        <td align="left"><?php  echo $product['Product']['product_name'];?></td>
        <td align="left"><?php echo $array[0];?><?php  echo $product['Product']['product_code'];?></td>
        <td align="left"><?php  echo $product['Product']['stock_quantity'];?></td>
         <td align="left"><?php  echo $product['Product']['status'];?></td>
         <!--<td align="center"><?php  echo $this->Html->image('icons/photo.png',array('url'=>array('action'=>'addimages',$product['Product']['product_id']),'border'=>0,'alt'=>'Delete') ); ?></td>-->
       <td align="center"><?php echo h($product['Product']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$product['Product']['product_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$product['Product']['product_id'],'Active')); ?></td> 
        <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit', $product['Product']['product_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
       <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$product['Product']['product_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
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
<script type="text/javascript">
$(function() {
	$( "#cdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#edate" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>