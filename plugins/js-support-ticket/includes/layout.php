<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTlayout {

    static function getNoRecordFound() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/4.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Oooops', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('Record not found', 'js-support-ticket') . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getPermissionNotGranted() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/2.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Access Denied', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('You are not allowed to view this page', 'js-support-ticket') . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getNotStaffMember() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/2.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Access Denied', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('You are not staff member', 'js-support-ticket') . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getYouAreLoggedIn() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/2.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Opsss....', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('You are Already Logged in', 'js-support-ticket') . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getStaffMemberDisable() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/2.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Access Denied', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('Your account is disabled please contact to administrator', 'js-support-ticket') . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getSystemOffline() {
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/error/offline.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('Offline', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . jssupportticket::$_config['offline_message'] . '
						</span>
					</div>
				</div>
		';
        echo $html;
    }

    static function getUserGuest($redirect_url = '') {
    	if($redirect_url != ''){
    		$redirect_url = '&js_redirecturl='.$redirect_url;
    	}
        $html = '
				<div class="js_job_error_messages_wrapper">
					<div class="js_job_messages_image_wrapper">
						<img class="js_job_messages_image" src="' . jssupportticket::$_pluginpath . 'includes/images/notlogin.png"/>
					</div>
					<div class="js_job_messages_data_wrapper">
						<span class="js_job_messages_main_text">
					    	' . __('You are not logged in', 'js-support-ticket') . '
						</span>
						<span class="js_job_messages_block_text">
					    	' . __('To access this page please login', 'js-support-ticket') . '
						</span>
							<a class="button-not-login" href="'.site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=jssupportticket&jstlay=login'.$redirect_url).'" title="Login">' . __('Login', 'js-support-ticket') . '</a>
					</div>
				</div>
		';
        echo $html;
    }

}

?>