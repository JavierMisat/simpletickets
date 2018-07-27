<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

if (jssupportticket::$_config['offline'] == 2) {
    JSSTmessage::getMessage(); 
    JSSTbreadcrumbs::getBreadcrumbs(); 
    include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <div id="jsjobs-wrapper">
        <h1 class="js-ticket-heading"><?php echo __('Login', 'js-support-ticket') ?></h1>
        <div class="js-login-wrapper">
            <div  class="js-ourlogin">
<?php /*                <div class="login-heading"><?php echo __('Login into your account', 'js-support-ticket'); ?></div> */ ?>
                <?php
                $redirecturl = JSSTrequest::getVar('js_redirecturl','GET','');
                $redirecturl = base64_decode($redirecturl);
                if (!is_user_logged_in()) { // Display WordPress login form:
                    $args = array(
                        'redirect' => $redirecturl,
                        'form_id' => 'loginform-custom',
                        'label_username' => __('Username', 'js-support-ticket'),
                        'label_password' => __('Password', 'js-support-ticket'),
                        'label_remember' => __('keep me login', 'js-support-ticket'),
                        'label_log_in' => __('Login', 'js-support-ticket'),
                        'remember' => true
                    );
                    wp_login_form($args);
                }else{ // user not Staff
                    JSSTlayout::getYouAreLoggedIn();
                }
                ?>
            </div>
        </div>
    </div>
<?php 
} ?>