<?php
/* System Path */
define("CLASS_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "class");
define("CONF_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "conf");
define("LIB_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "lib");
define("METHOD_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "methods");
define("TMP_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "tmp");

/* JsonRPC Version */
define("JSONRPC_VERSION" , "2.0");

/* <JSON RPC Error Codes> */
define("ERROR_PARSE_ERROR"          , -32700);
define("ERROR_INVALID_REQUEST"      , -32600);
define("ERROR_METHOD_NOT_FOUND"     , -32601);
define("ERROR_INVALID_PARAMS"       , -32602);
define("ERROR_INTERNAL"             , -32603);

#-32000 to -32099: Server error = Reserved for implementation-defined server-errors.
define("ERROR_MISMATCHED_VERSION"   , -32000);
define("ERROR_INVALID_ID"           , -32001);
define("ERROR_ACCESS_DENIED"        , -32002);
define("ERROR_PERMISSION_DENIED"    , -32003);
define("ERROR_DATABASE_CONNECTION"  , -32004);
define("ERROR_EXCEPTION"            , -32099);
/* </JSON RPC Error Codes> */

require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Logs.php';

/* Fatal error handler */
ini_set("display_errors", '0');
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
        case E_ERROR:           $error_type = "Fatal error";    break;
        case E_STRICT:          $error_type = "Strict";         break;
        case E_COMPILE_ERROR:   $error_type = "Complie error";  break;
        case E_CORE_ERROR:      $error_type = "Core error";     break;
        case E_USER_ERROR:      $error_type = "User error";     break;
        case E_WARNING:         $error_type = "Warning";        break;
        case E_NOTICE:          $error_type = "Notice";         break;
        default:                $error_type = "Unknown error type#" . $errno; break;
    }
    Logs::_write(Logs::ERROR, "{$error_type}: " . $errstr . " @" . $errfile . " (Line:" . $errline . ")", "ErrorHandler");
}
set_error_handler("myErrorHandler");

function myShutdownHandler()
{
    $err = error_get_last();
    if($err === NULL){
        return;
    }
    switch ($err['type']) {
        case E_ERROR:           $error_type = "Fatal error";    break;
        case E_STRICT:          $error_type = "Strict";         break;
        case E_COMPILE_ERROR:   $error_type = "Complie error";  break;
        case E_CORE_ERROR:      $error_type = "Core error";     break;
        case E_USER_ERROR:      $error_type = "User error";     break;
        case E_WARNING:         $error_type = "Warning";        break;
        case E_NOTICE:          $error_type = "Notice";         break;
        case E_PARSE:           $error_type = "Parse";          break;
        default:                $error_type = "Unknown error type#" . $err['type']; break;
    }
    Logs::_write(Logs::ERROR, "{$error_type}: " . $err['message'] . " @" . $err['file'] . " (Line:" . $err['line'] . ")", "ShutdownHandler");
}
register_shutdown_function("myShutdownHandler");


require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Tools.php';
require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Cache.php';
require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Session.php';
require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Database.php';
require_once LIB_DIR . DIRECTORY_SEPARATOR . 'Rule.php';

/* Core Configurations */
define("SYS_AUTHEN", FALSE); //On/Off check authen session