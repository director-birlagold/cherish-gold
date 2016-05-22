<?php
App::uses('Vendorclient', 'Model');

/**
 * Vendorclient Test Case
 *
 */
class VendorclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.vendorclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Vendorclient = ClassRegistry::init('Vendorclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vendorclient);

		parent::tearDown();
	}

}
