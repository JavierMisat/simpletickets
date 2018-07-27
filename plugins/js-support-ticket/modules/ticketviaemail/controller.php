<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTticketviaemailController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        if (self::canaddfile()) {
            $layout = JSSTrequest::getLayout('jstlay', null, 'ticketviaemail');
            switch ($layout) {
                case 'admin_ticketviaemail':
                    $ck = JSSTincluder::getJSModel('configuration')->getCheckCronKey();
                    if ($ck == false) {
                        JSSTincluder::getJSModel('configuration')->genearateCronKey();
                    }
                    JSSTincluder::getJSModel('configuration')->getConfigurationByFor('ticketviaemail');
                break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'ticketviaemail');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        global $wp_query;
        if(is_null($wp_query))
            return false;
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    function registerReadEmails(){
        register_shutdown_function(array($this, 'readEmails'));
        echo "<style type=\"text/css\">
                    h1{color:1A5E80;}
                </style>";
        echo str_pad('<html><h1>' . __('Service is running please close the page','js-support-ticket') . '</h1></html>', 5120);
        echo str_pad(__('','js-support-ticket'), 5120) . "<br />\n";
        flush();
        ob_flush();
    }

    function readEmails() {
        JSSTincluder::getJSModel('configuration')->getConfigurationByFor('ticketviaemail');
        // $f = fopen(jssupportticket::$_path .  'mylogone.txt', 'a') or exit("Can't open $lfile!");
        // $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // $time = date('H:i:s');
        // $message = ' start ';
        // fwrite($f, "$time ($script_name) $message\n");
        if(jssupportticket::$_data[0]['tve_enabled'] == 1){ // Ticket via email is enabled
            // $message = ' tve_enabled = 1 ';
            // fwrite($f, "$time ($script_name) $message\n");
            $time = null;
            $runscript = false;
            $time = JSSTincluder::getJSModel('configuration')->getEmailReadTime();
            // $message = ' time in configuration =  '.$time;
            // fwrite($f, "$time ($script_name) $message\n");
            if($time == null){
                $runscript = true;
            }else{
                $currenttime = time();
                $lastruntime = $time;
                $nextruntime = $lastruntime + jssupportticket::$_data[0]['tve_emailreadingdelay'];
                // next time = current time + x sec

                if($currenttime >= $nextruntime){
                    $runscript = true;
                }else{
                    $runscript = false;
                }
            }
            if($runscript == true){
                $newtime = time();
                JSSTincluder::getJSModel('configuration')->setEmailReadTime($newtime);
                JSSTincluder::getJSModel('ticketviaemail')->readEmails();
            }
        }
        // $message = ' main function of controller end '.$time;
        // fwrite($f, "$time ($script_name) $message\n");
        // fclose($f);
        die('done');
    }

    static function saveticketviaemail() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('ticketviaemail')->storeConfiguration($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticketviaemail&jstlay=ticketviaemail");
        }
        wp_redirect($url);
        exit;
    }

}

$ticketviaemailController = new JSSTticketviaemailController();
?>
