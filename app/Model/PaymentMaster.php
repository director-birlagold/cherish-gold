<?php
App::uses('AppModel', 'Model');
/**
 * Type Model
 *
 */
class PaymentMaster extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'payment_master';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'payment_id';

}