<div class="main">
<header> &nbsp; </header>
<div style="clear:both;">&nbsp;</div>

<!--- New HTML Start -->

<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
<div id="" class="tabsDiv">
	<div class="middleContent">
    	<h2>Account Dashboard</h2>
        <p> Manage your personal information and track your orders by clicking the sections below. Your Order items are not the same as your cart items(link at the top of this page).
The cart is the set of items that have been readied for purchase but have not been paid for. </p>
    </div>
  </div>
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/details"   class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/address_book"  class="ui-tabs-anchor">Address Book</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>orders/my_order"  class="ui-tabs-anchor">My Order</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">Wishlist</a></li>
</ul>
<div id="tabs-1" class="">
<p></p>
<div class="account_details">
      <table cellpadding="0" border="0" cellspacing="0" width="100%" class="table">
	  <?php
	  if(!empty($user)) {
	  foreach($user as $user) {
	  
	   $product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' =>$user['Whislist']['product_id'])));
	  
	  $category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'],'status'=>'Active')));
		$subcategory=ClassRegistry::init('Subcategory')->find('first',array('conditions'=>array('subcategory_id' =>$product['Product']['subcategory_id'],
		'status'=>'Active')));
                 $subcategory_name='';
                if(!empty($subcategory))
                {
                $subcategory_name=str_replace(' ','_',$subcategory['Subcategory']['subcategory']);
                }
	
	  // $image=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('image_id' =>$user['Whislist']['image_id'])));
	   $image=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id'],'status'=>'Active')));
	   
	   $cat_code=ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
	
	  // $purity=ClassRegistry::init('Purity')->find('first', array('conditions' => array('purity_id' => $product['Product']['metal_purity'])));
	 
	   $color=ClassRegistry::init('Color')->find('first', array('conditions' => array('color_id' => $product['Product']['stone_color_id'])));
	   
	  // $field=array('ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*metal_weight) AS metalprice','IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\')),0) AS stoneprice','IF(gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,Product.making_charge AS mc,Product.vat_cst As vat ');
        //modified by prakash for metal fineness calculations
        $field = array('ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight) AS metalprice',
            '(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness) AS price',
            'IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0) AS stoneprice', 'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,Product.making_charge AS mc,Product.vat_cst As vat',
            '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) AS totprice',
            'Product.*');
        
//	  $field=array('ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))* Product.metal_weight) AS metalprice',
//		'(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id) AS price',
//		'IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0) AS stoneprice',
//		'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,
//		Product.making_charge AS mc,
//		Product.vat_cst As vat',
//		'((ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100) AS vatprice',
//		 'ROUND(ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)*making_charge/100) AS makingprice',
//		'(ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND(('.(isset($_REQUEST['goldpurity'])?$_REQUEST['goldpurity']:'(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)').'/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) AS totprice',
//		'Product.*');
	   
	   $product_new=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id'=>$user['Whislist']['product_id']),'fields'=>$field));
	   $metalpurity=ClassRegistry::init('Productmetal')->find('first',array('conditions'=>array('product_id'=>$user['Whislist']['product_id'],'type'=>'Purity'),'order'=>'value ASC'));	

	 /*  $total_price=round($product_new[0][0]['metalprice']+$product_new[0][0]['stoneprice']+$product_new[0][0]['gemstoneprice']+($product_new[0][0]['metalprice']*$product_new[0]['Product']['mc']/100)+(($product_new[0][0]['metalprice']+$product_new[0][0]['stoneprice']+$product_new[0][0]['gemstoneprice']+($product_new[0][0]['metalprice']*$product_new[0]['Product']['mc']/100))*$product_new[0]['Product']['vat']/100));*/
	   
	   //+ ROUND((metalprice+stoneprice+gemstoneprice+ROUND(metalprice* mc/100))* vat/100) 
	 	 
	  ?>
	   <tr>
          <td valign="top"><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',$category['Category']['category'])."/".$subcategory_name."/".$product['Product']['product_id']."/".str_replace(' ','_',$product['Product']['product_name']);?>"><?php echo $this->Html->image('product/small/'.$image['Productimage']['imagename'],array('alt'=>"")); ?></a></td>
          <td><h2 style="margin-bottom:10px;" ><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',$category['Category']['category'])."/".$subcategory_name."/".$product['Product']['product_id']."/".str_replace(' ','_',$product['Product']['product_name']);?>" style="color:#9e3a46;"><?php echo $product['Product']['product_name'];?></a></h2>
            <br />  <br />
            
            Product code: <?php echo $cat_code['Category']['category_code'].$product['Product']['product_code']."-".$metalpurity['Productmetal']['value']."K".(!empty($color)? $color['Color']['clarity'].$color['Color']['color']:'');?></td>
            <td>
            <strong>Rs. <?php echo indian_number_format($product_new['0']['totprice']);//echo  $total_price ; ?></strong> 
        </td>
          <td><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',$category['Category']['category'])."/".$subcategory_name."/".$product['Product']['product_id']."/".str_replace(' ','_',$product['Product']['product_name']);?>">
          <button name="" value="">BUY NOW</button></a></td>
        </tr>
        <tr>
          <th colspan="4" style="border-bottom:0px none; padding:0px;">&nbsp;</th>
        </tr>

       <?php } } else  {?>
	   
	   <?php echo 'No results found'; ?>
	   <?php } ?>

      </table>
    </div>
 
  </div>
 </div>
 </div>
 
  
  <!--- New HTML End -->
