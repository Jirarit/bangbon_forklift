<?php
App::uses('AppHelper', 'View/Helper');
class FormatHelper extends AppHelper {
    public $name = array('FormatHelper');
        
    public function money($number) {
        return number_format($number, 2);
    }
}

