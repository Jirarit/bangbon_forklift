<?php
App::uses('AppModel', 'Model');
/**
 * ForkliftProperty Model
 *
 */
class ProductProperty extends AppModel {

    public $useTable = false;
/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'info';

    function useProperty($category_code){
        $table = "property_" . strtolower($category_code);
        $this->setSource($table);
    }
}
