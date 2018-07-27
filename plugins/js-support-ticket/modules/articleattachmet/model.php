<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTarticleattachmetModel {

    function getAttachmentForForm($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename,filesize,id
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments`
					WHERE articleid = " . $id;
        jssupportticket::$_data[5] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function storeAttachments($data) {
        JSSTincluder::getObjectClass('uploads')->storeArticleAttachment($data, $this);
    }

    function storeArticleAttachmet($articleid, $filesize, $filename) {
        if (!is_numeric($articleid))
            return false;
        $created = date_i18n('Y-m-d H:i:s');
        $query_array = array('articleid' => $articleid,
            'filesize' => $filesize,
            'filename' => $filename,
            'created' => $created,
            'status' => 1
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_articles_attachments', $query_array);
        //staff downloads attachments store
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            return false;
        }
        return true;
    }

    function removeAttachment($id , $articleid) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments` WHERE id = " . $id;
        $filename = jssupportticket::$_db->get_var($query);
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_articles_attachments', array('id' => $id));
        if (jssupportticket::$_db->last_error == null) {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $path = $path . '/articles/article_' . $articleid . '/' . $filename;
            unlink($path);
            //$files = glob($path.'/*.*');
            //array_map('unlink', $files); // delete all file in the direcoty
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }

    function removeAllAttachment($articleid) {
        if (!is_numeric($articleid))
            return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_articles_attachments', array('articleid' => $articleid));
        if (jssupportticket::$_db->last_error == null) {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            
            $path = $path . '/attachmentdata';
            $path = $path . '/articles/article_' . $id . '/';
            $files = glob($path . '/*.*');
            array_map('unlink', $files); // delete all file in the direcoty
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }

    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT filename,articleid FROM `".jssupportticket::$_db->prefix."js_ticket_articles_attachments` WHERE id = $id";
        $object = jssupportticket::$_db->get_row($query);
        $filename = $object->filename;
        $articleid = $object->articleid;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/attachmentdata';
        $path = $path . '/articles/article_' . $articleid;
        $file = $path . '/'.$filename;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        //ob_clean();
        flush();
        readfile($file);
        exit();
        
    }
}

?>
