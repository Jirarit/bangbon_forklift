<?php
//	Class _USER_
//	Working with users

//	Change Logs
//	-----------	------------------------------------------------
//	150412	First Create File	//win

class _USER_ {
    
    static function _info($id) { /*{{{
     * 
     */
        global $db;
        
        $query = "SELECT * FROM auth.users u LEFT JOIN auth.user_profiles up ON u.id = up.id WHERE u.id = ?";
        $info = $db->query($query, [$id])->fetchFirst();
        
        return $info;
    } /*}}}*/
    
    static function _find($filter) { /*{{{
     * 
     */
        
    } /*}}}*/
}

?>
