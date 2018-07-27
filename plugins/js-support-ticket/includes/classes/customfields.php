<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTcustomfields {
    function formCustomFields($field) {
        if($field->isuserfield != 1){
            return false;
        }
        $cssclass = "";
        $html = '';
        $div1 = (is_admin()) ? 'js-form-wrapper' : ($field->size == 100) ? 'js-col-md-12 js-form-wrapper' : 'js-col-md-6 js-form-wrapper' ;
        $div2 = (is_admin()) ? 'js-form-title' : 'js-col-md-12 js-form-title';
        $div3 = (is_admin()) ? 'js-form-field' : 'js-col-md-12 js-form-value';

        $required = $field->required;
        $html = '<div class="' . $div1 . '">
               <div class="' . $div2 . '">';
        if ($required == 1) {
            $html .= $field->fieldtitle . '<font color="red">*</font>';
            if ($field->userfieldtype == 'email')
                $cssclass = "email";
            else
                $cssclass = "required";
        }else {
            $html .= $field->fieldtitle;
            if ($field->userfieldtype == 'email')
                $cssclass = "email";
            else
                $cssclass = "";
        }
        $html .= ' </div><div class="' . $div3 . '">';
        //$readonly = $field->readonly ? "'readonly => 'readonly'" : "";
        $readonly = "";
        $maxlength = $field->maxlength ? "$field->maxlength" : "";
        $fvalue = "";
        $value = "";
        $userdataid = "";
        if (isset(jssupportticket::$_data[0]->id)) {
            $userfielddataarray = json_decode(jssupportticket::$_data[0]->params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = $userfielddataarray->$uffield;
            } else {
                $value = '';
            }
        }

        switch ($field->userfieldtype) {
            case 'text':
            case 'email':
                $html .= JSSTformfield::text($field->field, $value, array('class' => 'inputbox one', 'data-validation' => $cssclass, 'maxlength' => $maxlength, $readonly));
                break;
            case 'date':
                $html .= JSSTformfield::text($field->field, $value, array('class' => 'custom_date one', 'data-validation' => $cssclass));
                break;
            case 'textarea':
                $html .= JSSTformfield::textarea($field->field, $value, array('class' => 'inputbox one', 'data-validation' => $cssclass, 'rows' => $field->rows, 'cols' => $field->cols, $readonly));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    $i = 0;
                    $valuearray = explode(', ',$value);
                    foreach ($obj_option AS $option) {                        
                        $check = '';
                        if(in_array($option, $valuearray)){
                            $check = 'checked';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="radiobutton" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= JSSTformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $html .= JSSTformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass, 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $html .= JSSTformfield::select($field->field, $comboOptions, $value, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox one'));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if ($value != null) {
                    if (!empty($field->userfieldparams)) {
                        $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $html .= JSSTformfield::select($field->field, $comboOptions, $value, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox one'));
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $valuearray = explode(', ', $value);
                $html .= JSSTformfield::select($array, $comboOptions, $valuearray, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'multiple' => 'multiple', 'class' => 'inputbox one'));
                break;
            case 'file':
                $html .= '<input type="file" name="'.$field->field.'" id="'.$field->field.'"/>';
                if($value != null){
                    $html .= JSSTformfield::hidden($field->field.'_1', 0);
                    $html .= JSSTformfield::hidden($field->field.'_2',$value);
                    $jsFunction = "deleteCutomUploadedFile('".$field->field."_1')";
                    $html .='<span class='.$field->field.'_1>'.$value.'( ';
                    $html .= "<a href='#' onClick=".$jsFunction." >". __('Delete', 'js-support-ticket')."</a>";
                    $html .= ' )</span>';
                }
                break;
        }
        $html .= '</div></div>';
        echo $html;
        
    }

    function formCustomFieldsForSearch($field, &$i, $isadmin = 0) {
        if ($field->isuserfield != 1)
            return false;
        $cssclass = "";
        $html = '';
        $i++;
        $required = $field->required;
        $div1 = 'js-col-md-6 js-filter-wrapper';
        $div3 = 'js-col-md-12 js-filter-value';

        $html = '<div class="' . $div1 . '"> ';
        $html .= ' <div class="' . $div3 . '">';
        if($isadmin == 1){
            $html = ''; // only field send
        }
        $readonly = ''; //$field->readonly ? "'readonly => 'readonly'" : "";
        $maxlength = ''; //$field->maxlength ? "'maxlength' => '".$field->maxlength : "";
        $fvalue = "";
        $value = null;
        $userdataid = "";
        $userfielddataarray = array();
        if (isset(jssupportticket::$_data['filter']['params'])) {
            $userfielddataarray = jssupportticket::$_data['filter']['params'];
            $uffield = $field->field;
            //had to user || oprator bcz of radio buttons

            if (isset($userfielddataarray[$uffield]) || !empty($userfielddataarray[$uffield])) {
                $value = $userfielddataarray[$uffield];
            } else {
                $value = '';
            }
        }
        switch ($field->userfieldtype) {
            case 'text':
            case 'file':
            case 'email':
                $html .= JSSTformfield::text($field->field, $value, array('class' => 'inputbox one', 'data-validation' => $cssclass,'placeholder' =>$field->fieldtitle, $maxlength, $readonly));
                break;
            case 'date':
                $html .= JSSTformfield::text($field->field, $value, array('class' => 'custom_date one', 'data-validation' => $cssclass));
                break;
            case 'editor':
                $html .= wp_editor(isset($value) ? $value : '', $field->field, array('media_buttons' => false, 'data-validation' => $cssclass));
                break;
            case 'textarea':
                $html .= JSSTformfield::textarea($field->field, $value, array('class' => 'inputbox one', 'data-validation' => $cssclass, 'rows' => $field->rows, 'cols' => $field->cols, $readonly));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    if(empty($value))
                        $value = array();
                    foreach ($obj_option AS $option) {
                        if( in_array($option, $value)){
                            $check = 'checked="true"';
                        }else{
                            $check = '';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="radiobutton" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= JSSTformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $html .= JSSTformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass, "autocomplete" => "off", 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $html .= JSSTformfield::select($field->field, $comboOptions, $value, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox one'));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                    if (!empty($obj_option)) {
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $html .= JSSTformfield::select($field->field, $comboOptions, $value, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox one'));
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $html .= JSSTformfield::select($array, $comboOptions, $value, __('Select', 'js-support-ticket') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'multiple' => 'multiple'));
                break;
        }
        if($isadmin == 1){
            echo $html;
            return;
        }
        $html .= '</div></div>';
        echo $html;
        
    }

    function showCustomFields($field, $fieldfor, $params) {
        $html = '';
        $fvalue = '';        
        
        if(!empty($params)){
            $data = json_decode($params,true);
            if(array_key_exists($field->field, $data)){
                $fvalue = $data[$field->field];
            }
        }
        if($fieldfor == 1){ // tickets listing/my tickets, admin tickets and staff tickets
            $html = '<div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">';
            if($field->userfieldtype=='file'){
            $html .= '<span class="js-ticket-title">' . $field->fieldtitle . ':&nbsp</span>';
               if($fvalue !=null){
                    $path = admin_url("?page=ticket&action=jstask&task=downloadbyname&id=".jssupportticket::$_data['ticketid']."&name=".$fvalue);
                    $html .= '
                        <div class="js_ticketattachment">
                            ' . $field->fieldtitle . ' ( ' . $fvalue . ' ) ' . '              
                            <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                        </div>';
                }
            }else{
            $html .= '<span class="js-ticket-title">' . $field->fieldtitle . ':&nbsp</span>';
                $html .= '<span class="js-ticket-value">' . $fvalue . '</span>';
            }
            
                $html .= '</div>';
        }elseif($fieldfor == 2){ // ticket detail front end
            $html = '<div class="js-col-xs-12 js-col-md-12 js-ticket-detail-wrapper-padding-xs js-ticket-body-data-elipses"  >';
            if($field->userfieldtype=='file'){
            $html .= '<span class="js-ticket-title">' . $field->fieldtitle . ':&nbsp</span>';
               if($fvalue !=null){
                    $path = admin_url("?page=ticket&action=jstask&task=downloadbyname&id=".jssupportticket::$_data['custom']['ticketid']."&name=".$fvalue);
                    $html .= '
                        <div class="js_ticketattachment">
                            ' . $field->fieldtitle . ' ( ' . $fvalue . ' ) ' . '              
                            <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                        </div>';
                }
            }else{
                $html .=    '<span class="js-ticket-title textstylebold">' . $field->fieldtitle . ':&nbsp</span>
                        <span class="js-ticket-value">' . $fvalue . '</span>';
            }
            $html .=   '</div>';
        }

        return $html;
    }

    function userFieldsData($fieldfor, $listing = null) {
        if (!is_user_logged_in()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $inquery = '';
        if ($listing == 1) {
            $inquery = ' AND showonlisting = 1 ';
        }
        $query = "SELECT field,fieldtitle,isuserfield,userfieldtype,userfieldparams  FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND fieldfor =" . $fieldfor . $inquery." ORDER BY ordering";
        $data = jssupportticket::$_db->get_results($query);
        return $data;
    }

    function userFieldsForSearch($fieldfor) {
        if (!is_user_logged_in()) {
            $inquery = ' isvisitorpublished = 1 AND search_user =1';
        } else {
            $inquery = ' published = 1 AND search_visitor =1';
        }
        
        $query = "SELECT rows,cols,required,field,fieldtitle,isuserfield,userfieldtype,userfieldparams,depandant_field  FROM " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE isuserfield = 1 AND " . $inquery . " AND fieldfor =" . $fieldfor ." ORDER BY ordering ";
        $data = jssupportticket::$_db->get_results($query);
        return $data;
    }

    function getDataForDepandantFieldByParentField($fieldfor, $data) {
        if (!is_user_logged_in()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $value = '';
        $returnarray = array();
        $query = "SELECT field from " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND depandant_field ='" . $fieldfor . "'";
        $field = jssupportticket::$_db->get_var($query);
        if ($data != null) {
            foreach ($data as $key => $val) {
                if ($key == $field) {
                    $value = $val;
                }
            }
        }
        $query = "SELECT userfieldparams from " . jssupportticket::$_db->prefix . "js_ticket_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND field ='" . $fieldfor . "'";
        $field = jssupportticket::$_db->get_var($query);
        $fieldarray = json_decode($field);
        foreach ($fieldarray as $key => $val) {
            if ($value == $key)
                $returnarray = $val;
        }
        return $returnarray;
    }

}

?>
