<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0 || jssupportticket::$_config['visitor_can_create_ticket'] == 1) {
        JSSTmessage::getMessage();
        wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery.cluetip.min.js', jssupportticket::$_pluginpath . 'includes/js/jquery.cluetip.min.js');
        wp_enqueue_script('jquery.hoverIntent.js', jssupportticket::$_pluginpath . 'includes/js/jquery.hoverIntent.js');
        wp_enqueue_style('jquery.cluetip', jssupportticket::$_pluginpath . 'includes/css/jquery.cluetip.css');
        $printflag = false;
        if(isset(jssupportticket::$_data['print']) && jssupportticket::$_data['print'] == 1){
            $printflag = true;
        }
        if($printflag == true){
            wp_head();
        }
        ?>
        <script type="text/javascript">
            function getpremade(val) {
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'premademessage', task: 'getpremadeajax'}, function (data) {
                    if (data) {
                        var append = jQuery('input#append_premade1:checked').length;
                        if (append == 1) {
                            var content = tinyMCE.get('jsticket_message').getContent();
                            content = content + data;
                            tinyMCE.get('jsticket_message').execCommand('mceSetContent', false, content);
                        } else {
                            tinyMCE.get('jsticket_message').execCommand('mceSetContent', false, data);
                        }

                    }
                });
            }
            jQuery(document).ready(function ($) {
                //$('img.tooltip').cluetip({splitTitle: '|'});
                jQuery("#tabs").tabs();
                jQuery("#tk_attachment_add").click(function () {
                    var obj = this;
                    var current_files = jQuery('input[type="file"]').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20' maxlenght='30'  /><span  class='tk_attachment_remove'></span></span>";
                    if (current_files < total_allow) {
                        jQuery(".tk_attachment_value_wrapperform").append(append_text);
                    } else if ((current_files === total_allow) || (current_files > total_allow)) {
                        alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                        obj.hide();
                    }
                });
                jQuery(document).delegate(".tk_attachment_remove", "click", function (e) {
                    jQuery(this).parent().remove();
                    var current_files = jQuery('input[type="file"]').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    if (current_files < total_allow) {
                        jQuery("#tk_attachment_add").show();
                    }
                });
                jQuery("a#showhidedetail").click(function (e) {
                    e.preventDefault();
                    var divid = jQuery(this).attr('data-divid');
                    jQuery("div#" + divid).slideToggle();
                    jQuery(this).find('img').toggleClass('js-hidedetail');
                });
                jQuery("a#showaction").click(function (e) {
                    e.preventDefault();
                    jQuery("div#action-div").slideToggle();
                });
                jQuery("a#showhistory").click(function (e) {
                    e.preventDefault();
                    jQuery("div#userpopup").slideDown('slow');
                    jQuery('div#userpopupblack').show();
                });
                jQuery("div#userpopupblack,span.close-history").click(function (e) {
                    jQuery("div#userpopup").slideUp('slow');
                    setTimeout(function () {
                        jQuery('div#userpopupblack').hide();
                    }, 700);
                });
                //print code
                jQuery('a#print-link').click(function (e) {
                    e.preventDefault();
                    var ticketid = jQuery(this).attr('data-ticketid');
                    var href = '<?php echo site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=printticket'); ?>';
                    href += '&jssupportticketid=' + ticketid;
                    print = window.open(href, 'print_win', 'width=1024, height=800, scrollbars=yes');
                });
            });
            function actionticket(action) {
                /*  Action meaning
                 * 1 -> Change Priority
                 * 2 -> Close Ticket
                 * 2 -> Reopen Ticket
                 */
                jQuery("input#actionid").val(action);
                jQuery("form#adminTicketform").submit();
            }
            function checktinymcebyid(id) {
                var content = tinymce.get(id).getContent({format: 'text'});
                if (jQuery.trim(content) == '')
                {
                    alert('<?php echo __('Some values are not acceptable please retry', 'js-support-ticket'); ?>');
                    return false;
                }
                return true;
            }
        </script>
        <div id="userpopupblack" style="display:none;"> </div>
        <div id="userpopup" style="display:none;">
            <div class="js-row">
                <form id="userpopupsearch">
                    <div class="search-center-history"><?php echo __('Ticket History', 'js-support-ticket'); ?><span class="close-history"></span></div>
                </form>
            </div>
            <div id="records">
                <?php // data[5] holds the tickect history
                if ((!empty(jssupportticket::$_data[5]))) {
                    $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
                    ?>
                            <?php foreach (jssupportticket::$_data[5] AS $history) { ?>
                        <div class="js-col-xs-12 js-col-md-12 js-popup-row-wrapper">
                            <span class="js-col-xs-4 js-col-md-2">
                                <?php echo date_i18n('Y-m-d', strtotime($history->datetime)); ?>
                            </span>
                            <span class="js-col-xs-4 js-col-md-2 no-border-xs">
                            <?php echo date_i18n('H:i:s', strtotime($history->datetime)); ?>
                            </span>
                            <?php
                            if (is_super_admin($history->uid)) {
                                $message = 'admin';
                            } elseif (JSSTincluder::getJSModel('staff')->isUserStaff($history->uid)) {
                                $message = 'staff';
                            } else {
                                $message = 'member';
                            }
                            ?>
                            <span class="js-col-xs-12 js-col-md-8 no-border <?php echo $message; ?>">
                <?php echo $history->message; ?>
                            </span>
                        </div>

            <?php } ?>
        <?php } ?>
            </div>      
        </div>
        <span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
        <span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
        <?php
            if($printflag == false){
                JSSTbreadcrumbs::getBreadcrumbs(); 
                include_once(jssupportticket::$_path . 'includes/header.php'); 
            } ?>
        <?php
        if (jssupportticket::$_data['permission_granted'] == true) {
            jssupportticket::$_data['custom']['ticketid'] = jssupportticket::$_data[0]->id;
            if (!empty(jssupportticket::$_data[0])) {
                if (jssupportticket::$_data[0]->lock == 1) {
                    $style = "darkred;";
                    $status = __('Lock', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 0) {
                    $style = "red;";
                    $status = __('New', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 1) {
                    $style = "orange;";
                    $status = __('Waiting reply', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 2) {
                    $style = "#FF7F50;";
                    $status = __('In Progress', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 3) {
                    $style = "green;";
                    $status = __('Replied', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 4) {
                    $style = "blue;";
                    $status = __('Closed', 'js-support-ticket');
                }

                $cur_uid = get_current_user_id();
                if (jssupportticket::$_data['user_staff']) {
                    $link = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=actionticket");
                } else {
                    $link = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=reply&task=savereply");
                }
                ?>	

                <h1 class="js-ticket-heading"><?php echo __('Ticket Details', 'js-support-ticket') ?></h1>
                <form method="post" action="<?php echo $link; ?>" id="adminTicketform" enctype="multipart/form-data">
                    <div class="js-col-md-12 js-ticket-detail-wrapper">
                        <div class="js-row js-ticket-topbar">
                            <div class="js-col-md-5 js-openclosed">
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-openclosed">
                                    <?php
                                    if (jssupportticket::$_data[0]->status == 4)
                                        $ticketmessage = __('Closed', 'js-support-ticket');
                                    elseif (jssupportticket::$_data[0]->status == 2)
                                        $ticketmessage = __('In Progress', 'js-support-ticket');
                                    else
                                        $ticketmessage = __('Open', 'js-support-ticket');
                                    echo $ticketmessage;
                                    ?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-7 js-ticket-detail-wrapper-padding-xs">
                                    <?php
                                    echo __('Created', 'js-support-ticket') . ' ';
                                    $startTimeStamp = strtotime(jssupportticket::$_data[0]->created);
                                    $endTimeStamp = strtotime("now");
                                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                    $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
                                    // and you might want to convert to integer
                                    $numberDays = intval($numberDays);
                                    if ($numberDays != 0 && $numberDays == 1) {
                                        $day_text = __('Day', 'js-support-ticket');
                                    } elseif ($numberDays > 1) {
                                        $day_text = __('Days', 'js-support-ticket');
                                    } elseif ($numberDays == 0) {
                                        $day_text = __('Today', 'js-support-ticket');
                                    }
                                    if ($numberDays == 0) {
                                        echo $day_text;
                                    } else {
                                        echo $numberDays . ' ' . $day_text . ' ';
                                        echo __('Ago', 'js-support-ticket');
                                    }
                                    echo ' ' . date_i18n("d F, Y, h:i:s A", strtotime(jssupportticket::$_data[0]->created));
                                    ?>
                                </div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-4 js-mid-ticketdetail-part">
                                <div class="js-row js-margin-bottom">
                                    <div class="js-col-xs-5 js-col-md-6 js-ticket-title"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-6 js-col-md-5 js-ticket-value js-border-box"><?php echo jssupportticket::$_data[0]->ticketid; ?></div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-5 js-col-md-6 js-ticket-title"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-6 js-col-md-5 js-ticket-value js-ticket-wrapper-textcolor" style="background:<?php echo jssupportticket::$_data[0]->prioritycolour; ?>;"><?php echo __(jssupportticket::$_data[0]->priority, 'js-support-ticket'); ?></div>
                                </div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-3 js-last-left">
                                <div class="js-row">
                                    <div class="js-col-xs-5 js-col-md-6 js-ticket-title"><?php echo __('Last Reply', 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-6 js-col-md-5 js-ticket-value"><?php if (empty(jssupportticket::$_data[0]->lastreply) || jssupportticket::$_data[0]->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket');
                                    else echo date_i18n(jssupportticket::$_config['date_format'], strtotime(jssupportticket::$_data[0]->lastreply)); ?></div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-5 js-col-md-6 js-ticket-title"><?php echo __($field_array['status'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-6 js-col-md-5 js-ticket-value">
                                        <?php
                                        $printstatus = 1;
                                        if (jssupportticket::$_data[0]->lock == 1) {
                                            echo '<div><img src="' . jssupportticket::$_pluginpath . 'includes/images/lockstatus.png"/>' . __('Lock', 'js-support-ticket') . '</div>';
                                            $printstatus = 0;
                                        }
                                        if (jssupportticket::$_data[0]->isoverdue == 1) {
                                            echo '<div><img src="' . jssupportticket::$_pluginpath . 'includes/images/mark_over_due.png"/>' . __('Overdue', 'js-support-ticket') . '</div>';
                                            $printstatus = 0;
                                        }
                                        if ($printstatus == 1) {
                                            echo $ticketmessage;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-row js-ticket-middlebar">
                            <div class="js-col-xs-12 js-col-md-9 js-nullpadding js-ticket-detail-wrapper-padding-xs js-ticket-detail-wrapper-xs-lineheight">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-detail-wrapper-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-title textstylebold"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value js-subject-ticketdetail"><?php echo jssupportticket::$_data[0]->subject; ?></span>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-detail-wrapper-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-title textstylebold"><?php echo __($field_array['department'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value"><?php echo __(jssupportticket::$_data[0]->departmentname ,'js-support-ticket'); ?></span>
                                </div>
                                <?php
                                    $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1);
                                    foreach ($customfields as $field) {
                                        echo JSSTincluder::getObjectClass('customfields')->showCustomFields($field,2, jssupportticket::$_data[0]->params);
                                    }
                                ?>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-detail-wrapper-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-value"><?php echo (jssupportticket::$_data[0]->ticketviaemail == 1) ? __('Created via Email', 'js-support-ticket') : ''; ?></span>
                                </div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-3 js-button-margin">
                                <?php if($printflag == false){ ?>
                                    <?php if (jssupportticket::$_data['user_staff']) { 
                                            $printpermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Print Ticket');
                                        ?>
                                        <a class="button" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=staffaddticket&jssupportticketid=" . jssupportticket::$_data[0]->id); ?>" alt="<?php echo __('Edit Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" title="<?php echo __('Edit Ticket', 'js-support-ticket'); ?>" /></a>
                                        <?php if (jssupportticket::$_data[0]->status != 4) { ?>
                                            <a class="button" href="#" onclick="actionticket(2);" alt="<?php echo __('Close Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/close.png" title="<?php echo __('Close Ticket', 'js-support-ticket'); ?>" /></a>
                                        <?php } else { ?>
                                            <a class="button" href="#" onclick="actionticket(3);" alt="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/reopen.png" title="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>" /></a>
                                        <?php } ?>
                                        <a class="button" href="#" id="showaction"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/down.png" title="<?php echo __('More Option', 'js-support-ticket'); ?>" /></a>
                                        <a class="button" href="#" id="showhistory"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tickethistory.png" title="<?php echo __('Ticket History', 'js-support-ticket'); ?>" /></a>
                                        <?php if($printpermission) { ?>
                                            <a class="button" href="#" id="print-link" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /></a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if (jssupportticket::$_data[0]->status != 4) { ?>
                                            <a style="height:36px" onclick="return confirm('<?php echo __('Are you sure to close ticket', 'js-support-ticket'); ?>');" class="button" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=closeticket&action=jstask&ticketid=" . jssupportticket::$_data[0]->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" title="<?php echo __('Delete ticket', 'js-support-ticket'); ?>" /><?php echo __('Close Ticket', 'js-support-ticket'); ?></a>
                                            &nbsp;
                                            <a class="button" href="#" id="showhistory"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tickethistory.png" title="<?php echo __('Ticket History', 'js-support-ticket'); ?>" /></a>
                                        <?php
                                        } else {
                                            if (JSSTincluder::getJSModel('ticket')->checkCanReopenTicket(jssupportticket::$_data[0]->id)) {
                                                $link = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&action=jstask&task=reopenticket&ticketid=" . jssupportticket::$_data[0]->id);
                                                ?>
                                                <a class="button" href="<?php echo $link; ?>" alt="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/reopen.png" title="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>" /></a>

                                    <?php  }
                                        } ?>
                                        <?php if(jssupportticket::$_config['print_ticket_user'] == 1){ ?>
                                            <a class="button" href="#" id="print-link" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /></a>
                                        <?php } ?>
                            <?php   } ?>
                            <?php    }else{ ?>
                                        <a class="button" href="javascript:window.print();"><?php echo __('Print', 'js-support-ticket'); ?></a>
                            </div>
                            <?php  } ?>
                                    

                        </div>
                            <?php if (jssupportticket::$_data['user_staff']) { ?>
                            <div class="js-col-xs-12 js-col-md-12" id="action-div" style="display:none;">
                                <?php if (jssupportticket::$_data[0]->lock == 1) { ?>
                                    <a class="button" href="#" onclick="actionticket(5);" alt="<?php echo __('Unlock Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/unlockticket.png" title="<?php echo __('Unlock Ticket', 'js-support-ticket'); ?>" /></a>
                                <?php } else { ?>
                                    <a class="button" href="#" onclick="actionticket(4);" alt="<?php echo __('Lock Ticket', 'js-support-ticket'); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/lockticket.png" title="<?php echo __('Lock Ticket', 'js-support-ticket'); ?>" /></a>
                                <?php } ?>
                    <?php if (JSSTincluder::getJSModel('banemail')->isEmailBan(jssupportticket::$_data[0]->email)) { ?>
                                    <a class="button" href="#" onclick="actionticket(7);"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/unbanemail.png" title="<?php echo __('Unban Email', 'js-support-ticket'); ?>" /></a>
                    <?php } else { ?>
                                    <a class="button" href="#" onclick="actionticket(6);"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/banemail.png" title="<?php echo __('Ban Email', 'js-support-ticket'); ?>" /></a>
                    <?php } ?>
                                <a class="button" href="#" onclick="actionticket(8);"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/markoverdue.png'; ?>" title="<?php echo __('Mark Overdue', 'js-support-ticket'); ?>" /></a>
                                <a class="button" href="#" onclick="actionticket(9);"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/markinprogress.png'; ?>" title="<?php echo __('Mark in Progress', 'js-support-ticket'); ?>" /></a>
                                <a class="button" href="#" onclick="actionticket(10);"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/banemailandcloseticket.png'; ?>" title="<?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?>" /></a>
                                <div class="js-row">
                                    <div class="js-col-md-6"><?php echo JSSTformfield::select('priority', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), jssupportticket::$_data[0]->priorityid, __('Change Priority', 'js-support-ticket'), array()); ?></div>
                                    <div class="js-col-md-4"><?php echo JSSTformfield::button('changepriority', __('Change Priority', 'js-support-ticket'), array('class' => 'changeprioritybutton', 'onclick' => 'actionticket(1);')); ?></div>
                                </div>
                            </div>
                <?php } ?>
                    </div>
                    <div class="js-col-md-12 js-ticket-detail-wrapper">
                        <div class="js-row js-ticket-requester"><?php echo __('Requester Info', 'js-support-ticket'); ?></div>
                        <div class="js-row js-ticket-bottombar">
                            <div class="js-col-md-4">
                                <?php
                                if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                    echo get_avatar(jssupportticket::$_data[0]->uid,20);
                                } else { ?>
                                    <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/smallticketman.png'; ?>" />
                                <?php } ?>                            
                                <?php echo jssupportticket::$_data[0]->name; ?>
                            </div>
                            <div class="js-col-md-5">
                                <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/smallmail.png'; ?>" />
                <?php echo jssupportticket::$_data[0]->email; ?>
                            </div>
                            <div class="js-col-md-3">
                            <?php  if($printflag == false){ ?>
                                    <a href="#" id="showhidedetail" data-divid="js-hidden-ticket-data"><img class="js-showdetail" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/showhide.png'; ?>" /><?php echo __('Show Detail', 'js-support-ticket'); ?></a>
                            <?php } ?>
                            </div>
                            <div id="js-hidden-ticket-data" <?php if($printflag == true){ echo "style='display:inline-block'";}?>>
                                <div class="js-row js-ticket-requester"><?php echo __('More Detail', 'js-support-ticket'); ?></div>
                                <div class="js-row">
                                    <div class="js-col-md-6 js-col-xs-12 js-ticket-moredetail">
                                        <div class="js-col-md-6 js-col-xs-5 js-ticket-data-title"><?php echo __($field_array['phone'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-md-6 js-col-xs-7 js-ticket-data-value"><?php echo jssupportticket::$_data[0]->phone; ?></div>
                                    </div>
                                    <div class="js-col-md-6 js-col-xs-12 js-ticket-moredetail">
                                        <div class="js-col-md-6 js-col-xs-5 js-ticket-data-title"><?php echo __($field_array['helptopic'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-md-6 js-col-xs-7 js-ticket-data-value"><?php echo jssupportticket::$_data[0]->helptopic; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>                
                <?php if (jssupportticket::$_data['user_staff']) { ?>
                    <?php
                    $colored = "colored";
                    if (!empty(jssupportticket::$_data[6])) {
                        ?>
                            <h1 class="js-ticket-sub-heading"><?php echo __('Internal Notes', 'js-support-ticket'); ?></h1>
                        <?php
                        foreach (jssupportticket::$_data[6] AS $note) {
                            if ($cur_uid == isset($note->uid))
                                $colored = '';
                            ?>
                                <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                                    <?php if ($note->staffphoto) { ?>
                                        <img  src="<?php echo site_url('?page_id='.jssupportticket::getPageid().'&action=jstask&jstmod=staff&task=getStaffPhoto&jssupportticketid='.$note->staff_id ); ?>">
                                    <?php } else {
                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                            echo get_avatar($note->uid);
                                        } else { ?>
                                            <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                        <?php } ?>                            
                                    <?php } ?>
                                </div>
                                <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper <?php echo $colored; ?>">
                                    <div class="js-ticket-detail-corner"></div>
                                    <div class="js-ticket-thread-upperpart">
                                        <span class="js-ticket-thread-replied"><?php echo __('Posted by', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-thread-person"><?php echo !empty($note->staffname) ? $note->staffname : $note->display_name; ?></span>
                                        <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($note->created)); ?>&nbsp;)</span>
                                    </div>
                            <?php if (isset($note->title) && $note->title != '') { ?>
                                        <div class="js-ticket-thread-upperpart">
                                            <span class="js-ticket-thread-replied"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                            <span class="js-ticket-thread-person"><?php echo $note->title; ?></span>
                                        </div>
                                    <?php } ?>
                                    <div class="js-ticket-thread-middlepart">
                                        <?php 
                                            echo $note->note;
                                            if($note->filesize > 0 && !empty($note->filename)){
                                                echo '<div class="js_ticketattachment">'
                                                        . $note->filename . ' (' . ($note->filesize / 1024 ) . ')&nbsp;&nbsp;
                                                        <a class="button" target="_blank" href="'.admin_url('?page=note&action=jstask&task=downloadbyid&id='.$note->id).'">'.__('Download','js-support-ticket').'</a>
                                                        </div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <h1 class="js-ticket-sub-heading"><?php echo __('Ticket Thread', 'js-support-ticket'); ?></h1>
                    <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                        <?php if (jssupportticket::$_data[0]->staffphotophoto) { ?>
                            <img  src="<?php echo site_url('?page_id='.jssupportticket::getPageid().'&action=jstask&jstmod=staff&task=getStaffPhoto&jssupportticketid='.jssupportticket::$_data[0]->staffphotoid ); ?>">
                        <?php } else {
                            if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                echo get_avatar(jssupportticket::$_data[0]->uid);
                            } else { ?>
                                <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>                            
                        <?php } ?>
                    </div>
                    <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper colored">
                        <div class="js-ticket-detail-corner"></div>
                        <div class="js-ticket-thread-upperpart">
                            <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                            <span class="js-ticket-thread-person"><?php echo jssupportticket::$_data[0]->name; ?></span>
                            <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]->created)); ?>&nbsp;)</span>
                        </div>
                        <div class="js-ticket-thread-middlepart">
                        <?php echo jssupportticket::$_data[0]->message; ?>
                        </div>
                        <?php
                        if (!empty(jssupportticket::$_data['ticket_attachment'])) {
                            foreach (jssupportticket::$_data['ticket_attachment'] AS $attachment) {
                                $path = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&action=jstask&task=downloadbyid&id=".$attachment->id);
                                echo '
                              <div class="js_ticketattachment">
                                ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '              
                                <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                              </div>';
                            }
                        }
                        ?>
                    </div>
                        <?php
                        $colored = "colored";
                        if (!empty(jssupportticket::$_data[4]))
                            foreach (jssupportticket::$_data[4] AS $reply):
                                if ($cur_uid == $reply->uid)
                                    $colored = '';
                                ?>
                            <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                                <?php if ($reply->staffphoto) { ?>
                                    <img  src="<?php echo site_url('?page_id='.jssupportticket::getPageid().'&action=jstask&jstmod=staff&task=getStaffPhoto&jssupportticketid='.$reply->staffid ); ?>">
                                <?php } else {
                                    if (isset($reply->uid) && !empty($reply->uid)) {
                                        echo get_avatar($reply->uid);
                                    } else { ?>
                                        <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                    <?php } ?>                            
                                <?php } ?>
                            </div>
                            <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper <?php echo $colored; ?>">
                                <div class="js-ticket-detail-corner"></div>
                                <div class="js-ticket-thread-upperpart">
                                    <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-thread-person"><?php echo $reply->name; ?></span>
                                    <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>&nbsp;)</span>
                                    <span class="js-ticket-via-email"><?php echo ($reply->ticketviaemail == 1) ? __('Created via Email', 'js-support-ticket') : ''; ?></span>
                                </div>
                                <div class="js-ticket-thread-middlepart">
                        <?php echo $reply->message; ?>
                                </div>
                        <?php
                        if (!empty($reply->attachments)) {
                            foreach ($reply->attachments AS $attachment) {
                                $path = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&action=jstask&task=downloadbyid&id=".$attachment->id);
                                echo '
                                    <div class="js_ticketattachment">
                                      ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                                      <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                                    </div>';
                            }
                        }
                        ?>
                            </div>
                    <?php endforeach; 
                    if($printflag == false){
                            
                            // Reply Area
                            if (!jssupportticket::$_data['user_staff']) {
                                if (jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->lock != 1):
                                    ?>
                            <h1 class="js-ticket-heading"><?php echo __('Reply', 'js-support-ticket'); ?></h1>
                            <div id="postreply">
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Response', 'js-support-ticket'); ?><font color="red">*</font></label></div>
                                    <div class="js-form-field"><?php echo wp_editor('', 'jsticket_message', array('media_buttons' => false)); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-form-wrapper">
                                    <div class="js-col-xs-12 js-form-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-12 js-form-field">
                                        <div class="js-col-xs-12 tk_attachment_value_wrapperform">
                                            <span class="js-col-xs-12 tk_attachment_value_text">
                                                <input type="file" class="inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                                <span class='tk_attachment_remove'></span>
                                            </span>
                                        </div>  
                                        <span class="tk_attachments_configform">
                                            <small><?php echo __('Maximum File Size', 'js-support-ticket');
                        echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                        echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
                                        </span>
                                        <div class="js-col-md-12"><span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File', 'js-support-ticket'); ?></span></div>
                                    </div>
                                </div>
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 replyFormStatus js-form-title-position-reletive-left"><?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?></div>
                                    </div>

                                <div class="js-form-button">
                                    <?php echo JSSTformfield::submitbutton('postreply', __('Post Reply', 'js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('message');")); ?>
                                </div>      
                            </div>
                    <?php endif; ?>
                    <?php echo JSSTformfield::hidden('actionid', ''); ?>
                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('created', jssupportticket::$_data[0]->created); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('updated', jssupportticket::$_data[0]->updated); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                    </form>

                    <?php
                }else {
                    ?>
                    <?php echo JSSTformfield::hidden('actionid', ''); ?>
                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('created', jssupportticket::$_data[0]->created); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('updated', jssupportticket::$_data[0]->updated); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                    </form>
                    <div id="tabs" class="tabs">
                        <ul class="js-col-xs-12 js-col-md-12">
                            <li class="js-col-xs-12 js-col-md-3 firstTab"><a href="#postreply"><?php echo __('Post Reply', 'js-support-ticket'); ?></a></li>
                            <li class="js-col-xs-12 js-col-md-3"><a href="#postinternalnote"><?php echo __('Internal Note', 'js-support-ticket'); ?></a></li>
                            <li class="js-col-xs-12 js-col-md-3"><a href="#departmenttransfer"><?php echo __('Department Transfer', 'js-support-ticket') ?></a></li>
                            <li class="js-col-xs-12 js-col-md-3 lastTab"><a href="#assigntostaff"><?php echo __('Assign to Staff', 'js-support-ticket') ?></a></li>
                        </ul>
                        <div class="tabInner">
                            <!-- Post Reply Area -->
                            <div id="postreply"> 
                                <form method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=reply&task=savereply"); ?>" enctype="multipart/form-data">
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-form-title js-col-md-2"><?php echo __($field_array['premade'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-form-field js-form-value js-col-md-10">
                                            <?php echo JSSTformfield::select('premadeid', JSSTincluder::getJSModel('premademessage')->getPreMadeMessageForCombobox(), isset(jssupportticket::$_data[0]->premadeid) ? jssupportticket::$_data[0]->premadeid : '', __('Select Premade', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getpremade(this.value);')); ?>
                                            <span class="js-col-xs-12 js-append-radio-reletive appendRadio"><?php echo JSSTformfield::checkbox('append_premade', array('1' => __('Append', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?></span>
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-field"><?php echo wp_editor('', 'jsticket_message', array('media_buttons' => false)); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-form-title-position-reletive-left"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-form-field">
                                            <div class="tk_attachment_value_wrapperform">
                                                <span class="js-col-xs-12 tk_attachment_value_text">
                                                    <input type="file" class="inputbox selectFile" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                                </span>
                                            </div>

                                            <div class="js-col-xs-12 js-col-md-12"><span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File', 'js-support-ticket'); ?></span></div>
                                            <span class="fileLimits">
                                                <small class"js-col-xs-12"><?php echo __('Maximum File Size', 'js-support-ticket');
                    echo ' (' . jssupportticket::$_config['file_maximum_size']; ?> KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                    echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
                                            </span>

                                        </div>
                                    </div>

                                    <div class="js-col-md-6 js-form-wrapper">
                                        <div class="js-col-md-12 js-form-title js-form-title-position-reletive-left"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
                                        <div class="js-col-md-12 js-form-value js-form-title-position-reletive-left js-form-title-position-border">
                    <?php echo JSSTformfield::checkbox('ownsignature', array('1' => __('Own Signature', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                    <?php echo JSSTformfield::checkbox('departmentsignature', array('1' => __('Department Signature', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                    <?php echo JSSTformfield::checkbox('nonesignature', array('1' => __('JNone', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                        </div>
                                    </div>
                                            <?php
                                            $staffid = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());
                                            if (jssupportticket::$_data[0]->staffid != $staffid) {
                                                ?>
                                        <div class="js-col-md-6 js-form-wrapper">
                                            <div class="js-col-md-12 js-form-title js-form-title-position-reletive-left"><?php echo __('Assign to me', 'js-support-ticket'); ?></div>
                                            <div class="js-col-md-12 js-form-value js-form-title-position-reletive-left js-form-title-position-border">
                                                <?php 
                                                    if(jssupportticket::$_data[0]->staffid){
                                                        $checked = '';
                                                    }else{
                                                        $checked = 1;
                                                    }
                                                    echo JSSTformfield::checkbox('assigntome', array('1' => __('Assign to me', 'js-support-ticket')), $checked, array('class' => 'radiobutton')); 
                                                ?>
                                            </div>
                                        </div>
                    <?php } ?>
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-title js-form-title-position-reletive-left"><?php echo __('Ticket', 'js-support-ticket'); echo ' '; echo __($field_array['status'],'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-col-md-12 replyFormStatus js-form-title-position-reletive-left"><?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?></div>
                                    </div>
                                    <div class="js-form-button">
                                    <?php echo JSSTformfield::submitbutton('postreply', __('Post Reply', 'js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('message');")); ?>
                                    </div>
                                    <?php echo JSSTformfield::hidden('departmentid', jssupportticket::$_data[0]->departmentid); ?>
                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('action', 'reply_savereply'); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>   
                            </div> <!-- end of postreply div -->
                            <div id="postinternalnote">  <!--  postinternalnote Area   -->
                                <form method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=note&task=savenote"); ?>" enctype="multipart/form-data">

                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-form-title js-col-md-2"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-form-field js-col-md-10">
                    <?php echo JSSTformfield::text('internalnotetitle', '', array('class' => 'inputbox')) ?>
                                        </div>
                                    </div>

                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">                                  
                                        <div class="js-col-xs-12 js-col-md-12 js-form-field"><?php echo wp_editor('', 'internalnote', array('media_buttons' => false)); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-title js-form-title-position-reletive-left"><?php echo __('Ticket', 'js-support-ticket'); echo ' '; echo __($field_array['status'],'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-col-md-12 replyFormStatus js-form-title-position-reletive-left"><?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-col-md-12 js-form-field">
                                            <div class="tk_attachment_value_wrapperform">
                                                <span class="tk_attachment_value_text">
                                                    <input type="file" class="inputbox" name="note_attachment" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                                    <span class='tk_attachment_remove'></span>
                                                </span>
                                            </div>
                                            <span class="tk_attachments_configform">
                                                <small><?php __('Maximum File Size','js-support-ticket');
                                                echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php __('File Extension Type','js-support-ticket');
                                                echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
                                            </span>                            
                                        </div>
                                    </div>
                                    <div class="js-form-button">
                    <?php echo JSSTformfield::submitbutton('postinternalnote', __('Post Internal Note', 'js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('internalnote');")); ?>
                                    </div>
                                            <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('action', 'note_savenote'); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>
                            </div> <!-- end of postinternalnote div -->
                            <div id="departmenttransfer">
                                <form method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=transferdepartment"); ?>" enctype="multipart/form-data">
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-form-title js-col-md-2"><?php echo __($field_array['department'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-form-field js-col-md-12 js-col-md-10">
                                            <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data[0]->departmentid, __('Select Department', 'js-support-ticket'), array('class' => 'inputbox')); ?>
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-field"><?php echo wp_editor('', 'departmenttranfernote', array('media_buttons' => false)); ?></div>
                                    </div>
                                    <div class="js-form-button">
                    <?php echo JSSTformfield::submitbutton('departmenttransfer', __('Transfer', 'js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('departmenttranfernote');")); ?>
                                    </div>
                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('action', 'ticket_transferdepartment'); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>
                            </div> <!-- end of departmenttransfer div -->
                            <div id="assigntostaff">
                                <form method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=assigntickettostaff"); ?>" enctype="multipart/form-data">
                                    <div class="js-col-xs-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-form-title js-col-md-2"><?php echo __('Staff Member', 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-12 js-form-field js-col-md-10">
                    <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('staff')->getstaffForCombobox(), jssupportticket::$_data[0]->staffid, __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox')); ?>
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-form-wrapper">
                                        <div class="js-col-xs-12 js-col-md-12 js-form-field"><?php echo wp_editor('', 'assignnote', array('media_buttons' => false)); ?></div>
                                    </div>
                                    <div class="js-form-button">
                    <?php echo JSSTformfield::submitbutton('assigntostaff', __('Assign', 'js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('assignnote');")); ?>
                                    </div>
                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                    <?php echo JSSTformfield::hidden('action', 'ticket_assigntickettostaff'); ?>
                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>
                            </div> <!-- end of assigntostaff div -->
                        </div> <!-- end of tabInner div -->
                    </div> <!-- end of tab div -->                      

                    <?php
                }
            }
                ?>
                <?php
            } else { // Record Not FOund
                JSSTlayout::getNoRecordFound();
            }
        } else {// User is permission
            JSSTlayout::getPermissionNotGranted();
        }
    } else {// User is guest
        $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=ticketdetail');
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
