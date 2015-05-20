<?php 
 ini_set('error_reporting', E_ALL);
session_start();if(!isset($_SESSION["ApiRequestObj"]))$_SESSION["ApiRequestObj"]=array();

$file_config = "../conf/api_test.conf";
if(file_exists($file_config)){
	require_once($file_config);
}

$default_method = defined("TEST_DEFAULT_METHOD") ? TEST_DEFAULT_METHOD : "";
$default_params = defined("TEST_DEFAULT_PARAMS") ? TEST_DEFAULT_PARAMS : "";
$default_id = defined("TEST_DEFAULT_ID") ? TEST_DEFAULT_ID : "";

$fix_method = isset($_POST["method"]) ? $_POST["method"] : $default_method; 
$fix_params = isset($_POST["params"]) ? $_POST["params"] : $default_params;
$fix_id = isset($_POST["id_no"]) ? $_POST["id_no"] : $default_id;
?>
<h1>TEST-API</h1>
<?php $client = new Client(); ?>
<form method="post">
    <table>
        <tr>
            <td>- Method : </td><td><input type="text" name="method" size="100" value="<?=$fix_method?>"></td>
        </tr>
        <tr>
            <td>- Params(Json): </td><td><input type="text" name="params" size="100" value='<?=$fix_params?>'></td>
        </tr>
        <tr>
            <td>- ID : </td><td><input type="text" name="id_no" size="30" value="<?=$fix_id?>"></td>
        </tr>
    </table>
<input type="submit" name="add" value="Add"><input type="submit" name="submit" value="Send">
</form>

<hr>


<?php

if(!empty($_POST["method"])){
    $client->initRequest();
    $method = $_POST["method"];
    $params = (empty($_POST["params"])) ? NULL : json_decode($_POST["params"], TRUE);
    $id = (empty($_POST["id_no"])) ? NULL : $_POST["id_no"];
    $client->addRequest($method,$params,$id);
    array_push($_SESSION["ApiRequestObj"], $client->_requestObj);
}

if(!empty($_SESSION["ApiRequestObj"])){
    echo "<h2> REQUEST </h2>";
    $client->initRequest();
    foreach($_SESSION["ApiRequestObj"] as $obj){
        $client->addRequest($obj->method,@$obj->params,$obj->id);
    }
    echo "<pre>";
    echo json_encode($client->_requestObj);
    echo "</pre>";
    echo "<form method='post'><input type='submit' name='clear' value='Clear'></form>";
    echo "<hr>";
    
    if(isset($_POST["submit"])){
        $response = $client->sendRequest();
        
        echo "<h2> RESPONSE </h2>";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        echo "<hr>";
        
        session_destroy();
    }elseif(isset($_POST["clear"])){
        session_destroy();
    }
    
}



class Client {

    /**
     * Version of Json RPC
     *
     * @access const
     * @var string
     */
    const JSONRPC_VERSION = '2.0';
        
    /**
     * URL of the server
     *
     * @access private
     * @var string
     */
    private $_url = "http://172.16.8.77:8080/api/";
    
    /**
     * HTTP client timeout
     *
     * @access private
     * @var integer
     */
    private $_timeout = 5;
    
    /**
     * Default HTTP headers to send to the server
     *
     * @access private
     * @var array
     */
    private $_headers = array(
        'Connection: close',
        'Content-Type: application/json',
        'Accept: application/json'
    );
	
    /**
     * Enable debug request and response
     *
     * @access private
     * @var boolean
     */
    private $_debug = TRUE;
	
    /**
     * Request object data
     *
     * @access private
     * @var array
     */
    var $_requestObj;

    /* <Error Codes> */
    /* <JSON RPC Error Codes> */
    const ERROR_PARSE_ERROR = -32700;
    const ERROR_INVALID_REQUEST = -32600;
    const ERROR_METHOD_NOT_FOUND = -32601;
    const ERROR_INVALID_PARAMS = -32602;
    const ERROR_INTERNAL = -32603;

    #-32000 to -32099: Server error = Reserved for implementation-defined server-errors.
    const ERROR_EXCEPTION = -32099;
    /* </Error Codes> */

    function __construct(){
		if(defined("TEST_URL_SERVER")){
			$this->_url = TEST_URL_SERVER;
		}
        echo "<hr>URL : " . $this->_url . "<hr>";
    }

    function enableDebug(){
        $this->_debug = TRUE;
    }

    function initRequest(){
        $this->_requestObj = array();
    }

    function addRequest($method, $params = NULL, $id = NULL){
        //var_dump($params); 
        if(empty($this->_requestObj)){
            $this->_requestObj = $this->_createRequestObj($method, $params, $id);
            return TRUE;
        }elseif(is_object($this->_requestObj)){
            $tmp = $this->_requestObj;
            $this->_requestObj = array();
            return array_push($this->_requestObj, $tmp, $this->_createRequestObj($method, $params, $id));
        }else{
            return array_push($this->_requestObj, $this->_createRequestObj($method, $params, $id));
        }
    }

    function sendRequest(){
        if(empty($this->_requestObj)){
            return $this->_createErrorObj(self::ERROR_INVALID_REQUEST , "Invalid request");
        }

        $jsonRequest = json_encode($this->_requestObj);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Web-Client');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
        $response = curl_exec($ch);
        
        if($response === FALSE){
            return $this->_createErrorObj(self::ERROR_EXCEPTION , "Cannot connect to server");
        }
        
        $this->_removeBOM($response);
        
        echo "<h2> RAW RESPONSE </h2>";
        echo "$response";
        echo "<hr>";
        
        return $this->decodeResponse($response);
    }

    function decodeResponse($response){
        if(empty($response)){
            return NULL;
        }
        
        $responseDecode = json_decode($response);

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

            return $this->_createErrorObj(self::ERROR_PARSE_ERROR , "Parse response data error: " . $errorMsg);
        }

        return $responseDecode;
    }

    private function _createErrorObj($code , $message){
        $obj = new stdClass();
        $obj->jsonrpc = self::JSONRPC_VERSION;
        $obj->error = new stdClass();
        $obj->error->code = $code;
        $obj->error->message = $message;
        $obj->id = null;
        return $obj;
    }

    private function _createRequestObj($method, $params = NULL, $id = NULL){
        $obj = new stdClass();
        $obj->jsonrpc = self::JSONRPC_VERSION;
        $obj->method = $method;
        if(!empty($params)){
            $obj->params = $params;
        }
        if($id !== NULL){
            $obj->id = $id;
        }
        return $obj;
    }
    
    private function _removeBOM(&$str){
        if(substr($str, 0,3) == pack("CCC",0xef,0xbb,0xbf)) {
            $str=substr($str, 3);
        }
        return trim($str);
    }
}
