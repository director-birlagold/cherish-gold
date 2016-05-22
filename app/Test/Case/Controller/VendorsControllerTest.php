<?php
App::uses('VendorsController', 'Controller');

/**
 * VendorsController Test Case
 *
 */
class VendorsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.vendor',
		'app.vendorclient',
		'app.vendorcontact',
		'app.vendorplant',
		'app.adminuser',
		'app.emaillist',
		'app.emailcontent'
	);

}
