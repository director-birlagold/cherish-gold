<?php
App::uses('AppModel', 'Model');
class Submenu extends AppModel {
    public $useTable = 'submenus';
    public $primaryKey = 'submenu_id';
    public $belongsTo = array(
        'Menu' => array(
            'className' => 'Menu',
            'foreignKey' => 'menu_id'
        )
    );
    public $hasMany = array(
        'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'submenu_id'
        )
    );
}
