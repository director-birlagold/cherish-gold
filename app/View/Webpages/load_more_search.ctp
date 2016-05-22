<?php

if(!empty($product)) {
  if($json['checker']=='grid')
  {
$productdiv='';
foreach ($product as $products) { 
  $images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$products['Product']['product_id'],'status'=>'Active')));


$productdiv.='   <div class="gridproduct"><div class="productDiv ">
            <div style="position:relative;">
            <div style="position:absolute; right:-18px;"></div>
            </div>';
         if(!empty($images['Productimage']['imagename'])) { 
		   $image=$this->Html->link($this->Html->image( 'product/small/'.$images['Productimage']['imagename'],array('border'=>0,'class'=>'xyz')),array('action'=>'product_details','controller'=>'webpages',$products['Product']['product_id']),array('escape'=>false)
        );
		   }
		   else
		   {
			   $image='No Image Found';
		   }
			  
		 $productdiv.='<p>'.$image.'</p> <p align="center">'.$products['Product']['product_name'].'</p>
          <div style="border-bottom:1px solid #ccc; float:left; width:100%; padding-bottom:5px;">
            <div style="float:left; color:#dba715; font-size:18px; font-weight:bold;">&nbsp;</div>
            <div style="float:right;">';
		
			$reviewcount=ClassRegistry::init('Rating')->find('count',array('conditions'=>array('product_id'=>$products['Product']['product_id'])));
			
			$rating=ClassRegistry::init('Rating')->find('all',array('fields' =>array('SUM(Rating.rate) as total'),'conditions'=>array('product_id'=>$products['Product']['product_id']), 'group' => array( 'Rating.product_id')));
			
			 foreach($rating as $rating) {
				foreach($rating as $rating) {
				  $count=$rating['total']/$reviewcount;
				  $count=round($count,2);
			  }
			  }
		
            $productdiv.='<span class="b-star"><span style="width:'.(!empty($rating)?$count*20:'0').'%" class="rstar"></span></span>
            </div>
          </div>
          <div style="clear:both;"></div>
          <div style="border-bottom:1px solid #ccc; float:left; width:100%;">
            <p align="center">
             <a href="'.BASE_URL.'/webpages/product_details/'.$products['Product']['product_id'].'"><input name="" type="button" value="" class="addBtn" ></a>
            <a href="'.BASE_URL.'/webpages/whislist/'.$products['Product']['product_id'].'/'.(!empty($images)?$images['Productimage']['image_id']:'').'"> 
			 <input name="" type="button" value="" class="wish_list_btn"></a>
            </p>
          </div> </div></div>';
  }
 	    $flag='Yes';
		$count=$json['pagecount']; 
		$array=array_merge(array('count'=>$count,'productdiv'=>$productdiv,'flag'=>$flag));
}
if($json['checker']=='list') {
$productlist='';

foreach ($product as $products) { 
	  $images=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$products['Product']['product_id'],'status'=>'Active'))); 
	  	  
$productlist.='<div class="listproduct">
         <div class="productDiv" style="width:100%;">
          <div style="position:relative;">
            <div style="position:absolute; right:-18px;"></div>
          </div>
          <div style="float:left; width:270px;">';
		   if(!empty($images['Productimage']['imagename'])) { 
		   $image=$this->Html->link($this->Html->image( 'product/small/'.$images['Productimage']['imagename'],array('border'=>0,'class'=>'xyz')),array('action'=>'product_details','controller'=>'webpages',$products['Product']['product_id']),array('escape'=>false)
        );
		   }
		   else
		   {
			   $image='No Image Found';
		   }
			  
		 $productlist.='<p>'.$image.'</p>
			</div><div style="float:left; width:570px; height:40px;">
          	<h3>'.$products['Product']['product_name'].'</h3>
          </div>

          <div style="float:left; width:570px; height:50px;">
          	<h1>Rs. 85,769 </h1>
          </div>

          <div style="float:left; width:570px; height:50px;">
          	 <strong>Metal :</strong> 18Kt Yellow Gold | Stone: Diamond | Gender: Unisex 
          </div><div style="float:left; width:270px;">
               <a href="'.BASE_URL.'/webpages/product_details/'.$products['Product']['product_id'].'"><input name="" type="button" value="" class="addBtn" ></a>
            <a href="'.BASE_URL.'/webpages/whislist/'.$products['Product']['product_id'].'/'.(!empty($images)?$images['Productimage']['image_id']:'').'">  <input name="" type="button" value="" class="wish_list_btn"></a>
          </div> 
          <div style="clear:both;"></div>
         </div>
        </div>';
        }
		$flag='Yes';
		$count=$json['pagecount']; 
		$array=array_merge(array('count'=>$count,'productdiv'=>$productlist,'flag'=>$flag));
		
}
}
else
{
	$flag='No';
	$array=array_merge(array('flag'=>$flag));
} 
echo json_encode($array);

?>