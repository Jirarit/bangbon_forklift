<?php
/**
 * Tools for handler session
 *
 * @author Win
 */

class Session {
	
    function __construct($id) {
		session_id($id);
		session_start();
    }
	
	public static function check($path){
		if (is_string($path) || is_numeric($path)) {
			$parts = explode('.', $path);
		} else {
			$parts = $path;
		}
		$data = $_SESSION;
		foreach ($parts as $key) {
			if (!isset($data[$key])) {
				return FALSE;
			}
			$data =& $data[$key];
		}
		return TRUE;
	}
	
	public static function read($path){
		if (is_string($path) || is_numeric($path)) {
			$parts = explode('.', $path);
		} else {
			$parts = $path;
		}
		$data = $_SESSION;
		foreach ($parts as $key) {
			if (!isset($data[$key])) {
				return NULL;
			}
			$data =& $data[$key];
		}
		return $data;
	}

    public static function destory(){
        return session_destroy();
    }
}
