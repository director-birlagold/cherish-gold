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
class Shipping extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'shippingdetails';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'shipping_id';


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