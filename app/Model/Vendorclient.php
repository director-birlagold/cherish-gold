<?php
App::uses('AppModel', 'Model');
/**
 * Vendorclient Model
 *
 */
class Vendorclient extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'vendorclient';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'vendor_client_id';

}
