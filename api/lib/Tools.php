<?php
/* {{{
 * Lib/Tools contain general function
 * 
 }}}*/
class Tools {
    static function _version(){ /*{{{
     * Generate int date 18 digits yymmddhhiiss + microsec6digits
     */
        $msec = explode(' ',microtime());
        $msec = $msec[0] * 1000000;
        return date("ymdHis") . sprintf("%06d",$msec);
    } /*}}}*/

    static function _uuid(){ /*{{{
     * Generate UUID
     */
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    } /*}}}*/

    static function _debug($data, $return = FALSE){ /*{{{
     * Use for debug data with file name and line number
     */
        $call_by = debug_backtrace();
        $file = $call_by[0]["file"];
        $line = $call_by[0]["line"];
        
        $msg = "<pre>"
                . "DEBUG {$file} (Line:{$line})" . PHP_EOL
                . print_r($data, TRUE) . PHP_EOL
                . "</pre>";
        if($return){
            return $msg;
        }else{
            echo $msg;
        }
    } /*}}}*/

    static function _verify_permission($action, $item){ /*{{{
     * Check permission access by using RULE::check
     */
        global $log;
        
        if (($cr=Rule::check($action, $item))===false) {
            $log->error("Denied UserID={$_SESSION['User']['id']} "
                        . "login={$_SESSION['User']['login']} "
                        . "no permission to {$action} {$item}");
            throw new Exception("", ERROR_PERMISSION_DENIED);
        }
        $log->info( "Allow UserID={$_SESSION['User']['id']} "
                        . "login={$_SESSION['User']['login']} "
                        . "to {$action} {$item} with Rule#{$cr[0]} CompileVersion#{$cr[1]}");
    } /*}}}*/

    static function _require_class($class){ /*{{{
     * Use for require class
     * Step working
     * - Check file class exits?
     * -- if file exists, require_once file class 
     * -- if file not exists, write log and then throw exception internal error
     */
        if(!is_array($class)){
            $class = [$class];
        }
        foreach($class as $cls){
            $path_file = CLASS_DIR . DIRECTORY_SEPARATOR . $cls . ".php";
            if(file_exists($path_file)){
                require_once $path_file;
            }else{
                $call_by = debug_backtrace();
                $file = $call_by[0]["file"];
                $line = $call_by[0]["line"];
                Logs::_write(Logs::ERROR, "Cannot include file '{$path_file}' @{$file} (Line:{$line})");
                throw new Exception("", ERROR_INTERNAL);
            }
        }
    } /*}}}*/

    static function _include_config($cofigs) { /*{{{
     * Use for include config
     * Step working
     * - Check file config exits?
     * -- if file exists, require_once file class 
     * -- if file not exists, write log warning
     */
        if(!is_array($cofigs)){
            $cofigs = [$cofigs];
        }
        foreach($cofigs as $conf){
            $path_file = CONF_DIR . DIRECTORY_SEPARATOR . $conf . ".conf";
            if(file_exists($path_file)){
                include_once $path_file;
            }else{
                $call_by = debug_backtrace();
                $file = $call_by[0]["file"];
                $line = $call_by[0]["line"];
                //Logs::_write(Logs::WARNING, "Cannot include file '{$path_file}' @{$file} (Line:{$line})");
            }
        }
    } /*}}}*/
    
    static function _filter_data(&$datas, $valid_key) {
        foreach ($arr_data as $k=>$v){
            if (! in_array($k, $valid_key)){
                unset($arr_data[$k]);
            }
        }
    }
}