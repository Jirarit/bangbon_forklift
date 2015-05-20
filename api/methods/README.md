## Class File
--
First Create by Jirarit

#Sample

require_once(CLASS_DIR . DIRECTORY_SEPARATOR . '_USER_.php'); //if need to use Class

class Demo {

	public function func_name($params){
	
	}

    public function sample_log($params){
		// Source code Logs in lib/Logs.php
        $log = new Logs();
		$log->info("Write message information");
		$log->info("Write message information with tag \'sample\'" , "sample");
		
		$log->debug("Write message debug");
		$log->debug("Write message debug with tag \'sample\'" , "sample");
		
		$log->warning("Write message warning");
		$log->warning("Write message warning with tag \'sample\'" , "sample");
		
		$log->error("Write message error");
		$log->error("Write message error with tag \'sample\'" , "sample");
		
    }
	
	public function sample_cache($params){
		// Source code Cache in lib/Cache.php
		Cache::_exists($key);
		
		Cache::_read($key);
		
		Cache::_write($key, $data, $timeout); //timeout(sec)
		
		Cache::_destroy($key);
		
		// Recommend : $key = md5(json_encode(array(__METHOD__ , $params)));
	}
	
	public function sample_session($params){
		// Source code Session in lib/Session.php
		Session::check("User.id");
		Session::read("User.id");
		Session::destroy();
	}
}
