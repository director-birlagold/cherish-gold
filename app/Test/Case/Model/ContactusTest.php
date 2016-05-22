<?php
App::uses('Contactus', 'Model');

/**
 * Contactus Test Case
 *
 */
class ContactusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contactus'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contactus = ClassRegistry::init('Contactus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contactus);

		parent::tearDown();
	}

}
