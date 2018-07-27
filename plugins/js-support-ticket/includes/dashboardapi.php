<?php
/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function jssupportticket_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'jssupportticket_dashboard_widget',         // Widget slug.
                 jssupportticket::$_config['title'],         // Title.
                 'jssupportticket_dashboard_widget_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'jssupportticket_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function jssupportticket_dashboard_widget_function() {
	$tickets = JSSTincluder::getJSModel('ticket')->getLatestTicketForDashboard();
	if(!empty($tickets)){
		$allticket = '<div class="js-row js-nullmargin"><span class="js-admin-title color-black">'.__('Latest Tickets', 'js-support-ticket').'</span>
		<div class="js-ticket-admin-cp-tickets js-nullpadding">
		    <div class="js-row js-ticket-admin-cp-head color-blue js-ticket-admin-hide-head">
		        <div class="js-col-xs-12 js-col-md-7">'.__('Subject', 'js-support-ticket').'</div>
		        <div class="js-col-xs-12 js-col-md-3">'.__('From', 'js-support-ticket').'</div>
		        <div class="js-col-xs-12 js-col-md-2">'.__('Priority', 'js-support-ticket').'</div>
		    </div>';
		    foreach ($tickets AS $ticket):
		        $allticket .= '<div class="js-ticket-admin-cp-data">
		            				<div class="js-col-xs-12 js-col-md-7 js-admin-cp-text-elipses"><span class="js-ticket-admin-cp-showhide" >'.__('Subject', 'js-support-ticket')." : ".'</span> <a href="'.admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $ticket->id).'">'.$ticket->subject.'</a></div>
		            				<div class="js-col-xs-12 js-col-md-3"> <span class="js-ticket-admin-cp-showhide" >'.__('From', 'js-support-ticket')." : ".'</span> '.$ticket->name.'</div>
		            				<div class="js-col-xs-12 js-col-md-2" style="background:'.$ticket->prioritycolour.';color:#ffffff;"> <span class="js-ticket-admin-cp-showhide" >'.__('Priority', 'js-support-ticket')." : ".'</span>'.__($ticket->priority, 'js-support-ticket').'</div>
		        				</div>';
			endforeach;
		$allticket .= '</div></div>';
		echo $allticket;
	}else{
		JSSTlayout::getNoRecordFound();
	}
}


function jssupportticket_totalstats_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                'jssupportticket_totalstats_dashboard_widget',         // Widget slug.
                __('Last Month Ticket Stats','js-support-ticket'),         // Title.
                'jssupportticket_totalstats_dashboard_widget_function' // Display function.
    );	
}
add_action( 'wp_dashboard_setup', 'jssupportticket_totalstats_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function jssupportticket_totalstats_dashboard_widget_function() {
	$stats = JSSTincluder::getJSModel('ticket')->getTotalStatsForDashboard();
	if(!empty($stats)){
		$res = '
		<div id="js-total-count-cp-dashbordapi"> 
		    <a class="js-total-count-dashbordapi" href="'.admin_url("admin.php?page=ticket&jstlay=tickets").'">
		        <img class="img" src="'.jssupportticket::$_pluginpath.'/includes/images/admincp/new.png" />
		        <div class="data-dashbordapi">
		            <span class="jstotal-dashbordapi">'.$stats['open'].'</span>
		            <span class="jsstatus-dashbordapi">'.__('New','js-support-ticket').'</span>
		        </div>
		    </a>
		    <a class="js-total-count-dashbordapi" href="'.admin_url("admin.php?page=ticket&jstlay=tickets").'">
		        <img class="img" src="'.jssupportticket::$_pluginpath.'/includes/images/admincp/answered.png" />
		        <div class="data-dashbordapi">
		            <span class="jstotal-dashbordapi">'.$stats['answered'].'</span>
		            <span class="jsstatus-dashbordapi">'.__('Answered','js-support-ticket').'</span>
		        </div>
		    </a>
		    <a class="js-total-count-dashbordapi" href="'.admin_url("admin.php?page=ticket&jstlay=tickets").'">
		        <img class="img" src="'.jssupportticket::$_pluginpath.'/includes/images/admincp/pending.png" />
		        <div class="data-dashbordapi">
		            <span class="jstotal-dashbordapi">'.$stats['pending'].'</span>
		            <span class="jsstatus-dashbordapi">'.__('Pending','js-support-ticket').'</span>
		        </div>
		    </a>
		    <a class="js-total-count-dashbordapi" href="'.admin_url("admin.php?page=ticket&jstlay=tickets").'">
		        <img class="img" src="'.jssupportticket::$_pluginpath.'/includes/images/admincp/overdue.png" />
		        <div class="data-dashbordapi">
		            <span class="jstotal-dashbordapi">'.$stats['overdue'].'</span>
		            <span class="jsstatus-dashbordapi">'.__('Overdue','js-support-ticket').'</span>
		        </div>
		    </a>
		</div>';
		echo $res;
	}else{
		JSSTlayout::getNoRecordFound();
	}
}
?>