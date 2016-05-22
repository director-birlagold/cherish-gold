<style type="text/css">
    .emptyrect{
        background-color: #ebebeb;
        border: medium none;
        height: 100px;
        width: 100px;
        text-align: center;
    }

    .category_images ul li {
        margin: 15px 5px !important;
        width: 100px;
    }
    
    .productInfoDiv{
        margin-bottom: 50px;
    }
    
    .submit{
        text-align: center;
    }
</style>
<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>

    <div class="productInfoDiv"> 
        <h2><p align="center">Edit Products</p></h2>
        <div style="clear:both;">&nbsp;</div>
        <div style="clear:both; text-align: right"><?php echo $this->Html->link('Back to Catalogue', array('controller' => 'franchiseeproducts', 'action' => 'index'));?></div>
        <div class="shadow"><?php echo $this->Html->image('shadow.png', array("alt" => "Image")); ?></div>
        <div style="float:left; width:100%;">

            <?php
            $i = 0;
            ?>

            <div class="category_images catelog_category_images">
                <?php 
                echo $this->Form->create('Franchiseeproduct');
                $all_products = ClassRegistry::init('Product')->find('all', array('conditions' => array('category_id' => $category['Category']['category_id'], 'status' => 'Active')));
                
                $product_ids = array();
                foreach ($all_products as $key => $all_product) {
                    $product_ids[$key] = $all_product['Product']['product_id'];
                }
                $product_count = count($product_ids);
                $franchisee_products = ClassRegistry::init('Franchiseeproduct')->find('list', array('fields' => array('franchise_product_id', 'product_id'), 'conditions' => array('user_id' => $this->Session->read('User.user_id'), 'category_id' => $category['Category']['category_id'])));
                $result = array_diff($product_ids, $franchisee_products);
                $remain_product_count = count($result);
                $franchisee_product_count = $product_count - $remain_product_count;
                
                ?>
                <h3><p align="center"><?php echo strtoupper($category['Category']['category']).' ('.$franchisee_product_count.')' ?></p></h3>
                <?php echo $this->Form->submit('Save', array('class' => 'button'));?>
                <ul>
                    <?php
                    foreach ($products as $product) {
                        $image = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'status' => 'Active')));
                        ?>
                        <?php if (!empty($image)) { ?>
                            <li>
                                <div>
                                    <?php 
                                    $subcategory=ClassRegistry::init('Subcategory')->find('first', array('conditions' => array('subcategory_id' =>$product['Product']['subcategory_id'])));
                                    $Product_product_name=str_replace(" ","_",$product['Product']['product_name']);
                                    $link = BASE_URL.$category['Category']['category']."/".$subcategory['Subcategory']['subcategory']."/".$product['Product']['product_id']."/".$Product_product_name;
                                    ?>
                                    <a target="_blank" href="<?php echo $link;?>">
                                    <?php 
                                    echo $this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '100px', 'height' => '100', 'alt' => $product['Product']['product_name'], 'title' => $product['Product']['product_name'])); 
//                                    echo $this->Html->link($this->Html->image('product/small/' . $image['Productimage']['imagename'], array('border' => 0, 'width' => '100px', 'height' => '100')), array('action' => 'product', 'controller' => 'webpages', $category['Category']['link']), array('escape' => false)); 
                                    ?>
                                    </a>
                                </div>
                                <div style="text-align: center">
                                    <?php
                                    $metals=ClassRegistry::init('Productmetal')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id'],'type'=>'Purity')));
                                    $diamond=ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' =>$product['Product']['product_id'])));

                                    $product_code = $category['Category']['category_code'].$product['Product']['product_code'].'-'.$metals['Productmetal']['value'].'K';
                                    if(!empty($diamond)) {
                                        $product_code .= $diamond['Productdiamond']['clarity'].$diamond['Productdiamond']['color'];
                                    }
                                    $checked = in_array($product['Product']['product_id'], $franchisee_products);
                                    
                                    if($checked){
                                        echo $this->Form->hidden('franchisee_product_id', array('value' => array_search($product['Product']['product_id'], $franchisee_products), 'name' => "data[Franchiseeproduct][{$product['Product']['product_id']}][franchise_product_id]"));
                                    }
                                    echo $this->Form->hidden('category_id', array('value' => $category['Category']['category_id'], 'name' => "data[Franchiseeproduct][{$product['Product']['product_id']}][category_id]"));
                                    echo $this->Form->input('checkbox', array(
                                        'type'=>'checkbox', 
                                        'label' => false,
                                        'id' => 'checkbox_'.$product['Product']['product_id'],
                                        'name' => "data[Franchiseeproduct][{$product['Product']['product_id']}][checked]",
                                        'checked' => $checked
                                        ));
                                    echo "<div class='prod_name'><a href='{$link}' target='_blank'>{$product['Product']['product_name']}</a></div>";
                                    echo "<div class='prod_name prod_code'><a href='{$link}' target='_blank'>{$product_code}</a></div>";
                                    ?>
                                </div>
                                
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>

                <?php echo $this->Form->submit('Save', array('class' => 'button'));?>
                <?php echo $this->Form->end();?>
            </div> 

        </div>
    </div>


