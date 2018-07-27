<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTcaptcha {

    function getCaptchaForForm() {
        $rand = $this->randomNumber();
        $_SESSION['jssupportticket_spamcheckid'] = $rand;
        $_SESSION['jssupportticket_rot13'] = mt_rand(0, 1);
        $operator = 2;
        if ($operator == 2) {
            $tcalc = jssupportticket::$_config['owncaptcha_calculationtype'];
        }
        $max_value = 20;
        $negativ = 1;
        $operend_1 = mt_rand($negativ, $max_value);
        $operend_2 = mt_rand($negativ, $max_value);
        $operand = jssupportticket::$_config['owncaptcha_totaloperand'];
        if ($operand == 3) {
            $operend_3 = mt_rand($negativ, $max_value);
        }

        if (jssupportticket::$_config['owncaptcha_calculationtype'] == 2) { // Subtraction
            if (jssupportticket::$_config['owncaptcha_subtractionans'] == 1) {
                $ans = $operend_1 - $operend_2;
                if ($ans < 0) {
                    $one = $operend_2;
                    $operend_2 = $operend_1;
                    $operend_1 = $one;
                }
                if ($operand == 3) {
                    $ans = $operend_1 - $operend_2 - $operend_3;
                    if ($ans < 0) {
                        if ($operend_1 < $operend_2) {
                            $one = $operend_2;
                            $operend_2 = $operend_1;
                            $operend_1 = $one;
                        }
                        if ($operend_1 < $operend_3) {
                            $one = $operend_3;
                            $operend_3 = $operend_1;
                            $operend_1 = $one;
                        }
                    }
                }
            }
        }

        if ($tcalc == 0)
            $tcalc = mt_rand(1, 2);

        if ($tcalc == 1) { // Addition
            if ($_SESSION['jssupportticket_rot13'] == 1) { // ROT13 coding
                if ($operand == 2) {
                    $_SESSION['jssupportticket_spamcheckresult'] = str_rot13(base64_encode($operend_1 + $operend_2));
                } elseif ($operand == 3) {
                    $_SESSION['jssupportticket_spamcheckresult'] = str_rot13(base64_encode($operend_1 + $operend_2 + $operend_3));
                }
            } else {
                if ($operand == 2) {
                    $_SESSION['jssupportticket_spamcheckresult'] = base64_encode($operend_1 + $operend_2);
                } elseif ($operand == 3) {
                    $_SESSION['jssupportticket_spamcheckresult'] = base64_encode($operend_1 + $operend_2 + $operend_3);
                }
            }
        } elseif ($tcalc == 2) { // Subtraction
            if ($_SESSION['jssupportticket_rot13'] == 1) {
                if ($operand == 2) {
                    $_SESSION['jssupportticket_spamcheckresult'] = str_rot13(base64_encode($operend_1 - $operend_2));
                } elseif ($operand == 3) {
                    $_SESSION['jssupportticket_spamcheckresult'] = str_rot13(base64_encode($operend_1 - $operend_2 - $operend_3));
                }
            } else {
                if ($operand == 2) {
                    $_SESSION['jssupportticket_spamcheckresult'] = base64_encode($operend_1 - $operend_2);
                } elseif ($operand == 3) {
                    $_SESSION['jssupportticket_spamcheckresult'] = base64_encode($operend_1 - $operend_2 - $operend_3);
                }
            }
        }
        $add_string = "";
        $add_string .= '<div><label for="' . $_SESSION['jssupportticket_spamcheckid'] . '">';

        if ($tcalc == 1) {
            if ($operand == 2) {
                $add_string .= $operend_1 . ' ' . __('Plus', 'js-support-ticket') . ' ' . $operend_2 . ' ' . __('Equals', 'js-support-ticket') . ' ';
            } elseif ($operand == 3) {
                $add_string .= $operend_1 . ' ' . __('Plus', 'js-support-ticket') . ' ' . $operend_2 . ' ' . __('Plus', 'js-support-ticket') . ' ' . $operend_3 . ' ' . __('Equals', 'js-support-ticket') . ' ';
            }
        } elseif ($tcalc == 2) {
            $converttostring = 0;
            if ($operand == 2) {
                $add_string .= $operend_1 . ' ' . __('Minus', 'js-support-ticket') . ' ' . $operend_2 . ' ' . __('Equals', 'js-support-ticket') . ' ';
            } elseif ($operand == 3) {
                $add_string .= $operend_1 . ' ' . __('Minus', 'js-support-ticket') . ' ' . $operend_2 . ' ' . __('Minus', 'js-support-ticket') . ' ' . $operend_3 . ' ' . __('Equals', 'js-support-ticket') . ' ';
            }
        }

        $add_string .= '</label>';
        $add_string .= '<input type="text" name="' . $_SESSION['jssupportticket_spamcheckid'] . '" id="' . $_SESSION['jssupportticket_spamcheckid'] . '" size="3" class="inputbox ' . $rand . '" value="" data-validation="required" />';
        $add_string .= '</div>';

        return $add_string;
    }

    function randomNumber() {
        $pw = '';

        // first character has to be a letter
        $characters = range('a', 'z');
        $pw .= $characters[mt_rand(0, 25)];

        // other characters arbitrarily
        $numbers = range(0, 9);
        $characters = array_merge($characters, $numbers);

        $pw_length = mt_rand(4, 12);

        for ($i = 0; $i < $pw_length; $i++) {
            $pw .= $characters[mt_rand(0, 35)];
        }
        return $pw;
    }

    private function performChecks() {
        if ($_SESSION['jssupportticket_rot13'] == 1) {
            $spamcheckresult = base64_decode(str_rot13($_SESSION['jssupportticket_spamcheckresult']));
        } else {
            $spamcheckresult = base64_decode($_SESSION['jssupportticket_spamcheckresult']);
        }
        $spamcheck = JSSTrequest::getVar($_SESSION['jssupportticket_spamcheckid'], '', 'post');
        unset($_SESSION['jssupportticket_rot13']);
        unset($_SESSION['jssupportticket_spamcheckid']);
        unset($_SESSION['jssupportticket_spamcheckresult']);
        if (!is_numeric($spamcheckresult) || $spamcheckresult != $spamcheck) {
            return false; // Failed
        }
        /*        // Hidden field
          $type_hidden = 0;
          if ($type_hidden) {
          $hidden_field = $session->get('hidden_field', null, 'checkspamcalc');
          $session->clear('hidden_field', 'checkspamcalc');

          if (JJSSTrequest::getVar($hidden_field, '', 'post')) {
          return false; // Hidden field was filled out - failed
          }
          }
          // Time lock
          $type_time = 0;
          if ($type_time) {
          $time = $session->get('time', null, 'checkspamcalc');
          $session->clear('time', 'checkspamcalc');

          if (time() - $this->params->get('type_time_sec') <= $time) {
          return false; // Submitted too fast - failed
          }
          }
          $session->clear('ip', 'jsautoz_buyercheckspamcalc');
          $session->clear('saved_data', 'jsautoz_buyercheckspamcalc');
         */
        return true;
    }

    function checkCaptchaUserForm() {
        if (!$this->performChecks())
            $return = 2;
        else
            $return = 1;
        return $return;
    }

}

?>
