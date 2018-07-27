<?php
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
wp_enqueue_style('jquery-ui-css', 'http://www.example.com/your-plugin-path/css/jquery-ui.css');
wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        jQuery("#tk_attachment_add").click(function () {
            var obj = this;
            var current_files = jQuery('input[type="file"]').length;
            var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
            var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20' maxlenght='30'  /><span  class='tk_attachment_remove'></span></span>";
            if (current_files < total_allow) {
                jQuery(".tk_attachment_value_wrapperform").append(append_text);
            } else if ((current_files === total_allow) || (current_files > total_allow)) {
                alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                obj.hide();
            }
        });
        jQuery(document).delegate(".tk_attachment_remove", "click", function (e) {
            jQuery(this).parent().remove();
            var current_files = jQuery('input[type="file"]').length;
            var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
            if (current_files < total_allow) {
                jQuery("#tk_attachment_add").show();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
<span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=knowledgebase&jstlay=listarticles');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Knowledge Base', 'js-support-ticket'); ?></span>
</span>
<form method="post" action="<?php echo admin_url("admin.php?page=knowledgebase&task=savearticle"); ?>" enctype="multipart/form-data" >
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('kb'), isset(jssupportticket::$_data[0]->categoryid) ? jssupportticket::$_data[0]->categoryid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Type', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('type', array('1' => __('Public', 'js-support-ticket'), '2' => __('Private', 'js-support-ticket'), '2' => __('Draft', 'js-support-ticket')), isset(jssupportticket::$_data[0]->type) ? jssupportticket::$_data[0]->type : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data[0]->subject) ? jssupportticket::$_data[0]->subject : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Content', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->content) ? jssupportticket::$_data[0]->content : '', 'articlecontent', array('media_buttons' => false)); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Attachments', 'js-support-ticket'); ?></div>
        <div class="js-form-field">
            <div class="tk_attachment_value_wrapperform">
                <span class="tk_attachment_value_text">
                    <input type="file" class="inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                    <span class='tk_attachment_remove'></span>
                </span>
            </div>
            <span class="tk_attachments_configform">
                <small><?php echo __('Maximum File Size', 'js-support-ticket');
echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
            </span>
            <span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File', 'js-support-ticket'); ?></span>
            <?php 
            if (!empty(jssupportticket::$_data[5])) {
                foreach (jssupportticket::$_data[5] AS $attachment) {
                    $id = isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '';
                    echo '
	        					<div class="js_ticketattachment">
	        						' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
	        						<a href="?page=articleattachmet&task=deleteattachment&action=jstask&id=' . $attachment->id . '&articleid=' . $id . '">' . __('Delete attachment','js-support-ticket') . '</a>
	        					</div>';
                }
            }
            ?>
        </div>
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
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
    <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : '' ); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
    <?php echo JSSTformfield::hidden('action', 'knowledgebase_savearticle'); ?>
        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
<?php echo JSSTformfield::submitbutton('save', __('Save Knowledge Base', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>
