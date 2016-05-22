<?php
/**
 * VendorplantFixture
 *
 */
class VendorplantFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'vendorplant';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'vendor_plant_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'vendor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'manufacture_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'year' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'vendor_plant_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'vendor_plant_id' => 1,
			'vendor_id' => 1,
			'manufacture_name' => 'Lorem ipsum dolor sit amet',
			'year' => 1
		),
	);

}
