<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-title').value = '';
                            document.getElementById('jsst-cat').value = '';
                            document.getElementById('jsst-type').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-title').value = fillSpaces(document.getElementById('jsst-title').value);
                            return true;
                        }
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php
                    $type = array(
                        (object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
                        (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
                    );
                    ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <h1 class="js-ticket-heading"><?php echo __('Announcements', 'js-support-ticket') ?>
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=addannouncement"); ?> "><?php echo __('Add Announcement', 'js-support-ticket') ?></a>

                    </h1>
                    <form class="js-filter-form" method="GET" action="">
                        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
                        <?php echo "<input type='hidden' name='jstmod' value='announcement'/>"; ?>
                        <?php echo "<input type='hidden' name='jstlay' value='staffannouncements'/>"; ?>
                        <div class="row js-filter-wrapper">
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::text('jsst-title', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-title')), array('placeholder' => __('Title', 'js-support-ticket'))); ?></div>
                            </div>
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Categories', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::select('jsst-cat', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), JSSTrequest::getVar('jsst-cat'), __('Select Category', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                            </div>		
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Type', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::select('jsst-type', $type, JSSTrequest::getVar('jsst-type'), __('Select Type', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
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
                                <div class="js-col-md-3 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-3 second"><?php echo __('Category', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-1 third js-textaligncenter"><?php echo __('Type', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-1 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 fifth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 sixth"><?php echo __('Action', 'js-support-ticket'); ?></div>
                            </div>
                            <?php
                            foreach (jssupportticket::$_data[0] AS $announcement) {
                                $listtype = '';
                                if ($announcement->type == 1)
                                    $listtype = __('Public', 'js-support-ticket');
                                elseif ($announcement->type == 2)
                                    $listtype = __('Private', 'js-support-ticket');
                                $status = ($announcement->status == 1) ? 'yes.png' : 'no.png';
                                ?>			
                                <div class="js-filter-form-data">
                                    <div class="js-col-xs-12 js-col-md-3 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
                            echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=addannouncement&jssupportticketid=" . $announcement->id); ?>"><?php echo $announcement->title; ?></a></div>
                                    <div class="js-col-xs-12 js-col-md-3 second"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket');
                            echo " : "; ?></span><?php echo $announcement->categoryname; ?></div>
                                    <div class="js-col-xs-12 js-col-md-1 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Type', 'js-support-ticket');
                            echo " : "; ?></span><?php echo $listtype; ?></div>
                                    <div class="js-col-xs-12 js-col-md-1 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                            echo " : "; ?></span><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></div>
                                    <div class="js-col-xs-12 js-col-md-2 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
                            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($announcement->created)); ?></div>
                                    <div class="js-col-xs-12 js-col-md-2 sixth js-filter-form-action-hl-xs">
                                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=addannouncement&jssupportticketid=" . $announcement->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                                        <a onclick="return confirm('<?php echo __('Are you sure to delete'); ?>');" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&task=deleteannouncement&action=jstask&announcementid=" . $announcement->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                                    </div>
                                </div>
                            <?php }
                        ?>
                        </div>		
                        <?php
                        if (jssupportticket::$_data[1]) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                        }
                    } else {
                        JSSTlayout::getNoRecordFound();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=announcement&jstlay=staffannouncements');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
}
?>
