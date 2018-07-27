<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTajax {

    function __construct() {
        add_action("wp_ajax_jsticket_ajax", array($this, "ajaxhandler")); // when user is login
        add_action("wp_ajax_nopriv_jsticket_ajax", array($this, "ajaxhandler")); // when user is not login
    }

    function ajaxhandler() {
        $module = JSSTrequest::getVar('jstmod');
        $task = JSSTrequest::getVar('task');
        $result = JSSTincluder::getJSModel($module)->$task();
        echo $result;
        die();
    }

}

$jsajax = new JSSTajax();
?>
