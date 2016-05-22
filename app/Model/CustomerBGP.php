<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 */
class CustomerBGP extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'customer_master';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'customer_id';

}