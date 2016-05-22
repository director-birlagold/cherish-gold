<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 */
class States extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'states';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'state_id';

}
