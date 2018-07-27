<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTrequest {
    /*
     * Check Request from both the Get and post method
     */

    static function getVar($variable_name, $method = null, $defaultvalue = null, $typecast = null) {
        $value = null;
        if ($method == null) {
            if (isset($_GET[$variable_name])) {
                $value = $_GET[$variable_name];
            } elseif (isset($_POST[$variable_name])) {
                $value = $_POST[$variable_name];
            } elseif (get_query_var($variable_name)) {
                $value = get_query_var($variable_name);
            }elseif(isset(jssupportticket::$_data['sanitized_args'][$variable_name]) && jssupportticket::$_data['sanitized_args'][$variable_name] != ''){
              $value = jssupportticket::$_data['sanitized_args'][$variable_name];
            }
        } else {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    if (isset($_POST[$variable_name]))
                        $value = $_POST[$variable_name];
                    break;
                case 'get':
                    if (isset($_GET[$variable_name]))
                        $value = $_GET[$variable_name];
                    break;
            }
        }
        if ($typecast != null) {
            $typecast = strtolower($typecast);
            switch ($typecast) {
                case "int":
                    $value = (int) $value;
                    break;
                case "string":
                    $value = (string) $value;
                    break;
            }
        }
        if ($value == null)
            $value = $defaultvalue;
        //echo print_r($value); exit;
        return $value;
    }

    /*
     * Check Request from both the Get and post method
     */

    static function get($method = null) {
        $array = null;
        if ($method != null) {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    $array = $_POST;
                    break;
                case 'get':
                    $array = $_GET;
                    break;
            }
        }
        return $array;
    }

    /*
     * Check Request from both the Get and post method
     */

    static function getLayout($layout, $method = null, $defaultvalue) {
        $layoutname = null;
        if ($method != null) {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    $layoutname = $_POST[$layout];
                    break;
                case 'get':
                    $layoutname = $_GET[$layout];
                    break;
            }
        } else {
            if (isset($_POST[$layout]))
                $layoutname = $_POST[$layout];
            elseif (isset($_GET[$layout]))
                $layoutname = $_GET[$layout];
            elseif (get_query_var($layout))
                $layoutname = get_query_var($layout);
            elseif(isset(jssupportticket::$_data['sanitized_args'][$layout]) && jssupportticket::$_data['sanitized_args'][$layout]  != '')
              $layoutname = jssupportticket::$_data['sanitized_args'][$layout];
        }
        if ($layoutname == null) {
            $layoutname = $defaultvalue;
        }
        if (is_admin()) {
            $layoutname = 'admin_' . $layoutname;
        }
        return $layoutname;
    }

}

?>
