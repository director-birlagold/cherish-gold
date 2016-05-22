<?php
/**
 * VendorFixture
 *
 */
class VendorFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'vendor';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'vendor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'Company_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_state' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_pincode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_phone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_phone1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reg_mobile' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_state' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_pincode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_phone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_phone1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ho_mobile' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_state' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_pincode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_phone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_phone1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_mobile' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'vendor_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'bank_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'account_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'micr_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ifsc_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'bank_pincode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'state_sales_tax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'central_sales_tax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tax_index_no' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_contact_tax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'good_service_tax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'value_add_tax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'total_experience' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'capital_amount' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'turnover_first_year' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Product_category' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'product_certificate' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'vendor_id', 'unique' => 1)
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
			'vendor_id' => 1,
			'Company_name' => 'Lorem ipsum dolor sit amet',
			'reg_address' => 'Lorem ipsum dolor sit amet',
			'reg_address1' => 'Lorem ipsum dolor sit amet',
			'reg_city' => 'Lorem ipsum dolor sit amet',
			'reg_state' => 'Lorem ipsum dolor sit amet',
			'reg_pincode' => 'Lorem ipsum dolor sit amet',
			'reg_phone' => 'Lorem ipsum dolor sit amet',
			'reg_phone1' => 'Lorem ipsum dolor sit amet',
			'reg_mobile' => 'Lorem ipsum dolor sit amet',
			'ho_address' => 'Lorem ipsum dolor sit amet',
			'ho_address1' => 'Lorem ipsum dolor sit amet',
			'ho_city' => 'Lorem ipsum dolor sit amet',
			'ho_state' => 'Lorem ipsum dolor sit amet',
			'ho_pincode' => 'Lorem ipsum dolor sit amet',
			'ho_phone' => 'Lorem ipsum dolor sit amet',
			'ho_phone1' => 'Lorem ipsum dolor sit amet',
			'ho_mobile' => 'Lorem ipsum dolor sit amet',
			'work_address' => 'Lorem ipsum dolor sit amet',
			'work_address1' => 'Lorem ipsum dolor sit amet',
			'work_city' => 'Lorem ipsum dolor sit amet',
			'work_state' => 'Lorem ipsum dolor sit amet',
			'work_pincode' => 'Lorem ipsum dolor sit amet',
			'work_phone' => 'Lorem ipsum dolor sit amet',
			'work_phone1' => 'Lorem ipsum dolor sit amet',
			'work_mobile' => 'Lorem ipsum dolor sit amet',
			'vendor_type' => 1,
			'bank_name' => 'Lorem ipsum dolor sit amet',
			'account_type' => 'Lorem ipsum dolor sit amet',
			'micr_code' => 'Lorem ipsum dolor sit amet',
			'ifsc_code' => 'Lorem ipsum dolor sit amet',
			'bank_pincode' => 'Lorem ipsum dolor sit amet',
			'state_sales_tax' => 'Lorem ipsum dolor sit amet',
			'central_sales_tax' => 'Lorem ipsum dolor sit amet',
			'tax_index_no' => 'Lorem ipsum dolor sit amet',
			'work_contact_tax' => 'Lorem ipsum dolor sit amet',
			'good_service_tax' => 'Lorem ipsum dolor sit amet',
			'value_add_tax' => 'Lorem ipsum dolor sit amet',
			'total_experience' => 'Lorem ipsum dolor sit amet',
			'capital_amount' => 'Lorem ipsum dolor sit amet',
			'turnover_first_year' => 'Lorem ipsum dolor sit amet',
			'Product_category' => 'Lorem ipsum dolor sit amet',
			'product_certificate' => 'Lorem ipsum dolor sit amet'
		),
	);

}
