<?php
App::uses('AppModel', 'Model');
/**
 * Vendor Model
 *
 * @property Vendorclient $Vendorclient
 * @property Vendor $Vendor
 * @property Vendorcontact $Vendorcontact
 * @property Vendorplant $Vendorplant
 */
class Vendor extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'vendor';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'vendor_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	

/**
 * hasMany associations
 *
 * @var array
 */
	

}
