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

    public function productWithSerial() {
        $sql = "SELECT p.id as product_id, p.name,pb.name as brand, ps.id as product_serial_id, ps.serial_no "
                . "FROM info.products p "
                . "LEFT JOIN info.product_serials ps ON p.id = ps.product_id "
                . "LEFT JOIN info.product_brands pb ON p.brand_id = pb.id "
                . "WHERE p.enable = 'Y';";
        return $this->query($sql);
    }
}
