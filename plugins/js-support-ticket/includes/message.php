<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTmessage {
    /*
     * Set Message
     * @params $message = Your message to display
     * @params $type = Messages types => 'updated','error','update-nag'
     */

    static function setMessage($message, $type) {
        if (isset($_SESSION['msg'])) {
            $count = COUNT($_SESSION['msg']);
            $_SESSION['msg'][$count] = $message;
            $_SESSION['type'][$count] = $type;
        } else {
            $_SESSION['msg'][0] = $message;
            $_SESSION['type'][0] = $type;
        }
    }

    static function getMessage() {
        $frontend = (is_admin()) ? '' : 'frontend';
        $divHtml = '';
        $option = get_option('jssupportticket', array());
        if (isset($_SESSION['msg'][0]) && isset($_SESSION['type'][0])) {
            for ($i = 0; $i < COUNT($_SESSION['msg']); $i++)
                $divHtml .= '<div class=" ' . $frontend . ' ' . $_SESSION['type'][$i] . '"><p>' . $_SESSION['msg'][$i] . '</p></div>';
        }
        echo $divHtml;
        unset($_SESSION['msg']);
        unset($_SESSION['type']);
    }

}

?>
