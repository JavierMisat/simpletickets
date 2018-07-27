<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdeactivation {

    static function jssupportticket_deactivate() {
        wp_clear_scheduled_hook('jssupporticket_updateticketstatus');
        wp_clear_scheduled_hook('jssupporticket_ticketviaemail');
        $id = jssupportticket::getPageid();
        jssupportticket::$_db->get_var("UPDATE `" . jssupportticket::$_db->prefix . "posts` SET post_status = 'draft' WHERE ID = $id");

        //Delete capabilities
        $role = get_role( 'administrator' );
        $role->remove_cap( 'jsst_support_ticket' ); 
        
    }

}

?>