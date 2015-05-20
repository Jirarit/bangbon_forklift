<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

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

    public $belongsTo = array(
		'UserProfile' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
