<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTticketModel {
    
    private $ticketid;
    
    function getTicketsForAdmin($list) {
        $this->getOrdering();
        // Filter
        $subject = trim(JSSTrequest::getVar('subject'));
        $name = trim(JSSTrequest::getVar('name'));
        $email = trim(JSSTrequest::getVar('email'));
        $ticketid = trim(JSSTrequest::getVar('ticketid'));
        $datestart = trim(JSSTrequest::getVar('datestart'));
        $dateend = trim(JSSTrequest::getVar('dateend'));
        $priority = trim(JSSTrequest::getVar('priority'));
        $departmentid = trim(JSSTrequest::getVar('departmentid'));
        $staffid = trim(JSSTrequest::getVar('staffid'));
        $sortby = trim(JSSTrequest::getVar('sortby'));
        $inquery = '';
        switch ($list) {
            // Ticket Default Status
            // 0 -> New Ticket
            // 1 -> Waiting admin/staff reply
            // 2 -> in progress
            // 3 -> waiting for customer reply
            // 4 -> close ticket
            case 1:$inquery .= " AND ticket.status != 4 ";
                break;
            case 2:$inquery .= " AND ticket.isanswered = 1 ";
                break;
            case 3:$inquery .= " AND ticket.isoverdue = 1 ";
                break;
            case 4:$inquery .= " AND ticket.status = 4 ";
                break;
            case 5://$inquery .= " AND ticket.uid =" . get_current_user_id();
                break;
        }
        $data = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
        $valarray = array();
        if (!empty($data)) {
            foreach ($data as $uf) {
                $valarray[$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                    switch ($uf->userfieldtype) {
                        case 'text':
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'file':
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'combo':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'depandant_field':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'radio':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'checkbox':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                $finalvalue .= $value.'.*';
                            }
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                            break;
                        case 'date':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'textarea':
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'multiple':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                if($value != null){
                                    $finalvalue .= $value.'.*';
                                }    
                            }
                            if($finalvalue !=''){
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                            }
                            break;
                    }
                    jssupportticket::$_data['filter']['params'] = $valarray;
                }
            }
        }
        //end
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
            $_SESSION['JSST_SEARCH']['name'] = $name;
            $_SESSION['JSST_SEARCH']['email'] = $email;
            $_SESSION['JSST_SEARCH']['ticketid'] = $ticketid;
            $_SESSION['JSST_SEARCH']['datestart'] = $datestart;
            $_SESSION['JSST_SEARCH']['dateend'] = $dateend;
            $_SESSION['JSST_SEARCH']['priority'] = $priority;
            $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
            $_SESSION['JSST_SEARCH']['staffid'] = $staffid;
            $_SESSION['JSST_SEARCH']['sortby'] = $sortby;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
            $name = (isset($_SESSION['JSST_SEARCH']['name']) && $_SESSION['JSST_SEARCH']['name'] != '') ? $_SESSION['JSST_SEARCH']['name'] : null;
            $email = (isset($_SESSION['JSST_SEARCH']['email']) && $_SESSION['JSST_SEARCH']['email'] != '') ? $_SESSION['JSST_SEARCH']['email'] : null;
            $ticketid = (isset($_SESSION['JSST_SEARCH']['ticketid']) && $_SESSION['JSST_SEARCH']['ticketid'] != '') ? $_SESSION['JSST_SEARCH']['ticketid'] : null;
            $datestart = (isset($_SESSION['JSST_SEARCH']['datestart']) && $_SESSION['JSST_SEARCH']['datestart'] != '') ? $_SESSION['JSST_SEARCH']['datestart'] : null;
            $dateend = (isset($_SESSION['JSST_SEARCH']['dateend']) && $_SESSION['JSST_SEARCH']['dateend'] != '') ? $_SESSION['JSST_SEARCH']['dateend'] : null;
            $priority = (isset($_SESSION['JSST_SEARCH']['priority']) && $_SESSION['JSST_SEARCH']['priority'] != '') ? $_SESSION['JSST_SEARCH']['priority'] : null;
            $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
            $staffid = (isset($_SESSION['JSST_SEARCH']['staffid']) && $_SESSION['JSST_SEARCH']['staffid'] != '') ? $_SESSION['JSST_SEARCH']['staffid'] : null;
            $sortby = (isset($_SESSION['JSST_SEARCH']['sortby']) && $_SESSION['JSST_SEARCH']['sortby'] != '') ? $_SESSION['JSST_SEARCH']['sortby'] : null;
        }

        if ($datestart != null) 
            $inquery .= " AND '$datestart' <= DATE(ticket.created)";
        if ($dateend != null) 
            $inquery .= " AND '$dateend' >= DATE(ticket.created)";
        if ($ticketid != null)
            $inquery .= " AND ticket.ticketid LIKE '%$ticketid%'";
        if ($subject != null)
            $inquery .= " AND ticket.subject LIKE '%$subject%'";
        if ($name != null)
            $inquery .= " AND ticket.name LIKE '%$name%'";
        if ($email != null)
            $inquery .= " AND ticket.email LIKE '%$email%'";
        if ($priority != null)
            $inquery .= " AND ticket.priorityid = $priority";
        if ($departmentid != null)
            $inquery .= " AND ticket.departmentid = $departmentid";
        if ($staffid != null)
            $inquery .= " AND ticket.staffid = $staffid";

        jssupportticket::$_data['filter']['subject'] = $subject;
        jssupportticket::$_data['filter']['ticketid'] = $ticketid;
        jssupportticket::$_data['filter']['name'] = $name;
        jssupportticket::$_data['filter']['email'] = $email;
        jssupportticket::$_data['filter']['datestart'] = $datestart;
        jssupportticket::$_data['filter']['dateend'] = $dateend;
        jssupportticket::$_data['filter']['priority'] = $priority;
        jssupportticket::$_data['filter']['departmentid'] = $departmentid;
        jssupportticket::$_data['filter']['staffid'] = $staffid;
        jssupportticket::$_data['filter']['sortby'] = $sortby;

        // Pagination
        $query = "SELECT COUNT(ticket.id) "
                . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                . "WHERE 1 = 1";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        /*
          list variable detail
          1=>For open ticket
          2=>For answered  ticket
          3=>For overdue ticket
          4=>For Closed tickets
          5=>For mytickets tickets
         */
        jssupportticket::$_data['list'] = $list; // assign for reference
        // Data
        $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour, staff.id AS staffid, staff.photo AS staffphoto
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = ticket.uid 
                    WHERE 1 = 1";
        $query .= $inquery;
        $query .= " ORDER BY " . jssupportticket::$_ordering . " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        // check email is bane 
        if (isset(jssupportticket::$_data[0]->email))
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = ' " . jssupportticket::$_data[0]->email . "'";
        jssupportticket::$_data[7] = jssupportticket::$_db->get_var($query);
        // echo "<pre>";print_r(jssupportticket::$_db);exit;
        //Hook action
        do_action('jsst-ticketbeforelisting', jssupportticket::$_data[0]);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if(jssupportticket::$_config['count_on_myticket'] == 1){
            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.status != 4";            
            jssupportticket::$_data['count']['openticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.isanswered = 1";            
            jssupportticket::$_data['count']['answeredticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.isoverdue = 1";            
            jssupportticket::$_data['count']['overdueticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.status = 4";            
            jssupportticket::$_data['count']['closedticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE 1 = 1";            
            jssupportticket::$_data['count']['allticket'] = jssupportticket::$_db->get_var($query);;
        }
        return;
    }

    function getOrdering() {
        $sort = JSSTrequest::getVar('sortby', '');
        if ($sort == '') {
            $list = JSSTrequest::getVar('list', null, 1);
            if ($list == 1)
                $sort = 'statusasc';
            elseif ($list == 2)
                $sort = 'createddesc';
            elseif ($list == 3)
                $sort = 'statusasc';
            elseif ($list == 4)
                $sort = 'createddesc';
            elseif ($list == 5)
                $sort = 'statusasc';
        }
        $this->getTicketListOrdering($sort);
        $this->getTicketListSorting($sort);
    }

    function combineOrSingleSearch() { 

        $ticketkeys = trim(JSSTrequest::getVar('jsst-ticketsearchkeys', 'post'));
        $sortby = trim(JSSTrequest::getVar('sortby'));
        jssupportticket::$_data['filter']['sortby'] = $sortby;
        $inquery = '';
        if ($ticketkeys) {
            if (strlen($ticketkeys) == 9)
                $inquery = " AND ticket.ticketid = '$ticketkeys'";
            else if (strpos($ticketkeys, '@') && strpos($ticketkeys, '.'))
                $inquery = " AND ticket.email LIKE '%$ticketkeys%'";
            else
                $inquery = " AND ticket.subject LIKE '%$ticketkeys%'";

            jssupportticket::$_data['filter']['ticketsearchkeys'] = $ticketkeys;
        }else {
            $ticketid = JSSTrequest::getVar('jsst-ticket', 'post');
            $from = JSSTrequest::getVar('jsst-from', 'post');
            $email = JSSTrequest::getVar('jsst-email', 'post');
            $departmentid = JSSTrequest::getVar('jsst-departmentid', 'post');
            $priorityid = JSSTrequest::getVar('jsst-priorityid', 'post');
            $subject = JSSTrequest::getVar('jsst-subject', 'post');
            $datestart = JSSTrequest::getVar('jsst-datestart', 'post');
            $dateend = JSSTrequest::getVar('jsst-dateend', 'post');
            $staffid = JSSTrequest::getVar('staffid', 'post');

            if ($ticketid != null) {
                $inquery .= " AND ticket.ticketid LIKE '$ticketid'";
                jssupportticket::$_data['filter']['ticketid'] = $ticketid;
            }
            if ($from != null) {
                $inquery .= " AND ticket.name LIKE '%$from%'";
                jssupportticket::$_data['filter']['from'] = $from;
            }
            if ($email != null) {
                $inquery .= " AND ticket.email LIKE '$email'";
                jssupportticket::$_data['filter']['email'] = $email;
            }
            if ($departmentid != null) {
                $inquery .= " AND ticket.departmentid = '$departmentid'";
                jssupportticket::$_data['filter']['departmentid'] = $departmentid;
            }
            if ($priorityid != null) {
                $inquery .= " AND ticket.priorityid = '$priorityid'";
                jssupportticket::$_data['filter']['priorityid'] = $priorityid;
            }
            if ($staffid != null) {
                $inquery .= " AND ticket.staffid = '$staffid'";
                jssupportticket::$_data['filter']['staffid'] = $staffid;
            }
            if ($subject != null) {
                $inquery .= " AND ticket.subject LIKE '%$subject%'";
                jssupportticket::$_data['filter']['subject'] = $subject;
            }
            if ($datestart != null) {
                $inquery .= " AND '$datestart' <= DATE(ticket.created)";
                jssupportticket::$_data['filter']['datestart'] = $datestart;
            }
            if ($dateend != null) {
                $inquery .= " AND '$dateend' >= DATE(ticket.created)";
                jssupportticket::$_data['filter']['dateend'] = $dateend;
            }
            //Custom field search


            //start
            $data = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
            $valarray = array();
            if (!empty($data)) {
                foreach ($data as $uf) {
                    $valarray[$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                    if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                        switch ($uf->userfieldtype) {
                            case 'text':
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'combo':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'depandant_field':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'radio':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'checkbox':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    $finalvalue .= $value.'.*';
                                }
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                                break;
                            case 'date':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'textarea':
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'multiple':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    if($value != null){
                                        $finalvalue .= $value.'.*';
                                    }    
                                }
                                if($finalvalue !=''){
                                    $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                                }
                                break;
                        }
                        jssupportticket::$_data['filter']['params'] = $valarray;
                    }
                }
            }
            //end

            if ($inquery == '')
                jssupportticket::$_data['filter']['combinesearch'] = false;
            else
                jssupportticket::$_data['filter']['combinesearch'] = true;
        }

        return $inquery;
    }

    function getMyTickets() {
        $this->getOrdering();
        // Filter
        /*
          list variable detail
          1=>For open ticket
          2=>For closed ticket
          3=>For open answered ticket
          4=>For all my tickets
         */
        $inquery = $this->combineOrSingleSearch();

        $list = JSSTrequest::getVar('list', null, 1);
        jssupportticket::$_data['list'] = $list; // assign for reference
        switch ($list) {
            // Ticket Default Status
            // 0 -> New Ticket
            // 1 -> Waiting admin/staff reply
            // 2 -> in progress
            // 3 -> waiting for customer reply
            // 4 -> close ticket
            case 1:$inquery .= " AND ticket.status != 4 ";
                break;
            case 2:$inquery .= " AND ticket.status = 4 ";
                break;
            case 3:$inquery .= " AND ticket.status = 3 ";
                break;
            case 4:$inquery .= " ";
                break;
        }

        $uid = get_current_user_id();
        if ($uid) {
            // Pagination
            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE ticket.uid = $uid ";
            $query .= $inquery;
            $total = jssupportticket::$_db->get_var($query);
            jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

            // Data
            $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id";
            $query .= " WHERE ticket.uid = $uid " . $inquery;
            $query .= " ORDER BY " . jssupportticket::$_ordering . " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
            jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            if(jssupportticket::$_config['count_on_myticket'] == 1){
                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status != 4";            
                jssupportticket::$_data['count']['openticket'] = jssupportticket::$_db->get_var($query);;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status = 3";            
                jssupportticket::$_data['count']['answeredticket'] = jssupportticket::$_db->get_var($query);;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status = 4";            
                jssupportticket::$_data['count']['closedticket'] = jssupportticket::$_db->get_var($query);;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid";            
                jssupportticket::$_data['count']['allticket'] = jssupportticket::$_db->get_var($query);;
            }
        }        
        return;
    }

    function getStaffTickets() {
        $this->getOrdering();
        // Filter
        /*
          list variable detail
          1=>For open ticket
          2=>For closed ticket
          3=>For open answered ticket
          4=>For all my tickets
         */

        $inquery = $this->combineOrSingleSearch();
        $list = JSSTrequest::getVar('list', null, 1);
        jssupportticket::$_data['list'] = $list; // assign for reference
        switch ($list) {
            // Ticket Default Status
            // 0 -> Open Ticket
            // 1 -> Waiting admin/staff reply
            // 2 -> in progress
            // 3 -> waiting for customer reply
            // 4 -> close ticket
            case 1:$inquery .= " AND ticket.status != 4 ";
                break;
            case 2:$inquery .= " AND ticket.status = 4 ";
                break;
            case 3:$inquery .= " AND ticket.status = 3 ";
                break;
            case 4:$inquery .= " ";
                break;
            case 5:$inquery .= " AND ticket.isoverdue = 1 ";
                break;
        }

        $uid = get_current_user_id();
        if ($uid == 0)
            return false;
        $staffid = JSSTincluder::getJSModel('staff')->getStaffId($uid);
        // Pagination
        $query = "SELECT COUNT(ticket.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT DISTINCT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour,staff.photo AS staffphoto,staff.id AS staffid
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = ticket.uid
                    WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) " . $inquery;
        $query .= " ORDER BY " . jssupportticket::$_ordering . " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if(jssupportticket::$_config['count_on_myticket'] == 1){
            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) AND ticket.status != 4";
            jssupportticket::$_data['count']['openticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) AND ticket.status = 3";
            jssupportticket::$_data['count']['answeredticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) AND ticket.status = 4";
            jssupportticket::$_data['count']['closedticket'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) AND ticket.isoverdue = 1";
            jssupportticket::$_data['count']['overdue'] = jssupportticket::$_db->get_var($query);;

            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) ";
            jssupportticket::$_data['count']['allticket'] = jssupportticket::$_db->get_var($query);;
        }
        return;
    }

    function getTicketsForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour,user.user_login
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        LEFT JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.ID = ticket.uid 
                        WHERE ticket.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        JSSTincluder::getJSModel('attachment')->getAttachmentForForm($id);
        JSSTincluder::getJSModel('fieldordering')->getFieldsOrderingforForm(1);
        return;
    }

    function getTicketForDetail($id) {
        if (!is_numeric($id))
            return $id;
        if (jssupportticket::$_data['user_staff']) { //staff
            if(current_user_can('manage_options'))
                jssupportticket::$_data['permission_granted'] = true;
            else
                jssupportticket::$_data['permission_granted'] = $this->validateTicketDetailForStaff($id);
        } else { // user
            if(current_user_can('manage_options'))
                jssupportticket::$_data['permission_granted'] = true;
            elseif (is_user_logged_in())
                jssupportticket::$_data['permission_granted'] = $this->validateTicketDetailForUser($id);
            else
                jssupportticket::$_data['permission_granted'] = $this->validateTicketDetailForVisitor($id);
        }
        if (!jssupportticket::$_data['permission_granted']) { // validation failed
            return;
        }

        $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour,
                    helptopic.topic AS helptopic ,CONCAT(staff.firstname ,'  ' ,staff.lastname) AS staffname, staff.id AS staffid, staff.photo AS staffphoto, staffphoto.photo AS staffphotophoto,staffphoto.id AS staffphotoid
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic ON ticket.helptopicid = helptopic.id
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staffphoto ON ticket.uid = staffphoto.uid
                    WHERE ticket.id = " . $id;
        jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
        // check email is ban  
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = '" . jssupportticket::$_data[0]->email . "'";
        jssupportticket::$_data[7] = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        JSSTincluder::getJSModel('note')->getNotes($id);
        JSSTincluder::getJSModel('reply')->getReplies($id);
        jssupportticket::$_data['ticket_attachment'] = JSSTincluder::getJSModel('attachment')->getAttachmentForReply($id, 0);
        $this->getTicketHistory($id);
        //Hooks
        do_action('jsst-ticketbeforeview', jssupportticket::$_data);

        return;
    }

    function validateUserForTicket($id) {
        if (is_user_logged_in()) {
            
        } else {
            jssupportticket::$_data['permission_granted'] = $this->checkTokenForTicketDetail($id);
        }
        return;
    }

    function getRandomTicketId() {
        $query = "SELECT ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
        do {
            $ticketid = "";
            $length = 9;
            $sequence = jssupportticket::$_config['ticketid_sequence'];
            if($sequence == 1){
                $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
                // we refer to the length of $possible a few times, so let's grab it now
                $maxlength = strlen($possible);
                if ($length > $maxlength) { // check for length overflow and truncate if necessary
                    $length = $maxlength;
                }
                // set up a counter for how many characters are in the ticketid so far
                $i = 0;
                // add random characters to $password until $length is reached
                while ($i < $length) {
                    // pick a random character from the possible ones
                    $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                    if (!strstr($ticketid, $char)) {
                        if ($i == 0) {
                            if (ctype_alpha($char)) {
                                $ticketid .= $char;
                                $i++;
                            }
                        } else {
                            $ticketid .= $char;
                            $i++;
                        }
                    }
                }
            }else{ // Sequential ticketid
                if($ticketid == ""){
                    $ticketid = 0; // by default its set to zero                    
                }
                $maxquery = "SELECT max(convert(ticketid, SIGNED INTEGER)) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
                
                $maxticketid = jssupportticket::$_db->get_var($maxquery);
                if(is_numeric($maxticketid)){
                    $ticketid = $maxticketid + 1;
                }else{
                    $ticketid = $ticketid + 1;
                }
            }
            $rows = jssupportticket::$_db->get_results($query);
                foreach ($rows as $row) {
                    if ($ticketid == $row->ticketid)
                        $match = 'Y';
                    else
                        $match = 'N';
                }
        }while ($match == 'Y');
        return $ticketid;
    }

    function countTicket($emailorid) {
        if (is_numeric($emailorid)) { // its UserID
            $counts = jssupportticket::$_db->get_var("SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . $emailorid);
        } else { // its EmailAddress
            $counts = jssupportticket::$_db->get_var("SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailorid . "'");
        }
        return $counts;
    }

    function countOpenTicket($emailorid) {
        if (is_numeric($emailorid)) { // its UserID
            $counts = jssupportticket::$_db->get_var("SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . $emailorid . " AND status != 4");
        } else { // its EmailAddress
            $counts = jssupportticket::$_db->get_var("SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailorid . "' AND status != 4");
        }
        return $counts;
    }

    function checkBannedEmail($emailaddress) {
        $counts = jssupportticket::$_db->get_var("SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = '" . $emailaddress . "'");
        if ($counts > 0) {
            $data['loggeremail'] = $emailaddress;
            $data['title'] = __('Ban Email', 'js-support-ticket');
            $data['log'] = __('Ban email try to create ticket', 'js-support-ticket');
            $current_user = wp_get_current_user(); // to get current user name
            $currentUserName = $current_user->display_name;
            $data['logger'] = $currentUserName;
            $data['ipaddress'] = $this->getIpAddress();
            JSSTincluder::getJSModel('banemaillog')->storebanemaillog($data);
            JSSTmessage::setMessage(__('Banned email cannot create ticket', 'js-support-ticket'), 'error');
            return false;
        }
        return true;
    }

    function getIpAddress() {
        //if client use the direct ip
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function checkMaxTickets($emailaddress) {
        if (is_user_logged_in()) {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . get_current_user_id();
        } else {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "'";
        }
        $counts = jssupportticket::$_db->get_var($query);
        if ($counts >= jssupportticket::$_config['maximum_tickets']) {
            JSSTmessage::setMessage(__('Limit exceeds maximum tickets', 'js-support-ticket'), 'error');
            return false;
        }
        return true;
    }

    function checkMaxOpenTickets($emailaddress) {
        if (is_user_logged_in()) {
            $uid = get_current_user_id();
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . $uid . " AND status != 4";
        } else {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND status != 4";
        }
        $counts = jssupportticket::$_db->get_var($query);
        if ($counts >= jssupportticket::$_config['maximum_open_tickets']) {
            JSSTmessage::setMessage(__('Limit exceeds maximum open tickets', 'js-support-ticket'), 'error');
            return false;
        }
        return true;
    }

    function ticketValidate($emailaddress) {
        //check the banned user / email
        if (!$this->checkBannedEmail($emailaddress)) {
            return false;
        }
        //check the Maximum Tickets 
        if (!$this->checkMaxTickets($emailaddress)) {
            return false;
        }
        //check the Maximum Open Tickets 
        if (!$this->checkMaxOpenTickets($emailaddress)) {
            return false;
        }
        return true;
    }

    function captchaValidate() {
        if (!is_user_logged_in()) {
            if (jssupportticket::$_config['show_captcha_on_visitor_from_ticket'] == 1) {
                if (jssupportticket::$_config['captcha_selection'] == 1) { // Google recaptcha
                    $gresponse = $_POST['g-recaptcha-response'];
                    $resp = googleRecaptchaHTTPPost(jssupportticket::$_config['recaptcha_privatekey'],$gresponse);

                    if ($resp == true) {
                        return true;
                    } else {
                        # set the error code so that we can display it
                        JSSTmessage::setMessage(__('Incorrect Captcha code', 'js-support-ticket'), 'error');
                        return false;
                    }
                } else { // own captcha
                    $captcha = new JSSTcaptcha;
                    $result = $captcha->checkCaptchaUserForm();
                    if ($result == 1) {
                        return true;
                    } else {
                        JSSTmessage::setMessage(__('Incorrect Captcha code', 'js-support-ticket'), 'error');
                        return false;
                    }
                }
            }
        }
		return true;
    }

    function storeTickets($data) {
        if (!is_admin() && $data['ticketviaemail'] != 1) { //if not admin
            if (!$this->captchaValidate()) {
                //JSSTmessage::setMessage(__('Incorrect Captcha code', 'js-support-ticket'), 'error');
                return 2;
            }
            if (!$this->ticketValidate($data['email'])) {
                return 3;
            }
        }
        $sendEmail = true;
        if ($data['id']) {
            $sendEmail = false;
            $updated = date_i18n('Y-m-d H:i:s');
            $created = $data['created'];
            if ($data['isoverdue'] == 1) {// for edit case to change the overdue if criteria is passed
                $curdate = date_i18n('Y-m-d H:i:s');
                if (date_i18n('Y-m-d',strtotime($data['duedate'])) > date_i18n('Y-m-d',strtotime($curdate))){
                    $data['isoverdue'] = 0;
                }else{
                    $query = "SELECT ticket.duedate FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket WHERE ticket.id = ".$data['id'];
                    $duedate = jssupportticket::$_db->get_var($query);
                    if(date_i18n('Y-m-d',strtotime($data['duedate'])) != date_i18n('Y-m-d',strtotime($duedate))){
                        JSSTticketModel::setMessage(__('Due date error is not valid','js-support-ticket'),'error');
                        return; //Due Date must be greater then current date
                    }
                }
            }

        } else {
            $data['ticketid'] = $this->getRandomTicketId();
            $data['attachmentdir'] = $this->getRandomFolderName();
            $created = date_i18n('Y-m-d H:i:s');
            $updated = '';
        }
        if(isset($data['assigntome']) && $data['assigntome'] == 1){
            $uid = get_current_user_id();
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId($uid);
            $data['staffid'] = $staffid;
        }else{
            $data['staffid'] = isset($data['staffid']) ? $data['staffid'] : '';
        }
        $data['status'] = isset($data['status']) ? $data['status'] : '';
        $data['duedate'] = isset($data['duedate']) ? $data['duedate'] : '';
        $data['lastreply'] = isset($data['lastreply']) ? $data['lastreply'] : '';
        $data['ticketviaemail'] = isset($data['ticketviaemail']) ? $data['ticketviaemail'] : 0;
        $data['message'] = wpautop(wptexturize(stripslashes($data['jsticket_message']))); // use jsticket_message to avoid conflict
        if(empty($data['message'])){
            JSSTmessage::setMessage(__('Message field cannot be empty', 'js-support-ticket'), 'error');
            return false;
        }
//custom field code start
        $customflagforadd = false;
        $customflagfordelete = false;
        $custom_field_namesforadd = array();
        $custom_field_namesfordelete = array();
        $userfield = JSSTincluder::getJSModel('fieldordering')->getUserfieldsfor(1);
        $params = '';
        $maxfilesizeallowed = jssupportticket::$_config['file_maximum_size'];        
        foreach ($userfield AS $ufobj) {
            $vardata = '';
            if($ufobj->userfieldtype == 'file'){
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1']== 0){
                    $vardata = $data[$ufobj->field.'_2'];
                }else{
                    $uploadfilesize = $_FILES[$ufobj->field]['size'] / 1024; //kb
                    if($uploadfilesize <= $maxfilesizeallowed){
                        $filetyperesult = '';
                        $filetyperesult = wp_check_filetype($_FILES[$ufobj->field]['name']);
                        if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                            $image_file_types = JSSTincluder::getJSModel('configuration')->getConfigValue('file_extension');
                            if(strstr($image_file_types, $filetyperesult['ext'])){
                                $vardata = sanitize_file_name($_FILES[$ufobj->field]['name']);
                            }
                        }
                    }
                }
                $customflagforadd=true;
                $custom_field_namesforadd[]=$ufobj->field;
            }else{
                $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            }
            if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                $customflagfordelete = true;
                $custom_field_namesfordelete[]= $data[$ufobj->field.'_2'];
                }
            if($vardata != ''){

                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$ufobj->field] = htmlspecialchars($vardata);
            }
        }

        if($data['id'] != ''){
            if(is_numeric($data['id'])){
                $query = "SELECT params FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $data['id'];
                $oParams = jssupportticket::$_db->get_var($query);

                if(!empty($oParams)){
                    $oParams = json_decode($oParams,true);
                    $unpublihsedFields = JSSTincluder::getJSModel('fieldordering')->getUserUnpublishFieldsfor(1);
                    foreach($unpublihsedFields AS $field){
                        if(isset($oParams[$field->field])){
                            $params[$field->field] = $oParams[$field->field];
                        }
                    }
                }
            }
        }

        if (!empty($params)) {
            $params = json_encode($params);
        }
        $data['params'] = $params;
//custom field code end
        $query_array = array('id' => $data['id'],
            'email' => $data['email'],
            'name' => $data['name'],
            'uid' => $data['uid'],
            'phone' => $data['phone'],
            'phoneext' => $data['phoneext'],
            'departmentid' => $data['departmentid'],
            'priorityid' => $data['priorityid'],
            'subject' => $data['subject'],
            'staffid' => $data['staffid'],
            'helptopicid' => $data['helptopicid'],
            'message' => $data['message'],
            'status' => $data['status'],
            'duedate' => $data['duedate'],
            'lastreply' => $data['lastreply'],
            'attachmentdir' => $data['attachmentdir'],
            'created' => $created,
            'ticketviaemail' => $data['ticketviaemail'],
            'updated' => $updated,
            'params' => $data['params'],
            'ticketid' => $data['ticketid']
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_tickets', $query_array);
        $ticketid = jssupportticket::$_db->insert_id; // get the ticket id
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
            JSSTmessage::setMessage(__('Ticket has not been stored', 'js-support-ticket'), 'error');
        } else {
            $messagetype = __('Successfully', 'js-support-ticket');
            
            // Storing Attachments
            $data['ticketid'] = $ticketid;
            JSSTincluder::getJSModel('attachment')->storeAttachments($data);
            JSSTmessage::setMessage(__('Ticket has been stored', 'js-support-ticket'), 'updated');

            //removing custom field attachments
            if($customflagfordelete == true){
                foreach ($custom_field_namesforadd as $key) {
                    $res = $this->removeFileCustom($ticketid,$key);
                }
            }
            //storing custom field attachments
            if($customflagforadd == true){
                foreach ($custom_field_namesforadd as $key) {
                    if ($_FILES[$key]['size'] > 0) { // logo
                        $res = $this->uploadFileCustom($ticketid,$key);
                    }
                }
            }
        }

        /* for activity log */
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user(); // to get current user name
            $currentUserName = $current_user->display_name;
        }else{
            $currentUserName = __('Guest','js-support-ticket');
        }
        $eventtype = __('New ticket', 'js-support-ticket');
        if ($data['id']) {
            $message = __('Ticket is updated by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        } else {
            $message = __('Ticket is created by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        }
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 1, $ticketid); // Mailfor, Create Ticket, Ticketid
            //For Hook
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketcreate', $ticketobject);
        }
        /* to store internal notes */

        if (isset($data['internalnote']) && $data['internalnote'] != '') {
            JSSTincluder::getJSModel('note')->storeTicketInternalNote($data, $data['internalnote']);
        }
        return $ticketid;
    }

    function uploadFileCustom($id,$field){
        JSSTincluder::getObjectClass('uploads')->storeTicketCustomUploadFile($id,$field);
    }

    function removeTicket($id) {
        $sendEmail = true;
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Ticket');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }

        if ($this->canRemoveTicket($id)) {
            jssupportticket::$_data['ticketid'] = $this->getTrackingIdById($id);
            jssupportticket::$_data['ticketemail'] = $this->getTicketEmailById($id);
            jssupportticket::$_data['staffid'] = $this->getStaffIdById($id);
            jssupportticket::$_data['ticketsubject'] = $this->getTicketSubjectById($id);
            // delete attachments
            $this->removeTicketAttachmentsByTicketid($id);
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_tickets', array('id' => $id));

            if (jssupportticket::$_db->last_error == null) {
                $messagetype = __('Successfully', 'js-support-ticket');
                JSSTmessage::setMessage(__('Ticket has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Ticket has not been deleted', 'js-support-ticket'), 'error');
                $messagetype = __('Error', 'js-support-ticket');
                $sendEmail = false;
            }

            // Send Emails
            if ($sendEmail == true) {
                JSSTincluder::getJSModel('email')->sendMail(1, 3); // Mailfor, Delete Ticket
                $ticketobject = (object) array('ticketid' => jssupportticket::$_data['ticketid'], 'ticketemail' => jssupportticket::$_data['ticketemail']);
                do_action('jsst-ticketdelete', $ticketobject);
            }
            // delete internal notes
            JSSTincluder::getJSModel('note')->removeTicketInternalNote($ticketid);
            // delete replies
            JSSTincluder::getJSModel('reply')->removeTicketReplies($ticketid);
        } else {
            JSSTmessage::setMessage(__('Ticket','js-support-ticket').' '.__('in use cannot be deleted', 'js-support-ticket'), 'error');
        }

        return;
    }

    function removeEnforceTicket($id) {
        $sendEmail = true;
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Ticket');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }

        jssupportticket::$_data['ticketid'] = $this->getTrackingIdById($id);
        jssupportticket::$_data['ticketemail'] = $this->getTicketEmailById($id);
        jssupportticket::$_data['staffid'] = $this->getStaffIdById($id);
        jssupportticket::$_data['ticketsubject'] = $this->getTicketSubjectById($id);
		// delete attachments
		$this->removeTicketAttachmentsByTicketid($id);
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_tickets', array('id' => $id));
		// delete attachments
		$this->removeTicketAttachmentsByTicketid($id);	    

        if (jssupportticket::$_db->last_error == null) {
            $messagetype = __('Successfully', 'js-support-ticket');
            JSSTmessage::setMessage(__('Ticket has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been deleted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 3); // Mailfor, Delete Ticket
            $ticketobject = (object) array('ticketid' => jssupportticket::$_data['ticketid'], 'ticketemail' => jssupportticket::$_data['ticketemail']);
            do_action('jsst-ticketdelete', $ticketobject);
        }
        // delete internal notes
        JSSTincluder::getJSModel('note')->removeTicketInternalNote($id);
        // delete replies
        JSSTincluder::getJSModel('reply')->removeTicketReplies($id);

        return;
    }
    
    private function removeTicketAttachmentsByTicketid($id){
		if(!is_numeric($id)) return false;
		$datadirectory = jssupportticket::$_config['data_directory'];
		$maindir = wp_upload_dir();
		$mainpath = $maindir['basedir'];
		$mainpath = $mainpath .'/'.$datadirectory;
		$mainpath = $mainpath . '/attachmentdata';
		$query = "SELECT ticket.attachmentdir
					FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket 
					WHERE ticket.id = ".$id;
		$foldername = jssupportticket::$_db->get_var($query);
		if(!empty($foldername)){
			$folder = $mainpath . '/ticket/'.$foldername;
			$path = $mainpath . '/ticket/'.$foldername.'/*.*';
			$files = glob($path);
			array_map('unlink', $files);//deleting files
			rmdir($folder);
			$query = "DELETE FROM `".jssupportticket::$_db->prefix."js_ticket_attachments` WHERE ticketid = ".$id;
			jssupportticket::$_db->query($query);
		}
	}

    private function canRemoveTicket($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE ticketid = " . $id . ")
                    +(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_notes` WHERE ticketid = " . $id . ")
                    ) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0)
            return true;
        else
            return false;
    }

    function getTicketSubjectById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT subject FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $subject = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $subject;
    }

    function getTrackingIdById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $ticketid = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $ticketid;
    }

    function getTicketEmailById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT email FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $ticketemail = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $ticketemail;
    }

    function getStaffIdById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT staffid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $staffid = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $staffid;
    }

    function setStatus($status, $ticketid) {
        // 0 -> New Ticket
        // 1 -> Waiting admin/staff reply
        // 2 -> in progress
        // 3 -> waiting for customer reply
        // 4 -> close ticket
        if (!is_numeric($status))
            return false;
        if (!is_numeric($ticketid))
            return false;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = " . $status . " WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function updateLastReply($id) {
        if (!is_numeric($id))
            return false;
        $date = date_i18n('Y-m-d H:i:s');
        $isanswered = " , isanswered = 0 ";
        if (is_admin() || JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $isanswered = " , isanswered = 1 ";
        }
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET lastreply = '" . $date . "' " . $isanswered . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function closeTicket($id) {
        if (!is_numeric($id))
            return false;
        //Check if its allowed to close ticket
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Close Ticket');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        if (!$this->checkActionStatusSame($id, array('action' => 'closeticket'))) {
            JSSTmessage::setMessage(__('Ticket already closed', 'js-support-ticket'), 'error');
            return;
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 4, closed = '" . $date . "' WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket has been closed', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been closed', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $id; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Close Ticket', 'js-support-ticket');
        $message = __('Ticket is closed by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 2, $ticketid); // Mailfor, Close Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        return;
    }

    function lockTicket($id) {
        /*
          lock = 0 means unlocked
          lock = 1 means locked
         */
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Lock Ticket');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET `lock` = 1 WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        // echo "<pre>";print_r(jssupportticket::$_db);exit;
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket has been locked', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been locked', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $id; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Lock Ticket', 'js-support-ticket');
        $message = __('Ticket is locked by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 6, $ticketid); // Mailfor, Lock Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        return;
    }

    function unLockTicket($id) {
        /*
          lock = 0 means unlocked
          lock = 1 means locked
         */
        if (!is_numeric($id))
            return false;
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET `lock` = 0 WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket has been unlocked', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been unlocked', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $id; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Unlock Ticket', 'js-support-ticket');
        $message = __('Ticket is unlocked by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 7, $ticketid); // Mailfor, Unlock Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        return;
    }

    function getTicketListOrdering($sort) {
        switch ($sort) {
            case "subjectdesc":
                jssupportticket::$_ordering = "ticket.subject DESC";
                jssupportticket::$_sorton = "subject";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "subjectasc":
                jssupportticket::$_ordering = "ticket.subject ASC";
                jssupportticket::$_sorton = "subject";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "prioritydesc":
                jssupportticket::$_ordering = "priority DESC";
                jssupportticket::$_sorton = "priority";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "priorityasc":
                jssupportticket::$_ordering = "priority ASC";
                jssupportticket::$_sorton = "priority";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "ticketiddesc":
                jssupportticket::$_ordering = "ticket.ticketid DESC";
                jssupportticket::$_sorton = "ticketid";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "ticketidasc":
                jssupportticket::$_ordering = "ticket.ticketid ASC";
                jssupportticket::$_sorton = "ticketid";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "isanswereddesc":
                jssupportticket::$_ordering = "ticket.isanswered DESC";
                jssupportticket::$_sorton = "isanswered";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "isansweredasc":
                jssupportticket::$_ordering = "ticket.isanswered ASC";
                jssupportticket::$_sorton = "isanswered";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "statusdesc":
                jssupportticket::$_ordering = "ticket.status DESC";
                jssupportticket::$_sorton = "status";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "statusasc":
                jssupportticket::$_ordering = "ticket.status ASC";
                jssupportticket::$_sorton = "status";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "createddesc":
                jssupportticket::$_ordering = "ticket.created DESC";
                jssupportticket::$_sorton = "created";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "createdasc":
                jssupportticket::$_ordering = "ticket.created ASC";
                jssupportticket::$_sorton = "created";
                jssupportticket::$_sortorder = "ASC";
                break;
            default: jssupportticket::$_ordering = "ticket.id DESC";
        }
        return;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "iddesc";
    }

    function getTicketListSorting($sort) {
        jssupportticket::$_sortlinks['subject'] = $this->getSortArg("subject", $sort);
        jssupportticket::$_sortlinks['priority'] = $this->getSortArg("priority", $sort);
        jssupportticket::$_sortlinks['ticketid'] = $this->getSortArg("ticketid", $sort);
        jssupportticket::$_sortlinks['isanswered'] = $this->getSortArg("isanswered", $sort);
        jssupportticket::$_sortlinks['status'] = $this->getSortArg("status", $sort);
        jssupportticket::$_sortlinks['created'] = $this->getSortArg("created", $sort);
        return;
    }

    private function getTicketHistory($id) {
        if(!is_numeric($id)) return false;
        $query = "SELECT al.id,al.message,al.datetime,al.uid  
        from `" . jssupportticket::$_db->prefix . "js_ticket_activity_log`  AS al
        join `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS tic on al.referenceid=tic.id
        where al.referenceid=" . $id . " AND al.eventfor=1 ORDER BY al.datetime DESC ";
        jssupportticket::$_data[5] = jssupportticket::$_db->get_results($query);
        // echo "<pre>";print_r(jssupportticket::$_db);exit;
    }

    function tickDepartmentTransfer($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Ticket Department Transfer');
            if ($allow != true) {
                JSSTmessage::setMessage(__('Your are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET departmentid = " . $data['departmentid'] . ", updated = '" . $date . "' WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Department has been transfered', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Department has not been transfered', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Ticket Department Transfer', 'js-support-ticket');
        $message = __('Department is transfered by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 12, $ticketid); // Mailfor, Department Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        /* to store internal notes FOR department transfer  */
        if (isset($data['departmenttranfernote']) && $data['departmenttranfernote'] != '') {
            JSSTincluder::getJSModel('note')->storeTicketInternalNote($data, $data['departmenttranfernote']);
        }
        return;
    }

    function assignTicketToStaff($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Assign Ticket To Staff');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET staffid = " . $data['staffid'] . ", updated = '" . $date . "' WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Assigned to staff', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Not assigned to staff', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Assign ticket to staff', 'js-support-ticket');
        $message = __('Ticket is assigned to staff by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 13, $ticketid); // Mailfor, Assign Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        /* to store internal notes FOR department transfer  */
        if (isset($data['assignnote']) && $data['assignnote'] != '') {
            JSSTincluder::getJSModel('note')->storeTicketInternalNote($data, $data['assignnote']);
        }
        return;
    }

    function changeTicketPriority($id, $priorityid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($priorityid))
            return false;
        if (!$this->checkActionStatusSame($id, array('action' => 'priority', 'id' => $priorityid))) {
            JSSTmessage::setMessage(__('Ticket already have same priority', 'js-support-ticket'), 'error');
            return;
        }
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Change Ticket Priority');
            if ($allow == 0) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET priorityid = " . $priorityid . ", updated = '" . $date . "' WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Priority has been changed', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Priority has not been changed', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Change Priority', 'js-support-ticket');
        $message = __('Ticket priority is changed by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($id, 1, $eventtype, $message, $messagetype);
        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 11, $id, 'js_ticket_tickets'); // Mailfor, Ban email, Ticketid
        }
        return;
    }

    function banEmail($data) {
        $ticketid = $data['ticketid'];
        $uid = get_current_user_id();
        $staffid = JSSTincluder::getJSModel('staff')->getstaffid($uid);
        if (!is_numeric($ticketid))
            return false;
        if(!is_admin()){
            if (!is_numeric($staffid))
                return false;
        }
        $email = self::getTicketEmailById($ticketid);
        $sendEmail = true;
        $query_array = array(
            'email' => $email,
            'submitter' => $staffid,
            'uid' => $uid,
            'created' => date_i18n('Y-m-d H:i:s')
        );
        if (!$this->checkActionStatusSame($ticketid, array('action' => 'banemail', 'email' => $email))) {
            JSSTmessage::setMessage(__('Email already banned', 'js-support-ticket'), 'error');
            return;
        }
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_email_banlist', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Email has been banned', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Email has not been banned', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Ban Email', 'js-support-ticket');
        $message = __('Email is banned by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(2, 1, $ticketid, 'js_ticket_tickets'); // Mailfor, Ban email, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }
        return;
    }

    function markOverDueTicket($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;

        if (!$this->checkActionStatusSame($ticketid, array('action' => 'markoverdue'))) {
            JSSTmessage::setMessage(__('Ticket already marked overdue', 'js-support-ticket'), 'error');
            return;
        }
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Mark Overdue');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET isoverdue = 1 , updated = '" . $date . "' WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket has been marked as overdue', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been marked as overdue', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Mark overdue', 'js-support-ticket');
        $message = __('Ticket is marked as overdue by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 8, $ticketid); // Mailfor, Overdue Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }
        return;
    }

    function banEmailAndCloseTicket($data) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Ban Email And Close Ticket');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        self::banEmail($data);
        self::closeTicket($data['ticketid']);
        return;
    }

    /* check can a ticket be opened with in the given days */

    function checkCanReopenTicket($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        $lastreply = JSSTincluder::getJSModel('reply')->getLastReply($ticketid);
        if (!$lastreply)
            $lastreply = date_i18n('Y-m-d H:i:s');
        $days = jssupportticket::$_config['reopen_ticket_within_days'];
        $date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($lastreply)) . " +" . $days . " day"));
        if ($date < date_i18n('Y-m-d H:i:s'))
            return false;
        else
            return true;
    }

    function reopenTicket($data) {
        $ticketid = $data['ticketid'];
        $lastreply = isset($data['lastreplydate']) ? $data['lastreplydate'] : '';
        if (!is_numeric($ticketid))
            return false;
        //check the permission to reopen ticket
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Reopen Ticket');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        /* check can a ticket be opened with in the given days */
        if ($this->checkCanReopenTicket($ticketid)) {
            $sendEmail = true;
            $date = date_i18n('Y-m-d H:i:s');
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 0 , updated = '" . $date . "' WHERE id = " . $ticketid;
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Ticket has been reopend', 'js-support-ticket'), 'updated');
                $messagetype = __('Successfully', 'js-support-ticket');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Ticket has not been reopened', 'js-support-ticket'), 'error');
                $messagetype = __('Error', 'js-support-ticket');
                $sendEmail = false;
            }

            /* for activity log */
            $current_user = wp_get_current_user(); // to get current user name
            $currentUserName = $current_user->display_name;
            $eventtype = __('Reopen Ticket', 'js-support-ticket');
            $message = __('Ticket is reopened by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
            JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
            /*
              // Send Emails
              if ($sendEmail == true) {
              JSSTincluder::getJSModel('email')->sendMail(1, 2, $ticketid); // Mailfor, Close Ticket, Ticketid
              $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
              do_action('jsst-ticketclose', $ticketobject);
              }
             */
        } else {
            JSSTmessage::setMessage(__('Ticket reopen time limit end', 'js-support-ticket'), 'error');
        }


        return;
    }

    private function canUnbanEmail($email) {
        $query = " SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = '" . $email . "' ";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result > 0)
            return true;
        else
            return false;
    }

    function unbanEmail($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Unban Email');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $email = self::getTicketEmailById($ticketid);
        if ($this->canUnbanEmail($email)) {
            $sendEmail = true;
            $date = date_i18n('Y-m-d H:i:s');
            $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = '" . $email . " ' ";
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Email has been unbanned', 'js-support-ticket'), 'updated');
                $messagetype = __('Successfully', 'js-support-ticket');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Email has not been unbanned', 'js-support-ticket'), 'error');
                $messagetype = __('Error', 'js-support-ticket');
                $sendEmail = false;
            }

            /* for activity log */
            $current_user = wp_get_current_user(); // to get current user name
            $currentUserName = $current_user->display_name;
            $eventtype = __('Unbanned Email', 'js-support-ticket');
            $message = __('Email is unbanned by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
            JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

            // Send Emails
            if ($sendEmail == true) {
                JSSTincluder::getJSModel('email')->sendMail(2, 2, $ticketid, 'js_ticket_tickets'); // Mailfor, Unban Ticket, Ticketid
                $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
                do_action('jsst-ticketclose', $ticketobject);
            }
        } else {
            JSSTmessage::setMessage(__('Email cannot be unbanned', 'js-support-ticket'), 'error');
        }

        return;
    }

    function markTicketInProgress($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;
        if (!$this->checkActionStatusSame($ticketid, array('action' => 'markinprogress'))) {
            JSSTmessage::setMessage(__('Ticket already marked in progress', 'js-support-ticket'), 'error');
            return;
        }
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Mark In Progress');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $date = date_i18n('Y-m-d H:i:s');
        $sendEmail = true;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 2 , updated = '" . $date . "' WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket has been marked as in progress', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been marked as in progress', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('In progress ticket', 'js-support-ticket');
        $message = __('Ticket is marked as in progress by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 9, $ticketid, 'js_ticket_tickets'); // Mailfor, Unban Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }

        return;
    }

    function updateTicketStatusCron() {
        // close ticket
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 4 WHERE date(DATE_ADD(lastreply,INTERVAL " . jssupportticket::$_config['ticket_auto_close'] . " DAY)) < CURDATE() AND isanswered = 1";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        // overdue ticket admin/staff not answered mark overdue
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET isoverdue = 1 WHERE date(DATE_ADD(lastreply,INTERVAL " . jssupportticket::$_config['ticket_overdue'] . " DAY)) < CURDATE() AND status != 0 AND status != 4 AND isanswered != 1";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        // overdue ticket new ticket not reply anyone
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET isoverdue = 1 WHERE date(DATE_ADD(created,INTERVAL " . jssupportticket::$_config['ticket_overdue'] . " DAY)) < CURDATE() AND status = 0";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        // overdue ticket admin/staff set overdue date and ticket not closed and not is answered
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET isoverdue = 1 WHERE date(duedate) < CURDATE() AND status != 4 AND isanswered != 1 AND duedate != '0000-00-00 00:00:00'";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
    }

    function removeFileCustom($id,$key){
        $filename = str_replace(' ', '_', $key);
        
        $datadirectory = jssupportticket::$_config['data_directory'];
        $path = jssupportticket::$_path . '/' . $datadirectory. '/attachmentdata/ticket';
        
        $query = "SELECT attachmentdir FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE id = ".$id;
        $foldername = jssupportticket::$_db->get_var($query);
        $userpath = $path . '/' . $foldername.'/'.$filename;
        unlink($userpath);
        return ;
    }

    function getTicketidForVisitor($token) {
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
        $decryptedtext = $encoder->decrypt($token);
        $array = json_decode($decryptedtext, true);
        $emailaddress = $array['emailaddress'];
        $trackingid = $array['trackingid'];
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND ticketid = '" . $trackingid . "'";
        $ticketid = jssupportticket::$_db->get_var($query);
        return $ticketid;
    }

    function createTokenByEmailAndTrackingId($emailaddress, $trackingid) {
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
        $token = $encoder->encrypt(json_encode(array('emailaddress' => $emailaddress, 'trackingid' => $trackingid)));
        return $token;
    }

    function validateTicketDetailForStaff($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        // check in assign department
        $c_uid = get_current_user_id();
        $query = "SELECT ticket.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept ON ticket.departmentid = dept.departmentid 
            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON dept.staffid = staff.id AND staff.uid = " . $c_uid . "
            WHERE ticket.id = " . $ticketid;
        $id = jssupportticket::$_db->get_var($query);

        if ($id) {
            return true;
        } else {
            // check in assign ticket
            $query = "SELECT ticket.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id AND staff.uid = " . $c_uid;
            $query .= " WHERE ticket.id = ". $ticketid;
            $id = jssupportticket::$_db->get_var($query);
            if ($id)
                return true;
            else
                return false;
        }
    }

    function totalTicket() {
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
        $total = jssupportticket::$_db->get_var($query);
        return $total;
    }

    function validateTicketDetailForUser($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT uid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $uid = jssupportticket::$_db->get_var($query);

        if ($uid == get_current_user_id()) {
            return true;
        } else {
            return false;
        }
    }

    function validateTicketDetailForVisitor($id) {
        if (!isset($_SESSION['js-support-ticket']['token'])) {
            return false;
        }
        $token = $_SESSION['js-support-ticket']['token'];
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder();
        $decryptedtext = $encoder->decrypt($token);
        $array = json_decode($decryptedtext, true);
        $emailaddress = $array['emailaddress'];
        $trackingid = $array['trackingid'];
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND ticketid = '" . $trackingid . "'";
        $ticketid = jssupportticket::$_db->get_var($query);

        if ($ticketid == $id) {
            return true;
        } else {
            return false;
        }
    }

    function checkActionStatusSame($id, $array) {
        switch ($array['action']) {
            case 'priority':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND priorityid = ' . $array['id']);
                break;
            case 'markoverdue':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND isoverdue = 1');
                break;
            case 'markinprogress':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND status = 2');
                break;
            case 'closeticket':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND status = 4');
                break;
            case 'banemail':
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_email_banlist` WHERE email = "' . $array['email'] . '"');
                break;
        }
        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }

    function ticketAssignToMe($ticketid, $staffid) {
        if (!is_numeric($ticketid))
            return false;
        if (!is_numeric($staffid))
            return false;
        jssupportticket::$_db->query("UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET staffid = " . $staffid . " WHERE id = " . $ticketid);
        return true;
    }

    function getMyTicketInfo_Widget($maxrecord){
        if(!is_numeric($maxrecord)) return false;
        if(is_user_logged_in()){
            $uid = get_current_user_id();
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId($uid);
            if(!$staffid){
                // Data
                $query = "SELECT DISTINCT ticket.id,ticket.subject,ticket.status,ticket.name,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                            FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id                            
                            WHERE ticket.uid = $uid AND (ticket.status = 0 OR ticket.status = 1) ORDER BY ticket.status DESC LIMIT $maxrecord";
            }elseif($staffid){
                // Data
                $query = "SELECT DISTINCT ticket.id,ticket.subject,ticket.status,ticket.name,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                            FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = ticket.uid
                            WHERE (ticket.staffid = $staffid OR ticket.departmentid IN (SELECT dept.departmentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dept WHERE dept.staffid = $staffid)) AND (ticket.status = 0 OR ticket.status = 1) ORDER BY ticket.status DESC LIMIT $maxrecord";
            }
            if(isset($query)){
                jssupportticket::$_data['widget_myticket'] = jssupportticket::$_db->get_results($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }else{
                jssupportticket::$_data['widget_myticket'] = false;    
            }
        }else{  
            jssupportticket::$_data['widget_myticket'] = false;
        }
        return;
    }

    function getLatestTicketForDashboard(){
        $query = "SELECT ticket.id,ticket.subject,ticket.name,priority.priority,priority.prioritycolour
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON priority.id = ticket.priorityid
                    ORDER BY ticket.status ASC, ticket.created DESC LIMIT 0, 5";
        $tickets = jssupportticket::$_db->get_results($query);
        return $tickets;
    }

    function getTotalStatsForDashboard(){
        $curdate = date_i18n('Y-m-d');
        $fromdate = date_i18n('Y-m-d', strtotime("now -1 month"));

        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '".$fromdate."'AND date(created) <= '".$curdate."'";
        $result['open'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '".$fromdate."' AND date(created) <= '".$curdate."'";
        $result['answered'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '".$fromdate."' AND date(created) <= '".$curdate."'";
        $result['overdue'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '".$fromdate."' AND date(created) <= '".$curdate."'";
        $result['pending'] = jssupportticket::$_db->get_var($query);

        return $result;
    }

    function getRandomFolderName() {
        $foldername = "";
        $length = 7;
        $possible = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        // we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($possible);
        if ($length > $maxlength) { // check for length overflow and truncate if necessary
            $length = $maxlength;
        }
        // set up a counter for how many characters are in the ticketid so far
        $i = 0;
        // add random characters to $password until $length is reached
        while ($i < $length) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
            if (!strstr($foldername, $char)) {
                if ($i == 0) {
                    if (ctype_alpha($char)) {
                        $foldername .= $char;
                        $i++;
                    }
                } else {
                    $foldername .= $char;
                    $i++;
                }
            }
        }
        return $foldername;
    }

}
?>
