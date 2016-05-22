<div class="container">
<!--- New HTML Start -->

<div class="productInfoDiv">
<div class="productMiddleDeatil">
  <div class="topsubmenudiv">
    <div class="topsubmenu">
      <ul>
       <li><?php echo $this->Html->link('Home',array('controller'=>'webpages','action'=>'index'), array('escape' => false));?></li>
            <li class="line_img"><?php  echo $this->Html->image('line-img.png',array("alt" => "Image")); ?></li>
            <li><?php echo $this->Html->link('Jewllery' ,array('controller'=>'webpages','action'=>'jewellery'), array('escape' => false)); ?></li> 
             <li class="line_img"><?php  echo $this->Html->image('line-img.png',array("alt" => "Image")); ?></li>  
        <li class="category"><a  class="product">Cart </a></li>
      </ul>
    </div>
  </div>
</div>

<div style="float:left; color:#8d3446; font-size:18px; padding-top:7px;">SHOPPING CART </div>
<div style="float:right; width:130px; text-align:center;" class="place_order"><?php if($this->Session->read('User')=='') {
			  $link=BASE_URL.'signin/index?ref=cart';
		  }else
		  {
			    $link=BASE_URL.'orders/shipping_details';	
		  }
		  ?>
          <div class="place_order"><a href="<?php echo $link;?>"> Place Order</a></div></td></div>
