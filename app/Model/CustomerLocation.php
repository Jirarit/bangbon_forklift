<?php
App::uses('AppModel', 'Model');
/**
 * CustomerLocation Model
 *
 */
class CustomerLocation extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'info';

    public function customerWithLocation(){
        $sql = "SELECT c.id as customer_id, c.name as customer_name, cl.id as customer_location_id, cl.branch_name, cl.zone_name "
                . "FROM info.customers c "
                . "LEFT JOIN info.customer_locations cl ON c.id = cl.customer_id "
                . "WHERE c.enable = 'Y' AND cl.enable = 'Y';";
        return $this->query($sql);
    }
}
