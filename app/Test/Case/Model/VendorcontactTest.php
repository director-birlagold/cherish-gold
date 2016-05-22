<?php
App::uses('Vendorcontact', 'Model');

/**
 * Vendorcontact Test Case
 *
 */
class VendorcontactTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.vendorcontact'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Vendorcontact = ClassRegistry::init('Vendorcontact');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vendorcontact);

		parent::tearDown();
	}

}
