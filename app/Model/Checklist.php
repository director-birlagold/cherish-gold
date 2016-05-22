<?php
App::uses('AppModel', 'Model');
/**
 * Vendorplant Model
 *
 */
class Checklist extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'checklist';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'checklist_id';

}
