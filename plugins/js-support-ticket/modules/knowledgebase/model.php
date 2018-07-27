<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTknowledgebaseModel {

    function getAllStaffCategories() {
        $isadmin = is_admin();
        $catname = ($isadmin) ? 'catname' : 'jsst-cat';
        $name = JSSTrequest::getVar($catname);
        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['catname'] = $name;
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $name = (isset($_SESSION['JSST_SEARCH']['catname']) && $_SESSION['JSST_SEARCH']['catname'] != '') ? $_SESSION['JSST_SEARCH']['catname'] : null;
        }
        $name = jssupportticket::parseSpaces($name);
        $inquery = '';
        $condition = " WHERE ";
        if ($name != null) {
            $inquery = $condition . "category.name LIKE '%$name%'";
            $condition = " AND ";
        }

        jssupportticket::$_data['filter'][$catname] = $name;

        $result = array();
        $prefix = '|-- ';
        $query = "SELECT category.* from `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ";
        $query .= $inquery;
        $query .= $condition . "category.parentid = 0 ";

        $knowledgebase = jssupportticket::$_db->get_results($query);
        if (isset($knowledgebase)) {
            foreach ($knowledgebase as $kb) {
                $record = (object) array();
                $record->id = $kb->id;
                $record->name = $kb->name;
                $record->type = $kb->type;
                $record->kb = $kb->kb;
                $record->downloads = $kb->downloads;
                $record->faqs = $kb->faqs;
                $record->announcement = $kb->announcement;
                $record->created = $kb->created;
                $record->status = $kb->status;
                $result[] = $record;
                $this->getknowledgebasecategorychild($kb->id, $prefix, $result);
            }
        }
        $totalresult = count($result);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($totalresult);

        $finalresult = array();
        JSSTpagination::setLimit(JSSTpagination::getLimit() + JSSTpagination::getOffset());
        if (JSSTpagination::getLimit() >= $totalresult)
            JSSTpagination::setLimit($totalresult);
        for ($i = JSSTpagination::getOffset(); $i < JSSTpagination::getLimit(); $i++) {
            $finalresult[] = $result[$i];
        }
        jssupportticket::$_data[8] = $finalresult;
        return;
    }

    private function getknowledgebasecategorychild($parentid, $prefix, &$result, $for = null) {

        if (!is_numeric($parentid))
            return false;
        $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category WHERE category.parentid = " . $parentid;
        if ($for)
            $query .= " $for";
        $kbcategories = jssupportticket::$_db->get_results($query);
        if (!empty($kbcategories)) {
            foreach ($kbcategories as $cat) {
                $subrecord = (object) array();
                $subrecord->id = $cat->id;
                $subrecord->name = $prefix . __($cat->name, 'js-support-ticket');
                $subrecord->type = $cat->type;
                $subrecord->kb = $cat->kb;
                $subrecord->downloads = $cat->downloads;
                $subrecord->faqs = $cat->faqs;
                $subrecord->announcement = $cat->announcement;
                $subrecord->created = $cat->created;
                $subrecord->status = $cat->status;
                $result[] = $subrecord;
                $this->getknowledgebasecategorychild($cat->id, $prefix . '|-- ', $result, $for);
            }
            //return $result;
        }
    }

    // end of zain code

    function getCategoryForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT category.*
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category 
                        WHERE category.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function storeCategory($data) {
        $staffid = 0;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Category' : 'Edit Category';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());            
        }
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');

        $kb = isset($data['kb']) ? $data['kb'] : '0';
        $downloads = isset($data['downloads']) ? $data['downloads'] : '0';
        $announcement = isset($data['announcement']) ? $data['announcement'] : '0';
        $faqs = isset($data['faqs']) ? $data['faqs'] : '0';

        $query_array = array(
            'id' => $data['id'],
            'name' => $data['name'],
            'parentid' => $data['parentid'],
            'type' => $data['type'],
            'kb' => $kb,
            'downloads' => $downloads,
            'announcement' => $announcement,
            'faqs' => $faqs,
            'logo' => $data['logo'],
            'metadesc' => $data['metadesc'],
            'metakey' => $data['metakey'],
            'status' => $data['status'],
            'staffid' => $staffid,
            'created' => $data['created']
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_categories', $query_array);
        $lastid = jssupportticket::$_db->insert_id;

        $result = JSSTincluder::getObjectClass('uploads')->uploadCategoryLogo($lastid , $this);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Category has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Category has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function storeCategoryLogo($id , $filename){
        if(is_numeric($id)){
            jssupportticket::$_db->query("UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_categories` SET logo = '" . $filename . "' WHERE id = $id");
        }
    }

    function storeImage($id) {
        if (!is_numeric($id))
            return false;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $path = jssupportticket::$_path . $datadirectory;
        if (!file_exists($path)) { // create user directory
            JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        }
        $isupload = false;
        $path = $path . '/attachmentdata';
        if (!file_exists($path)) { // create user directory
            JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        }
        $path = $path . '/logo';
        if (!file_exists($path)) { // create user directory
            JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        }
        if ($_FILES['filename']['size'] > 0) {
            $file_name = str_replace(' ', '_', $_FILES['filename']['name']);
            $file_tmp = $_FILES['filename']['tmp_name']; // actual location

            $userpath = $path . '/logo_' . $id;
            if (!file_exists($userpath)) { // create user directory
                JSSTincluder::getJSModel('jssupportticket')->makeDir($userpath);
            }
            $isupload = true;
        }
        if ($isupload) {
            if (move_uploaded_file($file_tmp, $userpath . '/' . $file_name))
                echo "iam hre tin store";
        }
    }

    function removeCategory($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Category');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($this->canRemoveCategory($id)) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_categories', array('id' => $id));
            if (jssupportticket::$_db->last_error == null) {
                $this->deleteCatLogo($id);
                JSSTmessage::setMessage(__('Category has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('Category has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('Category in use cannot deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function deleteCatLogo( $id ){

        $datadirectory = jssupportticket::$_config['data_directory'];
        
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/knowledgebasedata/categories/category_'.$id;
        $files = glob($path . '/*.*');
        array_map('unlink', $files); // delete all file in the direcoty

        rmdir($path);
    }    

    private function canRemoveCategory($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE parentid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` WHERE categoryid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` WHERE categoryid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` WHERE categoryid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` WHERE categoryid = " . $id . ")
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

    function getCategoryForCombobox($for) {
        $result = array();
        $prefix = '|-- ';
        if ($for == null)
            $for = '';
        else
            $for = 'AND category.' . $for . ' = 1';
        $query = "SELECT category.* from `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ";
        $query .= " WHERE category.parentid = 0 $for AND category.status = 1";
        $knowledgebase = jssupportticket::$_db->get_results($query);
        if (isset($knowledgebase)) {
            foreach ($knowledgebase as $kb) {
                $record = (object) array();
                $record->id = $kb->id;
                $record->name = $kb->name;
                $record->type = $kb->type;
                $record->kb = $kb->kb;
                $record->downloads = $kb->downloads;
                $record->faqs = $kb->faqs;
                $record->announcement = $kb->announcement;
                $record->created = $kb->created;
                $record->status = $kb->status;
                $result[] = $record;
                $this->getknowledgebasecategorychild($kb->id, $prefix, $result, $for);
            }
        }

        $list = '';
        foreach ($result AS $category) {
            $list[] = (object) array('id' => $category->id, 'text' => $category->name);
        }
        return $list;
    }

    function changeStatusCategory($id) {

        if (!is_numeric($id))
            return false;

        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_categories` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Category','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Category','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getStaffArticles() {
        $isadmin = is_admin();
        $subjectname = ($isadmin) ? 'subject' : 'jsst-subject';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';
        $typename = ($isadmin) ? 'type' : 'jsst-type';

        $subject = JSSTrequest::getVar($subjectname);
        $categoryid = JSSTrequest::getVar($catname);
        $type = JSSTrequest::getVar($typename);

        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['subject'] = $subject;
                $_SESSION['JSST_SEARCH']['type'] = $type;
                $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
            $type = (isset($_SESSION['JSST_SEARCH']['type']) && $_SESSION['JSST_SEARCH']['type'] != '') ? $_SESSION['JSST_SEARCH']['type'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }
        $subject = jssupportticket::parseSpaces($subject);
        $inquery = '';
        $condition = " WHERE ";
        if ($subject != null) {
            $inquery .= $condition . "article.subject LIKE '%$subject%'";
            $condition = " AND ";
        }
        if ($type) {
            if (!is_numeric($type))
                return false;
            $inquery .= $condition . "article.type = " . $type;
            $condition = " AND ";
        }
        if ($categoryid) {
            if (!is_numeric($categoryid))
                return false;
            $inquery .= $condition . "article.categoryid= " . $categoryid;
        }

        jssupportticket::$_data['filter'][$subjectname] = $subject;
        jssupportticket::$_data['filter'][$catname] = $type;
        jssupportticket::$_data['filter'][$typename] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(article.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category on article.categoryid = category.id";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT article.*, category.name AS categoryname
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article 
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON article.categoryid = category.id 
                    ";
        $query .= $inquery;
        $query .= " ORDER BY article.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getArticleForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT article.*,category.name AS categoryname
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article 
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON article.categoryid = category.id 
                    WHERE article.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
            JSSTincluder::getJSModel('articleattachmet')->getAttachmentForForm($id);
        }
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeArticle($data) {
        $staffid = 0;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Knowledge Base' : 'Edit Knowledge Base';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id());            
        }
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $data['views'] = isset($data['views']) ? $data['views'] : '';
        $data['type'] = isset($data['type']) ? $data['type'] : '';
        $data['ordering'] = isset($data['ordering']) ? $data['ordering'] : '';
        $query_array = array('id' => $data['id'],
            'categoryid' => $data['categoryid'],
            'staffid' => $staffid,
            'subject' => $data['subject'],
            'content' => wpautop(wptexturize(stripslashes($data['articlecontent']))),
            'views' => $data['views'],
            'type' => $data['type'],
            'ordering' => $data['ordering'],
            'metadesc' => $data['metadesc'],
            'metakey' => $data['metakey'],
            'status' => $data['status'],
            'created' => $data['created']
        );
        if (!$data['id']) { //new
            $query_array['ordering'] = $this->getNextOrdering();
        } else {
            $query_array['ordering'] = $data['ordering'];
        }

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_articles', $query_array);
        $data['id'] = jssupportticket::$_db->insert_id; // get the downlowd id
        JSSTincluder::getJSModel('articleattachmet')->storeAttachments($data);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Knowledge base article has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Knowledge base article has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeArticle($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Knowledge Base');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }

        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_articles', array('id' => $id));
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_articles_attachments', array('articleid' => $id));
        if (jssupportticket::$_db->last_error == null) {
            $this->removeArticleAttachmentsByArticleId( $id );
            JSSTmessage::setMessage(__('Article has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Article has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function removeArticleAttachmentsByArticleId($id){
        if(!is_numeric($id)) return false;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/attachmentdata/articles/article_'.$id;
        $files = glob($path . '/*.*');
        array_map('unlink', $files); // delete all file in the direcoty

        rmdir($path);
    }


    function changeStatusArticle($id) {

        if (!is_numeric($id))
            return false;

        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_articles` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Article','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Article','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getKnowledgebaseCat() {

        $title = JSSTrequest::getVar('jsst-search');
        $title = jssupportticket::parseSpaces($title);
        $inquery = '';
        $inqueryarticle = '';
        if ($title != null) {
            $inquery .=" AND category.name LIKE '%$title%'";
            $inqueryarticle .=" AND article.subject LIKE '%$title%'";
            jssupportticket::$_data[0]['kb-filter']['search'] = $title;
        }

        $query = "SELECT category.name, category.id, category.logo
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.parentid = 0 AND kb = 1" . $inquery;

        $parentcat = jssupportticket::$_db->get_results($query);
        foreach ($parentcat as $cat) {
            $query = "SELECT category.name, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.parentid = " . $cat->id . " AND kb = 1 LIMIT 4";

            $cat->subcategory = jssupportticket::$_db->get_results($query);
        }
        // echo '<pre>';print_r($parentcat);echo '</pre>';exit;
        jssupportticket::$_data[0]['categories'] = $parentcat;
        // Pagination
        $query = "SELECT COUNT(article.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                    WHERE article.status = 1" . $inqueryarticle;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT article.subject,article.content, article.id AS articleid, attachment.id AS attachmentid, attachment.filename,attachment.filesize
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments` AS attachment
                    ON article.id = attachment.articleid
                    WHERE article.status = 1 ".$inqueryarticle;
        $query .=" ORDER BY article.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0]['articles'] = jssupportticket::$_db->get_results($query);
    }

    function getArticleDetails($id) {

        if (!is_numeric($id))
            return;

        $query = "SELECT article.id, article.subject, article.content, category.name
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category 
                ON article.categoryid = category.id
                WHERE article.id = " . $id;

        jssupportticket::$_data[0]['articledetails'] = jssupportticket::$_db->get_row($query);

        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }

        $query = "SELECT attachment.id,attachment.articleid, attachment.filename,attachment.filesize
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments` AS attachment
                WHERE attachment.articleid = " . $id;

        jssupportticket::$_data[0]['articledownloads'] = jssupportticket::$_db->get_results($query);

        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }

        return;
    }

    function getKnowledgebase($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;

        if ($id != 0)
            $inquery = " AND article.categoryid = " . $id;
        else
            $inquery = '';

        $query = "SELECT category.name, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.parentid = " . $id . " AND kb = 1";
        jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT category.name, category.logo, category.id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                    WHERE category.id = " . $id . " AND kb = 1";
        jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);

        // Pagination
        $query = "SELECT COUNT(article.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                    WHERE article.status = 1" . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT article.subject,article.content, article.id AS articleid
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS article
                    WHERE article.status = 1" . $inquery;
        $query .=" ORDER BY article.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0]['articles'] = jssupportticket::$_db->get_results($query);

        return;
    }

    function getTypeForByParentId() {
        $array = null;
        $parentid = JSSTrequest::getVar('parentid');
        if ($parentid) {
            if (!is_numeric($parentid))
                return false;
            $result = jssupportticket::$_db->get_row("SELECT kb,downloads,announcement,faqs FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE id = $parentid");
            $array['kb'] = $result->kb;
            $array['downloads'] = $result->downloads;
            $array['announcement'] = $result->announcement;
            $array['faqs'] = $result->faqs;
        }
        return json_encode($array);
    }

    function checkParentType() {
        $message = '';
        $type = JSSTrequest::getVar('type');
        $parentid = JSSTrequest::getVar('parentid');
        if ($parentid) {
            if (!is_numeric($parentid))
                return false;
            $result = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE id = $parentid");
            if ($result->$type != 1) {
                $message = '<div class="admin-title">' . __('You parent does not have this type', 'js-support-ticket') . '</div>';
                $message .= '<div class="admin-title">' . __('Would you like to add this type to parent', 'js-support-ticket') . '</div>';
                $message .= '<div class="admin-title"><a href="#" onclick="addTypeToParent(' . $parentid . ',\'' . $type . '\');">' . __('JYes', 'js-support-ticket') . '</a></div>';
                $message .= '<div class="admin-title"><a href="#" onclick="closemsg(\'' . $type . '\');">' . __('JNo', 'js-support-ticket') . '</a></div>';
            }
        }
        return $message;
    }

    function checkChildType() {
        $message = '';
        $type = JSSTrequest::getVar('type');
        $currentid = JSSTrequest::getVar('currentid');
        if ($currentid) {
            if (!is_numeric($currentid))
                return false;
            $result = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE parentid = $currentid");
            if ($result->$type == 1) {
                $message = '<div class="admin-title">' . __('Your child have this type', 'js-support-ticket') . '</div>';
                $message .= '<div class="admin-title">' . __('You cannot unmark it', 'js-support-ticket') . '</div>';
            }
        }
        return $message;
    }

    function makeParentOfType() {
        $parentid = JSSTrequest::getVar('parentid');
        $type = JSSTrequest::getVar('type');
        $this->makeParentOfTypeRecursive($parentid, $type);
        return true;
    }

    function makeParentOfTypeRecursive($parentid, $type) {
        if(!is_numeric($parentid)) return false;
        jssupportticket::$_db->query("UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_categories` SET $type = 1");
        $isparent = jssupportticket::$_db->get_var("SELECT parentid FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE id = $parentid");
        if ($isparent != 0)
            $this->makeParentOfTypeRecursive($isparent, $type);
        else
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
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_articles` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_articles` SET ordering = " . $result->ordering . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_articles` SET ordering = " . $result->ordering2 . " WHERE id = " . $result->id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Article','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Article','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>
