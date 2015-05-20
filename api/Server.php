<?php
/*
Change History
------------------------------------------------------------------------------
141225.1546		Change returning value from function registerMethod() return
				Real cause message and send it back to description
------------------------------------------------------------------------------
150105.1103 Tuning
------------------------------------------------------------------------------
150105.2038 Add verify session
*/
require_once(ROOT_DIR . "/lib/Core.php");

class Server {    
    /**
     * Raw request data
     *
     * @access private
     * @var string
     */
    private $_raw;
    
    /**
     * List of method which ignore verify session
     *
     * @access protected
     * @var array
     */
    protected $_method_session_ignore = array("Authen::login");

    function __construct($raw) {
        $this->_raw = $raw;
    }
    
    function process(){
        try{
            if(empty($this->_raw)){
                throw new Exception("Empty raw request", ERROR_INVALID_REQUEST);
            }

            $requestObj = $this->decodeRequest();
            
            if(is_object($requestObj)){
                #Single request
                $responseObj = $this->singleRequest($requestObj);
            }elseif(is_array($requestObj)){
                #Batch request
                $responseObj = $this->batchRequest($requestObj);
            }else{
                throw new Exception("Unknown type of request", ERROR_INVALID_REQUEST);
            }
        } catch (Exception $e) {
            Logs::_write(Logs::ERROR, "Catch Exception [" . $e->getCode() . "] " . $e->getMessage() . " @" . $e->getFile() . " (Line:" . $e->getLine() . ")");
            $responseObj = $this->createErrorObj($e->getCode() , $e->getMessage() , @$requestObj->id);
        }
        
        return $this->response($responseObj);
    }
    
    function decodeRequest(){
        $requestObj = json_decode($this->_raw, false, 512, JSON_BIGINT_AS_STRING);
        
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
            throw new Exception($errorMsg, ERROR_PARSE_ERROR);
        }

