<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0 || jssupportticket::$_config['visitor_can_create_ticket'] == 1) {
        JSSTmessage::getMessage();
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
        wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.custom_date').datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                jQuery("#tk_attachment_add").click(function () {
                    var obj = this;
                    var current_files = jQuery('input[name="filename[]"]').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20' maxlenght='30'  /><span  class='tk_attachment_remove'></span></span>";
                    if (current_files < total_allow) {
                        jQuery(".tk_attachment_value_wrapperform").append(append_text);
                    } else if ((current_files === total_allow) || (current_files > total_allow)) {
                        alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                        jQuery(obj).hide();
                    }
                });
                jQuery(document).delegate(".tk_attachment_remove", "click", function (e) {
                    jQuery(this).parent().remove();
                    var current_files = jQuery('input[name="filename[]"]').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    if (current_files < total_allow) {
                        jQuery("#tk_attachment_add").show();
                    }
                });
                $.validate();
            });
            // to get premade and append to isssue summery
            function getHelpTopicByDepartment(val) {
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'department', task: 'getHelpTopicByDepartment'}, function (data) {
                    if (data != false) {
                        jQuery("div#helptopic").html(data);
                    }else{
                        jQuery("div#helptopic").html( "<?php echo __('No help topic found','js-support-ticket'); ?>");
                    }
                });//jquery closed
            }
        </script>
        <span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
        <span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
        <?php
        $loginuser_name = '';
        $loginuser_email = '';
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $loginuser_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
            if(str_replace(' ', '', $loginuser_name) == ''){
                $loginuser_name = $current_user->user_nicename;
            }
            $loginuser_email = $current_user->user_email;
        }
        ?>
        <?php JSSTmessage::getMessage(); ?>
        <?php $formdata = JSSTformfield::getFormData(); ?>
        <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
        <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
        <?php if (jssupportticket::$_config['new_ticket_message']) { ?>
            <div class="js-col-xs-12 js-col-md-12 js-ticket-form-instruction-message">
                <?php echo jssupportticket::$_config['new_ticket_message']; ?>
            </div>
            <?php }
        ?>
        <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=saveticket"); ?>" id="adminTicketform" enctype="multipart/form-data">
            <?php
            $i = '';
            $fieldcounter = 0;
            foreach (jssupportticket::$_data['fieldordering'] AS $field):
                switch ($field->field) {
                    case 'email':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>                        
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['email'])) $email = $formdata['email'];
                                    elseif(isset(jssupportticket::$_data[0]->email)) $email = jssupportticket::$_data[0]->email;
                                    else $email = $loginuser_email;
                                    echo JSSTformfield::text('email', $email, array('class' => 'inputbox', 'data-validation' => 'email'));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'fullname':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['name'])) $name = $formdata['name'];
                                    elseif(isset(jssupportticket::$_data[0]->name)) $name = jssupportticket::$_data[0]->name;
                                    else $name = $loginuser_name;
                                    echo JSSTformfield::text('name', $name, array('class' => 'inputbox', 'data-validation' => 'required'));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'phone':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['phone'])) $phone = $formdata['phone'];
                                    elseif(isset(jssupportticket::$_data[0]->phone)) $phone = jssupportticket::$_data[0]->phone;
                                    else $phone = '';
                                    echo JSSTformfield::text('phone', $phone, array('class' => 'inputbox','data-validation'=>($field->required) ? 'required': ''));
                                ?>
                            </div>
                        </div>
                        <?php 
                        break;
                    case 'phoneext':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['phoneext'])) $phoneext = $formdata['phoneext'];
                                    elseif(isset(jssupportticket::$_data[0]->phoneext)) $phoneext = jssupportticket::$_data[0]->phoneext;
                                    else $phoneext = '';
                                    echo JSSTformfield::text('phoneext', $phoneext, array('class' => 'inputbox','data-validation'));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'department':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['departmentid'])) $departmentid = $formdata['departmentid'];
                                    elseif(isset(jssupportticket::$_data[0]->departmentid)) $departmetnid = jssupportticket::$_data[0]->departmentid;
                                    else $departmentid = JSSTincluder::getJSModel('department')->getDefaultDepartmentID();
                                    echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), $departmentid, __('Select Department', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getHelpTopicByDepartment(this.value);', 'data-validation' => ($field->required) ? 'required' : ''));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'helptopic':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                            <div class="js-col-md-12 js-form-value" id="helptopic">
                                <?php 
                                    if(isset($formdata['helptopicid'])) $helptopicid = $formdata['helptopicid'];
                                    elseif(isset(jssupportticket::$_data[0]->helptopicid)) $helptopicid = jssupportticket::$_data[0]->helptopicid;
                                    else $helptopicid = '';
                                    echo JSSTformfield::select('helptopicid', JSSTincluder::getJSModel('helptopic')->getHelpTopicsForCombobox(), $helptopicid, __('Select Help Topic', 'js-support-ticket'), array('class' => 'inputbox','data-validation',($field->required) ? 'required' : ''));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'priority':
                        if($fieldcounter % 2 == 0){
                            if($fieldcounter != 0){
                                echo '</div>';
                            }
                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                        }
                        $fieldcounter++;
                        ?>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['priorityid'])) $priorityid = $formdata['priorityid'];
                                    elseif(isset(jssupportticket::$_data[0]->priorityid)) $priorityid = jssupportticket::$_data[0]->priorityid;
                                    else $priorityid = JSSTincluder::getJSModel('priority')->getDefaultPriorityID();
                                    echo JSSTformfield::select('priorityid', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), $priorityid, __('Select Priority', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required'));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'subject':
                        if($fieldcounter != 0){
                            echo '</div>';
                            $fieldcounter = 0;
                        }
                        ?>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php 
                                    if(isset($formdata['subject'])) $subject = $formdata['subject'];
                                    elseif(isset(jssupportticket::$_data[0]->subject)) $subject = jssupportticket::$_data[0]->subject;
                                    else $subject = '';
                                    echo JSSTformfield::text('subject', $subject, array('class' => 'inputbox', 'data-validation' => 'required'));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'issuesummary':
                        if($fieldcounter != 0){
                            echo '</div>';
                            $fieldcounter = 0;
                        }
                        ?>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12">
                                <?php 
                                    if(isset($formdata['message'])) $message = wpautop(wptexturize(stripslashes($formdata['message'])));
                                    elseif(isset(jssupportticket::$_data[0]->message)) $message = jssupportticket::$_data[0]->message;
                                    else $message = '';
                                    echo wp_editor($message, 'jsticket_message', array('media_buttons' => false));
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'attachments':
                        if($fieldcounter != 0){
                            echo '</div>';
                            $fieldcounter = 0;
                        }
                        ?>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                            <div class="js-col-md-12 js-form-value">
                                <div class="tk_attachment_value_wrapperform">
                                    <span class="tk_attachment_value_text">
                                        <input type="file" class="inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30' data-validation="<?php echo ($field->required == 1) ? 'required' : ''; ?>" />
                                        <span class='tk_attachment_remove'></span>
                                    </span>
                                </div>
                                <span class="tk_attachments_configform">
                                    <small><?php echo __('Maximum File Size', 'js-support-ticket');
                    echo ' (' . jssupportticket::$_config['file_maximum_size'];
                    ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                    echo ' (' . jssupportticket::$_config['file_extension'] . ')';
                        ?></small>
                                </span>
                                <span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File', 'js-support-ticket'); ?></span>
                                <?php
                                /*
                                if (!empty(jssupportticket::$_data[5])) {
                                    foreach (jssupportticket::$_data[5] AS $attachment) {
                                        echo '
                                            <div class="js_ticketattachment">
                                                    ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                                                    <a href="?page=attachment&task=deleteattachment&action=jstask&id=' . $attachment->id . '&ticketid=' . isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' . '">' . __('Delete attachment','js-support-ticket') . '</a>
                                            </div>';
                                    }
                                }
                                */
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    default:
                        echo JSSTincluder::getObjectClass('customfields')->formCustomFields($field);
                        break;
                }
            endforeach;
            if($fieldcounter != 0){
                echo '</div>'; // close extra div open in user field
            }
            echo '<input type="hidden" id="userfeilds_total" name="userfeilds_total"  value="' . $i . '"  />';
            ?>
            <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
            <?php echo JSSTformfield::hidden('attachmentdir', isset(jssupportticket::$_data[0]->attachmentdir) ? jssupportticket::$_data[0]->attachmentdir : ''); ?>
            <?php echo JSSTformfield::hidden('ticketid', isset(jssupportticket::$_data[0]->ticketid) ? jssupportticket::$_data[0]->ticketid : ''); ?>
            <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
            <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
            <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
            <?php
            // captcha
            if (!is_user_logged_in()) {
                if (jssupportticket::$_config['show_captcha_on_visitor_from_ticket'] == 1) {
                    ?>
                    <div class="js-col-md-12 js-form-wrapper">
                        <div class="js-col-md-12 js-user-captcha-title"><?php echo __('Captcha', 'js-support-ticket'); ?></div>
                        <div class="js-user-captcha-padding">
                            <div class="js-col-md-12 js-user-captcha-value">

                                <?php
                                if (jssupportticket::$_config['captcha_selection'] == 1) { // Google recaptcha
                                    $error = null;
                                    echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
                                    echo '<div class="g-recaptcha" data-sitekey="'.jssupportticket::$_config['recaptcha_publickey'].'"></div>';
                                } else { // own captcha
                                    $captcha = new JSSTcaptcha;
                                    echo $captcha->getCaptchaForForm();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Create Ticket', 'js-support-ticket'), array('class' => 'button')); ?>
            </div>
        </form>
        <?php
    } else {// User is guest
        $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=addticket');
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
