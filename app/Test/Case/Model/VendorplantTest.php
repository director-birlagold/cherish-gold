<?php
App::uses('Vendorplant', 'Model');

/**
 * Vendorplant Test Case
 *
 */
class VendorplantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.vendorplant'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Vendorplant = ClassRegistry::init('Vendorplant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vendorplant);

		parent::tearDown();
	}

}
