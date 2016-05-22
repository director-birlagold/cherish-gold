<style type="text/css">
    .banner_slide {
        position: unset !important;
    }
</style>
<div class="main">
    <div class="shadow"><?php echo $this->Html->image("shadow.png", array("alt" => "index")); ?></div>
</div>
<div class="main">
    <h2><p align="center"><?php echo $category['Category']['category'] . ' Catelog' ?></p></h2>
    <div style="clear:both;">&nbsp;</div>
    <div style="clear:both; text-align: right"><?php echo $this->Html->link('Back to Catalogue', array('controller' => 'franchiseeproducts', 'action' => 'index')); ?></div>
    <div class="banner_slide">
        <ul id="demo1">
            <?php foreach ($products as $product) { ?>
                <li>
                    <?php
                    $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'status' => 'Active')));
                    if (!empty($image)) {
                        if ($image['Productimage']['imagename'] != NULL) {
                            echo $this->Html->image('product/big/' . $image['Productimage']['imagename'], array("alt" => $product['Product']['product_name']));
                        }
                    } else {
                        echo $this->Html->image('icons/slide1_new.png', array('border' => 0, 'alt' => 'logo'));
                    }
                    ?>
                    <div class="slide-desc">
                        <h2><?php echo $product['Product']['product_name']; ?></h2>
                        <p><?php echo $product['Product']['product_code']; ?><br>
                        <p><?php echo $category['Category']['category']; ?><br>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="main">
    <div class="shadow"><?php echo $this->Html->image("shadow.png", array("alt" => "index")); ?></div>
</div>
