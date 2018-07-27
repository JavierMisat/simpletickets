<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            if (jssupportticket::$_data['staff_enabled']) {
                wp_enqueue_script('jquery-form', array('jquery'), false, true);
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        jQuery("a#userpopup").click(function (e) {
                            e.preventDefault();
                            jQuery("div#userpopup").slideDown('slow');
                        });
                        jQuery("span.close").click(function (e) {
                            jQuery("div#userpopup").slideUp('slow');
                        });
                        setUserLink();
                        function setUserLink() {
                            jQuery("a.js-userpopup-link").each(function () {
                                var anchor = jQuery(this);
                                jQuery(anchor).click(function (e) {
                                    var id = jQuery(this).attr('data-id');
                                    var name = jQuery(this).html();
                                    jQuery("div#username-div").html(name);
                                    jQuery("input#uid").val(id);
                                });
                            });
                        }
                        jQuery("form#userpopupsearch").submit(function (e) {
                            e.preventDefault();
                            var name = jQuery("input#name").val();
                            var emailaddress = jQuery("input#emailaddress").val();
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, emailaddress: emailaddress, jstmod: 'staff', task: 'getusersearchajax'}, function (data) {
                                if (data) {
                                    jQuery("div#records").html(data);
                                }
                            });//jquery closed
                        });
                        $('div.editable').each(function () {
                            var maindiv = $(this);
                            $(maindiv).mouseover(function () {
                                var datafor = $(maindiv).attr('data-for');
                                if (!($(maindiv).find('img#one').length > 0) && ($(maindiv).find('img#two').length <= 0)) {
                                    $(maindiv).append('<img id="one" style="height:17px;float:right;cursor:pointer;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" />');
                                    var img = $(maindiv).find('img');
                                    $(img).click(function (e) {
                                        var value = $(maindiv).find('span').html();
                                        var data = setEditOption(img, datafor, value);
                                        $(maindiv).html(data);
                                        $(maindiv).append('<img id="two" style="height:17px;float:right;cursor:pointer;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/save.png" />');
                                        var save = $(maindiv).find('img#two');
                                        $(save).click(function (e) {
                                            var value = $('#' + datafor).val();
                                            var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'staff', task: 'saveuserprofileajax', value: value, datafor: datafor}, function (data) {
                                                if (data == '1') {
                                                    $(maindiv).html('<span>'+value+'</span>');
                                                } else {
                                                    alert('<?php echo __("Some thing wrong try again later", "js-support-ticket"); ?>')
                                                }
                                            });
                                        });
                                    });
                                }
                            });
                            $(this).mouseout(function () {
                                if (!$(this).find('img#one').is(':hover')) {
                                    $(this).find('img#one').remove();
                                }
                            });
                        });
                        function setEditOption(img, datafor, value) {
                            switch (datafor) {
                                case 'firstname':
                                    data = '<input type="text" name="firstname" id="firstname" value="' + value + '"/>';
                                    break;
                                case 'lastname':
                                    data = '<input type="text" name="lastname" id="lastname" value="' + value + '"/>';
                                    break;
                                case 'phone':
                                    data = '<input type="text" name="phone" id="phone" value="' + value + '"/>';
                                    break;
                                case 'signature':
                                    data = '<textarea name="signature" id="signature">' + value + '</textarea>';
                                    break;
                            }
                            return data;
                        }
                        /*
                         var options = { 
                         beforeSend: function(){
                         jQuery("#progress").show();
                         //clear everything
                         jQuery("#bar").width('0%');
                         jQuery("#message").html("");
                         jQuery("#percent").html("0%");
                         },
                         uploadProgress: function(event, position, total, percentComplete){
                         jQuery("#bar").width(percentComplete+'%');
                         jQuery("#percent").html(percentComplete+'%');
                         
                         },
                         success: function() {
                         jQuery("#bar").width('100%');
                         jQuery("#percent").html('100%');
                         
                         },
                         complete: function(response){
                         alert(response.responseText);
                         var object = jQuery.parseJSON(response.responseText);
                         var defualtimageid = object.defaultimageid;
                         
                         if(object.resultcode == 1){
                         
                         
                         jQuery("#message").html("<font style='color:#fff'>"+object.msg+"</font>");
                         }else if(object.resultcode == 2){
                         jQuery("#message").html("<font style='color:#fff'>"+object.msg+"</font>");
                         }
                         },
                         error: function(){
                         jQuery("#message").html("<font style='color:#f6010d'> ERROR: unable to upload files</font>");
                         
                         }
                         };
                         jQuery("#jsst-myprofileimageform").ajaxForm(options);
                         */
                        var options = {
                            //target:        '#percent',      // target element(s) to be updated with server response 
                            beforeSubmit: showRequest, // pre-submit callback 
                            success: showResponse, // post-submit callback 
                            url: '<?php echo admin_url('admin-ajax.php'); ?>'                 // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php     
                        };

                        // bind form using 'ajaxForm' 
                        $('#jsst-myprofileimageform').ajaxForm(options);
                        $("img.profile-image").mouseover(function () {
                            $('div#showhidemouseover').show();
                        }).mouseout(function () {
                            if (!$('div#showhidemouseover').is(':hover')) {
                                //$('div#showhidemouseover').hide();
                            }
                            //$('div#showhidemouseover').hide();
                        });
                    });
                    function showRequest(formData, jqForm, options) {
                        //do extra stuff before submit like disable the submit button
                        //jQuery('#percent').html('Sending...');
                        jQuery('#upload_btn').attr("disabled", "true");
                    }
                    function showResponse(responseText, statusText, xhr, $form) {
                        //do extra stuff after submit
                        var object = jQuery.parseJSON(responseText);
                        if (object.errorcode == true) {
                            jQuery('img.profile-image').attr('src', object.imagepath);
                        }
                        jQuery('#upload_btn').removeAttr("disabled");
                        jQuery('div#showhidemouseover').hide();
                    }
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
                <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                <h1 class="js-ticket-heading"><?php echo __('My Profile', 'js-support-ticket') ?></h1>
                <form class="js-ticket-form" id="jsst-myprofileimageform" method="post" action="#" enctype="multipart/form-data">
                    <div class="js-col-md-2" style="padding-left:15px;padding-right:0px;">
                        <?php if (!empty(jssupportticket::$_data[0]->photo)) {
                            $datadirectory = jssupportticket::$_config['data_directory'];
                            $maindir = wp_upload_dir();
                            $path = $maindir['baseurl'];
                            $path = $path.'/'.$datadirectory.'/staffdata/staff_'.jssupportticket::$_data[0]->id.'/'. jssupportticket::$_data[0]->photo;
                         ?>
                            <img class="profile-image" src="<?php echo $path; ?>">
                        <?php } else { ?>
                            <img class="profile-image" src="<?php echo jssupportticket::$_pluginpath . "/includes/images/defaultprofile.png"; ?>">
                        <?php } ?>
                        <div id="showhidemouseover" style="display:none;">
                            <input type="hidden" name="jstmod" value="staff" />
                            <input type="hidden" name="task" value="uploadStaffImage" />
                            <input type="hidden" name="action" value="jsticket_ajax" />
                            <input type="file" name="filename" />
                            <input type="submit" id="upload_btn" value="UPLOAD">
                        </div>
                    </div>
                    <div class="js-col-md-10 js-nullpadding">
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Username', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox"><?php echo jssupportticket::$_data[0]->username; ?></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Role', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox"><?php echo jssupportticket::$_data[0]->rolename; ?></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('First Name', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox editable" data-for="firstname"><span><?php echo jssupportticket::$_data[0]->firstname; ?></span></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Last Name', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox editable" data-for="lastname"><span><?php echo jssupportticket::$_data[0]->lastname; ?></span></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Email Address', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox"><?php echo jssupportticket::$_data[0]->email; ?></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Office Phone', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox editable" data-for="phone"><span><?php echo jssupportticket::$_data[0]->phone; ?></span></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Signature', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox editable" data-for="signature"><span><?php echo jssupportticket::$_data[0]->signature; ?></span></div>
                        </div>
                        <div class="js-col-md-12">
                            <div class="js-col-md-3 js-float-right"><?php echo __('Account status', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-9 js-profile-rightbox"><?php echo (jssupportticket::$_data[0]->status == 1) ? __('Active', 'js-support-ticket') : __('Disabled', 'js-support-ticket'); ?></div>
                        </div>
                    </div>
                    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                    <?php echo JSSTformfield::hidden('uid', isset(jssupportticket::$_data[0]->uid) ? jssupportticket::$_data[0]->uid : '' ); ?>
                    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
                </form>
                <?php
            } else {
                JSSTlayout::getStaffMemberDisable();
            }
        } else { // user not Staff
            JSSTlayout::getNotStaffMember();
        }
    } else {
        $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=staff&jstlay=myprofile');
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>
