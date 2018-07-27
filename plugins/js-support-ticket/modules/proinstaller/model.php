<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTproinstallerModel {

    function getServerValidate() {
        $array = explode('.', phpversion());
        $phpversion = $array[0] . '.' . $array[1];
        $curlexist = function_exists('curl_version');
        //$curlversion = curl_version()['version'];
        $curlversion = '';
        if (extension_loaded('gd') && function_exists('gd_info')) {
            $gd_lib = 1;
        } else {
            $gd_lib = 0;
        }
        $zip_lib = 0;

        if (file_exists(jssupportticket::$_path . 'includes/lib/pclzip.lib.php')) {
            $zip_lib = 1;
        }
        jssupportticket::$_data['phpversion'] = $phpversion;
        jssupportticket::$_data['curlexist'] = $curlexist;
        jssupportticket::$_data['curlversion'] = $curlversion;
        jssupportticket::$_data['gdlib'] = $gd_lib;
        jssupportticket::$_data['ziplib'] = $zip_lib;
    }

    function getConfiguration() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        // check for plugin using plugin name
        if (is_plugin_active('js-support-ticket/js-support-ticket.php')) {
            //plugin is activated
            $query = "SELECT config.* FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` AS config";
            $config = jssupportticket::$_db->get_results($query);
            foreach ($config as $conf) {
                jssupportticket::$_config[$conf->configname] = $conf->configvalue;
            }
            jssupportticket::$_config['config_count'] = COUNT($config);
        }
    }

    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("$path  can't create. Please create directory with 0755 permissions");
            fclose($ourFileHandle);
        }
    }


    function getStepTwoValidate() {
        $basepath = ABSPATH;
        if(!is_writable($basepath)){
            $return['tmpdir'] = 0;
        }else{
            $this->makeDir($basepath.'/tmp');
        }        
        $return['dir'] = substr(sprintf('%o', fileperms(jssupportticket::$_path)), -3);
        if(!is_writable(jssupportticket::$_path)){
            $return['dir'] = 0;
        }        
        $return['tmpdir'] = substr(sprintf('%o', fileperms($basepath.'/tmp')), -3);
        if(!is_writable($basepath.'/tmp')){
            $return['tmpdir'] = 0;
        }        
        $query = 'CREATE TABLE js_test_table(
                    id int,
                    name varchar(255)
                );';
        jssupportticket::$_db->query($query);
        $return['create_table'] = 1;

        if (jssupportticket::$_db->last_error != null) {
            $return['create_table'] = 0;
        }

        $query = 'INSERT INTO js_test_table(id,name) VALUES (1,\'Naeem\'),(2,\'Saad\');';
        jssupportticket::$_db->query($query);
        $return['insert_record'] = 1;
        if (jssupportticket::$_db->last_error != null) {
            $return['insert_record'] = 0;
        }
        $query = 'UPDATE js_test_table SET name = \'Shoaib Rehmat\' WHERE id = 1;';
        jssupportticket::$_db->query($query);
        $return['update_record'] = 1;

        if (jssupportticket::$_db->last_error != null) {
            $return['update_record'] = 0;
        }
        $query = 'DELETE FROM js_test_table;';
        jssupportticket::$_db->query($query);
        $return['delete_record'] = 1;
        if (jssupportticket::$_db->last_error != null) {
            $return['delete_record'] = 0;
        }
        $query = 'DROP TABLE js_test_table;';
        jssupportticket::$_db->query($query);
        $return['drop_table'] = 1;
        if (jssupportticket::$_db->last_error != null) {
            $return['drop_table'] = 0;
        }
        if ($return['dir'] >= 755 && $return['tmpdir'] >= 755) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_URL, 'http://test.setup.joomsky.com/logo.png');
            $fp = fopen(jssupportticket::$_path . 'logo.png', 'w+');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $return['file_downloaded'] = 0;
            if (file_exists(jssupportticket::$_path . 'logo.png')) {
                $return['file_downloaded'] = 1;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_URL, 'http://test.setup.joomsky.com/logo.png');
            $fp = fopen($basepath . '/tmp/logo.png', 'w+');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $return['file_downloaded'] = 0;
            if (file_exists(jssupportticket::$_path . 'logo.png')) {
                $return['file_downloaded'] = 1;
            }
        } else
            $return['file_downloaded'] = 0;
        jssupportticket::$_data['step2'] = $return;
    }

    function getmyversionlist() {
        $post_data['transactionkey'] = JSSTrequest::getVar('transactionkey');
        $post_data['serialnumber'] = JSSTrequest::getVar('serialnumber');
        $post_data['domain'] = JSSTrequest::getVar('domain');
        $post_data['producttype'] = JSSTrequest::getVar('producttype', null, 'pro');
        $post_data['productcode'] = JSSTrequest::getVar('productcode');
        $post_data['productversion'] = JSSTrequest::getVar('productversion');
        $post_data['JVERSION'] = JSSTrequest::getVar('JVERSION');
        $post_data['count'] = jssupportticket::$_config['config_count'];
        $post_data['installerversion'] = JSSTrequest::getVar('installerversion');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, JCONSTINST);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);
        return;
    }

}

?>
