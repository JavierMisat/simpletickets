<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
    function checkCategoriesParent(val, type) {
        var parentid = jQuery("select#parentid").val();
        if (val == true && parentid != '') {
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, type: type, jstmod: 'knowledgebase', task: 'checkParentType'}, function (data) {
                if (data) {
                    jQuery("div#msgshowcategory").html(data);
                }
            });
        } else {
            var currentid = jQuery("input#id").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', currentid: currentid, type: type, jstmod: 'knowledgebase', task: 'checkChildType'}, function (data) {
                if (data) {
                    jQuery("div#msgshowcategory").html(data);
                    jQuery("input#" + type + "1").attr('checked', 'true');
                }
            });
        }
    }
    function addTypeToParent(parentid, type) {
        jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, type: type, jstmod: 'knowledgebase', task: 'makeParentOfType'}, function (data) {
            if (data) {
                jQuery("div#msgshowcategory").html('');
            }
        });
    }
    function getTypeForByParentId(parentid) {
        jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, jstmod: 'knowledgebase', task: 'getTypeForByParentId'}, function (data) {
            if (data) {
                var array = jQuery.parseJSON(data);
                //reset the previous selection
                jQuery("input#kb1").removeAttr('checked');
                jQuery("input#downloads1").removeAttr('checked');
                jQuery("input#announcement1").removeAttr('checked');
                jQuery("input#faqs1").removeAttr('checked');
                if (array['kb'] == 1) {
                    jQuery("input#kb1").attr({'checked': 'true'});
                }
                if (array['downloads'] == 1) {
                    jQuery("input#downloads1").attr({'checked': 'true'});
                }
                if (array['announcement'] == 1) {
                    jQuery("input#announcement1").attr({'checked': 'true'});
                }
                if (array['faqs'] == 1) {
                    jQuery("input#faqs1").attr({'checked': 'true'});
                }
            }
        });
    }
    function closemsg(type) {
        type = type + '1';
        jQuery("input#" + type).attr('checked', false);
        jQuery("div#msgshowcategory").html('');
    }
    function checkCategoryForSelected(){
        var cat_for = jQuery('input[type="checkbox"]:checked').length;
        if (cat_for == 0) {
            alert('<?php echo __('Please select atleast one category for','js-support-ticket'); ?>');
            return false;
        }
        return true;
    }
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=knowledgebase&jstlay=listcategories');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Category', 'js-support-ticket'); ?></span>
</span>
<form method="post" enctype="multipart/form-data" action="<?php echo admin_url("admin.php?page=knowledgebase&task=savecategory"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category Name', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('name', isset(jssupportticket::$_data[0]->name) ? jssupportticket::$_data[0]->name : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Parent Category', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('parentid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox(null), isset(jssupportticket::$_data[0]->parentid) ? jssupportticket::$_data[0]->parentid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getTypeForByParentId(this.value);')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Type', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('type', array('1' => __('Public', 'js-support-ticket'), '0' => __('Private', 'js-support-ticket')), isset(jssupportticket::$_data[0]->type) ? jssupportticket::$_data[0]->type : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Logo', 'js-support-ticket'); ?></div>
        <div class="js-form-field">
            <input type="file" class="inputbox" name="filename"  size="20" maxlenght='30'/>
            <?php
            if (isset(jssupportticket::$_data[0]))
                if (jssupportticket::$_data[0]->logo != '') {
                    $datadirectory = jssupportticket::$_config['data_directory'];
                    $maindir = wp_upload_dir();
                    $path = $maindir['baseurl'];
                    $path = $path.'/' . $datadirectory;
                    $path .= "/knowledgebasedata/categories/category_" . jssupportticket::$_data[0]->id . "/" . jssupportticket::$_data[0]->logo;
                    ?> <img width="50px" height="50px" src="<?php echo $path; ?>"> <?php
                }
            ?>
        </div>
    </div>
    <div class="js-col-md-12" id="msgshowcategory"></div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category For', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('kb', array('1' => __('Knowledge Base', 'js-support-ticket')), isset(jssupportticket::$_data[0]->kb) ? jssupportticket::$_data[0]->kb : '0', array('class' => 'radiobutton', 'onchange' => "checkCategoriesParent(this.checked,'kb');")); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category For', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('downloads', array('1' => __('Downloads', 'js-support-ticket')), isset(jssupportticket::$_data[0]->downloads) ? jssupportticket::$_data[0]->downloads : '0', array('class' => 'radiobutton', 'onchange' => "checkCategoriesParent(this.checked,'downloads');")); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category For', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('announcement', array('1' => __('Announcement', 'js-support-ticket')), isset(jssupportticket::$_data[0]->announcement) ? jssupportticket::$_data[0]->announcement : '0', array('class' => 'radiobutton', 'onchange' => "checkCategoriesParent(this.checked,'announcement');")); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category For', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('faqs', array('1' => __("FAQ's", 'js-support-ticket')), isset(jssupportticket::$_data[0]->faqs) ? jssupportticket::$_data[0]->faqs : '0', array('class' => 'radiobutton', 'onchange' => "checkCategoriesParent(this.checked,'faqs');")); ?></div>
    </div>
    <span class="js-admin-title"><?php echo __('Meta Data Options', 'js-support-ticket'); ?></span>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Meta Description', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><textarea name="metadesc" cols="50" rows="5"><?php echo (isset(jssupportticket::$_data[0]->metadesc)) ? jssupportticket::$_data[0]->metadesc : ''; ?></textarea></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Meta Keywords', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><textarea name="metakey" cols="50" rows="5"><?php echo (isset(jssupportticket::$_data[0]->metakey)) ? jssupportticket::$_data[0]->metakey : ''; ?></textarea></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Active', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
    <?php echo JSSTformfield::hidden('logo', isset(jssupportticket::$_data[0]->logo) ? jssupportticket::$_data[0]->logo : ''); ?>
    <?php echo JSSTformfield::hidden('action', 'knowledgebase_savecategory'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Category', 'js-support-ticket'), array('class' => 'button','onclick' => 'return checkCategoryForSelected();')); ?>
    </div>
</form>
