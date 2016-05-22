<?php
/**
 * VendorclientFixture
 *
 */
class VendorclientFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'vendorclient';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'vendor_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'vendor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'client' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255, 'unsigned' => false),
		'turnover' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'vendor_client_id', 'unique' => 1)
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
			'vendor_client_id' => 1,
			'vendor_id' => 1,
			'client' => 1,
			'turnover' => 'Lorem ipsum dolor sit amet'
		),
	);

}
