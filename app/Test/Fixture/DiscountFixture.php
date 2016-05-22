<?php
/**
 * DiscountFixture
 *
 */
class DiscountFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'discount';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'discount_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'voucher_code' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'product_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'percentage' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'start_date' => array('type' => 'timestamp', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'),
		'expired_date' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created_date' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modify_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'discount_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'discount_id' => 1,
			'voucher_code' => 1,
			'product_id' => 1,
			'percentage' => 1,
			'user_id' => 1,
			'start_date' => 1420803319,
			'expired_date' => 1,
			'created_date' => 1420803319,
			'modify_date' => '2015-01-09 17:05:19'
		),
	);

}
