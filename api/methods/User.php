<?php
/*{{{	method User change logs

Date.Time	Description
----------- --------------------------------------------------------------
150413.0857	First Create this Class		//WIN

----------- --------------------------------------------------------------

}}}*/
Tools::_require_class("_USER_");

class User {

    public function get_profile($uid) { /*{{{
     * Get user profile
     * PARAMS : (bigint)uid
     * RETURN
     *      [id=>uid, name, ...]    //Success
     *      []                      //User not found
     * 
    */
        global $log, $db;
        

        if ((int)$uid !== $uid){
             throw new Exception("Invalid user id", ERROR_INVALID_PARAMS);
        }
        $log->debug("Request user profile of {$uid}");

        // Authen login & password
        $profile = _USER_::_info($uid);
        if($profile === FALSE){
            $log->warning("Not found profile for user id {$uid}");
            return [];
        }

        $log->debug("Succes return user profile");
        return $profile;
    }	/*}}}*/

    public function create($params) { /*{{{
     * Create new user
     * PARAMS : (Obj)information
     *      Require Key : [login, pass, name]
     * RETURN
     *      (bigint)uid             //Success
     *      0                       //Fail
    */
        global $log, $db;

        return 1;
    } /*}}}*/

    public function update($params) { /*{{{
     * Update user information
     * PARAMS : (Array)information
     *      Require Key : [id]
     * RETURN
     *      1                       //Success
     *      0                       //Fail
    */
        global $log, $db;

        return 1;
    } /*}}}*/

    public function change_password($params) { /*{{{
     * Change Password
     * PARAMS : (Obj)
     *      Require Key : [id, old_pass, new_pass, confirm_pass]
     * RETURN
     *      1                       //Success
     *      0                       //Fail
    */
        global $log, $db;
        
        return 1;
    } /*}}}*/
}

?>
