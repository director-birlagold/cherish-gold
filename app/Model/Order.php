<?php

App::uses('AppModel', 'Model');

/**
 * Contactus Model
 *
 */
class Order extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'orders';

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'order_id';

    /**
     * Display field
     *
     * @var string
     */
    public $belongsTo = array(
        'Orderstatus' => array(
            'className' => 'Orderstatus',
            'foreignKey' => 'order_status_id'
        ),
        'Adminstatus' => array(
            'className' => 'Adminstatus',
            'foreignKey' => 'admin_status_id'
        )
    );

}
