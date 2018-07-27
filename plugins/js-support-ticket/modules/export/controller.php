<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTExportController {

    function __construct() {
        
    }

    function getoverallexport() {

        $return_value = JSSTincluder::getJSModel('export')->setOverallExport();

        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Overall Reports', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getstaffmemberexport() {

        $return_value = JSSTincluder::getJSModel('export')->setStaffMemberExport();
        //var_dump($return_value);
        //die();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }
    
    function getstaffmemberexportbystaffid() {
        $return_value = JSSTincluder::getJSModel('export')->setStaffMemberExportByStaffId();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }
    
    function getusersexport() {
        $return_value = JSSTincluder::getJSModel('export')->setUsersExport();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }
    
    function getuserexportbyuid() {
        $return_value = JSSTincluder::getJSModel('export')->setUserExportByuid();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }
}

?>