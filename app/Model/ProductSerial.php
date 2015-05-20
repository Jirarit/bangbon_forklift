<?php
App::uses('AppModel', 'Model');
/**
 * ProductSerial Model
 *
 */
class ProductSerial extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'info';

    public $virtualFields = array('age'=>'age(manufacture_date)');
}
