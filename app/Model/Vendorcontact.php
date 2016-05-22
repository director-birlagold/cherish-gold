<?php
App::uses('AppModel', 'Model');
/**
 * Vendorcontact Model
 *
 */
class Vendorcontact extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'vendorcontact';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'vendor_contact_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
