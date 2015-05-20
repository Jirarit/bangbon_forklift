<?php
Tools::_include_config("cache");

class Cache {

    const CACHE_MODE = 1;
    const CACHE_TIMEOUT = 180;

    static function _write($key , $data, $timeout = NULL){
        

        if(empty($key)){
            return FALSE;
        }

        $cache_mode = defined("CACHE_MODE") ? CACHE_MODE : self::CACHE_MODE;
        if($cache_mode === 0){
            return FALSE;
        }

        if($timeout === NULL){
            $timeout = defined("CACHE_TIMEOUT") ? CACHE_TIMEOUT : self::CACHE_TIMEOUT;
        }

        $file = Cache::_path_file($key);

        #Content in file cache
        $contents = array();
        #First line is expiry time
        $contents[] = date("ymdHis" , mktime(date('H'), date('i'), date('s') + $timeout, date('m'), date('d'), date('Y')));
        #Since 2nd onwards are data with json encoding
        $contents[] = json_encode($data,128); // 128=JSON_PRETTY_PRINT

        #Write cache
        file_put_contents($file , implode(PHP_EOL, $contents));
        #Set permission access to file cache
        chmod($file, 0777);
        return TRUE;
    }
    
    static function _exists($key){
        $cache_mode = defined("CACHE_MODE") ? CACHE_MODE : self::CACHE_MODE;
        if($cache_mode === 0){
            return FALSE;
        }

        $file = Cache::_path_file($key);

        #Check file cache is exists?
        if(!file_exists($file)){
            return FALSE;
        }

        #If file cache existing then check expiry time(first line)
        $fileHandler = fopen($file, 'r');
        $expire = fgets($fileHandler);
        if($expire < date('ymdHis')){
            #If cache expired then destroy
            Cache::_destroy($key);
            return FALSE;
        }
        fclose($fileHandler);
        return TRUE;
    }

    static function _read($key){
        $cache_mode = defined("CACHE_MODE") ? CACHE_MODE : self::CACHE_MODE;
        if($cache_mode === 0){
            return NULL;
        }

        $file = Cache::_path_file($key);

        #Check cache is exists
        if(Cache::_exists($key) === FALSE){
            return NULL;
        }

        #Get content in file to array
        $result = file($file);

        #Unset timeout (line 1)
        unset($result[0]);

        #concatenate array to json
        $result = implode("", $result);

        #Decode json
        $result = json_decode($result);

        return $result;
    }

    static function _destroy($key){
        @unlink(CACHE_DIR . DIRECTORY_SEPARATOR . "{$key}.cache");
    }

    static function _clear_cache_expired(){
        if ($dirHandle = opendir(CACHE_DIR)) {
            while (false !== ($file = readdir($dirHandle))) {
                if(is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == ".cache"){
                    $fileHandle = fopen($file, 'r');
                    $timeout = fgets($fileHandle);
                    fclose($fileHandle);
                    if($timeout < date('ymdHis')){
                        unlink($file);
                    }
                }
            }
        }
    }

    static function _generate_key($method , $params = NULL){
        if(is_array($params)){
            ksort($params);
        }
        $method = str_replace("::", ".", $method);
        $clean_char = array(" ", '"', "'", "&", "/", "\\", "?", "#", ":");
        $method = str_replace($clean_char, "", $method);
        return $method . "." . md5(json_encode(array($method , $params)));
    }

    static function _path_file($key, $method = ""){
        $cache_dir = defined("CACHE_DIR") ? CACHE_DIR : TMP_DIR . DIRECTORY_SEPARATOR . "cache";
        return $cache_dir . DIRECTORY_SEPARATOR . "{$key}.cache";
    }
}