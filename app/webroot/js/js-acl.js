/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    if("undefined"==typeof jQuery) {
        //throw new Error("JS-ACL's JavaScript requires jQuery");
        console.log("JS-ACL's JavaScript requires jQuery");
        return;
    }
    if($("div#acl-crt").length == 0) {
        //throw new Error("ACL Disabled");
        console.log("ACL Disabled");
        return;
    }

    /* Config */
    var defaultAccess = 'A'; // A=ALLOW, D=DENY
    var defaultAction = 'disabled'; // disable, hidden, redirect
    
    
    
    var crt = $("div#acl-crt").attr('value');
    try {
        crt = JSON.parse(crt);
    } catch (e) {
        //throw new Error("Invalid acl-ctr value");
        console.log("Invalid acl-ctr value");
        return;
    }

    if($.isArray(crt) === false)throw new Error("Invalid acl-ctr value");


    $('[acl-item]').each(function() {
        ele_item = $(this).attr('acl-item');
        ele_action = $(this).attr('acl-action');

        denied_action = $(this).attr('acl-denied-action');
        if(denied_action === undefined){
            denied_action = defaultAction;
        }
        
        /* Compile access element */
        permission = checkPermission(ele_item, ele_action);
        if(permission !== 'A'){
            switch(denied_action){
                case 'disabled': $(this).attr('disabled','disabled'); break;
                case 'hidden': $(this).remove(); break;
                case 'redirect': 
                    $('body').empty();
                    $('body').html('Access Denied');
                    break;
            }
        }
        
        
    });
    
    function checkPermission(item, action){
        result = '';
        crt.forEach(function(crt_obj) {
            if(result !== '') return;
            console.log(crt_obj);
            if(crt_obj.item === item || crt_obj.item === 'ALL'){
                if(crt_obj.action === action || crt_obj.action === 'ALL'){
                    console.log('Match ' + crt_obj.item  + ':' + crt_obj.action + ' = ' + crt_obj.ad);
                    result = crt_obj.ad;
                    return;
                }
            }
        });
        return (result === '') ? defaultAccess : result;
    }
});