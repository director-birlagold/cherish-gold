<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Rating extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'rating';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'rating_id';

}
