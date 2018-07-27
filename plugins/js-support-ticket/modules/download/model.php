<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadModel {

    function getStaffDownloads() {
        $isadmin = is_admin();

        $titlename = ($isadmin) ? 'title' : 'jsst-title';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';

        $title = JSSTrequest::getVar($titlename);
        $categoryid = JSSTrequest::getVar($catname);
        $title = jssupportticket::parseSpaces($title);
        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['title'] = $title;
                $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }

        $condition = " WHERE ";
        $inquery = '';
        if ($title != null) {
            $inquery .= $condition . "download.title LIKE '%$title%'";
            $condition = " AND ";
        }
        if ($categoryid) {
            if (!is_numeric($categoryid))
                return false;
            $inquery .= $condition . "download.categoryid= " . $categoryid;
        }

        jssupportticket::$_data['filter'][$titlename] = $title;
        jssupportticket::$_data['filter'][$catname] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(`download`.`id`) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id 
                        ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);
        // Data
        $query = "SELECT download.*,category.name AS categoryname ,(SELECT count(downloadattachment.id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` AS downloadattachment WHERE download.id=downloadattachment.downloadid ) AS totalattachment
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id 
                    ";
        $query .= $inquery;
        $query .= " ORDER BY download.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getDownloadForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT download.*,category.name AS categoryname
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id 
                    WHERE download.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        JSSTincluder::getJSModel('downloadattachment')->getAttachmentForForm($id);
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeDownload($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $staffid = 0;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Download' : 'Edit Download';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'updated');
                return;
            }
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());
        }
        $query_array = array('id' => $data['id'],
            'categoryid' => $data['categoryid'],
            'title' => $data['title'],
            'staffid' => $staffid,
            'description' => wpautop(wptexturize(stripslashes($data['description']))),
            'status' => $data['status'],
            'created' => $data['created']
        );
        if (!$data['id']) { //new
            $query_array['ordering'] = $this->getNextOrdering();
        } else {
            $query_array['ordering'] = $data['ordering'];
        }

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_downloads', $query_array);
        $data['id'] = jssupportticket::$_db->insert_id; // get the downlowd id
        JSSTincluder::getJSModel('downloadattachment')->storeAttachments($data);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Download has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download has not been stored', 'js-support-ticket'), 'error');
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
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_downloads` SET ordering = " . $result->ordering . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_downloads` SET ordering = " . $result->ordering2 . " WHERE id = " . $result->id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeDownload($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Download');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_downloads', array('id' => $id));
        JSSTincluder::getJSModel('downloadattachment')->removeAllAttachment($id);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Download has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Download has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;

        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_downloads` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getDownloads($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;

        $title = JSSTrequest::getVar('jsst-search');
        $title = jssupportticket::parseSpaces($title);
        $inquery = '';
        $inquerycat = '';
        if ($title != null) {
            $inquerycat .=" AND category.name LIKE '%$title%'";
            $inquery .=" AND download.title LIKE '%$title%'";
            jssupportticket::$_data[0]['download-filter']['search'] = $title;
        }


        $query = "SELECT category.name, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.parentid = " . $id . " AND downloads = 1 ". $inquerycat;
        jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);

        if ($id != 0)
            $inquery = " AND download.categoryid = " . $id;
        // Pagination
        $query = "SELECT COUNT(download.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    WHERE download.status = 1" . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT download.title, download.id AS downloadid
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    WHERE download.status = 1" . $inquery;
        $query .=" ORDER BY download.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0]['downloads'] = jssupportticket::$_db->get_results($query);

        return;
    }

    function getDownloadById() {
        $downloadid = JSSTrequest::getVar('downloadid');
        if (!is_numeric($downloadid))
            return false;

        $query = "SELECT download.title, download.description, download.id AS downloadid, attachment.id AS attachmentid, attachment.filename,attachment.filesize, attachment.filetype
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` AS attachment
                ON download.id = attachment.downloadid
                WHERE download.status = 1 AND download.id = " . $downloadid;
        $query .=" ORDER BY downloadid";
        $downloads = jssupportticket::$_db->get_results($query);

        $result['data'] = '
            <div class="js-col-md-12">
                <div class="js-ticket-popup-desctiption">' . $downloads[0]->description . '</div>
            </div>
            <div class="js-col-md-12">';
        foreach ($downloads as $download) {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $path = site_url('?page_id='.jssupportticket::getPageid()."&action=jstask&jstmod=download&task=downloadbyid&id=".$download->attachmentid);
            $result['data'] .='
                <div class="js-col-xs-12 js-col-md-12 js-ticket-popup-download-row">
                    <div class="js-col-xs-12 js-col-md-9 js-ticket-popup-download-name">
                        <img src="' . jssupportticket::$_pluginpath . 'includes/images/userdownloads.png" />
                        <span class="js-ticket-popup-row-text">
                            ' . $download->filename . '
                            <div class="js-ticket-popup-row-filesize">(' . $download->filesize . ') </div>
                        </span>
                    </div>
                   <div class="js-col-xs-12 js-col-md-3 js-ticket-popup-row-button">
                        <a class="js-ticket-popup-row-button-a" href="' . $path . '" target="_blank">
                            '.__('Download','js-support-ticket').'
                        </a>
                    </div>
                </div>';
        }
        $result['data'] .= '</div>';
        $result['downloadallbtn'] = '
                                    <div class="js-col-xs-12 js-col-md-12 download_all_btn">
                                        <div class="js-ticket-popup-row-button-all">
                                        <a class="js-ticket-popup-row-button-a" href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=download&task=downloadall&action=jstask&downloadid=' . $downloadid) . '" onclick="" target="_blank">
                                            '.__('Download All','js-support-ticket').'
                                        </a>
                                        </div>
                                    </div>';
        $result['title'] = $downloads[0]->title;
        return json_encode($result);
    }

    function getAllDownloads() {
        $downloadid = JSSTrequest::getVar('downloadid');
		if(!class_exists('PclZip')){
			require_once(jssupportticket::$_path . 'includes/lib/pclzip.lib.php');
		}
        $path = jssupportticket::$_path;
        $path .= 'zipdownloads';
        JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        $randomfolder = $this->getRandomFolderName($path);
        $path .= '/' . $randomfolder;
        JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        $archive = new PclZip($path . '/alldownloads.zip');
        
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $jpath = $maindir['basedir'];
        $jpath = $jpath .'/'.$datadirectory;
        $directory = $jpath . '/attachmentdata/downloads/download_' . $downloadid . '/';

        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        $filelist = '';
        foreach ($scanned_directory AS $file) {
            $filelist .= $directory . '/' . $file . ',';
        }
        $filelist = substr($filelist, 0, strlen($filelist) - 1);
        $v_list = $archive->create($filelist, PCLZIP_OPT_REMOVE_PATH, $directory);
        if ($v_list == 0) {
            die("Error : '" . $archive->errorInfo() . "'");
        }
        $file = $path . '/alldownloads.zip';
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
        @unlink($file);
        $path = jssupportticket::$_path;
        $path .= 'zipdownloads';
        $path .= '/' . $randomfolder;
        @unlink($path . '/index.html');
        rmdir($path);
        exit();
    }

    function getRandomFolderName($path) {
        $match = '';
        do {
            $rndfoldername = "";
            $length = 5;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            $maxlength = strlen($possible);
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            $i = 0;
            while ($i < $length) {
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                if (!strstr($rndfoldername, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $rndfoldername .= $char;
                            $i++;
                        }
                    } else {
                        $rndfoldername .= $char;
                        $i++;
                    }
                }
            }
            $folderexist = $path . '/' . $rndfoldername;
            if (file_exists($folderexist))
                $match = 'Y';
            else
                $match = 'N';
        }while ($match == 'Y');

        return $rndfoldername;
    }
    
    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT filename,downloadid FROM `".jssupportticket::$_db->prefix."js_ticket_downloads_attachments` WHERE id = $id";
        $object = jssupportticket::$_db->get_row($query);
        $filename = $object->filename;
        $downloadid = $object->downloadid;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/attachmentdata';
        $path = $path . '/downloads/download_' . $downloadid;
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