        return $requestObj;
    }

    function batchRequest($requestBatch){
        $response = array();
        foreach($requestBatch as $requestObj){
            $result = $this->singleRequest($requestObj);
            if($result !== NULL){
                array_push($response, $result);
            }
        }
        return empty($response) ? NULL : $response;
    }

    function singleRequest($requestObj){
        try {
            $this->verifyRequest($requestObj);
            return $this->callMethod($requestObj);
        } catch (Exception $e) {
            Logs::_write(Logs::ERROR, "Catch Exception [" . $e->getCode() . "] " . $e->getMessage() . " @" . $e->getFile() . " (Line:" . $e->getLine() . ")", $requestObj->method);
            return $this->createErrorObj($e->getCode() , $e->getMessage() , @$requestObj->id);
        }
    }

    function verifyRequest($requestObj){
        #Check request is object
        if(! is_object($requestObj)){
            throw new Exception("", ERROR_INVALID_REQUEST);
        }

        #Check params jsonrpc
        if(empty($requestObj->jsonrpc)){
            throw new Exception("Invalid params jsonrpc", ERROR_INVALID_REQUEST);
        }
        
        #Check JsonRPC version
        if($requestObj->jsonrpc != JSONRPC_VERSION){
            throw new Exception("", ERROR_MISMATCHED_VERSION);
        }
        
        #Check params method
        if(empty($requestObj->method)){
            throw new Exception("Invalid params method", ERROR_INVALID_REQUEST);
        }
        
        #Check format method
        @list($className, $methodName) = explode("::" , $requestObj->method , 2);
        if($className === NULL || $methodName === NULL){
            throw new Exception("Method format wrong", ERROR_INVALID_REQUEST);
        }
        
        #Path to file method
        $file = METHOD_DIR . DIRECTORY_SEPARATOR . "{$className}.php";
        
        #Check syntax error
        /*
        check file exist and no syntax error
        this checking style should use in debug mode only
        In real production should disable this checking
        */
        $check_file = exec("php -l {$file}");
        if(substr($check_file , 0 , 14) === 'Could not open'){
            throw new Exception("File method not exists", ERROR_METHOD_NOT_FOUND);
        }elseif(substr($check_file , 0 , 15) === 'PHP Parse error'){
            throw new Exception("Syntax error in file method", ERROR_METHOD_NOT_FOUND);
        }elseif(substr($check_file , 0 , 16) !== 'No syntax errors'){
            throw new Exception($check_file, ERROR_METHOD_NOT_FOUND);
        }
        
        #Include file method
        if(!require_once($file)){
            throw new Exception("Cannot include file method", ERROR_METHOD_NOT_FOUND);
        }
        
        #Check class exist in file
        if(class_exists($className) === FALSE){
            throw new Exception("Class not exists in file method", ERROR_METHOD_NOT_FOUND);
        }
        
        #Check method exist in class
        if(method_exists(new $className() , $methodName) === FALSE){
            throw new Exception("Method not exists in class", ERROR_METHOD_NOT_FOUND);
        }
        
        #Verify params id
        if(isset($requestObj->id)){
            @list($session_id, $running) = explode(":", $requestObj->id,2);
            if($session_id === NULL || $running === NULL){
                throw new Exception("ID format wrong", ERROR_INVALID_REQUEST);
            }

            if(SYS_AUTHEN === TRUE){
                if(!in_array($requestObj->method, $this->_method_session_ignore) && !in_array("{$className}::*", $this->_method_session_ignore)){
                    $session = new Session($session_id);
                    if ($session->check('SSID') === FALSE) {
                        throw new Exception('SSID not found', ERROR_ACCESS_DENIED);
                    }
                }
            }
            
        }
        
        #Everything OK
        return TRUE;
    }
        
    function callMethod($requestObj){
        @list($session_id, $running) = explode(":", $requestObj->id,2);

        $params = isset($requestObj->params) ? $requestObj->params : NULL;
        if($running !== ""){ //Need result response
            list($class, $func) = explode("::", $requestObj->method);
            $result = call_user_func(array(new $class(), $func), $params);
            return $this->createResponseObj($result, $requestObj->id);
        }else{ //Just notice no need any response
            list($class, $func) = explode("::", $requestObj->method);
            $result = call_user_func(array(new $class(), $func), $params);
            return NULL;
        }
        
        return $this->createResponseObj($result, $requestObj->id);
    }
    
    function response($objResponse){
        if($objResponse !== NULL){
            return json_encode($objResponse);
        }
    }
    
    function createErrorObj($code, $message = "", $id = NULL){
        $obj = new stdClass();
        $obj->jsonrpc = JSONRPC_VERSION;
        $obj->error = new stdClass();
        $obj->error->code = $code;
        $obj->error->message = $this->getErrorCodeMessage($code , $message);
        $obj->id = $id;
        return $obj;
    }

    function createResponseObj($result, $id = NULL){
        $obj = new stdClass();
        $obj->jsonrpc = JSONRPC_VERSION;
        $obj->result = $result;
        $obj->id = $id;
        return $obj;
    }
    
    function getErrorCodeMessage($code, $additionInfo = ""){
        
        $additionInfo = empty($additionInfo) ? "" : ": " . $additionInfo;
        
        switch ((int) $code){
            case ERROR_PARSE_ERROR: return "Parse error" . $additionInfo;
            case ERROR_INVALID_REQUEST: return "Invalid request" . $additionInfo;
            case ERROR_METHOD_NOT_FOUND: return "Method not found" . $additionInfo;
            case ERROR_INVALID_PARAMS: return "Invalid params" . $additionInfo;
            case ERROR_INTERNAL: return "Internal error" . $additionInfo;
            case ERROR_MISMATCHED_VERSION: return "Mismatched version" . $additionInfo;
            case ERROR_ACCESS_DENIED: return "Access denied" . $additionInfo;
            case ERROR_PERMISSION_DENIED: return "Permission denied" . $additionInfo;
            case ERROR_DATABASE_CONNECTION: return "Database cannot connect" . $additionInfo;
            case ERROR_EXCEPTION: return "Exception" . $additionInfo;
            default : return "Unknown error" . $additionInfo;
        }
    }
}
