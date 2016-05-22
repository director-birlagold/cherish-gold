<?php
App::uses('AppModel', 'Model');
class Franchiseeproduct extends AppModel {
    public $useTable = 'franchiseeproducts';
    public $primaryKey = 'franchise_product_id';
    public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        )
    );
}
