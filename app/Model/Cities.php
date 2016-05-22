<?php
App::uses('AppModel', 'Model');
/**
 * Contactus Model
 *
 */
class Cities extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'cities';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'city_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
