<?php
App::uses('StatusesController', 'Controller');

/**
 * StatusesController Test Case
 *
 */
class StatusesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.status',
		'app.adminuser',
		'app.emaillist',
		'app.emailcontent'
	);

}
