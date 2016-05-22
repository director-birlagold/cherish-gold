<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Payu extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'payu';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'payu_id';

}
