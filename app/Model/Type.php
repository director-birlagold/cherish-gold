<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 */
class Type extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'type';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'vendor_type_id';

}
