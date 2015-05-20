<?php
App::uses('AppHelper', 'View/Helper');
class FlagHelper extends AppHelper {
    public $name = array('FlagHelper');
    public $helpers = array('Html' , 'Form');
        
    public function serialStatus($flag = NULL){
        //A=Available, R=Rent, S=Sold out, F=Fix(Repair)
        $list = ['A'=>'Available', 'R'=>'Rent', 'F'=>'Repair', 'I'=>'Inactive'];
        return ($flag === NULL) ? $list : @$list[$flag];
    }
    
    public function forkliftGear($flag = NULL){
        //A=Auto, M=Manual
        $list = ['A'=>'Auto', 'M'=>'Manual'];
        return ($flag === NULL) ? $list : @$list[$flag];
    }
    
    public function forkliftEngine($flag = NULL){
        //B=Battery, D=Diesel, G=Gasoline&LPG
        $list = ['B'=>'Battery', 'D'=>'Diesel', 'G'=>'Gasoline&LPG'];
        return ($flag === NULL) ? $list : @$list[$flag];
    }
    
    public function contractStatus($flag = NULL){
        //A=Acitive, I=Inactive
        $list = ['A'=>'Active', 'I'=>'Inactive'];
        return ($flag === NULL) ? $list : @$list[$flag];
    }
}

