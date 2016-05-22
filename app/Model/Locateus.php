<?php
App::uses('AppModel', 'Model');
/**
 * Contactus Model
 *
 */
class Locateus extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'locateus';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'locateus_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
