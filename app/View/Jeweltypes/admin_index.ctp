<?php
if($type=="Size") {
    $suffix="";	
}
elseif($type=="Metals"){
	$suffix="";
}
elseif($type=="Purity"){
	$suffix="K";
}
elseif($type=="Stone"){
	$suffix="";
}
elseif($type=="Stone Clarity"){
	$suffix="";
}
elseif($type=="Stone Color"){
	$suffix="";
}
elseif($type=="Stone Carat"){
	$suffix="Carat";
}
elseif($type=="Stone Shape"){
	$suffix="";
}
elseif($type=="Setting Type"){
	$suffix="";
}
elseif($type=="Metal Color"){
	$suffix="";
}
?>
<div id="content" class="clearfix">
  <div class="container">
    <div class="mainheading">
      <div class="btnlink"><?php echo $this->Html->link(__('+Add '.$type), array('action' => 'add',$this->params['pass']['0']),array('class'=>'button')); ?></div>
      <div class="titletag">
        <h1><?php echo $type; ?></h1>
      </div>
    </div>
    <div class="tablefooter clearfix">
      <form name="searchfilters" action="" id="myForm1" method="post" style="width:800px;float:left;padding: 5px 10px;">
        <table cellpadding="0" cellspacing="2">
          <tr>
            <td><strong><?php echo $type;?> : </strong>&nbsp;</td>
            <td><input id="searchterm" name="searchterm" type="text" class="validate[groupRequired[payments]] text-input" autocomplete="off" value="<?php if(isset($_REQUEST['searchterm'])){echo $_REQUEST['searchterm'];}?>" /></td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="searchfilter" value="1"/>
              <input type="submit" name="searchbutton" class="button small" value="<?php echo __('Search');?>" /></td>
            <td>&nbsp;</td>
            <td><?php if(isset($_REQUEST['search'])){			
            echo $this->Html->link(__('Cancel'),array('action'=>'index',$type),array('class'=>'button small','style'=>'padding:3px 5px;','title'=>'Cancel Search'));
            } ?></td>
          </tr>
        </table>
      </form>
    </div>
    <?php echo $this->Form->create('', array('Controller'=>'jeweltypes','action' => 'delete/'.$this->params['pass']['0'],'id'=>'myForm')); ?>
    <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
      <thead>
        <tr>
          <th width="30" align="center"><?php echo __('<input type="checkbox" id="checkAllAuto" name="action[]"  class="validate[minCheckbox[1]] checkbox"  value="0"  />'); ?></th>
          <th width="30" align="center"><?php echo __('#');?></th>
          <th align="left"><?php echo $this->Paginator->sort('name',$type);?></th>
        <?php  if($this->params['pass']['0']=='size') {	 ?>
            <th align="left" ><?php echo $this->Paginator->sort('category','Category');?></th> 
              <th align="left"><?php echo $this->Paginator->sort('goldpurity','Gold Purity');?></th> 
                <th align="left"><?php echo $this->Paginator->sort('width','Width');?></th> 
                  <th align="left"><?php echo $this->Paginator->sort('height','Height');?></th> 
                    <th align="left"><?php echo $this->Paginator->sort('weight','Weight');?></th> 
                      <th align="left"><?php echo $this->Paginator->sort('making_charge','Making Charge');?></th> 
                      <?php } ?>
                         <?php  if($this->params['pass']['0']=='metal_color') {	 ?>
                         <th align="left" width="100"><?php echo $this->Paginator->sort('metals','Metal');?></th> 
                         <?php } ?>
                         <?php if($this->params['pass']['0']!="size") { ?>
          <th align="left"><?php echo $this->Paginator->sort('status','Status');?></th>
          <th align="center" width="100"><?php echo __('Action');?></th>
          <?php } ?>
          <th width="30" align="center">Edit</th>
            <?php if($this->params['pass']['0']!="size") { ?>
          <th width="30" align="center">Delete</th>
          <?php }?>
        </tr>
      </thead>
      <tbody>
      <?php
	  if($type=='Size'){
		  if(empty($productsize)){
			   echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
		  }else{
			  $i=$this->Paginator->counter('{:start}'); 
			   foreach ($productsize as $productsize): 			 	 
				  $categoty=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$productsize['Productsize']['category_id'])));
				  $purity=ClassRegistry::init('Jeweltype')->find('first',array('conditions'=>array('type_id'=>$productsize['Productsize']['goldpurity'])));
				  $size=ClassRegistry::init('Jeweltype')->find('first',array('conditions'=>array('type_id'=>$productsize['Productsize']['type_id'])));
				  ?>
                  <tr>
          <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($productsize['Productsize']['product_size']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
            <td align="center"><?php echo h($i); ?></td>
            <td align="left"><?php  echo $size['Jeweltype']['name'];?> </td>          
            <td align="left"><?php  echo $categoty['Category']['category'];?> &nbsp;</td>
            <td align="left"><?php  echo $purity['Jeweltype']['name'];?> &nbsp; K</td>
            <td align="left"><?php  echo $productsize['Productsize']['width'];?> &nbsp; </td>
            <td align="left"><?php  echo $productsize['Productsize']['height'];?> &nbsp; </td>
            <td align="left"><?php  echo $productsize['Productsize']['weight'];?> &nbsp; </td>
            <td align="left"><?php  echo $productsize['Productsize']['making_charge'];?> &nbsp; </td>         
          <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$this->params['pass']['0'],$productsize['Productsize']['product_size']),'border'=>0,'alt'=>__('Edit')) );?></td>
        <!--  <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$this->params['pass']['0'],$productsize['Productsize']['product_size']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>-->
        
        </tr>
                  <?php
				   $i++;
			   endforeach;
		  }
	  }else{
        if(empty($jeweltype))
        echo '<tr><td colspan="7" align="center">'.__('No records found').'</td></tr>';
        else{
        $i=$this->Paginator->counter('{:start}');
        foreach ($jeweltype as $jeweltypes): 
		if($this->params['pass']['0']=='size') {	
			$size=ClassRegistry::init('Productsize')->find('first',array('conditions'=>array('type_id'=>$jeweltypes['Jeweltype']['type_id'])));
			
			$categoty=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$size['Productsize']['category_id'])));
			$jewel=ClassRegistry::init('Jeweltype')->find('first',array('conditions'=>array('type_id'=>$size['Productsize']['goldpurity'])));
			
		}
		if($this->params['pass']['0']=='metal_color') {	
		
		$color=ClassRegistry::init('Metalcolor')->find('first',array('conditions'=>array('type_id'=>$jeweltypes['Jeweltype']['type_id'])));
		$jeweltypes_color=ClassRegistry::init('Jeweltype')->find('first',array('conditions'=>array('type_id'=>$color['Metalcolor']['metals'])));
		}
		
		?>
        <tr>
          <td align="center"><input type="checkbox" name="action[]" value="<?php echo h($jeweltypes['Jeweltype']['type_id']); ?>"  class="validate[minCheckbox[1]] checkbox" rel="action" /></td>
          <td align="center"><?php echo h($i); ?></td>
          <td align="left"><?php  echo $jeweltypes['Jeweltype']['name'];?> &nbsp;<?php echo $suffix;?></td>
          <?php if($this->params['pass']['0']=="size") { ?>
            <td align="left"><?php  echo $categoty['Category']['category'];?> &nbsp;</td>
               <td align="left"><?php  echo $jewel['Jeweltype']['name'];?> &nbsp; K</td>
                 <td align="left"><?php  echo $size['Productsize']['width'];?> &nbsp; </td>
                    <td align="left"><?php  echo $size['Productsize']['height'];?> &nbsp; </td>
                       <td align="left"><?php  echo $size['Productsize']['weight'];?> &nbsp; </td>
                          <td align="left"><?php  echo $size['Productsize']['making_charge'];?> &nbsp; </td>
          
          <?php } ?>
           <?php if($this->params['pass']['0']=="metal_color") { ?>
            <td align="left"><?php  echo $jeweltypes_color['Jeweltype']['name'];?> &nbsp;</td>
           <?php } ?>
          
        
          <?php if($this->params['pass']['0']!="size") { ?>
            <td align="left"><?php  echo $jeweltypes['Jeweltype']['status'];?></td>
          <td align="center"><?php echo h($jeweltypes['Jeweltype']['status'])=="Active" ? $this->Html->link(__('Click to Deactive'),array('action'=>'changestatus',$this->params['pass']['0'],$jeweltypes['Jeweltype']['type_id'],'Inactive')) : $this->Html->link(__('Click to Active'),array('action'=>'changestatus',$this->params['pass']['0'],$jeweltypes['Jeweltype']['type_id'],'Active')); ?></td>
          <?php } ?>
          <td align="center"><?php echo $this->Html->image('icons/edit.png',array('url'=>array('action'=>'edit',$this->params['pass']['0'],$jeweltypes['Jeweltype']['type_id']),'border'=>0,'alt'=>__('Edit')) );?></td>
          <td align="center"><?php echo $this->Html->image('icons/cross.png',array('url'=>array('action'=>'delete',$this->params['pass']['0'],$jeweltypes['Jeweltype']['type_id']),'border'=>0,'class'=>'confirdel','alt'=>__('Delete')) );?></td>
        
        </tr>
        
        <?php $i++; endforeach;
        }
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
    <?php echo $this->Form->end(); ?> </div>
</div>
