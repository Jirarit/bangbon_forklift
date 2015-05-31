<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 */
class Menu extends AppModel {

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

    public function accessible_menu($type, $parent = 0) {
        $menus = $this->find('all', array('conditions'=>array('enable'=>'Y', 'parent'=>$parent, 'type'=>$type), 'order'=>array('sort', 'id')));
        $Rule = ClassRegistry::init('Rule');
        $result = array();
        foreach($menus as $menu){
            $item = $menu['Menu']['item'];
            $action = $menu['Menu']['action'];

            if($Rule->accessible($item, $action) === TRUE) {
                $link = $menu['Menu']['host'] . $menu['Menu']['path'];
                $name = $menu['Menu']['name'];
                $name_en = $menu['Menu']['name_en'];
                $parent = $menu['Menu']['id'];
                $result[] = array('link'=>$link, 'name'=>$name, 'name_en'=>$name_en, 'sub'=>$this->accessible_menu($type, $parent));
            }
        }

        return $result;
    }
}
