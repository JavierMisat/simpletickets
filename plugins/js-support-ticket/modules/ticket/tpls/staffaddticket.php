<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('jquery-ui-datepicker');
                    wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
                    wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <script type="text/javascript">
                        function updateuserlist(pagenum){
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'staff', task: 'getuserlistajax',userlimit:pagenum}, function (data) {
                                if(data){                    
                                    jQuery("div#records").html("");
                                    jQuery("div#records").html(data);
                                    setUserLink();
                                }
                            });
                        }
                        function setUserLink() {
                            jQuery("a.js-userpopup-link").each(function () {
                                var anchor = jQuery(this);
                                jQuery(anchor).click(function (e) {
                                    var id = jQuery(this).attr('data-id');
                                    var name = jQuery(this).html();
                                    var email = jQuery(this).attr('data-email');
                                    var displayname = jQuery(this).attr('data-name');
                                    jQuery("input#username-text").val(name);
                                    if(jQuery('input#name').val() == ''){
                                        jQuery('input#name').val(displayname);
                                    }
                                    if(jQuery('input#email').val() == ''){
                                        jQuery('input#email').val(email);
                                    }
                                    jQuery("input#uid").val(id);
                                    jQuery("div#userpopup").slideUp('slow', function () {
                                        jQuery("div#userpopupblack").hide();
                                    });
                                });
                            });
                        }
                        jQuery(document).ready(function () {
                            jQuery("a#userpopup").click(function (e) {
                                e.preventDefault();
                                jQuery("div#userpopupblack").show();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'staff', task: 'getuserlistajax'}, function (data) {
                                    if(data){     
                                        jQuery("div#records").html("");               
                                        jQuery("div#records").html(data);
                                        setUserLink();
                                    }
                                });
                                jQuery("div#userpopup").slideDown('slow');
                            });
                            jQuery("form#userpopupsearch").submit(function (e) {
                                e.preventDefault();
                                var username = jQuery("input#username").val();
                                var name = jQuery("input#name").val();
                                var emailaddress = jQuery("input#emailaddress").val();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name,username: username, emailaddress: emailaddress, jstmod: 'staff', task: 'getusersearchajax'}, function (data) {
                                    if (data) {
                                        jQuery("div#records").html(data);
                                        setUserLink();
                                    }
                                });//jquery closed
                            });
                            jQuery("span.close, div#userpopupblack").click(function (e) {
                                jQuery("div#userpopup").slideUp('slow', function () {
                                    jQuery("div#userpopupblack").hide();
                                });

                            });
                        });
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
                        function getpremade(val) {
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'premademessage', task: 'getpremadeajax'}, function (data) {
                                if (data) {
                                    var append = jQuery('input#append1:checked').length;
                                    if (append == 1) {
                                        var content = tinyMCE.get('message').getContent();
                                        content = content + data;
                                        tinyMCE.get('message').execCommand('mceSetContent', false, content);
                                    }
                                    else {
                                        tinyMCE.get('message').execCommand('mceSetContent', false, data);
                                    }
                                }
                            });//jquery closed
                        }
                        // to get premade and append to isssue summery
                        function getHelpTopicByDepartment(val) {
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'department', task: 'getHelpTopicByDepartment'}, function (data) {
                                if (data) {
                                    jQuery("div#helptopic").html(data);
                                }else{
                                    jQuery("div#helptopic").html( "<?php echo __('No help topic found','js-support-ticket'); ?>");
                                }
                            });//jquery closed
                        }
                        function getPremadeByDepartment(val) {
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'department', task: 'getPremadeByDepartment'}, function (data) {
                                if (data) {
                                    jQuery("span#premade").html(data);
                                }else{
                                    jQuery("span#premade").html( "<?php echo __('No premade found','js-support-ticket'); ?>");
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
                    <h1 class="js-ticket-heading"><?php echo __('Add Ticket', 'js-support-ticket') ?></h1>
                    <?php if (jssupportticket::$_config['new_ticket_message']) { ?>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-form-instruction-message">
                            <?php echo jssupportticket::$_config['new_ticket_message']; ?>
                        </div>
                        <?php }
                    ?>
                    <div id="userpopupblack" style="display:none;"></div>
                    <div id="userpopup" style="display:none;">
                        <div class="js-row">
                            <form id="userpopupsearch">
                                <div class="search-center">
                                    <div class="search-center-heading"><?php echo __('Select user','js-support-ticket'); ?><span class="close"></span></div>
                                    <div class="js-col-md-12">
                                        <div class="js-col-xs-12 js-col-md-3 js-search-value">
                                            <input type="text" name="username" id="username" placeholder="<?php echo __('Username','js-support-ticket'); ?>" />
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-3 js-search-value">
                                            <input type="text" name="name" id="name" placeholder="<?php echo __('Name','js-support-ticket'); ?>" />
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-3 js-search-value">
                                            <input type="text" name="emailaddress" id="emailaddress" placeholder="<?php echo __('Email Address','js-support-ticket'); ?>"/>
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-3 js-search-value-button">
                                            <div class="js-button">
                                                <input type="submit" value="<?php echo __('Search','js-support-ticket'); ?>" />
                                            </div>
                                            <div class="js-button">
                                                <input type="submit" onclick="document.getElementById('name').value = '';document.getElementById('username').value = ''; document.getElementById('emailaddress').value = '';" value="<?php echo __('Reset','js-support-ticket'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="records">
                            <div id="records-inner">
                                <div class="js-staff-searc-desc">
                                    <?php echo __('Use Search Feature To Select The User','js-support-ticket'); ?>
                                </div>
                            </div>    
                        </div>          
                    </div>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=saveticket"); ?>" id="adminTicketform" enctype="multipart/form-data">
                        <?php
                        $i = '';   // $j = 0;
                        $fieldcounter = 0;
                        ?>
                        <?php
                        foreach (jssupportticket::$_data['fieldordering'] AS $field):                            
                            switch ($field->field) {
                                case 'users':
                                    if($fieldcounter % 2 == 0){
                                        if($fieldcounter != 0){
                                            echo '</div>';
                                        }
                                        echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                                    }
                                    $fieldcounter++;
                                    ?>
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <?php if (isset(jssupportticket::$_data[0]->uid)) { ?>
                                                <div id="username-div"><input type="text" value="<?php if(isset($formdata['username-text'])) echo $formdata['username-text']; else echo jssupportticket::$_data[0]->user_login; ?>" id="username-text" readonly="readonly" <?php if($field->required == 1) echo 'data-validation="required"'; ?> /></div>
                                                <?php } else {
                                                ?>
                                                <div id="username-div"></div><input type="text" value="<?php if(isset($formdata['username-text'])) echo $formdata['username-text']; ?>" id="username-text" readonly="readonly" <?php if($field->required == 1) echo 'data-validation="required"'; ?> /><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
                                                <?php
                                            }
                                            ?>              
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 'email':
                                    if($fieldcounter % 2 == 0){
                                        if($fieldcounter != 0){
                                            echo '</div>';
                                        }
                                        echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                                    }
                                    $fieldcounter++;
                                    ?>
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <?php 
                                                if(isset($formdata['email'])) $email = $formdata['email'];
                                                elseif(isset(jssupportticket::$_data[0]->email)) $email = jssupportticket::$_data[0]->email;
                                                else $email = "";
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <?php 
                                                if(isset($formdata['phone'])) $phone = $formdata['phone'];
                                                elseif(isset(jssupportticket::$_data[0]->phone)) $phone = jssupportticket::$_data[0]->phone;
                                                else $phone = '';
                                                echo JSSTformfield::text('phone', $phone, array('class' => 'inputbox','data-validation' =>($field->required == 1) ? 'required': ''));
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <?php 
                                                if(isset($formdata['phoneext'])) $phoneext = $formdata['phoneext'];
                                                elseif(isset(jssupportticket::$_data[0]->phoneext)) $phoneext = jssupportticket::$_data[0]->phoneext;
                                                else $phoneext = '';
                                                echo JSSTformfield::text('phoneext', $phoneext, array('class' => 'inputbox'));
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <?php 
                                                if(isset($formdata['departmentid'])) $departmentid = $formdata['departmentid'];
                                                elseif(isset(jssupportticket::$_data[0]->departmentid)) $departmentid = jssupportticket::$_data[0]->departmentid;
                                                else $departmentid = JSSTincluder::getJSModel('department')->getDefaultDepartmentID();
                                                echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), $departmentid, __('Select Department', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getPremadeByDepartment(this.value);getHelpTopicByDepartment(this.value);', 'data-validation' => ($field->required == 1) ? 'required': ''));
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                        <div class="js-col-md-12 js-form-value" id="helptopic">
                                            <?php 
                                                if(isset($formdata['helptopicid'])) $helptopicid = $formdata['helptopicid'];
                                                elseif(isset(jssupportticket::$_data[0]->helptopicid)) $helptopicid = jssupportticket::$_data[0]->helptopicid;
                                                else $helptopicid = '';
                                                echo JSSTformfield::select('helptopicid', JSSTincluder::getJSModel('helptopic')->getHelpTopicsForCombobox(), $helptopicid, __('Select Help Topic', 'js-support-ticket'), array('class' => 'inputbox','data-validation' => ($field->required == 1) ? 'required' : ''));
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
                                    <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
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
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
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
                                case 'premade':
                                    if($fieldcounter != 0){
                                        echo '</div>';
                                        $fieldcounter = 0;
                                    }
                                    ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?></div>
                                        <div class="js-col-md-12 js-form-value">
                                            <span id="premade"><?php echo JSSTformfield::select('premadeid', JSSTincluder::getJSModel('premademessage')->getPreMadeMessageForCombobox(), isset(jssupportticket::$_data[0]->premadeid) ? jssupportticket::$_data[0]->premadeid : '', __('Select Premade', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getpremade(this.value)')); ?></span>
                                            <?php echo JSSTformfield::checkbox('append', array('1' => __('Append', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
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
                                                if(isset($formdata['message'])) $message = $formdata['message'];
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
                                            <span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File', 'js-support-ticket'); ?></span>
                                            <span class="tk_attachments_configform">
                                                <small>
                                                    <?php
                                                    echo __('Maximum File Size', 'js-support-ticket');
                                                    echo ' (' . jssupportticket::$_config['file_maximum_size'];
                                                    ?>KB)
                                                    <br><?php echo __('File Extension Type', 'js-support-ticket');
                                echo ' (' . jssupportticket::$_config['file_extension'] . ')';
                                                    ?>
                                                </small>
                                            </span>
                                            <?php /*
                                            if (!empty(jssupportticket::$_data[5])) {
                                                foreach (jssupportticket::$_data[5] AS $attachment) {
                                                    $id = isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ;
                                                    echo '
                                                                <div class="js_ticketattachment">
                                                                        ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                                                                        <a href="?page=attachment&task=deleteattachment&action=jstask&id=' . $attachment->id . '&ticketid=' . $id . '">' . __('Delete Attachment') . '</a>
                                                                </div>';
                                                } 
                                            } */
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 'internalnotetitle':
                                    if (JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Post Internal Note')) {
                                        if($fieldcounter != 0){
                                            echo '</div>';
                                            $fieldcounter = 0;
                                        }
                                        ?>
                                        <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                            <div class="js-col-md-12 js-form-field">
                                                <?php 
                                                    if(isset($formdata['internalnotetitle'])) $internalnotetitle = $formdata['internalnotetitle'];
                                                    else $internalnotetitle = '';
                                                    echo JSSTformfield::text('internalnotetitle', $internalnotetitle, array('class' => 'inputbox fullwidth','data-validation'=>($field->required == 1) ? 'required': ''));
                                                ?>
                                            </div>
                                        </div>
                                        <?php if (isset(jssupportticket::$_data[0]->id)) { ?>
                                            <div class="js-col-md-12 js-form-title" style = "margin-left:160px;"><?php echo __('Reason for edit', 'js-support-ticket'); ?><br></div>
                                    <?php } ?>
                                        <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                            <div class="js-col-md-12 js-form-title"><?php echo __('Internal Note', 'js-support-ticket'); ?></div>
                                            <div class="js-col-md-12 js-form-field">
                                                <?php 
                                                    if(isset($formdata['internalnote'])) $internalnote = $formdata['internalnote'];
                                                    elseif(isset(jssupportticket::$_data[0]->internalnote)) $internalnote = jssupportticket::$_data[0]->internalnote;
                                                    else $internalnote = '';
                                                    echo wp_editor($internalnote, 'internalnote', array('media_buttons' => false));
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case 'duedate':
                                    ?>
                                <?php if (JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Duedate Ticket')) { 
                                        if($fieldcounter % 2 == 0){
                                            if($fieldcounter != 0){
                                                echo '</div>';
                                            }
                                            echo '<div class="js-col-md-12 js-form-wrapper nopadd">';
                                        }
                                        $fieldcounter++;
                                    ?>
                                        <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                                            <div class="js-col-md-12 js-form-title"><?php echo __($field->fieldtitle, 'js-support-ticket'); ?><?php if($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></div>
                                            <div class="js-col-md-12 js-form-field">
                                                <?php 
                                                    if(isset($formdata['duedate'])) $duedate = $formdata['duedate'];
                                                    elseif(isset(jssupportticket::$_data[0]->duedate)) $duedate = jssupportticket::$_data[0]->duedate;
                                                    else $duedate = '';
                                                    echo JSSTformfield::text('duedate', $duedate, array('class' => 'custom_date','data-validation' => ($field->required == 1) ? 'required' : ''));
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    break;
                                default:
                                    echo JSSTincluder::getObjectClass('customfields')->formCustomFields($field);
                                    break;
                            }
                        endforeach;
                        ?>
                        <div class="js-col-xs-12 js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Assign to me', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value js-assingtome-chkbox">
                                <?php 
                                if(isset(jssupportticket::$_data[0]->id)) $staffid = jssupportticket::$_data[0]->staffid;
                                if(isset($staffid)){
                                    if($staffid == 0)
                                        $checked = '';
                                    else{
                                        $staffid_current = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());
                                        if($staffid_current == $staffid){
                                            $checked = 1;
                                        }else{
                                            $checked = '';
                                        }
                                    }
                                }else{
                                    $checked = 1;
                                }

                                echo JSSTformfield::checkbox('assigntome', array('1' => __('Assign to me', 'js-support-ticket')), $checked, array('class' => 'radiobutton')); ?>
                            </div>
                        </div>
                        <?php
                        if($fieldcounter != 0){
                            echo '</div>'; // close extra div open in user field
                        }
                        echo '<input type="hidden" id="userfeilds_total" name="userfeilds_total"  value="' . $i . '"  />';
                        ?>
                        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
                        <?php echo JSSTformfield::hidden('attachmentdir', isset(jssupportticket::$_data[0]->attachmentdir) ? jssupportticket::$_data[0]->attachmentdir : ''); ?>
                        <?php echo JSSTformfield::hidden('ticketid', isset(jssupportticket::$_data[0]->ticketid) ? jssupportticket::$_data[0]->ticketid : ''); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                        <?php echo JSSTformfield::hidden('uid', isset(jssupportticket::$_data[0]->uid) ? jssupportticket::$_data[0]->uid : get_current_user_id()); ?>
                        <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
                        <?php echo JSSTformfield::hidden('action', 'ticket_saveticket'); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>

                        <div class="js-form-button">
                    <?php echo JSSTformfield::submitbutton('save', __('Create Ticket', 'js-support-ticket'), array('class' => 'button')); ?>
                        </div>
                    </form>
                    <?php
                }else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else { // User Guest
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=staffaddticket');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
