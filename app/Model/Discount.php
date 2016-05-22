<?php
App::uses('AppModel', 'Model');
/**
 * Discount Model
 *
 */
class Discount extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'discount';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'discount_id';

}
