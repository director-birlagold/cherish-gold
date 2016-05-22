<?php
App::uses('AppModel', 'Model');
class Offer extends AppModel {
    public $useTable = 'offers';
    public $primaryKey = 'offer_id';
    
    public $belongsTo = array(
        'Menu' => array(
            'className' => 'Menu',
            'foreignKey' => 'menu_id'
        ),
        'Submenu' => array(
            'className' => 'Submenu',
            'foreignKey' => 'submenu_id'
        )
    );

}