<div style="clear:both;"></div>
<div class="productMiddleDeatil">
  <form name="cartform" id="cartform" action="" method="post">
    <table cellpadding="0" border="0" cellspacing="0" width="100%" class="table">
      <tr>
        <th>PRODUCTS DETAILS</th>
        <th>&nbsp;</th>
        <th>QUANTITY</th>
        <th>PRICE</th>
        <th>&nbsp;</th>
      </tr>
      <?php
				
		$j=0;
		$total=0;
		foreach($cart_products as $carts) {
			
		$product=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
		$image=ClassRegistry::init('Productimage')->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'],'status'=>'Active')));
		$category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'],'status'=>'Active')));
		$subcategory=ClassRegistry::init('Subcategory')->find('first',array('conditions'=>array('subcategory_id' =>$product['Product']['subcategory_id'],'status'=>'Active')));
		
		if($carts['Shoppingcart']['size']=='')
		{
			$size='N/A';
		}else
		{
		
		if($category['Category']['category']!='Bangles'){ 
		$size=$carts['Shoppingcart']['size'];
		}else
		{
		$size=ClassRegistry::init('Size')->find('first',array('conditions'=>array('size_value'=>$carts['Shoppingcart']['size'],'status'=>'Active')));
		$size=$size['Size']['size'];
		//$size=$carts['Shoppingcart']['size'];
		}
		}
		
		?>
      <tr>
        <td valign="top"><a href="<?php echo BASE_URL?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']))."/".$product['Product']['product_id']."/".str_replace(' ','_',trim($product['Product']['product_name']));?>"><?php  echo $this->Html->image('product/small/'.$image['Productimage']['imagename'] ,array("alt" => "index")); ?></a></td>
        <td valign="top" ><table cellpadding="0" border="0" cellspacing="0" width="100%" class="table2">
            <tr>
              <td colspan="3"><h3 style="color:#9e3a46;"></h3></td>
            </tr>
            <tr>
              <td width=""><strong>Product Name</strong></td>
              <td width="15">:</td>
              <td><a style="color:#979797;font-weight:bold;" href="<?php echo BASE_URL?><?php echo str_replace(' ','_',trim($category['Category']['category']))."/".str_replace(' ','_',trim($subcategory['Subcategory']['subcategory']))."/".$product['Product']['product_id']."/".str_replace(' ','_',trim($product['Product']['product_name']))?>"><?php echo $product['Product']['product_name'];?></a></td>
            </tr>
            <tr>
              <td colspan="3" height="10"></td>
            </tr>
            <?php  if(!empty($carts['Shoppingcart']['size'])){?>
            <tr>
              <td width=""><strong>Size</strong></td>
              <td width="15">:</td>
              <td><strong><?php echo $size; ?></strong></td>
            </tr><?php }?>
            <tr>
              <td colspan="3" height="10"></td>
            </tr>
            
            <tr>
              <td><strong>Metal</strong></td>
              <td>:</td>
              <td><strong><?php echo $carts['Shoppingcart']['metal'];?>&nbsp;<?php echo $carts['Shoppingcart']['purity'];?>K</strong></td>
            </tr>
            <tr>
              <td>Metal Weight</td>
              <td>:</td>
              <td><?php echo $carts['Shoppingcart']['weight'];?>grams</td>
            </tr>
            <tr>
              <td colspan="3" height="10"></td>
            </tr>
            <?php 
			  $productdetails=ClassRegistry::init('Product')->find('first',array('conditions'=>array('product_id'=>$carts['Shoppingcart']['product_id'])));
			  if($productdetails['Product']['stone']=='Yes'){
				 $productdiamonddetail=ClassRegistry::init('Productdiamond')->find('first',array('conditions'=>array(
				 'product_id'=>$productdetails['Product']['product_id'],'clarity'=>$carts['Shoppingcart']['clarity'],'color'=>$carts['Shoppingcart']['color'])));
				 //pr($productdiamonddetail);exit;
		  $productdiamondtotal = ClassRegistry::init('Productdiamond')->find('first',array('fields'=>array('SUM(noofdiamonds) as nodiamond','SUM(stone_weight) AS sweight') ,'conditions'=>array('product_id'=>$productdetails['Product']['product_id'],'clarity'=>$carts['Shoppingcart']['clarity'],'color'=>$carts['Shoppingcart']['color'])));
				 // pr($productdiamondtotal);exit;
				 $nofdiamond=$productdiamondtotal[0]['nodiamond'];
				  $stoneweight=$productdiamondtotal[0]['sweight']
			
				  //foreach($productdiamonddetail as $productdiamonddetail){
					  
				 ?>
            <tr>
              <td><strong>Stone</strong></td>
              <td>:</td>
              <td><strong>Diamond</strong></td>
            </tr>
            <tr>
              <td>Total Weight</td>
              <td>:</td>
              <td><?php //echo //$productdiamonddetail['Productdiamond']['stone_weight'];
			   echo $stoneweight?> Carat</td>
            </tr>
            <tr>
              <td>Quality</td>
              <td>:</td>
              <td><?php echo $productdiamonddetail['Productdiamond']['clarity'];?> <?php echo $productdiamonddetail['Productdiamond']['color'];?></td>
            </tr>
            <tr>
              <td>Number of Stones</td>
              <td>:</td>
              <td><?php echo  $nofdiamond;
			             
			  ?></td>
            </tr>
            <tr>
              <td colspan="3" height="10"></td>
            </tr>
            <?php
			  //}
			  }
			   ?>
            <?php 
					  if($productdetails['Product']['gemstone']=='Yes'){
				  $productgemstonedetail=ClassRegistry::init('Productgemstone')->find('all',array('conditions'=>array('product_id'=>$productdetails['Product']['product_id'])));
				  foreach($productgemstonedetail as $productgemstonedetail){
				 ?>
            <tr>
              <td><strong>Stone</strong></td>
              <td>:</td>
              <td><strong><?php echo $productgemstonedetail['Productgemstone']['gemstone']?></strong></td>
            </tr>
            <tr>
              <td>Number of Stones</td>
              <td>:</td>
              <td><?php echo $productgemstonedetail['Productgemstone']['no_of_stone'];?></td>
            </tr>
           
              <td colspan="3" height="10"></td>
            </tr>
            <?php
			  }
			  }
			   ?>
          </table></td>
        <td valign="top"><select name="quantity[<?php echo  $j?>]" class="quantity"  style="margin-top:10px;">
            <?php
		  for($i=1;$i<=10;$i++){
		   ?>
            <?php echo '<option value="'.$i.'" ' . ($carts['Shoppingcart']['quantity'] == $i ? 'selected="selected"' : '') . ' >'.$i.'</option>';?>
            <?php } ?>
          </select>
          <input type="hidden" name="cartid[<?php echo  $j?>]" class="cartid" value="<?php echo $carts['Shoppingcart']['cart_id'];?>" />
          <input type="hidden" name="productid[<?php echo  $j?>]" class="productid" value="<?php echo $carts['Shoppingcart']['product_id'];?>" /></td>
        <td valign="top"><div style="margin-top:10px;"><span >Rs. <?php $total_amt=str_replace(',','',$carts['Shoppingcart']['total'])*$carts['Shoppingcart']['quantity'];
		
		$total+=$total_amt;
		echo indian_number_format($total_amt); ?></span>/-</td></div>
        <td valign="top"  ><div style="margin-top:10px;"><a style="color:#8d3446;" href="<?php echo BASE_URL?>shoppingcarts/remove/<?php echo $carts['Shoppingcart']['cart_id']?>">Remove</a></div></td>
      </tr>
      <tr>
        <th colspan="5" style="border-bottom:0px none; padding:0px;">&nbsp;</th>
      </tr>
      <?php $j++;?>
      <?php } ?>
      <tr>
        <td align="center"><div class="place_order" style="width:170px;"> <a href="<?php echo BASE_URL;?>webpages/jewellery">Continue Shopping</a> </div></td>
        <td>&nbsp;</td>
        <td style="font-size:16px;"><strong>Total</strong></td>
        <td style="font-size:16px;"><strong>Rs.<?php echo indian_number_format($total);?>/-</strong></td>
        <td align="center"><?php
		  if($this->Session->read('User')=='') {
			  $link=BASE_URL.'signin/index?ref=cart';
		  }else
		  {
			    $link=BASE_URL.'orders/shipping_details';	
		  }
		  ?>
          <div class="place_order"><a href="<?php echo $link;?>"> Place Order</a></div></td>
       
      </tr>
    </table>
  </form>
</div>
<div style="clear:both;">&nbsp;</div>
<?php echo $this->Element('newsletter');?> 
<script>
    $(document).ready(function(){
    $("#myForm").validationEngine();
    });
</script> 

<script>
$(document).ready(function() {
	$('.quantity').on('change', function() {
		$('#cartform').submit();
  //alert( this.value );
 /* var qty=$(this).val();
  
  var cartid=$('.cartid').val();
 
  var productamt=$('.productamt').val();
  var productid=$('.productid').val();
  alert(productamt);
 // window.location ='<?php echo BASE_URL;?>shoppingcarts/qtyprice/'+qty+'/'+cartid+'/'+productamt; // or $(this).val()
 $.ajax({
		type: "POST",
		url: "<?php echo BASE_URL;?>shoppingcarts/qtyprice",
		 data: 'qt=' + qty + '&cartid_t=' + cartid + '&productamt_t=' +productamt + '&pid=' +productid,
		 dataType: 'json',
		success: function (msg) {
			find('span').html(msg);
					
          }
		});
		*/
 
});
	
	});

</script></div></div>