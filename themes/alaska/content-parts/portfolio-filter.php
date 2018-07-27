<?php 
    global $ts_alaska;
 ?>
<div id="filters-portfolio" class="cbp-l-filters-alignLeft">
    <div class="container">
    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">
        <?php echo esc_html__('All', 'alaska') ?>
    </div>
    <?php
        $portfolio_terms = array();
         $portfolio_terms  =  get_terms("portfolio_cats"); 
            foreach( $portfolio_terms as $portfolio_cat ){
                echo '<div class="cbp-filter-item" data-filter=".'. $portfolio_cat->slug .'">'. $portfolio_cat->name .'</div>';
            }

    ?>
    </div>
</div>