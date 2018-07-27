<?php

// Creating the widget 
class JSSTmyticket_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'JSSTmyticket_widget',
// Widget name will appear in UI
                __('My Ticket Widget', 'js-support-ticket'),
// Widget description
                array('description' => __('Show unanswered tickets', 'js-support-ticket'),)
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
        JSSTincluder::getJSModel('ticket')->getMyTicketInfo_Widget($maxrecord);
        if(jssupportticket::$_data['widget_myticket'] != false){
            foreach(jssupportticket::$_data['widget_myticket'] AS $ticket){
            ?>
                <div id="jsst-widget-myticket-wrapper" class="<?php echo $layoutcss; ?>">
                    <div class="jsst-widget-myticket-topbar">
                        <span class="jsst-widget-myticket-subject"><a href="<?php echo site_url('index.php?page_id='.jssupportticket::getPageId().'&jstmod=ticket&jstlay=ticketdetail&jssupportticketid='.$ticket->id); ?>"><?php echo $ticket->subject; ?></a></span>
                        <span class="jsst-widget-myticket-status" style="background:<?php echo ($ticket->status == 0) ? '#9ACC00' : '#217ac3'; ?>"><?php echo ($ticket->status == 0) ? __('New','js-support-ticket'): __('Waiting Your Reply','js-support-ticket'); ?></span>
                    </div>
                    <div class="jsst-widget-myticket-bottombar">
                        <span class="jsst-widget-myticket-priority" style="background:<?php echo $ticket->prioritycolour; ?>"><?php echo $ticket->priority; ?></span>
                        <span class="jsst-widget-myticket-from"><span class="widget-from"><?php echo __('From','js-support-ticket').' : '; ?></span><span class="widget-fromname"><?php echo $ticket->name; ?></span></span>
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
        $title = (isset($instance['title'])) ? $instance['title'] : __('My Tickets', 'js-support-ticket');
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
            <label for="<?php echo $this->get_field_id('maxrecord'); ?>"><?php echo __('Max record', 'js-support-ticket'); ?></label> 
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
function JSSTmyticket_load_widget() {
    register_widget('JSSTmyticket_widget');
}

add_action('widgets_init', 'JSSTmyticket_load_widget');
?>
