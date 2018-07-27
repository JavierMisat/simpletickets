<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTformhandler {

    function __construct() {
        add_action('init', array($this, 'checkFormRequest'));
        add_action('init', array($this, 'checkDeleteRequest'));
    }

    /*
     * Handle Form request
     */

    function checkFormRequest() {
        $formrequest = JSSTrequest::getVar('form_request', 'post');
        if ($formrequest == 'jssupportticket') {
            //handle the request
            $page_id = JSSTRequest::getVar('page_id', 'GET');
            jssupportticket::setPageID($page_id);
            $modulename = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($modulename);
            JSSTincluder::include_file($module);
            $class = 'JSST' . $module . "Controller";
            $task = JSSTrequest::getVar('task');
            $obj = new $class;
            $obj->$task();
        }
    }

    /*
     * Handle Form request
     */

    function checkDeleteRequest() {
        $jssupportticket_action = JSSTrequest::getVar('action', 'get');
        if ($jssupportticket_action == 'jstask') {
            //handle the request
            $page_id = JSSTRequest::getVar('page_id', 'GET');
            jssupportticket::setPageID($page_id);
            $modulename = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($modulename);
            JSSTincluder::include_file($module);
            $class = 'JSST' . $module . "Controller";
            $action = JSSTrequest::getVar('task');
            $obj = new $class;
            $obj->$action();
        }
    }

}

$formhandler = new JSSTformhandler();
?>
