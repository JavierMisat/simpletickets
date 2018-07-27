<?php
if ( class_exists( 'Vc_Manager' ) ) {

    add_action( 'init', 'themestudio_register_vc_shortcodes' );
    function themestudio_register_vc_shortcodes()
    {
//****************************************************** Variable ******************************************************//
        $add_yes_no = array(
            'type'        => 'dropdown',
            'heading'     => __( 'Choose Animation', 'alaska' ),
            'param_name'  => 'onclick',
            'value'       => array(
                __( 'No', 'alaska' )  => 'no',
                __( 'Yes', 'alaska' ) => 'yes',
            ),
            'description' => __( 'Define action for choose event if needed.', 'alaska' ),
        );
        $add_css_animation = array(
            'type'        => 'dropdown',
            'heading'     => __( 'CSS Animation', 'alaska' ),
            'param_name'  => 'css_animation',
            'admin_label' => true,
            'value'       => array(
                __( 'No', 'alaska' )         => '',
                __( 'bounce', 'alaska' )     => 'bounce',
                __( 'rubberBand', 'alaska' ) => 'rubberBand',
                __( 'flash', 'alaska' )      => 'flash',
                __( 'pulse', 'alaska' )      => 'pulse',
                __( 'shake', 'alaska' )      => 'shake',
                __( 'swing', 'alaska' )      => 'swing',
                __( 'tada', 'alaska' )       => 'tada',
                __( 'wobble', 'alaska' )     => 'wobble',

                __( 'bounceIn', 'alaska' )           => 'bounceIn',
                __( 'bounceInDown', 'alaska' )       => 'bounceInDown',
                __( 'bounceInLeft', 'alaska' )       => 'bounceInLeft',
                __( 'bounceInRight', 'alaska' )      => 'bounceInRight',
                __( 'bounceInUp', 'alaska' )         => 'bounceInUp',
                __( 'bounceOut', 'alaska' )          => 'bounceOut',
                __( 'bounceOutDown', 'alaska' )      => 'bounceOutDown',
                __( 'bounceOutLeft', 'alaska' )      => 'bounceOutLeft',
                __( 'bounceOutRight', 'alaska' )     => 'bounceOutRight',
                __( 'bounceOutUp', 'alaska' )        => 'bounceOutUp',
                __( 'fadeIn', 'alaska' )             => 'fadeIn',
                __( 'fadeInDown', 'alaska' )         => 'fadeInDown',
                __( 'fadeInDownBig', 'alaska' )      => 'fadeInDownBig',
                __( 'fadeInLeft', 'alaska' )         => 'fadeInLeft',
                __( 'fadeInLeftBig', 'alaska' )      => 'fadeInLeftBig',
                __( 'fadeInRight', 'alaska' )        => 'fadeInRight',
                __( 'fadeInRightBig', 'alaska' )     => 'fadeInRightBig',
                __( 'fadeInUp', 'alaska' )           => 'fadeInUp',
                __( 'fadeInUpBig', 'alaska' )        => 'fadeInUpBig',
                __( 'fadeOut', 'alaska' )            => 'fadeOut',
                __( 'fadeOutDown', 'alaska' )        => 'fadeOutDown',
                __( 'fadeOutDownBig', 'alaska' )     => 'fadeOutDownBig',
                __( 'fadeOutLeft', 'alaska' )        => 'fadeOutLeft',
                __( 'fadeOutLeftBig', 'alaska' )     => 'fadeOutLeftBig',
                __( 'fadeOutRight', 'alaska' )       => 'fadeOutRight',
                __( 'fadeOutRightBig', 'alaska' )    => 'fadeOutRightBig',
                __( 'fadeOutUp', 'alaska' )          => 'fadeOutUp',
                __( 'fadeOutUpBig', 'alaska' )       => 'fadeOutUpBig',
                __( 'flip', 'alaska' )               => 'flip',
                __( 'flipInX', 'alaska' )            => 'flipInX',
                __( 'flipInY', 'alaska' )            => 'flipInY',
                __( 'flipOutX', 'alaska' )           => 'flipOutX',
                __( 'flipOutY', 'alaska' )           => 'flipOutY',
                __( 'lightSpeedIn', 'alaska' )       => 'lightSpeedIn',
                __( 'lightSpeedOut', 'alaska' )      => 'lightSpeedOut',
                __( 'rotateIn', 'alaska' )           => 'rotateIn',
                __( 'rotateInDownLeft', 'alaska' )   => 'rotateInDownLeft',
                __( 'rotateInDownRight', 'alaska' )  => 'rotateInDownRight',
                __( 'rotateInUpLeft', 'alaska' )     => 'rotateInUpLeft',
                __( 'rotateInUpRight', 'alaska' )    => 'rotateInUpRight',
                __( 'rotateOut', 'alaska' )          => 'rotateOut',
                __( 'rotateOutDownLeft', 'alaska' )  => 'rotateOutDownLeft',
                __( 'rotateOutDownRight', 'alaska' ) => 'rotateOutDownRight',
                __( 'rotateOutUpLeft', 'alaska' )    => 'rotateOutUpLeft',
                __( 'rotateOutUpRight', 'alaska' )   => 'rotateOutUpRight',
                __( 'hinge', 'alaska' )              => 'hinge',
                __( 'rollIn', 'alaska' )             => 'rollIn',
                __( 'rollOut', 'alaska' )            => 'rollOut',

                __( 'zoomIn', 'alaska' )             => 'zoomIn',
                __( 'zoomInDown', 'alaska' )         => 'zoomInDown',
                __( 'zoomInLeft', 'alaska' )         => 'zoomInLeft',
                __( 'zoomInRight', 'alaska' )        => 'zoomInRight',
                __( 'zoomInUp', 'alaska' )           => 'zoomInUp',
                __( 'zoomOut', 'alaska' )            => 'zoomOut',
                __( 'zoomOutDown', 'alaska' )        => 'zoomOutDown',
                __( 'zoomOutLeft', 'alaska' )        => 'zoomOutLeft',
                __( 'zoomOutRight', 'alaska' )       => 'zoomOutRight',
                __( 'zoomOutUp', 'alaska' )          => 'zoomOutUp',
                __( 'Appear from center', 'alaska' ) => "appear",
            ),
            'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'alaska' ),
            'dependency'  => array(
                'element' => 'onclick',
                'value'   => array( 'yes' ),
            ),
        );


        $data_wow_delay = array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Data Wow Delay", 'alaska' ),
            "param_name"  => "data_wow_delay",
            "value"       => "",
            "description" => __( "Data Wow Delay eg:0.2s,0.3s ...", 'alaska' ),
            'dependency'  => array(
                'element' => 'onclick',
                'value'   => array( 'yes' ),
            ),
        );
        $data_wow_duration = array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Data Wow Duration", 'alaska' ),
            "param_name"  => "data_wow_duration",
            "value"       => "",
            "description" => __( "Data Wow Duration eg:0.2s,0.3s ...", 'alaska' ),
            'dependency'  => array(
                'element' => 'onclick',
                'value'   => array( 'yes' ),
            ),
        );
        $add_css_style = array(
            'type'       => 'css_editor',
            'heading'    => __( 'Css', 'alaska' ),
            'param_name' => 'css',
            'group'      => __( 'Design options', 'alaska' ),
        );

        $add_css_awesome = array(
            'type'        => 'textfield',
            'heading'     => __( 'font awesome icon class', 'alaska' ),
            'param_name'  => 'css_awesome',
            'admin_label' => true,
            'value'       => '',
            'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a target="__blank" href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
        );

//WHMPRESS


//******************************************************************************************************/
// font basic
//******************************************************************************************************/
        $add_css_basic = array(
            'type'        => 'dropdown',
            'heading'     => __( 'font Basic icon class', 'alaska' ),
            'param_name'  => 'css_basic',
            'admin_label' => true,
            'value'       => array(
                __( 'No', 'alaska' )                       => '',
                __( 'icon-basic-joypad', 'alaska' )        => 'icon-basic-joypad',
                __( 'icon-basic-keyboard', 'alaska' )      => 'icon-basic-keyboard',
                __( 'icon-basic-laptop', 'alaska' )        => 'icon-basic-laptop',
                __( 'icon-basic-accelerator', 'alaska' )   => 'icon-basic-accelerator',
                __( 'icon-basic-alarm', 'alaska' )         => 'icon-basic-alarm',
                __( 'icon-basic-anchor', 'alaska' )        => 'icon-basic-anchor',
                __( 'icon-basic-anticlockwise', 'alaska' ) => 'icon-basic-anticlockwise',
                __( 'icon-basic-archive', 'alaska' )       => 'icon-basic-archive',
                __( 'icon-basic-archive-full', 'alaska' )  => 'icon-basic-archive-full',
                __( 'icon-basic-ban', 'alaska' )           => 'icon-basic-ban',
            ),

            'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'alaska' ),
        );

//******************************************************************************************************/
// Custom VC Row
//******************************************************************************************************/
        $setting = array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => __( "In container", 'alaska' ),
            "param_name"  => "container_class",
            "value"       => array(
                __( "No container", 'alaska' )         => "",
                __( "Inside container div", 'alaska' ) => "container",
            ),
            "description" => __( "With container class.", 'alaska' ),
        );
        vc_add_param( 'vc_row', $setting );
        $setting = array(
            'type'        => 'colorpicker',
            'holder'      => 'div',
            'class'       => '',
            'heading'     => __( 'Background overlay', 'alaska' ),
            'param_name'  => 'color_overlay',
            'value'       => '',
            'description' => "",
        );
        vc_add_param( 'vc_row', $setting );
        $setting = array(
            'type'        => 'textfield',
            'heading'     => __( 'Custom section id', 'alaska' ),
            'param_name'  => 'section_custom_id',
            'value'       => '',
            'description' => "",
        );
        vc_add_param( 'vc_row', $setting );

        $setting = array(
            'type'        => 'column_offset',
            'heading'     => __( 'Responsiveness', 'alaska' ),
            'param_name'  => 'offset',
            'group'       => __( 'Width & Responsiveness', 'alaska' ),
            'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'alaska' ),
        );
        vc_add_param( 'vc_column_inner', $setting );
