<?php
App::uses('AppModel', 'Model');
/**
 * Contactus Model
 *
 */
class Contactus extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'contactus';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'contact_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
