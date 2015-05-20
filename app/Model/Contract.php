<?php
App::uses('AppModel', 'Model');
/**
 * Contract Model
 *
 * @property Product $Product
 * @property ProductSerial $ProductSerial
 * @property Customer $Customer
 * @property CustomerLocation $CustomerLocation
 */
class Contract extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'trans';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Serial' => array(
			'className' => 'ProductSerial',
			'foreignKey' => 'product_serial_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CustomerLocation' => array(
			'className' => 'CustomerLocation',
			'foreignKey' => 'customer_location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
