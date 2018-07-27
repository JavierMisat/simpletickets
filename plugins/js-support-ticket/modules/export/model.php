<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTExportModel {


    private function getOverallExportData(){

        //Overall Data by status
        $result = '';
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '')";
        $result['bystatus']['openticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4";
        $result['bystatus']['closeticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0";
        $result['bystatus']['answeredticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4";
        $result['bystatus']['overdueticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '')";
        $result['bystatus']['pendingticket'] = jssupportticket::$_db->get_var($query);

        //Overall tickets by departments
        $query = "SELECT dept.departmentname,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE departmentid = dept.id) AS totalticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_departments` AS dept";
        $result['bydepartments'] = jssupportticket::$_db->get_results($query);

        //Overall tickets by prioritys
        $query = "SELECT priority.priority,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE priorityid = priority.id) AS totalticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority";
        $result['bypriority'] = jssupportticket::$_db->get_results($query);

        //Overall tickets by medium
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketviaemail = 1";
        $result['bymedium']['ticketviaemail'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketviaemail = 0";
        $result['bymedium']['directticket'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_replies` WHERE ticketviaemail = 1";
        $result['bymedium']['replyviaemail'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_replies` WHERE ticketviaemail = 0";
        $result['bymedium']['directreply'] = jssupportticket::$_db->get_var($query);

        //Overall tickets by staffmembers
        $query = "SELECT CONCAT(staff.firstname,' ',staff.lastname) AS name ,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE staffid = staff.id) AS totalticket 
                    FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff";
        $result['bystaff'] = jssupportticket::$_db->get_results($query);

        return $result;
    }

    function setOverallExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getOverallExportData();
        if(empty($result))
            return null;
        // by staus
        $data = '';
        $data = __('JS Support Ticket Overall Reports', 'js-support-ticket').$nl.$nl;
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$result['bystatus']['openticket'].'"'.$tb.'"'.$result['bystatus']['answeredticket'].'"'.$tb.'"'.$result['bystatus']['closeticket'].'"'.$tb.'"'.$result['bystatus']['pendingticket'].'"'.$tb.'"'.$result['bystatus']['overdueticket'].'"'.$nl.$nl.$nl;
        // by dep
        $data .= __('Tickets By Departments', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bydepartments'])){
            foreach ($result['bydepartments'] as $key) {
                $data .= __($key->departmentname,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bydepartments'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
            $data .= $nl.$nl.$nl;
        }
        // by pri
        $data .= __('Tickets By Priorities', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bypriority'])){
            foreach ($result['bypriority'] as $key) {
                $data .= __($key->priority,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bypriority'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
            $data .= $nl.$nl.$nl;
        }
        // by channel
        $data .= __('Tickets By Channel', 'js-support-ticket').$nl.$nl;
        $data .= __('Direct', 'js-support-ticket').$tb.__('Direct reply', 'js-support-ticket').$tb.__('Email', 'js-support-ticket').$tb.__('Email reply', 'js-support-ticket').$nl;
        $data .= '"'.$result['bymedium']['directticket'].'"'.$tb.'"'.$result['bymedium']['directreply'].'"'.$tb.'"'.$result['bymedium']['ticketviaemail'].'"'.$tb.'"'.$result['bymedium']['replyviaemail'].'"'.$nl.$nl.$nl;
        // by staff
        $data .= __('Tickets By staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bystaff'])){
            foreach ($result['bystaff'] as $key) {
                $data .= __($key->name,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bystaff'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
        }
        return $data;
    }

    private function getStaffExportData(){

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $uid = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if($uid)
            if(! is_numeric($uid))
                return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['uid'] = $uid;

        $staffid = JSSTincluder::getJSModel('staff')->getStaffId($uid);
        $result['name'] = JSSTincluder::getJSModel('staff')->getMyName($staffid);

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT staff.photo,staff.id,staff.firstname,staff.lastname,staff.username,staff.email,user.display_name,user.user_email,user.user_nicename,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS openticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS closeticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS answeredticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS overdueticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS pendingticket 
                    FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff 
                    JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.id = staff.uid";
        if($uid) $query .= ' WHERE staff.uid = '.$uid;

        $staffs = jssupportticket::$_db->get_results($query);
        $result['staffs'] = $staffs;
        return $result;
    }
    
    function setStaffMemberExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getStaffExportData();
        if(empty($result))
            return '';
        
        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        if($result['uid']){
            $data = __('Report By', 'js-support-ticket').' '.$result['name'].' '.__('staff member', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.'-'.__('To', 'js-support-ticket').' '.$todate.$nl.$nl;
        }else{
            $data = __('Report By Staff Members', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.'-'.__('To', 'js-support-ticket').' '.$todate.$nl.$nl;
        }

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month
        
        // by staus
        $openticket = count($result['openticket']);
        $closeticket = count($result['closeticket']);
        $answeredticket = count($result['answeredticket']);
        $overdueticket = count($result['overdueticket']);
        $pendingticket = count($result['pendingticket']);
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl.$nl.$nl;
        
        // by staffs
        $data .= __('Tickets Staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['staffs'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            foreach ($result['staffs'] as $key) {
                if($key->firstname && $key->lastname){
                    $staffname = $key->firstname . ' ' . $key->lastname;
                }else{
                    $staffname = $key->display_name;
                }
                if($key->username){
                    $username = $key->username;
                }else{
                    $username = $key->user_nicename;
                }
                if($key->email){
                    $email = $key->email;
                }else{
                    $email = $key->user_email;
                }
                $data .= '"'.$staffname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getStaffExportDataByStaffId(){
        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $id = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
            
        if(! is_numeric($id))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['id'] = $id;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT staff.photo,staff.id,staff.firstname,staff.lastname,staff.username,staff.email,user.display_name,user.user_email,user.user_nicename,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS openticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS closeticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS answeredticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS overdueticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS pendingticket 
                    FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff 
                    JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.id = staff.uid 
                    WHERE staff.id = ".$id;
        $staff = jssupportticket::$_db->get_row($query);
        $result['staffs'] = $staff;
        //Tickets
        $query = "SELECT ticket.*,priority.priority, priority.prioritycolour 
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket 
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority ON priority.id = ticket.priorityid                     
                    WHERE staffid = ".$id." AND date(ticket.created) >= '" . $curdate . "' AND date(ticket.created) <= '" . $fromdate . "' ";
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        return $result;
    }

    function setStaffMemberExportByStaffId(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getStaffExportDataByStaffId();
        if(empty($result))
            return '';
        
        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        
        $data = __('Report By staff member', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month
        
        // by staffs
        $data .= __('Tickets Staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['staffs'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            $key = $result['staffs'];
            if($key->firstname && $key->lastname){
                $staffname = $key->firstname . ' ' . $key->lastname;
            }else{
                $staffname = $key->display_name;
            }
            if($key->username){
                $username = $key->username;
            }else{
                $username = $key->user_nicename;
            }
            if($key->email){
                $email = $key->email;
            }else{
                $email = $key->user_email;
            }
            $data .= '"'.$staffname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
        
            $data .= $nl.$nl.$nl;
        }
        
        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $data .= __('Subject', 'js-support-ticket').$tb.__('Status', 'js-support-ticket').$tb.__('Priority', 'js-support-ticket').$tb.__('Created', 'js-support-ticket').$nl;
            $status = '';
            foreach ($result['tickets'] as $ticket) {
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d',strtotime($ticket->created));
                $data .= '"'.$ticket->subject.'"'.$tb.'"'.$status.'"'.$tb.'"'.$ticket->priority.'"'.$tb.'"'.$created.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getUsersExportData(){

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $uid = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if($uid)
            if(! is_numeric($uid))
                return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['uid'] = $uid;

        $result['username'] = JSSTincluder::getJSModel('staff')->getUserNameById($uid);

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0  AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['openticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT user.display_name,user.user_email,user.user_nicename,user.id,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS openticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS closeticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS answeredticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS overdueticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS pendingticket 
                    FROM `".jssupportticket::$_wpprefixforuser."users` AS user 
                    WHERE NOT EXISTS (SELECT id FROM `".jssupportticket::$_db->prefix."js_ticket_staff` WHERE uid = user.id) 
                    AND NOT EXISTS (SELECT umeta_id FROM `".jssupportticket::$_wpprefixforuser."usermeta` WHERE user_id = user.id AND meta_value LIKE '%administrator%')";
        if($uid) $query .= " AND user.id = ".$uid;
        $users = jssupportticket::$_db->get_results($query);
        $result['users'] = $users;
        return $result;
    }

    function setUsersExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getUsersExportData();
        if(empty($result))
            return '';
        
        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        if($result['uid']){
            $data = __('User report', 'js-support-ticket').' '.$result['username'].' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;
        }else{
            $data = __('Users report', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;
        }

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month
        
        // by staus
        $openticket = count($result['openticket']);
        $closeticket = count($result['closeticket']);
        $answeredticket = count($result['answeredticket']);
        $overdueticket = count($result['overdueticket']);
        $pendingticket = count($result['pendingticket']);
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl.$nl.$nl;
        
        // by staffs
        $data .= __('Users tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['users'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            foreach ($result['users'] as $key) {
                $name = $key->display_name;
                $username = $key->user_nicename;
                $email = $key->user_email;

                $data .= '"'.$name.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getUserDetailReportByUserId(){
        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $id = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if(! is_numeric($id))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['id'] = $id;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);
        //user detail
        $query = "SELECT user.display_name,user.user_email,user.user_nicename,user.id,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0  AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS openticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS closeticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS answeredticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS overdueticket, 
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND isoverdue = 1 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS pendingticket 
                    FROM `".jssupportticket::$_wpprefixforuser."users` AS user 
                    WHERE user.id = ".$id;
        $user = jssupportticket::$_db->get_row($query);
        $result['users'] = $user;
        //Tickets
        $query = "SELECT ticket.*,priority.priority, priority.prioritycolour 
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket 
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority ON priority.id = ticket.priorityid                     
                    WHERE uid = ".$id." AND date(ticket.created) >= '" . $curdate . "' AND date(ticket.created) <= '" . $fromdate . "' ";
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        return $result;
    }

    function setUserExportByuid(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getUserDetailReportByUserId();
        if(empty($result))
            return '';
        
        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        
        $data = __('User Report', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month
        
        // by staffs
        $data .= __('Users Ticekts', 'js-support-ticket').$nl.$nl;
        if(!empty($result['users'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            $key = $result['users'];
            $staffname = $key->display_name;
            $username = $key->user_nicename;
            $email = $key->user_email;

            $data .= '"'.$staffname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
        
            $data .= $nl.$nl.$nl;
        }
        
        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $data .= __('Subject', 'js-support-ticket').$tb.__('Status', 'js-support-ticket').$tb.__('Priority', 'js-support-ticket').$tb.__('Created', 'js-support-ticket').$nl;
            $status = '';
            foreach ($result['tickets'] as $ticket) {
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d',strtotime($ticket->created));
                $data .= '"'.$ticket->subject.'"'.$tb.'"'.$status.'"'.$tb.'"'.$ticket->priority.'"'.$tb.'"'.$created.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }
}
?>