<?php
wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
$type = array((object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
);
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=announcement&jstlay=announcements');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Announcement', 'js-support-ticket'); ?></span></span>
<form method="post" action="<?php echo admin_url("admin.php?page=announcement&task=saveannouncement"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Category', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), isset(jssupportticket::$_data[0]->categoryid) ? jssupportticket::$_data[0]->categoryid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => '')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Type', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('type', $type, isset(jssupportticket::$_data[0]->type) ? jssupportticket::$_data[0]->type : '', __('Select Type', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('title', isset(jssupportticket::$_data[0]->title) ? jssupportticket::$_data[0]->title : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Description', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->description) ? jssupportticket::$_data[0]->description : '', 'description', array('media_buttons' => false)); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Active', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
    <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : ''); ?>
    <?php echo JSSTformfield::hidden('action', 'announcement_saveannouncement'); ?>
        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
<?php echo JSSTformfield::submitbutton('save', __('Save Announcement', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>
