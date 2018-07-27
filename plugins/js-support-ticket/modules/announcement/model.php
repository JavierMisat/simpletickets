<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTannouncementModel {

    function getStaffAnnouncements() {
        // Filter
        $condition = " WHERE ";
        $isadmin = is_admin();

        $titlename = ($isadmin) ? 'title' : 'jsst-title';
        $typename = ($isadmin) ? 'type' : 'jsst-type';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';

        $title = JSSTrequest::getVar($titlename);
        $type = JSSTrequest::getVar($typename);
        $categoryid = JSSTrequest::getVar($catname);
        $title = jssupportticket::parseSpaces($title);

        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['title'] = $title;
                $_SESSION['JSST_SEARCH']['type'] = $type;
                $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            $type = (isset($_SESSION['JSST_SEARCH']['type']) && $_SESSION['JSST_SEARCH']['type'] != '') ? $_SESSION['JSST_SEARCH']['type'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }

        $inquery = '';
        if ($title != null) {
            $inquery .= $condition . " announcement.title LIKE '%$title%' ";
            $condition = " AND ";
        }
        if ($type) {
            if (!is_numeric($type))
                return false;
            $inquery .= $condition . " announcement.type = " . $type;
            $condition = " AND ";
        }
        if ($categoryid) {
            if (!is_numeric($categoryid))
                return false;
            $inquery .= $condition . " announcement.categoryid= " . $categoryid;
        }

        jssupportticket::$_data['filter'][$titlename] = $title;
        jssupportticket::$_data['filter'][$typename] = $type;
        jssupportticket::$_data['filter'][$catname] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(announcement.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON announcement.categoryid = category.id 
                    ";
        $query .= $inquery;

        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT announcement.*,category.name AS categoryname
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON announcement.categoryid = category.id 
                    ";
        $query .= $inquery;
        $query .= " ORDER BY announcement.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAnnouncementForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT announcement.*,category.name AS categoryname
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON announcement.categoryid = category.id 
                    WHERE announcement.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeAnnouncement($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s'); // new
        $staffid = 0;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Announcement' : 'Edit Announcement';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());
        }
        $query_array = array('id' => $data['id'],
            'categoryid' => $data['categoryid'],
            'title' => $data['title'],
            'description' => wpautop(wptexturize(stripslashes($data['description']))),
            'type' => $data['type'],
            'staffid' => $staffid,
            'status' => $data['status'],
            'created' => $data['created']
        );
        if (!$data['id']) { //new
            $query_array['ordering'] = $this->getNextOrdering();
        } else {
            $query_array['ordering'] = $data['ordering'];
        }

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_announcements', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Announcement has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeAnnouncement($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Announcement');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_announcements', array('id' => $id));
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Announcement has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Announcement has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;

        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_announcements` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getAnnouncementDetails($id) {
        if (!is_numeric($id))
            return;

        $query = "SELECT announcement.id, announcement.title, announcement.description  
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.id = " . $id;

        jssupportticket::$_data[0]['announcementdetails'] = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAnnouncements($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;

        $title = jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-search'));
        $inquery = '';
        $inquerycat = '';
        if ($title != null) {
            $inquery .=" AND announcement.title LIKE '%$title%'";
            $inquerycat .=" AND category.name LIKE '%$title%'";
        }

        $query = "SELECT category.name, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.parentid = " . $id . " AND announcement = 1 " . $inquerycat;
        jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT category.name
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.id = " . $id . " AND announcement = 1";
        jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);


        if ($id != 0)
            $inquery = " AND announcement.categoryid = " . $id;

        if ($id > 0) {
            $query = "SELECT category.name, category.logo, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.id = " . $id . " AND kb = 1";
            jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);
        }

        // Pagination
        $query = "SELECT COUNT(announcement.id)
                   FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.status = 1 " . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT announcement.id, announcement.title  
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.status = 1 " . $inquery;
        $query .=" ORDER BY announcement.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();

        jssupportticket::$_data[0]['announcements'] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function setOrdering($id) {
        if (!is_numeric($id))
            return false;
        $order = JSSTrequest::getVar('order', 'get');
        if ($order == 'down') {
            $order = ">";
            $direction = "ASC";
        } else {
            $order = "<";
            $direction = "DESC";
        }
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_announcements` SET ordering = " . $result->ordering . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_announcements` SET ordering = " . $result->ordering2 . " WHERE id = " . $result->id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>
