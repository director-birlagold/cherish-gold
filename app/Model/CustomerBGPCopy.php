<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 */
class CustomerBGPCopy extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'customer_master_copy';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'customer_id';

}