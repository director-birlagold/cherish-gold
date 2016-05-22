<?php
App::uses('Discount', 'Model');

/**
 * Discount Test Case
 *
 */
class DiscountTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.discount'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Discount = ClassRegistry::init('Discount');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Discount);

		parent::tearDown();
	}

}
