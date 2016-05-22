<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Payment extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'payments';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'pay_id';

}
