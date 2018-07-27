<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-subject').value = '';
                            document.getElementById('jsst-cat').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-subject').value = fillSpaces(document.getElementById('jsst-subject').value);
                            return true;
                        }
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                    <h1 class="js-ticket-heading"><?php echo __("FAQ's", 'js-support-ticket') ?>
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=addfaq"); ?>"><?php echo __('Add FAQ', 'js-support-ticket') ?></a>
                    </h1>
                    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
                        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
                        <?php echo "<input type='hidden' name='jstmod' value='faq'/>"; ?>
                        <?php echo "<input type='hidden' name='jstlay' value='stafffaqs'/>"; ?>
                        <div class="row js-filter-wrapper">
                            <div class="js-col-md-6 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::text('jsst-subject', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-subject')), array('placeholder' => __('Title', 'js-support-ticket'))); ?></div>
                            </div>
                            <div class="js-col-md-6 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Categories', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::select('jsst-cat', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('faqs'), JSSTrequest::getVar('jsst-cat'), __('Select Category', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                            </div>
                            <div class="js-col-md-12 js-filter-wrapper">
                                <div class="js-filter-button">
                                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return addSpaces();')); ?>
                                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (!empty(jssupportticket::$_data[0])) { ?>  		
                        <div class="js-filter-form-list">
                            <div class="js-filter-form-head js-filter-form-head-xs">
                                <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-3 js-col-xs-12 second"><?php echo __('Category', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 js-col-xs-12 fifth"><?php echo __('Action', 'js-support-ticket'); ?></div>
                            </div>
                            <?php
                            foreach (jssupportticket::$_data[0] AS $faq) {
                                $status = ($faq->status == 1) ? 'yes.png' : 'no.png';
                                ?>			
                                <div class="js-filter-form-data">
                                    <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
                            echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=addfaq&jssupportticketid=" . $faq->id); ?>"><?php echo $faq->subject; ?></a></div>
                                    <div class="js-col-md-3 js-col-xs-12 second"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket');
                            echo " : "; ?></span> <?php echo $faq->categoryname; ?></div>
                                    <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                            echo " : "; ?></span> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></div>
                                    <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
                            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($faq->created)); ?></div>
                                    <div class="js-col-md-2 js-col-xs-12 fifth js-filter-form-action-hl-xs">
                                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=addfaq&jssupportticketid=" . $faq->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&task=deletefaq&action=jstask&faqid=" . $faq->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                                    </div>
                                </div>
                            <?php }
                        ?>
                        </div>
                        <?php
                        if (jssupportticket::$_data[1]) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                        }
                    } else { // Record Not FOund
                        JSSTlayout::getNoRecordFound();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=faq&jstlay=stafffaqs');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
} ?>