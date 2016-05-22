<div class="container">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>
    <div class="productInfoDiv"> 
        <?php
        $counts = '';
        $categorycount = ClassRegistry::init('Category')->find('first', array('conditions' => array('link' => $this->params['pass']['0'], 'status' => 'Active')));
        $subcategorycount = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $categorycount['Category']['category_id'], 'status' => 'Active')));
        $length = count($subcategorycount);
        ?>
          <p align="center"><?php echo '<center><h1 style="color:#666666;">'.'All '.ucwords($categorycount['Category']['category']).'</h1></center>';?></p>
	<?php /*$category = ClassRegistry::init('Category')->find('first', array('conditions' => array('link'=>$this->params['pass']['0'],'status' =>'Active'),'order'=>'category_id ASC')); 
	if($category['Category']['category_id']==1){
		echo $this->Html->image('rings_heading.jpg');
	}else{*/
		//echo $this->Html->image('all-jewellery.jpg');
		
		
	//}?>
        <p align="center"><a style="color:#666666;">View all (<?php echo $length; ?>) </a></p>
        <div style="clear:both;">&nbsp;</div>
        <div class="shadow"><?php // echo $this->Html->image('shadow.png',array("alt" => "Image"));     ?></div>
        <div style="float:left; width:100%;">
            <div class="shadow">
                <?php // echo $this->Html->image('shadow.png'); ?><hr/>
            </div>
            <?php
            $category = ClassRegistry::init('Category')->find('all', array('conditions' => array('link' => $this->params['pass']['0'], 'status' => 'Active'), 'order' => 'category_id ASC'));
            foreach ($category as $categories) {
                $subcategory = ClassRegistry::init('Subcategory')->find('all', array('conditions' => array('category_id' => $categories['Category']['category_id'], 'status' => 'Active')));
            }
            ?>
            <div class="rings_main">
                <?php
                $i = 1;
                $length = count($subcategory);
                foreach ($subcategory as $subcategories) {

                    $product = ClassRegistry::init('Product')->find('all', array('conditions' => array('subcategory_id' => $subcategories['Subcategory']['subcategory_id'], 'category_id' => $categories['Category']['category_id'], 'status' => 'Active'), 'limit' => 4));

                    $productcount = ClassRegistry::init('Product')->find('all', array('conditions' => array('subcategory_id' => $subcategories['Subcategory']['subcategory_id'], 'category_id' => $categories['Category']['category_id'], 'status' => 'Active')));
                    ?> 
                    <?php //if($i<=2) { ?>

                    <div  class="<?php
                    if ($i <= 2) {
                        echo 'rings_cat';
                    } else {
                        echo 'rings_cat_three ';
                    }
                    ?>" <?php
                    if ($i != 2) {
                        echo 'style="border-right:1px dashed #ccc;"';
                    }
                    ?>>

                        <center><p><?php echo strtoupper($subcategories['Subcategory']['subcategory']); ?></p></center>	
                        <ul>


                            <?php
                            if (!empty($product)) {
                                foreach ($product as $products) {
                                    $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $products['Product']['product_id'], 'status' => 'Active'), 'limit' => 4));
                                    $count = count($productcount);
                                    if (!empty($image)) {
                                        ?>
                                        <li><a href="<?php echo $categories['Category']['link'] . "/" . $subcategories['Subcategory']['link'] ?>"><img  src="<?php echo BASE_URL . 'img/product/small/' . $image['Productimage']['imagename'] ?>"border='0' width='110px' height='85px'/></a></li>
                                    <?php } ?><?php } ?></ul><?php
                        } else {
                            echo '<div class="no_category">No Product Found</div>';
                        }
                        ?>


                        <?php if (!empty($product)) { ?><p align="center">

                                <a href="<?php echo $categories['Category']['link'] . "/" . $subcategories['Subcategory']['link'] ?>" style="color:#666666;float:right;"><?php echo $count . '  More' . ' >' ?></a>

                                <?php //echo $this->Html->link($count.'  More'.' >',array('action'=>'product',$categories['Category']['link'],$subcategories['Subcategory']['link']),array('style' => 'color:#666666;float:right;'));  ?></p> <?php } ?>

                    </div><?php if ($i == 2 || $i == 5 || $i == 8) { ?> 

                        <div style="clear:both;">&nbsp;</div>
                        <div class="shadow"><?php // echo $this->Html->image('shadow.png', array("alt" => "Image")); ?><hr/></div>

                    <?php } ?> 
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>  
    </div>
</div>


