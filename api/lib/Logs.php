<?php
@include_once CONF_DIR . DIRECTORY_SEPARATOR . "log.conf";
class Logs {
    const LOG_MODE = 4;

    const DEBUG = "D";
    const INFO = "I";
    const WARNING = "W";
    const ERROR = "E";

    public $file, $tag;

    function __construct($tag = NULL, $file = NULL) {
        $this->tag = empty($tag) ? "" : $tag;
        $this->file = empty($file) ? date("ymd") : $file;
    }

    public function info($message, $tag = NULL, $file = NULL){
        $file = (empty($file)) ? $this->file : $file;
        $tag = (empty($tag)) ? $this->tag : $tag;
        return Logs::_write(Logs::INFO, $message, $tag, $file, FALSE);
    }

    public function debug($message, $tag = NULL, $file = NULL){
        $file = (empty($file)) ? $this->file : $file;
        $tag = (empty($tag)) ? $this->tag : $tag;
        return Logs::_write(Logs::DEBUG, $message, $tag, $file, FALSE);
    }

    public function warning($message, $tag = NULL, $file = NULL){
        $file = (empty($file)) ? $this->file : $file;
        $tag = (empty($tag)) ? $this->tag : $tag;
        return Logs::_write(Logs::WARNING, $message, $tag, $file, FALSE);
    }

    public function error($message, $tag = NULL, $file = NULL){
        $file = (empty($file)) ? $this->file : $file;
        $tag = (empty($tag)) ? $this->tag : $tag;
        return Logs::_write(Logs::ERROR, $message, $tag, $file, FALSE);
    }	

    static function _write($type, $message, $tag = NULL, $file = NULL, $static_call = TRUE){
        $log_mode = defined("LOG_MODE") ? LOG_MODE : self::LOG_MODE;
        switch ($log_mode) {
            case 0: return;
            case 1: if(!in_array($type, ['E'])) { return; }
            case 2: if(!in_array($type, ['E', 'W'])) { return; }
            case 3: if(!in_array($type, ['E', 'W', 'I'])) { return; }
            default: if(!in_array($type, ['E', 'W', 'I', 'D'])) { return; }
        }

        $time = explode(' ',microtime());
        $time = $time[0] * 1000000;
        $time = date("His") . ":" . sprintf("%06d",$time);

        if(empty($tag)){
            $call_by = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
            $call_by = ($static_call) ? $call_by[1] : $call_by[2];
            $tag = $call_by["class"] . "::" . $call_by["function"];
        }

        $session = '{' . (isset($_SESSION['SSID']) ? $_SESSION['SSID'] : str_repeat('0', 18)) . '}';

        $message = print_r($message, TRUE);
        $content = "{$type}[{$time}] {$session}<{$tag}> {$message}" . PHP_EOL;

        $file = empty($file) ? date("ymd") : $file;
        $file = Logs::_path_file($file);

        error_log($content, 3, $file);
        chmod($file, 0777);
        //file_put_contents($this->file, $content, FILE_APPEND);
        return $time;
    }

    static function _path_file($file){
        $cache_dir = defined("LOG_DIR") ? LOG_DIR : TMP_DIR . DIRECTORY_SEPARATOR . "logs";
        return $cache_dir . DIRECTORY_SEPARATOR . "{$file}.log";
    }
}

$log = new Logs();
?>