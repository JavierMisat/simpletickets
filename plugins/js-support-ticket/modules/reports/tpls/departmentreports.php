<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) { ?>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>                
    <script type="text/javascript">
        //google.load("visualization", "1", {packages:["corechart"]});
        <?php
        if(!empty(jssupportticket::$_data['pie3d_chart1'])){ ?>
            google.setOnLoadCallback(drawPie3d1Chart);
            <?php
        }
        ?>
        function drawPie3d1Chart() {
            var data = google.visualization.arrayToDataTable([
              ['<?php echo __('Departments','js-support-ticket'); ?>', '<?php echo __('Tickets By Department','js-support-ticket'); ?>'],
              <?php echo jssupportticket::$_data['pie3d_chart1']; ?>
            ]);

            var options = {
              title: '<?php echo __('Ticket by departments','js-support-ticket'); ?>',
              chartArea :{width:450,height:350},
              pieHole:0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('pie3d_chart1'));
            chart.draw(data, options);
        }
    </script>

    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <h1 class="js-ticket-heading"><?php echo __("Department Reports", 'js-support-ticket') ?></h1>

    <div class="js-col-md-12">
        <div id="pie3d_chart1" style="height:400px;width:100%;">
        <?php
        if(empty(jssupportticket::$_data['pie3d_chart1'])){ ?>
            <div class="donut_chart" id="no_message"><?php echo __('No Data', 'js-support-ticket'); ?></div>
            <?php
        } ?>
        </div>
    </div>
    <?php
if(!empty(jssupportticket::$_data['departments_report'])){ ?>
    <h1 class="js-ticket-heading jssetfontsize js-department-margin"><?php echo __("Ticket Status By Departments", 'js-support-ticket') ?></h1>
<?php
    foreach(jssupportticket::$_data['departments_report'] AS $department){ ?>
        <div class="js-admin-staff-wrapper js-departmentlist">
            <div class="js-col-md-4 nopadding js-festaffreport-img">
                <div class="js-col-md-12 jsposition-reletive">
                    <div class="departmentname">
                        <?php
                            echo $department->departmentname;
                        ?>
                    </div>
                </div>
            </div>
            <div class="js-col-md-8 nopadding js-festaffreport-data">
                <div class="js-col-md-2 js-col-md-offset-1 js-admin-report-box box1">
                    <span class="js-report-box-number"><?php echo $department->openticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box2">
                    <span class="js-report-box-number"><?php echo $department->answeredticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box3">
                    <span class="js-report-box-number"><?php echo $department->pendingticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box4">
                    <span class="js-report-box-number"><?php echo $department->overdueticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
                <div class="js-col-md-2 js-admin-report-box box5">
                    <span class="js-report-box-number"><?php echo $department->closeticket; ?></span>
                    <span class="js-report-box-title"><?php echo __('Closed','js-support-ticket'); ?></span>
                    <div class="js-report-box-color"></div>
                </div>
            </div>
        </div>
    <?php
                        }
                        if (jssupportticket::$_data[1]) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                        }
                    }

                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=reports&jstlay=departmentreports');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>