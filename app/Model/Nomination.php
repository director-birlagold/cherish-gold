<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Nomination extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'nominations';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'nominee_id';

}
