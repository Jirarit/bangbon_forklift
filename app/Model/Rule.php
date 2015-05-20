<?php
App::uses('AppModel', 'Model');
/**
 * Rule Model
 *
 */
class Rule extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'app';

    public function accessible($item, $action) {
        return TRUE;
    }
}
