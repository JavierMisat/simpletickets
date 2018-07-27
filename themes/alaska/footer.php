<?php
    /**
    * footer.php
    * Footer
    * @author Vulinhpc
    * @package ALASKA
    * @since 1.0.0
    */
    global $ts_alaska;
    $show_footer = isset($ts_alaska['show-hide-footer']) ? $ts_alaska['show-hide-footer'] : 'hide_footer';
    $show_info = isset($ts_alaska['ts-switch-info-bar']) ? $ts_alaska['ts-switch-info-bar'] : false;
    $copy_info = isset($ts_alaska['footer_copyright_text']) ? $ts_alaska['footer_copyright_text'] : esc_html__('© 2014 Alaska Hosting. All rights reserved.','alaska');
    $menu_footer = isset($ts_alaska['ts-footer-menu']) ? $ts_alaska['ts-footer-menu'] : '';
?>
    <section class="ts-section-top-footer">    
        <?php 
        
        if($show_footer == 'show_footer')
        {?>
            <div class="ts-top-footer">
                <div class="container">
                    <div class="row">
                        <?php foreach ($ts_alaska['footer_calltoaction_footer'] as $value): ?>
                         <div class="col-lg-4 col-md-4 col-sm-4 ts-contact-email-info contact-info">
                            <span><i class="fa <?php echo esc_attr( $value['description'] ); ?>"></i></span>
                            <a href="<?php echo esc_attr( $value['url'] ); ?>"><?php echo esc_attr($value['title']); ?></a>
                        </div>
                        <?php endforeach ?>                                                                 
                    </div>                            
                </div>
            </div>
        <?php }?>                                    
    </section>
    <?php get_template_part('content-parts/footer','widgets' ); ?>
    <section class="ts-copy-right">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                     <p><?php echo do_shortcode( $copy_info ); ?></p>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="ts-menu-footer">
                        <nav>
                             <?php echo do_shortcode( $menu_footer );  ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if($show_info==1){ ?>
    <div class="clr toggle-bar-fade hidden-xs" id="toggle-bar-wrap">
        <div class="clr container" id="toggle-bar">
            <div class="container">
                <div class="vc_row wpb_row vc_row-fluid  ">
                    <div class="vc_col-sm-6 wpb_column clr column_container  ">                    
                    <div class="wpb_text_column wpb_content_element ">
                        <div class="wpb_wrapper">
                            <h4><?php echo esc_attr($ts_alaska['info_title']) ?></h4>
                            <p><?php echo do_shortcode( $ts_alaska['info_bar_description'] ); ?></p>
                        </div> 
                    </div> 
                    <div class="vcex-spacing"></div>
                    <div class="wpb_text_column wpb_content_element ">
                        <div class="wpb_wrapper">
                            <h4><?php echo esc_attr($ts_alaska['info_title_touch']) ?></h4>
                        </div> 
                    </div>
                    <?php if($ts_alaska['info_address']!=''){  ?>                              
                        <div class="vcex-list_item textleft">
                            <span class="fa fa-map-marker"></span><?php echo esc_attr($ts_alaska['info_address']) ?> 
                        </div><!-- .vcex-list_item -->
                    <?php } 
                    if($ts_alaska['info_email']!=''){
                    ?>                         
                        <div class="vcex-list_item textleft">
                            <span class="fa fa-envelope-o"></span><?php echo esc_attr($ts_alaska['info_email']) ?>               
                        </div><!-- .vcex-list_item -->
                    <?php } 
                    if($ts_alaska['info_phone']!=''){
                    ?>    
                        <div class="vcex-list_item textleft">
                            <span class="fa fa-phone"></span><?php echo esc_attr($ts_alaska['info_phone']) ?>                  
                        </div><!-- .vcex-list_item -->   
                    <?php }
                    if($ts_alaska['info_fax']){
                    ?>    
                        <div class="vcex-list_item textleft">
                            <span class="fa fa-fax"></span><?php echo esc_attr($ts_alaska['info_fax']) ?>                  
                        </div><!-- .vcex-list_item -->   
                    <?php } ?>                       
                    </div> 
                    <div class="vc_col-sm-6 wpb_column clr column_container  ">
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <h4><span style="font-size: 18px;"><?php echo esc_attr($ts_alaska['info_title_map']) ?></span></h4>
                            </div> 
                        </div>                                             
                        <div class="wpb_single_image wpb_content_element clr vc_align_none">
                            <div class="wpb_wrapper">                            
                                <img width="468" height="263" alt="togglebar-map" class=" vc_box_border_grey attachment-full" src="<?php echo esc_url($ts_alaska['info_map']['url']) ?>">
                            </div><!-- .wpb_wrapper -->
                        </div><!-- .wpb_single_image -->
                    </div> 
                </div>
            </div><!-- .entry -->
        </div><!-- #toggle-bar -->
    </div>    
    <?php   } ?>    
    <!-- End / Page wrap -->
    </div>
    <a class="backtotop" href="#">
        <span class="fa fa-angle-double-up"></span><?php echo esc_html__('Click Me', 'alaska') ?></a>
    <!-- End / Page wrap -->
    <?php wp_footer(); ?>
</body>
</html>