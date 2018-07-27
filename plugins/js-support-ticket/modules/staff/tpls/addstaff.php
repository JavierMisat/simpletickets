<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
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
                                    jQuery("div#username-div").html(name);
                                    jQuery("input#uid").val(id);
                                    if(jQuery('input#email').val() == ''){
                                        jQuery('input#email').val(email);
                                    }
                                    if(jQuery('input#firstname').val() == ''){
                                        jQuery('input#firstname').val(displayname);
                                    }
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
                            jQuery("span.close, div#userpopupblack").click(function (e) {
                                jQuery("div#userpopup").slideUp('slow', function () {
                                    jQuery("div#userpopupblack").hide();
                                });

                            });
                            jQuery("form#userpopupsearch").submit(function (e) {
                                e.preventDefault();
                                var username = jQuery("input#username").val();
                                var name = jQuery("input#name").val();
                                var emailaddress = jQuery("input#emailaddress").val();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, username: username, emailaddress: emailaddress, jstmod: 'staff', task: 'getusersearchajax'}, function (data) {
                                    if (data) {
                                        jQuery("div#records").html(data);
                                        setUserLink();
                                    }
                                });//jquery closed
                            });
                        });
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                        function uploadfile(fileobj, fileextensionallow) {
                            var file = fileobj.files[0];
                            var name = file.name;
                            var type = file.type;
                            var fileext = getExtension(name);
                            replace_txt = "<input type='file' class='inputbox' name='filename' onchange='uploadfile(this," + '"' + fileextensionallow + '"' + ");' size='20' maxlenght='30'/>";
                            var f_e_a = fileextensionallow.split(','); // file extension allow array
                            var isfileextensionallow = checkExtension(f_e_a, fileext);
                            if (isfileextensionallow == 'N') {
                                jQuery(fileobj).replaceWith(replace_txt);
                                alert(jQuery('span#fileext').html());
                                return false;
                            }
                            return true;
                        }
                        function  checkExtension(f_e_a, fileext) {
                            var match = 'N';
                            for (var i = 0; i < f_e_a.length; i++) {
                                if (f_e_a[i].toLowerCase() === fileext.toLowerCase()) {
                                    match = 'Y';
                                    return match;
                                }
                            }
                            return match;
                        }
                        function getExtension(filename) {
                            return filename.split('.').pop().toLowerCase();
                        }
                    </script>
                    <?php
                    $status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
                    );
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
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <h1 class="js-ticket-heading"><?php echo __('Add Staff', 'js-support-ticket') ?></h1>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&task=savestaff"); ?>">
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Username', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value">
                                <?php if (isset(jssupportticket::$_data[0]->uid)) { ?>
                                    <div id="username-div"><input type="text" value="<?php echo jssupportticket::$_data[0]->firstname . ' ' . jssupportticket::$_data[0]->lastname; ?>" id="username-text" readonly="readonly" data-validation="required"/></div>
                                    <?php } else {
                                    ?>
                                    <div id="username-div"><input type="text" value="" id="username-text" readonly="readonly" data-validation="required"/></div><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
                                    <?php
                                }
                                ?>              
                            </div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Roles', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font>&nbsp;<small><?php echo isset(jssupportticket::$_data[0]->id) ? __('', 'js-support-ticket') : ''; ?></small></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('roleid', JSSTincluder::getJSModel('role')->getRolesForCombobox(), isset(jssupportticket::$_data[0]->roleid) ? jssupportticket::$_data[0]->roleid : '', __('Select Role', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('First Name', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('firstname', isset(jssupportticket::$_data[0]->firstname) ? jssupportticket::$_data[0]->firstname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Last Name', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('lastname', isset(jssupportticket::$_data[0]->lastname) ? jssupportticket::$_data[0]->lastname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Email Address', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('email', isset(jssupportticket::$_data[0]->email) ? jssupportticket::$_data[0]->email : '', array('class' => 'inputbox', 'data-validation' => 'email')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Office Phone', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('phone', isset(jssupportticket::$_data[0]->phone) ? jssupportticket::$_data[0]->phone : '', array('class' => 'inputbox')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('extension', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('phoneext', isset(jssupportticket::$_data[0]->phoneext) ? jssupportticket::$_data[0]->phoneext : '', array('class' => 'inputbox')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Mobile No', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('mobile', isset(jssupportticket::$_data[0]->mobile) ? jssupportticket::$_data[0]->mobile : '', array('class' => 'inputbox')) ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Picture', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-field">
                                <div class="tk_attachment_value_wrapperform">
                                    <span class="tk_attachment_value_text">
                                        <input type="file" class="inputbox" name="filename" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                    </span>
                                    <?php
                                    //if(isset(jssupportticket::$_data[0]->photo) && !empty(jssupportticket::$_data[0]->photo))
                                    //echo '<img src="'.jssupportticket::$_pluginpath."/".jssupportticket::$_config['data_directory']."/staffdata/staff_".jssupportticket::$_data[0]->id."/".jssupportticket::$_data[0]->photo.'" />';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="js-col-md-12 js-form-wrapper">
                                <div class="js-col-md-12 js-form-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-form-value">
                                    <div class="js-form-value-signature">
                                        <?php echo JSSTformfield::checkbox('canappendsignature', array('1' => __('Append', 'js-support-ticket')), isset(jssupportticket::$_data[0]->appendsignature) ? jssupportticket::$_data[0]->appendsignature : '', array('class' => 'radiobutton')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Signature', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo wp_editor(isset(jssupportticket::$_data[0]->signature) ? jssupportticket::$_data[0]->signature : '', 'signature', array('media_buttons' => false)); ?></div>
                        </div>
                        <div class="js-col-md-4 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Account Status', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                        </div>
                        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                        <?php echo JSSTformfield::hidden('uid', isset(jssupportticket::$_data[0]->uid) ? jssupportticket::$_data[0]->uid : '' ); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                        <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
                        <?php echo JSSTformfield::hidden('action', 'staff_savestaff'); ?>
                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                        <div class="js-col-md-6 js-form-button">
                            <?php echo JSSTformfield::submitbutton('save', __('Save Staff Member', 'js-support-ticket'), array('class' => 'button')); ?>
                        </div>
                    </form>
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=staff&jstlay=addstaff');
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
