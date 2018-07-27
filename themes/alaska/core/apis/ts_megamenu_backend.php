<?php

if ( !function_exists( 'themestudio_add_custom_nav_fields' ) ) {
    function themestudio_add_custom_nav_fields( $menu_item ) {
        $menu_item->menutype = get_post_meta( $menu_item->ID, '_menu_item_menutype', true );
        $menu_item->iconclass = get_post_meta( $menu_item->ID, '_menu_item_iconclass', true );
        return $menu_item;
    }
    /* add custom menu fields to menu */
    add_filter( 'wp_setup_nav_menu_item', 'themestudio_add_custom_nav_fields' );
}

if ( !function_exists( 'themestudio_menu_fields_update' ) ) {
    function themestudio_menu_fields_update( $menu_id, $menu_item_id, $args ) {

        if ( isset($_REQUEST['menu-item-menutype']) && is_array( $_REQUEST['menu-item-menutype']) ) {
            $menutypeclass_value = $_REQUEST['menu-item-menutype'][$menu_item_id];
            update_post_meta( $menu_item_id, '_menu_item_menutype', $menutypeclass_value );
        }
        if ( isset($_REQUEST['menu-item-iconclass']) && is_array( $_REQUEST['menu-item-iconclass']) ) {
            $iconclassclass_value = $_REQUEST['menu-item-iconclass'][$menu_item_id];
            update_post_meta( $menu_item_id, '_menu_item_iconclass', $iconclassclass_value );
        }
    }
    /* save menu custom fields */
    add_action( 'wp_update_nav_menu_item', 'themestudio_menu_fields_update' , 10 , 3 );
}

if ( !function_exists( 'ts_edit_walker' ) ) {
    function ts_edit_walker( $walker , $menu_id ) {
        return 'Walker_Nav_Menu_Edit_Custom';
    }
    /* edit menu walker */
    add_filter( 'wp_edit_nav_menu_walker', 'ts_edit_walker' , 10 , 2 );
}

class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
    /**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	}
	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	}
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array() , $current_object_id = 0 ) {
        global $_wp_nav_menu_max_depth;
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	   //     'action',
	   //     'customlink-tab',
	   //     'edit-menu-item',
	    //    'menu-item',
	   //     'page-tab',
	    //    '_wpnonce',
	    );
	    $original_title = '';

	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );

	        if ( is_wp_error( $original_title ) )
	            $original_title = false;

	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }
	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );
	    $title = $item->title;

	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( __( '%s (Invalid)' , 'alaska' ), $item->title );

	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( __('%s (Pending)' , 'alaska' ), $item->title );
	    }
	    $title = empty( $item->label ) ? $title : $item->label;
	    ?>
	    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <dl class="menu-item-bar">
	            <dt class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                esc_url(add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
	                                )),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up' , 'alaska'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                esc_url(add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
	                                )),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down' , 'alaska'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item' , 'alaska' ); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url( add_query_arg( 'edit-menu-item', $item_id, esc_url( remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) ) );
	                    ?>"><?php _e( 'Edit Menu Item' , 'alaska' ); ?></a>
	                </span>
	            </dt>
	        </dl>
	        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
	                        <?php _e( 'URL' , 'alaska' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Navigation Label' , 'alaska' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Title Attribute' , 'alaska' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
	            <p class="field-link-target description">
	                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php _e( 'Open link in a new window/tab' , 'alaska' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
	                    <?php _e( 'CSS Classes (optional)' , 'alaska' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-css-iconclass description description-thin">
	                <label for="edit-menu-item-iconclass-<?php echo $item_id; ?>">
	                    <?php _e( 'Input Font Awesome class <a href="http://fortawesome.github.io/Font-Awesome/icons/">here</a>' , 'alaska' ); ?><br />
	                    <input type="text" id="edit-menu-item-iconclass-<?php echo $item_id; ?>" class="widefat code edit-menu-item-iconclass" name="menu-item-iconclass[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->iconclass ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
	                    <?php _e( 'Link Relationship (XFN)' , 'alaska' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
	                    <?php _e( 'Description' , 'alaska' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.' , 'alaska' ); ?></span>
	                </label>
	            </p>
                <p class="field-custom description description-thin themestudio-edit-menu-type">
	                <label for="edit-menu-item-menutype-<?php echo $item_id; ?>">
						<?php _e( 'Menu Type' , 'alaska' ); ?><br />
                        <select class="widefat" id="edit-menu-item-menutype-<?php echo $item_id; ?>" name="menu-item-menutype[<?php echo $item_id; ?>]">
                            <option value="clasic_menu" <?php selected('clasic_menu' , esc_attr( $item->menutype ) , true); ?>><?php _e( 'Normal menu' , 'alaska'); ?></option>
                        	<option value="minicart" <?php selected('minicart' , esc_attr( $item->menutype ) , true); ?>><?php _e( 'Include mini cart' , 'alaska'); ?></option>
                        </select>
	                </label>
	            </p>
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( __('Original: %s' , 'alaska' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
	                echo wp_nonce_url(
	                    esc_url(add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
	                    )),
	                    'delete-menu_item_' . $item_id
	                ); ?>"><?php _e('Remove' , 'alaska'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel' , 'alaska' ); ?></a>
	            </div>
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php
	    $output .= ob_get_clean();
	    }
	}