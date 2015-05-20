<?php
/*{{{	method Authen change logs

Date.Time	Description
----------- --------------------------------------------------------------
150412.1210	First Create this Class		//WIN

----------- --------------------------------------------------------------

}}}*/
define("TABLE_USER", "auth.users");

class Authen {

    public function login($params) { /*{{{
     * Authen user login/pass
     * PARAMS : ['login'=>user_login, 'pass'=>user_pass]
     * RETURN
     *      SSID & User info        //Success
     *      0                       //Authen Fail
    */
        global $log, $db;
        $params = (array)$params;

        if ((!is_array($params)) || (!isset($params['login'])) || (!isset($params['pass']))){
             throw new Exception("", ERROR_INVALID_PARAMS);
        }
        $login = $params['login'];
        $pass = $params['pass'];

        $log->debug("Request login by {$login}");

        // Authen login & password
        $field = ['id', 'login', 'pass', 'enable'];
        $user = $db->query("SELECT " . implode(',', $field) . " FROM auth.users WHERE login = ?", [$login])->fetchFirst();
        if($user === FALSE){
            $log->warning("Login with user {$login} fail. User not exists");
            return 0;
        }

        if($user['enable'] !== 'Y'){
            $log->warning("Login with user {$login} fail. User disabled");
            return 0;
        }

        if($user['pass'] !== md5(md5($pass))){
            $log->warning("Login with user {$login} fail. Password wrong");
            return 0;
        }
        unset($user['pass']);

        $ssid = $db->tm18();

        session_id($ssid);
        session_start();

        // Push variables to _SESSION
        $_SESSION['SSID'] = $ssid;
        $_SESSION['User'] = $user;

        $log->info("Login with user {$login} success and get SSID #{$ssid}");
        return $_SESSION;
    }	/*}}}*/

    public function logout() { /*{{{
     * Logout
     * PARAMS : N/A
     * RETURN
     *      1           //Success
     *      0           //Fail
    */
        global $log;

        $log->debug("Request logout");
        // Auto pull ssid from _SESSION
        if (!isset($_SESSION['SSID'])) {
            $log->warning('Logout fail. SSID not exists');
            return 0;
        }
        $ssid = $_SESSION['SSID'];

        // Destroy Success
        $log->info('Success Destroy SSID #'.$ssid);
        session_destroy();

        // Everything OK
        return 1;
    } /*}}}*/

    public function get_menus() { /*{{{
     * List menu where the SSID accessable
     * PARAMS : N/A
     * RETURN
     *      []           //Success
     *      0            //Fail
    */
        
    }
}

?>
