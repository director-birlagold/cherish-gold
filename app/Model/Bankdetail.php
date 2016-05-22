<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Bankdetail extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'bankdetails';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'bank_id';

}
