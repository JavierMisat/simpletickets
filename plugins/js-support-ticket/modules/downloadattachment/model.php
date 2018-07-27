<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadattachmentModel {

    function getAttachmentForForm($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename,filesize,id
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments`
					WHERE downloadid = " . $id;
        jssupportticket::$_data[5] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function storeAttachments($data) {
        JSSTincluder::getObjectClass('uploads')->storeDownloadAttachment($data, $this);
    }

    function storeDownloadAttachment($downloadid, $filesize, $filename) {
        if (!is_numeric($downloadid))
            return false;
        $query_array = array('downloadid' => $downloadid,
            'filesize' => $filesize,
            'filename' => $filename,
            'created' => date_i18n('Y-m-d H:i:s')
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_downloads_attachments', $query_array);
        // staff downloads attachments store
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        return false;
        }
        return true;
    }

    function removeAttachment($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` WHERE id = " . $id;
        $filename = jssupportticket::$_db->get_var($query);
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_downloads_attachments', array('id' => $id));
        if (jssupportticket::$_db->last_error == null) {
            $downloadid = JSSTRequest::getVar('downloadid');
            if($downloadid){
                $datadirectory = jssupportticket::$_config['data_directory'];
                $maindir = wp_upload_dir();
                $path = $maindir['basedir'];
                $path = $path .'/'.$datadirectory;            
                $path = $path . '/attachmentdata';
                $path = $path . '/downloads/download_' . $downloadid . '/' . $filename;
                unlink($path);
                // $files = glob($path.'/*.*');
                // array_map('unlink', $files); // delete all file in the direcoty
                JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
            }
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }

    function removeAllAttachment($downloadid) {
        if (!is_numeric($downloadid))
            return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_downloads_attachments', array('downloadid' => $downloadid));
        if (jssupportticket::$_db->last_error == null) {
            $datadirectory = jssupportticket::$_config['data_directory'];        
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $path = $path . '/downloads/download_' . $downloadid;
            $files = glob($path . '/*.*');
            array_map('unlink', $files); // delete all file in the direcoty
            rmdir($path);
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }

}

?>
