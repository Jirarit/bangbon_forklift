<?php
/*	Class JsonRpcClient Change Logs
	===============================
{{{ 
	Change Date		Description
	-----------		-----------------------------------------------------------
	150206.1150		Modify from Win class for easy to use and practical	//pitak
	150320.1054		Formatting source code for easy read	//pitak

	-----------		-----------------------------------------------------------
}}} */

require(dirname(__FILE__).'/color.php');

class JsonRpcClient {

    const JSONRPC_VERSION = '2.0';

	/*{{{ Client Error Code Constant	*/
    const ERROR_PARSE_ERROR     = -32700;
    const ERROR_INVALID_REQUEST = -32600;
    const ERROR_INTERNAL        = -32603;
    #-32000 to -32099: Server error = Reserved for implementation-defined server-errors.
    const ERROR_SERVER_CONNECTION   = -32050;
    const ERROR_MISMATCHED_VERSION  = -32051;
    const ERROR_PERMISSION_DENIED   = -32052;
    const ERROR_EXCEPTION           = -32099;
	/*}}}*/

	/*{{{	Protected Variables		*/
	protected $_url = 'http://127.0.0.1/api/';
	protected $_timeout = 5;
    protected $_headers = array(
        'Connection: close',
        'Content-Type: application/json',
        'Accept: application/json'
		);
	/*}}}*/

	/*{{{	Public Variables		*/
    public $IsDebug = FALSE;
	public $LastError = NULL;	// Error Object
	/*}}}*/

	//=== Protected Function --------------------------------------------------

    protected function decode_response($response) {	/*{{{
		Decode data from response string into format of JSON
		and return correct error code if occure
		*/
        $responseDecode = json_decode($response, true);

        $decodeError = json_last_error();
        if($decodeError !== JSON_ERROR_NONE){
            $errorMsg = "";
            switch ($decodeError) {
                case JSON_ERROR_DEPTH:
                    $errorMsg = 'Maximum stack depth exceeded';break;
                case JSON_ERROR_STATE_MISMATCH:
                    $errorMsg = 'Underflow or the modes mismatch';break;
                case JSON_ERROR_CTRL_CHAR:
                    $errorMsg = 'Unexpected control character found';break;
                case JSON_ERROR_SYNTAX:
                    $errorMsg = 'Syntax error, malformed JSON';break;
                case JSON_ERROR_UTF8:
                    $errorMsg = 'Malformed UTF-8 characters, possibly incorrectly encoded';break;
                default:
                    $errorMsg = 'Unknown error';break;
            }

            return $this->create_error_obj(
				self::ERROR_PARSE_ERROR,
				"Parse response data error: " . $errorMsg);
        }
        return $responseDecode;

    }	/*}}}*/

    protected function create_error_obj($code , $message) {	/*{{{
		Create and prepare class ErrorObject
		*/
        $obj = new stdClass();
        $obj->jsonrpc = self::JSONRPC_VERSION;
        $obj->error = new stdClass();
        $obj->error->code = $code;
        $obj->error->message = $message;
        $obj->id = null;
        return $obj;
    }	/*}}}*/

    protected function create_request_obj($method, $params=NULL, $ssid=NULL, $isNotify=FALSE) {	/*{{{
		Create class Request from input attribute
		*/
		// Create object structure
        $obj = new stdClass();
        	$obj->jsonrpc = self::JSONRPC_VERSION;
        	$obj->method = $method;
			if (!is_null($params)) $obj->params = $params;
       
	   	// Try start session
		if (session_status()!==PHP_SESSION_ACTIVE) @session_start();

		// Auto load last session if (session_id NULL)
		if (is_null($ssid) && isset($_SESSION['SSID'])) $ssid = $_SESSION['SSID'];
		if (is_null($ssid)) $ssid = 0;	// Convert to Zero if still NULL

		if ($isNotify) {
			// Blank sequence cause it is Notify request
            $obj->id = $ssid.':';
		}
		else {
			// Prepare auto Sequence
			if (isset($_SESSION['SEQ'])) $id_seq = (int)$_SESSION['SEQ']+1;
			else $id_seq =1;

			// Save last sequence in Session
			$_SESSION['SEQ'] = $id_seq;

			// Save last session ID
			$_SESSION['SSID'] = $ssid;

			// Normal message must in format SSID:SEQ
            $obj->id = $ssid.':'.$id_seq;
        }
        return $obj;

    }	/*}}}*/
    
    function debug($data) {	/*{{{
		Show debug message in well form format
		*/
        $call_by = debug_backtrace();
        $file = $call_by[0]["file"];
        $line = $call_by[0]["line"];
        
		
        echo color::fgRed,"DEBUG {$file} (Line:{$line})",color::fgMagenta,PHP_EOL;
        print_r($data);
        echo color::fgNormal,PHP_EOL;
    }	/*}}}*/
    
	//=== Public Function -----------------------------------------------------

	public function __construct($remote_url='') {	/*{{{
		Constructuor of class
		*/
		if (!empty($remote_url))
			$this->_url = $remote_url;
	}	/*}}}*/

	public function call($method, $params=NULL, $id=NULL, $isNotify=FALSE) { /*{{{
		Do a single request
		Return:
			result object		//on success
			false				//on any fail, check error from $this->LastError
		*/
		$requestObj = $this->create_request_obj($method, $params, $id, $isNotify);
		$requestJson = json_encode($requestObj);
		if ($this->IsDebug) $this->debug(array('REQUEST'=>$requestJson));
        $opt = array('http'=>array(
                'method'=>"POST",
                'header'=>$this->_headers,
                'content'=>$requestJson,
                'timeout'=>$this->_timeout
            	));
        $context = stream_context_create($opt);
        $responseJson = file_get_contents($this->_url, false, $context);
		if (FALSE===$responseJson) {
			$responseObj = $this->create_error_obj(
									self::ERROR_SERVER_CONNECTION,
									'Cannot connect server');
			$this->LastError = $responseObj->error;	// Get Error Object ONLY
			return(false);
		}
		if ($this->IsDebug) $this->debug(array('RESPONSE'=>$responseJson));
		$responseObj = $this->decode_response($responseJson);
		if (!isset($responseObj['result'])) {				// Trap for Error
			$this->LastError = $responseObj['error'];
			return(false);
		}
		return($responseObj['result']);	// Only Result that Need

	}	/*}}}*/

	//-------------------------------------------------------------------------
}
