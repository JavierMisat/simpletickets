<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTEncoder {

    private $securekey, $iv;

    function __construct($textkey = '') {
        //$this->securekey = hash('sha256', $textkey, TRUE);
        //$this->iv = mcrypt_create_iv(32);
    }

    function encrypt($input) {
        //return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_ECB, $this->iv));
        return base64_encode($input);
    }

    function decrypt($input) {
        //return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, base64_decode($input), MCRYPT_MODE_ECB, $this->iv));
        return base64_decode($input);
    }

}

?>
