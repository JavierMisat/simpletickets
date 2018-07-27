<?php

// Creating the widget 
class JSSTmailnotification_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'JSSTmailnotification_widget',
// Widget name will appear in UI
                __('Mail Notification Widget', 'js-support-ticket'),
// Widget description
                array('description' => __('Show new and reply mail notifications', 'js-support-ticket'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $layout = apply_filters('widget_layout', $instance['jstlay']);
        $maxrecord = apply_filters('widget_maxrecord', $instance['maxrecord']);
// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
        $layoutcss = ($layout == 1) ? 'vertical' : 'horizontal';
        JSSTincluder::getJSModel('mail')->getMailNotification_Widget($maxrecord);
        if(jssupportticket::$_data['widget_mailnotification'] != false){
            foreach(jssupportticket::$_data['widget_mailnotification'] AS $staff){
            ?>
                <div id="jsst-widget-mailnotification-wrapper" class="<?php echo $layoutcss; ?>">
                    <?php if ($staff->photo) { ?>
                        <img  src="<?php echo jssupportticket::$_pluginpath . jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . $staff->staffid . "/" . $staff->photo; ?>">
                    <?php } else { ?>
                        <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                    <?php } ?>
                    <div class="jsst-widget-mailnotification-inner-wrapper">
                        <span class="jsst-widget-mailnotification-upper"><?php echo $staff->subject; ?></span>
                        <span class="jsst-widget-mailnotification-upper">
                            <span class="jsst-widget-mailnotification-<?php echo ($staff->replytoid == 0) ? 'new':'replied'; ?>"><?php echo ($staff->replytoid == 0) ? __('New mail from','js-support-ticket'):__('Replied By','js-support-ticket'); ?></span>
                            <span class="jsst-widget-mailnotification-sender"><?php echo $staff->staffname; ?></span>
                            <span class="jsst-widget-mailnotification-created"><?php echo date_i18n(jssupportticket::$_config['date_format'],strtotime($staff->created)); ?></span>
                        </span>
                    </div>
                </div>
            <?php
            }
        }else{

        }
        echo $args['after_widget'];
    }

// Widget Backend 
    public function form($instance) {
        $title = (isset($instance['title'])) ? $instance['title'] : __('Mail Notification', 'js-support-ticket');
        $layout = (isset($instance['jstlay'])) ? $instance['jstlay'] : 1;
        $maxrecord = (isset($instance['maxrecord'])) ? $instance['maxrecord'] : 5;
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title', 'js-support-ticket'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('jstlay'); ?>"><?php __('Layout', 'js-support-ticket'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id('jstlay'); ?>" name="<?php echo $this->get_field_name('jstlay'); ?>" >
                <option value="1" <?php if (esc_attr($layout) == 1) echo "selected"; ?>><?php echo __('Vertical', 'js-support-ticket'); ?></option>
                <option value="2" <?php if (esc_attr($layout) == 2) echo "selected"; ?>><?php echo __('Horizontal', 'js-support-ticket'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('maxrecord'); ?>"><?php echo __('Max Record', 'js-support-ticket'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id(' maxrecord'); ?>" name="<?php echo $this->get_field_name('maxrecord'); ?>" type="text" value="<?php echo esc_attr($maxrecord); ?>" />
        </p>
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['jstlay'] = (!empty($new_instance['jstlay']) ) ? strip_tags($new_instance['jstlay']) : '';
        $instance['maxrecord'] = (!empty($new_instance['maxrecord']) ) ? strip_tags($new_instance['maxrecord']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function JSSTmailnotification_load_widget() {
    register_widget('JSSTmailnotification_widget');
}

add_action('widgets_init', 'JSSTmailnotification_load_widget');
?>
