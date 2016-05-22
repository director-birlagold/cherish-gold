<?php
App::uses('Emailcontent', 'Model');

/**
 * Emailcontent Test Case
 *
 */
class EmailcontentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.emailcontent'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Emailcontent = ClassRegistry::init('Emailcontent');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Emailcontent);

		parent::tearDown();
	}

}
