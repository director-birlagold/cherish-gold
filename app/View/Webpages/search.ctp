<?php
	echo $this->Html->css(array('page'));
    echo $this->Html->script(array('script'));	
?>
<script type="text/javascript" src="http://www.jquery4u.com/demos/jquery-quick-pagination/js/jquery.quick.pagination.min.js"></script>
<div class="main">
  <header> &nbsp; </header>
  <div style="clear:both;">&nbsp;</div>
  
  <!--- New HTML Start -->
  
  <div class="productInfoDiv">
    <div class="productMiddleDeatil">
      <div class="topsubmenudiv">
        <div class="topsubmenu">
          <ul>
          <?php
		  ?>
            <li><?php echo $this->Html->link( $this->Html->image("home_btn.png",array("alt" => "index")),array('controller'=>'webpages','action'=>'index'), array('escape' => false));?></li>
            <li><a href="#"><?php echo $this->Html->link( $this->Html->image("jewellery_btn.png",array("alt" => "index")),array('controller'=>'webpages','action'=>'jewellery'), array('escape' => false)); ?></a></li>
            
           
          </ul>
        </div>
      </div>
    </div>
    <div class="shadow"><?php  echo $this->Html->image('shadow.png',array("alt" => "Image")); ?></div>
   
    <p><h2>Search Results For "<?php if(!empty($_REQUEST['search'])){ echo $this->request->query['search']; }else { echo $this->params['pass']['0']; }?>" </h2></p>
    <div style="border-bottom:2px solid #dba715; border-top:2px solid #dba715; width:100%; float:left; margin-bottom:10px;">
    	<div style="float:left; margin:10px 0px 0px 20px;">Search Criteria</div>
    	<div class="productMiddleWhatNew">
      <ul>
        <li><a href="#">WHAT'S NEW</a></li>
       
        <li><a href="#">POPULAR</a></li>
        <li><a href="#">PRICE</a></li>
      </ul>
      <div style="float:left; margin-right:15px;"> <a href="#"><?php  echo $this->Html->image('result_divider.jpg',array("alt" => "Image")); ?></a> </div>
      <div style="float:left; margin-top:8px;"> <a class="grid" style="cursor:pointer;" rel="grid"><?php  echo $this->Html->image('result_icn1.jpg',array("alt" => "Image")); ?></a>&nbsp;&nbsp; <a class="list" style="cursor:pointer;" rel="list"><?php  echo $this->Html->image('result_icn2.jpg',array("alt" => "Image")); ?></a> </div> 
      <div style="clear:both;"></div>
     
    </div>
   </div>
    <div style="float:right; font-size:12px;">
          <?php	    
	$outer_arr=$this->params['named'];

		   foreach($outer_arr as $key => $val) { 
        }
    $conditions=array();
	    if(!empty($key) && empty($_REQUEST['search'])) {
			if($key=='gemstone' || $key=='shape') {
		$productstone=ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array($key =>$val),'group'=>'product_id')); 
		if(!empty($productstone)) {

			foreach($productstone as $productstone) {			
				$id[]=$productstone['Productgemstone']['product_id'];
			}
			
			$conditions=array_merge($conditions,array('product_id IN ('.implode(",",$id).')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
	 	 
		}
		}if($key=='dia') {
		$productdiamond=ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('diamond' =>$val))); 
		if(!empty($productdiamond)) {

			foreach($productdiamond as $productdiamond) {			
				$id[]=$productdiamond['Productdiamond']['product_id'];
			}
			
				$conditions=array_merge($conditions,array('product_id IN ('.implode(",",$id).')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
				
			}
			 
		}
		if($key=='goldpurity'){
			$conditionschk=array();
			$productpurity=ClassRegistry::init('Productmetal')->find('all',array('conditions'=>array('value'=>$val,'type'=>'Purity'),'group'=>'product_id'));
				foreach($productpurity as $purity)
				{
				
					$conditionschk[]=$purity['Productmetal']['product_id'];
					
				}
				$ids=implode(',',$conditionschk);
				$conditions=array_merge($conditions,array('product_id IN ('.$ids.')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
				

			}
			
			
		
		if($key=='metal')
			{
				$conditions=array_merge($conditions,array('metal'=>$val,'product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
				
			}
		   }
			else
			{
				$conditions=array_merge($conditions,array('product_name LIKE'=>'%'.$this->request->query['search'].'%','status'=>'Active'));
				
			} 
				$productscount=ClassRegistry::init('Product')->find('all', array('conditions' =>$conditions,'order'=>'product_id DESC','limit'=>6)); 
				$counts=count($productscount);
				$productrep=ClassRegistry::init('Product')->find('all', array('conditions' => $conditions,'order'=>'product_id DESC')); 
				$count=count($productrep); 
			
			
			 ?>
  
    <input type="hidden" name="count" value="6" class="count" />
    <input type="hidden" name="countnew" value="<?php  echo $counts;?>" class="countnew" /> 
   Showing 1-<span class="countpage"><?php echo $counts;?></span> Of <?php  echo $count; ?> Results </div>
    <div style="clear:both;"></div>
    <div class="productMiddleDeatil">
      <div class="productMiddleLeft">
      <form method="get" id="left_side" name="left_side">
        <!--<ul>
          <li class="bg_none">
            <input name="" type="radio" value="">
            RINGS</li>
          <li>
            <input name="" type="radio" value="">
            OTHER</li>
        </ul>-->
        <!--<ul>
       
          <p>PRICE</p>
          <li class="bg_none">
            <input name="" type="radio" value="">
            BELOW &gt; 10,000/-</li>
          <li>
            <input name="" type="radio" value="">
            10,000/- &gt; 20,000/-</li>
          <li>
            <input name="" type="radio" value="">
            20,000/- &gt; 30,000/-</li>
          <li>
            <input name="" type="radio" value="">
            30,000/- &gt; 40,000/-</li>
           
          
        </ul>-->
       
        <ul>   <div class="shape">
            <p class="gold" rel="metal" value="purity">METAL</p>
          <?php $m='0'; 
		  foreach($metal as $metals) { ?>
          <li class="bg_none">
            <input name="metal" type="radio" value="<?php echo $metals['Metal']['metal_name'];?>" class="metals">
            <?php echo $metals['Metal']['metal_name'];?></li>
         <?php
		 $m=$m+1;
		
		  } ?></div>
          <?php if($m>3){?>
         <a class="more" rel="noreal">
               More
            <i>+</i>
           </a><?php }?>
            <a class="less" rel="noreal" style="display:none">
               Less
            <i>-</i>
           </a>
         
        </ul>
        <ul>    <div class="shape">
          <p class="gold" rel="goldpurity" value="purity">GOLD PURITY</p>
            <?php $pi='0';
			$purity=ClassRegistry::init('Purity')->find('all', array('conditions' => array('status'=>'Active'),'order'=>'purity_id ASC')); 
			foreach($purity as $purities) { ?>
          <li class="bg_none">
            <input name="goldpurity" type="radio" value="<?php echo $purities['Purity']['purity'];?>">
            <?php echo $purities['Purity']['purity'];?>K</li>
            <?php 
			$pi=$pi+1;
			
			}
			?></div><?php if($pi>3){?>
            <a class="more" rel="noreal" >
               More
            <i>+</i>
           </a><?php }?>
            <a class="less" rel="noreal" style="display:none">
               Less
            <i>-</i>
           </a>
        </ul>
        <ul>
      <div class="shape">
           <p class="gold" rel="gemstone" value="stone" id="dia"><p>STONES</p>
           <li class="bg_none" >
         <input name="dia" type="radio" value="<?php echo $diamond['Diamond']['name']?>" />
           <?php echo $diamond['Diamond']['name'];?>
           </li>  
           <?php $s='0';
		   foreach($stone as $stone) { ?>
          <li class="bg_none">
            <input name="gemstone" type="radio" value="<?php echo $stone['Gemstone']['stone'];?>">
           <?php echo $stone['Gemstone']['stone'];?></li>
           <?php $s=$s+1; } ?> </div>
           <?php if($s>2){?>
            <a class="more" rel="noreal" >
               More
            <i>+</i>
           </a><?php }?>
            <a class="less" rel="noreal" style="display:none">
               Less
            <i>-</i>
           </a>
          
        </ul>
       
       <!-- <ul>
          <p>OF STONES</p>
          <li class="bg_none">
            <input name="" type="radio" value="">
            SINGLE</li>
          <li class="bg_none">
            <input name="" type="radio" value="">
            THREE  STONE</li>
          <li class="bg_none">
            <input name="" type="radio" value="">
            FIVE STONE</li>
        </ul>-->
       <!-- <ul>
          <p>DESIGN</p>
          <li class="bg_none">
            <input name="" type="radio" value="">
            CLASSIC</li>
          <li class="bg_none">
            <input name="" type="radio" value="">
            BAND</li>
          <li class="bg_none">
            <input name="" type="radio" value="">
            FUSION</li>
          <li class="bg_none">
            <input name="" type="radio" value="">
            CLUSTER</li>
        </ul>-->
        <ul>
        <div class="shape">
          <p class="gold" rel="shape" value="stone_shape"><p>STONE SHAPE</p>
            <?php 
			$ss='0';
			foreach($shape as $shape) { ?>
          <li class="bg_none">
            <input name="shape" type="radio" value="<?php echo $shape['Shape']['shape'];?>">
            <?php echo $shape['Shape']['shape'];?></li>
          <?php $ss=$ss+1;} ?>
           </div>
           <?php  if($ss>3){?>
           <a class="more" rel="noreal">
               More
            <i>+</i>
           </a><?php }?>
            <a class="less" rel="noreal" style="display:none">
               Less
            <i>-</i>
           </a>
            </div>
        </ul>
       </form>
     
      <div class="productMiddleRight">
      <?php	    
	$outer_arr=$this->params['named'];

		   foreach($outer_arr as $key => $val) { 
        }
    $conditions=array();
	    if(!empty($key) && empty($_REQUEST['search'])) {
			if($key=='gemstone' || $key=='shape') {
		$productstone=ClassRegistry::init('Productgemstone')->find('all', array('conditions' => array($key =>$val),'group'=>'product_id')); 
		if(!empty($productstone)) {

			foreach($productstone as $productstone) {			
				$id[]=$productstone['Productgemstone']['product_id'];
			}
			
			$conditions=array_merge($conditions,array('product_id IN ('.implode(",",$id).')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));

			$product=ClassRegistry::init('Product')->find('all', array('conditions' =>$conditions,'order'=>'product_id DESC','limit'=>6));
			$productnewcount=ClassRegistry::init('Product')->find('count', array('conditions' => $conditions,'order'=>'product_id DESC'));  		
						 
			 
		}
		}if($key=='dia') {
		$productdiamond=ClassRegistry::init('Productdiamond')->find('all', array('conditions' => array('diamond' =>$val))); 
		if(!empty($productdiamond)) {

			foreach($productdiamond as $productdiamond) {			
				$id[]=$productdiamond['Productdiamond']['product_id'];
			}
			
				$conditions=array_merge($conditions,array('product_id IN ('.implode(",",$id).')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
				
			}
			$product=ClassRegistry::init('Product')->find('all', array('conditions' =>$conditions,'order'=>'product_id DESC','limit'=>6));
			$productnewcount=ClassRegistry::init('Product')->find('count', array('conditions' => $conditions,'order'=>'product_id DESC'));  		
						 
			 
		}
		if($key=='goldpurity'){
			$conditionschk=array();
			$productpurity=ClassRegistry::init('Productmetal')->find('all',array('conditions'=>array('value'=>$val,'type'=>'Purity'),'group'=>'product_id'));
				foreach($productpurity as $purity)
				{
				
					$conditionschk[]=$purity['Productmetal']['product_id'];
					
				}
				$ids=implode(',',$conditionschk);
				$conditions=array_merge($conditions,array('product_id IN ('.$ids.')','product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
				$product=ClassRegistry::init('Product')->find('all', array('conditions' =>$conditions,'order'=>'product_id DESC','limit'=>6)); 
				$productnewcount=ClassRegistry::init('Product')->find('count', array('conditions' => $conditions,'order'=>'product_id DESC'));  

			}
			
			
		
		if($key=='metal')
			{
				$conditions=array_merge($conditions,array('metal'=>$val,'product_name LIKE'=>'%'.$this->params['pass']['0'].'%','status'=>'Active'));
			    $product=ClassRegistry::init('Product')->find('all',array('conditions'=>$conditions,'order'=>'product_id DESC','limit'=>6)); 
				$productnewcount=ClassRegistry::init('Product')->find('count', array('conditions' => $conditions,'order'=>'product_id DESC'));  
			
			}
		   }
			else
			{
				$conditions=array_merge($conditions,array('product_name LIKE'=>'%'.$this->request->query['search'].'%','status'=>'Active'));
				$product=ClassRegistry::init('Product')->find('all', array('conditions' => $conditions,'order'=>'product_id DESC','limit'=>6)); 
				$productnewcount=ClassRegistry::init('Product')->find('count', array('conditions' => $conditions,'order'=>'product_id DESC'));  
			} 
			
			
			

		?>
        
        <?php
	
		
			if(!empty($product)) {
	  foreach($product as $products) { 
		 
	   $images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$products['Product']['product_id'],'status'=>'Active'),'limit'=>6));
	  
	  
      ?>
      <div class="gridproduct">
       <div class="productDiv">
          <div style="position:relative;">
            <div style="position:absolute; right:-18px;"><?php // echo $this->Html->image('offer_img.png',array("alt" => "Image")); ?></div>
          </div>
         
          <?php if(!empty($images['Productimage']['imagename'])) { ?><p>
		  <?php echo $this->Html->link($this->Html->image( 'product/small/'.$images['Productimage']['imagename'],array('border'=>0,'class'=>'xyz')),array('action'=>'product_details','controller'=>'webpages',$products['Product']['product_id']),array('escape'=>false)
        );?></p><?php } else { ?><div class="procuctimage"><?php echo 'No Image Found';?></div><?php } ?> </p>
         
          <p align="center"><?php echo $products['Product']['product_name'];?></p>
          <div style="border-bottom:1px solid #ccc; float:left; width:100%; padding-bottom:5px;">
            <div style="float:left; color:#dba715; font-size:18px; font-weight:bold;">&nbsp;</div>
            <div style="float:right;">
			<?php 
			$reviewcount=ClassRegistry::init('Rating')->find('count',array('conditions'=>array('product_id'=>$products['Product']['product_id'])));
			
			$rating=ClassRegistry::init('Rating')->find('all',array('fields' =>array('SUM(Rating.rate) as total'),'conditions'=>array('product_id'=>$products['Product']['product_id']), 'group' => array( 'Rating.product_id')));
			
			 foreach($rating as $rating) {
				foreach($rating as $rating) {
				  $count=$rating['total']/$reviewcount;
				  $count=round($count,2);
			  }
			  }
			?>
			
            <span class="b-star"><span style="width:<?php if(!empty($rating)) {  echo $count*20; }else{ echo '0';}?>%" class="rstar"></span></span>
            </div>
          </div>
          <div style="clear:both;"></div>
        
          <div style="border-bottom:1px solid #ccc; float:left; width:100%;">
            <p align="center">
             <a href="<?php echo BASE_URL;?>/webpages/product_details/<?php echo $products['Product']['product_id'];?>"><input name="" type="button" value="" class="addBtn" ></a>
            <a href="<?php echo BASE_URL;?>/webpages/whislist/<?php echo $products['Product']['product_id'];?>/<?php if(!empty($images)) { echo $images['Productimage']['image_id']; }?>">  <input name="" type="button" value="" class="wish_list_btn"></a>
            </p>
          </div>
        </div>
        </div>
        
        <div class="listproduct" style="display:none;">
        <div class="productDiv" style="width:100%;">
          <div style="position:relative;">
            <div style="position:absolute; right:-18px;"><!--<img src="images/offer_img.png" alt="" />--></div>
          </div>
          <div style="float:left; width:270px;">
          	<?php if(!empty($images['Productimage']['imagename'])) { echo $this->Html->link($this->Html->image( 'product/small/'.$images['Productimage']['imagename'],array('border'=>0,'height'=>'150')),array('action'=>'product_details','controller'=>'webpages',$products['Product']['product_id']),array('escape'=>false)
        ); }else {  echo 'No Image Found';} ?> 	
          </div>

          <div style="float:left; width:570px; height:40px;">
          	<h3><?php echo $products['Product']['product_name'];?></h3>
          </div>

          <div style="float:left; width:570px; height:50px;">
          	<h1>Rs. 85,769 </h1>
          </div>

          <div style="float:left; width:570px; height:50px;">
          	 <strong>Metal :</strong> 18Kt Yellow Gold | Stone: Diamond | Gender: Unisex 
          </div>

          <div style="float:left; width:270px;">
               <a href="<?php echo BASE_URL;?>/webpages/product_details/<?php echo $products['Product']['product_id'];?>"><input name="" type="button" value="" class="addBtn" ></a>
            <a href="<?php echo BASE_URL;?>/webpages/whislist/<?php if(!empty($this->params['pass']['0'])) { echo $this->params['pass']['0']; } else { } ?>/<?php echo $products['Product']['product_id'];?>/<?php if(!empty($images)) { echo $images['Productimage']['image_id']; }?>">  <input name="" type="button" value="" class="wish_list_btn"></a>
          </div>
          
          
          <div style="clear:both;"></div>
          
        </div>
        </div>
       
        <?php   }?>
        
        <?php }  else { 
		?>
        <div style="float:left; width:100%; padding:8px 0px 8px 0px; color:#ad8000; text-align:center; margin-top:30px; border-bottom:2px solid #dba715; background-color:#e7cb5d;" id="loadingimgae">No more products to show</div>
		
		<?php 

		 } ?>
        </div>
        <div class="no_more_image" style="display:none;">
        <div style="float:left; width:100%; padding:8px 0px 8px 0px; color:#ad8000; text-align:center; margin-top:30px; border-bottom:2px solid #dba715; background-color:#e7cb5d;" id="loadingimgae">No more products to show</div>
        </div>
        
    </div>
    

  </div>
  <?php
   $outer_arr=$this->params['named'];

		   foreach($outer_arr as $key => $val) { 
        }
    ?>
  <input type="hidden" name="jewellery" value="<?php if(!empty($key)) { if($key!='diamond') { echo $key; } } ?>" class="key" />
    <input type="hidden" name="jewelleryval" value="<?php  if(!empty($key)) { if($key!='diamond') { echo $val; } } ?>" class="value" />
 <input type="hidden" name="page" value="1" class="page" />   
<input type="hidden" id="flag" value="0"/>    
<input type="hidden" id="total" value="<?php  echo $productnewcount;?>"/>
<input type="hidden" name="checker" value="grid" class="checker" /> 
<input type="hidden" name="search_name" value="<?php if(!empty($_REQUEST['search'])){ echo $_REQUEST['search']; } else { echo $this->params['pass']['0']; }?>" class="search_name" /> 
<input type="hidden" name="counter" value="<?php echo $counts;?>" class="counter" />
<script>
$(document).ready(function() {
	$('.more').click(function() {
		thisvar=$(this);
		thisvar.parents('ul').find('.shape').css( { height:'100%' });
		thisvar.parents('ul').find('.shape').show(100);
		thisvar.parents('ul').find('.more').hide();
		thisvar.parents('ul').find('.less').show();
		
	});
	$('.less').click(function() {
		thisvar=$(this);
		thisvar.parents('ul').find('.shape').css( { height:'127px' });
		thisvar.parents('ul').find('.shape').show(100);
		thisvar.parents('ul').find('.less').hide();
		thisvar.parents('ul').find('.more').show();
		
	});
	
});

</script>
<script>
$(document).ready(function() {
$('input[type=radio]').click(function() {
	var subc=$('.sublink').length>0?$('.sublink').val()+'/':'';
	var cat=$('.catlink').length>0?$('.catlink').val():'';
	thisvar=$(this);
	name=$('.search_name').val();
	var id=$(this).val();
	
	if(id=='Diamond')
	{
	var type=$(this).parents('ul').find('p').attr('id');	
	}
	else
	{
	var type=$(this).parents('ul').find('p').attr('rel');
	}
	
	
	window.location ='<?php echo BASE_URL;?>webpages/search/'+name+'/'+type+':'+ id;
	//thisvar.parents('ul').find('li').find('input[type="radio"]').is(':checked');
	//alert(thisvar.parents('ul').find('li').find('input[type="radio"]'));
});
<?php
if(!empty($this->params['named'])){
	$outer_arr=$this->params['named'];
	?>
	$('input[type=radio][name=<?php echo key($outer_arr);?>][value=<?php echo $outer_arr[key($outer_arr)];?>]').prop( "checked",true ).parents('ul').find('.shape').css( { height:'100%' });
	$('input[type=radio][name=<?php echo key($outer_arr);?>][value=<?php echo $outer_arr[key($outer_arr)];?>]').prop( "checked",true ).parents('ul').find('.less').show();
	$('input[type=radio][name=<?php echo key($outer_arr);?>][value=<?php echo $outer_arr[key($outer_arr)];?>]').prop( "checked",true ).parents('ul').find('.more').hide();
	$('input[type=radio][name=<?php echo key($outer_arr);?>][value=<?php echo $outer_arr[key($outer_arr)];?>]').prop( "checked",true );
	
	
	<?php
}
?>
});
</script>

<script>
$(document).ready(function() {
	$(window).scroll(function() {		
            if ($(window).scrollTop()+400 > ($(document).height() - $(window).height())) {
				    load_images();

            }
        });
});
function load_images() {
	  value = $('#flag').val();
	 if(value == 0) {
	   $('#flag').val('1');
			 page = parseInt($('.page').val())+1;
			 jeweltype=$('.key').val();
			 keyval=$('.value').val();
			 count=$('.count').val();
			 checker=$('.checker').val();
			  name=$('.search_name').val();
			 if($('#total').val()!=$('.countnew').val()) {
				 $('.helpfade').show();
      			 $('.helptips').show();
                  $.ajax({
                      url: "<?php echo BASE_URL;?>webpages/load_more_search",
                      type:'POST',
                       data: 'page=' + page  +'&type=' +jeweltype+ '&value=' +keyval+'&count=' +count+'&checker=' +checker+'&name=' +name,
					   dataType: 'json',
                      success: function(data){
						  if(data!='') {
						if(data.flag=='Yes'){
						 $('.productMiddleRight').append(data.productdiv); 
						 $('.countpage').html(data.count);
						 $('.count').val(data.count);
						 $('.countnew').val(data.count);
						 var values=parseInt($('.page').val())+1;
						 $('.page').val(values);
						 $('.helpfade').hide();
   						 $('.helptips').hide();
						  $('#flag').val('0');
						  }
						 else{
							 $('#flag').val('1');	
							
						 }
						  }
						  else
						  {	
						  $('#flag').val('1');					
						  }
						   
					  }
					  
				});
	 }else
	 {
	  $('.no_more_image').show();	
	 }
	 }
	 else
	 {
		
		$('.helpfade').hide();
   	    $('.helptips').hide();
	 }
}        

  </script>
<script>
$(document).ready(function(){
	var subc=$('.sublink').val();
	var cat=$('.catlink').val();
	$('.grid').click(function(){
		location.reload();
		$('.gridproduct').show();
		$('.listproduct').hide();
		$('.checker').val('grid');
		$('#flag').val('0');
		  $('.no_more_image').hide();	
		  $('.count').val('');
		   $('.countnew').val('');
		    $('.page').val('1');
			counter=$('.counter').val();
			$('.countpage').html(counter);
				$('.countnew').val(counter);
					$('.count').val(counter);
		
	});
	$('.list').click(function(){
		$('.listproduct').show();
		$('.gridproduct').hide();
		$('.checker').val('list');
		$('#flag').val('0');
		  $('.no_more_image').hide();	
		  $('.count').val('');
		   $('.countnew').val('');
		    $('.page').val('1');
			counter=$('.counter').val();
			$('.countpage').html(counter);
				$('.countnew').val(counter);
					$('.count').val(counter);
		
		
	});
});
</script>
