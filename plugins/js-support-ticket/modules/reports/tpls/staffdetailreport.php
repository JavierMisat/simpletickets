<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) { ?>
    <!-- admin -->
<?php
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
    google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '<?php echo __('Dates','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('New','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Answered','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Pending','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Overdue','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Closed','js-support-ticket'); ?>');
        data.addRows([
            <?php echo jssupportticket::$_data['line_chart_json_array']; ?>
        ]);        

        var options = {
          colors:['#1EADD8','#179650','#D98E11','#DB624C','#5F3BBB'],
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 6,
          // This line will make you select an entire row of data at a time
          focusTarget: 'category',
          chartArea: {width:'90%',top:50}
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }

    function resetFrom(){
        document.getElementById('jsst-date-start').value = '';
        document.getElementById('jsst-date-end').value = '';
        return true;
    }
</script>

<?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
<?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
<h1 class="js-ticket-heading"><?php echo __("Staff Report", 'js-support-ticket') ?></h1>

    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
        <?php 
        $curdate = date_i18n('Y-m-d');
        $enddate = date_i18n('Y-m-d', strtotime("now -1 month"));
        $date_start = !empty(jssupportticket::$_data['filter']['jsst-date-start']) ? jssupportticket::$_data['filter']['jsst-date-start'] : $curdate;
        $date_end = !empty(jssupportticket::$_data['filter']['jsst-date-end']) ? jssupportticket::$_data['filter']['jsst-date-end'] : $enddate; ?>
        <?php echo "<input type='hidden' name='jsst-id' value='" . jssupportticket::$_data['staff_report']->id . "'/>"; ?>
        <div class="row js-filter-wrapper">
            <div class="js-col-md-6"> <div class="js-col-md-12 js-filter-title"> <?php echo __('Date From', 'js-support-ticket'); ?> </div> <div class="js-col-md-12 js-filter-value"> <?php echo JSSTformfield::text('jsst-date-start', $date_start, array('class' => 'custom_date','placeholder' => __('Start Date','js-support-ticket'))); ?> </div> </div>
            <div class="js-col-md-6"> <div class="js-col-md-12 js-filter-title"> <?php echo __('Date To', 'js-support-ticket'); ?> </div> <div class="js-col-md-12 js-filter-value"> <?php echo JSSTformfield::text('jsst-date-end', $date_end, array('class' => 'custom_date','placeholder' => __('End Date','js-support-ticket'))); ?> </div> </div>
            <div class="js-col-md-12 js-filter-wrapper">
                <div class="js-filter-button">
                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                </div>
            </div>
        </div>
        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
        <?php echo "<input type='hidden' name='jstmod' value='reports'/>"; ?>
        <?php echo "<input type='hidden' name='jstlay' value='staffdetailreport'/>"; ?>        
    </form>

<div id="curve_chart" style="height:400px;width:100%; "></div>
<?php 
    $staff = jssupportticket::$_data['staff_report'];
    if(!empty($staff)){ ?>      
        <div class="js-admin-staff-wrapper padding">            
            <div class="js-col-md-4 nopadding js-festaffreport-img">
                <div class="js-col-md-3 js-report-staff-image-wrapper">
                    <?php
                        if($staff->photo){
                            $maindir = wp_upload_dir();
                            $path = $maindir['baseurl'];

                            $imageurl = $path."/".jssupportticket::$_config['data_directory']."/staffdata/staff_".$staff->id."/".$staff->photo;
                        }else{
                            $imageurl = jssupportticket::$_pluginpath."includes/images/defaultprofile.png";
                        }
                    ?>
                    <img class="js-report-staff-pic" src="<?php echo $imageurl; ?>" />
                </div>
                <div class="js-col-md-9">
                    <div class="js-report-staff-name">
                        <?php
                            if($staff->firstname && $staff->lastname){
                                $staffname = $staff->firstname . ' ' . $staff->lastname;
                            }else{
                                $staffname = $staff->display_name;
                            }
                            echo $staffname;
                        ?>                      
                    </div>
                    <div class="js-report-staff-username">
                        <?php
                            if($staff->username){
                                $username = $staff->username;
                            }else{
                                $username = $staff->user_nicename;
                            }
                            echo $username;
                        ?>
                    </div>
                    <div class="js-report-staff-email">
                        <?php
                            if($staff->email){
                                $email = $staff->email;
                            }else{
                                $email = $staff->user_email;
                            }
                            echo $email;
                        ?>
                    </div>
                </div>
            </div>
            <div class="js-col-md-8 nopadding js-festaffreport-data">
                <div class="js-col-md-2 js-col-md-offset-1 js-admin-report-box box1">
                    <span class="js-report-box-number"><?php echo $staff->openticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box2">
                    <span class="js-report-box-number"><?php echo $staff->answeredticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box3">
                    <span class="js-report-box-number"><?php echo $staff->pendingticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box4">
                    <span class="js-report-box-number"><?php echo $staff->overdueticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box5">
                    <span class="js-report-box-number"><?php echo $staff->closeticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Closed','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
            </div>
        </div>
    <?php
    } ?>
<?php
    if(!empty(jssupportticket::$_data['staff_tickets'])){ ?>
        <h1 class="js-ticket-heading jssetfontsize"><?php echo __("Tickets", 'js-support-ticket') ?></h1>

        <table class="js-admin-report-tickets">
            <tr>
                <th width="60%"><?php echo __('Subject','js-support-ticket'); ?></th>
                <th><?php echo __('Status','js-support-ticket'); ?></th>
                <th><?php echo __('Priority','js-support-ticket'); ?></th>
                <th><?php echo __('Created','js-support-ticket'); ?></th>
            </tr>
        <?php
        foreach(jssupportticket::$_data['staff_tickets'] AS $ticket){ ?>
            <tr>
                <td class="overflow"><a target="_blank" href="<?php echo site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=ticketdetail&jssupportticketid='.$ticket->id); ?>"><?php echo $ticket->subject; ?></a></td>
                <td >
                    <?php 
                        // 0 -> New Ticket
                        // 1 -> Waiting admin/staff reply
                        // 2 -> in progress
                        // 3 -> waiting for customer reply
                        // 4 -> close ticket
                        switch($ticket->status){
                            case 0:
                                $status = '<font color="#1EADD8">'.__('New','js-support-ticket').'</font>';
                                if($ticket->isoverdue == 1)
                                    $status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
                            break;
                            case 1:
                                $status = '<font color="#D98E11">'.__('Pending','js-support-ticket').'</font>';
                                if($ticket->isoverdue == 1)
                                    $status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
                            break;
                            case 2:
                                $status = '<font color="#D98E11">'.__('In Progress','js-support-ticket').'</font>';
                                if($ticket->isoverdue == 1)
                                    $status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
                            break;
                            case 3:
                                $status = '<font color="#179650">'.__('Answered','js-support-ticket').'</font>';
                                if($ticket->isoverdue == 1)
                                    $status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
                            break;
                            case 4:
                                $status = '<font color="#5F3BBB">'.__('Closed','js-support-ticket').'</font>';
                            break;
                        } 
                        echo $status;
                    ?>
                </td>
                <td style="color:<?php echo $ticket->prioritycolour; ?>;"><?php echo $ticket->priority; ?></td>
                <td ><?php echo date_i18n('Y-m-d',strtotime($ticket->created)); ?></td>
            </tr>
        <?php
        } ?>
        </table>
        <?php       
        if (jssupportticket::$_data[1]) {
            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
        }
    }
    ?>
    <!-- END admin -->
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=reports&jstlay=staffreports');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>