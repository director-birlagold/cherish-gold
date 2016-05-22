<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'categories';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'category_id';



}
