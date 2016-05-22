<?php
App::uses('AppModel', 'Model');
class Menu extends AppModel {
    public $useTable = 'menus';
    public $primaryKey = 'menu_id';
    public $hasMany = array(
        'Submenu' => array(
            'className' => 'Submenu'
        )
    );
}
