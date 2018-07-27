
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=role&jstlay=roles');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo jssupportticket::$_data[0]['role']->name . " " . __('Role Permission', 'js-support-ticket'); ?></span></span>

<?php
$colperrow = 3;
$colwidth = round(100 / $colperrow, 1);
$colwidth = $colwidth - 1;
$colwidth = $colwidth . '%';
$permission_allow = 0;

$trclass = array("row0", "row1");
$k = 0;
?>
<div id="tk_form_wraper">
    <?php
    $deptext = __('Department Section', 'js-support-ticket');
    $depid = "rad_alldepartmentaccess";
    $depclass = "rad_departmentaccess";
    ?>
    <div class="tk_permission_wraper">
        <div class="tk_permission_heading" > 
            <span class="tk_permission_heading_text" > 
                <?php echo $deptext; ?>
            </span>
        </div>   
        <div class="tk_permission_task_wraper"  >
            <?php
            $colcount = 0;
            foreach (jssupportticket::$_data[0]['department_role'] AS $dep) {
                ?>                 <?php
                if ($colcount == $colperrow) {
                    echo '</div><div class="tk_permission_task_wraper" >';
                    $colcount = 0;
                } $colcount++;
                ?>
                <span class="tk_permission_task_data" style="width:<?php echo $colwidth; ?>;">
                    <?php
                    $dchecked_or_not = "";
                    if (jssupportticket::$_data[0]['role']->id) {  //edit case
                        if (isset($dep->roledepartmentid)) {
                            $dchecked_or_not = ($dep->roledepartmentid == $dep->id) ? "checked='checked'" : "";
                        };
                    } else { //add case
                        $dchecked_or_not = "checked='checked'";
                    }
                    ?>
                    <input type='checkbox' disabled ='disabled' id="<?php echo 'roledepdata_' . $dep->name; ?>" class="<?php echo $depclass; ?>" name='roledepdata[<?php echo $dep->name; ?>]' value="<?php echo $dep->id ?>" <?php echo $dchecked_or_not; ?>  />
                    <label class="<?php echo $depclass; ?>" for="<?php echo 'roledepdata_' . $dep->name; ?>"><?php echo __($dep->name, 'js-support-ticket'); ?></label>
                </span>
            <?php
            }
            if ($colcount <= $colperrow)
                echo '</div>';
            $permission_keys = array_keys(jssupportticket::$_data[0]['permission_by_task']);
            foreach ($permission_keys AS $permissin_by_section) {
                switch ($permissin_by_section) {
                    case 'ticket_section':
                        $text = __('Ticket Section', 'js-support-ticket');
                        $id = "t_s_allrolepermision";
                        $class = "t_s_rolepermission";
                        $section = 'ticke';
                        break;
                    case 'staff_section':
                        $text = __('Staff Section', 'js-support-ticket');
                        $id = "s_s_allrolepermision";
                        $class = "s_s_rolepermission";
                        $section = 'staff';

                        break;
                    case 'kb_section':
                        $text = __('Knowledge Base Section', 'js-support-ticket');
                        $id = "kb_s_allrolepermision";
                        $class = "kb_s_rolepermission";
                        $section = 'kb';

                        break;
                    case 'faq_section':
                        $text = __('FAQ Section', 'js-support-ticket');
                        $id = "f_s_allrolepermision";
                        $class = "f_s_rolepermission";
                        $section = 'faqs';

                        break;
                    case 'download_section':
                        $text = __('Download Section', 'js-support-ticket');
                        $id = "d_s_allrolepermision";
                        $class = "d_s_rolepermission";
                        $section = 'staffdownloads';

                        break;
                    case 'announcement_section':
                        $text = __('Announcement Section', 'js-support-ticket');
                        $id = "a_s_allrolepermision";
                        $class = "a_s_rolepermission";
                        $section = 'announcement';
                        break;
                    case 'mail_section':
                        $text = __('Mail Section', 'js-support-ticket');
                        $id = "m_s_allrolepermision";
                        $class = "m_s_rolepermission";
                        $section = 'mail';
                        break;
                }
                ?>
                <div class="tk_permission_heading">
                    <span class="tk_permission_heading_text">
                    <?php echo $text; ?>
                    </span>
                </div>   
                <div class="tk_permission_task_wraper">
                        <?php
                        $colcount = 0;
                        foreach (jssupportticket::$_data[0]['permission_by_task'][$permissin_by_section] AS $per) {
                            if ($colcount == $colperrow) {
                                echo '</div><div class="tk_permission_task_wraper">';
                                $colcount = 0;
                            }
                            $colcount++;
                            ?>
                        <span class="tk_permission_task_data" style="width:<?php echo $colwidth; ?>;">
                        <?php
                        $checked_or_not = "";
                        if (jssupportticket::$_data[0]['role']->id) {  //edit case:
                            if (isset($per->rolepermissionid)) {
                                $checked_or_not = ($per->rolepermissionid == $per->id) ? "checked='checked'" : "";
                            }
                            ?>
        <?php } else { //add case  ?>
            <?php $checked_or_not = "checked='checked'" ?>
        <?php } ?>
                            <input type='checkbox' disabled ='disabled'  id="<?php echo $section . '_' . $per->permission; ?>" class="<?php echo $class; ?>" name='roleperdata[<?php echo $per->permission ?>]' value="<?php echo $per->id ?>" <?php echo $checked_or_not; ?> />
                            <label for="<?php echo $section . '_' . $per->permission; ?>"><?php echo __($per->permission, 'js-support-ticket'); ?></label>
                        </span>   
    <?php
    }
    if ($colcount <= $colperrow)
        echo '</div>';
}
?>
            </div>
        </div> 