<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpriorityModel {

    function getPriorities() {
        // Filter
        $prioritytitle = JSSTrequest::getVar('title');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $prioritytitle;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $prioritytitle = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
        }

        if ($prioritytitle != null)
            $inquery .= " WHERE priority.priority LIKE '%$prioritytitle%'";

        jssupportticket::$_data['filter']['title'] = $prioritytitle;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT priority.*
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ";
        $query .= $inquery;
        $query .= " ORDER BY priority.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getPriorityForCombobox() {
        $query = "SELECT id, priority AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities`";
        $staff = JSSTincluder::getJSModel('staff')->isUserStaff();
        if (!is_admin() && !$staff) {
            $query .= ' WHERE ispublic = 1 ';
        }
        $query .= 'ORDER BY ordering ASC';
        $priorities = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $priorities;
    }

    function getDefaultPriorityID() {
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE isdefault = 1";
        $id = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $id;
    }

    function getPriorityForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT priority.*
						FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority
						WHERE priority.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function storePriority($data) {
        if (!$this->validatePriority($data['priority'], $data['id'])) {
            JSSTmessage::setMessage(__('Priority Title Already Exist', 'js-support-ticket'), 'error');
            return;
        }
        $query_array = array('id' => $data['id'],
            'priority' => $data['priority'],
            'prioritycolour' => $data['prioritycolor'],
            'ispublic' => $data['ispublic'],
            'isdefault' => $data['isdefault'],
            'status' => $data['status']
        );
        if (!$data['id']) { //new
            $query_array['ordering'] = $this->getNextOrdering();
        } else {
            $query_array['ordering'] = $data['ordering'];
        }
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_priorities', $query_array);
        $id = jssupportticket::$_db->insert_id;
        if ($data['isdefault'] == 1) {
            $this->setDefaultPriority($id);
        }
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Priority has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Priority has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function validatePriority($priority, $id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT priority FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE id = " . $id;
            $result = jssupportticket::$_db->get_var($query);
            if ($result == $priority) {
                return true;
            }
        }

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE priority = '" . $priority . "'";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0)
            return true;
        else
            return false;
    }

    private function getNextOrdering($priority) {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function setDefaultPriority($id) {
        if (!is_numeric($id))
            return false;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_priorities` SET isdefault = 2";
        jssupportticket::$_db->query($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_priorities` SET isdefault = 1 WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        return;
    }

    function removePriority($id) {
        if (!is_numeric($id))
            return false;
        $canremove = $this->canRemovePriority($id);
        if ($canremove == 1) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_priorities', array('id' => $id));
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Priority has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Priority has not been deleted', 'js-support-ticket'), 'error');
            }
        } elseif ($canremove == 2)
            JSSTmessage::setMessage(__('Priority','js-support-ticket').' '.__('in use cannot deleted', 'js-support-ticket'), 'error');
        elseif ($canremove == 3)
            JSSTmessage::setMessage(__('Default priority cannot delete', 'js-support-ticket'), 'error');

        return;
    }

    function makeDefault($id) {
        if (!is_numeric($id))
            return false;
        //Reset all priorities to non-default
        $query = "UPDATE `" . jssupportticket::$_db->prefix . 'js_ticket_priorities` SET isdefault = 0';
        jssupportticket::$_db->query($query);
        //Make the selected priority as default
        $query = "UPDATE `" . jssupportticket::$_db->prefix . 'js_ticket_priorities` SET isdefault = 1 WHERE id = ' . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Priority has been make default', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Priority has not been make default', 'js-support-ticket'), 'error');
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
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_priorities` SET ordering = " . $result->ordering . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_priorities` SET ordering = " . $result->ordering2 . " WHERE id = " . $result->id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Priority','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Priority','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function canRemovePriority($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
					(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE priorityid = " . $id . ")
					) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0) {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE isdefault = 1 AND id = " . $id;
            $result = jssupportticket::$_db->get_var($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            if ($result == 0)
                return 1;
            else
                return 3;
        } else
            return 2;
    }

    function getPriorityById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT priority FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE id = $id";
        $priority = jssupportticket::$_db->get_var($query);
        return $priority;
    }

}

?>
