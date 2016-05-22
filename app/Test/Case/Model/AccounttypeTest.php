<?php
App::uses('Accounttype', 'Model');

/**
 * Accounttype Test Case
 *
 */
class AccounttypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.accounttype'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Accounttype = ClassRegistry::init('Accounttype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Accounttype);

		parent::tearDown();
	}

}
