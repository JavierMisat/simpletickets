<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
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
        jQuery("form#userpopupsearch").submit(function (e) {
            e.preventDefault();
            var username = jQuery("input#username").val();
            var name = jQuery("input#name").val();
            var emailaddress = jQuery("input#emailaddress").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, username: username, emailaddress: emailaddress, jstmod: 'staff', task: 'getusersearchajax'}, function (data) {
                if (data) {
                    d = json.parse(data);
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
<span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
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
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=staff');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Staff Member', 'js-support-ticket'); ?></span> </span>
<form method="post" action="<?php echo admin_url("admin.php?page=staff&task=savestaff"); ?>" enctype="multipart/form-data">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Username', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-value">
            <?php if (isset(jssupportticket::$_data[0]->uid)) { ?>
                <input type="text" value="<?php echo jssupportticket::$_data[0]->firstname . ' ' . jssupportticket::$_data[0]->lastname; ?>" id="username-text" readonly="readonly" data-validation="required"/><div id="username-div"></div>
                <?php } else {
                ?>
                <input type="text" value="" id="username-text" readonly="readonly" data-validation="required"/><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a><div id="username-div"></div>
                <?php
            }
            ?>              
        </div>
    </div>
    <div class="js-form-wrapper">   
        <div class="js-form-title"><?php echo __('Roles', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('roleid', JSSTincluder::getJSModel('role')->getRolesForCombobox(), isset(jssupportticket::$_data[0]->roleid) ? jssupportticket::$_data[0]->roleid : '', __('Select Role', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('First Name', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('firstname', isset(jssupportticket::$_data[0]->firstname) ? jssupportticket::$_data[0]->firstname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Last Name', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('lastname', isset(jssupportticket::$_data[0]->lastname) ? jssupportticket::$_data[0]->lastname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Email Address', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('email', isset(jssupportticket::$_data[0]->email) ? jssupportticket::$_data[0]->email : '', array('class' => 'inputbox', 'data-validation' => 'email')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Office Phone', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('phone', isset(jssupportticket::$_data[0]->phone) ? jssupportticket::$_data[0]->phone : '', array('class' => 'inputbox')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('extension', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('phoneext', isset(jssupportticket::$_data[0]->phoneext) ? jssupportticket::$_data[0]->phoneext : '', array('class' => 'inputbox')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Mobile No', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('mobile', isset(jssupportticket::$_data[0]->mobile) ? jssupportticket::$_data[0]->mobile : '', array('class' => 'inputbox')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Picture', 'js-support-ticket'); ?></div>
        <div class="js-form-field">
            <div class="tk_attachment_value_wrapperform">
                <span class="tk_attachment_value_text">
                    <input type="file" class="inputbox" name="filename" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                </span>
                <?php
                if (isset(jssupportticket::$_data[0]->photo) && !empty(jssupportticket::$_data[0]->photo)){
                    $maindir = wp_upload_dir();
                    $path = $maindir['baseurl'];                    
                    echo '<img class="jsticketstafflogo" src="' . $path . "/" . jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . jssupportticket::$_data[0]->id . "/" . jssupportticket::$_data[0]->photo . '" />';
                    
                }
                ?>
            </div>
        </div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('appendsignature', array('1' => __('Append', 'js-support-ticket')), isset(jssupportticket::$_data[0]->appendsignature) ? jssupportticket::$_data[0]->appendsignature : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Signature', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->signature) ? jssupportticket::$_data[0]->signature : '', 'signature', array('media_buttons' => false)); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Account Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Active', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('uid', isset(jssupportticket::$_data[0]->uid) ? jssupportticket::$_data[0]->uid : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
    <?php echo JSSTformfield::hidden('action', 'staff_savestaff'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Staff Member', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>
