<?php
App::uses('AppModel', 'Model');
class Orderhistory extends AppModel {
    public $useTable = 'orderhistory';
    public $primaryKey = 'history_id';
    
    public $belongsTo = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id'
        ),
        'Oldorderstatus' => array(
            'className' => 'Orderstatus',
            'foreignKey' => 'old_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'orderstatus'
            )
        ),
        'Neworderstatus' => array(
            'className' => 'Orderstatus',
            'foreignKey' => 'new_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'orderstatus'
            )
        ),
        'Oldadminstatus' => array(
            'className' => 'Adminstatus',
            'foreignKey' => 'old_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'adminstatus'
            )
        ),
        'Newadminstatus' => array(
            'className' => 'Adminstatus',
            'foreignKey' => 'new_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'adminstatus'
            )
        ),
        'Oldbrokeragestatus' => array(
            'className' => 'Brokeragestatus',
            'foreignKey' => 'old_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'brokeragestatus'
            )
        ),
        'Newbrokeragestatus' => array(
            'className' => 'Brokeragestatus',
            'foreignKey' => 'new_status_id',
            'conditions' => array(
                'Orderhistory.status_type' => 'brokeragestatus'
            )
        ),
    ); 
}
