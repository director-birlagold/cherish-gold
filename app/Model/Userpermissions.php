<?php
App::uses('AppModel', 'Model');
class Userpermissions extends AppModel {
    public $useTable = 'permissions';
    public $primaryKey = 'perm_id';
}
