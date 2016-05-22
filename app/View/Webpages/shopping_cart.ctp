<body>

<div class="main">
  <header> &nbsp; </header>
  <div style="clear:both;">&nbsp;</div>
  
  <!--- New HTML Start -->
  
  <div class="productInfoDiv">
    <div class="productMiddleDeatil">
      <div class="topsubmenudiv">
        <div class="topsubmenu">
          <ul>
            <li><a href="#"><?php  echo $this->Html->image('icons/home_btn.png',array("alt" => "Image")); ?></a></li>
            <li><a href="#"><?php  echo $this->Html->image('icons/jewellery_btn.png',array("alt" => "Image")); ?></a></li>
            <li><a href="#"><?php  echo $this->Html->image('icons/rings_btn.png',array("alt" => "Image")); ?></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="shadow"><?php  echo $this->Html->image('shadow.png',array("alt" => "Image")); ?></div>
    <div style="float:left; color:#8d3446; font-size:18px; padding-top:7px;">SHOPPING CART </div>
    <div style="float:right; width:130px; text-align:center;" class="place_order"><a href="#">Place Order</a></div>
    <div style="clear:both;"></div>
    <div class="productMiddleDeatil">
     <?php
		$image=ClassRegistry::init('Productimage')->find('first', array('conditions' => array('image_id' =>$this->params['pass']['0'])));
		$product=ClassRegistry::init('Product')->find('first', array('conditions' => array('product_id' =>$image['Productimage']['product_id'])));
		
		$jewel=ClassRegistry::init('Jeweltype')->find('first', array('conditions' => array('type_id' =>$product['Product']['goldpurity'])));
		$metal=ClassRegistry::init('Jeweltype')->find('first', array('conditions' => array('type_id' =>$product['Product']['metal'])));
	
	   $productstone=ClassRegistry::init('Productstone')->find('all', array('conditions' => array('product_id' =>$product['Product']['product_id'])));
		?>
      <table cellpadding="0" border="0" cellspacing="0" width="100%" class="table">
        <tr>
          <th>PRODUCTS DETAILS</th>
          <th>&nbsp;</th>
          <th>QUANTITY</th>
          <th>PRICE</th>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <td valign="top"><?php  echo $this->Html->image('product/small/'.$image['Productimage']['imagename'],array("alt" => "Image")); ?></td>
          <td valign="top" ><table cellpadding="0" border="0" cellspacing="0" width="100%" class="table2">
              <tr>
                <td colspan="3"><h3 style="color:#9e3a46;"><?php echo $product['Product']['product_name'];?></h3></td>
              </tr>
              <tr>
                <td width=""><strong>Size</strong></td>
                <td width="15">:</td>
                <td><strong><?php if(!empty($product['Product']['size'])) { echo $product['Product']['size']; } else { echo '-'; } ?></strong></td>
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td><strong>Metal</strong></td>
                <td>:</td>
                <td><strong><?php if(!empty($product['Product']['goldpuruty'])) { echo $jewel['Jeweltype']['name']; } else {  } ?><?php if(!empty($product['Product']['metal'])) { echo $metal['Jeweltype']['name']; } else { echo '-'; } ?></strong></td>
              </tr>
              <tr>
                <td>Metal Weight</td>
                <td>:</td>
                <td><?php if(!empty($product['Product']['weight'])) { echo $product['Product']['weight']; } else { echo '-'; } ?> grams</td>
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <?php
			  foreach($productstone as $stone) {
				  
			  ?>
              <tr>
                <td><strong>Stone</strong></td>
                <td>:</td>
                <td><strong>Diamond</strong></td>
              </tr>
              <tr>
                <td>Total Weight</td>
                <td>:</td>
                <td><?php echo $stone['Productstone']['stone_weight'];?> Carat</td>
              </tr>
              <tr>
                <td>Qulity</td>
                <td>:</td>
                <td>SI IJ</td>
              </tr>
              <tr>
                <td>Number of Stones</td>
                <td>:</td>
                <td><?php echo $stone['Productstone']['no_of_diamonds'];?></td>
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <?php } ?>
             
            </table></td>
          <td valign="top"><select name="">
              <option></option>
              <option>1</option>
              <option>1</option>
              <option>1</option>
              <option>1</option>
            </select></td>
          <td valign="top">₹<?php echo $product['Product']['total_amount'];?>/-</td>
          <td valign="top"><a style="color:#8d3446;" href="#">Remove</a></td>
        </tr>
        <tr>
          <th colspan="5" style="border-bottom:0px none; padding:0px;">&nbsp;</th>
        </tr>
        <tr>
          <td align="center"><div class="place_order" style="width:170px;">
            <a href="#">Continue Shopping</a></td>
          <td>&nbsp;</td>
          <td style="font-size:16px;"><strong>Total</strong></td>
          <td style="font-size:16px;"><strong>₹<?php echo $product['Product']['total_amount'];?>/-</strong></td>
          <td align="center"><div class="place_order">
            <a href="#">Place Order</a></td>
        </tr>
      </table>
    </div>
  </div>
 <div style="clear:both;">&nbsp;</div>
   <?php echo $this->Element('newsletter');?>
  

   <script>
    $(document).ready(function(){
    $("#myForm").validationEngine();
    });
</script>