//******************************************************************************************************/
// Custom VC TABS
//******************************************************************************************************/
        $setting = array(
            'type'        => 'dropdown',
            'heading'     => __( 'Choose style tab', 'alaska' ),
            'param_name'  => 'style_boder',
            'value'       => array(
                __( 'Style 1', 'alaska' ) => '',
                __( 'Style 2', 'alaska' ) => 'ts-tab-style2',
            ),
            'description' => "",
        );
        vc_add_param( 'vc_tabs', $setting );
//******************************************************************************************************/
// Accordion Overwrite Visual composer
//******************************************************************************************************/
        vc_map(
            array(
                'name'                    => __( 'Accordion Shortcode', 'alaska' ),
                'base'                    => 'vc_accordion',
                'show_settings_on_create' => false,
                'is_container'            => true,
                "category"                => __( 'ALASKA Blocks', 'alaska' ),
                'params'                  => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style accordion', 'alaska' ),
                        'param_name'  => 'choose_style_accordion',
                        'value'       => array(
                            __( 'Style accordion 1', 'alaska' ) => 'style1',
                            __( 'Style accordion 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose style accordion display on page.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Widget title', 'alaska' ),
                        'param_name'  => 'title',
                        'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Active section', 'alaska' ),
                        'param_name'  => 'active_tab',
                        'value'       => array(
                            __( 'Active fisrt tab', 'alaska' ) => '0',
                            __( 'No Active', 'alaska' )        => 'false',
                        ),
                        'description' => __( 'Enter section number to be active on load or enter false to collapse all sections.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Extra class name', 'alaska' ),
                        'param_name'  => 'el_class',
                        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'alaska' ),
                    ),
                ),
                'custom_markup'           => '
	<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
	%content%
	</div>
	<div class="tab_controls">
	    <a class="add_tab" title="' . __( 'Add section', 'alaska' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . __( 'Add section', 'alaska' ) . '</span></a>
	</div>
	',
                'default_content'         => '
	    [vc_accordion_tab title="' . __( 'Section 1', 'alaska' ) . '"][/vc_accordion_tab]
	    [vc_accordion_tab title="' . __( 'Section 2', 'alaska' ) . '"][/vc_accordion_tab]
	',
                'js_view'                 => 'VcAccordionView',
            )
        );
        vc_map(
            array(
                'name'                      => __( 'Section', 'alaska' ),
                'base'                      => 'vc_accordion_tab',
                'allowed_container_element' => 'vc_row',
                'is_container'              => true,
                'content_element'           => false,
                'params'                    => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Title', 'alaska' ),
                        'param_name'  => 'title',
                        'description' => __( 'Accordion section title.', 'alaska' ),
                    ),
                ),
                'js_view'                   => 'VcAccordionTabView',
            )
        );
//******************************************************************************************************/
// Blockquote
//******************************************************************************************************/
        vc_map(
            array(
                "name"        => __( "Block Quote", 'alaska' ),
                "description" => "Display style blockquote",
                "base"        => "ts_blockquote",
                "class"       => "",
                "category"    => __( "ALASKA Blocks", 'alaska' ),
                "params"      => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style quote', 'alaska' ),
                        'param_name'  => 'choose_style_quote',
                        'value'       => array(
                            __( 'Style 1', 'alaska' ) => 'style1',
                            __( 'Style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose style for Blockquote.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Author name", 'alaska' ),
                        "param_name"  => "name_author",
                        "value"       => "Robert Smith",
                        "description" => __( "Add author name for quote.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => 'Synergistically supply global testing procedures through ethical scenarios develop empowered sticky leadership.',
                        "description" => __( "content", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Style button
//******************************************************************************************************/
        $add_style_border = array(
            'type'        => 'dropdown',
            'heading'     => __( 'Choose style border', 'alaska' ),
            'param_name'  => 'style_border_button',
            'value'       => array(
                __( 'solid', 'alaska' )   => 'solid',
                __( 'dotted', 'alaska' )  => 'dotted',
                __( 'dashed', 'alaska' )  => 'dashed',
                __( 'none', 'alaska' )    => 'none',
                __( 'hidden', 'alaska' )  => 'hidden',
                __( 'double', 'alaska' )  => 'double',
                __( 'groove', 'alaska' )  => 'groove',
                __( 'ridge', 'alaska' )   => 'ridge',
                __( 'inset', 'alaska' )   => 'inset',
                __( 'outset', 'alaska' )  => 'outset',
                __( 'initial', 'alaska' ) => 'initial',
                __( 'inherit', 'alaska' ) => 'inherit',
            ),
            'dependency'  => array(
                'element' => 'border_button',
                'value'   => array( 'yes' ),
            ),
            'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'alaska' ),
        );
        vc_map(
            array(
                "name"     => __( "Button Shortcode", 'alaska' ),
                "base"     => "ts_style_button",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'size_button',
                        'value'       => array(
                            __( 'Large', 'alaska' )  => 'large',
                            __( 'Normal', 'alaska' ) => 'normal',
                            __( 'Small', 'alaska' )  => 'small',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "text_button",
                        "value"       => __( "Button", 'alaska' ),
                        "description" => __( "Add button name for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link button", 'alaska' ),
                        "param_name"  => "link_button",
                        "value"       => "#",
                        "description" => __( "Add button link for element", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Postion button', 'alaska' ),
                        'param_name'  => 'postion_button',
                        'value'       => array(
                            __( 'Left', 'alaska' )  => 'pull-left',
                            __( 'Right', 'alaska' ) => 'pull-right',
                        ),
                        'description' => __( 'Choose Postion display for button.', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color text", 'alaska' ),
                        "param_name"  => "color_text_button",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Choose color for text ", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color text hover", 'alaska' ),
                        "param_name"  => "color_text_hover_button",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for text button when hover", 'alaska' ),
                    ),

                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "background button", 'alaska' ),
                        "param_name"  => "color_button",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for button", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "background button hover", 'alaska' ),
                        "param_name"  => "color_hover_button",
                        "value"       => '#252525', //Default color
                        "description" => __( "Choose color when hover button.", 'alaska' ),
                    ),

                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose border', 'alaska' ),
                        'param_name'  => 'border_button',
                        'value'       => array(
                            __( 'No border', 'alaska' ) => 'no',
                            __( 'Border', 'alaska' )    => 'yes',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Width border button", 'alaska' ),
                        "param_name"  => "width_border_button",
                        "value"       => "1",
                        'dependency'  => array(
                            'element' => 'border_button',
                            'value'   => array( 'yes' ),
                        ),
                        "description" => __( "Add border width for button", 'alaska' ),
                    ),
                    $add_style_border,
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( " Choose color border", 'alaska' ),
                        "param_name"  => "color_border_button",
                        "value"       => '#42454a', //Default color
                        'dependency'  => array(
                            'element' => 'border_button',
                            'value'   => array( 'yes' ),
                        ),
                        "description" => __( "Choose color for border button", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Width radius", 'alaska' ),
                        "param_name"  => "border_radius_width",
                        "value"       => "0",
                        "description" => __( "Enter number radius width for button", 'alaska' ),
                    ),
                ),
            )
        );

//******************************************************************************************************/
// Call To Action
//******************************************************************************************************/

        vc_map(
            array(
                "name"     => __( "Call To action", 'alaska' ),
                "base"     => "ts_call_to_action",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title", 'alaska' ),
                        "param_name"  => "ts_cta_title",
                        "value"       => "Managed Dedicated Servers",
                        "description" => __( "Enter Call to action title ", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color title", 'alaska' ),
                        "param_name"  => "color_title",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Choose color for Title", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text Action", 'alaska' ),
                        "param_name"  => "ts_cta_text_link",
                        "value"       => "Get started",
                        "description" => __( "Enter Call to action text ", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button color", 'alaska' ),
                        "param_name"  => "color_text_button",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Choose color for Text button", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button color hover", 'alaska' ),
                        "param_name"  => "color_text_button_hover",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Choose color for Text button when hover", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Background button", 'alaska' ),
                        "param_name"  => "color_button",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for background button", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Background button hover", 'alaska' ),
                        "param_name"  => "color_hover_button",
                        "value"       => '#2a2a2a', //Default color
                        "description" => __( "Choose color for background button when hover.", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style border', 'alaska' ),
                        'param_name'  => 'style_border_button',
                        'value'       => array(
                            __( 'solid', 'alaska' )   => 'solid',
                            __( 'dotted', 'alaska' )  => 'dotted',
                            __( 'dashed', 'alaska' )  => 'dashed',
                            __( 'none', 'alaska' )    => 'none',
                            __( 'hidden', 'alaska' )  => 'hidden',
                            __( 'double', 'alaska' )  => 'double',
                            __( 'groove', 'alaska' )  => 'groove',
                            __( 'ridge', 'alaska' )   => 'ridge',
                            __( 'inset', 'alaska' )   => 'inset',
                            __( 'outset', 'alaska' )  => 'outset',
                            __( 'initial', 'alaska' ) => 'initial',
                            __( 'inherit', 'alaska' ) => 'inherit',
                        ),
                        'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Border button color", 'alaska' ),
                        "param_name"  => "color_border_button",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for border button", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Width border button", 'alaska' ),
                        "param_name"  => "width_border_button",
                        "value"       => "1",
                        "description" => __( "Enter width border button. default :1 ", 'alaska' ),
                    ),

                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link Action", 'alaska' ),
                        "param_name"  => "ts_cta_url",
                        "value"       => "#",
                        "description" => __( "Enter Call to action link ", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color Text call to action", 'alaska' ),
                        "param_name"  => "color_text_description",
                        "value"       => '#2a2a2a', //Default color
                        "description" => __( "Choose color for text call to action ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Blazing performance, supreme flexibility & superior UK based support.", 'alaska' ),
                        "description" => __( "Call to action  content", 'alaska' ),
                    ),


                ),
            )
        );
