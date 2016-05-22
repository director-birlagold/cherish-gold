<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Outlet extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'outlets';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'out_id';

}
