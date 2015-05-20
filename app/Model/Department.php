<?php
App::uses('AppModel', 'Model');
/**
 * Department Model
 *
 */
class Department extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'app';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