//******************************************************************************************************/
// Client List
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Client List', 'alaska' ),
                'base'     => 'ts_client_work',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'attach_images',
                        'heading'     => __( 'Images', 'alaska' ),
                        'param_name'  => 'images',
                        'value'       => '',
                        'description' => __( 'Select images from media library.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Image size', 'alaska' ),
                        'param_name'  => 'img_size',
                        'value'       => 'client-work',
                        'description' => __( 'Enter image size. Example: thumbnail, medium, large, full ,client-work . Leave empty to use "thumbnail" size.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'On click', 'alaska' ),
                        'param_name'  => 'onclick',
                        'value'       => array(
                            __( 'Open prettyPhoto', 'alaska' ) => 'link_image',
                            __( 'Do nothing', 'alaska' )       => 'link_no',
                            __( 'Open custom link', 'alaska' ) => 'custom_link',
                        ),
                        'description' => __( 'What to do when slide is clicked?', 'alaska' ),
                    ),
                    array(
                        'type'        => 'exploded_textarea',
                        'heading'     => __( 'Custom links', 'alaska' ),
                        'param_name'  => 'custom_links',
                        'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'alaska' ),
                        'dependency'  => array(
                            'element' => 'onclick',
                            'value'   => array( 'custom_link' ),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Extra class name', 'alaska' ),
                        'param_name'  => 'el_class',
                        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Compare Table
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Compare Table', 'alaska' ),
                'base'     => 'ts_pricing_hosting',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Heading Pricing", 'alaska' ),
                        "param_name"  => "heading_hosting",
                        "value"       => 'Single CPU, Multiple Cores (Intel Xeon E3)',
                        "description" => __( "Add Heading Pricing for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title Pricing", 'alaska' ),
                        "param_name"  => "content_title",
                        "value"       => 'CPU|RAM|HARD DRIVER|BANDWIDTH|PRICE',
                        "description" => __( "Add Heading Pricing for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Xeon E3-1240 v34|Cores x 3.4 GHz|8GBDDR3|1TB|100TB|$99|mo|GET STARTED|#", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// Contact hotline
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Contact Hotline', 'alaska' ),
                'base'     => 'ts_contact_hotline',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    $add_css_awesome,
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color icon", 'alaska' ),
                        "param_name"  => "color_icon",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for icon.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title Contact", 'alaska' ),
                        "param_name"  => "title_contact",
                        "value"       => 'Support',
                        "description" => __( "Add Title for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number phone", 'alaska' ),
                        "param_name"  => "phone_contact",
                        "value"       => '',
                        "description" => __( "Add Number phone  for element.eg :(888) 755-7585.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Email", 'alaska' ),
                        "param_name"  => "text_email_contact",
                        "value"       => '',
                        "description" => __( "Add Email for element,eg : support@alaska.com.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text link support", 'alaska' ),
                        "param_name"  => "text_contact",
                        "value"       => '',
                        "description" => __( "Add text link for element. eg:Click to chat", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Url support", 'alaska' ),
                        "param_name"  => "url_contact",
                        "value"       => '#',
                        "description" => __( "Add  url for element", 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// Contact Information
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Contact Information', 'alaska' ),
                'base'     => 'ts_contact_infomation',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title Contact", 'alaska' ),
                        "param_name"  => "title_contact",
                        "value"       => 'Head Office',
                        "description" => __( "Add Title for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Address info", 'alaska' ),
                        "param_name"  => "address_contact",
                        "value"       => '30 South Park Avenue, CA 94108 San Francisco USA',
                        "description" => __( "Add text link for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Email", 'alaska' ),
                        "param_name"  => "text_email_contact",
                        "value"       => 'support@alaska.com',
                        "description" => __( "Add Email for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number phone", 'alaska' ),
                        "param_name"  => "phone_contact",
                        "value"       => '(888) 755-7585',
                        "description" => __( "Add Number phone  for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number fax", 'alaska' ),
                        "param_name"  => "fax_contact",
                        "value"       => '(888) 755-7585',
                        "description" => __( "Add  Number fax url for element", 'alaska' ),
                    ),
                    $add_css_style,

                ),
            )
        );
//******************************************************************************************************/
// Content Box
//******************************************************************************************************/

        vc_map(
            array(
                "name"     => __( "Content Box", 'alaska' ),
                "base"     => "ts_box_border",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title ", 'alaska' ),
                        "param_name"  => "title_box",
                        "value"       => "",
                        "description" => __( "Add title for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => 'Compellingly transform plug-and-play expertise whereas efficient platforms. Authoritatively communicate quality sources vis-a-vis standards compliant partnerships.',
                        "description" => __( "content", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => "",
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );
//******************************************************************************************************/
// Countdown Shortcode
//******************************************************************************************************/

        vc_map(
            array(
                "name"     => __( "Countdown Shortcode", 'alaska' ),
                "base"     => "ts_countdown",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(

                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'countdown_style',
                        'value'       => array(
                            __( 'Countdown style 1', 'alaska' ) => 'countdownstyle1',
                            __( 'Countdown style 2', 'alaska' ) => 'countdownstyle2',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Datetime", 'alaska' ),
                        "param_name"  => "date_countdown",
                        "value"       => "2016/01/01|00/00/00",
                        "description" => __( "Add date for element.Eg:YYYY/MM/DD|h/i/s", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => "",
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                    $add_css_style,

                ),
            )
        );
//******************************************************************************************************/
// Data Table
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Data Table', 'alaska' ),
                'base'     => 'ts_table_data',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title box", 'alaska' ),
                        "param_name"  => "title_box",
                        "value"       => 'Table data',
                        "description" => __( "Add Title box for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Column table", 'alaska' ),
                        "param_name"  => "number_column",
                        "value"       => '4',
                        "description" => __( "Enter column table.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title table", 'alaska' ),
                        "param_name"  => "content_title",
                        "value"       => 'Invoice #|Invoice Date|Due Date|Total',
                        "description" => __( "Add Heading Pricing for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "8|11/08/2014|11/08/2014|$10.99 USD", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// Themestudio Domain box price
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Domain Price Box', 'alaska' ),
                'base'     => 'ts_domain_box_price',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'choose_style_display',
                        'value'       => array(
                            __( 'Display Text', 'alaska' )  => 'text',
                            __( 'Display Image', 'alaska' ) => 'image',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Name Domain", 'alaska' ),
                        "param_name"  => "name_domain",
                        "value"       => __( ".net", 'alaska' ),
                        'dependency'  => array(
                            'element' => 'choose_style_display',
                            'value'   => array( 'text' ),
                        ),
                        "description" => __( "Add domain name for element. eg : .net,.org,.co,.com....", 'alaska' ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image domain", 'alaska' ),
                        "param_name"  => "domain_img",
                        "value"       => '',
                        'dependency'  => array(
                            'element' => 'choose_style_display',
                            'value'   => array( 'image' ),
                        ),
                        "description" => __( "Upload image domain", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Postion text or image', 'alaska' ),
                        'param_name'  => 'text_align',
                        'value'       => array(
                            __( 'Right', 'alaska' )  => 'right',
                            __( 'Center', 'alaska' ) => 'center',
                            __( 'Left', 'alaska' )   => 'left',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color price", 'alaska' ),
                        "param_name"  => "price_color",
                        "value"       => '',
                        "description" => __( "Choose color diplay for price.", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color border", 'alaska' ),
                        "param_name"  => "color_border_price",
                        "value"       => '',
                        "description" => __( "Choose color border diplay for price box.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price Domain", 'alaska' ),
                        "param_name"  => "price_domain",
                        "value"       => __( "$3.99", 'alaska' ),
                        "description" => __( "Add price domain for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Expand/Colapse Content
//******************************************************************************************************/

        vc_map(
            array(
                "name"     => __( "Expand/Collapse Content", 'alaska' ),
                "base"     => "ts_readmore",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Show/hide readmore', 'alaska' ),
                        'param_name'  => 'ts_choose_showmore',
                        'value'       => array(
                            __( 'show', 'alaska' ) => 'show',
                            __( 'Hide', 'alaska' ) => 'hide',
                        ),
                        'description' => __( 'Choose show/hide readmore.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text showmore", 'alaska' ),
                        "param_name"  => "ts_showmore",
                        "value"       => "Expand",
                        'dependency'  => array(
                            'element' => 'ts_choose_showmore',
                            'value'   => array( 'show' ),
                        ),
                        "description" => __( "Add text showmore for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text hide", 'alaska' ),
                        "param_name"  => "ts_hiden",
                        "value"       => "Collapse",
                        'dependency'  => array(
                            'element' => 'ts_choose_showmore',
                            'value'   => array( 'show' ),
                        ),
                        "description" => __( "Add text hide for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Height content", 'alaska' ),
                        "param_name"  => "ts_maxheight",
                        "value"       => "80",
                        'dependency'  => array(
                            'element' => 'ts_choose_showmore',
                            'value'   => array( 'show' ),
                        ),
                        "description" => __( "Add Height for content.Eg:80,100,120...", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => 'Compellingly transform plug-and-play expertise whereas efficient platforms. Authoritatively communicate quality sources vis-a-vis standards compliant partnerships.',
                        "description" => __( "content", 'alaska' ),
                    ),
                    $add_css_style,

                ),
            )
        );
//******************************************************************************************************/
// Social Full icon
//******************************************************************************************************/
        vc_map(
            array(
                "name"        => __( "Expand/Collapse Button", 'alaska' ),
                "description" => "Display button view full icon",
                "base"        => "ts_social_full",
                "class"       => "",
                "category"    => __( "ALASKA Blocks", 'alaska' ),
                "params"      => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "text_button_view",
                        "value"       => "View Full Icon",
                        "description" => __( "Add text for button view full icon", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Feature
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Feature Content", 'alaska' ),
                "base"     => "ts_feature",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout Feature', 'alaska' ),
                        'param_name'  => 'feature_tyle',
                        'value'       => array(
                            __( 'Layout style 1', 'alaska' ) => 'style1',
                            __( 'Layout style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose Layout Feature item', 'alaska' ),
                    ),
                    $add_css_awesome,
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color icon", 'alaska' ),
                        "param_name"  => "color_icon",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for icon", 'alaska' ),

                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color border icon", 'alaska' ),
                        "param_name"  => "color_border_icon",
                        "value"       => '#fd4326',
                        'dependency'  => array(
                            'element' => 'feature_tyle',
                            'value'   => array( 'style2' ),
                        ),
                        "description" => __( "Choose color border icon", 'alaska' ),

                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Postion Feature item', 'alaska' ),
                        'param_name'  => 'position_feature',
                        'value'       => array(
                            __( 'Left', 'alaska' )  => 'left',
                            __( 'Right', 'alaska' ) => 'right',
                        ),
                        'dependency'  => array(
                            'element' => 'feature_tyle',
                            'value'   => array( 'style1', 'style2' ),
                        ),
                        'description' => __( 'Choose Postion Feature item', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title Feature item", 'alaska' ),
                        "param_name"  => "title_feature",
                        "value"       => '',
                        "description" => __( "Add Feature item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Url for title", 'alaska' ),
                        "param_name"  => "link_title",
                        "value"       => '#',
                        "description" => __( "Add link feature box for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color title", 'alaska' ),
                        "param_name"  => "color_title",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for title", 'alaska' ),

                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "<p>Globally evolve e-business niches with best-of-breed technology. Monotonectally iterate backend infomediaries for excellent manufactured products. Dramatically disseminate</p>", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// FunFact
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Funfact Shortcode", 'alaska' ),
                "base"     => "ts_funfact",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    $add_css_awesome,
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color icon", 'alaska' ),
                        "param_name"  => "color_icon",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for icon", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color border", 'alaska' ),
                        "param_name"  => "color_border",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for border", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color Text", 'alaska' ),
                        "param_name"  => "color_text",
                        "value"       => '$fd4326',
                        "description" => __( "Choose color for Text", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number Funfact", 'alaska' ),
                        "param_name"  => "number_funfact",
                        "value"       => __( "7854", 'alaska' ),
                        "description" => __( "Add number funfact on for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit funfact", 'alaska' ),
                        "param_name"  => "unit_funfact",
                        "value"       => '',
                        "description" => __( "Add Unit funfact for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Name Funfact", 'alaska' ),
                        "param_name"  => "name_funfact",
                        "value"       => __( "Data Transferred", 'alaska' ),
                        "description" => __( "Add Name Funfacr for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// FunFact 2
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "ALASKA Funfact style 2", 'alaska' ),
                "base"     => "ts_funfact_style2",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number Funfact", 'alaska' ),
                        "param_name"  => "number_funfact",
                        "value"       => __( "7854", 'alaska' ),
                        "description" => __( "Add number funfact on for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit funfact", 'alaska' ),
                        "param_name"  => "unit_funfact",
                        "value"       => '',
                        "description" => __( "Add Unit funfact for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color Number", 'alaska' ),
                        "param_name"  => "color_number",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for number", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Name Funfact", 'alaska' ),
                        "param_name"  => "name_funfact",
                        "value"       => __( "Data Transferred", 'alaska' ),
                        "description" => __( "Add Name Funfacr for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color title", 'alaska' ),
                        "param_name"  => "color_title",
                        "value"       => '#252525',
                        "description" => __( "Choose color for title", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color Text", 'alaska' ),
                        "param_name"  => "color_text",
                        "value"       => '#737373',
                        "description" => __( "Choose color for Text", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Compellingly transform plug-and-play expertise whereas.Authoritatively communicate quality sources vis-a-vis standards compliant.", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Google MAP
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Google MAP', 'alaska' ),
                'base'     => 'themestudio_map_shortcode',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Title map', 'alaska' ),
                        'param_name'  => 'title_map_title',
                        'value'       => 'Themestudio',
                        'description' => __( 'Title for map info', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color map", 'alaska' ),
                        "param_name"  => "colormap",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for map", 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Address', 'alaska' ),
                        'param_name'  => 'address',
                        'value'       => 'Ngõ 176 Z115, Tân Thịnh, tp. Thái Nguyên, Thái Nguyên, Việt Nam',
                        'description' => __( 'Address for map info', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Latitude', 'alaska' ),
                        'param_name'  => 'lat',
                        'value'       => '21.582668',
                        'description' => __( 'get lat long coordinates from an address <a href="http://www.latlong.net/convert-address-to-lat-long.html">click here</a>', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Longitude', 'alaska' ),
                        'param_name'  => 'long',
                        'value'       => '105.807298',
                        'description' => __( 'get lat long coordinates from an address <a href="http://www.latlong.net/convert-address-to-lat-long.html">click here</a>', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Phone', 'alaska' ),
                        'param_name'  => 'title_map_phone',
                        'value'       => '+84 (0) 1753 456789',
                        'description' => __( 'Phone for map info', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Email', 'alaska' ),
                        'param_name'  => 'title_map_email',
                        'value'       => 'themestudio@gmail.com',
                        'description' => __( 'Phone for map info', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Website', 'alaska' ),
                        'param_name'  => 'title_map_website',
                        'value'       => 'themestudio.net',
                        'description' => __( 'Website for map info', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Add class', 'alaska' ),
                        'param_name'  => 'css_class',
                        'value'       => '',
                        'description' => __( 'Add class for Block element', 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// lasted blog
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Latest Posts', 'alaska' ),
                'base'     => 'ts_lasted_blog',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Number post display', 'alaska' ),
                        'param_name'  => 'number_post',
                        'value'       => '',
                        'description' => __( 'Choose number posts display.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Class min-height', 'alaska' ),
                        'param_name'  => 'minheight_blog_item',
                        'value'       => '495px',
                        'description' => __( 'Class min-height for box', 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// List Icons			ts_size_awesome
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "List Icons", 'alaska' ),
                "base"     => "ts_social_include",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style social', 'alaska' ),
                        'param_name'  => 'ts_choose_style_social',
                        'value'       => array(
                            __( 'Style 1', 'alaska' ) => 'style1',
                            __( 'Style 2', 'alaska' ) => 'style2',
                            __( 'Style 3', 'alaska' ) => 'style3',
                        ),
                        'description' => __( 'Choose style for social.', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color awesome", 'alaska' ),
                        "param_name"  => "ts_color_awesome",
                        "value"       => '#333333',
                        'dependency'  => array(
                            'element' => 'ts_choose_style_social',
                            'value'   => array( 'style1' ),
                        ),
                        "description" => __( "Choose color for Awesome", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose size social', 'alaska' ),
                        'param_name'  => 'ts_size_awesome',
                        'value'       => array(
                            __( 'fa-1x', 'alaska' ) => 'fa-1x',
                            __( 'fa-2x', 'alaska' ) => 'fa-2x',
                            __( 'fa-3x', 'alaska' ) => 'fa-3x',
                            __( 'fa-4x', 'alaska' ) => 'fa-4x',
                            __( 'fa-5x', 'alaska' ) => 'fa-5x',
                        ),
                        'dependency'  => array(
                            'element' => 'ts_choose_style_social',
                            'value'   => array( 'style1' ),
                        ),
                        'description' => __( 'Choose style for social.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Font icon", 'alaska' ),
                        "param_name"  => "ts_font_awesome",
                        "value"       => "fa-facebook|fa_vine",
                        'dependency'  => array(
                            'element' => 'ts_choose_style_social',
                            'value'   => array( 'style1' ),
                        ),
                        "description" => __( "Input graph values here. Divide values with linebreaks (Enter). Example: fa-facebook|fa_vine.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Icon and Tooltip", 'alaska' ),
                        "param_name"  => "ts_tooltip_awesome",
                        "value"       => "",
                        'dependency'  => array(
                            'element' => 'ts_choose_style_social',
                            'value'   => array( 'style2', 'style3' ),
                        ),
                        "description" => __( "Input graph values here. Divide values with linebreaks (Enter). Example: Style 2: fa-facebook|Facebook. Style 3: fa-facebook|Facebook|#242424.", 'alaska' ),
                    ),


                ),
            )
        );
//******************************************************************************************************/
// List images
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'List Images', 'alaska' ),
                'base'     => 'ts_list_images',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'attach_images',
                        'heading'     => __( 'Images', 'alaska' ),
                        'param_name'  => 'images',
                        'value'       => '',
                        'description' => __( 'Select images from media library.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'On click', 'alaska' ),
                        'param_name'  => 'onclick',
                        'value'       => array(
                            __( 'Open prettyPhoto', 'alaska' ) => 'link_image',
                            __( 'Do nothing', 'alaska' )       => 'link_no',
                            __( 'Open custom link', 'alaska' ) => 'custom_link',
                        ),
                        'description' => __( 'What to do when slide is clicked?', 'alaska' ),
                    ),
                    array(
                        'type'        => 'exploded_textarea',
                        'heading'     => __( 'Custom links', 'alaska' ),
                        'param_name'  => 'custom_links',
                        'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'alaska' ),
                        'dependency'  => array(
                            'element' => 'onclick',
                            'value'   => array( 'custom_link' ),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Extra class name', 'alaska' ),
                        'param_name'  => 'el_class',
                        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// List style
//******************************************************************************************************/
        vc_map(
            array(
                "name"        => __( "List Style", 'alaska' ),
                "description" => "Display style list",
                "base"        => "ts_list_style",
                "class"       => "",
                "category"    => __( "ALASKA Blocks", 'alaska' ),
                "params"      => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style list', 'alaska' ),
                        'param_name'  => 'choose_list_style',
                        'value'       => array(
                            __( 'Default', 'alaska' )       => 'default',
                            __( 'Orderlist', 'alaska' )     => 'orderlist',
                            __( 'Style icon', 'alaska' )    => 'icon',
                            __( 'Inline list', 'alaska' )   => 'inline-style',
                            __( 'Unstyled list', 'alaska' ) => 'unstyle',
                        ),
                        'description' => __( 'Choose style for social.', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color icon", 'alaska' ),
                        "param_name"  => "color_icon",
                        "value"       => '#737373', //Default color
                        'dependency'  => array(
                            'element' => 'choose_list_style',
                            'value'   => array( 'default', 'icon' ),
                        ),
                        "description" => __( "Choose color for icon.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title list", 'alaska' ),
                        "param_name"  => "list_title",
                        "value"       => "Custom list with icons",
                        'dependency'  => array(
                            'element' => 'choose_list_style',
                            'value'   => array( 'default', 'icon' ),
                        ),
                        "description" => __( "Add title for list style", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => '',
                        "description" => __(
                            "Add content for list style.<br /> Default:1|Nam aliquet massa id gravida venenatis.|(url).<br /> Style icon:fa-facebook|Nam aliquet massa id gravida venenatis.|(url).<br />Unstyled:Nam aliquet massa id gravida venenatis.|(url).<br />
              						Inline list: add content <ul> <li> of editor.", 'alaska'
                        ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Messega box
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Notification Box', 'alaska' ),
                'base'     => 'ts_notifications',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        "type"        => "dropdown",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose style Notification boxes or no boxes", 'alaska' ),
                        "param_name"  => "choose_style_message_box",
                        'value'       => array(
                            __( 'No boxes', 'alaska' ) => 'no_boxed',
                            __( 'Boxed', 'alaska' )    => 'boxed',
                        ),
                        'description' => "Choose style Notification boxes or no boxes",
                    ),
                    array(
                        "type"        => "dropdown",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color", 'alaska' ),
                        "param_name"  => "ts_color_title_message",
                        'value'       => array(
                            __( 'No Color', 'alaska' )  => 'no',
                            __( 'Yes color', 'alaska' ) => 'yes',
                        ),
                        'dependency'  => array(
                            'element' => 'choose_style_message_box',
                            'value'   => array( 'boxed' ),
                        ),
                        'description' => "Choose color for title Notification boxes.",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title box", 'alaska' ),
                        "param_name"  => "ts_title_message",
                        "value"       => "Success..   Everything is good!",
                        "description" => __( "Add title for box.", 'alaska' ),
                    ),
                    array(
                        "type"        => "dropdown",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose styles message box", 'alaska' ),
                        "param_name"  => "choose_style_message",
                        'value'       => array(
                            __( 'Info', 'alaska' )    => 'info',
                            __( 'Warning', 'alaska' ) => 'warning',
                            __( 'Success', 'alaska' ) => 'success',
                            __( 'Error', 'alaska' )   => 'error',
                        ),
                        'description' => "",
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Message content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => 'Credibly promote cross-platform internal or "organic" sources whereas real-time functionalities. Appropriately communicate leading-edge e-commerce and standardized best practices. Phosfluorescently empower error-free web services for fully researched internal or "organic" sources. ',
                        'dependency'  => array(
                            'element' => 'choose_style_message_box',
                            'value'   => array( 'boxed' ),
                        ),
                        "description" => __( "Add text message for Block element", 'alaska' ),
                    ),
                ),
            )
        );

//******************************************************************************************************/
// Portfolio Shortcode
//******************************************************************************************************/
        $portfolio_term = array();
        $id_portfolio = '';
        $portfolio_terms = get_terms( "portfolio_cats" );
        if (!empty($portfolio_terms) && !is_wp_error($portfolio_terms)) {
            foreach ( $portfolio_terms as $portfolio_cat ) {
                $portfolio_term[ $portfolio_cat->name ] = $portfolio_cat->slug;
                $id_portfolio = $portfolio_cat->slug;
            }
        }
       

        vc_map(
            array(
                "name"     => __( "Portfolio Shortcode", 'alaska' ),
                "base"     => "ts_portfolio",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(

                    array(
                        "type"       => "dropdown",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Show/hide portfolio filter", 'alaska' ),
                        "param_name" => "portfolio_filter_switch",
                        'value'      => array(
                            __( 'Show filter', 'alaska' ) => 'show-filter',
                            __( 'Hide filter', 'alaska' ) => 'hide-filter',
                        ),
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => __( 'Categories display', 'alaska' ),
                        'param_name'  => 'portfolio_show_categories',
                        'value'       => $portfolio_term,
                        "description" => __( "Add categories portfolio display on page.", 'alaska' ),
                        'std'         => $id_portfolio,
                    ),

                    array(
                        "type"       => "dropdown",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Choose portfolio container", 'alaska' ),
                        "param_name" => "portfolio_container",
                        'value'      => array(
                            __( 'Yes', 'alaska' ) => 'yes',
                            __( 'No', 'alaska' )  => 'no',
                        ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number portfolio per page ", 'alaska' ),
                        "param_name"  => "posts_per_page",
                        "value"       => "12",
                        "description" => __( "Number portfolio per page ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Portfolio item width", 'alaska' ),
                        "param_name"  => "portfolio_item_width",
                        "value"       => "275",
                        "description" => __( "This option set width for portfolio item.Enter value width.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Portfolio item height", 'alaska' ),
                        "param_name"  => "portfolio_item_height",
                        "value"       => "245",
                        "description" => __( "This option set height for portfolio item.Enter value height.", 'alaska' ),
                    ),
                    array(
                        "type"       => "dropdown",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Select show/hide pagination", 'alaska' ),
                        "param_name" => "show_pagination",
                        'value'      => array(
                            __( 'Show', 'alaska' ) => 'show',
                            __( 'Hide', 'alaska' ) => 'hide',
                        ),
                    ),
                    $add_css_style,

                ),
            )
        );
//******************************************************************************************************/
// Pricing Table
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Pricing Table", 'alaska' ),
                "base"     => "ts_pricing_table",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Pricing table style ', 'alaska' ),
                        'param_name'  => 'pricing_table_style',
                        'value'       => array(
                            __( 'Layout style 1', 'alaska' ) => 'style1',
                            __( 'Layout style 2', 'alaska' ) => 'style2',
                            __( 'Layout style 3', 'alaska' ) => 'style3',
                            __( 'Layout style 4', 'alaska' ) => 'style4',
                        ),
                        'description' => __( 'Choose Pricing table layout needed.', 'alaska' ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image service", 'alaska' ),
                        "param_name"  => "image_service",
                        "value"       => '',
                        'dependency'  => array(
                            'element' => 'pricing_table_style',
                            'value'   => array( 'style4' ),
                        ),
                        "description" => __( "Upload image service", 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'font awesome icon class', 'alaska' ),
                        'param_name'  => 'css_awesome',
                        'admin_label' => true,
                        'value'       => '',
                        'dependency'  => array(
                            'element' => 'pricing_table_style',
                            'value'   => array( 'style3' ),
                        ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a target="__blank" href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Subtitle", 'alaska' ),
                        "param_name"  => "pricing_subtitle",
                        
                        'dependency'  => array(
                            'element' => 'pricing_table_style',
                            'value'   => array( 'style3' ),
                        ),
                        "description" => __( "Add Pricing Title for element", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose Active', 'alaska' ),
                        'param_name'  => 'class_active',
                        'value'       => array(
                            __( 'No Active', 'alaska' ) => '',
                            __( 'Active', 'alaska' )    => 'active',
                        ),
                        'dependency'  => array(
                            'element' => 'pricing_table_style',
                            'value'   => array( 'style1', 'style2', 'style3' ),
                        ),
                        'description' => __( 'Choose active pricing needed.', 'alaska' ),
                    ),

                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Title", 'alaska' ),
                        "param_name"  => "pricing_title",
                        "value"       => __( "Economy", 'alaska' ),
                        "description" => __( "Add Pricing Title for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Price", 'alaska' ),
                        "param_name"  => "pricing_price",
                        "value"       => __( "$3.99", 'alaska' ),
                        "description" => __( "Add Pricing Price for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Price unit", 'alaska' ),
                        "param_name"  => "pricing_unit",
                        "value"       => __( "pm", 'alaska' ),
                        "description" => __( "Add Pricing Price unit for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price description", 'alaska' ),
                        "param_name"  => "price_description",
                        
                        'dependency'  => array(
                            'element' => 'pricing_table_style',
                            'value'   => array( 'style3' ),
                        ),
                        "description" => __( "Add Price description for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __(
                            "<ul>
								<li>500 GB Disk Space</li>
								<li>100 Databases List</li>
								<li>Free Domain Registration</li>
								<li>1 Hosting Space</li>
								<li>FREE Ad Coupons</li>
							</ul>", 'alaska'
                        ),
                        "description" => __( "Add content", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Link Button", 'alaska' ),
                        "param_name"  => "pricing_link_button",
                        "value"       => __( "#", 'alaska' ),
                        "description" => __( "Add Pricing Link Button for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Pricing Text Button", 'alaska' ),
                        "param_name"  => "pricing_text_button",
                        "value"       => __( "GET STARTED", 'alaska' ),
                        "description" => __( "Add Pricing Text Button for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Process bar
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Process Bar", 'alaska' ),
                "base"     => "ts_process_bar",
                "class"    => "",
                "category" => __( "ALASKA Blocks", 'alaska' ),
                "params"   => array(

                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title skill ", 'alaska' ),
                        "param_name"  => "title_skill",
                        "value"       => __( "Energistically evolve", 'alaska' ),
                        "description" => __( "Add title for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number skill ", 'alaska' ),
                        "param_name"  => "number_skill",
                        "value"       => "75",
                        "description" => __( "Add number for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit skill ", 'alaska' ),
                        "param_name"  => "unit_skill",
                        "value"       => "%",
                        "description" => __( "Add unit for element. Eg:%", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Fontsize skill ", 'alaska' ),
                        "param_name"  => "fontsize_skill",
                        "value"       => "30",
                        "description" => __( "Add fontsize for element. Eg:%", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Dimension skill ", 'alaska' ),
                        "param_name"  => "dimension_skill",
                        "value"       => "127",
                        "description" => __( "Add Dimension for element. Eg:255", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Width skill ", 'alaska' ),
                        "param_name"  => "width_skill",
                        "value"       => "5",
                        "description" => __( "Add Dimension for element. Eg:255", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Skill bar background color", 'alaska' ),
                        "param_name"  => "bgcolor_skill",
                        "value"       => '#f3f3f3', //Default color
                        "description" => __( "Choose color for skill bar background", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Percent bar background color", 'alaska' ),
                        "param_name"  => "color_skill",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for percent bar", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Skill title color", 'alaska' ),
                        "param_name"  => "color_title_skill",
                        "value"       => '#252525', //Default color
                        "description" => __( "Choose color for Title bar ", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Skill text color", 'alaska' ),
                        "param_name"  => "color_text_skill",
                        "value"       => '#737373', //Default color
                        "description" => __( "Choose color for percent text", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => 'Compellingly transform plug-and-play expertise whereas efficient platforms. Authoritatively communicate quality sources vis-a-vis standards compliant partnerships.',
                        "description" => __( "content", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => "",
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );
//******************************************************************************************************/
// Search Domain
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Search Domain Box", 'alaska' ),
                "base"     => "ts_search_domain",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color text", 'alaska' ),
                        "param_name"  => "color_domain_search",
                        "value"       => '', //Default color
                        "description" => __( "Choose color for text in box search domain", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color border", 'alaska' ),
                        "param_name"  => "color_box_search",
                        "value"       => '', //Default color
                        "description" => __( "Choose color for border box search domain", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color background input", 'alaska' ),
                        "param_name"  => "color_domain_input",
                        "value"       => '', //Default color
                        "description" => __( "Choose color background for  box search domain", 'alaska' ),
                    ),

                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Search Domain - Text Placehoder ", 'alaska' ),
                        "param_name"  => "text_placeholder",
                        "value"       => __( "Enter your Domain Name here...", 'alaska' ),
                        "description" => __( "Search Domain - Text Placehoder ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Value Search ", 'alaska' ),
                        "param_name"  => "select_option_search",
                        "value"       => "",
                        "description" => __(
                            "Enter value Search <br/>
	          						     eg:com|whois.verisign-grs.com,org|whois.pir.org,co|whois.nic.co", 'alaska'
                        ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button Search", 'alaska' ),
                        "param_name"  => "search_text_button",
                        "value"       => __( "Search", 'alaska' ),
                        "description" => __( " Text button Search", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose link to whmcs', 'alaska' ),
                        'param_name'  => 'link_to_whmcs',
                        'value'       => array(
                            __( 'WHMCS BRIDGE', 'alaska' ) => '1',
                            __( 'WHMCS', 'alaska' )        => '0',
                        ),
                        'description' => __( 'Link to WHMCS by whmcs-bridge plugin.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link Action Search", 'alaska' ),
                        "param_name"  => "search_link_button",
                        "description" => __( "Link actice button search", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );
//******************************************************************************************************/
// Section/ Block title
//******************************************************************************************************/

        vc_map(
            array(
                "name"     => __( "Section/Block Title", 'alaska' ),
                "base"     => "themestudio_title",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title", 'alaska' ),
                        "param_name"  => "title",
                        "value"       => "",
                        "description" => __( "Enter section title ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "font-size for title", 'alaska' ),
                        "param_name"  => "fontsize_title",
                        "value"       => "30",
                        "description" => __( "Enter value font-size for title.", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Align title', 'alaska' ),
                        'param_name'  => 'align_title',
                        'value'       => array(
                            __( 'Center', 'alaska' ) => 'text-center',
                            __( 'Left', 'alaska' )   => 'text-left',
                            __( 'Right', 'alaska' )  => 'text-right',
                        ),
                        'description' => __( 'Choose Postion Title/Section', 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title color", 'alaska' ),
                        "param_name"  => "title_color",
                        "value"       => '#252525', //Default color
                        "description" => __( "Choose color for title", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Description color", 'alaska' ),
                        "param_name"  => "des_color",
                        "value"       => '#737373', //Default color
                        "description" => __( "Choose color for Description", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => '',
                        "description" => __( "Subtitle content", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );


//******************************************************************************************************/
// Our Service
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Service Icon ", 'alaska' ),
                "base"     => "ts_our_service",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'font awesome icon class', 'alaska' ),
                        'param_name'  => 'css_awesome',
                        'admin_label' => true,
                        'value'       => '',
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a target="__blank" href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title", 'alaska' ),
                        "param_name"  => "ts_service_title",
                        "value"       => "Backups Available",
                        "description" => __( "Enter service title ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Compellingly transform plug-and-play expertise whereas efficient platforms. Authoritatively communicate quality sources vis-a-vis standards compliant partnerships.", 'alaska' ),
                        "description" => __( "Service content", 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Show readmore', 'alaska' ),
                        'param_name'  => 'choose_readmore',
                        'value'       => array(
                            __( 'Show', 'alaska' ) => '1',
                            __( 'Hide', 'alaska' ) => '0',
                        ),
                        'description' => __( 'Choose show/hide readmore.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text service url", 'alaska' ),
                        "param_name"  => "ts_service_text_link",
                        "value"       => "Read more",
                        "description" => __( "Enter Service readmore text ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link service url", 'alaska' ),
                        "param_name"  => "ts_service_url",
                        "value"       => "#",
                        "description" => __( "Enter readmore link ", 'alaska' ),
                    ),


                ),
            )
        );
//******************************************************************************************************/
// Service Image
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Service Image', 'alaska' ),
                'base'     => 'ts_our_service_style3',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(

                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image service", 'alaska' ),
                        "param_name"  => "image_service",
                        "value"       => '',
                        "description" => __( "Upload image service", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Url Service", 'alaska' ),
                        "param_name"  => "url_image_service",
                        "value"       => '#',
                        "description" => __(
                            "Add link to service for element.", 'alaska'
                        ),
                    ), array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title service item", 'alaska' ),
                        "param_name"  => "ts_service_title",
                        "value"       => 'Brand & Indentity',
                        "description" => __( "Add title service item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Rapidiously architect performance based platforms before performance based customer service. Assertively seize ubiquitous functionalities via emerging manufactured products.Rapidiously architect performance based platforms before performance based customer service. Assertively seize ubiquitous functionalities via emerging manufactured products.", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );

//******************************************************************************************************/
// Our Service Style 2
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Service Simple', 'alaska' ),
                'base'     => 'ts_our_service_style2',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'ts_service_style',
                        'value'       => array(
                            __( 'Layout style 1', 'alaska' )   => 'style1',
                            __( 'Layout style tab', 'alaska' ) => 'style2',
                            __( 'Layout style 3', 'alaska' )   => 'style3',
                            __( 'Layout style 4', 'alaska' )   => 'style4',
                            __( 'Layout style 5', 'alaska' )   => 'style5',
                            __( 'Layout style 6', 'alaska' )   => 'style6',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose icon or image', 'alaska' ),
                        'param_name'  => 'ts_choose_image',
                        'value'       => array(
                            __( 'Icon', 'alaska' )  => 'icon',
                            __( 'Image', 'alaska' ) => 'image',
                        ),
                        'dependency'  => array(
                            'element' => 'ts_service_style',
                            'value'   => array( 'style4' ),
                        ),
                        'description' => __( 'Choose style display.Note:You should choose icon or image.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Url Service", 'alaska' ),
                        "param_name"  => "url_image_service",
                        "value"       => '#',
                        "description" => __( "Add link to service for element.", 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'font awesome icon class', 'alaska' ),
                        'param_name'  => 'css_awesome',
                        'admin_label' => true,
                        'value'       => '',
                        'dependency'  => array(
                            'element' => 'ts_service_style',
                            'value'   => array( 'style1', 'style2', 'style3', 'style4', 'style5', 'style6' ),
                        ),
                        'description' => __( 'Note:You should choose icon or image.Enter font icon awesome .eg: fa-facebook... . <a target="__blank" href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image service", 'alaska' ),
                        "param_name"  => "image_service",
                        "value"       => '',
                        'dependency'  => array(
                            'element' => 'ts_service_style',
                            'value'   => array( 'style4' ),
                        ),
                        'dependency'  => array(
                            'element' => 'ts_choose_image',
                            'value'   => 'image',
                        ),
                        "description" => __( "Upload image service.Note:You should choose icon or image.", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose color icon", 'alaska' ),
                        "param_name"  => "ts_color_icon",
                        "value"       => '#fd4326',
                        "description" => __( "Choose color for icon", 'alaska' ),
                        'dependency'  => array(
                            'element' => 'ts_service_style',
                            'value'   => array( 'style3', 'style4', 'style5', 'style6' ),
                        ),

                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Choose border color icon", 'alaska' ),
                        "param_name"  => "ts_border_color_icon",
                        "value"       => '#fd4326',
                        "description" => __( "Choose border color for icon", 'alaska' ),
                        'dependency'  => array(
                            'element' => 'ts_service_style',
                            'value'   => array( 'style4' ),
                        ),

                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title service item", 'alaska' ),
                        "param_name"  => "ts_service_title",
                        "value"       => 'System Admin',
                        "description" => __( "Add title service item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => __( "Compellingly transform plug-and-play expertise whereas efficient platforms. Authoritatively communicate ", 'alaska' ),
                        "description" => __( "Add content", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Skill Bars
//******************************************************************************************************/
        vc_map(
            array(
                "name"        => __( "Skill Bar", 'alaska' ),
                "base"        => "ts_skillbar_shortcode",
                "description" => "Display your skills with style",
                "icon"        => "icon-progress-bar",
                "class"       => "skillbar_extended",
                "category"    => __( "ALASKA Blocks", 'alaska' ),
                "params"      => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'skill_bar_style',
                        'value'       => array(
                            __( 'Skillbar style 1', 'alaska' ) => 'skillbarstyle1',
                            __( 'Skillbar style 2', 'alaska' ) => 'skillbarstyle2',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),

                    array(
                        "type"        => "exploded_textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Graphic values", 'alaska' ),
                        "param_name"  => "values",
                        "value"       => "90|Development",
                        "description" => __( "Input graph values here. Divide values with linebreaks (Enter). Example: 90|Development.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Units", 'alaska' ),
                        "param_name"  => "units",
                        "value"       => "%",
                        "description" => __( "Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Skill bar background color", 'alaska' ),
                        "param_name"  => "skillbar_background_color",
                        "value"       => '#f3f3f3', //Default color
                        "description" => __( "Choose color for skill bar background", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Percent bar background color", 'alaska' ),
                        "param_name"  => "percentbar_background_color",
                        "value"       => '#fd4326', //Default color
                        "description" => __( "Choose color for percent bar", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Skill bar text color", 'alaska' ),
                        "param_name"  => "skill_bar_text_color",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Choose color for percent text", 'alaska' ),
                    ),
                    array(
                        "type"       => "textarea_html",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Skill bar description", 'alaska' ),
                        "param_name" => "content",
                        "value"      => "",
                        'dependency' => array(
                            'element' => 'skill_bar_style',
                            'value'   => array( 'skillbarstyle1' ),
                        ),
                    ),
                    $add_css_style,
                ),
            )
        );
//******************************************************************************************************/
// Themestudio special offer
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Special Offer', 'alaska' ),
                'base'     => 'ts_special_offer',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Layout display', 'alaska' ),
                        'param_name'  => 'choose_style_special',
                        'value'       => array(
                            __( 'Special style 1', 'alaska' ) => 'style1',
                            __( 'Special style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose Layout display.', 'alaska' ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image special", 'alaska' ),
                        "param_name"  => "background_special",
                        "value"       => '',
                        "description" => __( "Upload image special", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title special item", 'alaska' ),
                        "param_name"  => "title_special",
                        "value"       => 'Host for your website',
                        "description" => __( "Add title special item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Description special item", 'alaska' ),
                        "param_name"  => "description_special",
                        "value"       => 'Makings of this first generator on internet',
                        'dependency'  => array(
                            'element' => 'choose_style_special',
                            'value'   => array( 'style1' ),
                        ),
                        "description" => __( "Add title special item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => '',
                        "description" => __( "Add content", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price special item", 'alaska' ),
                        "param_name"  => "price_special",
                        "value"       => '$4.99',
                        "description" => __( "Add price special item for element. $4.99 per month, 30% discount", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit special item", 'alaska' ),
                        "param_name"  => "unit_special",
                        "value"       => 'per month',
                        "description" => __( "Add unit special item for element. Eg : per month, discount", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link special item", 'alaska' ),
                        "param_name"  => "more_special_url",
                        "value"       => '#',
                        "description" => __( "Add url special item for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Description special item", 'alaska' ),
                        "param_name"  => "more_special_text",
                        "value"       => 'Learn more',
                        "description" => __( "Add text for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Team Member
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Team Member", 'alaska' ),
                "base"     => "ts_team_member",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style team', 'alaska' ),
                        'param_name'  => 'choose_style_team',
                        'value'       => array(
                            __( 'Style 1', 'alaska' ) => 'style1',
                            __( 'Style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose style for Team member.', 'alaska' ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's avatar", 'alaska' ),
                        "param_name"  => "bg_member",
                        "value"       => '',
                        "description" => __( "Upload member's avatar", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's name", 'alaska' ),
                        "param_name"  => "name_member",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's postion", 'alaska' ),
                        "param_name"  => "member_postion",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's twitter url", 'alaska' ),
                        "param_name"  => "fa_tiwtter",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's behance url", 'alaska' ),
                        "param_name"  => "fa_behance",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's dribble url", 'alaska' ),
                        "param_name"  => "fa_dribble",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's facebook url", 'alaska' ),
                        "param_name"  => "fa_facebook",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's youtube url", 'alaska' ),
                        "param_name"  => "fa_youtube",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's google url", 'alaska' ),
                        "param_name"  => "fa_google",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's tumblr url", 'alaska' ),
                        "param_name"  => "fa_tumblr",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Member's vine url", 'alaska' ),
                        "param_name"  => "fa_vine",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => '',
                        'dependency'  => array(
                            'element' => 'choose_style_team',
                            'value'   => array( 'style1' ),
                        ),
                        "description" => __( "Story member content", 'alaska' ),
                    ),
                    $add_css_style,
                ),
            )
        );

//******************************************************************************************************/
// Testimonial
//******************************************************************************************************/

        $testimonial_term = array();
        $testimonial_terms = get_terms( "testimonials_cats" );
        if (!empty($testimonial_terms) && !is_wp_error($testimonial_terms)) {
            foreach ( $testimonial_terms as $testimonial_cat ) {
                $testimonial_term[ $testimonial_cat->name ] = $testimonial_cat->slug;

            }
        }        
        wp_reset_postdata();


        vc_map(
            array(
                "name"     => __( "Testimonial Shortcode", 'alaska' ),
                "base"     => "ts_testimonials",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        "holder"      => "div",
                        'heading'     => __( 'Categories display', 'alaska' ),
                        'param_name'  => 'testimonial_show_categories',
                        'value'       => $testimonial_term,
                        "description" => __( "Add categories testimonial display on page.", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Post Number", 'alaska' ),
                        "param_name"  => "number_post_testimonial",
                        "value"       => __( "3", 'alaska' ),
                        "description" => __( "Number post display in testimonial", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Autoplay", 'alaska' ),
                        "param_name"  => "speed_slide",
                        "value"       => __( "4", 'alaska' ),
                        "description" => __( "Enter value autoplay for slide. ", 'alaska' ),
                    ),
                    array(
                        "type"        => "dropdown",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Layout style", 'alaska' ),
                        "param_name"  => "style_testimonial",
                        "value"       => array(
                            'Layout style 1' => "style1",
                            'Layout style 2' => "style2",
                        ),
                        "description" => __( "Layout Display testimonial", 'alaska' ),
                    ),
                    array(
                        "type"        => "dropdown",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Style testimonial", 'alaska' ),
                        "param_name"  => "style_text_testimonial",
                        "value"       => array(
                            'Light' => "light",
                            'Dark'  => "dark",
                        ),
                        'dependency'  => array(
                            'element' => 'style_testimonial',
                            'value'   => array( 'style2' ),
                        ),
                        "description" => __( "Layout Display testimonial", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => '',
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Text Dropcap
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Text Dropcap", 'alaska' ),
                "base"     => "ts_text_dropcap",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style dropcap', 'alaska' ),
                        'param_name'  => 'choose_style_dropcap',
                        'value'       => array(
                            __( 'Style 1', 'alaska' ) => 'style1',
                            __( 'Style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose style for dropcap.', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "First Text", 'alaska' ),
                        "param_name"  => "first_text",
                        "value"       => "",
                        "description" => __( "First text dropcap", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Background color first text dropcap", 'alaska' ),
                        "param_name"  => "background_color_fisttext",
                        "value"       => '#42454a', //Default color
                        'dependency'  => array(
                            'element' => 'choose_style_dropcap',
                            'value'   => array( 'style1' ),
                        ),
                        "description" => __( "Background color first text dropcap", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color first text dropcap", 'alaska' ),
                        "param_name"  => "color_fisttext",
                        "value"       => '#ffffff', //Default color
                        "description" => __( "Color first text dropcap", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea_html",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Content Text", 'alaska' ),
                        "param_name"  => "content",
                        "value"       => "",
                        "description" => __( "Add content text drop cap", 'alaska' ),
                    ),

                ),
            )
        );
//******************************************************************************************************/
// Themestudio Twitter
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Twitter Shortcode', 'alaska' ),
                'base'     => 'ts_twitter',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Number tweets", 'alaska' ),
                        "param_name"  => "number_tweet",
                        "value"       => '4',
                        "description" => __( "Enter number tweets for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => '',
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Divider Shortcode
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Divider Shortcode', 'alaska' ),
                'base'     => 'ts_divider_shortcode',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style divider', 'alaska' ),
                        'param_name'  => 'choose_style_divider',
                        'value'       => array(
                            __( 'Style 1', 'alaska' ) => 'style1',
                            __( 'Style 2', 'alaska' ) => 'style2',
                        ),
                        'description' => __( 'Choose style for divider.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose width divider', 'alaska' ),
                        'param_name'  => 'width_divider',
                        'value'       => array(
                            __( 'Full width', 'alaska' )     => '',
                            __( 'Divider medium', 'alaska' ) => 'divider-md',
                            __( 'Divider small', 'alaska' )  => 'divider-sm',
                        ),
                        'description' => __( 'Choose width for divider.', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose Style Text or Icon', 'alaska' ),
                        'param_name'  => 'choose_icon_text',
                        'value'       => array(
                            __( 'Divider text', 'alaska' ) => 'text',
                            __( 'Divider icon', 'alaska' ) => 'icon',
                        ),
                        'dependency'  => array(
                            'element' => 'choose_style_divider',
                            'value'   => array( 'style2' ),
                        ),
                        'description' => __( 'Choose style for divider display .', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text divider", 'alaska' ),
                        "param_name"  => "title_divider",
                        "value"       => 'Your text',
                        'dependency'  => array(
                            'element' => 'choose_icon_text',
                            'value'   => array( 'text' ),
                        ),
                        "description" => __( "Add text for divider", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color divider", 'alaska' ),
                        "param_name"  => "color_divider",
                        "value"       => '#ccc', //Default color
                        'dependency'  => array(
                            'element' => 'choose_style_divider',
                            'value'   => array( 'style2' ),
                        ),
                        "description" => __( "Select color for divider", 'alaska' ),
                    ),
                    array(
                        'type'        => 'textfield',
                        "heading"     => __( "Icon divider", 'alaska' ),
                        "class"       => "",
                        "param_name"  => "icon_divider",
                        'value'       => '',
                        'dependency'  => array(
                            'element' => 'choose_icon_text',
                            'value'   => array( 'icon' ),
                        ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose divider parallel', 'alaska' ),
                        'param_name'  => 'divider_style',
                        'value'       => array(
                            __( 'One divider', 'alaska' )    => '',
                            __( 'Parallel lines', 'alaska' ) => 'divider-2',
                        ),
                        'dependency'  => array(
                            'element' => 'choose_style_divider',
                            'value'   => array( 'style1' ),
                        ),
                        'description' => __( 'Choose for divider.', 'alaska' ),
                    ),
                ),
            )
        );
//******************************************************************************************************/
// Pricing Table New
//******************************************************************************************************/
        vc_map(
            array(
                'name'     => __( 'Pricing Table(New)', 'alaska' ),
                'base'     => 'ts_pricing_table_new',
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose Number plan display', 'alaska' ),
                        'param_name'  => 'choose_column',
                        'value'       => array(
                            __( 'Two plan', 'alaska' )   => '3',
                            __( 'Three plan', 'alaska' ) => '4',
                            __( 'Four plan', 'alaska' )  => '5',
                        ),
                        'description' => __( 'Choose number plan display .', 'alaska' ),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Choose style plan display', 'alaska' ),
                        'param_name'  => 'choose_border',
                        'value'       => array(
                            __( 'No border', 'alaska' )  => 'no',
                            __( 'Yes border', 'alaska' ) => 'yes',
                        ),
                        'description' => __( 'Choose style plan display .', 'alaska' ),
                    ),

                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Pricing Content", 'alaska' ),
                        "param_name"  => "ts_pricing_content",
                        "value"       => "Linux Web Hosting includes|Number of Websites,1,1,5,10
		         				Cloud hosting platform,Y,Y,N,Y",
                        "description" => __(
                            "Input graph values here. Divide values with linebreaks (Enter). <br />
		         						Example: Linux Web Hosting includes|Number of Websites,1,1,5,9 <br />
		         								 Cloud hosting platform,Y,Y,Y,N", 'alaska'
                        ),
                    ),
                    array(
                        "type"        => "attach_image",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Image pricing", 'alaska' ),
                        "param_name"  => "img_pricing",
                        "value"       => '',
                        "description" => __( "Upload image pricing", 'alaska' ),
                    ),

                    // Plan 1
                    array(
                        'type'        => 'textfield',
                        "heading"     => __( "Icon Pricing", 'alaska' ),
                        "class"       => "",
                        "param_name"  => "icon_prcing_1",
                        'value'       => '',
                        'group'       => __( 'Plan one', 'alaska' ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title pricing plan one", 'alaska' ),
                        "param_name"  => "title_pricing_1",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color border plan 1", 'alaska' ),
                        "param_name"  => "color_border_1",
                        "value"       => '', //Default color
                        'dependency'  => array(
                            'element' => 'choose_border',
                            'value'   => array( 'yes' ),
                        ),
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Select color for plan 1", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price", 'alaska' ),
                        "param_name"  => "price_1",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "pence", 'alaska' ),
                        "param_name"  => "pence_pricing_1",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit", 'alaska' ),
                        "param_name"  => "unit_pricing_1",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "VAT prompt", 'alaska' ),
                        "param_name"  => "vatprompt",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Description plan one", 'alaska' ),
                        "param_name"  => "des_plan_one_1",
                        "value"       => "",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Input description values here", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "button_pricing_1",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Enter text button for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "class"       => "",
                        "heading"     => __( "Link button", 'alaska' ),
                        "param_name"  => "link_pricing_1",
                        "value"       => "",
                        'group'       => __( 'Plan one', 'alaska' ),
                        "description" => __( "Input link pricing one values here", 'alaska' ),
                    ),
                    // Plan 2
                    array(
                        'type'        => 'textfield',
                        "heading"     => __( "Icon Pricing", 'alaska' ),
                        "class"       => "",
                        "param_name"  => "icon_prcing_2",
                        'value'       => '',
                        'group'       => __( 'Plan Two', 'alaska' ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title pricing plan one", 'alaska' ),
                        "param_name"  => "title_pricing_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color border plan 2", 'alaska' ),
                        "param_name"  => "color_border_2",
                        "value"       => '', //Default color
                        'dependency'  => array(
                            'element' => 'choose_border',
                            'value'   => array( 'yes' ),
                        ),
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Select color for plan 2", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price", 'alaska' ),
                        "param_name"  => "price_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "pence", 'alaska' ),
                        "param_name"  => "pence_pricing_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit", 'alaska' ),
                        "param_name"  => "unit_pricing_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "VAT prompt", 'alaska' ),
                        "param_name"  => "vatprompt_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Description plan one", 'alaska' ),
                        "param_name"  => "des_plan_one_2",
                        "value"       => "",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Input description values here", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "button_pricing_2",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Enter text button for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "class"       => "",
                        "heading"     => __( "Link button", 'alaska' ),
                        "param_name"  => "link_pricing_2",
                        "value"       => "",
                        'group'       => __( 'Plan Two', 'alaska' ),
                        "description" => __( "Input link pricing one values here", 'alaska' ),
                    ),
                    // Plan 3
                    array(
                        'type'        => 'textfield',
                        "heading"     => __( "Icon Pricing", 'alaska' ),
                        "class"       => "",
                        "param_name"  => "icon_prcing_3",
                        'value'       => '',
                        'group'       => __( 'Plan Three', 'alaska' ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title pricing plan one", 'alaska' ),
                        "param_name"  => "title_pricing_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color border plan 3", 'alaska' ),
                        "param_name"  => "color_border_3",
                        "value"       => '', //Default color
                        'dependency'  => array(
                            'element' => 'choose_border',
                            'value'   => array( 'yes' ),
                        ),
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Select color for plan 3", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price", 'alaska' ),
                        "param_name"  => "price_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "pence", 'alaska' ),
                        "param_name"  => "pence_pricing_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit", 'alaska' ),
                        "param_name"  => "unit_pricing_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "VAT prompt", 'alaska' ),
                        "param_name"  => "vatprompt_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Description plan one", 'alaska' ),
                        "param_name"  => "des_plan_one_3",
                        "value"       => "",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Input description values here", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "button_pricing_3",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Enter text button for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "class"       => "",
                        "heading"     => __( "Link button", 'alaska' ),
                        "param_name"  => "link_pricing_3",
                        "value"       => "",
                        'group'       => __( 'Plan Three', 'alaska' ),
                        "description" => __( "Input link pricing one values here", 'alaska' ),
                    ),
                    // Plan 4
                    array(
                        'type'        => 'textfield',
                        "heading"     => __( "Icon Pricing", 'alaska' ),
                        "class"       => "",
                        "param_name"  => "icon_prcing_4",
                        'value'       => '',
                        'group'       => __( 'Plan Four', 'alaska' ),
                        'description' => __( 'Enter font icon awesome .eg: fa-facebook... . <a href="http://fortawesome.github.io/Font-Awesome/icons/">click here.</a>', 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Title pricing plan one", 'alaska' ),
                        "param_name"  => "title_pricing_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Color border plan 4", 'alaska' ),
                        "param_name"  => "color_border_4",
                        "value"       => '', //Default color
                        'dependency'  => array(
                            'element' => 'choose_border',
                            'value'   => array( 'yes' ),
                        ),
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Select color for plan 4", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Price", 'alaska' ),
                        "param_name"  => "price_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "pence", 'alaska' ),
                        "param_name"  => "pence_pricing_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Unit", 'alaska' ),
                        "param_name"  => "unit_pricing_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "VAT prompt", 'alaska' ),
                        "param_name"  => "vatprompt_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter Value for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "class"       => "",
                        "admin_label" => true,
                        "heading"     => __( "Description plan one", 'alaska' ),
                        "param_name"  => "des_plan_one_4",
                        "value"       => "",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Input description values here", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button", 'alaska' ),
                        "param_name"  => "button_pricing_4",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Enter text button for element", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "class"       => "",
                        "heading"     => __( "Link button", 'alaska' ),
                        "param_name"  => "link_pricing_4",
                        "value"       => "",
                        'group'       => __( 'Plan Four', 'alaska' ),
                        "description" => __( "Input link pricing one values here", 'alaska' ),
                    ),
                ),
            )
        );
        //******************************************************************************************************/
// Search Domain
//******************************************************************************************************/
        vc_map(
            array(
                "name"     => __( "Search Domain Dropdown", 'alaska' ),
                "base"     => "ts_search_domain_2",
                "class"    => "",
                "category" => __( 'ALASKA Blocks', 'alaska' ),
                "params"   => array(

                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Search Domain - Text Placehoder ", 'alaska' ),
                        "param_name"  => "text_placeholder",
                        "value"       => __( "Enter your Domain Name here...", 'alaska' ),
                        "description" => __( "Search Domain - Text Placehoder ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textarea",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Select Option Search ", 'alaska' ),
                        "param_name"  => "select_option_search",
                        "value"       => "",
                        "description" => __( "Select Option Search eg:.com,.co,.net,.org ", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Text button Search", 'alaska' ),
                        "param_name"  => "search_text_button",
                        "value"       => __( "Search", 'alaska' ),
                        "description" => __( " Text button Search", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Link Action Search", 'alaska' ),
                        "param_name"  => "search_link_button",
                        "description" => __( "Link actice button search", 'alaska' ),
                        'std'         => __( "http://alaska.themestudio.net/whmcs-bridge-2/?ccce=domainchecker", 'alaska' ),
                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Title price list", 'alaska' ),
                        "param_name" => "title_price_list",
                        "value"      => __( "View Domain Price List", 'alaska' ),
                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Link price list", 'alaska' ),
                        "param_name" => "link_price_list",
                        "std"        => __( "http://alaska.themestudio.net/whmcs-bridge-2/?ccce=domainchecker", 'alaska' ),
                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Title Bulk search", 'alaska' ),
                        "param_name" => "title_bulk_search",
                        "value"      => __( "Bulk Domain Search", 'alaska' ),
                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Link Bulk Search", 'alaska' ),
                        "param_name" => "link_bulk_search",
                        'std'        => __( "http://alaska.themestudio.net/whmcs-bridge-2/?ccce=domainchecker&amp;search=bulkregister", 'alaska' ),
                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Title Transfer", 'alaska' ),
                        "param_name" => "title_transfer",
                        "value"      => __( "Transfer Domain", 'alaska' ),

                    ),
                    array(
                        "type"       => "textfield",
                        "holder"     => "div",
                        "class"      => "",
                        "heading"    => __( "Link Transfer", 'alaska' ),
                        "param_name" => "link_transfer",
                        'std'        => __( "http://alaska.themestudio.net/whmcs-bridge-2/?ccce=domainchecker&amp;search=bulktransfer", 'alaska' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "holder"      => "div",
                        "class"       => "",
                        "heading"     => __( "Class name", 'alaska' ),
                        "param_name"  => "el_class",
                        "value"       => "",
                        "description" => __( "Add class name for element", 'alaska' ),
                    ),
                ),
            )
        );

    }
}
?>