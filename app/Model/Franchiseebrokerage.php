<?php
App::uses('AppModel', 'Model');
class Franchiseebrokerage extends AppModel {
    public $useTable = 'franchiseebrokerages';
    public $primaryKey = 'franchisee_brkge_id';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'franchisee_brkge_user_id'
        )
    );

}
