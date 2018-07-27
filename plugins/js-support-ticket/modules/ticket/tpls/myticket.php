<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0) {
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

        ?>
        <script type="text/javascript">
        ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery(document).ready(function ($) {
                $('.custom_date').datepicker({dateFormat: 'yy-mm-dd'});
                var combinesearch = "<?php echo isset(jssupportticket::$_data['filter']['combinesearch']) ? jssupportticket::$_data['filter']['combinesearch'] : ''; ?>";
                if (combinesearch) {
                    doVisible();
                    $("#js-filter-wrapper-toggle-area").show();
                }
                $("#js-filter-wrapper-toggle-btn").click(function () {
                    if ($("#js-filter-wrapper-toggle-search").is(":visible")) {
                        doVisible();
                    } else {
                        $("#js-filter-wrapper-toggle-search").show();
                        $("#js-filter-wrapper-toggle-ticketid").hide();
                        $("#js-filter-wrapper-toggle-minus").hide();
                        $("#js-filter-wrapper-toggle-plus").show();
                    }
                    $("#js-filter-wrapper-toggle-area").toggle();
                });

                jQuery('a.jssortlink').click(function(e){
                    e.preventDefault();
                    var sortby = jQuery(this).attr('href');
                    jQuery('input#sortby').val(sortby);
                    jQuery('form#jssupportticketform').submit();
                });
                jQuery('a.js-myticket-link').click(function(e){
                    e.preventDefault();
                    var list = jQuery(this).attr('href');
                    jQuery('input#list').val(list);
                    jQuery('form#jssupportticketform').submit();
                });


                function doVisible() {
                    $("#js-filter-wrapper-toggle-search").hide();
                    $("#js-filter-wrapper-toggle-ticketid").show();
                    $("#js-filter-wrapper-toggle-minus").show();
                    $("#js-filter-wrapper-toggle-plus").hide();
                }
            });
            function resetFrom() {
                var form = jQuery('form#jssupportticketform');
                form.find("input[type=text], input[type=email], input[type=password], textarea").val("");
                form.find('input:checkbox').removeAttr('checked');
                form.find('select').prop('selectedIndex', 0);
                form.find('input[type="radio"]').prop('checked', false);
                document.getElementById('jsst-ticket').value = '';
                document.getElementById('jsst-ticketsearchkeys').value = '';
                document.getElementById('jsst-from').value = '';
                document.getElementById('jsst-email').value = '';
                document.getElementById('jsst-departmentid').value = '';
                document.getElementById('jsst-priorityid').value = '';
                document.getElementById('jsst-subject').value = '';
                document.getElementById('jsst-datestart').value = '';
                document.getElementById('jsst-dateend').value = '';
                return true;
            }
        </script>
        <?php JSSTmessage::getMessage(); ?>
        <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
        <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
        <?php
        $list = JSSTrequest::getVar('list', null, 1);
        $open = ($list == 1) ? 'active' : '';
        $answered = ($list == 2) ? 'active' : '';
        $overdue = ($list == 3) ? 'active' : '';
        $myticket = ($list == 4) ? 'active' : '';
        $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
        ?>
        <div class="js-row js-nullmargin">
            <div class="js-col-xs-12 js-col-md-3 js-myticket-link">
                <a class="js-myticket-link <?php echo $open; ?>" href="1">
                    <?php 
                        echo __('Open', 'js-support-ticket'); 
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( ' . jssupportticket::$_data['count']['openticket'] . ' )';
                    ?>
                </a>
            </div>
            <div class="js-col-xs-12 js-col-md-3 js-myticket-link">
                <a class="js-myticket-link <?php echo $answered; ?>" href="2">
                    <?php 
                        echo __('Closed', 'js-support-ticket'); 
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( ' . jssupportticket::$_data['count']['closedticket'] . ' )';
                    ?>
                </a>
            </div>
            <div class="js-col-xs-12 js-col-md-3 js-myticket-link">
                <a class="js-myticket-link <?php echo $overdue; ?>" href="3">
                    <?php 
                        echo __('Answered', 'js-support-ticket'); 
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( ' . jssupportticket::$_data['count']['answeredticket'] . ' )';
                    ?>
                </a>
            </div>
            <div class="js-col-xs-12 js-col-md-3 js-myticket-link">
                <a class="js-myticket-link <?php echo $myticket; ?>" href="4">
                    <?php 
                        echo __('My Tickets', 'js-support-ticket'); 
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( ' . jssupportticket::$_data['count']['allticket'] . ' )';
                    ?>
                </a>
            </div>
        </div>
        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo site_url("?page_id=" . jssupportticket::getPageId() . "&jstmod=ticket&jstlay=myticket"); ?>">
            <div class="js-col-md-12 js-filter-wrapper js-filter-wrapper-position">	
                <div class="js-col-md-12 js-filter-value" id="js-filter-wrapper-toggle-search"><?php echo JSSTformfield::text('jsst-ticketsearchkeys', isset(jssupportticket::$_data['filter']['ticketsearchkeys']) ? jssupportticket::$_data['filter']['ticketsearchkeys'] : '', array('placeholder' => __('Ticket ID', 'js-support-ticket') . ' ' . __('Or', 'js-support-ticket') . ' ' . __($field_array['email'], 'js-support-ticket') . ' ' . __('Or', 'js-support-ticket') . ' ' . __($field_array['subject'], 'js-support-ticket'))); ?></div>
                <div class="js-col-md-12 js-filter-value" id="js-filter-wrapper-toggle-ticketid"><?php echo JSSTformfield::text('jsst-ticket', isset(jssupportticket::$_data['filter']['ticketid']) ? jssupportticket::$_data['filter']['ticketid'] : '', array('placeholder' => __('Ticket ID', 'js-support-ticket'))); ?></div>
                <div id="js-filter-wrapper-toggle-btn">
                    <div id="js-filter-wrapper-toggle-plus">
                        <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/plus.png'; ?>" />
                    </div> 
                    <div id="js-filter-wrapper-toggle-minus">
                        <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/minus.png'; ?>" />
                    </div>
                </div>
            </div>
            <div id="js-filter-wrapper-toggle-area">
                <div class="js-col-md-12 js-filter-wrapper">	
                    <div class="js-col-xs-12 js-col-md-6 js-filter-value"><?php echo JSSTformfield::text('jsst-from', isset(jssupportticket::$_data['filter']['from']) ? jssupportticket::$_data['filter']['from'] : '', array('placeholder' => __('From', 'js-support-ticket'))); ?></div>
                    <div class="js-col-md-6 js-filter-value"><?php echo JSSTformfield::text('jsst-email', isset(jssupportticket::$_data['filter']['email']) ? jssupportticket::$_data['filter']['email'] : '', array('placeholder' => __($field_array['email'], 'js-support-ticket'))); ?></div>
                </div>
                <div class="js-col-xs-12 js-col-md-12 js-filter-wrapper">	
                    <div class="js-col-xs-12 js-col-md-6 js-filter-value"><?php echo JSSTformfield::select('jsst-departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), isset(jssupportticket::$_data['filter']['departmentid']) ? jssupportticket::$_data['filter']['departmentid'] : '', __('Select', 'js-support-ticket').' '.__($field_array['department'], 'js-support-ticket')); ?> </div>
                    <div class="js-col-xs-12 js-col-md-6 js-filter-value"><?php echo JSSTformfield::select('jsst-priorityid', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), isset(jssupportticket::$_data['filter']['priorityid']) ? jssupportticket::$_data['filter']['priorityid'] : '', __('Select', 'js-support-ticket').' '.__($field_array['priority'], 'js-support-ticket')); ?></div>
                </div>
                <div class="js-col-xs-12 js-col-md-12 js-filter-wrapper">	
                    <div class="js-col-xs-12 js-col-md-12 js-filter-value"><?php echo JSSTformfield::text('jsst-subject', isset(jssupportticket::$_data['filter']['subject']) ? jssupportticket::$_data['filter']['subject'] : '', array('placeholder' => __($field_array['subject'], 'js-support-ticket'))); ?></div>
                </div>
                <div class="js-col-xs-12 js-col-md-12 js-filter-wrapper">	
                    <div class="js-col-xs-12 js-col-md-4 js-filter-value"><?php echo JSSTformfield::text('jsst-datestart', isset(jssupportticket::$_data['filter']['datestart']) ? jssupportticket::$_data['filter']['datestart'] : '', array('class' => 'custom_date', 'placeholder' => __('Start Date', 'js-support-ticket'))); ?></div>
                    <div class="js-col-md-4 js-ticket-special-character js-nullpadding">-</div>
                    <div class="js-col-xs-12 js-col-md-4 js-filter-value"><?php echo JSSTformfield::text('jsst-dateend', isset(jssupportticket::$_data['filter']['dateend']) ? jssupportticket::$_data['filter']['dateend'] : '', array('class' => 'custom_date', 'placeholder' => __('End Date', 'js-support-ticket'))); ?></div>
                </div>
                <?php 
                    $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
                    foreach ($customfields as $field) {
                        JSSTincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $k);
                    }
                ?>
            </div>
            <div class="js-col-xs-12 js-col-md-12 js-filter-wrapper">
                <div class="js-filter-button">
                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'js-ticket-filter-button')); ?>
                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'js-ticket-filter-button', 'onclick' => 'return resetFrom();')); ?>
                </div>
            </div>
            <?php echo JSSTformfield::hidden('sortby', jssupportticket::$_data['filter']['sortby']); ?>
            <?php echo JSSTformfield::hidden('list', $list); ?>            
        </form>

        <?php
        $link = site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=myticket&list=' . jssupportticket::$_data['list']);
        if (jssupportticket::$_sortorder == 'ASC')
            $img = "sort0.png";
        else
            $img = "sort1.png";
        ?>
        <div class="js-ticket-sorting js-col-md-12">
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['subject']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'subject') echo 'selected' ?>"><?php echo __($field_array['subject'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'subject') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['priority']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'priority') echo 'selected' ?>"><?php echo __($field_array['priority'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'priority') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['ticketid']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'ticketid') echo 'selected' ?>"><?php echo __('Ticket ID', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'ticketid') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['isanswered']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'isanswered') echo 'selected' ?>"><?php echo __('Answered', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'isanswered') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['status']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'status') echo 'selected' ?>"><?php echo __($field_array['status'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'status') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['created']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'created') echo 'selected' ?>"><?php echo __('Created', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'created') { ?> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
        </div>
        <?php
        if (!empty(jssupportticket::$_data[0])) {
            foreach (jssupportticket::$_data[0] AS $ticket) {
                if ($ticket->status == 0) {
                    $style = "#9ACC00;";
                    $status = __('New', 'js-support-ticket');
                } elseif ($ticket->status == 1) {
                    $style = "#FFB613;";
                    $status = __('Waiting Staff Reply', 'js-support-ticket');
                } elseif ($ticket->status == 2) {
                    $style = "#FE7C2C;";
                    $status = __('In Progress', 'js-support-ticket');
                } elseif ($ticket->status == 3) {
                    $style = "#217ac3;";
                    $status = __('Waiting Your Reply', 'js-support-ticket');
                } elseif ($ticket->status == 4) {
                    $style = "#F04646;";
                    $status = __('Closed', 'js-support-ticket');
                }
                $ticketviamail = '';
                if ($ticket->ticketviaemail == 1)
                    $ticketviamail = __('Created via Email', 'js-support-ticket');
                ?>  		
                <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                    <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                        <div class="js-col-xs-2 js-col-md-1 js-ticket-pic">
                            <?php
                            if (isset($ticket->uid) && !empty($ticket->uid)) {
                                echo get_avatar($ticket->uid);
                            } else { ?>
                                <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>                            
                        </div>
                        <div class="js-col-xs-10 js-col-md-7 js-col-xs-10 js-ticket-data js-nullpadding">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                <span class="js-ticket-title"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $ticket->id); ?>"><?php echo $ticket->subject; ?></a>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                <span class="js-ticket-title"><?php echo __('From', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-value"><?php echo $ticket->name; ?></span>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                <span class="js-ticket-title"><?php echo __($field_array['department'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-value"><?php echo __($ticket->departmentname, 'js-support-ticket'); ?></span>
                            </div>
                            <?php
                            jssupportticket::$_data['ticketid'] = $ticket->id;
                            $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1, 1);
                            foreach ($customfields as $field) {
                                echo JSSTincluder::getObjectClass('customfields')->showCustomFields($field,1, $ticket->params);
                            }
                            ?>
                            <span class="js-ticket-value js-ticket-creade-via-email-spn"><?php echo $ticketviamail; ?></span>
                            <span class="js-ticket-status" style="background:<?php echo $style; ?>">
                                <?php
                                $counter = 'one';
                                if ($ticket->lock == 1) {
                                    ?>
                                    <img class="ticketstatusimage <?php echo $counter;
                    $counter = 'two'; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/lockstatus.png"; ?>" title="<?php echo __('Ticket is locked', 'js-support-ticket'); ?>" />
                                <?php } ?>
                <?php if ($ticket->isoverdue == 1) { ?>
                                    <img class="ticketstatusimage <?php echo $counter; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/mark_over_due.png"; ?>" title="<?php echo __('Ticket mark overdue', 'js-support-ticket'); ?>" />
                <?php } ?>
                <?php echo $status; ?>
                            </span>
                        </div>
                        <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo $ticket->ticketid; ?></div>
                            </div>
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __('Last Reply', 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php if (empty($ticket->lastreply) || $ticket->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket');
                else echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->lastreply)); ?></div>
                            </div>
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6 js-ticket-wrapper-textcolor" style="background:<?php echo $ticket->prioritycolour; ?>;"><?php echo __($ticket->priority, 'js-support-ticket'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }

            if (jssupportticket::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else { // Record Not FOund
            JSSTlayout::getNoRecordFound();
        }
    } else {// User is guest
        $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=myticket');
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
