<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfieldorderingModel {

    function getFieldOrderingForList() {
        // Pagination
        /*
          $query = "SELECT COUNT(`id`) FROM `".jssupportticket::$_db->prefix."js_ticket_fieldsordering` WHERE published = 1 AND fieldfor = 1";
          $total = jssupportticket::$_db->get_var($query);
          jssupportticket::$_data[1] = JSSTpagination::getPagination($total);
         */

        // Data
//        $query = "SELECT * FROM `".jssupportticket::$_db->prefix."js_ticket_fieldsordering` WHERE published = 1 AND fieldfor = 1 ORDER BY ordering LIMIT ".JSSTpagination::getOffset().", ".JSSTpagination::getLimit();
        $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` WHERE fieldfor = 1 ORDER BY ordering ";
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function changePublishStatus($id, $status) {
        if (!is_numeric($id))
            return false;
        if ($status == 'publish') {            
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET published = 1 WHERE id = " . $id . " AND cannotunpublish = 0";
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            JSSTmessage::setMessage(__('Field mark as published', 'js-support-ticket'),'updated');
        } elseif ($status == 'unpublish') {
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET published = 0 WHERE id = " . $id . " AND cannotunpublish = 0";
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            JSSTmessage::setMessage(__('Field mark as unpublished', 'js-support-ticket'),'updated');
        }
        return;
    }

    function changeRequiredStatus($id, $status) {
        if (!is_numeric($id))
            return false;
        if ($status == 'required') {            
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET required = 1 WHERE id = " . $id . " AND cannotunpublish = 0";
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            JSSTmessage::setMessage(__('Field mark as required', 'js-support-ticket'),'updated');
        } elseif ($status == 'unrequired') {
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET required = 0 WHERE id = " . $id . " AND cannotunpublish = 0";
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            JSSTmessage::setMessage(__('Field mark as not required', 'js-support-ticket'),'updated');
        }
        return;
    }

    function changeOrder($id, $action) {
        if (!is_numeric($id))
            return false;
        if ($action == 'down') {
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` AS f1, `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` AS f2
                        SET f1.ordering = f1.ordering - 1 WHERE f1.ordering = f2.ordering + 1 AND f1.fieldfor = f2.fieldfor
                        AND f2.id = " . $id;
            jssupportticket::$_db->query($query);
            $query = " UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET ordering = ordering + 1 WHERE id = " . $id;
            jssupportticket::$_db->query($query);
            JSSTmessage::setMessage(__('Field ordering down', 'js-support-ticket'),'updated');
        } elseif ($action == 'up') {
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` AS f1, `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` AS f2 SET f1.ordering = f1.ordering + 1 
                        WHERE f1.ordering = f2.ordering - 1 AND f1.fieldfor = f2.fieldfor AND f2.id = " . $id;
            jssupportticket::$_db->query($query);
            $query = " UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET ordering = ordering - 1 WHERE id = " . $id;
            jssupportticket::$_db->query($query);
            JSSTmessage::setMessage(__('Field ordering up', 'js-support-ticket'),'updated');
        }
        return;
    }

    function getFieldsOrderingforForm($fieldfor) {
        if (!is_numeric($fieldfor))
            return false;
        if (!is_user_logged_in()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $query = "SELECT  * FROM `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` WHERE ".$published." AND fieldfor =  " . $fieldfor . " ORDER BY ordering ";
        jssupportticket::$_data['fieldordering'] = jssupportticket::$_db->get_results($query);
        return;
    }

    function storeUserField($data) {
        if (empty($data)) {
            return false;
        }
        if ($data['isuserfield'] == 1) {
            // value to add as field ordering
            if ($data['id'] == '') { // only for new
                $query = "SELECT max(ordering) FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering ";
                $var = jssupportticket::$_db->get_var($query);
                $data['ordering'] = $var + 1;
                if(isset($data['userfieldtype']) && $data['userfieldtype'] == 'file'){
                    $data['cannotsearch'] = 1;
                    $data['cannotshowonlisting'] = 1;
                }else{
                    $data['cannotsearch'] = 0;
                }
                $query = "SELECT max(id) FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering ";
                $var = jssupportticket::$_db->get_var($query);
                $var = $var + 1;
                $fieldname = 'ufield'.$var;
            }else{
                $fieldname = $data['field'];
            }

            $params = '';
            //code for depandetn field
            if (isset($data['userfieldtype']) && $data['userfieldtype'] == 'depandant_field') {
                if ($data['id'] != '') {
                    //to handle edit case of depandat field
                    $data['arraynames'] = $data['arraynames2'];
                }
                $flagvar = $this->updateParentField($data['parentfield'], $data['field'], $data['fieldfor']);
                if ($flagvar == false) {
                    return SAVE_ERROR;
                }
                if (!empty($data['arraynames'])) {
                    $valarrays = explode(',', $data['arraynames']);
                    foreach ($valarrays as $key => $value) {
                        $keyvalue = $value;
                        $value = str_replace(' ','_',$value);
                        if ($data[$value] != null) {
                            $params[$keyvalue] = array_filter($data[$value]);
                        }
                    }
                }
            }
            if (!empty($data['values'])) {
                foreach ($data['values'] as $key => $value) {
                    if ($value != null) {
                        $params[] = trim($value);
                    }
                }
            }
            if(!empty($params)){
                $params = json_encode($params);
                $data['userfieldparams'] = $params;
            }
        }else{
            $fieldname = $data['field'];
        }
            $query_array = array('id' => $data['id'],
                'userfieldtype' => $data['userfieldtype'],
                'field' => $fieldname,
                'fieldtitle' => $data['fieldtitle'],
                'showonlisting' => $data['showonlisting'],
                'cannotshowonlisting' => $data['cannotshowonlisting'],
                'published' => $data['published'],
                'search_user' => $data['search_user'],
                'cannotsearch' => $data['cannotsearch'],
                'required' => $data['required'],
                'size' => $data['size'],
                'maxlength' => $data['maxlength'],
                'cols' => $data['cols'],
                'rows' => $data['rows'],
                'depandant_field' => $data['depandant_field'],
                'fieldfor' => 1,
                'ordering' => $data['ordering'],
                'isuserfield' => $data['isuserfield'],
                'userfieldparams' => $data['userfieldparams'],
                'section' => 10,
                'isvisitorpublished' => $data['isvisitorpublished'],
                'search_visitor' => $data['search_visitor'],
                'size' => $data['size']
            );
                
//echo '<pre>';print_r($query_array);die();
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_fieldsordering', $query_array);
        $ticketid = jssupportticket::$_db->insert_id; // get the ticket id
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
            JSSTmessage::setMessage(__('Field has not been stored', 'js-support-ticket'), 'error');
        } else {        
            JSSTmessage::setMessage(__('Field has been stored', 'js-support-ticket'), 'updated');
        }
    }

    function updateField($data) {
        if (empty($data)) {
            return false;
        }
        $inquery = '';
        $clasue = '';
        if(isset($data['fieldtitle']) && $data['fieldtitle'] != null){
            $inquery .= $clasue." fieldtitle = '". $data['fieldtitle']."'";
            $clasue = ' , ';
        }
        if(isset($data['published']) && $data['published'] != null){
            $inquery .= $clasue." published = ". $data['published'];
            $clasue = ' , ';
        }
        if(isset($data['isvisitorpublished']) && $data['isvisitorpublished'] != null){
            $inquery .= $clasue." isvisitorpublished = ". $data['isvisitorpublished'];
            $clasue = ' , ';
        }
        if(isset($data['required']) && $data['required'] != null){
            $inquery .= $clasue." required = ". $data['required'];
            $clasue = ' , ';
        }
        if(isset($data['search_user']) && $data['search_user'] != null){
            $inquery .= $clasue." search_user = ". $data['search_user'];
            $clasue = ' , ';
        }
        if(isset($data['search_visitor']) && $data['search_visitor'] != null){
            $inquery .= $clasue." search_visitor = ". $data['search_visitor'];
            $clasue = ' , ';
        }
        if(isset($data['showonlisting']) && $data['showonlisting'] != null){
            $inquery .= $clasue." showonlisting = ". $data['showonlisting'];
            $clasue = ' , ';
        }
        
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET ".$inquery." WHERE id = " . $data['id'] ;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        JSSTmessage::setMessage(__('Field has been updated', 'js-support-ticket'),'updated');
        
        return;
    }

    function updateParentField($parentfield, $field) {
        if(!is_numeric($parentfield)) return false;
 
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` SET depandant_field = '" . $field . "' WHERE id = " . $parentfield;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return true;
    }

    function getFieldsForComboByFieldFor() {
        $fieldfor = JSSTrequest::getVar('fieldfor');
        $parentfield = JSSTrequest::getVar('parentfield');
        $query = "SELECT fieldtitle AS text ,id FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo') ";
        $data = jssupportticket::$_db->get_results($query);

        $query = "SELECT id FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo') AND depandant_field = '" . $parentfield . "' ";
        $parent = jssupportticket::$_db->get_var($query);
        $jsFunction = 'getDataOfSelectedField();';
        $html = JSSTformfield::select('parentfield', $data, $parent, __('Select', 'js-support-ticket') .'&nbsp;'. __('Parent Field', 'js-support-ticket'), array('onchange' => $jsFunction, 'class' => 'inputbox one'));
        $data = json_encode($html);
        return $data;
    }

    function getSectionToFillValues() {
        $field = JSSTrequest::getVar('pfield');
        $query = "SELECT userfieldparams FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE id=$field";
        $data = jssupportticket::$_db->get_var($query);
        $data = json_decode($data);
        $html = '';
        $fieldsvar = '';
        $comma = '';
        for ($i = 0; $i < count($data); $i++) {
            $fieldsvar .= $comma . "$data[$i]";
            $textvar = $data[$i];
            $textvar .='[]';
            $html .= "<div class='js-field-wrapper js-row no-margin'>";
            $html .= "<div class='js-field-title js-col-lg-3 js-col-md-3 no-padding'>" . $data[$i] . "</div>";
            $html .= "<div class='js-col-lg-9 js-col-md-9 no-padding combo-options-fields' id=" . $data[$i] . ">
                            <span class='input-field-wrapper'>
                                " . JSSTformfield::text($textvar, '', array('class' => 'inputbox one user-field')) . "
                                <img class='input-field-remove-img' src='" . jssupportticket::$_pluginpath . "includes/images/remove.png' />
                            </span>
                            <input type='button' id='depandant-field-button' onClick='getNextField(\"" . $data[$i] . "\", this);'  value='Add More' />
                        </div>";
            $html .= "</div>";
            $comma = ',';
        }
        $html .= " <input type='hidden' name='arraynames' value='" . $fieldsvar . "' />";
        $html = json_encode($html);
        return $html;
    }

    function getOptionsForFieldEdit() {
        $field = JSSTrequest::getVar('field');
        $yesno = array(
            (object) array('id' => 1, 'text' => __('JYes', 'js-support-ticket')),
            (object) array('id' => 0, 'text' => __('JNo', 'js-support-ticket')));

        $query = "SELECT * FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE id=$field";
        $data = jssupportticket::$_db->get_row($query);

        $html = '<span class="popup-top">
                    <span id="popup_title" >
                    ' . __("Edit Field", 'js-support-ticket') . '
                    </span>
                    <img id="popup_cross" onClick="close_popup();" src="' . jssupportticket::$_pluginpath . 'includes/images/close.png">
                </span>';
        $html .= '<form id="adminForm" class="popup-field-from" method="post" action="' . admin_url("?page=fieldordering&task=savefeild") . '">';
        $html .= '<div class="popup-field-wrapper">
                    <div class="popup-field-title">' . __('Field Title', 'js-support-ticket') . '<font class="required-notifier">*</font></div>
                    <div class="popup-field-obj">' . JSSTformfield::text('fieldtitle', isset($data->fieldtitle) ? $data->fieldtitle : 'text', '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                </div>';
        if ($data->cannotunpublish == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('User Published', 'js-support-ticket') . '</div>
                        <div class="popup-field-obj">' . JSSTformfield::select('published', $yesno, isset($data->published) ? $data->published : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Visitor published', 'js-support-ticket') . '</div>
                        <div class="popup-field-obj">' . JSSTformfield::select('isvisitorpublished', $yesno, isset($data->isvisitorpublished) ? $data->isvisitorpublished : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';

            $html .= '<div class="popup-field-wrapper">
                    <div class="popup-field-title">' . __('Required', 'js-support-ticket') . '</div>
                    <div class="popup-field-obj">' . JSSTformfield::select('required', $yesno, isset($data->required) ? $data->required : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                </div>';
        }

        if ($data->cannotsearch == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('User Search', 'js-support-ticket') . '</div>
                        <div class="popup-field-obj">' . JSSTformfield::select('search_user', $yesno, isset($data->search_user) ? $data->search_user : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Visitor Search', 'js-support-ticket') . '</div>
                        <div class="popup-field-obj">' . JSSTformfield::select('search_visitor', $yesno, isset($data->search_visitor) ? $data->search_visitor : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        if ($data->isuserfield == 1 || $data->cannotshowonlisting == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Show On Listing', 'js-support-ticket') . '</div>
                        <div class="popup-field-obj">' . JSSTformfield::select('showonlisting', $yesno, isset($data->showonlisting) ? $data->showonlisting : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        $html .= JSSTformfield::hidden('form_request', 'jssupportticket');
        $html .= JSSTformfield::hidden('id', $data->id);
        $html .= JSSTformfield::hidden('isuserfield', $data->isuserfield);
        $html .= JSSTformfield::hidden('fieldfor', $data->fieldfor);
        $html .='<div class="js-submit-container js-col-lg-10 js-col-md-10 js-col-md-offset-1 js-col-md-offset-1">
                    ' . JSSTformfield::submitbutton('save', __('Save', 'js-support-ticket'), array('class' => 'button'));
        if ($data->isuserfield == 1) {
            $html .= '<a class="button" style="margin-left:10px;" id="user-field-anchor" href="?page=fieldordering&jstlay=adduserfeild&jssupportticketid=' . $data->id .'"> ' . __('Advanced', 'js-support-ticket') . ' </a>';
        }

        $html .='</div>
            </form>';
        return json_encode($html);
    }

    function deleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $query = "SELECT field,fieldfor FROM `".jssupportticket::$_db->prefix."js_ticket_fieldsordering` WHERE id = $id";
        $result = jssupportticket::$_db->get_row($query);
        if ($this->userFieldCanDelete($result) == true) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_fieldsordering', array('id' => $id));
        }
        return IN_USE;
    }

    function enforceDeleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $query = "SELECT field,fieldfor FROM `".jssupportticket::$_db->prefix."js_ticket_fieldsordering` WHERE id = $id";
        $result = jssupportticket::$_db->get_row($query);
        if ($this->userFieldCanDelete($result) == true) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_fieldsordering', array('id' => $id));
        }
        return IN_USE;
    }

    function userFieldCanDelete($field) {
        $fieldname = $field->field;
        $fieldfor = $field->fieldfor; 

        if($fieldfor == 1){//for deleting a ticket field
            $table = "tickets";
        }
        $query = ' SELECT
                    ( SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_'.$table.'` WHERE 
                        params LIKE \'%"' . $fieldname . '":%\' 
                    )
                    AS total';
        $total = jssupportticket::$_db->get_var($query);
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getUserfieldsfor($fieldfor) {
        if (!is_numeric($fieldfor))
            return false;
        if (!is_user_logged_in()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $query = "SELECT field,userfieldparams,userfieldtype FROM `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 AND " . $published;
        $fields = jssupportticket::$_db->get_results($query);
        return $fields;
    }

    function getUserUnpublishFieldsfor($fieldfor) {
        if (!is_numeric($fieldfor))
            return false;
        if (!is_user_logged_in()) {
            $published = ' isvisitorpublished = 0 ';
        } else {
            $published = ' published = 0 ';
        }
        $query = "SELECT field FROM `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 AND " . $published;
        $fields = jssupportticket::$_db->get_results($query);
        return $fields;
    }

    function getFieldTitleByFieldfor($fieldfor) {
        if (!is_numeric($fieldfor))
            return false;
        
        $query = "SELECT field,fieldtitle FROM `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` WHERE fieldfor = " . $fieldfor ;
        $fields = jssupportticket::$_db->get_results($query);
        $fielddata = array();
        foreach ($fields as $value) {
            $fielddata[$value->field] = $value->fieldtitle;
        }
        return $fielddata;
    }

    function getUserFieldbyId($id,$fieldfor) {
        if ($id) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE id = " . $id;
            jssupportticket::$_data[0]['userfield'] = jssupportticket::$_db->get_row($query);
            $params = jssupportticket::$_data[0]['userfield']->userfieldparams;
            jssupportticket::$_data[0]['userfieldparams'] = !empty($params) ? json_decode($params, True) : '';
        }
        jssupportticket::$_data[0]['fieldfor'] = $fieldfor;
        return;
    }

    function DataForDepandantField(){ 
        $val = JSSTrequest::getVar('fvalue'); 
        $childfield = JSSTrequest::getVar('child'); 
        $query = "SELECT userfieldparams,fieldtitle FROM `".jssupportticket::$_db->prefix."js_ticket_fieldsordering` WHERE field = '".$childfield."'"; 
        $data = jssupportticket::$_db->get_row($query); 
        $decoded_data = json_decode($data->userfieldparams); 
        $comboOptions = array(); 
        $flag = 0; 
        foreach ($decoded_data as $key => $value) { 
            if($key==$val){ 
               for ($i=0; $i <count($value) ; $i++) {  
                   $comboOptions[] = (object)array('id' => $value[$i], 'text' => $value[$i]); 
                   $flag = 1; 
               } 
            } 
        } 
        $textvar =  ($flag == 1) ?  __('Select', 'js-support-ticket').' '.$data->fieldtitle : '';  
        $html = JSSTformfield::select($childfield, $comboOptions, '',$textvar, array('data-validation' => '','class' => 'inputbox one')); 
        $phtml = json_encode($html); 
        return $phtml; 
    }

}

?>