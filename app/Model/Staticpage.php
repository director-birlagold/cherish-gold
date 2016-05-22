<?php
App::uses('AppModel', 'Model');
/**
 * Staticpage Model
 *
 */
class Staticpage extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'staticpage_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'pagename';

}
