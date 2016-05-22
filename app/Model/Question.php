<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 */
class Question extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'question';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'question_id';

}