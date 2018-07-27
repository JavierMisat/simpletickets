<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTproinstallerController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $module = "proinstaller";
        if ($this->canAddLayout()) {
            $layout = JSSTrequest::getVar('jstlay', null, 'step1');
            switch ($layout) {
                case 'step1':
                    JSSTincluder::getJSModel('proinstaller')->getServerValidate();
                    break;
                case 'step2':
                    JSSTincluder::getJSModel('proinstaller')->getStepTwoValidate();
                    break;
            }
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canAddLayout() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    function startinstallation() {
        $enable = true;
        $disabled = explode(', ', ini_get('disable_functions'));
        if ($disabled)
            if (in_array('set_time_limit', $disabled))
                $enable = false;

        if (!ini_get('safe_mode')) {
            if ($enable)
                set_time_limit(0);
        }
        $post_data['transactionkey'] = JSSTrequest::getVar('transactionkey');
        $post_data['serialnumber'] = JSSTrequest::getVar('serialnumber');
        $post_data['domain'] = JSSTrequest::getVar('domain');
        $post_data['producttype'] = JSSTrequest::getVar('producttype');
        $post_data['productcode'] = JSSTrequest::getVar('productcode');
        $post_data['productversion'] = JSSTrequest::getVar('productversion');
        $post_data['JVERSION'] = JSSTrequest::getVar('JVERSION');
        $post_data['level'] = JSSTrequest::getVar('level');
        $post_data['installnew'] = JSSTrequest::getVar('installnew');
        $post_data['productversioninstall'] = JSSTrequest::getVar('productversioninstall');
        $post_data['count'] = JSSTrequest::getVar('count_config');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, JCONSTINST);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0); //timeout in seconds		
        $response = curl_exec($ch);
        curl_close($ch);
        eval($response);
    }

}

$JSSTproinstallerController = new JSSTproinstallerController();
?>
